<?php

class FileField extends Field {
    /**
     * 
     * @return string The mime type of the file 
     */
    public function mime(){
        return FileTools::mime($this->get());
    }
    /**
     * Check if the file exists
     * @return bool true if the file exists. 
     */
    public function exists(){
        return file_exists($this->get());
    }
	
}

?>
