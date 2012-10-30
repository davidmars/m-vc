<?php
/**
 * A Contact represents a contact information with a downloadable file
 */
class M_contact extends M_{

    public static $manager;
    /**
     *
     * @var TextField The name of the contact.
     */
    public $name;                
    /**
     *
     * @var TextField The function of the contact
     */
    public $role;
    /**
     *
     * @var TextField The society of the contact.
     */
    public $society;                
    /**
     *
     * @var TextField The street of the contact.
     */
    public $street;    
    /**
     *
     * @var TextField The zip of the contact.
     */
    public $zip;        
    /**
     *
     * @var TextField The city of the contact.
     */
    public $city;    
    /**
     *
     * @var TextField The country of the contact.
     */
    public $country;    
    /**
     *
     * @var TextField The number of the contact.
     */
    public $number;    
    /**
     *
     * @var TextField The email of the contact.
     */
    public $email;    
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
     * @var ModifiedField Test sur un champ dans le modele étendu 
     */
    //public $modifiedInExtend;



    /**
     * Create a new M_contact with default values, save it and return it.
     * @return M_contact The new contact.
     */
    public static function getNew(){
        $newItem=new M_contact();
        $newItem->name="name";
        $newItem->role="role";
        $newItem->society="society";
        $newItem->street="street";
        $newItem->zip="zip";
        $newItem->city="city";
        $newItem->country="country";
        $newItem->number="number";
        $newItem->email="email";
        $newItem->theFile="theFile";
        $newItem->thumb="thumb";

        $newItem->save();
        return $newItem;
    }


    /**
     *
     * @return array The admin config object for M_download model
     */
    public function getAdminConfig() {
        $conf=parent::getAdminConfig();
                
        $conf["default"]["fields"]["name"]=array(
            "visible"=>true,
            "label"=>"Name"
        );
        
        $conf["default"]["fields"]["role"]=array(
            "visible"=>true,
            "label"=>"Function"
        );
        
        $conf["default"]["fields"]["society"]=array(
            "visible"=>true,
            "label"=>"Society"
        );
        
        $conf["default"]["fields"]["street"]=array(
            "visible"=>true,
            "label"=>"Street"
        );
        
        $conf["default"]["fields"]["zip"]=array(
            "visible"=>true,
            "label"=>"Zip"
        );
        
        $conf["default"]["fields"]["city"]=array(
            "visible"=>true,
            "label"=>"City"
        );
        
        $conf["default"]["fields"]["country"]=array(
            "visible"=>true,
            "label"=>"Country"
        );
        
        $conf["default"]["fields"]["number"]=array(
            "visible"=>true,
            "label"=>"Number"
        );
        
        $conf["default"]["fields"]["email"]=array(
            "visible"=>true,
            "label"=>"Email"
        );
        
        $conf["default"]["fields"]["break"]=array(
            "notAField"=>true,
            "visible"=>true,
            "template"=>"admin/fields/xtra/section",
            "label"=>"Contact file"
        );        
        $conf["default"]["fields"]["theFile"]=array(
            "visible"=>true,
            "label"=>"Downloadable file",
            "help"=>"the file contact to download"
            
        );
        $conf["default"]["fields"]["restricted"]=array(
            "visible"=>false,
            "label"=>"Private file?",
            "help"=>"Does the user need to to be logged to downlaod this file?"
        );
        
        return $conf;
    }
           
    
}




