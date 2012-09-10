<?php

/**
 * This class will help you to parse code comments.
 *
 * @author David Marsalone
 */
class CodeComments {
    /**
     * return the description of a function or a class.
     * @param string $comments
     * @return string The description or false 
     */
    public static function getDescription($comments){
        
        //clean /* */ and * * *
        $str= preg_replace("|\*\/|s","",$comments);
        $str= preg_replace("|\/\*\*|s","",$str);
        $str= preg_replace("/\*/s","",$str);
        $str= preg_replace("/^\//s","",$str);
        //extract form the beginning to the first @
        preg_match_all("/(.*?)@/s",$str,$out);
        if($out && $out[0]){
            $value=$out[1][0];
        }else{
            $value=$str; //there is no @ probably so we return the whole comment 
        }
        $value=trim($value);
        $value=trim($value);
        $value=  nl2br($value);
        if(!$value){
           $value="Missing documentation."; 
        }
        
        return ucfirst($value);
        return $out;  
    }
    /**
    * return a meta param like @author or @see etc...
    * Note, that if you need to extract @param it will works but the getArgument() method will be probably better. 
    * @param string $paramName of the @paramName
    * @param string $comments
    * @return string the value 
    */
    public static function getMeta($paramName,$comments){
        preg_match_all("/@".$paramName." (.*)/",$comments,$out);
        if($out && $out[0]){
            $value=$out[1][0];
            return $value;
        }
        return $out;  
    }
    /**
     * Return the @param $argument type and description...it is for functions for sure!
     * @param string $argument The argument you want to show.
     * @param string $comments The php comment block to parse.
     */
    public static function getArgument($argument,$comments){
        $argument= str_replace("$","",$argument);
        $reg="/@param(.*)\\$".$argument."(.*)/";
        preg_match_all($reg,$comments,$out);
        if($out && $out[0]){
            $type=$out[1][0];
            $description=$out[2][0];
        }
        return self::getTypeAndDescription($type, $description); 
    }
    /**
     *
     * @param type $comments
     * @return string 
     */
    public static function getReturn($comments){
        
        $reg="/@return (.*?) (.*)/";
        preg_match_all($reg,$comments,$out);
        if($out && $out[0]){
            $type=$out[1][0];
            $description=$out[2][0];
        }
        if(!$type && !$description){
            $type="void";
        }
        return self::getTypeAndDescription($type, $description);
    }
    /**
     * Return an array with keys $type & $description. The two parameters are managed to support exceptions messages like "missing documentation" when something is not defined.
     * @param string $type 
     * @param string $description 
     */
    private static function getTypeAndDescription($type,$description){
            $type=  trim($type);
            switch($type){
                case "type":
                case "":
                   $type="undocumented";
                   break;
            } 
            
            $description=  trim($description);
            switch($description){
                case "":
                   $description="Missing documentation";
                   break;
            }
            return array("type"=>$type,"description"=>$description);
    }
    /**
     * Will return a quick overview of parameters.
     * @example $param1:bool, $param2:SomeTypeClass, $param3:bool=true
     * @param ReflectionMethod $fn The function that will give use the parameters.
     */
    public static function getParametersOverview($fn){
        /* @var $param ReflectionParameter*/
        $parameters=$fn->getParameters();
        $comments=$fn->getDocComment();
        $out=array();
        foreach($parameters as $param){
            $str="$".$param->name;
            $str.="";
            $type=self::getArgument($param->name, $comments);
            $type=$type["type"];
            if(!$type){
                $type="unknow";
            }
            $str.=":".$type;
            if($param->isOptional()){
                $def=$param->getDefaultValue();
                if($def==""){
                    $def="empty";
                }
                $str.=" = ".$def;
            }
            $out[]=$str;
        }
        return implode(", ",$out);
    }
    /**
     * Will return a quick overview of parameters.
     * @example $param1:bool, $param2:SomeTypeClass, $param3:bool=true
     * @param ReflectionMethod $fn The function that will give use the parameters.
     */
    public static function getReturnOverview($comments){
        $return = self::getReturn($comments);
        $str=$return["type"];
        return $str;
    }
    
}
