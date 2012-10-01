<?
/**
 *
 * Classe représentant un champ "code", c'est à dire un champ string unique
 *
 * @package Core.model
 * @subpackage Field
 *
 */
class CodeField extends Field {

	/**
	 *
	 * @staticvar array Options par défaut
	 */
	static $defaults = array(
		self::UNIQUE => true,
		self::LENGTH => 255
	);

	public function __construct($path, $options = array()){
		parent::__construct( $path , $options );
		$this->options = array_merge( self::$defaults , $options );
	}

	public function set( $value ){
		
		$this->value = $value;

	}

	public function get(){
		if( $this->value ){
			return $this->value;
		}else{
			return "";
		}
	}

	function asDbColumn(){
		$field = parent::asDbColumn();
		return $field;
	}

}

?>