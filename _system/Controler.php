<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Controler
 *
 * @author david marsalone
 */
class Controler {

    /**
     * view is the view with the same controler "path/file-name of the controler"...except the suffix _c. 
     * @var View 
     */
    public $view;
    
    /**
     * 
     * @var ViewVariables The data object that will feed the View.
     */
    public $data;

    /**
     *
     * @var String the function name to call in the controller 
     */
    public $routeFunction="index";
    /**
     *
     * @var Array The parameters passed in the url 
     */
    public $routeParams=array();
    
    /**
     * Return the correct controler
     * @param String $route an url that looks like : /path/to/controler/controlerName/function-in-the-controler/param1/param2/paramN
     * @return Controler 
     */
    public static function getByRoute($route){
	
	$parts=explode("/",$route);
	$i=count($parts);
	
        while(count($parts)>0){
	    $i--;
            $url="_app/mvc/c/".implode("/",$parts).".php";
	    Human::log("search controler in $url");
            if(file_exists($url)){
		//class name
		$className=ucfirst($parts[count($parts)-1])."Controler";
		$parts=explode("/",$route);
		$i++;
		//function in the class
		$fn=$parts[$i];
		$i++;
		//params to feed the function
		array_splice($parts,0,$i);
		//include the controler
		require_once "$url";
		if(class_exists($className)){
		    Human::log("class $className exists! we have a controler");
		}else{
		    Human::log("class $className doesn't exists!","controler error",  Human::TYPE_ERROR);
		}
		
		//creates the controler
		$controler=new $className();

		if(method_exists ( $controler, $fn )){
		    Human::log($controler, "controler function $fn found", Human::TYPE_WARN);
		    $controler->routeFunction=$fn;
		}else{
		    Human::log("The function $fn does'nt exists", "controler error", Human::TYPE_ERROR);
		}
		
		$controler->routeFunction=$fn;
		$controler->routeParams=$parts;
		//echo $url."===>".$url."  class name===>".$className." function===>".$fn." params===>".implode(",",$parts);
		
		return $controler;
		
                break;
            }	    
            array_pop($parts);
        }
	
	
	
	
        return "false";
    }
    
    
    
    public function __construct() {
        
    }
    

}
