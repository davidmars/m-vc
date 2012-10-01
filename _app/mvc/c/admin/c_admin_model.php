<?php

/**
 * Description of c_admin_model
 *
 * @author David Marsalone
 */
class c_admin_model extends Controller{
    /**
     * Will display a list of models of the given type.
     * @param string $modelType the model 
     */
    public function listModels($modelType){
        POV_CssAndJs::applyAdminSettings();
        //unexisting model
        if(!class_exists($modelType)){
            $this->setHeader404();
            return null;
        }
        //get the model class
        $vv=new VV_admin_model_list();
        $vv->init($modelType);
        return new View("admin/model-list", $vv);
    }
    
    
}
