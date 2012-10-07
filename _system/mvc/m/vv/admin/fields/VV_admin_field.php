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
     * @var bool True if the field is updatable 
     */
    public $editable=false;
    
    /**
     *
     * @var string Label of the field like it is displayed 
     */
    public $label;
    /**
     *
     * @var string A small text displayed after the label 
     */
    public $subLabel;
    /**
     *
     * @var string Path to a specific template for displaying this field. If empty the template will be found by Field Type. 
     */
    public $template;
    
    /**
     *
     * @var int The number of span for displaying the field 
     */
    public $span=4;

    /**
     * @param M_ $model
     * @param string $fieldName 
     */
    public function init($model,$fieldName){
        
        //Prepare variables
        
        $this->field=$model->field($fieldName);
        $this->name=$fieldName;
        $this->type=  get_class($this->field);
        $this->editable=$this->field->editableByHuman;
        $this->value=$model->$fieldName;
        
        
        //Now, let's have a look to the config
        
        $conf=$model->getAdminConfig();
        $conf=$conf["default"]["fields"][$this->name];
        
        //label
        $this->label=$conf["label"];
        if(!$this->label){
            $this->label=$this->name." (".$this->type.")";
        }
        //template
        $this->template=$conf["template"];
        if(!$this->template){
            $this->template=false;
        }
        //help
        $this->comments=$conf["help"];
        if(!$this->comments){
            $this->comments=$this->field->comments;
        }
        //span
        if($conf["span"]){
            $this->span=$conf["span"];
        }
        
        
        
        
        
	
        
        
        
        
    }
    
}
