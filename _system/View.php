<?php

/**
 * Description the view system
 *
 * @author juliette david
 */
class View {

	
	
	public $viewVariables;

	/**
	 *
	 * @var View a view outside this view, commonly called a layout
	 */
	public $outerView;

	/**
	 *
	 * @var string Chemin du template
	 */
	public $path;
	/**
	 *
	 * @var String it will be filled only if the current view is a kind of layout 
	 */
	public $insideContent;
        
    
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
        * Execute le script avec les variables $context
        *
        * @param array $context Les variables disponibles dans les templates
        * @return string Le template généré
        */
	public function run(){
	    
		$scriptPath = $this->path;
		if(!file_exists($scriptPath)){
		    $scriptPath = "_app/mvc/v/".$this->path.".php";
		}
		if(!file_exists($scriptPath)){
		    die("can't find the view :".$scriptPath);
		}
		
		while( true ){
			
			if( file_exists( $scriptPath ) ){
				
				//give the variables to the view
				$_vars=$this->viewVariables;
				$_content=$this->insideContent;
				ob_start();
				include $scriptPath;
				$this->content = ob_get_contents();
				ob_end_clean();
				
				if($this->outerView){
					$this->outerView->insideContent=$this->content;
					return $this->outerView->run();
				}else{
					return $this->content;		
				}
				
				break;
				
			}else{
                            die($scriptPath." n'existe pas!");
                        }
		}
			
	}

	
	/**
	 * Execute la vue $v avec le contexte global
	 * @param string $view nom du fichier de template a insérer/executer
	 * @param array $context Tableau des variables à transmettre à la vue
	 * @param string $theme définit le dossier des templates où se situe la vue
	 * @param int $numTemplate permet de gerer plusieurs fois le meme template dans la meme page en dispatchant les donnees dans le context
	 * @return string résultat du template interprété
	 **/
	function render( $path , $viewVariables=null ){

            $view = new View($path,$viewVariables);
	    return $view->run();
	}


	/**
	* Insert this template into a layout template.
        * in the layout template use the variable $_content to display the current view.
	* @param string $path path to the template file
	* @param array $viewVariables the data object givent to the outer view, if not given, the object will be the current strictParams
	*/ 
	function inside( $path, $viewVariables=null ){
		$this->outerView = new View($path, $viewVariables ? $viewVariables : $this->viewVariables);
	}

}
