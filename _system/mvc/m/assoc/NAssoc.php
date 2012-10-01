<?

/**
 *
 * Classe chargée des associations X à N (associations multiples)
 * 
 * @package Core.model
 *
 **/
class NAssoc extends Assoc implements IteratorAggregate {

	/**
	 * Option : boolean Les modèles associés peuvent-ils l'être plusieurs fois
	 */
	const UNIQUE 	= "unique";
	/**
	 * Option : boolean|string Les modèles associés ont-ils un ordre propre
	 */
	const ORDERED 	= "ordered";

	/**
	 *
	 * @var array Options par défaut : association unique, non ordonnée, sans symétrie
	 */
	public static $defaults = array(
		self::UNIQUE 	=> true,
		self::ORDERED 	=> false,
		self::SYMETRY	=> false
	);

	/**
	 *
	 * @var array Cache des Modèles associés
	 */
	protected $items;
	/**
	 *
	 * @var string Champ d'ordre
	 */
	protected $orderField;

	/**
	 *
	 * @var ManagerEvent gestionnaire des évènements
	 */
	public $events;

	/**
	* Constructeur
	* @param string $path
	* @param array $options options à intégrer à l'association comme ses liaisons, sa clé, son ordre, etc...
	*/
	public function __construct( $path, $options = array() ){
		parent::__construct( $path, array_merge( self::$defaults, $options ) );
		$this->events = new ManagerEvent( $this );
		//trace($this->options);
	}

	/**
	* Retourne tous les identifiants des N enregistrements liés à cette association
	* @return array $ids liste des identifiants de ces enregistrements
	*/
	public function ids(){
		$all = $this->all();
		$ids = array();
		if( $all ){
			foreach( $all as $item ){
				array_push( $ids, $item->id() );
			}
		}
		return $ids;
	}

	/**
	* Retourne les N enregistrements liés à cette association
	* @return array liste des identifiants de ces enregistrements
	*/
	public function all(){
		
		if( $this->items == null ){
			$this->items = $this->select()->all();
		}
		
		return $this->items;	
	}

	/**
	* Retourne le nombre d'enregistrements liés
	* @return int Nombre d'enregistrements
	*/
	public function count(){
	//DbManager::$cnx->debug = true;
		if( $this->items == null ){
			//Session::message("".$this->select());
			return $this->select()->count();
			//$this->items = $this->select()->all();
		}

		return count( $this->items );
	}

	/**
	 * Déserialise les données contenues dans $data pour définir les valeurs de l'association.
	 *
	 * @param array $data Un tableau à deux dimensions contenant des données correspondant aux modèles associés
	 * @see Manager::make
	 */
	public function unserialize( $data ){
    	
	    $manager = Manager::getManager( $this->to );
	    $this->items = array();
    	
	    if( is_array( $data ) ){
			foreach( $data as $row ){
				//trace($row);
				if( is_array( $row ) ){
					array_push( $this->items , $manager->make( $row ) );
				}
			}
	    }
	
	}

	/**
	 * Permet de savoir si l'élément passé en paramètre fait partie des éléments liés par l'assoc au modèle from
	 */
	public function has($obj )
	{
	    if( is_a( $obj , $this->to ) )
	    {
		$id = $obj->id;
	    }else
	    {
		$id = $obj;
	    }
	    return $this->select()->whereIn(array($id), "{$this->to}.id")->count() > 0;

	}

	/**
	 * Renvoie un itérateur sur les items associés (utilisé pour les foreach)
	 * @return ArrayIterator Itérateur sur les items associés
	 */
	public function getIterator(){
		return new ArrayIterator( $this->all() );
	}

}

?>
