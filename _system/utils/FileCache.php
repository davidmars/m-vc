<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FileCache
 *
 * @author david marsalone
 */
class FileCache {
    
    /**
     * 
     * @var String where to find the file in local file system
     */
    public $localUrl="";
    /**
     *  
     * @var Bool  will be true if the file didn't exist.
     */
    public $isNew=false;
    /**
     * 
     * @var Bool Well...will be true if the file has been refreshed
     */
    public $hasBeenRefreshed=false;
    /**
     *
     * @var String the distant URL of the file 
     */
    public $originalUrl="";



    /**
     *
     * @var Array[FileCache] list of calls to FileCache. Element 
     */
    public static $logs=array();
    
    
    public function __construct($url,$refreshSeconds=0) {
        $this->localUrl=self::getLocalUrl($url);
        $this->originalUrl=$url;

        $needToDownload=false;

        if(!file_exists($this->localUrl)){
           $needToDownload=true;
           $this->isNew=true;
        }else if($refreshSeconds!=0){
            if(time()-date("U",filemtime($this->localUrl))>$refreshSeconds){
                $needToDownload=true;
            }
        }

        if($needToDownload){
            $content=file_get_contents($this->originalUrl);
            self::save($content, $this->localUrl);
            $this->hasBeenRefreshed=true;
        }

        self::$logs[]=$this;
    }

    /**
     * Return a local url for the specified url
     * @param String $url
     * @return String 
     */
    private static function getLocalUrl($url){
        $parse=  parse_url($url);
            $host=$parse["host"]?$parse["host"]:"_";


            $path=$parse["path"]?$parse["path"]:"_";

        return "media/FileCache/".$host."".$path."/".md5($url);
    }
    /**
     * Return a local file url for the specified url. If the file is not in cache, it will first download the file to store it for the further calls.
     * @param String $url the remote url
     * @param Int $refreshSeconds the maximum time cache for the file
     * @return String
     */
    public static function getFile($url,$refreshSeconds=0){
        $f=new FileCache($url,$refreshSeconds);
        return $f->localUrl;
    }

    public static function remove($url){
       $localUrl=self::getLocalUrl($url);
       unlink($localUrl);
    }

    private static function save($content,$fileName){
        self::mkDirOfFile($fileName);
        file_put_contents($fileName, $content);
        chmod($fileName, 0777);
    }
    

    /**
     * Crée les répertoires et sous répertoire contenant $fileUrl
     * @param String $fileUrl url complete du fichier dont il faut éventuellement créer les répertoires conteneurs
     */
    static function mkDirOfFile($fileUrl){
            $splitted=explode("/",$fileUrl);
            $dir="";
            while(count($splitted)>1){
                    $newFolder=array_shift($splitted);
                    $dir=$dir.$newFolder;
                    if(!is_dir($dir)){
                            mkdir( $dir , 0777 , true );
                            chmod($dir, 0777);
                    }
                    $dir.="/";
            }
    }


}




