<?php

class FileField extends Field {
    
    public function __construct( $path, $options = array() ) {
	    parent::__construct( $path , $options );
    }
    /**
     * Return the filed object itself
     * @return FileField 
     */
    public function get(){
        return $this;
    }
    
    /**
     * Return the mime type of the file
     * @return string The mime type of the file 
     */
    public function mime(){
        
        //return "mime=".$this->insideValue;
        if($this->exists()){
           return FileTools::mime($this->value);
        }else{
            return "-";
        }
    }
    /**
     * Return the file size of the file in a readable format (mo, ko etc...)
     * @return string the file size of the file in a readable format (mo, ko etc...)
     */
    public function fileSize(){
        if($this->exists()){
           return FileTools::size($this->value, true); 
        }else{
            return "-";
        }
        
        //return "mime=".$this->insideValue;
    }

    /**
     * Check if the file exists
     * @return bool true if the file exists. 
     */
    public function exists(){
        return file_exists($this->value);
    }
    
    
    

}

?>
