<?php

/**
 * Description of doc
 *
 * @author David Marsalone
 */
class DocController extends Controller{
    
    /**
     *
     * @param string $page the page to display
     * @return View
     */
    public function index($page=null){
        $vv=  VV_doc_page::getPage($page);        
        $view=new View($vv->templateUrl,$vv);
        return $view;
    }
    
}
