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
     public $activate=true;
    
    /**
     * 
     * @var TextField The description of the post
     */
    public $description;
    
    /**
     *
     * @var EnumField Options for displaying the post.
     */
    //public $template="big";
    
    /**
     *
     * @var array The possibles values for the field $template 
     */
    //public $templateStates=array("small","medium","big");
    
    /**
     *
     * @var M_category_post The category where it will be possible to find the post.
     */
    //public $category;   
    
    /**
     *
     * @var ImageField Thumbnail representation of the post 
     */
    public $thumb;
    
    /**
     *
     * @var M_block[] the content of the post  
     */
    public $blocks;

    /**
     * Create a new M_post with default values, save it and return it.
     * @return M_post The new post.
     */
    public static function getNew(){
        $newPost=new M_post();
        $newPost->title="This is a new post";
        $newPost->description="This is the description of this new post";
        $newPost->thumb="pub/app/press/img/logo-havana-club.png";
        $newPost->save();
        return $newPost;
    }

    /**
     *
     * @return array The admin config object for M_download model
     */
    public function getAdminConfig() {
        $conf=parent::getAdminConfig();
        
        $conf["default"]["fields"]["title"]=array(
            "visible"=>true,
            "label"=>"Title"
        );
                
        
        $conf["default"]["fields"]["thumb"]=array(
            "visible"=>true,
            "label"=>"Thumbnail"
        );
        
        $conf["default"]["fields"]["description"]=array(
            "visible"=>true,
            "label"=>"Description"
        );      
        
        $conf["default"]["fields"]["activate"]=array(
            "visible"=>true,
            "label"=>"Activation"
        );
                   
        return $conf;
    }
}




