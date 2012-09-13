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
     * Will analyze an url (a route by preference) and will return you an UrlInfos object.
     * @param string $url The url you want to analyze.
     * @return UrlInfos An object with informations about the url.
     */
    public static function urlInfos($url){
        $infos=new UrlInfos();
        $infos->url=$infos->urlOptimized=$url;
        $infos->route=$url;
        
        switch (true){
            case (preg_match('%^(https?://)%i',$url)): //absolute path...let's move we know all we have to know
                $infos->isOutsideTheProject=true;
                $infos->url=$infos->urlOptimized=$url;
                $infos->isValid=true;
                return $infos;
                break;
            case file_exists($url): //file exists
                $infos->isRealFile=true;
                $infos->isValid=true;
                break;
            case file_exists(Site::$publicFolder."/".$url): //file exists...in public folder
                $infos->isRealFile=true;
                $infos->isValid=true;
                $infos->url=$infos->urlOptimized=$url=Site::$publicFolder."/".$url;
                break;
            default: //let's start to search for a route, here is the serious buisiness.
                
                $controller=Controller::getByRoute($url); //classic controller 
                if(!$controller){
                    $infos->route=UrlControler::getRoute($url);
                    $controller=Controller::getByRoute($infos->route);
                }
		if($controller){
		    $infos->urlOptimized=UrlControler::getOptimizedUrl($controller->route);
		    $infos->controller=$controller;
		}
                break;
        }

        $infos->urlOptimized=self::$root."/".$infos->urlOptimized;
        $infos->url=self::$root."/".$infos->url;
        $infos->urlAbsolute=self::$host.$infos->url;
        $infos->urlAbsoluteOptimized=self::$host.$infos->urlOptimized;
        
        return $infos;

    }
    
    /**
     *
     * @param string $url the local url you need to display
     * @param bool $absolute if true the host will be added
     * @return string return a coorect href to $url 
     */
    public static function url($url,$absolute=false){
        
        $infos=self::urlInfos($url);
        if(!$infos->isValid){
            return "#urlEroor($url)";
        }
        if($absolute){
            return $infos->urlAbsoluteOptimized;
        }else{
            return $infos->urlOptimized;
        }

    }
    
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
    
    


    
}
/**
 * 
 */
class UrlInfos{
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
     * @return bool Will be true if there is no error (like a 404 one) while processing the url.  
     */
    public function isValid(){
	//fichier no problemo
	if($this->isRealFile || $this->isOutsideTheProject){
	    return true;
	}
	if(!$this->controller){
	    return false;
	}
	
	$this->controller->run();
	if($this->controller->headerCode->code==Nerd_Header::ERR_404){
	   return false;
	}
	return true;
	
    }
    /**
     *
     * @var string The internal route to display 
     */
    public $route="";
    public $url="";
    public $urlOptimized="";
    public $urlAbsolute="";
    public $urlAbsoluteOptimized="";
    /**
     *
     * @var Controller 
     */
    public $controller=null;
    
    /**
     *
     * @return bool Can will be true if  $_REQUEST["route"] (given by htaccess) belongs to this object.
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
    
    public function __construct() {
	
    }
}

?>
