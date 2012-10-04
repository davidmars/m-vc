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
        
        /**
        *
        * @var bool Is the field editable by an admin user?
        */
        public $editableByHuman=false;
		
}

?>