<?php


/**
 * Description of Less
 *
 * @author  david marsalone
 */
class Less {
    
    /**
     * Guess...
     * @var Less 
     */
    private static $current;

    /**
     *
     * @return Less using it will prevent to declare more than one Less instance.
     */
    private static function me() {
        if(self::$current){
            return self::$current;
        }else{
            return new Less();
        }
    }


    /**
     *
     * @var lessc the wonderfull & glorious php less compiler 
     */
    private static $less;
    /**
     * where to put the output files
     */
    public static $outputPath="media/less-css/";


    public function __construct() {
        
        self::$current=$this;
        self::$less=new lessc();
        self::$less->setPreserveComments(true);
    }
    /**
     * 
     * @param String $inputFile the path to the less file you want to compile.
     * @param String $outputFile the path to the css file you want as result.
     * @return String the path to the result css file
     */
    public function compile ($inputFile,$outputFile,$variables=array()){
        
        try {
            $outputFile=$outputFile.".css";
            $inputFile=$inputFile.".less";
            FileTools::mkDirOfFile($outputFile);
            
            // load the cache
            $cacheFile = $outputFile.".cache";

            if (file_exists($cacheFile)) {
                $cache = unserialize(file_get_contents($cacheFile));
            } else {
                $cache = $inputFile;
            }

            $less = self::$less;
            $less->setVariables($variables);
            $newCache = $less->cachedCompile($cache);
            if (!is_array($cache) || $newCache["updated"] > $cache["updated"]) {
                Human::log(Site::url($outputFile, true),"Less new style sheet");
                file_put_contents($cacheFile, serialize($newCache));
                file_put_contents($outputFile, $newCache['compiled']);
            }else{
                 
            }
            
            return $outputFile;
            
        } catch (exception $e) {
            echo "fatal error: " . $e->getMessage();
            die();
        }
    }
    
    public static function getIncludeTag($lessFile,$variables=array()){
        $outputFile=  self::$outputPath.$lessFile."-".md5(implode("-", $variables));
        $path=Site::$root."/".self::me()->compile($lessFile, $outputFile,$variables);
        return "<link type=\"text/css\" rel=\"stylesheet\" href=\"".$path."\"/>";
    }
}

