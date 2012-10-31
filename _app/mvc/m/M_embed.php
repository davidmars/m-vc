<?php
/**
 * An embed is a stuff represented by html code generaly from an other website. 
 * For exemple, a youtube video outside youtube is an Embed.  
 */
class M_embed extends M_{

    public static $manager;
    /**
     *
     * @var TextField The html code of the stuff to display.
     */
    public $code;

    /**
     * Create a new M_photo with default values, save it and return it.
     * @return M_post The new post.
     */
    public static function getNew(){
        $new=new M_embed();
        $new->code='<iframe width="100%" height="100%" src="http://www.youtube.com/embed/FdyC-DTnXUI?list=UU2c0pMVgmvPmM6g2BBXZHRA&amp;hl=fr_FR" frameborder="0" allowfullscreen></iframe>';
        $new->save();
        return $new;
    }

    
}




