<?
class C_api extends Controller{

    public function index($modelType){
	
	M_::initModel("M_post");
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
