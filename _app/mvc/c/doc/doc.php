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
        $vv=new VV_doc_page($params);
        $vv->layout->htmlHeader->title=$page;
        $view=new View("doc/index",$vv);
        return $view;
    }
    
}
