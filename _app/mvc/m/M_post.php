<?php
/**
 * A post is a page wich can display various content.  
 */
class M_post extends M_{

    public static $manager;
    /**
     * 
     * @var TextField The name of the poste like it is displayed
     */
    public $title;
    /**
     *
     * @var BoolField If positive, the post will be displayed in variaous important places.
     */
    public $sticky=true;
    
    /**
     *
     * @var EnumField Options for displaying the post.
     */
    public $template="big";
    /**
     *
     * @var array The possibles values for the field $template 
     */
    public $templateStates=array("small","medium","big");
    
    /**
     *
     * @var M_category The category where it will be possible to find the post.
     */
    public $category;
    
    

           
    
}




