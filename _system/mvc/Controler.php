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
    

    const OUTPUT_JSON="json";
    const OUTPUT_XML="xml";
    const OUTPUT_HTML="html";
    
    
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
     *
     * @var String the requested output type for this controler.
     * 
     * @see OUTPUT_JSON
     * @see OUTPUT_XML
     * @see OUTPUT_HTML
     */
    public $outputType=self::OUTPUT_HTML;
    
    


     /**
     * Return a controller based on a route.
     * @param String $route an url that looks like : /path/to/controler/controlerName/function-in-the-controler/param1/param2/paramN
     * @return Controler 
     */
    public static function getByRoute($route){
        

        
	$parts=explode("/",$route);
        
        $exts=explode(".", $parts[count($parts)-1]);
        if(count($exts)>1){
            Human::log("there is an extension");
            Human::log($exts);
            $ext=  array_pop($exts);
            Human::log($ext);
           
            $parts[count($parts)-1]=implode(".", $exts);
            Human::log($parts[count($parts)-1]);
            
        }
        $route=  implode("/", $parts);
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
                $controler->outputType=$ext;
		if(method_exists ( $controler, $fn )){
		    Human::log($controler, "controler function $fn found", Human::TYPE_WARN);
		    $controler->routeFunction=$fn;
		}else{
		    Human::log("The function $fn doesn't exists", "controler error", Human::TYPE_ERROR);
		}
		
		$controler->routeFunction=$fn;
		$controler->routeParams=$parts;
		//echo $url."===>".$url."  class name===>".$className." function===>".$fn." params===>".implode(",",$parts);
		
		return $controler;
		
                break;
            }	    
            array_pop($parts);
        }

        return false;
    }
    /**
     * process the controller with the current function and paramters.
     * @return View the resulting view object
     */
    public function run(){
        $view=call_user_func_array(array($this,$this->routeFunction), $this->routeParams);
        return $view;
    }
    
    public function __construct() {
        
    }
    

}
