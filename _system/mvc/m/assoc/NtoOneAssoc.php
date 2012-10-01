<?
/**
 *
 * Classe Field chargée des associations N à 1, par exemple une propriété "parent" dans une arborescence.
 *
 * @package Core.model.assoc
 *
 **/
class NtoOneAssoc extends Assoc {

	protected $item;

	/**
	 * Constructeur
	 * @param string $path nom de l'association
	 * @param array $options options à intégrer à l'association comme ses liaisons, sa clé, son ordre, etc...
	 */
	public function __construct( $path , $options = array() ) {

		parent::__construct( $path, $options );
		$this->options[self::PRIORITY] = "9";
	}

	/**
	 * Setter : Lie le modèle passé en paramètre au modèle attaché
	 * @param int|string|array|Model $value Valeur à lier, peut être l'id ou le code d'un Model, un Model, ou un tableau de valeurs à transformer en Model...
	 */
	public function set( $value ) {
		
		switch( gettype( $value ) ) {
			case "integer":
			case "string" :
				$this->value = $value;
				$this->item = null;
				break;
			default:
				if( is_array( $value ) ) {
					$manager = Manager::getManager( $this->to );
					$value = $manager->make( $value );
				}
			
				if( is_a( $value , $this->to ) ) {
					if( !$value->id ) {
						$value->save();
					}
					$this->item = $value;
					$this->value = $value->id;
				}
				break;
		}

	}

	/**
	 * Getter
	 * @return Model renvoie le model auquel elle est associé
	 */
	public function get() {
		$manager = Manager::getManager( $this->to );

		if( $this->item ) {
			return $this->item;
		}else if( $this->value ) {

				$o = $manager->get( $this->value );

				if( $o ) {
					$this->item = $o;
					return $o;
				}
			}

	}

	/**
	 * Renvoie la valeur de l'association, c'est à dire l'id du modèle associé, pour stockage
	 * @return Object
	 */
	public function serialize( ) {
		return $this->value;
	}

	/**
	 * Enregistrement du paramètre comme valeur de l'association
	 * @param Object $v valeur à déserialiser
	 */
	public function unserialize( $v ) {
		$this->value = $v;
	}

	/**
	 * Permet d'inserer dans la BD ce qui doit être inséré à travers cette association en fonction du model auquel elle est lié
	 * @see Model::save()
	 */
	public function insert() {
		//au cas où le champs n'existerait pas on le crée
		//si le champ ne fait pas partie de la table de la BD il n'a aucune raison d'etre inséré
		if($this->item && !$this->options[Assoc::SYMETRY]) {
			$this->item->save();
		}
	}

}

?>
