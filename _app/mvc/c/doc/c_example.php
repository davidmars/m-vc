<?php

/**
 * This is used only to help people practice when reading the documentation
 * and access templates (stored in v/doc/samples)
 * before they know how to create a controller
 *
 * @author laurence
 */
class ExampleController extends Controller {
        /**
         * This is the Examples page.
         * @param string $template Name of the template you want to display
         * @return \View 
         */
    	public function index($template=null)
	{
            
            //if too much arguments redirect to the best page url
            if(func_num_args()>1){
                $this->redirect302($this->routeToFunction."/$template");
            }
            
            $vv=new VV_fmk_page();
            $vv->htmlHeader=new VV_html_header();
            $vv->title="This is the title of the page Examples";
            $view=new View("doc/samples/".$template, $vv);
            return $view;
	}
	
}
?>
