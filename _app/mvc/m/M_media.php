<?php
/**
 * A media can contain a file to download, youtube embedded video, etc 
 */
class M_media extends M_{

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
     * @var FileField The file that the final user will be able to download 
     */
    public $theFile;
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
     * @var M_category_media The category where it will be possible to find the download.
     */
    public $category;
    
    /**
     *
     * @var ModifiedField Test sur un champ dans le modele étendu 
     */
    //public $modifiedInExtend;
    

    /**
     *
     * @return array The admin config object for M_download model
     */
    public function getAdminConfig() {
        $conf=parent::getAdminConfig();
        
        $conf["default"]["fields"]["title"]=array(
            "visible"=>true,
            "label"=>"Title"
        );
        $conf["default"]["fields"]["category"]=array(
            "visible"=>true,
            "label"=>"Category"
        );

        
        $conf["default"]["fields"]["break"]=array(
            "notAField"=>true,
            "visible"=>true,
            "template"=>"admin/fields/xtra/section",
            "label"=>"Download details"
        );
        $conf["default"]["fields"]["description"]=array(
            "visible"=>true,
            "label"=>"Description"
        );
        $conf["default"]["fields"]["theFile"]=array(
            "visible"=>true,
            "label"=>"Downloadable file",
            "help"=>"the file to download"
            
        );
        $conf["default"]["fields"]["restricted"]=array(
            "visible"=>true,
            "label"=>"Private file?",
            "help"=>"Does the user need to to be logged to downlaod this file?"
        );
        
        return $conf;
    }
           

}



