<?php

/**
 * Represents a model. The goal when you will use this VV will be probably to display an admin form.
 *
 * @author David Marsalone
 */
class VV_admin_model extends ViewVariables{
    /**
     *
     * @var M_ The model itself
     */
    public $model;
    /**
     *
     * @var string The model type 
     */
    public $modelType;
    /**
     *
     * @var array List of database associated fields to the model. 
     */
    public $fields;
    /**
     *
     * @param M_ $model The model to work with... 
     */
    public function init($model) {
        $this->modelType=get_class($model);
        $this->model=$model;
        $this->fields=$this->getFields();
    }



    /**
     * 
     */
    public function getFields(){
        $ret=array();
        
        $class = new ReflectionClass(get_class($this->model));
        
        //$fieldsNames=$class->getStaticPropertyValue("dbFields");
        /* @var $f Field */
        foreach(Field::getFields($this->model) as $f){
            $field=new VV_admin_field();
            $field->init($this->model,$f);
            $ret[]=$field;
        }
        return $ret;
    }
    
    
}
