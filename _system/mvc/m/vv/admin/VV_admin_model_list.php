<?php

/**
 * This model is used to display list of models in the admin.
 *
 * @author David Marsalone
 */
class VV_admin_model_list extends ViewVariables{
    /**
     *
     * @var string the name of the class of the listed models 
     */
    public $modelType;
    /**
     *
     * @var VV_admin_model List of models 
     */
    public $models=array();
    
    public $emptyModel;
    
    public function init($modelType) {
	$this->modelType=$modelType;
	$emptyModel=new $modelType();
        
	$this->emptyModel=new VV_admin_model();
        $this->emptyModel->init($emptyModel);
	
        $class=new ReflectionClass($modelType);
        //$manager=  Manager::getManager($modelType);        
        $manager=$class->getStaticPropertyValue("manager");
        $models=$manager->select()->all();
        foreach($models as $m){
            $vvm=new VV_admin_model();
            $vvm->init($m);
            $this->models[]=$vvm;
        } 
         
        
    }
}
