<?
/**
 * The Api controller allows the user to manage datas
 */
class C_api extends Controller{
    /**
     * try to login the user using $_REQUEST["email"] and $_REQUEST["password"]
     * In all cases, die the action with a VV_apiReturn.
     */
    public static function login(){

        $log=M_user::login($_REQUEST["email"],$_REQUEST["password"]);
        //return in all cases will be here
        $json=new VV_apiReturn();
        if($log){
            $json->success=true;
            $json->messages[]="Welcome ".M_user::currentUser()->humanName();
        }else{
            $json->success=false;
            $json->errors[]="Sorry but the email and password don't match";
        }
        $json->messages[]=json_encode($_SESSION);
        die($json->json());
    }
    /**
     * Logout the user
     * In all cases, die the action with a VV_apiReturn.
     */
    public static function logout(){

        $log=M_user::logout();
        $json=new VV_apiReturn();
        $json->messages[]=json_encode($_SESSION);
        die($json->json());
    }

    /**
     * Record the model. Data are passed via $_REQUEST[root] object.
     * @param $modelType
     */
    public static function record($modelType){

        $modelType=$_REQUEST["type"];
        $modelId=$_REQUEST["id"];
        $templatePath=$_REQUEST["template"];
        //return in all cases will be here
        $json=new VV_apiReturn();

        if($modelId && $modelType){
            $manager = Manager::getManager($modelType);
            $m=$manager->get($modelId);
        }else if(isset ($modelType) && class_exists($modelType) && in_array ("Model", class_parents($modelType))){
            $m=new $modelType();
        }

        if($m){
            //loop on fields
            foreach($_REQUEST["root"] as $var=>$value){
                if(self::isRecordableField($var)){

                    if(is_array($value)){
                        //assoc field
                        Human::log("$var is an assoc");
                        self::performAssociation($m,$var,$value);
                    }else{
                        //simple field
                        $m->$var=$value;
                    }
                }
            }
            $json->success=true;
            $m->save();
        }

        //the template we will send via json
        $VVmodel=new VV_admin_model();
        $VVmodel->init($m);
        $template=new View($templatePath, $VVmodel);
        //the json
        $json->template=$template->render();
        die($json->json());

    }

    /**
     * Create a new model and associate it to an existing model via an association
     * @param $newModelType string
     * @param $containerModelType string
     * @param $containerModelId string
     * @param $containerFieldName string
     */
    public static function addNewChild($newModelType,$containerModelType,$containerModelId,$containerFieldName){

        $json=new VV_apiReturn();

        //the model container
        $container=self::getModel($containerModelType,$containerModelId);
        if(!$container){
            $json->success=false;
            $json->errors[]="The container model cannot be found";
            die($json->json());
        }

        //the new model
        /** @var $newModel M_ */
        $rc=new ReflectionClass($newModelType);
        if($rc->hasMethod("getNew") && $rc->getMethod("getNew")->isStatic()){
            $newModel=call_user_func_array(array($newModelType,"getNew"),array());
        }else{
            $newModel=new $newModelType();
            $newModel->save();
        }


        //performs the association
        $container->{$containerFieldName}->link($newModel);
        $container->{$containerFieldName}->ordre="0";
        $container->{$containerFieldName}->insert();

        $json->success=true;
        $json->messages[]="New model created ".$newModel->humanName();
        die($json->json());

    }


    /**
     * Display a template according to the $_REQUEST[template] param and the models params.
     * @param $modelType string
     * @param $modelId string
     * @return C_api
     */
    public static function modelTemplate($modelType,$modelId){
        $template=$_REQUEST["template"];
        $model=self::getModel($modelType,$modelId);
        $c=new C_api();
        $c->resultView=new View($template,$model);
        return $c;
    }

    /**
     * Will empty the links for $model->$varName et will re-attribute the given models.
     * @param $model Model the target model where to link the others models
     * @param $varName NtoNAssoc The name of the field association
     * @param $modelsArray Array[modelType,ModelId] The models array representation
     */
    private static function performAssociation($model,$varName,$modelsArray){

        $model->{$varName}->unlinkAll();
        $orderIds=array();
        foreach($modelsArray as $toLink){
            Human::log("model link ".$toLink["modelId"]);
            $m=self::getModel($toLink["modelType"],$toLink["modelId"]);

            if($m){
                $orderIds[]=$m->id;
                $model->{$varName}->link($m);
            }
        }

        Human::log($orderIds,"the order");
        $model->{$varName}->insert();
        $model->{$varName}->reorder( $orderIds );
    }

    /**
     * @param $modelType string a model name
     * @param $modelId id of the model to find or "new" to get a new one that will be created.
     * @return M_|null The found model, or a created one, on new
     */
    private static function getModel($modelType,$modelId){
        $manager=Manager::getManager($modelType);
        if(!$manager){
            return null;
        }
        if($modelId=="new"){
            $m=new $modelType();
            $m->save();
        }else{
            $m=$manager->get($modelId);
        }
        return $m;
    }

    /**
     * This controller copy  $_FILES['TheFile'] in the media folder and echo directly the new file location
     */
    public static function upload(){

        $json=new VV_apiReturn();

        $modelType=$_REQUEST["modelType"];
        $fieldName=$_REQUEST["fieldName"];
        $fieldName=  preg_replace('#root\[(.*)\]#',"$1",$fieldName);
        $templatePath=$_REQUEST["template"];

        $newFile=FileTools::saveUploadAsMedia($_FILES['TheFile']);

        $json->messages[]=$modelType;
        $json->messages[]=$fieldName;
        $json->messages[]=$templatePath;
        $json->messages[]=$newFile;

        $json->success=true;
        //the template we will send via json
        $vv=new VV_admin_field();
        //create an empty model just to get the good field settings
        $m=new $modelType();
        $m->$fieldName=$newFile;

        $vv->init($m, $fieldName);
        $template=new View($templatePath,$vv);
        $json->template=$template->render();
        die($json->json());
        //die("file received:".$_FILES['TheFile']["tmp_name"]."/".$_FILES['TheFile']['size']." saved into ".$newFile);
    }
    /**
     * Some fields (like id, creation date etc...) should not be updated via the api but the framework itself...this method will tell you
     * @param string $fieldName
     * @return bool true if the field can be updated.
     */
    private static function isRecordableField($fieldName){
        switch ($fieldName){
            case "id":
            case "created":
            case "modified":
                return false;
            default:
                return true;
        }
    }

    /*
    private function apiReturn(){
        $obj=array();
        $obj["success"]=$this->success;
        $obj["redirect"]=$this->redirect;
        $obj["messages"]=$this->messages;
        $obj["errors"]=$this->errors;
        $obj["template"]=$this->template;
    }
     
     */



}

class VV_apiReturn extends ViewVariables{
    public  $success=false;
    public  $redirect=false;
    public  $messages=array();
    public  $errors=array();
    public  $template="";
}
