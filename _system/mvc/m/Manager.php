<?
/**
 * A manager object manage a model. This is the basic class, usualy it is extended.
 *
 **/
class Manager {

	/**
	 *
	 * @var string Related model
	 */
	public $model;

	/**
	 *
	 * @var array Index utilisé pour le cache des modèles
	 */
	protected $cache = array();

	/**
	 *
	 * @var boolean Si vrai, le Manager conserve un index des modèles utilisés
	 * pour éviter de refaire des requête en base, et pour éviter la duplication des mêmes modèles
	 */
	public $useCache = true;

	/**
	 *
	 * @var array Source de données
	 */
	protected $source = array();

	/**
	 *
	 * @staticvar array Tableau de tous les managers créés, indexés par nom de modèle
	 */
	static $managers = array();

	/**
	 *
	 * @var boolean Mode debug si true
	 */
	public $debug = false;

	/**
	 *
	 * @var array Tableau des champs primaires du modèle
	 */
	public $keys = array();

	/**
	 *
	 * @var ManagerEvent gestionnaire des évènements
	 */
	public $events;

	/**
	 *
	 * @param string $model Nom du modèle à gérer
	 */
	public function __construct( $model ) {
		$this->model = $model;
		self::$managers[ $model ] = $this;
		$this->events = new ManagerEvent( $model );
	}

	/**
	 * Renvoie une occurence du modèle lié au manager ayant pour identifiant $id
	 * @param mixed $id Identifiant du modèle à récupérer
	 * @return mixed Le modèle identifié, ou null
	 */
	public function get( $id ) {
	//trace("getting [$id]");
		$id = trim($id);
		if( !$id ) return null;
		/*if( $this->useCache && array_key_exists( $id, $this->cache ) ) {
		//trace( "[$id] => using cache : ". $this->cache[$id] );
			return $this->cache[$id];
		}*/

		if( !is_numeric( $id ) && Field::getField( $this->model , 'code') ) {
			$o = $this->find( array( 'code' => $id ) );
		}else {
			$o = $this->find( array( 'id' => $id ) ) ;
		}

		/*if( $o ) {
		//trace("setting cache $id => $o");
			$this->cache[$id] = &$o;
		}*/
		return $o;

	}

	/**
	 * Renvoie le premier objet contenant les valeurs de $keys comme propriétés
	 * @param array $keys Tableau de clé => valeur à rechercher
	 * @return Model un objet ou null si aucun ne correspond
	 */
	public function find( $keys = array() ) {

		$results = $this->findAll($keys);

		if(count($results)) {
			return $results[0];
		}
	}

	/**
	 * Renvoie une liste des objets contenant les valeurs de $keys comme propriétés
	 * @param array $keys Tableau de clé => valeur à rechercher
	 * @return array Tableau de modèles correspondants
	 */
	public function findAll( $keys = array() ) {

		if(array_key_exists("id", $keys)) {
			$result = $this->source[$keys['id']];
			if($result) {
				return array( $this->make( $result ) );
			}else {
				return array();
			}

		}else {
			$output = array();
			foreach( $this->source as $k => $row ) {
				if(array_intersect_assoc( $row , $keys ) == $keys) {
					array_push($output, $this->make($row));
				}
			}
			return $output;
		}

	}

	/**
	 * Génère un model à partir de données récupérée dans un modèle de données (BD, XML, etc...)
	 * @param Array $arr tableau contenant les données à interpréter
	 * @return Model généré
	 * @see Manager::unmake
	 * @see Field::serialize
	 */
	public function make( $arr = array() ) {
		
		$model = new $this->model();

		foreach( $arr as $k => $v ) {
			if( $f = $model->field( $k ) ) {
				$f->unserialize( $v );
			}else {
				$model->{$k} = $v;
			}
		}

		if( $this->useCache ){
		    $ids = array();
		    foreach( $this->keys as $f ){
			$ids[] = $model->field($f->name)->serialize();
		    }
		    $this->cache[ join("-", $ids ) ] = $model;
		   // trace("Storing $model in #".join("-", $ids ));
		}

		return $model;

	}

	/**
	 * Génère un tableau de données à partir des informations contenues dans un model passé en paramètre
	 * @param Object $obj objet de donnée (généralement un model) qui nous permet de créer un tableau de données
	 * @return array données sous forme de tableau associatif découlant des données enregistrées dans le model
	 * @see Manager::make
	 * @see Field::serialize
	 */
	public function unmake( $obj = null ) {

		$data = array();

		foreach( Field::getFields( $obj ) as $fieldName => $fieldDef ) {
                    if($obj->field( $fieldName )){
			$data[$fieldName] = $obj->field( $fieldName )->serialize();
                    }

		/*
		trace(get_class($obj->field( $fieldName ))." ".$fieldName." ".get_class($obj->field( $fieldName )->model)." "." ".$obj->field( $fieldName )->options[Field::PRIMARY]." (".$data[$fieldName].")");
		if(get_class($obj->field( $fieldName )) == "NtoNAssoc")
		{
		    trace(get_class($obj->field( $fieldName )->model)." ".$obj->field( $fieldName )->options[Assoc::TO]);
		}
		*/
		}
		//trace($data);
		return $data;

	}

	/**
	 * Applique la méthode make à plusieurs tableaux
	 * @param array $arr Un tableau à deux dimensions contenant des données
	 * @return array Un tableau des modèles correspondant
	 */
	public function makeAll( $arr = array() ) {
		return array_map( $arr , array($this, "make") );
	}

	/**
	 * Renvoie le manager du model passé en paramètre
	 * @param Model $model model dont l'on souhaite récupérer le manager
	 * @return Manager le manager lié au model
	 */
	static function getManager( $model ) {
		if(is_object ($model)){
		    $model=get_class($model);
		}
		if( class_exists( $model ) ) {
		    return self::$managers[$model];
		//throw new Exception("Class [$model] doesn't exists");
		}else{
		    return null;
		}

	}

	/**
	 * Initialisation du manager
	 */
	public function init() {
		$this->keys = array();
		foreach( Field::getFields( $this->model ) as $name => $field ){
			if( $field->options[Field::PRIMARY] ){
				array_push( $this->keys , $field );
			}
		}
	}

	/**
	 * Détruit le model du manager passé en paramètre
	 * @param Model $m le model que l'on souhaite détruire
	 */
	public function destructModel( $m ) {

		if( is_a( $m , Model )) {
		    $ids = array();
		    foreach( $this->keys as $f ){
			$ids[] = $m->{$f->name};
		    }
		    if( count($ids) == count($this->keys ) ){
			unset($this->cache[join("-", $ids)]);
		    }
		    $m->__destruct();
			/*unset($this->cache[$m->id]);
			unset($this->cache[$m->code]);
			*/
		}/*else {
			if( array_key_exists($m,$this->cache)) {
				$this->cache[$m]->__destruct();
				unset( $this->cache[ $m ] );
			}
		}*/


	}

	/**
	 * Renvoie la liste des identifiants des items passé en paramètre
	 * @param Object $items éléments dont l'ont souhaite connaitre les identifiants
	 * @return array liste des identifiants
	 */
	public static function ids( $items ) {
		$ids = array();
		foreach( $items as $item ) {
			array_push( $ids, $item->id );
		}
		return $ids;

	}

	/**
	 * Renvoie un tableau id => nom à partir d'un tableau d'items passés en paramètres.
	 * Utilisé pour générer des options d'éléments de formulaires SelectInput ou MultipleCheckboxInput
	 * @param array $items Tableau de Modèles
	 * @param string $field Champ à afficher comme titre
	 * @return array Tableau id => nom correspodant aux items
	 */
	public static function options( $items , $field = null ) {
		$options = array();
		foreach( $items as $item ) {
			if( $field ){
				$options[$item->id] = $item->{$field};
			}else{
				$options[$item->id] = $item->name();
			}
		}
		return $options;
	}

	public static function groupByField( $items , $field ){
		$outp = array();
		foreach( $items as $item ){

			$outp["".$item->{$field}][] = $item;
		}
		return $outp;
	}

	public function flushCache(){
		$this->cache = array();
	}

}

?>