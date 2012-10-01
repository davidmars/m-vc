<?
/**
 * Champ contenant une clé primaire (int 255)
 *
 * @package Core.model
 * @subpackage Field
 */
class KeyField extends Field {
/*
	public function set( $value ){
		$this->value = intval( $value );
	}
	
	public function get(){
		return intval( $this->value );
	}
*/
	function asDbColumn(){
		$field = parent::asDbColumn();
		$field->type = "int(255) unsigned";
		$field->null = "NO";
		$field->key = "PRI";	
		
		return $field;
	}	
	
}

?>