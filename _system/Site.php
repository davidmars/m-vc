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
     * @return \UrlInfos 
     */
    public static function urlInfos($url){
        $infos=new UrlInfos();
        $infos->url=$infos->urlOptimized=$url;
        $infos->route=$url;
        
        switch (true){
            case (preg_match('%^(https?://)%i',$url)): //absolute path...let's move
                $infos->isOutsideTheProject=true;
                $infos->url=$infos->urlOptimized=$url;
                $infos->isValid=true;
                return $infos;
                break;
            case file_exists($url): //file exists
                $infos->isRealFile=true;
                $infos->isValid=true;
                break;
            case file_exists(Site::$publicFolder."/".$url): //file exists in public folder
                $infos->isRealFile=true;
                $infos->isValid=true;
                $infos->url=$infos->urlOptimized=$url=Site::$publicFolder."/".$url;
                break;
            default: //let's start to search for a route
                
                $controller=Controller::getByRoute($url); //classic controller 
                if(!$controller){
                    $infos->route=  UrlControler::getRoute($url);
                    $controller=Controller::getByRoute($infos->route);
                }
                if($controller){
                    $controller->run(); //here check if the controller is valid
                    if($controller->headerCode->code==Nerd_Header::ERR_404){
                        $controller=false;
                        
                    }
                }
                if(!$controller){
                    $infos->isValid=false;
                }else{
                    $infos->isValid=true;
                }
                $infos->urlOptimized=UrlControler::getOptimizedUrl($url);
                
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
     * @param String $url the local url you need to display
     * @param Bool $absolute if true the host will be added
     * @return String return a coorect href to $url 
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
        
        switch (true){
            case (preg_match('%^(https?://)%i',$url)): //absolute path...let's move
                return $url;
                break;
            case file_exists($url): //file exists
                break;
            case file_exists(Site::$publicFolder."/".$url): //file exists in public folder
                $url=Site::$publicFolder."/".$url;
                break;
            default: //let's start to search for a route
                $controller=Controller::getByRoute($url); //classic controller 
                if(!$controller){
                    $route=  UrlControler::getRoute($url);
                    $controller=Controller::getByRoute($route);
                }
                if($controller){
                    $controller->run(); //here check if the controller is valid
                    if($controller->headerCode->code==Nerd_Header::ERR_404){
                        $controller=false;
                    }
                }
                if(!$controller){
                    return "#urlError($url)"; //error
                }
                $url=UrlControler::getOptimizedUrl($url); //give me the best baby!
                break;
        }
        if($absolute){
            return self::$host.self::$root."/".$url;
        }else{
            return self::$root."/".$url;
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

class UrlInfos{
    /**
     *
     * @var bool will be true if the url is a real file in the website.
     */
    public $isRealFile=false;
    public $isOutsideTheProject=false;
    public $isCurrentUrl=false;
    public $isValid=false;
    public $route="";
    public $url="";
    public $urlOptimized="";
    public $urlAbsolute="";
    public $urlAbsoluteOptimized="";
    
    public function isCurrent(){

    }
}

?>
