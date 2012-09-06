<?php

/**
 * Description of I_Need
 *
 * @author David Marsalone
 */
class GiveMe {
    /**
     *
     * @param string $url
     * @param bool $absolute put true here to get an absolute url starting with http://...
     * @return string will return you a well formated url 
     */
    public static function url($url,$absolute=false){
        return Site::url($url,$absolute);
    }
    
    
    public static function imageSized($url,$width,$height,$backgroundColor="000000",$format="jpg"){
        return self::url(ImageTools::sized($url, $width, $height, "noBorder", $format, $backgroundColor));
    }
    public static function imageSizedWithoutCrop($url,$width,$height,$backgroundColor="000000",$format="jpg"){
        return self::url(ImageTools::sized($url, $width, $height, "showAll", $format, $backgroundColor));
    }

}
