<?php

class M_ extends Model{
    
    public function __construct() {
        $this->init();
        parent::__construct();  
    }
    
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
     * @var IdField  This is an unique identifier for this record.
     */
    public $id;



    /**
     *
     * @var array Contains all the model classes names. 
     */
    public static $allNames=array();


    /**
     *
     * @var bool will be true if the model has been boot once. 
     */
    public static $yetInit=array();
    
    /**
     *
     * @var array The database fields names. 
     */
    public static $dbFields=array();
    /**
     * Prepare the model, so init the field associations with database 
     */
    
    /**
     * Return a manager that will allow you to do database queries on this model.
     * @return Manager The manager related to the model. In fact the best entry to perform database queries. 
     */
    public function db(){
	return Manager::getManager($this);
    }
    
    public function init(){
	Human::log("init model------------".get_class($this));
        if(!self::$yetInit[get_class($this)]){
            Human::log("init model for true-------------".get_class($this));
            self::$yetInit[get_class($this)]=true;
            //let's init database.
            $modelName=get_class($this);
            $modelNameManager=$modelName."Manager";
            if(!class_exists($modelNameManager)){
               $modelNameManager="DbManager";
            }
            $rc=new ReflectionClass($modelName);
            $rc->setStaticPropertyValue("manager", new $modelNameManager(  $modelName ));
            //self::$manager = new $modelNameManager( $modelName );
            Human::log("init model for true manager is-------------".get_class(self::$manager));
            /*@var $field ReflectionProperty */
            
            $rc=new ReflectionClass($modelName);
            
            //browse the class propeties to find db fields.
            foreach ($rc->getProperties() as $field){
                $comments=$field->getDocComment();
                $details=CodeComments::getVariable($comments);
                $type=$details["type"];
                $fieldName=$field->name;
                if(self::isDbField($type)){
                    self::$dbFields[]=$fieldName;
                    Human::log(" field->".$fieldName."= new ".$type, "db model creation ".$modelName);
                    
                    $options=array("modelType"=>$modelName);
                    
                    switch($type){
                      case "EnumField":
                      $states=$fieldName."States";
                      $options[EnumField::STATES]=$this->$states;
                      $options[Field::DEFAULT_VALUE]=$this->$fieldName;
                      break;
                    }
                    
                   
                    Field::create("$modelName.$fieldName", $type,$options); 
                }
            }

            $this->db()->init(); 
        }
        $this->unsetProperties();
        
         
          
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
     * Remove the original propertie from the model that are related to database fields.
     * After that, the setters in Model will take effect.
     */
    private function unsetProperties(){
       foreach(self::$dbFields as $f){
           unset($this->$f);
       } 
    }
    /**
     * Checks if the $className given as parameter is a valid field class or not.
     * @param string $className 
     * @return bool true if the className is a Field
     */
    public static function isDbField($className){
        $areFields=array(
            "IdField",
            "CreatedField",
            "ModifiedField",
            "TextField",
            "BoolField",
            "EnumField",
            "HtmlField",
        );
        if(in_array($className, $areFields)){
            return true;
        }else{
            return false;
        }
    }
    
    
    /**
     * Returns the number of records of this model in the database.
     * @return int The number of records 
     */
    public function qTotal(){
        return Manager::getManager($this)->select()->count();
    }
    
    
}
