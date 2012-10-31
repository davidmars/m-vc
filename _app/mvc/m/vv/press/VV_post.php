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
     * @var M_category_post
     */
    public $parentCategory;
    /**
     * @var VV_block[] contain all the post content
     */
    public $blocks=array();
    
    /**
     *
     * @param M_post $post 
     */
    public function init($post,$category=null) {
        $this->post = $post;
        $this->parentCategory=$category;

        Human::Log($this->post->title, "POST CONTENT");

        foreach($this->post->blocks as $b){
            $bl=new VV_block();
            $bl->init($b);
            $this->blocks[]=$bl;
        }

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
