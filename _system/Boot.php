<?php

/**
 * Manage the whole application startup except index.
 *
 * @author david marsalone
 */
class Boot {
    
    /**
     *
     * @var array Lis of yet included files. 
     */
    private static $yetIncluded=array();
    
    /**
     * Prepare and check some stuff before booting.  
     */
    public static function preBoot(){
        require_once '_system/Site.php'; //by default it should works, if you change the _system folder location, you will have to change this line.
        
        //define the root folder
        if(isset($_REQUEST["rootFolder"])){
            //given by .htaccess
           Site::$root=$_REQUEST["rootFolder"]; 
        }else{
            //no...ok we should be in the setup
           Site::$root=str_replace("/setup.php", "", $_SERVER["REQUEST_URI"]);
        }
        
        $s = empty($_SERVER["HTTPS"]) ? '' : ($_SERVER["HTTPS"] == "on") ? "s" : "";
        $protocol = substr(strtolower($_SERVER["SERVER_PROTOCOL"]), 0, strpos(strtolower($_SERVER["SERVER_PROTOCOL"]), "/")) . $s;
        $port = ($_SERVER["SERVER_PORT"] == "80") ? "" : (":".$_SERVER["SERVER_PORT"]);
        Site::$host= $protocol . "://" . $_SERVER['SERVER_NAME'] . $port;
        
        
        
    }
    
    

    
    /**
     * It boots...the system. 
     */
    public static function theSystem(){  
        
        //includes
        self::includeFiles();
        self::bootModels();

        //search for the correct controller, function and params
        Human::log($_REQUEST["route"],"POV Boot - At the begining it was the route param");
        
        $infos=new UrlInfos($_REQUEST["route"]);
        UrlInfos::$current=$infos;
        $controller=$infos->controller;
	
	if($controller){
	    if(Site::$root."/".$_REQUEST["route"] != $infos->urlOptimized){ //best url found
		$header=new Nerd_Header(301, $infos->urlAbsoluteOptimized);
		$header->run();
		echo "There is a better url !<br/>";
		echo "Your request : ".$_REQUEST["route"]."<br/>";
		echo "Best url : ".$infos->urlAbsoluteOptimized;
		die();
	    }
	}else {
	    //okay we loose...
            $msg="There is no controller for this route : ".$route;
            Human::log($msg, "POV Boot Route error", Human::TYPE_ERROR);
            die($msg); 
        }
        
        $view=$controller->run();
        
        Human::log(DbConnection::$numberOfRequest,"POV Boot Number of requests");
        
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
    private static function includeFiles(){
        //system libs
        self::includeFile(Site::$systemLibs."/ChromePhp.php");
        self::includeFile(Site::$systemLibs."/lessc.inc.php");
        self::includeFile(Site::$systemLibs."/JavaScriptPacker.php");
        self::includeFile(Site::$systemLibs."/cssMin.php");
        //self::includeFile(Site::$systemLibs."/minify/JSMin.php");
        //self::includeFile(Site::$systemLibs."/minify/Minify/YUICompressor.php");
        //self::includeFile(Site::$systemLibs."/PHPthumb/ThumbLib.inc.php");
        self::includeFilesInFolder(Site::$systemUtils);
        self::includeFilesInFolder(Site::$appConfigFolder);
        //system FMK
        self::includeFilesInFolder(Site::$systemMVC);
        
        //app
        //self::includeFilesInFolder(Site::$appControllersFolder); //it is included when needed in fact.
        self::includeFilesInFolder(Site::$appModelsFolder); 
        
        //javascript and css modules
        //self::includeFilesInFolder(Site::$publicFolder); 
    }
    /**
     * boot the models
     */
    private static function bootModels(){
        foreach (get_declared_classes() as $cl){
            if(in_array("M_",class_parents($cl))){
                M_::initModel($cl);
                M_::$allNames[]=$cl;
            }
        }
    }
    
    /**
     *
     * @var boolean will be set to true if testCongFunction did work.
     */
    public static $testSuccess=null;
    
    /**
    * Performs a test on the project config.
    * Launch it in the index file to test your config just after your Site::something config lines.
    * @return string test results in a html output.
    */
    
    
    public static function testConfig(){
        self::$testSuccess=true;
        $l="";
        
        if("http://".$_SERVER["HTTP_HOST"]==Site::$host){
            //$l.=self::logLine("Site::\$host and current domain match","grey");
        }else{
            $l.=self::logLine("Site::host and current domain don't match","orange"); 
            $l.=self::logLine("It's just a warning, maybe your project is multidomain and it will work"); 
            $l.=self::logLine("http://".$_SERVER["HTTP_HOST"]." != ".Site::$host,"grey"); 
        }
        
        if($_SERVER["SCRIPT_NAME"]==Site::$root."/index.php"
                ||
           $_SERVER["SCRIPT_NAME"]==Site::$root."/setup.php"     
                ){
            //$l.=self::logLine("Site::\$root (".Site::$root.") and current folder match","grey");
        }else{
            $l.=self::logLine("Site::\$root and current folder don't match","red",true); 
            $l.=self::logLine($_SERVER["SCRIPT_NAME"]." != ".Site::$root."/index.php","grey"); 
        }
        //

        $l.=self::testWritablesFolders();
        if(self::$testSuccess){
           $l.=self::logLine("Everithing is ok","green");  
        }else{
            
        }
        //var_dump($_SERVER);
        return $l;
        
        

    }
    private static function testWritablesFolders(){
        //we need tools....
        self::includeFile(Site::$systemUtils."/forNerds/FileTools.php");

        //$l=self::logLine("Tests on cache folders","black",true);
        //try to create the cache directory
        $created= FileTools::mkDirOfFile(Site::$cacheFolder."/test.txt");
        
        
        if($created){
            //$l.=self::logLine("Site::\$cacheFolder exists","green");
        }else{
            $l.=self::logLine("Oooops...can't create ".Site::$cacheFolder.". Maybe try 777 chmod on this folder...","grey");
            self::$testSuccess=false;
        }

        //try to create a file in the cache folder

        $created=@file_put_contents(Site::$cacheFolder."/test.txt", "hello you!");
        if($created){
           //$l.=self::logLine(Site::$cacheFolder." is writtable","green");
        }else{
          $folder="http://".$_SERVER["HTTP_HOST"]."/".Site::$publicFolder."/media";
           $l.=self::logLine("The folder $folder is not writtable and it is a problem...don't worry, it's easy to solve it.","red");
           $l.=self::logLine("You NEED to set the ".$folder." folder in 777 mode","red");
           $l.=self::logLine("If you don't know how to do it, 
               this page will help you: <a target='_blank' href='http://www.stadtaus.com/en/tutorials/chmod-ftp-file-permissions.php'>http://www.stadtaus.com/en/tutorials/chmod-ftp-file-permissions.php</a>","red");
           $l.=self::logLine("You did it? Well, refresh this page, everything should be green...","black",true);
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
        $folders=array();
        if ($handle = opendir($folder)) {
            while (false !== ($entry = readdir($handle))) {
                $abs=$folder."/".$entry;
                if ($entry != "." && $entry != ".." && is_file($abs) && file_exists($abs)) {
                    self::includeFile($abs);
                }else if($recursive && $entry != "." && $entry != ".." && is_dir($abs)){
                    $folders[]=$abs;
                }
            }
            closedir($handle);
        }
        //loads the classes subfolders after (manage extends)
        foreach($folders as $f){
            self::includeFilesInFolder($f, $recursive);
        }
    }
    /**
     * returns all the folders and subfolders where is is possible to include a php file 
     */
    public static function getAllIncludePaths($folder,$recursive=true){
        $folders=array();
        if ($handle = opendir($folder)) {
            while (false !== ($entry = readdir($handle))) {
                $abs=$folder."/".$entry;
                if($recursive && $entry != "." && $entry != ".." && is_dir($abs)){
                    $folders[]=$abs;
                    $subFolders=self::getAllIncludePaths($abs,$recursive);
                    $folders=  array_merge($folders, $subFolders);
                }
            }
            closedir($handle);
        }
        return $folders;
    }
}

function __autoload($class_name) {

	$class_name = trim($class_name);
        $includePaths=array();
	$includePaths = Boot::getAllIncludePaths(Site::$systemMVC."/m");
        //$includePaths=array_merge($includePaths, Boot::getAllIncludePaths(Site::$appModelsFolder));
        $includePaths=array_merge($includePaths, Boot::getAllIncludePaths(Site::$systemFolder));
	
	$ext = ".php";
	
	foreach($includePaths as $include){
		
		$path = $include . "/" . $class_name . $ext ;
		//echo $path."<br/>";
		if(file_exists( $path )){
			//echo $path."<br/>";
			require_once($path);
			return;
		}
	}
	//echo join(",",$includePaths);
}








Boot::preBoot();