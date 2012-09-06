<?php

/**
 * Description of home
 *
 * @author david marsalone
 */
class HomeController extends Controller {
    
    	public function index($param1=null,$param2=null)
	{
            
            //if too much arguments redirect to the best page url
            if(func_num_args()>2){
                $this->redirect302($this->routeToFunction."/$param1/$param2");
            }
            
            $vv=new VV_fmk_page();
            $vv->htmlHeader=new VV_html_header();
            $vv->htmlHeader->author="you@you.com";
            $vv->htmlHeader->title="Hello world";
            $vv->param1=$param1;
            $vv->param2=$param2;
            $vv->title="Hello world";
            $view=new View("home", $vv);
            return $view;
	}
    	
}

