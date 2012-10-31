<?php
/**
 * A model dedicated to images
 */
class M_photo extends M_ {
    /**
     * @var Manager the dedicated manager to this object.
     */
    public static $manager;
    /**
     *
     * @var ImageField photo for the post content 
     */
    public $photo;

    /**
     * Create a new M_photo with default values, save it and return it.
     * @return M_post The new post.
     */
    public static function getNew(){
        $new=new M_photo();
        $new->photo="pub/app/press/img/default-image-16-9.jpg";
       $new->save();
        return $new;
    }
}
?>
