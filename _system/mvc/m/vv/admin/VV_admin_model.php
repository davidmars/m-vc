<?php

/**
 * Represents a model. The goal when you will use this class will be probably to display an admin form.
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
     * Returns the list of fields related to the model
     * @return VV_admin_field Returns the list of fields related to the model. 
     */
    public function getFields(){
        $ret=array();
        
        $rc = new ReflectionClass(get_class($this->model));
        
        
        $conf=$this->model->getAdminConfig();
        //the filed config we will use
        $conf=$conf["default"]["fields"];
        
        //$fieldsNames=$class->getStaticPropertyValue("dbFields");
        /* @var $f Field */
        foreach(Field::getFields($this->model) as $f){
            if(!$conf[$f->name]){
                $conf[$f->name]=array(
                    "visible"=>true,
                    "label"=>$f->name
                );
            }
        }
        
        //list adminconfig fields

        
        foreach($conf as $fieldName=>$fieldValue){
            if($conf[$fieldName]["visible"]){
                if(($conf[$fieldName]["visibleIfNew"]!==false) || $this->model->id){
                    $field=new VV_admin_field();
                    $field->init($this->model,$fieldName);
                    $ret[]=$field;
                }
            }
        }
        
        //list all fields
        

        return $ret;
    }
    
    

    
}
