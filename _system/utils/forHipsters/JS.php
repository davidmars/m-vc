<?php
class JS{
    
    /**
     * Will add the specified js file to the file list to include in the header
     * @param string $cssFileUrl a js file url
     */
    public static function addToHeader($cssFileUrl){
        $file=  GiveMe::url($cssFileUrl);
        self::$headerFiles[]=$file;
    }
    /**
     * Will add the specified js file to the file list to include after body
     * @param string $file a js file url
     */
    public static function addAfterBody($cssFileUrl){
        $file=  GiveMe::url($cssFileUrl);
        self::$afterBodyFiles[]=$file;
    }
    /**
     *
     * @var array The js file list to include in the header 
     */
    private static $headerFiles=array();
     /**
     *
     * @var array The js file list to include after body
     */
    private static $afterBodyFiles=array();
    
    /**
     *
     * @return string tags
     */
    public static function includeHeaderFiles(){
        $outp=self::getTags(self::$headerFiles);
        self::$headerFiles=array();
        return $outp;
    }
    /**
     *
     * @return string tags
     */
    public static function includeAfterBodyFiles(){
        $outp=self::getTags(self::$afterBodyFiles);
        self::$afterBodyFiles=array();
        return $outp;
    }
    /**
     *
     * @param type $javascriptFile You should understand what it is...no?
     * @return string  something like <script src=... 
     */
    public static function getTag($javascriptFile){
        return '<script src="'.$javascriptFile.'"></script>'."\n";
    }
    /**
     *
     * @param array $filesList
     * @return string a list of something like <script src=... 
     */
    public static function getTags($filesList){
        $outp="";
        foreach($filesList as $f){
            $outp.=self::getTag($f);
        }
        return $outp;
    }
}