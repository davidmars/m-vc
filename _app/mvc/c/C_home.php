<?php

/**
 * Description of home
 *
 * @author david marsalone
 */
class C_home extends Controller {
        /**
         * This is the home page.
         * @param string $param1 The first parameter that can be displayed
         * @param string $param2 The second parameter that can be displayed
         * @return \View 
         */
    	public function index($param1=null,$param2=null)
	{
            $c=new C_home();
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
            $c->resultView=new View("home", $vv);
            return $c;
	}
    	
}

