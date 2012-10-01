<?
/**
 *
 * Champ de type "enum", pouvant prendre plusieurs états définis
 *
 * @package Core.model
 * @subpackage Field
 */
class EnumField extends Field {

	/**
	 * Option : états
	 */
	const STATES = "states";

	/**
	 * Setter
	 * Vérifie que la valeur fasse partie de états définis en options, d'abord les valeurs, puis les clés;
	 * On peut donc éventuellement passer l'index numérique de l'état
	 *
	 * @param string|int $value
	 * 
	 */
	public function set( $value ){
		//trace("Setting to $value");
		if( $value === null ) return;
		if( in_array( $value , $this->options[EnumField::STATES] ) ){
		    $this->value = $value;
		}else if( array_key_exists( $value , $this->options[EnumField::STATES] ) ){
		    $this->value = $this->options[EnumField::STATES][$value];
		}
		else
		{
		    $this->value = 0;
		}
		//trace("this.value = ".$this->value);
	}

	/**
	 * Renvoie une colonne pour le stockage
	 * @return DbColumn Colonne de type "enum" avec les états correspondant entre quote, indexée
	 */
	public function asDbColumn(){
		
		$field = parent::asDbColumn();
		
		$manager = Manager::getManager($this->from);
		
		$type = "enum(";
		$type .= join(",", array_map( array( $this , "quote" ) , $this->options[EnumField::STATES] ) );
		$type .= ")";
		
		$field->type = $type;				
			
		$field->null = "NO";
		$field->key = "MUL";	
		
		return $field;
	}

	/**
	 * Méthode de quote personnalisée : lorsqu'on fait un SHOW COLUMNS, les valeurs d'enums sont renvoyés entourées de ', donc on fait la même chose
	 * @param string $str l'état à échapper / quoter
	 * @return l'état échappé / quoté
	 */
	private function quote( $str ){
		return "'".addslashes($str)."'";
	}

}

?>