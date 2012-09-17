<?php
/**
 * Description of LayoutVariables
 *
 * @author david marsalone
 */
class LayoutVariables extends ViewVariables{
    
    /**
     * 
     * @var VV_html_header The header variables
     */
    public $htmlHeader;
    
    /**
     *
     * @var Array pages hierarchy 
     */
    public $breadcrumb=array();
    
    
    public function __construct($params = null) {
        parent::__construct($params);
        $this->htmlHeader=new VV_html_header();
    }
    
    
}

?>
