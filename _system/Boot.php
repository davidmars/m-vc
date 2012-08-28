<?php

/**
 * Manage the whole application startup except index.
 *
 * @author david marsalone
 */
class Boot {
    
    private static $yetIncluded=array();

    /**
     * It boot...the system. 
     */
    public static function theSystem(){
        
        //system
        self::includeFilesInFolder(Site::$systemLibs);
        self::includeFilesInFolder(Site::$systemMVC);
        self::includeFilesInFolder(Site::$systemUtils);
        //app
        //self::includeFilesInFolder(Site::$appControlersFolder); //it is included when needed in fact.
        self::includeFilesInFolder(Site::$appModelsFolder);
        
    }

    public static function includeFile($file){
        if(!self::$yetIncluded[$file] && pathinfo($file, PATHINFO_EXTENSION)=="php"){
            require_once($file);
            self::$yetIncluded[$file]=true;
        }
    }
    public static function includeFilesInFolder($folder,$recursive=true){
        if ($handle = opendir($folder)) {
            while (false !== ($entry = readdir($handle))) {
                $abs=$folder."/".$entry;
                if ($entry != "." && $entry != ".." && is_file($abs) && file_exists($abs)) {
                    self::includeFile($abs);
                }else if($recursive && $entry != "." && $entry != ".." && is_dir($abs)){
                    self::includeFilesInFolder($abs, true);
                }
            }
            closedir($handle);
        }
    }
}

?>
