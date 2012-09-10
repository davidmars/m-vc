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
        
        $this->allFunctions=$rc->getMethods();

        $this->privateFunctions=array();
        $this->privateStaticFunctions=array();
        $this->inheritPrivateFunctions=array();
        $this->inheritPrivateStaticFunctions=array();
        
        $this->publicFunctions=array();
        $this->publicStaticFunctions=array();
        $this->inheritPublicFunctions=array();
        $this->inheritPublicStaticFunctions=array();

        /* @var $fn ReflectionMethod*/
        
        $localMethods=array();
        //filter functions
        foreach($this->allFunctions as $fn){
            switch (true){
                
                case $fn->isPublic() && !$fn->isStatic() && $fn->getDeclaringClass()->name==$className;
                $this->publicFunctions[]=$fn;
                break;
                
                case $fn->isPublic() && $fn->isStatic() && $fn->getDeclaringClass()->name==$className;
                $this->publicStaticFunctions[]=$fn;
                break;
            
                case $fn->isPublic() && !$fn->isStatic() && $fn->getDeclaringClass()->name!=$className;
                $this->inheritPublicFunctions[]=$fn;
                break;
            
                case $fn->isPublic() && $fn->isStatic() && $fn->getDeclaringClass()->name!=$className;
                $this->inheritPublicStaticFunctions[]=$fn;
                break;
                
                //----------------privates
                
                case $fn->isPrivate() && !$fn->isStatic() && $fn->getDeclaringClass()->name==$className;
                $this->privateFunctions[]=$fn;
                break;
                
                case $fn->isPrivate() && $fn->isStatic() && $fn->getDeclaringClass()->name==$className;
                $this->isPrivateStaticFunctions[]=$fn;
                break;
            
                case $fn->isPrivate() && !$fn->isStatic() && $fn->getDeclaringClass()->name!=$className;
                $this->inheritPrivateFunctions[]=$fn;
                break;
            
                case $fn->isPrivate() && $fn->isStatic() && $fn->getDeclaringClass()->name!=$className;
                $this->inheritPrivateStaticFunctions[]=$fn;
                break;
                
                    
            }
             
        }

        
        $this->comments=$rc->getDocComment();
        $this->author=  CodeComments::getMeta("author", $this->comments);
        $this->description=CodeComments::getDescription($this->comments);

        return true;
        
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



