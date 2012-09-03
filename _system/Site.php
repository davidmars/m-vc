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
     * @param String $url the local url you need to display
     * @param Bool $absolute if true the host will be added
     * @return String return a coorect href to $url 
     */
    public static function url($url,$absolute=false){
        $url=UrlControler::getOptimizedUrl($url);
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
    public static $host="http://david.de.shic.cc";
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
    public static $appModelsFolder="_app/mvc/m";
    /**
     * 
     * @var String For php use...where your view?
     */
    public static $appViewsFolder="_app/mvc/v";
    /**
     * 
     * @var String For php use...where your controlers?
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

?>
