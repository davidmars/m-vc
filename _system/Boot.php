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

        self::includeFiles();

        //search for the correct controller, function and params
        Human::log($_REQUEST["route"],"At the begining it was the route param");

        
        $route=$_REQUEST["route"];
        
        //search for a native system route
        $controller=Controller::getByRoute($route);

        if(!$controller){
            //search for a special route designed in the UrlControler::$routes array
            $route=  UrlControler::getRoute($route);
            $controller=Controller::getByRoute($route);
        }
        
        //search for a better url
        if(Site::$redirectToBestUrl){
            //checks if there is not a better url
            if($controller){
                $optimizedUrl=UrlControler::getOptimizedUrl($route);
                if($_REQUEST["route"] != $optimizedUrl){
                    $header=new Nerd_Header(301, Site::url($route, $absolute));
                    $header->run();
                    echo "There is a better url !<br/>";
                    echo "Your request : ".$_REQUEST["route"]."<br/>";
                    echo "Best url : ".$optimizedUrl;
                    die();
                }
            }
        }
        
        //okay we loose...
        if(!$controller){
            $msg="There is no controller for this route : ".$route;
            Human::log($msg, "Route error", Human::TYPE_ERROR);
            die($msg); 
        }
        
        Human::log($controller->routeParams);
        $view=$controller->run();
        
        if($view){

            
            //headers from the controller 404,301,302...
            if($controller->headerCode){
                $controller->headerCode->run();
            }
             //headers from the controller json, xml...
            if($controller->headerType){
                $controller->headerType->run();
            }
            
            
            switch ($controller->outputType){
                case Controller::OUTPUT_JSON:
                    echo $view->viewVariables->json();
                    break;
                case Controller::OUTPUT_XML:
                    echo $view->viewVariables->xml();
                    break;
                default :
                    echo $view->render();
                    break;
            }  
        }else{
            die("error no view");
        }

        
    }
    /**
     * all what we need to auto include before starting 
     */
    private function includeFiles(){
        //system
        self::includeFilesInFolder(Site::$systemLibs);
        self::includeFilesInFolder(Site::$systemMVC);
        self::includeFilesInFolder(Site::$systemUtils);
        //app
        //self::includeFilesInFolder(Site::$appControllersFolder); //it is included when needed in fact.
        self::includeFilesInFolder(Site::$appModelsFolder); 
    }


    /**
    * Performs a test on the project config.
    * Launch it in the index file to test your config just after your Site::something config lines.
    * @return string test results in a html output.
    */
    public static function testConfig(){
        
        $l="";
        
        if("http://".$_SERVER["HTTP_HOST"]==Site::$host){
            $l.=self::logLine("Site::\$host and current domain match","green");
        }else{
            $l.=self::logLine("Site::host and current domain don't match","orange"); 
            $l.=self::logLine("It's just a warning, maybe your project is multidomain and it will work"); 
            $l.=self::logLine("http://".$_SERVER["HTTP_HOST"]." != ".Site::$host,"grey"); 
        }
        
        if($_SERVER["SCRIPT_NAME"]==Site::$root."/index.php"){
            $l.=self::logLine("Site::\$root and current folder match","green",true);
        }else{
            $l.=self::logLine("Site::\$root and current folder don't match","red",true); 
            $l.=self::logLine($_SERVER["SCRIPT_NAME"]." != ".Site::$root."/index.php","grey"); 
        }
        //

        $l.=self::testWritablesFolders();

        //var_dump($_SERVER);
        return $l;
        
        

    }
    private static function testWritablesFolders(){
        //we need tools....
        self::includeFile(Site::$systemUtils."/forGeeks/FileTools.php");

        $l=self::logLine("Tests on cache folders","black",true);
        //try to create the cache directory
        $created= FileTools::mkDirOfFile(Site::$cacheFolder."/test.txt");
        
        
        if($created){
            $l.=self::logLine("Site::\$cacheFolder exists","green");
        }else{
            $l.=self::logLine("Oooops...can't create ".Site::$cacheFolder.". Maybe try 777 chmod on this folder...","red");
        }

        //try to create a file in the cache folder

        $created=@file_put_contents(Site::$cacheFolder."/test.txt", "hello you!");
        if($created){
           $l.=self::logLine("Site::\$cacheFolder is writtable","green");
        }else{
           $l.=self::logLine("Site::\$cacheFolder is not writtable","red");
        }


        return $l;
    }


    private static function logLine($log,$color="grey",$newBlock=false){
        if($newBlock){
            $margin=" margin-top:20px; ";
        }
        return "<div style='color:$color; $margin '>$log</div>";
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

