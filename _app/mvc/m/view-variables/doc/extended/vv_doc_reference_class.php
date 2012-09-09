<?

class VV_doc_reference_class extends VV_doc_reference{
    
    /**
     *
     * @var ReflectionMethod 
     */
    public $publicFunctions;
    
    /**
     *
     * @var DocParser 
     */
    public $parsed;
    
    /**
     *
     * @var ReflectionClass 
     */
    public $reflectionClass;
    /**
     *
     * @param string $className
     * @return bool will be false if an error occurs. 
     */
    public function setClassName($className){
        
        $this->run();
        if(!self::$classesFiles[$className]){
            return false;
        }
        require_once(self::$classesFiles[$className]);
        $rc = $this->reflectionClass = new ReflectionClass($className);
        
        //easy params
        $this->extends=$rc->getParentClass()?$rc->getParentClass()->name:"nothing";
        $this->className=$rc->name;
        $this->file=$rc->getFileName();
        
        $this->privateFunctions=$rc->getMethods(ReflectionMethod::IS_PRIVATE ^ ReflectionProperty::IS_STATIC);
        $this->publicFunctions=$rc->getMethods(ReflectionMethod::IS_PUBLIC ^ ReflectionProperty::IS_STATIC);
        $this->publicStaticFunctions=$rc->getMethods(ReflectionMethod::IS_PUBLIC & ReflectionProperty::IS_STATIC);
        $this->privateStaticFunctions=$rc->getMethods(ReflectionMethod::IS_PRIVATE & ReflectionProperty::IS_STATIC);
        /*
        $methods = $this->getMethods(ReflectionMethod::IS_PUBLIC ^ ReflectionMethod::IS_STATIC);
        $properties = $this->getProperties(ReflectionProperty::IS_PUBLIC ^ ReflectionProperty::IS_STATIC);
        $staticMethods = $this->getMethods(ReflectionMethod::IS_PUBLIC & ReflectionMethod::IS_STATIC);
        $staticProperties = $this->getProperties(ReflectionProperty::IS_PUBLIC & ReflectionProperty::IS_STATIC);
         */
        
        $this->comments=$rc->getDocComment();
        $this->author=$this->getMeta("author");
        $this->description=$this->getDescription();
        /*
        if($this->comments){
           $this->parsed=  $this->parseComments($this->comments); 
           $this->description=$this->parsed->getShortDesc()."<br/>".$this->parsed->getDesc()."";
        }*/
        

        
        return true;
        
    }
    private function parseComments($comments){
        $parser=new DocParser($comments);
        $parser->parse();
        $params=$parser->getParams();
        $this->author=$params["author"];
        return $parser;
    }
    /**
     * return a meta param like author
     * @param type $paramName
     * @return type 
     */
    public function getMeta($paramName){
        preg_match_all("/@".$paramName." (.*)/",$this->comments,$out);
        if($out && $out[0]){
            $value=$out[1][0];
            return $value;
        }
        return $out;  
    }
    public function getDescription(){
        $str= preg_replace("/\*/s","",$this->comments);
        $str= preg_replace("/^\//s","",$str);
        preg_match_all("/(.*)@/s",$str,$out);
        if($out && $out[0]){
            $value=$out[1][0];
            return $value;
        }
        return $out;  
    }

    
}



