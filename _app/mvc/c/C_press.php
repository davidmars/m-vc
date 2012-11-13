<?php

/**
 * Here 
 */
Class C_press extends Controller{

    /**
     * Display the default page.
     * @param bool $returnUrl
     * @return C_press|string
     */
    public static function index($returnUrl=false){
        if($returnUrl){
            //managed by routes...
            return GiveMe::url("");
        }
        //what is this page?
        return self::categoryPost("press-release",0);
    }
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
        /** @var $currentCategory M_category_post */
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
     * Return a preview page to display in the pop in.
     * @param $mediaId The media
     * @param $type the pop in type we can have preview or download
     * @param bool $returnUrl
     * @return C_press
     */
    public static function mediaPreview($mediaId, $type = "preview", $returnUrl=false) {
        if($returnUrl){
           $c = new C_press();
           return $c->url();
        }

        // create a variable for our controller
        $c = new C_press();
        /* @var $media M_media */
        $media=M_media::$manager->get($mediaId);

        $vv = new VV_media();
        $vv->init($media);
        
        // check the type of the pop in 
        if ($type == "preview") {
            if($media->isImage()){
                $c->resultView = new View("press/popin/media-image", $vv);
            }else if($media->isVideo()){
                $c->resultView = new View("press/popin/media-video", $vv);
            }else{
                $c->resultView = new View("press/popin/media-other", $vv);
            }
        }
        else {
            $c->resultView = new View("press/popin/media-other", $vv);
        }

        // return the controller
        return $c;
    }

    public   function getContentMail($data, $idPost){
        /* @var $post M_post */
        $post = M_post::$manager->get($idPost);

        $content = '<html><head><title>Contact</title></head><body>';

        $content .= '<table cellspacing="0" cellpadding="0" border="0" width="100%" style="margin:0;" bgcolor="#900" background="' . Site::$host .  Site::url("pub") . '/app/press/img/territoire.jpg"><tr><td width="100%" height="16px"></td></tr><tr><td>';

        $content .= '<table cellspacing="0" cellpadding="0" border="0" width="620px" style="margin:0 auto;" bgcolor="#ffffff"><tr><td height="16px"></td></tr><tr><td width="16px"></td><td width="588px" bgcolor="#ffffff" style="font-family:Arial, sans-serif; font-size:12px; line-height:13px; color:#000000;"><b>' . $data['senderemail'] . '</b> shared_link_with_you <a href="' . Site::$host . '"><font color="#990000"><u>' . Site::$host . '</u></font></a></td><td width="16px"></td></tr><tr><td height="16px"></td></tr><tr><td width="16px"></td><td width="588px" bgcolor="#ffffff" style="font-family:Arial, sans-serif; font-size:12px; line-height:13px; color:#000000;">' . $data["message"] . '</td><td width="16px"></td></tr><tr><td height="16px"></td></tr><tr><td width="16px"></td><td>';

        $content .= '<table cellspacing="0" cellpadding="0" border="0" width="588px" style="margin:0 auto;" bgcolor="#ffffff"><tr><td width="100px" height="100px" bgcolor="#ffffff" style="font-family:Arial, sans-serif; font-size:12px; line-height:13px; color:#000000;" valign="top"><a href="' . Site::$host . $data["pageid"] . '"><img src="' . Site::$host . $post->thumb->sized(100, 100, "000000", "jpg") . '" alt="' . $post->title . '" width="100px" height="100px" border="0"/></a></td><td width="16px" height="100px"></td><td valign="top">';

        $content .= '<table cellspacing="0" cellpadding="0" border="0" width="472px" style="margin:0 auto;" bgcolor="#ffffff"><tr><td width="472px" bgcolor="#ffffff" style="font-family:Arial, sans-serif; font-size:13px; line-height:13px; color:#990000;" valign="top"><b><a href="' . Site::$host . $data["pageid"] . '"><font color="#990000">' . $post->title . '</font></a></b></td></tr><tr><td width="472px" height="5px"></td></tr><tr><td width="472px" bgcolor="#ffffff" style="font-family:Arial, sans-serif; font-size:11px; line-height:13px; color:#aaaaaa;" valign="top"><a href="' . Site::$host . $data["pageid"] . '"><font color="#aaaaaa"><u>' . Site::$host . $data["pageid"] . '</u></font></a></td></tr><tr><td width="472px" height="5px"></td></tr><tr><td width="472px" bgcolor="#ffffff" style="font-family:Arial, sans-serif; font-size:12px; line-height:13px; color:#000000;" valign="top">' . $post->description . '</td></tr>';

        $content  .= '</table></td></tr>';

        $content  .= '</table></td><td width="16px"></td></tr><tr><td height="16px"></td></tr>';

        $content  .= '</table></td></tr><tr><td width="100%" height="16px"></td></tr>';

        $content  .= '</table></body></html>';

        return $content;
    }


    /**
     * Open the pop in for share by email the post
     * @param IdField $idPost
     * @param bool $returnUrl
     * @return C_press|string
     */
    public static function sendToFriend($idPost, $returnUrl=false) {
        if($returnUrl){
            $c = new C_press();
            return $c->url();
        }

        if ($_POST) {
            $title = "Havana PressRoom";

            $headers = "From: ".$_POST['senderemail']."\r\n";
            $headers .= 'Content-type: text/html; charset=UTF-8' ."\r\n";

            $c = new C_press();

            $content = $c->getContentMail($_POST, $idPost);

            //echo $content;

            if( mail( $_POST["friendemail"] , $title ,  $content , $headers ) ){
                echo json_encode(array(
                    "sent" => "ok"
                ));
            }
            die();
        }

        // create a variable for our controller
        $c = new C_press();

        $vv = new VV_share();
        $vv->init($idPost);

        $c->resultView = new View("press/popin/share-friend", $vv);

        return $c;
    }

    /**
     * Open the pop in for show the terms
     * @param bool $returnUrl
     * @return C_press|string
     */
    public static function showTerms($returnUrl=false) {
        if($returnUrl){
            $c = new C_press();
            return $c->url();
        }

        // create a variable for our controller
        $c = new C_press();

        $vv = new VV_layout();

        $c->resultView = new View("press/popin/terms", $vv);

        return $c;
    }

    /**
     * Open the pop in for show the terms
     * @param bool $returnUrl
     * @return C_press|string
     */
    public static function showPrivacy($returnUrl=false) {
        if($returnUrl){
            $c = new C_press();
            return $c->url();
        }

        // create a variable for our controller
        $c = new C_press();

        $vv = new VV_layout();

        $c->resultView = new View("press/popin/privacy", $vv);

        return $c;
    }

    /**
     * Open the pop in for show the terms
     * @param bool $returnUrl
     * @return C_press|string
     */
    public static function showContact($returnUrl=false) {
        if($returnUrl){
            $c = new C_press();
            return $c->url();
        }

        // create a variable for our controller
        $c = new C_press();

        $vv = new VV_layout();

        $c->resultView = new View("press/popin/contact", $vv);

        return $c;
    }

    /**
     * Open the pop in for show the terms
     * @param bool $returnUrl
     * @return C_press|string
     */
    public static function showNews($returnUrl=false) {
        if($returnUrl){
            $c = new C_press();
            return $c->url();
        }

        // create a variable for our controller
        $c = new C_press();

        $vv = new VV_layout();

        $c->resultView = new View("press/popin/news", $vv);

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
    public static function subCatMedia($subCat, $template, $start, $nbItem,$returnUrl=false) {
        if($returnUrl){
           $c = new C_press();
           return $c->url();
        }

        // set the css and the js
        self::setCssAndJs();

        $c = new C_press();

        // get the current sub category media
        $currentSubCategory = M_subcategory_media::$manager->get($subCat);

        // create the good view variable for our view
        $vv = new VV_subCatMedia();
        $vv->init($currentSubCategory, $start, $nbItem, $template);

        if ($template == "Page") {
            $template = "press/subCatMediaPage";
        }
        else {
            $template = "press/media/subCatMediaList";
        }

        $c->resultView = new View($template, $vv);
        return $c;
    }
    /**
     * Display the login page.
     * @param bool $returnUrl
     * @return C_admin_model
     */
    public static function login($returnUrl=false){

        if($returnUrl){
            $c = new C_press();
            return $c->url();
        }

        $c=new C_press();
        self::setCssAndJs(true);
        $vv=new VV_layout();
        $vv->isLogin=true;
        $c->resultView=new View("press/login",$vv);
        return $c;
    }
    /**
     * Logout the user
     * In all cases, die the action with a VV_apiReturn.
     */
    public static function logout(){

        $log=M_user::logout();
        return self::login();
    }
    /**
     * Display the sidebar content. This is only used by admin to refresh the page.
     * @param bool $returnUrl
     * @return C_press|string
     */
    public static function sideBar($returnUrl=false) {
        if($returnUrl){
            $c = new C_press();
            return $c->url();
        }

        $c = new C_press();

        $vv = new VV_layout();

        $c->resultView = new View("press/sidebar/sideBar", $vv);
        return $c;
    }

    /**
     * Display a style guide page. a good way th understand the css
     * @param bool $returnUrl
     * @return C_press|string
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
        $c->resultView = new View("press/style-guide/styleGuide", $vv);
        return $c;
    }
    
    /**
     * Settings for admin, need to be added
     * @param bool $forceadmin if true will include the admin fils if the user is logged or not
     */
    private static function setCssAndJs($forceadmin=true){
        //modernizer
        JS::addToHeader("pub/libs/modernizr-2.5.3-respond-1.1.0.min.js");
        
        //jquery
        JS::addAfterBody("pub/libs/jquery-1.7.2.js");
        JS::addAfterBody("pub/libs/jquery.history.js");


	
        JS::addAfterBody("pub/app/admin/utils/Utils.js");

        //bootstrap
        JS::addAfterBody("pub/libs/bootstrap/js/bootstrap.js");

        JS::addAfterBody("pub/libs/greensock/TweenMax.min.js");
        JS::addAfterBody("pub/libs/greensock/plugins/ScrollToPlugin.min.js");

        JS::addAfterBody("pub/libs/heartcode-canvasloader-min.js");

        // social share
        JS::addAfterBody("https://apis.google.com/js/plusone.js");
        JS::addAfterBody("http://platform.twitter.com/widgets.js");
        JS::addAfterBody("http://connect.facebook.net/en_US/all.js");

        // Press
        JS::addAfterBody("pub/app/press/js/Dom.js");
        JS::addAfterBody("pub/app/press/js/Nav.js");
        JS::addAfterBody("pub/app/press/js/Form.js");
        JS::addAfterBody("pub/tools/EventDispatcher.js");
        JS::addAfterBody("pub/app/press/js/Share.js");

        //admin?
        if(M_user::currentUser()->canWrite() || $forceadmin){
            POV_CssAndJs::adminSettings(false);
        }
        JS::addAfterBody("pub/app/press/js/Press.js");
        JS::addAfterBody("pub/app/press/js/Press.Slider.js");
        JS::addAfterBody("pub/app/press/js/boot.js");




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
