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
	$view=new View("samples/hello");
        return $view;
    }
     /**
     * Will display the default view with a parameter defined in the controller	
     * @example http://your-domain.com/your-project-folder-or-not/samples/hello/bob
     * @return String the html content of the page
     */
    public function bob(){
	//prepare the variables for the view
	$vv=new HelloVariables();
	$vv->name1="bob";
        
	//prepare the view
	$view=new View("samples/hello",$vv);
        return  $view;
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
	$vv->layoutVariables->htmlHeader->title="$who1 & $who2 are in love";
        $vv->layoutVariables->htmlHeader->keywords="$who1,$who2,$color";
        $vv->layoutVariables->htmlHeader->description="Let's discover ".$vv->layoutVariables->htmlHeader->title;
	$vv->name1=$who1;
	$vv->name2=$who2;
	$vv->color=$color;
        $view=new View("samples/helloTwoPeoples",$vv);
	return $view;
        
    }
   
}



?>
