<?php
/**
 * A text commonly used a a pragraph in a mixed model field.  
 */
class M_text extends M_{

    /**
     *
     * @var TextField 
     */
    public $title;
    /**
     *
     * @var HtmlField 
     */
    public $text;
    
    
}
class M_textManager extends DbManager{
    
}
M_::generate("M_text", M_textManager);
//M_text::$manager=new M_textManager(M_text);
$m=new M_text();
$m->init();
M_text::$manager->init();


