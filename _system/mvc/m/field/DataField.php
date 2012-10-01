<?
/**
 *
 * Champ de données, sérialisé via PHP. Permet de stocker n'importe quel type de données structurées (array) de façon transparente
 *
 * @package Core.model
 * @subpackage Field
 * 
 */
class DataField extends Field {
	
	public function serialize(){
		
        return serialize( $this->value );
    }

    public function unserialize( $data ){
       $this->value = unserialize( $data );
    }
	
}

?>