<?php

class ImageField extends FileField {
    
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
     * Check if the file exists
     * @return bool true if the file exists. 
     */
    public function exists(){
        return file_exists($this->value);
    }
    
    public function sized($width, $height, $backgroundColor, $format){
	return GiveMe::imageSized($this->value,$width, $height, $backgroundColor, $format);
    }
    
    public function sizedWithoutCrop($width, $height, $backgroundColor, $format){
	return GiveMe::imageSizedWithoutCrop($this->value,$width, $height, $backgroundColor, $format);
    }
       
}

?>
