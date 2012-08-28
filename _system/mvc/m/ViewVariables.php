<?php

class ViewVariables{
    /**
     *
     * @param ViewVariables $params 
     * This class itself has no interest, it will be always extended. The concept of this class is to get autocompletion and stict mode in the views.
     */
    public function __construct($params=null) {
	if($params){
	    $this->feedMe($params);
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