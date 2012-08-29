<?php

/**
 * Manage the whole application startup except index.
 *
 * @author david marsalone
 */
class Boot {
    
    private static $yetIncluded=array();
    
    
    /**
     * It boots...the system. 
     */
    public static function theSystem(){
        
        
        
        //system
        self::includeFilesInFolder(Site::$systemLibs);
        self::includeFilesInFolder(Site::$systemMVC);
        self::includeFilesInFolder(Site::$systemUtils);
        //app
        //self::includeFilesInFolder(Site::$appControlersFolder); //it is included when needed in fact.
        self::includeFilesInFolder(Site::$appModelsFolder);
        
        //search for the correct controller, function and params
        Human::log($_REQUEST["route"],"At the begining it was the route param");

        $route=$_REQUEST["route"];
        $controller=Controler::getByRoute($route);

        Human::log($controller->routeParams);
        $view=$controller->run();

        if($view){
            switch ($controller->outputType){
                case Controler::OUTPUT_JSON:
                    Header::json();
                    echo $view->viewVariables->json();
                    break;
                case Controler::OUTPUT_XML:
                    Header::xml();
                    echo $view->viewVariables->xml();
                    break;
                default :
                    echo $view->render();
                    break;
            }  
        }else{
            die("error in index");
        }

        
    }
    
    /**
     * performs a test on the configuration. 
     */
    public static function testConfig(){
        
        $l="";
        
        if("http://".$_SERVER["HTTP_HOST"]==Site::$host){
            $l.=self::logLine("Site::\$host and current domain match","green");
        }else{
            $l.=self::logLine("Site::host and current domain don't match","red"); 
            $l.=self::logLine("http://".$_SERVER["HTTP_HOST"]." != ".Site::$host,"grey"); 
        }
        
        if($_SERVER["SCRIPT_NAME"]==Site::$root."/index.php"){
            $l.=self::logLine("Site::\$root and current folder match","green");
        }else{
            $l.=self::logLine("Site::\$root and current folder don't match","red"); 
            $l.=self::logLine($_SERVER["SCRIPT_NAME"]." != ".Site::$root."/index.php","grey"); 
        }
        var_dump($_SERVER);
        return $l;
        
        
//die($_SERVER["HTTP_HOST"]." vs ".Site::$host);
    }
    private static function logLine($log,$color="grey"){
        return "<span style='color:$color;'>$log</span><br>";
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

