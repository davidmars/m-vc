<?

class VV_doc_page extends ViewVariables{

    /**
     *
     * @var LayoutVariables
     */
    public $layout;
    
    
    /**
     * 
     * @var string the name of the page
     */
    public $name="";
    /**
     * 
     * @var string the page title like it is displayed
     */
    public $title="";
    
    /**
     *
     * @var string the route controler related to this page
     */
    public $routeUrl;
    /**
     *
     * @var string the path to the view for this page 
     */
    public $templateUrl;
    
    /**
     *
     * @var bool Will be set to true if this page is the current page. 
     */
    public $isActive=false;
    /**
     * Try to find a page.
     * @param string $pageName
     * @return VV_doc_page 
     */
    public static function getPage($pageName) {
        $page=new VV_doc_page();
        $page->name=$pageName;
        $page->layout->htmlHeader->title=$pageName;
        $page->routeUrl="doc/doc/index/".$pageName;
        $page->templateUrl="doc/pages/".$pageName;
        //checks if the page exists
        if(!View::isValid($page->templateUrl)){
            return false;
        }
        
        
        switch ($pageName){
            case "overview":
                $page->title="Overview";
                $page->sections[]=new VV_doc_page_section("What is it?",        "doc/pages/overview/what-is-it");
                
                $page->sections[]=new VV_doc_page_section("What does it do?");
                
                $page->sections[]=new VV_doc_page_section("Small & big websites",           "doc/pages/overview/download");
                $page->sections[]=new VV_doc_page_section("Custom Urls",   "doc/pages/overview/custom-url");
                $page->sections[]=new VV_doc_page_section("Easy & Flexible templates",   "doc/pages/overview/templates");
                $page->sections[]=new VV_doc_page_section("Image manipulations",          "doc/pages/overview/images");
                $page->sections[]=new VV_doc_page_section("Translations management",          "doc/pages/overview/translations");
                $page->sections[]=new VV_doc_page_section("HTML, XML or JSON outputs",          "doc/pages/overview/xml-json-outputs");
                $page->sections[]=new VV_doc_page_section("A good worflow",          "doc/pages/overview/workflow");
                
                $page->sections[]=new VV_doc_page_section("It cames with...");
                
                $page->sections[]=new VV_doc_page_section("jQuery",          "doc/pages/overview/jquery");
                $page->sections[]=new VV_doc_page_section("Twitter Bootstrap",          "doc/pages/overview/bootstrap");
                $page->sections[]=new VV_doc_page_section("Less CSS autocompilation",          "doc/pages/overview/less");
                $page->sections[]=new VV_doc_page_section("Google Analytics pre-configuration",          "doc/pages/overview/google-analytics");
                $page->sections[]=new VV_doc_page_section("Basic pages samples",          "doc/pages/overview/samples");
                $page->sections[]=new VV_doc_page_section("Php debug via console",          "doc/pages/overview/debug");
                break;
            
            case "install":              
                $page->title="Install";
                $page->sections[]=new VV_doc_page_section("1. Download",           "doc/pages/install/download");
                $page->sections[]=new VV_doc_page_section("2. Upload & configure",   "doc/pages/install/upload");
                $page->sections[]=new VV_doc_page_section("3. It works!",          "doc/pages/install/it-works");
                $page->sections[]=new VV_doc_page_section("No? let's fix it",          "doc/pages/install/not-working");
                
                $page->sections[]=new VV_doc_page_section("Author tools");
                $page->sections[]=new VV_doc_page_section("Debug php via browser console",          "doc/pages/install/debug");
                
                $page->sections[]=new VV_doc_page_section("Advanced configuration");
                
                $page->sections[]=new VV_doc_page_section("Changing the folders structure",          "doc/pages/install/changing-folders-structure");
                $page->sections[]=new VV_doc_page_section("Multiple domains management",          "doc/pages/install/multiple-domains");
                $page->sections[]=new VV_doc_page_section("Enabling / Disabling cache",          "doc/pages/install/disabling-cache");

                
                break;
            
            case "get-started":              
                $page->title="Get started";
                
                
                $page->sections[]=new VV_doc_page_section("Files structure",           "doc/pages/get-started/files-structure");
                
                $page->sections[]=new VV_doc_page_section("Let's practice");
                
                $page->sections[]=new VV_doc_page_section("1. Play with templates",          "doc/pages/get-started/");
                $page->sections[]=new VV_doc_page_section("2. Create your first controler",          "doc/pages/get-started/");
                $page->sections[]=new VV_doc_page_section("3. Let's beautify this url",          "doc/pages/get-started/");
                $page->sections[]=new VV_doc_page_section("4. Templates autocompletion",          "doc/pages/get-started/");
                $page->sections[]=new VV_doc_page_section("5. JSON & XML !",          "doc/pages/get-started/");
                
                $page->sections[]=new VV_doc_page_section();
                
                $page->sections[]=new VV_doc_page_section("Theory after practice");
                
                $page->sections[]=new VV_doc_page_section("What's happened?",          "doc/pages/get-started/");
                $page->sections[]=new VV_doc_page_section("File naming",          "doc/pages/get-started/");
                $page->sections[]=new VV_doc_page_section("View Variables are they necessary?",          "doc/pages/get-started/");
                
                break;
            
            case "for-nerds":              
                $page->title="For nerds";
                $page->sections[]=new VV_doc_page_section("MySql models");
                $page->sections[]=new VV_doc_page_section("Translations");
                //$page->sections[]=new VV_doc_page_section("Download",           "doc/pages/for-nerds/");
                //$page->sections[]=new VV_doc_page_section("Upload the files",   "doc/pages/overview/installation");
                //$page->sections[]=new VV_doc_page_section("Configure your folders",          "doc/pages/overview/installation");
                
                //$page->sections[]=new VV_doc_page_section("Advanced configuration");
                //$page->sections[]=new VV_doc_page_section("Configure your folders",          "doc/pages/overview/installation");
                break;
            
            case "for-hipsters": 
                
                $page->title="For Hipsters";
                $page->sections[]=new VV_doc_page_section("Introduction",           "doc/pages/for-hipsters/introduction");
  
                
                $page->sections[]=new VV_doc_page_section("Php side");
                $page->sections[]=new VV_doc_page_section("Playing with templates",          "doc/pages/for-hipsters/templates");
                $page->sections[]=new VV_doc_page_section("Displaying variables",          "doc/pages/for-hipsters/variables");
                $page->sections[]=new VV_doc_page_section("Images manipulation",          "doc/pages/for-hipsters/images");
                $page->sections[]=new VV_doc_page_section("Urls",          "doc/pages/for-hipsters/urls");
                
                $page->sections[]=new VV_doc_page_section("Javascript side");
                $page->sections[]=new VV_doc_page_section("The Main.js structure",          "doc/pages/for-hipsters/main.js");
                
                $page->sections[]=new VV_doc_page_section("CSS"); 
                $page->sections[]=new VV_doc_page_section("Classic Css",          "doc/pages/for-hipsters/classic-css");
                $page->sections[]=new VV_doc_page_section("Less Css!",          "doc/pages/for-hipsters/less-css");

                
                break;
        }
        
        return $page;
    }
    



    /**
     * Usefull to build the doc main menu. 
     * @param VV_doc_page $currentPage 
     * @return VV_doc_page The doc pages list
     */
    public function getPages($currentPage=null){
        $pageList=array("overview","install","get-started","for-nerds","for-hipsters");
        
        foreach($pageList as $p){
            $newOne=self::getPage($p);
            if($currentPage->routeUrl == $newOne->routeUrl){
                $newOne->isActive=true;
            }
            $pages[]=$newOne;
        }
        return $pages;
    }
    
    /**
     *
     * @var VV_doc_page_section List of sections in the page 
     */
    public $sections=array();

    
}

class VV_doc_page_section{
    
    public $title="";
    public $templatePath="";
    /**
    * @var bool If set to true, the section is a title section in the page
    */
    public $isHeader=false;           
    public $isSeparator=false;           


    /**
     *
     * @param string $title the section title
     * @param string $template the template path for this section in the page
     */
    public function __construct($title=null,$templatePath=null) {
        
        $this->title=$title;
        $this->templatePath=$templatePath;
        
        if(!$title){
            $this->isSeparator=true;
        }elseif(!$templatePath){
            $this->isHeader=true;
        }else{
            //$this->templatePath=$templatePath; 
        }
        
    }
}

