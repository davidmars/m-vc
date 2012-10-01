<?php

class M_ extends Model{
    
    public function __construct() {
        $this->init();
        parent::__construct();  
    }
    
     /**
     *
     * @var CreatedField 
     */
    public $created;
    /**
     *
     * @var ModifiedField 
     */
    public $modified;
    
    /**
     *
     * @var IdField  
     */
    public $id;








    private static $yetInit=false;
    
    /**
     *
     * @var array The database fields names. 
     */
    public static $dbFields=array();
    /**
     * Prepare the model, so init the field associations with database 
     */
    public function init(){
       
        if(!self::$yetInit){
            self::$yetInit=true;
            //let's init database.
            $modelName=get_class($this);
            $modelNameManager=$modelName."Manager";
            if(!class_exists($modelNameManager)){
               $modelNameManager="DbManager";
            }
            self::$manager = new $modelNameManager( $modelName );
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

            self::$manager->init(); 
        }
        $this->unsetProperties();
        
         
          
    }
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
     *
     * @param string $className 
     * @return bool true if the className is a Field
     */
    public static function isDbField($className){
        $areFileds=array(
            "IdField",
            "CreatedField",
            "ModifiedField",
            "TextField",
            "BoolField",
            "EnumField",
            "IdField",
            "UIdField",
            "HtmlField",
        );
        if(in_array($className, $areFileds)){
            return true;
        }else{
            return false;
        }
    }
    
    
}
