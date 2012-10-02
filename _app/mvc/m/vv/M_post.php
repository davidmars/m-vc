<?php
/**
 * A post is a page wich can display various content.  
 */
class M_post extends M_{

    public static $manager;
    /**
     *
     * @var TextField 
     */
    public $title;
    /**
     *
     * @var BoolField 
     */
    public $sticky=true;
    
    /**
     *
     * @var EnumField 
     */
    public $template="big";
    /**
     *
     * @var array The possibles values for the field $template 
     */
    public $templateStates=array("small","medium","big");
    

           
    
}

class M_postManager extends DbManager {
    
}
M_::generate("M_post", M_postManager);
//M_post::$manager=new M_postManager(M_post);
$m=new M_post();
$m->init();
M_post::$manager->init();


