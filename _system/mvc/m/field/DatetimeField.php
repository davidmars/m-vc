<?
/**
 *
 * Champ date/heure.
 * Sa valeur est un timestamp standard.
 * Son formatage dans les templates passe par la méthode format()
 *
 * @package Core.model
 * @subpackage Field
 */
class DatetimeField extends Field {


	const OUTPUT_FORMAT = "outputFormat";
	/**
	 *
	 * @var string Format de stockage (compatible date())
	 */
	public $serializeFormat = "Y-m-d H:i:s";
	/**
	 *
	 * @var string Format de sortie
	 */
	public $outputFormat = DATE_RFC850;

	public function __construct( $path, $options = array() ) {
	    parent::__construct( $path , $options );
	    if( $this->options[DatetimeField::OUTPUT_FORMAT] ){
		$this->outputFormat = $this->options[DatetimeField::OUTPUT_FORMAT];
	    }

	}
        
        public function val(){
            if(!$this->value){
                return date("d/m/Y H:i:s");
            }
            return $this->format("d/m/Y H:i:s");
        }

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
	 * @return DatetimeField ce champ
	 */
	public function get(){
	    return $this;
	}

	/**
	 * Formatte la date/heure selon le pattern $f compatible date()
	 * @param string $f Un pattern de formatage de la date/heure (ex : "Y-m-d H:i:s" )
	 * @return string La date/heure formattée
	 */
	public function format( $f, $isloc = false ){
            if(!$this->value){
               $this->value=time(); 
            }
	    if($isloc)
	    {
		$langue = (Langue::$current->code == "kr")?"ko":Langue::$current->code;
		//setLocale(LC_ALL,"fr_FR"/*LC_TIME, str_replace("-", "_", Localisation::$current->code)*/);
		
		$fmt = new IntlDateFormatter( $langue , IntlDateFormatter::FULL, IntlDateFormatter::NONE , "Europe/Paris" );
		return $fmt->format( $this->value ); //strftime( $f , $this->value );
	    }
	    else
	    {
		return date( $f , $this->value );
	    }
	    
	}

	/**
	 * Renvoie la date/heure formattée selon la norme RFC850
	 * @return string Une date formattée
	 */
	public function __toString(){
	    //return $this->value;
	    if( $this->value == 0 ){
		return "";
	    }
	    return date( $this->outputFormat , $this->value );
	}
	
	public function unserialize( $value ){
	    if( $value == "0000-00-00 00:00:00" ){
		$this->value = 0;
	    }
	    else
	    {
		$this->value = strtotime( $value );
	    }
	}
	
	public function serialize(){
	    $d = date( $this->serializeFormat , $this->value );
	    //trace($d);
	    return $d;
	}
	
	function asDbColumn(){
	    $field = parent::asDbColumn();
	    $field->type = "datetime";
	    $field->null = "NO";
	    //$field->default = "NOW()";

	    return $field;
	}	
	
}

?>