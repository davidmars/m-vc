<?php

/**
 * Description of lolo
 *
 * @author laurence
 */
class LoloController extends Controller {
        /**
         * This is the home page.
         * @param string $param1 The first parameter that can be displayed
         * @param string $param2 The second parameter that can be displayed
         * @return \View 
         */
    	public function index($param1=null,$param2=null)
	{
            
            //if too much arguments redirect to the best page url
            if(func_num_args()>2){
                $this->redirect302($this->routeToFunction."/$param1/$param2");
            }
            
            $vv=new VV_fmk_page();
            $vv->htmlHeader=new VV_html_header();
            $vv->htmlHeader->author="you@you.com";
            $vv->htmlHeader->title="Ma première page";
            $vv->param1=$param1;
            $vv->param2=$param2;
            $vv->title="Ma première page en racine de fmk";
            $view=new View($param1, $vv); // on peut utiliser param1 comme template à afficher
            //$view=new View("lolo", $vv); //ecriture en dur du template à afficher
            
            
            return $view;
	}
    	
}

