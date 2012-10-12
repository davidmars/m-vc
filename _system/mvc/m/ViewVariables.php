<?php

class ViewVariables{
    /**
     * This class itself has no interest, it will be always extended. The concept of this class is to get autocompletion in the views.
     * @param ViewVariables $_vars If defined if will work like a clone. 
     * 
     */
    public function __construct($_vars=null) {
	if($_vars){
	    $this->feedMe($_vars);
	}
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
     * Lets give you informations about the fact to put it in a layout or not.
     * @var Boolean 
     */
    public $isAjax=false;

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