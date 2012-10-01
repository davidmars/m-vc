<?
/**
 * Champ primaire
 *
 * @package Core.model
 * @subpackage Field
 */
class PrimaryField extends Field {

	private $keys = array();

	public function __construct( $path , $options = array() ){
		
		parent::__construct( $path , $options );
		
		if( is_array( $this->options["keys"] ) ){
			
			foreach( $this->options["keys"] as $fullpath ){
			
				$this->keys = Field::getField( $fullpath );
			
			}
		
		}
	
	}

}


?>