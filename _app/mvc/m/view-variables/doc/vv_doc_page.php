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
        $page->layout->htmlHeader->title=$pageName;
        $page->routeUrl="doc/doc/index/".$pageName;
        $page->templateUrl="doc/pages/".$pageName;
        if(!View::isValid($page->templateUrl)){
            return false;
        }
        $page->name=str_replace("-", " ", $pageName);
        
        switch ($pageName){
            case "overview":
                $page->sections[]=new VV_doc_page_section("What is it?",        "doc/pages/overview/what-is-it");
                
                $page->sections[]=new VV_doc_page_section("Installation");
                $page->sections[]=new VV_doc_page_section("Download",           "doc/pages/overview/download");
                $page->sections[]=new VV_doc_page_section("Upload the files",   "doc/pages/overview/installation");
                $page->sections[]=new VV_doc_page_section("Configure your folders",          "doc/pages/overview/installation");
        }
        
        return $page;
    }
    



    /**
     * Usefull to build the doc main menu. 
     * @param VV_doc_page $currentPage 
     * @return VV_doc_page The doc pages list
     */
    public function getPages($currentPage=null){
        $pageList=array("overview","learn","for-geeks","for-hipsters");
        
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


    /**
     *
     * @param string $title the section title
     * @param string $template the template path for this section in the page
     */
    public function __construct($title,$templatePath=null) {
        $this->title=$title;
        if(!$templatePath){
            $this->isHeader=true;
        }else{
            $this->templatePath=$templatePath; 
        }
        
    }
}

