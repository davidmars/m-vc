<?
/**
 * Doc pages are pages for the framework documentation. 
 */
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
     * @var bool Will be set to true if this page is the current page. 
     */
    public $isActive=false;

    /**
     * Will help you to build the doc main menu. 
     * @param VV_doc_page $currentPage 
     * @return VV_doc_page The doc pages list
     */
    public function getPages($currentPage=null){
        
        $pages=array();
        
        //static pages
        $pageList=array("overview","install","get-started","for-nerds","for-hipsters");
        foreach($pageList as $p){
            $newOne=VV_doc_static::getPage($p);
            if($currentPage->routeUrl == $newOne->routeUrl){
                $newOne->isActive=true;
            }
            $pages[]=$newOne;
        }
        
        //api reference...works differently
        $apiReference=new VV_doc_page();
        $apiReference->title="Live doc";
        $apiReference->routeUrl="doc/doc/classDefinition/GiveMe";
        $urlInfos=Site::urlInfos($apiReference->routeUrl);
        if(preg_match("/doc\/doc\/classDefinition/", UrlInfos::$current->route)){
            $apiReference->isActive=true;
        }
        $pages[]=$apiReference;
        return $pages;
    }
    


    
}



