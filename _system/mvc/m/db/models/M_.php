<?php
/**
 * This is the basic database model instance. You will extend it a lot!
 * It contains basics fields for a database records. It performs the field relationships with database.
 */
class M_ extends Model{
    
    public function __construct() {
        $this->modelName=get_class($this);
        
        if(!self::$yetInit[get_class($this)]){
            //in fact boot the model, but this model will not work
            $this->createFields();
        }else{
            //a normal and cool model
            $this->unsetProperties();
            parent::__construct();
        }

          
    }
    
    //----------fields--------------------------------
    /**
     *
     * @var IdField  This is an unique identifier for this record.
     */
    public $id;
     /**
     *
     * @var CreatedField When was it created?
     */
    public $created;
    /**
     *
     * @var ModifiedField When was it last modified?
     */
    public $modified;




    /**
     *
     * @var array Contains all the model classes names. 
     */
    public static $allNames=array();


    /**
     *
     * @var array An array where model names are keys. Each key will be true if the model has been boot once. 
     */
    public static $yetInit=array();
    
    
    
    /**
     * Return a manager that will allow you to do database queries on this model.
     * @return DbManager The database manager related to the model. In fact the best entry to perform database queries. 
     */
    public function db(){
	return Manager::getManager($this);
    }
    
    public function humanName(){
	if($this->title){
	    return $this->title;
	}else{
	    return get_class($this)." ".$this->id;
	}
    }
    /**
     * Return an array with simple datas representations...mostly used in xml or json exports.
     * @return array Keys are field names, values, field values.
     */
    public function getDatas(){
        $r=array();
        $className=get_class($this);
        foreach($this->fields() as $f){
            $r[$f->name]=$f;
        }
        return $r;
    }
    

    /**
     * Performs a call to the specified model, like that it will be ready to use.
     * @param string $modelType The class name of the model to boot 
     */
    public static function initModel($modelType){
        $m=new $modelType();
        unset($m);
    }
    /**
     * Create the fields relationship with database. 
     */
    private function createFields(){
            //Human::log("------------- Create fields model ".$this->modelName);
            self::$yetInit[get_class($this)]=true;
            //let's init database.
            $modelName=get_class($this);
            $modelNameManager=$modelName."Manager";
            if(!class_exists($modelNameManager)){
               $modelNameManager="DbManager";
            }
            $rc=new ReflectionClass($modelName);
            $rc->setStaticPropertyValue("manager", new $modelNameManager(  $modelName ));
            
            //browse the class propeties to find db fields and then store it in a good order (keys first, associations later)
	        $fields=array();
            foreach ($rc->getProperties() as $field){
                //get the type from the @var type $field name comment...yes, I'm sure.
		        $comments=$field->getDocComment();
                $details=CodeComments::getVariable($comments);
		
                $type=$details["type"];
                $isVector=$details["isVector"];
                $description=$details["description"];
                $fieldName=$field->name;
		
		        $fieldObject=$this->getDbField($fieldName,$type,$isVector);

                if($fieldObject){
                    $fieldObject["comments"]=$description;
                    switch($fieldObject["type"]){

                        case "OneToOneAssoc":
                        case "NToNAssoc":
                            //associations at the end
                            array_push($fields, $fieldObject);
                        break;

                        default :
                            //classic fields at the beginning
                            array_unshift($fields, $fieldObject);

                    }
  
                }
            }
	    //create the fields
	    foreach ($fields as $f){
		$f["options"][Field::COMMENTS]=$f["comments"];
                Field::create($modelName.".".$f["name"],$f["type"],$f["options"]);
                //Human::log($this->modelName." Create field ".$f["name"]);
                
	    }
            
	    //whooho!
            $this->db()->init(); 
    }

    /**
     * Remove the original properties from the model that are related to database fields.
     * <b>WARNING :</b> launch it once, no more!
     * Why?
     * Because public properties in the models are not real Field objects and are not declared as Fields,
     * only the comments in the code does matter in fact.
     * So, the properties declared in a model are used as config and for autocompletion in your code.
     * And so, we need to unset this properties because they hidde the real Fields setters ans getters.
     * After that, the setters in Model will take effect...not before.
     */
    private function unsetProperties(){
       //Human::log("--------------------------------------------------- unset initial properties for ".$this->modelName);
       foreach($this->fields() as $f){
           
           $fieldName=$f->name;
           
           unset($this->$fieldName);
           /*
           if(gettype($this->$fieldName)=="object"){
              Human::log("FIELD now $fieldName is ".  get_class($this->$fieldName)); 
           }else{
              Human::log("FIELD now $fieldName is ".  gettype($this->$fieldName));  
           }
	    
	    */
       } 
    }
    /**
     * Checks if the $className given as parameter is a valid field class or not.
     * @param string $fieldName
     * @param string $className
     * @param bool $isVector
     * @return bool true if the className is a Field
     */
    public function getDbField($fieldName,$className,$isVector=false){
        $r=array(
            "name"=>$fieldName
        );

        $areFields=array(
            "IdField",
            "CreatedField",
            "ModifiedField",
            "TextField",
            "BoolField",
            "EnumField",
            "HtmlField",
            "FileField",
            "ImageField",
        );

        if(in_array($className,$areFields)){
            //standard field
            $options=array();
            switch($className){
                  case "EnumField":
                  $options[EnumField::STATES]=self::getStates(get_class($this),$fieldName);
                  $options[Field::DEFAULT_VALUE]=$options[EnumField::STATES][0];
                  /*$states=$fieldName."States";
                  $options[EnumField::STATES]=$this->$states;

                  */
            break;
	        }
            $r["options"]=$options;
            $r["type"]=$className;
            return $r;
	    
	    }else if(class_exists ($className) && is_subclass_of($className,"M_")){
            //an association
            if($isVector){
                //N to N assoc
                $r["options"]=array( Assoc::TO => $className,NtoNAssoc::LINK_MODEL=>$this->modelName."_".$className );
                //Field::create("Product.countries" , NtoNAssoc , array(Assoc::TO => Country, NtoNAssoc::LINK_MODEL => Product_Country ));
                $r["type"]="NtoNAssoc";
            }else{
                //one to One
                $r["options"]=array( Assoc::TO => $className );
                $r["type"]="OneToOneAssoc";
            }

            return $r;
        }else{
	    // $className is not a field...so false.
            return false;
        }
    }

    /**
     * Return an array with several states possibilities. To do it we parse the model constants.
     * A field named $toto will be in relationship with const TOTO_MY_STATE for example
     * @param string $className Name of the target class.
     * @param string $fieldName Name of the field which we want to guess the several states possibilities.
     */
    private static function getStates($className,$fieldName){
        $states=array();
        $rc=new ReflectionClass($className);
        $consts=$rc->getConstants();
        foreach($consts as $k=>$v){
            if(preg_match("#^".strtoupper($fieldName)."_#",$k)){
                $states[]=$v;
            }
        }
        return $states;
    }
    
    //--------------------admin preferences--------------------------------
    /**
     *
     * @var array Content options to display de model in admin UI.  
     */
    public static $adminConfig=array(
        "default"=>array(
            "fields"=>array(
                "id"=>array
                (
                    "visible"=>false,
                    "label"=>"Technical identifier"
                ),
                "created"=>array
                (
                    "visible"=>true,
                    "visibleIfNew"=>false,
                    "label"=>"Creation date"
                ),
                "modified"=>array
                (
                    "visible"=>true,
                    "visibleIfNew"=>false,
                    "label"=>"Last update"
                )
            )
        )
    );
    /**
     *
     * @return array Return the $adminConfig array. To customize fields in extendeds M_ override this method. 
     */
    public function getAdminConfig(){
        return self::$adminConfig;
    }


    //---------------------common requests---------------------------------
    
    /**
     * Returns the number of records of this model in the database.
     * @return int The number of records 
     */
    public function qTotal(){
        return Manager::getManager($this)->select()->count();
    }
    
    
}
