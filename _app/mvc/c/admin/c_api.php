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
        //print_r($_FILES);
        $sFileName = $_FILES['TheFile']['name'];
        $sFileType = $_FILES['TheFile']['type'];
        $newFile=FileTools::saveUploadAsMedia($_FILES['TheFile']);
        die($newFile);
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
