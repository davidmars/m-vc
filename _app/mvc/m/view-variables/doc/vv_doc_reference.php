<?php

class VV_doc_reference extends ViewVariables{
    /**
     * process complex actions like parsing the fmk folders to get the main structure. 
     */
    public function run(){
        $this->appControllers=self::browseFolder(Site::$appControllersFolder);
        $this->appModels=self::browseFolder(Site::$appModelsFolder);
        //so here $classesFiles is complete!
    }
    /**
     *
     * @var array keys are class names and values are file paths to the php file that contains the file. It helps to autoload classes. 
     */
    public static $classesFiles=array();
    
    /**
     *
     * @param string $folder
     * @param bool $recursive
     * @return array a tree array each entry can have the following properties :
     * type that can be file or folder
     * name the file name
     * file the path to the file
     * content which is an array of other entries like the current one 
     */
    private static function browseFolder($folder,$recursive=true){
        $folders=array();
        $files=array();
        if ($handle = opendir($folder)) {
            while (false !== ($entry = readdir($handle))) {
                $abs=$folder."/".$entry;
                if ($entry != "." && 
                    $entry != ".." &&
                    is_file($abs) && 
                    file_exists($abs) && 
                    FileTools::extension($abs)=="php") 
                    {
                        $classes=DocParser::file_get_php_classes($abs);
                        foreach($classes as $class){
                            self::$classesFiles[$class]=$abs;
                            $files[]=array(
                                "type"=>"file",
                                "name"=>$class
                            );  
                        }

                }else if($recursive && $entry != "." && $entry != ".." && is_dir($abs)){
                    
                    $folders[]=array(
                        "type"=>"folder",
                        "name"=>$entry,
                        "file"=>$abs,
                        "content"=>array()
                        );
                }
            }
            closedir($handle);
        }
        //loads the classes subfolders after (manage extends)
        for($i=0;$i<count($folders);$i++){
            $folders[$i]["content"]=self::browseFolder($folders[$i]["file"], $recursive);
        }
        
        return array_merge($files,$folders);
    }
    

    
    
    
}
