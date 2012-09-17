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

}
