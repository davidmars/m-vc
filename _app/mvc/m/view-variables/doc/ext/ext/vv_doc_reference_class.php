<?
/**
 *
 * This class contains what you need to display informations about a Class. In fact it is used to display documentation. 
 */
class VV_doc_reference_class extends VV_doc_reference{
    /** 
     * 
     * @var ReflectionProperty List all the ReflectionProperty(ies) in the class.
     */
    public $allVariables;
    /** 
     * 
     * @var ReflectionProperty List all the non herited statics ReflectionProperty(ies) in the class.
     */
    public $staticVariables;
    /**
     *
     * @var ReflectionMethod List all the ReflectionMethod(s) in the class.
     */
    public $publicFunctions;
    /**
     *
     * @var ReflectionClass A direct acces to the ReflectionClass of the class. 
     */
    public $reflectionClass;
    /**
     * In fact it could ne a constructor. You need to call this method to fill the current model with properties.
     * @param string $className The class name you need.
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
        
        
        $this->allVariables=$rc->getProperties();
        
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
        
        //filter functions by scopes and visibility
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
        
        $this->privateVariables=array();
        $this->privateStaticVariables=array();
        $this->inheritPrivateVariables=array();
        $this->inheritPrivateStaticVariables=array();
        
        $this->publicVariables=array();
        $this->publicStaticVariables=array();
        $this->inheritPublicVariables=array();
        $this->inheritPublicStaticVariables=array();
        
        
        /* @var $prop ReflectionProperty*/
        
        //filter variables by scopes and visibility
        foreach($this->allVariables as $prop){
            switch (true){
                
                case $prop->isPublic() && !$prop->isStatic() && $prop->getDeclaringClass()->name==$className;
                $this->publicVariables[]=$prop;
                break;
                
                case $prop->isPublic() && $prop->isStatic() && $prop->getDeclaringClass()->name==$className;
                $this->publicStaticVariables[]=$prop;
                break;
            
                case $prop->isPublic() && !$prop->isStatic() && $prop->getDeclaringClass()->name!=$className;
                $this->inheritPublicVariables[]=$prop;
                break;
            
                case $prop->isPublic() && $prop->isStatic() && $prop->getDeclaringClass()->name!=$className;
                $this->inheritPublicStaticVariables[]=$prop;
                break;
                
                //----------------privates
                
                case $prop->isPrivate() && !$prop->isStatic() && $prop->getDeclaringClass()->name==$className;
                $this->privateVariables[]=$prop;
                break;
                
                case $prop->isPrivate() && $prop->isStatic() && $prop->getDeclaringClass()->name==$className;
                $this->isPrivateStaticVariables[]=$prop;
                break;
            
                case $prop->isPrivate() && !$prop->isStatic() && $prop->getDeclaringClass()->name!=$className;
                $this->inheritPrivateVariables[]=$prop;
                break;
            
                case $prop->isPrivate() && $prop->isStatic() && $prop->getDeclaringClass()->name!=$className;
                $this->inheritPrivateStaticVariables[]=$prop;
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



