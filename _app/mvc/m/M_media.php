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
     * @var FileField The file that the high definition final user will be able to download
     */
    public $theFileHd;
    /**
     *
     * @var BoolField Is the file downloadable without authorisation?
     */
    public $restricted=false;
    
    /**
     *
     * @var M_subcategory_media The subcategory where it will be possible to find the media.
     */
    //public $category;
    
    /**
     *
     * @var ModifiedField Test sur un champ dans le modele étendu 
     */
    //public $modifiedInExtend;
    
        
    /**
     *
     * @var ImageField Thumbnail representation of the media 
     */
    public $thumb;

    /**
     * @var TextField Embed code that can be used to preview a video
     */
    public $embed;


    /**
     * Create a new M_media with default values, save it and return it.
     * @return M_post The new post.
     */
    public static function getNew(){
        $new=new M_media();
        $new->title="This is a new download";
        $new->thumb="pub/app/press/img/default-image-square.jpg";
        $new->save();
        return $new;
    }

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
        
        $conf["default"]["fields"]["thumb"]=array(
            "visible"=>true,
            "label"=>"Thumbnail"
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

    /**
     * return an appropriate image url according the mime of the first download.
     * @return string
     */
    public function autoIcon(){
        if($this->isImage()){
            return $this->theFile;
        }
        if($this->isFont()){
            return "pub/app/press/img/icon_font.jpg";
        }
        if($this->isPdf()){
            return "pub/app/press/img/icon_pdf.jpg";
        }

        //default
        return "pub/app/press/img/icon_ppt.jpg";
    }

    /**
     * @return bool true if the first download is a zip file
     */
    public function isZip(){
        if(preg_match("#zip#",$this->theFile->mime())){
            return true;
        }else{
            return false;
        }
    }
    /**
     * @return bool true if the first download is a fnnt file
     */
    public function isFont(){
        if(FileTools::extension($this->theFile)=="ttf" || FileTools::extension($this->theFile)=="otf"){
            return true;
        }else{
            return false;
        }
    }
    /**
     * @return bool true if the first download is a pdf file
     */
    public function isPdf(){
        if(preg_match("#pdf#",$this->theFile->mime())){
            return true;
        }else{
            return false;
        }
    }
    /**
     * @return bool true if the first download is an image
     */
    public function isImage(){
        if(preg_match("#image#",$this->theFile->mime())){
            return true;
        }else{
            return false;
        }
    }
    /**
     * @return bool true if the first download is an video
     */
    public function isVideo(){
        if(preg_match("#video#",$this->theFile->mime())){
            return true;
        }else{
            return false;
        }
    }
    /**
     * @return bool true if there is one or more download available
     */
    public function hasOneOrModeDownload(){
        if($this->theFile->exists() || $this->theFileHd->exists()){
            return true;
        }else{
            return false;
        }
    }
           

}



