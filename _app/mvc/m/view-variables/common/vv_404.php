<?php

/**
 * Common variables in  html document header section
 *
 * @author david marsalone
 */
class VV_404 extends ViewVariables{
    
    /**
     * 
     * @var type 
     */
    public $title="Ooops! ";
    
    public $message="The page cannot be found...";
    
    public function __construct($params = null) {
        parent::__construct($params);
        $this->header=new Nerd_Header(Nerd_Header::ERR_404);
    }

}

?>
