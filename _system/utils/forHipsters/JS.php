<?php
class JS{
    
    /**
     * Will add the specified js file to the file list to include in the header
     * @param string $cssFileUrl a js file url
     */
    public static function addToHeader($jsFileUrl){
        $file=  GiveMe::url($jsFileUrl,true);
        self::$headerFiles[]=$file;
    }
    /**
     * Will add the specified js file to the file list to include after body
     * @param string $file a js file url
     */
    public static function addAfterBody($jsFileUrl){
        $file=  GiveMe::url($jsFileUrl,true);
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
    public static function includeHeaderFiles($compress=true){

        $outp='';
        $names=array();
        $targetDir=Site::$mediaFolder."/cache/js/";
        
        //if no file added
        if(empty(self::$headerFiles)){return false;}
        
        //if compression
        if($compress){
            //check if file exists
            foreach(self::$headerFiles as $f){
                $names[]=FileTools::filename($f);
            }
            $name='script'.md5(implode('-',$names)).'.js';
            $targetUrl = $targetDir.$name;
            if(  !file_exists($targetUrl) || 
                 (file_exists($targetUrl) && filemtime($targetUrl)<time())
               ){
            
            //if file doesn't exist or exists but is too old: create
                foreach(self::$headerFiles as $f){
                    $c=file_get_contents($f);
                    $packer = new JavaScriptPacker($c, 'Normal', true, false);
                    $outp .= $packer->pack();
                }

                FileTools::mkDirOfFile($targetUrl);
                file_put_contents($targetUrl, $outp);
                $outp=self::getTag(GiveMe::url($targetUrl));
                
                self::$headerFiles=array();
                return $outp;
            } else {
                self::$headerFiles=array();
                return self::getTag(GiveMe::url($targetUrl));
            }
        } else {
            //if no compression
            $outp=self::getTags(self::$headerFiles);
            self::$headerFiles=array();
            return $outp;
        }
        
    }
    /**
     *
     * @return string tags
     */
    public static function includeAfterBodyFiles($compress=true){
        $outp='';
        $names=array();
        $targetDir=Site::$mediaFolder."/cache/js/";

        
        //if no file added
        if(empty(self::$afterBodyFiles)){return false;}
        
        //if compression
        if($compress){
            //check if file exists
            foreach(self::$afterBodyFiles as $f){
                $names[]=FileTools::filename($f);
            }
            
            $name='script'.md5(implode('-',$names)).'.js';
            $targetUrl=$targetDir.$name;
            
            if(  !file_exists($targetUrl) || 
                 (file_exists($targetUrl) && filemtime($targetUrl)<time())
               ){
            
                //if file doesn't exist or exists but is too old: create
                foreach(self::$afterBodyFiles as $f){
                    $c=file_get_contents($f);
                    $packer = new JavaScriptPacker($c, 'Normal', true, false);
                    $outp .= $packer->pack();
                }
                //create file
                FileTools::mkDirOfFile($targetUrl);
                file_put_contents($targetUrl, $outp);
                $outp=self::getTag(GiveMe::url($targetUrl));
                
                self::$afterBodyFiles=array();
                return $outp;
            } else {
                self::$afterBodyFiles=array();
                return self::getTag(GiveMe::url($targetUrl));
            }
        } else {
            //if no compression
            $outp=self::getTags(self::$afterBodyFiles);
            self::$afterBodyFiles=array();
            return $outp;
        }
    }
    /**
     *
     * @param type $javascriptFile You should understand what it is...no?
     * @return string  something like <script src=... 
     */
    public static function getTag($javascriptFile){
        return '<script src="'.  $javascriptFile.'"></script>'."\n";
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