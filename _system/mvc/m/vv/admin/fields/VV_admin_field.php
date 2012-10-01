<?php

/**
 * Description of VV_field
 *
 * @author David Marsalone
 */
class VV_admin_field extends ViewVariables{
    /**
     *
     * @var string name of the field. 
     */
    public $name;
    /**
     *
     * @var * The value of the field. 
     */
    public $value;
    /**
     *
     * @var string The field type. 
     */
    public $type;
    
    /**
     *
     * @var Field the field itsef 
     */
    public $field;
    /**
     *
     * @param Field $field 
     */
    public function init($model,$field){
        $this->type=  get_class($field);
        $this->name=$fieldName=$field->name;
        $this->field=$field;
        
        $this->value=$model->$fieldName;
    }
    
}
