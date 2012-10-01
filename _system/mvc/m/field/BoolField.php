<?php
/**
 *
 * Classe représentant un champ boolean (true ou false) dans un modèle
 *
 * @package Core.model
 * @subpackage Field
 */
class BoolField extends Field {

	/*public static $defaults = array(
		EnumField::STATES => array(0, 1 ),
		Field::DEFAULT_VALUE => array(0)
	);*/

	/*public function __construct($path, $options = array() ) {
		parent::__construct( $path , $options );
		$this->options = array_merge( self::$defaults , $this->options );
	}*/

	/*public function set( $value ){
		
		parent::set( $value );
		
	}

	public function get(){
		
		return $this->value;
		
	}*/

	public function asDbColumn(){
		$t = parent::asDbColumn();
		$t->default = '0';
		$t->type = "tinyint(1)";
		return $t;
	}

}

?>