<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Controller
 *
 * @author david marsalone
 */
class Controller {
    

    const OUTPUT_JSON="json";
    const OUTPUT_XML="xml";
    const OUTPUT_HTML="html";
    
    /**
     *
     * @var Nerd_Header The header according to the output (json, xml, html)
     */
    public $headerType;
    /**
     *
     * @var Nerd_Header The header according to the status (404,301...)
     */
    public $headerCode;
    
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
     *
     * @var string The original route wich led to this controller
     * @exemple my-controller-path/my-controller/my-function-in-the-controler/parameter-one/parameter-N 
     */
    public $route="";
    
    /**
     *
     * @var string  The route without parameters
     * @exemple my-controller-path/my-controller/my-function-in-the-controler 
     */
    public $routeToFunction="";
    /**
     *
     * @var string  The route without the function
     * @exemple my-controller-path/my-controller
     */
    public $routeToController="";

    
    /**
     * convert an url(splitted by folders) in an url that could match a controller. 
     * @param array $parts
     * @return string 
     * @exemple [toto,titi,tata] will return _app/mvc/c/toto/titi/c_tata.php
     */
    private static function getControlerPath($parts){
        $controllerFile=array_pop($parts);
        $controllerFile="/c_".$controllerFile.".php";
        $url=  Site::$appControllersFolder."/".implode("/", $parts).$controllerFile;
        return $url;
    }

    
    /**
     * Return a controller based on a route.
     * @param String $route an url that looks like : /path/to/controler/controlerName/function-in-the-controler/param1/param2/paramN
     * @return Controller 
     */
    public static function getByRoute($route){
        
        $savedRoute=$route;
	$parts=explode("/",$route);
        
        //search for extension first
        $exts=explode(".", $parts[count($parts)-1]);
        if(count($exts)>1){
            Human::log("there is an extension");
            Human::log($exts);
            $ext=  array_pop($exts);
            Human::log($ext);
            //remove the extension from the last $parts[] segment
            $parts[count($parts)-1]=implode(".", $exts);
            Human::log($parts[count($parts)-1]);
            
        }
        $route=implode("/", $parts);
	$i=count($parts);
	
        //search for controller itself
        while(count($parts)>0){
	    $i--;
            $url=  self::getControlerPath($parts);
	    Human::log("search controler in $url");
            if(file_exists($url)){
                
                $routeToController=implode("/",$parts);
                
		//controller class name
		$className=ucfirst($parts[count($parts)-1])."Controller";
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
                $controler->routeToController=$routeToController;
                $controler->routeToFunction=$routeToController."/".$fn;
                //check for the function inside the controller
		if(method_exists ( $controler, $fn )){
		    Human::log($controler, "controler function $fn found", Human::TYPE_WARN);
		    $controler->routeFunction=$fn;
		}else{
                    $controler->setHeader404();
                    $controler->routeFunction="default404";
		    Human::log("The function $fn doesn't exists", "controler error", Human::TYPE_ERROR);
		}
		
                //give parameters to the controller
		$controler->routeParams=$parts;
                $controler->setOutputType($ext);
		//echo $url."===>".$url."  class name===>".$className." function===>".$fn." params===>".implode(",",$parts);
		$controler->route=$savedRoute;
		return $controler;
		
                break;
            }	    
            array_pop($parts);
        }
        
        //if we are here we know that there is no controller for this route...

        return false;
    }
    /**
     * the page will have an header 404
     */
    public function setHeader404(){
        $this->headerCode=new Nerd_Header(Nerd_Header::ERR_404);
    }
    /**
     * The page will have an header 301 and will be redirected to $redirectUrl 
     */
    public function redirect301($redirectUrl){ 
        $this->headerCode=new Nerd_Header(Nerd_Header::REDIRECT_301, Site::url($redirectUrl,true));    
    }
    /**
     * The page will have an header 302 and will be redirected to $redirectUrl 
     */
    public function redirect302($redirectUrl){ 
        $this->headerCode=new Nerd_Header(Nerd_Header::REDIRECT_302, Site::url($redirectUrl,true));
    }

    /**
     * Define the outputType and the headerType. In fact it can be json or xml elsewhere it will be an html output.
     * @param string $extension something like json or xml
     */
    private function setOutputType($extension){
        
        switch ($extension){
            case self::OUTPUT_JSON:
                $this->outputType=$extension;
                $this->headerType=new Nerd_Header(Nerd_Header::JSON);
                break;
            
            case self::OUTPUT_XML:
                $this->outputType=$extension;
                $this->headerType=new Nerd_Header(Nerd_Header::XML);
                Human::log("set extension ".$extension);
                break;
            
           default:
                $this->outputType=self::OUTPUT_HTML;
                break;
        }
    }

    /**
     * process the controller with the current function and parameters.
     * @return View the resulting view object
     */
    public function run(){
        $view=call_user_func_array(array($this,$this->routeFunction), $this->routeParams);
        return $view;
    }
    
    
    /**
     * return the default 404 error page.
     *  
     */
    public function default404(){
        return new View("404",new VV_404());
    }
    

}
