<?

class VV_doc_page extends ViewVariables{

    /**
     *
     * @var LayoutVariables
     */
    public $layout;
    
    /**
     *
     * @var string The url of the view template.
     * In the route, it will be the first param
     * In the view folder it will be _app/mvc/v/doc/pages/[$url].php 
     */
    public $url="";
    
    /**
     * 
     * @var string the name of the page
     */
    public $name="";
    
    /**
     *
     * @var type 
     */
    public $routeUrl;
    public $templateUrl;
    
    /**
     *
     * @var array 
     */
    public static $listOfPages=array();
    
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
        $page->name=str_replace("-", " ", $pageName);
        return $page;
    }
    



    /**
     * Usefull to build a menu.
     * @return VV_doc_page
     */
    public function getPages(){
        $pages[]=self::getPage("overview");
        $pages[]=self::getPage("learn");
        $pages[]=self::getPage("for-geeks");
        $pages[]=self::getPage("for-hipsters");
        return $pages;
    }

    
}

