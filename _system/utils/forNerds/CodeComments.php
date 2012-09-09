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
        $str= preg_replace("|\*\/|s","",$comments);
        $str= preg_replace("|\/\*\*|s","",$str);
        $str= preg_replace("/\*/s","",$str);
        $str= preg_replace("/^\//s","",$str);
        preg_match_all("/(.*?)@/s",$str,$out);
        if($out && $out[0]){
            $value=$out[1][0];
        }else{
            $value=$str;
        }
        $value=trim($value);
        $value=trim($value);
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
     *
     * @param type $argument
     * @param type $comments 
     */
    public static function getArgument($argument,$comments){
        $argument= str_replace("$","",$argument);
        $reg="/@param(.*)\\$".$argument."(.*)/";
        preg_match_all($reg,$comments,$out);
        if($out && $out[0]){
            $type=$out[1][0];
            $description=$out[2][0];
            $type=  trim($type);
            switch($type){
                case "type":
                case "":
                   $type="unknow";
                   break;
            }
            return array("type"=>$type,"description"=>$description);
        }
        return $reg;  
    }
    /**
     *
     * @param ReflectionMethod $fn 
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
    
}
