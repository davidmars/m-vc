<?php

/**
 * This collection of static methods, will be usefull to do common tasks in templates.
 *
 * @author David Marsalone
 */
class GiveMe {
    /**
     *
     * @param string $url The url you want to get optimized or checked.
     * @param bool $absolute put true here to get an absolute url starting with http://...
     * @return string will return you a well formated url 
     */
    public static function url($url,$absolute=false){
        return Site::url($url,$absolute);
    }

    /**
     * Will analyze an url (a route by preference) and will return you an UrlInfos object.
     * @param string $url The url you want to analyze.
     * @return UrlInfos An object with informations about the url.
     */
    public static function urlInfos($url){
	return Site::urlInfos($url);
    }
    
    /**
     * Will resize an image. The output image will fill the rectangle desinged by $width and $height. So the resulting output image will be probably cropped.
     * @param string $url The url of you original image.
     * @param int $width desired width for the outpouted image. May also be "auto".
     * @param int $height desired height for the outpouted image. May also be "auto".
     * @param string $backgroundColor the hexadecimal color for background (without # at the beginning)
     * @param type $format choose jpg or png
     * @return string An Url to display the resulting image.  
     */
    public static function imageSized($url,$width,$height,$backgroundColor="000000",$format="jpg"){
        return self::url(ImageTools::sized($url, $width, $height, "noBorder", $format, $backgroundColor));
    }
    public static function imageSizedWithoutCrop($url,$width,$height,$backgroundColor="000000",$format="jpg"){
        return self::url(ImageTools::sized($url, $width, $height, "showAll", $format, $backgroundColor));
    }

}
