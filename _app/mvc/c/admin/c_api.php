<?
class C_api extends Controller{

    public function index($modelType){
	
	$modelType=$_REQUEST["type"];
	$modelId=$_REQUEST["id"];
	
	if($modelId && $modelType){
	    $manager = Manager::getManager($modelType);
	    $m=$manager->get($modelId);
	}else if(isset ($modelType) && class_exists($modelType) && in_array ("Model", class_parents($modelType))){
	    $m=new $modelType();
	}
	if($m){
	    foreach($_REQUEST["root"] as $var=>$value){
		if(self::isRecordableField($var)){
		$m->$var=$value;
		}
	    }
	    $m->save();
	}
	
	$vv=new VV_admin_model();
	$vv->init($m);
	
	
	

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
}
