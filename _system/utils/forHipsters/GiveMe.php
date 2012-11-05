<?php

/**
 * This collection of static methods, will be usefull to do common tasks in templates.
 *
 * @author David Marsalone
 */
class GiveMe {
    /**
     * Will return you a well formated url...<b>Use it</b> for all href src etc...
     * @param string $url The local url you need to display.
     * @param bool $absolute If true the host will be added and your result will start with something like http://...
     * @param bool $preventErrors If set to true, the system will performs a test to be sure that the url is valid. 
     * If it is not valid the resulting url will look like
     * <code>#urlError(the-url-you-did-provide)</code>
     * <b>Warning</b> Asking it to the system is complex, so please ensure to use it with parsimony.
     * @return string return a correct href to $url 
     */
    public static function url($url,$absolute=false,$preventErrors=false){
        return Site::url($url,$absolute);
    }

    /**
     * Will analyze an url (a route by preference) and will return an UrlInfos object.
     * @param string $url The url you want to analyze.
     * @return UrlInfos An object with informations about the url.
     */
    public static function urlInfos($url){
	return Site::urlInfos($url);
    }

    /**
     * @return string return the current url
     */
    public static function currentUrl() {
        $pageURL = 'http';
        if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
        $pageURL .= "://";
        if ($_SERVER["SERVER_PORT"] != "80") {
            $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
        } else {
            $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
        }

        return $pageURL;
    }
    
    /**
     * Will resize an image. The output image will fill the rectangle desinged by $width and $height. 
     * So the resulting output image will be probably cropped.
     * @param string $url The url of you original image.
     * @param int $width desired width for the outpouted image. May also be "auto".
     * @param int $height desired height for the outpouted image. May also be "auto".
     * @param string $backgroundColor the hexadecimal color for background (without # at the beginning)
     * @param string $format choose jpg or png
     * @return string An Url to display the resulting image.  
     */
    public static function imageSized($url,$width,$height,$backgroundColor="000000",$format="jpg"){
        return self::url(ImageTools::sized($url, $width, $height, "noBorder", $format, $backgroundColor));
    }
    /**
     * Will resize an image. The output image will fill fit the rectangle designed by $width and $height. 
     * It means that, the resulting output image will show the entire input image.
     * @param string $url The url of you original image.
     * @param int $width desired width for the outpouted image. May also be "auto".
     * @param int $height desired height for the outpouted image. May also be "auto".
     * @param string $backgroundColor the hexadecimal color for background (without # at the beginning)
     * @param string $format choose jpg or png
     * @return string An Url to display the resulting image.  
     */
    public static function imageSizedWithoutCrop($url,$width,$height,$backgroundColor="000000",$format="jpg"){
        return self::url(ImageTools::sized($url, $width, $height, "showAll", $format, $backgroundColor));
    }

    /**
     * @return string Will call the function to add a facebook like button on your blog
     */
    public static function socialFB(){
        return "<fb:like href='' send='true' layout='button_count' show_faces='false' width='200' font=''></fb:like>";
    }

    /**
     * @return string Will call the function to add a google plus button on your blog
     */
    public static function socialGoogle($url){
        return '<div class="item-google"><g:plusone href="'.$url.'" size="medium" count="false"></g:plusone></div>';
        //return '<div class="plusone"><g:plusone href="test" size="medium" count="false"></g:plusone></div>';
    }

    /**
     * @return string Will call the function to add a twitter share button on your blog
     */
    public static function socialTwitter($url){
        //return '<a class="twitter-share-button" href="http://twitter.com/share" data-url="" data-count="none" data-lang="en">Tweet</a>';
        return '<a href="http://twitter.com/share" data-url="'.$url.'" class="twitter-share-button" data-count="none" data-lang="fr">Tweet</a>';
    }
}
