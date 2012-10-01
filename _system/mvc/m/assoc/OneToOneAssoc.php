<?
/**
 *
 * Classe Field chargée des associations 1 à 1
 *
 * @package Core.model
 * @subpackage Assoc
 *
 **/
class OnetoOneAssoc extends Assoc {

/**
 *
 * @var Model Modèle associé
 */
	protected $item;

	/**
	 *
	 * @var Field Field correspondant à la clé d'association
	 */
	private $key;

	//public $adds = array();

	/**
	 * Constructeur
	 * @param string $path
	 * @param Object $options options à intégrer à l'association comme ses liaisons, sa clé, son ordre, etc...
	 */
	public function __construct( $path , $options = array() ) {
		parent::__construct( $path, $options );
		if( $this->options[self::KEY] ) {
			$this->key = Field::getField( $this->options[self::KEY] );
		}else {
			$this->key = $this;
		}

		$this->options[self::PRIORITY] = "9";
	}

	/**
	 * Setter
	 * @param Model|int|string|array $value une valeur ou un Model (dans ce cas la valeur prend l'identifiant du model)
	 */
	public function set( $value ) {

		$manager = Manager::getManager( $this->to );

		switch( gettype( $value ) ) {
			case "integer":
			case "string" :
				$this->value = $value;
				break;

			default:

				if( is_array( $value ) ) {
					$this->item = $this->get();
					if( !$this->item ) {
						$this->item = $manager->make( $value );
					}
					foreach( $value as $k => $v ) {
						$this->item->{$k} = $v;
					}
				}
				if( is_a( $value , $this->to ) ) {
					$this->item = $value;
				}
				/*if( !$this->item->id ) {
					$this->item->insert();
				}else {
					$this->item->update();
				}*/

				$this->value = $this->item->id;
				break;

		}

	}

	/**
	 * Getter
	 * @return Model renvoie le model auquel elle est associé
	 */
	public function get() {

		if( $this->item ) {
			return $this->item ;
		}

		$manager = Manager::getManager( $this->to );

		if( !$this->isSelfStored() ) {
			$q = $manager->select()->where( "{$this->key->fullname} = '".$this->model->id()."'");
			$o = $q->one();
		}else {
			$o = $manager->get($this->value);

		}

		if( $o ) {
			$this->item = $o;
			$this->value = $o->id();
			return $o;
		}

		$o = new $this->to;
		$this->item = $o;

		if( !$this->isSelfStored() ) {
			$this->item->{$this->key->name} = $this->model;
		}

		return $o;

	}

	/**
	 * Determine si l'association est stockée dans une colonne propre au modèle source ou au modèle destination
	 * @return boolean True si l'association est stockée dans une colonne du modèle source
	 */
	private function isSelfStored() {
		return ( $this->key->fullname == $this->fullname );
	}

	/**
	 * Si l'association est lié à un model on l'ajoute au tableau des ajouts (adds) et on renvois son identifiant
	 * Sinon on renvoie la valeur de l'association
	 * @return array
	 */
	public function serialize( ) {
	//trace($this->value);
		if( $this->item && $this->isSelfStored() ) {
			//$this->item->save();
			//array_push( $this->adds , $this->item );
			$this->value = $this->item->id;
		}

		return $this->value;
	}

	/**
	 * Si le paramètre transmis est un tableau on enregistre un model déduit de ce tableau et on enregistre pour valeur l'identifiant de ce model
	 * Sinon on enregistre simplement le paramètre comme valeur de l'association
	 * @param Object $v valeur à déserialiser
	 */
	public function unserialize( $v ) {
	//trace("unserialize : $v");
		$m = Manager::getManager( $this->to );

		if( is_array( $v ) ) {
			$this->item = $m->make( $v );

			//$this->item->save();

			$this->value = $this->item->id();
		}else if( $v ) {
				$this->value = $v;
			}
	}

	/**
	 * Renvoie une variable structurée comme une colonne de base de donnée à partir de l'association et de ses caractéristiques
	 * @see Assoc
	 * @return DbColumn occurence d'un champ de base de donnée basé sur l'association
	 */
	function asDbColumn() {
		if( $this->key == $this ) {
			return parent::asDbColumn();
		}
	}

	/**
	 * Permet d'inserer dans la BD ce qui doit être inséré à travers cette association en fonction du model auquel elle est lié
	 * @see Model::save()
	 */
	function insert() {
	//si le champ ne fait pas partie de la table de la BD il n'a aucune raison d'etre inséré
		if($this->item && !$this->options[Assoc::SYMETRY]) {
			$this->item->save();
		}
	}

}

?>