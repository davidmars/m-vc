<?php

/**
 * Description the view system
 *
 * @author juliette david
 */
class View {

	
	/**
         * 
         * @var ViewVariables Here are the variables used in the view. 
         * Inside the template use $_vars to retrieve it. 
         * It's an object, so it should be strict and it should be precise.
         */
	public $viewVariables;
	/**
	 *
	 * @var string Path to the template whithout view folder and without ".php".
         * @example a templates located at "_app/mvc/v/a-folder/hello-world.php" should be "a-folder/hello-world"
	 */
	public $path;
	/**
	 *
	 * @var String it will be filled only if the current view is a kind of layout. 
         * Inside the template use $_content to get it. 
	 */
	private $insideContent;
	/**
	 *
	 * @var View a view outside this view, in practice this view is a layout
	 */
	private $outerView;
        /**
        * Constructeur
        *
        * @param string $path Chemin de la vue
        * @param string $theme Theme de la vue
        */
	public function __construct( $path,$viewVariables=null ){
		$this->path = $path;
		$this->viewVariables=$viewVariables;
	}
        /**
        * Process the template with the current properties.
        *
        * @param array $context Les variables disponibles dans les templates
        * @return string Le template généré
        */
	private function run(){
	    
		$scriptPath = $this->path;
		//if(!file_exists($scriptPath)){
		    $scriptPath = "_app/mvc/v/".$this->path.".php";
		//}
		if(!file_exists($scriptPath)){
		    die("Can't find the view :".$scriptPath);
		}
		

	
                //declare the variables in the template
                $_vars=$this->viewVariables;
                $_content=$this->insideContent;
                ob_start();
                include $scriptPath;
                $content = ob_get_contents();
                ob_end_clean();

                if($this->outerView){
                        $this->outerView->insideContent=$content;
                        return $this->outerView->run();
                }else{
                        return $content;		
                }		
	}

	
	/**
	 * Process the template and return the result.
	 * @param String $view path to the template to execute or insert.
	 * @param ViewVariables $viewVariables Tableau des variables à transmettre à la vue
	 * @return String The template result after execution
	 **/
	function render( $path=null , $viewVariables=null ){
            
            $viewVariables=$viewVariables ? $viewVariables : $this->viewVariables;
            if($path){
                $view = new View($path,$viewVariables);
                return $view->run();
            }else{
                $this->viewVariables=$viewVariables;
                return $this->run();
            }
	}
        



	/**
	* Insert the current template inside an other template.
        * In the layout template use the variable $_content to display the current template.
	* @param String $path path to the template file
	* @param array $viewVariables the data object given to the outer view, if not given, the object will be the current strictParams
	*/ 
	function inside( $path, $viewVariables=null ){
                $viewVariables=$viewVariables ? $viewVariables : $this->viewVariables;
		$this->outerView = new View($path, $viewVariables);
	}

}
