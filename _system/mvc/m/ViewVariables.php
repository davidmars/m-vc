<?php

class ViewVariables{
    /**
     *
     * @param ViewVariables $params 
     * This class itself has no interest, it will be always extended. The concept of this class is to get autocompletion and stict mode in the views.
     */
    public function __construct($_vars=null) {
	if($_vars){
	    $this->feedMe($_vars);
	}
        $this->modelType=get_class($this);
    }
    
    public function json(){
        return json_encode($this);
    }
    public function xml(){
        return StuffToXml::getCompleteXml($this);
    }
    
    /**
     * A place to put messy variables... very, very bad practice.
     * If you are writting templates and a php developer use this, tell it to your boss...the developer sould be fired.
     * @var array A place where to put messy variables
     */
    public $anarchy=array();

    /**
     *
     * @var String The class name of the current object. 
     */
    public $modelType;


    /**
     *
     * @var String prevent this stupid $this->$kkkk autocompletion
     */
    private $kkkk;
    
    private function feedMe($params){
	
	foreach($params as $kkkk=>$v){
	    $this->$kkkk=$v;
	}

    }

    


    
}