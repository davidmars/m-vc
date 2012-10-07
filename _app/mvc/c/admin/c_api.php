<?
class C_api extends Controller{

     public function record($modelType){
	
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
		$m->$var=$value;
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
     * This controller copy  $_FILES['TheFile'] in the media folder and echo directly the new file location
     */
    public function upload(){
        
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
     * Some fields should not be updated via thze api but the framework itself...this method will tell you
     * @param string $fieldName
     * @return bool true if the field can be updated.  
     */
    public static function isRecordableField($fieldName){
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
