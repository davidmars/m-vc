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
     * @var array contain all the post content 
     */
    public $blocks;
    
    /**
     *
     * @param M_post $post 
     */
    public function init($post) {
        $this->post = $post;        
       // $this->currentCategoryId = $post->category->getCategoryId();
        
        $this->blocks = array();
        $this->blocks[] = $this->getExample("Photo", "2", 0, "16", "pub/app/press/img/media.png");
        $this->blocks[] = $this->getExample("Text", "6", 0, "8", "Ceci est un text de test <br/><b>Testttt</b>");
        $this->blocks[] = $this->getExample("Embed", "8", 0, "4", '<iframe width="640" height="395" src="http://www.youtube.com/embed/OsHGFNWVWcA?autoplay=0&amp;rel=0&amp;theme=light&amp;showinfo=0&amp;modestbranding=0&amp;autohide=0&amp;wmode=opaque" frameborder="0" allowfullscreen></iframe>');
    }
    
    public function getExample($modelType, $span, $offset, $id, $content) {
        $model = array();
        $model["modelType"] = $modelType;
        $model["id"] = $id;
        $model["span"] = $span;
        $model["offset"] = $offset;
        $model["content"] = $content;
        
        return $model;        
    }
    
        
    /**
     *
     * @return Array<M_download> Return all download of the current post
     */
    public function getAllDownload() {
        return M_download::$manager->select()->where("post", $this->post->id)->all();
    }
}

?>
