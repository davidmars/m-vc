<?
/**
 * Champ de date/heure qui contient la valeur courante à chaque update
 *
 * @package Core.model
 * @subpackage Field
 */
class ModifiedField extends DatetimeField {
	
	public function serialize(){
		
		$this->value = time();
		return parent::serialize();
		
	}
		
}

?>