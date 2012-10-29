<?php

/**
 * Description of home
 *
 * @author david marsalone
 */
class C_err404 extends Controller {
    
    	public function index($param1=null)
	{
            $c=new C_err404();
            
            $vv=new VV_fmk_page();
            $vv->htmlHeader=new VV_html_header();
            $vv->htmlHeader->author="you@you.com";
            $vv->htmlHeader->title="This is a 404";
            $vv->param1=$param1;
            $this->setHeader404();
            $vv->title="Wooops...this is a 404 error page.";
            $c->resultView=new View("err404", $vv);
            return $c;
	}
    	
}

