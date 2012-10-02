<?php

/**
 * This class represents a field in a model, it is usefull to display stuff like checkboxes, list, textfields etc...
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
     * @var Field The field model itsef 
     */
    public $field;
    
    /**
     *
     * @var string The description comments found in the php code.
     */
    public $comments;
    /**
     *
     * @param Field $field 
     */
    public function init($model,$field){
        $this->type=  get_class($field);
        $this->name=$fieldName=$field->name;
        $this->field=$field;
	$this->comments=$field->options["comments"]."...";
        
        $this->value=$model->$fieldName;
    }
    
}
