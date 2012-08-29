<?php

/**
 * Description of doc
 *
 * @author David Marsalone
 */
class DocController extends Controller{
    
    
    public function index(){
        $view=new View("doc/index");
        return $view;
    }
    
}
