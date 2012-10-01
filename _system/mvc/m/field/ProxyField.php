<?/**
 *
 * Classe ProxyField permettant de passer outre certains champs.
 * Exemple : voir model Content appli Piaget
 *
 * @package Core.model.assoc
 *
 **/
class ProxyField extends Field{

    const TARGET_FIELD = "targetField";

    public $targetField = array();

    public function  __construct( $path , $options = array() ) {
	parent::__construct( $path , $options );
	if( $f = $options[self::TARGET_FIELD] ){
	    $this->targetField = explode("." , $f );
	}
    }

    /*
     * Permet de ne pas créer de champs dans la BD
     */
    public function asDbColumn() {
	return;
    }

    /**
     * Getter
     * @return $this NtoNAssoc renvoie l'association
     */
    public function get() {

	return $this;
	//return parent::offsetGet(Langue::$current);
    }
    /**
     * 
     * @param <type> $name
     * @return <type>
     */
    public function __get( $name ){

	$obj = $this->model;

	foreach( $this->targetField as $part ){
	    $obj = $obj->{$part};
	    if( !$obj ) return;
	}

	return $obj->{$name};
	
    }
}

?>
