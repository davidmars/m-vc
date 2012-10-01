<?php
/**
 * A post is a page wich can display various content.  
 */
class M_post extends M_{

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
/*
class M_postManager extends DbManager {
    
}
 
 */





