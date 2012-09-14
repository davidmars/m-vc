<?php
/**
 * Here are publics statics to manage globals stuffs....
 * it is recommended to set this variables on a config file 
 *
 * @author david marsalone
 */
class Site {
    /**
     *
     * @var String the root path of your website starting with slash. This one is always visible on you url just fter your domain name.
     * @example /my-project-folder
     * @example /
     */
    public static $root="/";
 
    
    /**
     *
     * @var bool If set to true the non optimized urls will be redirected to the optimized one.  
     */
    public static $redirectToBestUrl=true;


    /**
     * @var String the host of your website.
     * Usefull to display hrefs or img src, etc... 
     */
    public static $host;
    /**
     * 
     * @var Bool is the website in debug mode or not? 
     */
    public static $debug=false;
    
    
    //----------------------app folders--------------------------
    
    /**
     * 
     * @var String For php use...where is your php project?
     */
    public static $appFolder="_app";
    /**
     * 
     * @var String For php use...where your models?
     */
    public static $appConfigFolder="_app/config";
    /**
     * 
     * @var String For php use...where your models?
     */
    public static $appModelsFolder="_app/mvc/m";
    /**
     * 
     * @var String For php use...where your view?
     */
    public static $appViewsFolder="_app/mvc/v";
    /**
     * 
     * @var String For php use...where are your controlers?
     */
    public static $appControllersFolder="_app/mvc/c";

    //----------------------system folders--------------------------  
    
    
    /**
     * 
     * @var String For php use...Hey Neo, where is the matrix?
     */
    public static $systemFolder="_system";
    /**
     * 
     * @var String For php use...core utilities are here.
     */
    public static $systemUtils="_system/utils";
    /**
     * 
     * @var String For php use...core libs are here.
     */
    public static $systemLibs="_system/libs";
    /**
     * 
     * @var String For php use...core libs are here.
     */
    public static $systemMVC="_system/mvc";
     /**
     * 
     * @var String For php use...where are the system controllers?
     */
    public static $systemControllersFolder="_system/mvc/c";
    
    //----------------------publics folders-------------------------- 
    
    /**
     *
     * @var string For php use...where is your public folder? 
     */
    public static $publicFolder="pub";
    /**
     *
     * @var string For php use...where are the media files? 
     */
    public static $mediaFolder="pub/media";
    /**
     *
     * @var string For php use...where are the cached files?
     */
    public static $cacheFolder="pub/media/cache";
    
    
   /**
     * Will analyze an url (a route by preference) and will return you an UrlInfos object.
     * @param string $url The url you want to analyze.
     * @return UrlInfos An object with informations about the url.
     */
    public static function urlInfos($url){
        $infos=new UrlInfos($url);
        return $infos;
    }
    
    /**
     *
     * @param string $url The local url you need to display.
     * @param bool $absolute If true the host will be added and your result will start with something like http://...
     * @param bool $preventErrors If set to true, the system will performs a test to be sure that the url is valid. 
     * If it is not valid the resulting url will look like
     * <code>#urlError(the-url-you-did-provide)</code>
     * <b>Warning</b> Asking it to the system is complex, so please ensure to use it with parsimony.
     * @return string return a coorect href to $url 
     */
    public static function url($url,$absolute=false,$preventErrors=false){
        $infos=self::urlInfos($url);
        if($preventErrors){
            if(!$infos->isValid()){
               return "#urlError($url)"; 
            } 
        }
        if($absolute){
            return $infos->urlAbsoluteOptimized;
        }else{
            return $infos->urlOptimized;
        }

    }

    
}
/**
 * 
 */
class UrlInfos{
    
     /**
     *
     * @param string $url 
     */
    public function __construct($url) {
	$this->url=$url;
        $this->run();
    }
    /**
     *
     * @return type 
     */
    public function run(){
        
        switch (true){
            case (preg_match('%^(https?://)%i',$this->url)): //absolute path...let's move we know all we have to know
                $this->isOutsideTheProject=true;
                $this->urlOptimized=$this->urlAbsolute=$this->urlAbsoluteOptimized=$this->url;
                return $this;
                break;
            case file_exists($this->url): //file exists
                $this->isRealFile=true;
                $this->urlOptimized=$this->url;
                break;
            case file_exists(Site::$publicFolder."/".$this->url): //file exists...in public folder
                $this->isRealFile=true;
                $this->url=$this->urlOptimized=$this->url=Site::$publicFolder."/".$this->url;
                break;
            default: //let's start to search for a route, here is the serious buisiness.
                
                $controller=Controller::getByRoute($this->url); //classic controller 
                if(!$controller){
                    $this->route=UrlControler::getRoute($this->url);
                    $controller=Controller::getByRoute($this->route);
                }
		if($controller){
		    $this->urlOptimized=UrlControler::getOptimizedUrl($controller->route);
		    $this->controller=$controller;
		}
                break;
        }

        $this->urlOptimized=Site::$root."/".$this->urlOptimized;
        $this->url="/".Site::$root."/".$this->url;
        $this->urlAbsolute=Site::$host.$this->url;
        $this->urlAbsoluteOptimized=Site::$host.$this->urlOptimized;
    }






    /**
     *
     * @var bool will be true if the url is a real file in the website.
     */
    public $isRealFile=false;
    /**
     *
     * @var bool will be true if the url can't be managed by the framework. 
     * In practice it will happens when the url belongs to an other website. 
     * It can happens if the host is not recognized or the root folder.
     */
    public $isOutsideTheProject=false;
    /**
     * Will be true if there is no error (like a 404 one) while processing the url.
     * <b>Note</b> that this is a function and not a property. This is designed like that for performance reasons.
     * 
     * It will return false if :
     * - The url belongs to a controller and this one return a 404 error. In most of cases, it's up to you to design it in the controller.
     * - The url belongs to a file and this file doesn't exist.
     * 
     * It will <b>ALWAYS</b> return true if :
     * - The url is outside the project
     * - The url is a real file
     * - The url belongs to a controller and this controller return no errors.
     * 
     * @return bool Will be true if there is no error (like a 404) while processing the url.  
     */
    public function isValid(){
	//real file or outside project...no problemo
	if($this->isRealFile || $this->isOutsideTheProject){
	    return true;
	}
        //no controller...well, it is broken for sure
	if(!$this->controller){
	    return false;
	}
	//here is the big deal. We run the controller to test it, so it can be complex and expensive.
	$this->controller->run();
	if($this->controller->headerCode->code==Nerd_Header::ERR_404){
	   return false;
	}
	return true;
    }
    /**
     *
     * @var string The internal route related to the controller
     */
    public $route="";
    /**
     *
     * @var string The url you did provide for this object 
     */
    public $url="";
    /**
     *
     * @var string The more beautifull url we found...okay "beauty" is a subjective concept. 
     * So it will be the first url matching your routes. 
     * And if not found, it will be the route itself. 
     */
    public $urlOptimized="";
    /**
     * 
     * @var string  The url with http://...
     */
    public $urlAbsolute="";
    /**
     *
     * @var string The optimized url with http://... 
     */
    public $urlAbsoluteOptimized="";
    /**
     *
     * @var Controller The controller that leads to the page.
     */
    public $controller=null;
    
    /**
     *
     * @return bool Will be true if  $_REQUEST["route"] (given by .htaccess) match to this object.
     */
    public function isCurrent(){
	$reqUrl=Site::urlInfos($_REQUEST["route"]);
	switch($reqUrl->route){
	    case $this->route:
	    case $this->url:
	    case $this->urlOptimized:
	    return true;
		
	default : 
	    return false;
	}
	
    }

}

?>
