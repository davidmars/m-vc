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
