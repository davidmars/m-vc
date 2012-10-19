<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of VV_post
 *
 * @author francoisrai
 */
class VV_post extends VV_layout {
    /**
     *
     * @var M_post 
     */
    public $post;
    
    /**
     *
     * @param M_post $post 
     */
    public function init($post) {
        $this->post = $post;        
        $this->currentCategoryId = $post->category->getCategoryId();
    }
}

?>
