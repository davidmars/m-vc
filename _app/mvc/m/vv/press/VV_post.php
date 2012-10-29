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

        Human::Log($this->post->title, "POST CONTENT");
       // $this->currentCategoryId = $post->category->getCategoryId();
    }

    /**
     * This function is an easy way to get an admin field for the post->thumb field.
     * @return VV_admin_field
     */
    public function thumbAdminField(){
        $editableField=new VV_admin_field();
        $editableField->init($this->post,"thumb");
        return $editableField;
    }


    public function getCategory(){
        return "toto";
    }
}

?>
