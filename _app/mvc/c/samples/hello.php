<?php
/**
 * Description of HelloControler
 *
 * @author david marsalone
 */
class HelloControler extends Controler{
    
    /**
     * Will display the default view	
     * @example http://your-domain.com/your-project-folder-or-not/samples/hello/index
     * 
     * @return String the html content of the page
     */
    public function index(){
	$this->view=new View("samples/hello");
        return $this->view->run();
    }
     /**
     * Will display the default view with a parameter defined in the controller	
     * @example http://your-domain.com/your-project-folder-or-not/samples/hello/bob
     * 
     * @return String the html content of the page
     */
    public function bob(){
	//prepare the variables for the view
	$vv=new HelloVariables();
	$vv->name1="bob";
	//prepare the view
	$view=new View("samples/hello",$vv);
        return $view->run();
    }
    /**
     * Here we will display an other template.
     * Note that the 3rd parameter here is optionnal so by default the color will be red.
     * Here we will use the view strict object. It will give use the hability to use autocompletion in the template. 
     * @param String $who1
     * @param String $who2
     * @param String $color
     * @return type 
     */
    public function peoples($who1,$who2,$color="red"){
	
	$vv=new HelloVariables();
	$vv->layoutVariables=new LayoutVariables();
	$vv->layoutVariables->pageTitle="page title is Hello peoples ".$who1." and ".$who2;
	$vv->name1=$who1;
	$vv->name2=$who2;
	$vv->color=$color;
        $view=new View("samples/helloTwoPeoples",$vv);
	return $view->run();
    }
   
}



?>
