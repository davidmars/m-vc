<?
/**
 * Champ d'identifiant classique (int(255) primaire)
 *
 * @package Core.model
 * @subpackage Field
 */
class IdField extends KeyField {
	
	static $defaults = array(
		self::PRIMARY => true,
		self::PASS_THROUGH => true
	);

	public function __construct($path, $options = array()){
		parent::__construct( $path , $options );
		$this->options = array_merge( self::$defaults , $options );
	}
/*
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
*/
	function asDbColumn(){
		$field = parent::asDbColumn();
		$field->extra = "auto_increment";
		
		return $field;
	}	
	
}

?>