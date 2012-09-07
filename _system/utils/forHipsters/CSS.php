<?php
class CSS{
    
    /**
     * Will add the specified css file to the file list to include
     * @param string $file a css file url
     */
    public static function addToHeader($cssFileUrl){
        $file=  GiveMe::url($cssFileUrl);
        self::$headerFiles[]=$file;
    }
    /**
     *
     * @var array The css file list to include in the header 
     */
    public static $headerFiles=array();
    
    /**
     *
     * @return string tags
     */
    public static function includeHeaderFiles(){
        $outp="";
        foreach(self::$headerFiles as $f){
            $outp.='<link rel="stylesheet" href="'.$f.'">\n';
        }
        self::$headerFiles=array();
        return $outp;
    }
}