<?
/**
 *
 * Classe Field chargée des associations N à N, par exemple les "tags", "related to", etc
 * Désigne une association N à N unique entre deux Modèles.
 *
 * @package Core.model.assoc
 *
 **/
class NtoNAssoc extends NAssoc implements arrayaccess {

	/**
	 * Option : boolean Désigne une association simple, c'est à dire unique entre deux modèles.
	 */
	const SIMPLE = "simple";
	/**
	 * Option : string Modèle de liaison (optionnel)
	 */
	const LINK_MODEL = "linkModel";
	/**
	 * Option : string Clé d'association
	 */
	const SELF_KEY = "selfKey";
	/**
	 * Option : string Clé d'association
	 */
	const FOREIGN_KEY = "foreignKey";

	/**
	 *
	 * @var string Nom du modèle de liaison
	 */
	public $linkModel;
	/**
	 *
	 * @var string Clé correspondant au modèle associé (from)
	 */
	protected $selfKey;
	/**
	 *
	 * @var string Clé correspondant au modèle associé (to)
	 */
	protected $foreignKey;

	/**
	 *
	 * @var array Tableau des ids à ajouter
	 * @see NtoNAssoc::unlink
	 */
	public $adds = array();
	/**
	 *
	 * @var array Tableau des ids à ajouter
	 * @see NtoNAssoc::link
	 */
	protected $removes = array();
	/**
	 *
	 * @var array Tableau des liens aux autres modeles, avec clé = id du modèle de destination et valeur = modèle de liaison
	 */
	protected $links = array();

	/**
	 * Constructeur
	 * @param string $path
	 * @param array $options options à intégrer à l'association comme ses liaisons, sa clé, son ordre, etc...
	 */
	public function __construct( $path, $options = array() ) {

		parent::__construct( $path, $options );

		foreach( array( "linkModel", "selfKey", "foreignKey", "arrayAccess" ) as $option ) {
			if( array_key_exists( $option , $this->options ) ) {
				$this->{$option} = $this->options[$option];
			}
		}
		if(!class_exists( $this->to ) ){
		    throw new Exception("The target class doesn't exists");
		}

		$initializeManager = false;

		if( !$this->linkModel ) {
			$this->generateModel();
			$initializeManager = true;
		}else if( !class_exists( $this->linkModel ) ) {
			$this->generateModel( $this->linkModel );
			$initializeManager = true;
		}

		if( $this->options[self::ORDERED] ) {
		//trace("ordered");
			if( $this->options[self::ORDER] && $f = Field::getField($this->options[self::ORDER]) ) {

				
				
				//trace("f".$f);
					$this->orderField = $f;
				

			}else {

					$this->orderField = $this->generateOrderField( $this->options[self::ORDER] );
					$initializeManager = true;

			}
		}else {
			$this->orderField = $this->generateOrderField();
			$initializeManager = true;
		}

		if( !$this->selfKey ){
			$this->selfKey = $this->from;
		}

		if( !$this->foreignKey ){
			$this->foreignKey = $this->to;
		}

		if( $initializeManager ){
			$linkManager = Manager::getManager($this->linkModel);
			$linkManager->init();

		}

		
		$this->options[self::PRIORITY] = "0";

	}

	/**
	 * Setter
	 * @see link()
	 * @param Object $value une valeur que l'on veut lier à l'association
	 */
	public function set( $values ) {

	//trace($values);
		if( is_numeric($values) || is_a( $values , $this->to )) {
			return $this->link($values);
		}
		if( is_array( $values ) ){
			return $this->link($values);
		}

		return $this->link( explode("," , $values ) );

	}

	/**
	 * Getter
	 * @return $this NtoNAssoc renvoie l'association
	 */
	public function get() {
		return $this;
	}

	/**
	 * Supprime toutes les liaisons associées à cette association
	 * @return boolean resultat de la requete
	 */
	public function unlinkAll() {

		$this->items = null;
		$this->links = array();
		
		$linkManager = Manager::getManager( $this->linkModel );
		return $linkManager->delete()->where($this->selfKey, $this->model->id())->all();

	}

	/**
	 * Supprime la liaisons passée en paramètre et liée à cette association
	 * @return boolean resultat de la requete
	 */
	public function unlink( $o ) {

		if( !is_array( $o ) ) {
			return $this->unlink( array( $o ) );
		}

		foreach( $o as $item ) {

			if( is_a( $item , $this->to ) ) {
				if( $item->id || $item->insert() ) {
					array_push( $this->removes , $item->id );
				}
			}elseif( is_numeric( $item ) ) {
				array_push( $this->removes , $item );
			}

		}
		/*
		if( !is_array( $o ) ) {
			return $this->unlink( array( $o ) );
		}

		$linkManager = Manager::getManager( $this->linkModel );

		$selfId = $this->model->id();

		foreach( $o as $item ) {
			if( is_a( $item , $this->to ) ) {
				if( $item->id || $item->insert() ) {
					array_push( $this->removes , $item->id );
				}
			}elseif( is_numeric( $item ) ) {
				array_push( $this->removes , $item );
			}
		}

		if( $this->removes && $selfId ) {
			$delete = $linkManager->delete()
				->where($this->selfKey , $selfId)
				->whereIn($this->removes, $this->linkModel.".".$this->foreignKey );

			$this->items = null;

			return $delete->all();
		}

		 */
	}

	/**
	 * Ajoute la liaisons passée en paramètre à cette association
	 * @param Object $o objet, généralement un model que l'on lie à cette association
	 */
	public function link( $o ) {

		if( !is_array( $o ) ) {
			return $this->link( array( $o ) );
		}

		foreach( $o as $item ) {

			if( is_a( $item , $this->to ) ) {
				if( $item->id || $item->insert() ) {
					array_push( $this->adds , $item->id );
					//$this->links[$item->id] = $item;
				}
			}elseif( is_numeric( $item ) ) {
				array_push( $this->adds , $item );
			}
		}

                /*
                trace($this->to);

                trace("link adds");
                foreach( $this->adds as $add ){
                        trace($selfId." ".$add);
                }
                trace($this->adds);
                trace("link adds");

                   
                if( $this->adds && $selfId ) {
			
			$insert = $linkManager->insert()
					      ->ignore();
			$insert->values = array( $this->selfKey, $this->foreignKey );
			foreach( $this->adds as $add ){
				$insert->row( array( $selfId, $add ) );
			}
			$this->items = null;
			
			return $insert->all();

		}
                    */

	}

	/**
	 * Insert les liaisons associées à cette association en BD si celle-ci ne le sont pas déjà
	 * @return int résultat de la requête d'insert
	 */
	public function insert() {
	// trace("********************************************************");
	// trace("$this->selfKey => ".$this->model->id());
		$selfId = $this->model->id;

		if( $this->adds && $selfId ) {

			$this->events->dispatchEvent( ManagerEvent::BEFORE_LINK , array($selfId, $this->adds) );

			$linkManager = Manager::getManager( $this->linkModel );

			$insert = $linkManager->insert()
				->ignore();
			// $insert->values = array( $this->selfKey, $this->foreignKey );
			foreach( $this->adds as $add ) {
				$insert->row( array( $this->selfKey => $selfId, $this->foreignKey => $add ) );
			}
			$this->items = null;
			//trace("$insert");

			$res = $insert->all();

			if($res)
			{
			    $this->events->dispatchEvent( ManagerEvent::AFTER_LINK , $this );
			}

			return $res;
		}
	}

	/**
	 * Supprime les liaisons associées à cette association en BD
	 * @return int résultat de la requête de delete
	 */
	public function delete() {
		$linkManager = Manager::getManager( $this->linkModel );
		$selfId = $this->model->id;
		if( $this->removes && $selfId ) {
			$delete = $linkManager->delete()
				->where($this->selfKey , $selfId)
				->whereIn($this->removes, $this->linkModel.".".$this->foreignKey );

			$this->items = null;

			return $delete->all();
		}
	}

	/**
	 * Retourne une requete retournant tous les elements de l'association
	 * @see DbQuery
	 * @return DbQuery requete prete à être executée
	 */
	public function select() {

		$manager = Manager::getManager( $this->to );

		if( !$this->model->id() ) {

			return DbQuery::dummy();

		}

		$linkManager = Manager::getManager( $this->linkModel );

		$query = $manager->select();
		$query->tables[$this->linkModel] = $linkManager->table;
		//$query->fields[] = "`{$this->linkModel}`.*";
                
                $primaries = Field::getPrimaryFields($this->to);
                $idField = array_shift($primaries);
                //trace($idField);
		$query->where( "{$this->linkModel}.{$this->selfKey} = {$this->model->id}" );
		$query->where( "{$this->to}.{$idField->name} = {$this->linkModel}.{$this->foreignKey}");
		//trace("$query");
		if( $this->orderField ) {
			//trace("full:".$this->orderField->fullname);
			$query->orderBy( array( $this->orderField->fullname => "ASC" ) );
		}
		//$o = $query->one();
		//trace("ID => ". get_class($o) ."_".$o->id());
		return $query;

	}

	/**
	 * Permet de générer un model correpondant à une table d'association dans la BD à partir des valeurs du from et du to enregistrés dans cette assoc
	 * @see Model::generate()
	 */
	protected function generateModel( $linkModel = null ) {

		if( $linkModel == null ) {
			$names = array( $this->from, $this->to );
			sort( $names );

			if( $this->options[self::SIMPLE] ) {
				$linkModel = "{$names[0]}_{$names[1]}";
			}else {
				if( $this->options[self::SYMETRY] ) {
					$symetricField = Field::getField( $this->options[self::SYMETRY] );
					$fieldNames = array( $this->name , $symetricField->name );
					sort( $fieldNames );
					$linkModel = "{$names[0]}_{$names[1]}_{$fieldNames[0]}_{$fieldNames[1]}";
				}else {
					$linkModel = "{$names[0]}_{$names[1]}";
				}

			}

		}

		if( !class_exists( $linkModel ) ) {
			Model::generate( $linkModel , DbManager , LinkModel );
		}

		$this->linkModel = $linkModel;

		if( !$this->selfKey ){
		    $this->selfKey = $this->from;
		}
		if( !$this->foreignKey ){
		    $this->foreignKey = $this->to;
		}


		//Field::create( "{$linkModel}.id", SimpleKeyField );
	
		Field::create( "{$this->linkModel}.{$this->selfKey}", NtoOneAssoc , array( Assoc::TO => $this->from , Field::PRIMARY => true ) );
		Field::create( "{$this->linkModel}.{$this->foreignKey}", NtoOneAssoc , array( Assoc::TO => $this->to , Field::PRIMARY => true ) );

	}

	/**
	 * Génère un champ d'ordre pour l'association
	 * @param string $name nom de base du champ
	 * @return Field le champ d'ordre
	 */
	protected function generateOrderField( $name = null ) {

		if( !$name ) $name = "{$this->linkModel}.ordre";

		//trace("name:".$name);
		$f = Field::create( $name , OrderField );
		
		//$m = Manager::getManager( $this->linkModel );
		//$m->init();

		return $f;
	}

	public function reorder( $ids ) {
		if( !is_array($ids) ){
			$ids = explode(",",$ids);
		}
		if( $this->orderField ) {

			$foreignKey = $this->options[self::KEY]; // par exemple, parent
			$manager = Manager::getManager( $this->linkModel );

			$select = $this->select();
			$select->fields = array("{$this->linkModel}.{$this->foreignKey}" , "`order`" => "FIND_IN_SET( {$this->linkModel}.{$this->foreignKey} , " . $select->quote(join(",",$ids)) . " )");
			$select->whereIn( $ids , "{$this->linkModel}.{$this->foreignKey}" );
			//$select->having( "{$this->to}.order <> order" );
			//trace("$select");
			$tmpTable = "Ordered{$this->to}";
			$select->createTemp( $tmpTable );

			$update = $manager->update()
				->from( $tmpTable )
				//->using( $manager->table )
				->where("{$this->linkModel}.{$this->selfKey} = '{$this->model->id}'")
				->where("$tmpTable.{$this->foreignKey} = {$this->linkModel}.{$this->foreignKey}");

			$update->values = array( 
				"{$this->orderField->fullname}" => "$tmpTable.order"
			);
			//trace("$update");
			//trace("$update");
			//Session::message("$update");
			//$this->links = array();
			$n = $update->run();
		
			return $n;
		//trace("Updates : $n");

		}

	}

	/**
	 * Ne retourne rien car les tables d'association ne correspondent pas à un champ de BD
	 */
	function asDbColumn() {
		return;
	}

	/** ArrayAccess interface **/

	function offsetSet( $offset, $value ) {
	// not implemented yet
	}

	function offsetExists( $offset ) {
	//return $this->select()->where("{$this->linkModel}.{$this->foreignKey} = '$offset'")->count() > 0;
	}

	function offsetUnset( $offset ) {
	//return $this->delete()->where("{$this->linkModel}.{$this->foreignKey} = '$offset'")->one() ;
	}
	/**
	 * TODO: apparemment, l'objet créé automatiquement est mal mémorisé dans $this->links
	 * @param <type> $offset
	 * @return <type>
	 */
	function offsetGet( $offset ) {
		//trace("getting $offset");
		$m = Manager::getManager( $this->linkModel );

		if( is_a( $offset, $this->to )){
			$f = $offset;
		}else{
			$foreignManager = Manager::getManager( $this->to );
			$f = $foreignManager->get( $offset );
		}
	
		if( array_key_exists( $f->id , $this->links ) ){
			
			return $this->links[$f->id];
		}

		if( $f ){
                   
			$o = $m->find(array(
			    "{$this->foreignKey}" => $f->id,
			    "{$this->selfKey}" => $this->model->id
			));
		    
		    /*$m->select()
				->where("{$this->linkModel}.{$this->foreignKey} = ".$m->quote( $f->id ))
				->where("{$this->linkModel}.{$this->selfKey} = ".$m->quote( $this->model->id ));*/
			//trace("$q");
			//$o = $q->one();

			if( !$o && $this->model->id ){
				//trace("toto");
				$o = new $this->linkModel;
				$o->{$this->foreignKey} = $f->id;
				$o->{$this->selfKey} = $this->model->id;
				//trace( $f->id . "=>". $this->model->id );
				//die();
			}

			if( $o ){
				
				$this->links[$f->id] = $o;
			}

			return $o;
		}
	}

	public function isSimple(){
		return count( Field::getFields( $this->linkModel ) ) == 2;
	}

}

?>
