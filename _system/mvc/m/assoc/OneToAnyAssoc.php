<?
/**
 *
 * Classe chargée des associations "N to Any", c a d d'un modele à n'importe quel modele
 *
 * @package Core.model.assoc
 */
class OneToAnyAssoc extends Assoc {

	private $modelField;
	private $idField;

	const MODELS = "allowedModels";
	private $allowedModels = array();

	public function __construct( $name , $options = array() ){
		parent::__construct( $name , $options );

		if( is_array( $this->options[self::MODELS] ) ){
			$this->allowedModels = $this->options[self::MODELS];
		}

		$this->createFields();
	}
	
	private function createFields(){

		$modelField = "{$this->from}.{$this->name}_model";
		$idField = "{$this->from}.{$this->name}_id";

		if( !Field::getField( $modelField ) ){
			Field::create( $modelField , Field );
		}
		if( !Field::getField( $idField ) ){
			Field::create( $idField , Field );
		}

	}

	public function asDbColumn(){

	}

}

?>