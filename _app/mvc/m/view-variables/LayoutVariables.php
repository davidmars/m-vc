<?php
/**
 * Description of LayoutVariables
 *
 * @author david marsalone
 */
class LayoutVariables extends ViewVariables{
    
    /**
     * 
     * @var HtmlHeaderVariables The header variables
     */
    public $htmlHeader;
    
    /**
     *
     * @var Array pages hierarchy 
     */
    public $breadcrumb=array();
    
    
    public function __construct($params = null) {
        parent::__construct($params);
        $this->htmlHeader=new HtmlHeaderVariables();
    }
    
    
}

?>
