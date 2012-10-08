<?php

/**
 * This controller handle the admin models management.
 *
 * @author David Marsalone
 */
class C_admin_model extends Controller{
    /**
     * Will display a list of models of the given type.
     * @param string $modelType the model 
     */
    public function listModels($modelType){
        POV_CssAndJs::adminSettings();
        //unexisting model
        if(!class_exists($modelType)){
            $this->setHeader404();
            return null;
        }
        //get the model class
        $vv=new VV_admin_model_list();
        $vv->init($modelType);
        $this->resultView=new View("admin/model-list", $vv);
        return $this->resultView;
    }
    /**
     * Will display a form to create or update a model.
     * @param string $modelType The type of the target model
     * @param string $modelId The id of the target model, if null an emty form of the requested model will be returned. 
     */
    public function editModel($modelType,$modelId=null){
        POV_CssAndJs::adminSettings();
        //unexisting model
        if(!class_exists($modelType)){
            $this->setHeader404();
            return null;
        }
        if($modelId && $modelType){
	    $manager = Manager::getManager($modelType);
	    $m=$manager->get($modelId);
	}else if(isset ($modelType) && class_exists($modelType) && in_array ("Model", class_parents($modelType))){
	    $m=new $modelType();
	}
	if($m){
            $vv=new VV_admin_model();
            $vv->init($m);
            return new View("admin/model-form",$vv);
	}
        
    }
    /**
     * Will display a form to create or update a model.
     * @param string $modelType The type of the target model
     * @param string $modelId The id of the target model, if null an emty form of the requested model will be returned. 
     * @return Controller
     */
    public static function url_editModel($modelType,$modelId=null){
        $c=new C_admin_model();
        $view=$c->editModel($modelType, $modelId);
        $path="admin/admin_model/";
        //---- we need to find....
        //the url of the current controller by its classNme
        //the current function name
        //the vurrent function params
        $c->route=$path."editModel"."/".$modelType."/".$modelId;
        
        return $c;
    }
    
    
}
