<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of View
 *
 * @author juliette david
 */
class View {
	/**
	 *
	 * @var array Variables disponibles dans la vue
	 */
	public $context = array();

	/**
	 *
	 * @var View Vue à l'intérieur de laquelle sera affiché ce template
	 */
	public $outerView;

	/**
	 *
	 * @var string Chemin du template
	 */
	public $path;
        
    
        /**
        * Constructeur
        *
        * @param string $path Chemin de la vue
        * @param string $theme Theme de la vue
        */
	public function __construct( $path ){
		$this->path = $path;
                $this->context=array();
	}
        /**
        * Execute le script avec les variables $context
        *
        * @param array $context Les variables disponibles dans les templates
        * @return string Le template généré
        */
	public function run( $context ){

		$this->context = array_merge($context,$this->context);
		
		$scriptPath = "php/view/".$this->path.".php";
		
		while( true ){
			
			if( !file_exists($scriptPath) ){
				return;
			}
			if( file_exists( $scriptPath ) ){
				
				while(list($k,$v) = each($this->context)){
					//trace("$k => $v");
					${$k} = $v;
				}
				reset($this->context);
				
				ob_start();
				include $scriptPath;
				$this->content = ob_get_contents();
				ob_end_clean();
				
				if($this->outerView){
                                        
					$outerContext = $this->context;
					$outerContext['_content'] = $this->content;
					return $this->outerView->run( $outerContext );
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
	function render( $view , $context = array(), $theme = null, $numTemplate = 0 ){
            
	    if($numTemplate != 0 && !empty($this->context["_".$numTemplate])) {
                $contextBase = $this->context["_".$numTemplate];
            }else{
                $contextBase = $this->context ;
            }
            $context = array_merge( $contextBase, $context );
             
             
            $view = new View($view);
	    //$context = array_merge( $contextBase, $context );
	    return $view->run($context);
	}


	/**
	* Insert this template in a layout template.
        * in the layout template use the variable $_content.
	* @param string $path path to the template file
	* @param array $data the data object givent to the outer view
	*/ 
	function inside( $path, $data = array() ){
		$this->outerView = new View($path,$data);
                //return $this->outerView->run($context);
	}

}
