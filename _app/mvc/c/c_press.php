<?php

/**
 * Here 
 */
Class C_press extends Controller{
    
    /**
     * Display a page with many post from a category
     * @param int $category is the id of current category
     * @param int $pagination is the index number of the pagination
     */
    public static function categoryPost($category, $pagination = "",$returnUrl=false) {
	if($returnUrl){
	   $c = new C_press();
	   return $c->url(); 
	}
	
        // set the css and the js 
        self::setCssAndJs();
        
        // create a variable for our controller
        $c = new C_press();
        
        // get the current category post       
        $currentCategory = M_category_post::$manager->get($category);        
        // get the current page index
        $pagination = $pagination;
                                              
        // create the good view variable for our view 
        $vv = new VV_categoryPost();                
        $vv->init($currentCategory, $pagination);
                                                          
        // set the result view with the good template and give param
        $c->resultView = new View("press/categoryPost", $vv);

        // return the controller
        return $c;
    }
    
    /**
     *
     * @param int $post is the id of the post
     * @param bool $returnUrl If set to true, the controller will not be run and will return its url.
     */
    public static function post($post,$returnUrl=false) {  
	if($returnUrl){
	   $c = new C_press();
	   return $c->url(); 
	}
        self::setCssAndJs();
        
        $c = new C_press();
        $post = M_post::$manager->get($post);
        
        $vv = new VV_post();
        $vv->init($post);
                
        $c->resultView = new View("press/post", $vv);
        return $c;
    }
    
    /**
     *
     * @param int $category is the media category
     * @param int $pagination is the index number of the pagination
     */
    public static function categoryMedia($category, $pagination = "",$returnUrl=false) {  
	if($returnUrl){
	   $c = new C_press();
	   return $c->url(); 
	}
        // set the css and the js 
        self::setCssAndJs();
        $c = new C_press();
        
        // get the current category media
        $currentCategory = M_category_media::$manager->get($category);        
        // get the current page index
        $pagination = $pagination;
                                              
        // create the good view variable for our view 
        $vv = new VV_categoryMedia();                
        $vv->init($currentCategory, $pagination);
        
        $c->resultView = new View("press/categoryMedia", $vv);
        return $c;
    }
    
    /**
     *
     * @param int $subCat is the current subCatMedia id
     * @param int $pagination is the index number of the pagination
     */
    public static function subCatMedia($subCat, $pagination = "",$returnUrl=false) {
        if($returnUrl){
           $c = new C_press();
           return $c->url();
        }

        die("toto");
    }
    
    /**
     *
     * 
     */
    public function styleGuide($returnUrl=false) {  
	if($returnUrl){
	   $c = new C_press();
	   return $c->url(); 
	}
        // set the css and the js 
        self::setCssAndJs();
        $c = new C_press();
        
        $vv = new VV_layout();
        $c->resultView = new View("press/styleGuide", $vv);
        return $c;
    }
    
    /**
     * Settings for admin, need to be added
     * @param bool $final si true, incluera les fichiers de base
     */
    private static function setCssAndJs($final=true){

        //modernizer
        JS::addToHeader("pub/libs/modernizr-2.5.3-respond-1.1.0.min.js");
        
        //jquery
        JS::addAfterBody("pub/libs/jquery-1.7.2.js");
        JS::addAfterBody("pub/libs/jquery.history.js");

	
        JS::addAfterBody("pub/app/admin/utils/Utils.js");

        //bootstrap
        JS::addAfterBody("pub/libs/bootstrap/js/bootstrap.js");

        JS::addAfterBody("pub/libs/greensock/TweenMax.min.js");

        JS::addAfterBody("pub/libs/heartcode-canvasloader-min.js");

        // FB
        JS::addAfterBody("http://connect.facebook.net/en_US/all.js");

        // Press
        JS::addAfterBody("pub/app/press/js/Dom.js");
        JS::addAfterBody("pub/app/press/js/Nav.js");
        JS::addAfterBody("pub/tools/EventDispatcher.js");
        JS::addAfterBody("pub/app/press/js/Share.js");
        JS::addAfterBody("pub/app/press/js/Press.js");
        
        //compile and integrate less files
        $lessVariables=array(
            "phpAppFolder"=>"'".Site::url("pub")."'"
        );
        //get the compiled less file
        $lessFile=Less::getCss("pub/app/press/Press",$lessVariables);
        //add the file to header section
        CSS::addToHeader($lessFile);
        
        
        
	
    }
}

?>
