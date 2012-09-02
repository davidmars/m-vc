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

    
}

