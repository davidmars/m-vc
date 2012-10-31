<?php
/**
 * A text commonly used a a pragraph in a mixed model field.  
 */
class M_text extends M_{

    public static $manager;
    /**
     *
     * @var TextField An optional title. 
     */
    public $title;
    /**
     *
     * @var HtmlField The text content itself.
     */
    public $text;


    /**
     * Create a new M_post with default values, save it and return it.
     * @return M_post The new post.
     */
    public static function getNew(){
        $new=new M_text();
        $new->title="The title here...";
        $new->text="Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.";
        $new->save();
        return $new;
    }

    public function getAdminConfig() {
        $conf=parent::getAdminConfig();
        
        $conf["default"]["fields"]["title"]=array(
            "visible"=>true,
            "label"=>"Title"
        );
        $conf["default"]["fields"]["text"]=array(
            "visible"=>true,
            "label"=>"Text content",
            "span"=>8
        );
        return $conf;
    }
    
    
}
