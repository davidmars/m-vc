<?php
/**
 * A Download represents a file that is downloadable.  
 */
class M_download extends M_{

    public static $manager;
    /**
     *
     * @var TextField The name of the download.
     */
    public $title;    
    /**
     *
     * @var TextField The description of the download.
     */
    public $description;    
    /**
     *
     * @var File The file itself.
     */
    public $file;
    /**
     *
     * @var PhotoRectangle The thumbnail for this download.
     */
    public $thumb;
    /**
     *
     * @var BoolField Is the file downloadable without authorisation?
     */
    public $restricted=false;
    
    /**
     *
     * @var M_category The category where it will be possible to find the download.
     */
    public $category;

           
    
}




