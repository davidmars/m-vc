<?

//A AMELIORER :
//la fonction delete() qui prend forcement un id de nom "id" => elle devrait prendre n'importe quel cle primaire du modele cible ($this->to)


/**
 *
 * Classe Field chargée des associations 1 à N, par exemple une propriété "enfants" dans une arborescence.
 *
 * @package Core.model
 * @subpackage Assoc
 *
 **/
class OneToNAssoc extends NAssoc {

	public $value = array();
	/**
	 *
	 * @var array Cache de tous les modèles associés
	 * @see OneToNAssoc::all
	 */
	protected $all;

	/**
	 *
	 * @var array Tableau des modèles à lier au prochain update/insert
	 */
	public $adds = array();
	/**
	 *
	 * @var array Tableau des ids à ajouter
	 * @see NtoNAssoc::link
	 */
	protected $removes = array();

	/**
	 * Constructeur
	 * @param string $path Nom de l'association
	 * @param array $options options à intégrer à l'association comme ses liaisons, sa clé, son ordre, etc...
	 */
	public function __construct( $path , $options = array() ) {

		if( $options[self::SYMETRY] ) {

			$symetryField = Field::getField( $options[self::SYMETRY] );
			if( $symetryField && ! $options[self::KEY] ) {
				$options[self::KEY] = $symetryField->name;
			}

		}

		if( !$options[self::KEY] ) {
			if( $options[self::TO] == $this->from ) {
				$options[self::KEY] = "parent";
			}else if( $options[self::TO] ) {
					$options[self::KEY] = strtolower( $options[self::TO] );
				}
		}

		parent::__construct( $path, array_merge(self::$defaults,$options) );
		$this->options[self::PRIORITY] = "0";

		//trace($options);
		if( $this->options[self::ORDERED] ) {
		//trace("ordered");
			if( $this->options[self::ORDER] ) {

				$f = Field::getField($this->options[self::ORDER]);
				if( $f ) {
					//trace("f".$f." - ".$this->options[self::ORDER]);
					$this->orderField = $f;
				}else {

					$this->orderField = $this->generateOrderField( $this->options[self::ORDER] );

				}
			}else {
				$this->orderField = $this->generateOrderField();

			}
		}
	
	}
	/**
	 * Attache l'association au modèle passé en paramètre.
	 * 
	 * @param Model $model Le modèle auquel ajouter ce champ
	 * @return Field Le champ d'association attaché au modèle
	 */
	public function attach( $model ) {

		$foreignKey = $this->options[self::KEY];
		//trace($this->orderField);
		/*
		if( $model->id && $this->orderField ) {

			$this->orderField->query->where("{$this->to}.$foreignKey = {$model->id}");
		
		}
		 */

		return parent::attach( $model );

	}

	/**
	 * Setter
	 * @see link()
	 * @param array $value une valeur que l'on veut lier à l'association
	 */
	public function set( $values ) {

	/*
	if( !$this->model->id() ) {
	    $this->model->insert();
	}
	*/

		$this->link( $values );
	}

	/**
	 * Getter
	 * @return NtoNAssoc $this renvoie l'association
	 */
	public function get() {

		return $this;

	}

        /**
	 * Supprime toutes les liaisons associées à cette association
	 * @return boolean resultat de la requete
	 */
	public function unlinkAll() {

                $foreignKey = $this->options[self::KEY];
                $manager = Manager::getManager( $this->to );
                
                $update = $manager->update();
                $update->values = array( $foreignKey => 0 );
                $update->where($foreignKey , "{$this->model->id}" );

                return $update->run();

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

	    	if( is_array( $o ) ) {
			$r = 0;
			foreach( $o as $item ) {
				$r += $this->link( $item );
			}
			return $r;
		}

		if( is_string( $o ) && strpos($o,",") ) {
			return $this->link( split(",", $o) );
		}

		if( is_numeric( $o ) ) {
			$manager = Manager::getManager( $this->to );
			$o = $manager->get( $o );
		}

		//foreach( $o as $item ) {
		    array_push( $this->adds , $o );
		//}

	}


	public function reorder( $ids ) {

		if( $this->orderField ) {

			$foreignKey = $this->options[self::KEY]; // par exemple, parent
			$manager = Manager::getManager( $this->to );

			$select = $this->select();
			$select->fields = array("{$this->to}.id" , "`order`" => "FIND_IN_SET( {$this->to}.id , " . $select->quote(join(",",$ids)) . " )");
			$select->whereIn( $ids , "{$this->to}.id" );
			//$select->having( "{$this->to}.order <> order" );
			$tmpTable = "Ordered{$this->to}";
			$select->createTemp( $tmpTable );

			$update = $manager->update()
				->from( $tmpTable )
				//->using( $manager->table )
				->where("$tmpTable.id = {$this->to}.id");

			$update->values = array( "{$this->orderField->fullname}" => "$tmpTable.order");
			//trace("$update");
			$n = $update->run();
			return $n;
		//trace("Updates : $n");

		}

	}

	/**
	 * Retourne tous les enregistrements liés à cette association
	 * @return array enregistrements retournés par la requête SQL
	 */
	public function all() {
		if( $this->all !== null ) {
			return $this->all;
		}
		$q = $this->select();
		if( !$q ) {
			$this->all = array();

		}else {
			$this->all = $q->all();
		}
		return $this->all;

	}

	/**
	 * Retourne une requête select initialisé pour retourner les enregistrements liés à cette association
	 * @see DbQuery
	 * @return DbQuery requete select prête à être utilisée
	 */
	public function select() {

		$manager = Manager::getManager( $this->to );
		$foreignKey = $this->options[self::KEY];

		if( $this->model->id() ) {
			$q = $manager->select()->where( "{$this->to}.{$foreignKey} = ".$manager->quote($this->model->id) );
			if( $this->orderField ) {
			//trace("full:".$this->orderField->fullname);
				$q->orderBy( array( $this->orderField->fullname => "ASC" ) );
			}
			return $q;
		}
	}
	/**
	 * Génère un champ d'ordre pour l'association
	 * @param string $name nom de base du champ
	 * @return Field le champ d'ordre
	 */
	private function generateOrderField( $name = null ) {

		if( !$name ) $name = "{$this->to}.{$this->from}_{$this->name}_order";

		//trace("name:".$name);
		$f = Field::create( $name , OrderField );
		$m = Manager::getManager( $this->to );
		if( $m ){
			$m->init();
		}

		return $f;
	}



	/**
	 * Lors d'une insertion comprenant ce champ d'assoc on s'assure de mettre à jour tous les identifiants des enregistrements liés à cette association
	 * @return boolean résultat de la requête de mise à jour des identifiants
	 */
	public function insert() {
	//définir la foreignKey dans tous les items linkés

	   $foreignKey = $this->options[self::KEY]; // par exemple, parent
	    $manager = Manager::getManager( $this->to );

	    $update = $manager->update();
	    $update->values = array( $foreignKey => $this->model->id );

	    $adds = array();
	    foreach($this->adds as $key => $item) {
		    if( is_a( $item , $this->to ) ) {
			    if( $item->id || $item->insert() ) {
				array_push( $adds , $item->id );
			    }
		    }
	    }

	    //trace($item)
	    $update->whereIn($adds , "{$this->to}.id" );
	    //trace("$update");
	    if($adds)
	    {
		return $update->run();
	    }
	}

	/**
	 * Supprime les liaisons associées à cette association en BD
	 * @return int résultat de la requête de delete
	 */
	public function delete() {

	    $foreignKey = $this->options[self::KEY];
	    $manager = Manager::getManager( $this->to );

	    $update = $manager->update();
	    $update->values = array( $foreignKey => 0 );
	    $update->whereIn($this->removes , "{$this->to}.id" );
	    return $update->run();

	}

	/**
	 * Ne retourne rien car les tables d'association étrangères (NAssoc) ne correspondent pas à un champ de BD
	 */
	function asDbColumn() {

		if( $this->orderField ) {
			return $this->orderField->asDbColumn();

		}

	}

}
