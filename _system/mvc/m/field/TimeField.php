<?
/**
 *
 * Champ heure.
 * Sa valeur est un timestamp standard.
 * Son formatage dans les templates passe par la méthode format()
 *
 * @package Core.model
 * @subpackage Field
 */
class TimeField extends Field {

	/**
	 *
	 * @var string Format de stockage (compatible date())
	 */
	public $serializeFormat = "H:i:s";

	/**
	 * Setter
	 * @param mixed $value Si c'est un chiffre, il sera interprété comme un timestamp. Si c'est un string, il passe par strtotime()
	 */
	public function set( $value ){
		if( is_numeric($value) ){
			$this->value = $value;
		}else{
			$this->value = strtotime( $value );
		}
	}

	/**
	 * Getter
	 * @return TimeField ce champ
	 */
	public function get(){
		return $this;
	}

	/**
	 * Formatte la date/heure selon le pattern $f compatible date()
	 * @param string $f Un pattern de formatage de la date/heure (ex : "Y-m-d H:i:s" )
	 * @return string La date/heure formattée
	 */
	public function format( $f ){
		return date( $f , $this->value );
	}

	/**
	 * Renvoie la date/heure formattée selon la norme RFC850
	 * @return string Une date formattée
	 */
	public function __toString(){
		//return $this->value;
		return date( DATE_RFC850, $this->value );
	}
	
	public function unserialize( $value ){
		//trace("value => ".$value);
		$this->value = strtotime( $value );
	}
	
	public function serialize(){
		if($this->value == "")
		{
		    return "";
		}
		else
		{
		    $d = date( $this->serializeFormat , $this->value );
		    //trace($d);
		    return $d;
		}
	}
	
	function asDbColumn(){
		$field = parent::asDbColumn();
		$field->type = "time";
		$field->null = "YES";
		//$field->default = "NOW()";
		
		return $field;
	}	
	
}

?>