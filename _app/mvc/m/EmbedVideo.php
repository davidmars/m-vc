<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EmbedVideo
 *
 * @author juliette david
 */
class EmbedVideo {
    
    /**
     *
     * @var Page 
     */
    public $page;
    
    public function __construct() {
        $this->page=new Page("embed-video/(.*)","embed/view/$1");
    }
}

?>
