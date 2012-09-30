<?
/**
 *
 * Manager pour base de données ...
 *
 * Initialisation :
 * <code>
 * MonModele::$manager = new Manager();
 * </code>
 * Utilisation :
 *  - Récupérer l'instance ayant pour ID 12
 * <code>
 * MonModele::$manager->get( 12 );
 * </code>
 *  - Sélectionner toutes les instances de MonModele ayant comme valeur "param" = "toto"
 * <code>
 * MonModele::$manager->select()->where("param = 'toto'")->all();
 * </code>
 *
 * @package Core.model
 * @subpackage db
 *
 **/
class DbManager extends Manager
{

/**
 *
 * @var DbConnection Connection de BDD cible
 */
	public $source;

	/**
	 *
	 * @var string Nom de la table de BDD cible
	 */
	public $table;

	/**
	 *
	 * @var array Ordre par défaut dans lequel renvoyer les modèles, au format array("champ"=>"ASC" ou "DESC")
	 */
	public $order = array();

	/**
	 *
	 * @var DbConnection Connection de BDD cible par défaut
	 */
	public static $cnx;

	/**
	 *
	 * @var boolean Si true, trace les requêtes sans les executer
	 * @see Debug
	 */
	public $trace = false;

	/**
	 *
	 * @var boolean Si true, crée et altère les tables automatiquement
	 */
	public static $autoTables = false;

	/**
	 * Constructeur
	 * @param Model $model model associé au manager
	 * @param array $table
	 * @param DbConnection connection établie avec la base de données
	 */
	public function __construct( $model , $table = null , DbConnection $cnx = null )
	{
		parent::__construct( $model );

		// TODO : mauvaise initialisation : les propriétés définies sont effacées...
		$this->source = ($cnx != null) ? $cnx : self::$cnx;
		//trace($this->source);

		if( $table && !$this->table )
		{
			$this->table = $table;
		}

		if($this->table == null)
		{
			$this->table = $model;
		}

		$q = new DbManagerQuery();
		$q->source = $this->source;
		$q->manager = $this;

		$q->tables[ $this->model ] = $this->table;
		$q->orderBy = $this->order;

		$this->__query__ = $q;

	}

	/**
	 * Permet de générer une string exprimant un ensemble de conditions WHERE suivant les données passées en paramètres
	 * @param array $keys liste des conditions à formater
	 * @param string $op opérateur à utiliser pour faire la jointure entre toutes les conditions
	 * @return string string formatée afin d'etre ajoutée à une requête SQL (retourne 1 au cas où aucune condition n'a pu etre formaté)
	 */
	function makeConditions( $keys = array() , $op = "AND" )
	{
		$conditions = array();

		foreach( $keys as $k => $v )
		{
			if(strpos( $k , "." ))
			{
				$cond = "{$k} = ". $this->source->quote($v);
			}else
			{
				$cond = "{$this->model}.{$k} = ". $this->source->quote($v);
			}

			array_push( $conditions, $cond);
		}

		return count($conditions) ? join(" $op ",$conditions) : "1";
	}

	/**
	 * Crée la partie ORDER BY d'une requête
	 * TODO : à déplacer dans DbQuery
	 *
	 * @param array $keys Tableau contenant les noms de colonnes au format, avec ASC comme ordre par défaut
	 * @return string Le composant ORDER BY d'une requête
	 */
	protected function makeOrder( $keys = array() )
	{
		$orders = array();

		foreach( $keys as $k => $v )
		{

			if(is_integer( $k ))
			{
				$k = $v;
				$v = "ASC";
			}

			if(strpos( $k, "."))
			{
				$order = "{$k} {$v}";
			}else
			{
				$order = "{$this->model}.{$k} {$v}";
			}

			array_push( $orders, $order );
		}

		return (count( $orders ) ? (" ORDER BY ".join(",", $orders)) : "");
	}

	/**
	 * Execute une requete SQL passée en paramètre
	 * @param string $query requete SQL
	 * @return array|int Retourne le résultat de la requete SQL sous la forme d'un tableau de lignes, ou du nombre de résultats affectés
	 * @see DbConnection::fetchAll()
	 */
	public function query( $query )
	{

	// trace($query);
		$result = $this->source->query( $query );

		if($result === false)
		{
		//trace("QUERY : ".$query);
		//trace("db error #".$this->source->errorCode() );
		//trace($this->source->errorInfo());
			return false;
		}

		if(is_numeric($result))
		{
		//trace($query);
		//trace($result);
			return $result;
		}

		try
		{

			$resultArray = $result->fetchAll();
			//trace($resultArray);
			$output = array();

			foreach( $resultArray as $k => $row )
			{
			//trace($row);
				if( is_array( $row[$this->model] ) )
				{
					$row = array_merge( $row , $row[$this->model] );
				}
				$output[] = $this->make( $row );
			}
			return $output;

		}catch(Exception $e )
		{

			trace("$e");
			return $result;
		}


	}

	/**
	 * Permet de retourner le premier enregistrement trouvé via une requete de selection suivant les conditions passées en paramètres
	 * @param array $keys liste des conditions de la requête
	 * @return DbStatement résultat de la requête executée
	 */
	public function find( $keys = array())
	{
	    if( $this->useCache ){
		$useCache = true;
		$ids = array();
		foreach( $this->keys as $f ){
		    if( isset( $keys[$f->name]) ){
			$ids[] = $keys[$f->name];
		    }else{
			$useCache = false;
			break;
		    }
		}

		
	    }
	   // trace("Searching ".join("-",$ids));
	    //trace(array_keys( $this->cache));
	    if( $useCache && $o = $this->cache[ join("-",$ids) ] ){
		return $o;
	    }
	    
	    return $this->select()
		    ->where( $this->makeConditions( $keys ) )
		    ->one();
	}

	/**
	 * Permet de retourner tous les enregistrements trouvés via une requete de selection suivant les conditions passées en paramètres
	 * @param array $keys liste des conditions de la requête
	 * @return DbStatement résultat de la requête executée
	 */
	public function findAll( $keys = array() )
	{

		return 	$this		->select()
		->where( $this->makeConditions( $keys ) )
		->all();

	}

        public function lock($flag = true, $type = null)
        {
            $q = clone $this->__query__;
            $q->type = ($flag===true)?DbQuery::LOCK:DbQuery::UNLOCK;
            $q->fields = array("`{$this->model}`.*");
            $q->mod($type);
            //trace($q."");
            $this->source->query( $q );
        }

	/**
	 * Initialise une requête de selection avec les paramètres transmis
	 * @param array $args ensemble des paramètres passés afin de constituer la requête select
	 * @return DbManagerQuery requête contenant l'ensemble des données necessaires à son execution
	 */
	public function select()
	{
		$args = func_get_args();

		$q = clone $this->__query__;
		$q->type = DbQuery::SELECT;
		if( $args )
		{
			$q->fields = $args;
		}else
		{
			$q->fields = array("`{$this->model}`.*");
		}
		return $q;
	}

	/**
	 * Initialise une requête de suppression avec les paramètres transmis
	 * @param array $args ensemble des paramètres passés afin de constituer la requête delete
	 * @return DbManagerQuery requête contenant l'ensemble des données necessaires à son execution
	 */
	public function delete()
	{

		$q = clone $this->__query__;
		$q->type = DbQuery::DELETE;

		return $q;

	}

	/**
	 * Initialise une requête d'insertion avec les paramètres transmis
	 * @param array $args ensemble des paramètres passés afin de constituer la requête insert
	 * @return DbManagerQuery requête contenant l'ensemble des données necessaires à son execution
	 */
	public function insert()
	{

		$q = clone $this->__query__;
		$q->type = DbQuery::INSERT;

		return $q;
	}

	/**
	 * Initialise une requête de mise à jour avec les paramètres transmis
	 * @param array $args ensemble des paramètres passés afin de constituer la requête update
	 * @return DbManagerQuery requête contenant l'ensemble des données necessaires à son execution
	 */
	public function update()
	{
		$q = clone $this->__query__;
		$q->type = DbQuery::UPDATE;

		return $q;
	}

	public function quote( $str )
	{
		return $this->source->quote( $str);
	}

	/**
	 * Initialise une requête permettant de générer une table avec les paramètres transmis
	 * @param array $args ensemble des paramètres passés afin de constituer la requête create table
	 * @return DbManagerQuery requête contenant l'ensemble des données necessaires à son execution
	 */
	public function generateTable()
	{
		$q = "CREATE TABLE IF NOT EXISTS `{$this->table}`";

		$f = array();
		$indexes = array();

		foreach( Field::getFields( $this->model ) as $fieldName => $fieldDef )
		{

			$dbField = $fieldDef->asDbColumn();

			if($dbField)
			{
				$sqlField = $dbField->asMySQL();
				array_push( $f , $sqlField );
				switch( $dbField->key )
				{
					case DbColumn::INDEX :
						array_push( $indexes , "KEY `{$dbField->name}` ( `{$dbField->name}` ) " );
						break;
					case DbColumn::PRIMARY :
						array_push( $indexes , "PRIMARY KEY `{$dbField->name}` ( `{$dbField->name}` ) " );
						break;
					case DbColumn::UNIQUE :
						array_push( $indexes , "UNIQUE KEY `{$dbField->name}` ( `{$dbField->name}` ) " );
						break;
				}
			}

		}

		$q .= "( ";
		if( $f )
		{
			$q .= join(",", $f );
		}
		if( $indexes )
		{
			$q .= " , ".join("," , $indexes );
		}

		$q .= " )";

		$q .= " ENGINE = MYISAM DEFAULT CHARSET=utf8";

		return $this->query($q);

	}

	/**
	 * Permet de lancer l'execution d'une requête de mise à jour pour le model transmis en paramètre
	 * @param Object $obj généralement un objet de type Model contenant toutes les données à mettre à jour
	 * @return boolean résultat de la requete de mise à jour
	 */
	public function doUpdate( $obj )
	{

		$this->events->dispatchEvent( ManagerEvent::BEFORE_UPDATE , $obj );

		$q = clone $this->__query__;

		$q->type = DbQuery::UPDATE;

		$values = array();

		$fields = Field::getFields( $obj );

	/*foreach( $this->unmake($obj) as $k => $v) {
	  //  trace($k);
		$f = $fields[$k];
		$c = $f->asDbColumn();
	    if( $v !== null && $c->name == $k ) {
			$values["$c->name"] = $v;
	    }
	}*/

		foreach( $this->unmake($obj) as $k => $v)
		{
			$f = $fields[$k];
			$col = $f->asDbColumn();
			//trace("$k => $v");
			//trace("col : $col");

			if( $col->name == $f->name )
			{
				$values["$k"] = $this->quote( $v );
			}
		}
		//trace($values);
		$q->values = $values;
		
		

		/*if( $obj->id )
		{
			$q->where("`id` = ".$this->quote($obj->id));
		}elseif( $f = $obj->code )
		{
			$q->where("`{$f->name}` = " .$this->quote( $obj->{$f->name} ) );
		}else
		{
			$q->where("0");
		}*/

		foreach( $this->keys as $f ){

			$q->where("`{$f->name}` = ".$q->quote( $obj->field($f->name)->serialize() ));

		}

		//trace("$q");

		//trace($q->__toString());
		if( $this->trace )
		{
			trace($q->__toString());
			return;
		}

		$r = $q->run();

		if($r)
		{
			$this->events->dispatchEvent( ManagerEvent::AFTER_UPDATE , $obj );

			return true;
		}else
		{
			return false;
		}


	}

	/**
	 * Permet de lancer l'execution d'une requête d'insertion pour le model transmis en paramètre
	 * @param Object $obj généralement un objet de type Model contenant toutes les données à inserer
	 * @param array $args tableau de parametres pouvant etre utiles lors des triggers BEFORE_INSERT et AFTER_INSERT
	 * @return boolean résultat de la requete d'insertion
	 */
	public function doInsert( $obj, $args = array() )
	{       
            	$this->events->dispatchEvent( ManagerEvent::BEFORE_INSERT , $args );

		$q = clone $this->__query__;

		$q->type = DbQuery::INSERT;

		$values = array();

		$fields = Field::getFields( $obj );

		foreach( $this->unmake($obj) as $k => $v)
		{

			$f = $fields[$k];

			$col = $f->asDbColumn();

			if( $col->name == $f->name )
			{
			//trace("k : ".$k." v : ".$v);
			//trace($col);
			//trace(get_class($v));
				$values["$k"] = $this->quote($v);
			//trace("kvalue => ".$values["$k"]);
			}
		}
		
		$q->row( $values );

		if( $this->trace )
		{
			trace(xdebug_get_function_stack( ));
			trace($q->__toString());
			return;
		}

		$r = $q->run();
		
		if($r !== false)
		{
		//trace("LAST INSERT ID : ".$q->source->lastInsertId());
                    if($obj->id  == null ) {
			$obj->id = $q->source->lastInsertId();
                    }
		//return true;
		}else
		{
			return false;
		}

		$this->events->dispatchEvent( ManagerEvent::AFTER_INSERT , $args );

		return true;


	////// TODO: dans les insert() vérifier que c'est bien un insert que l'on doit faire et pas un update()

	////// TODO: dans les insert() des OntToNAssoc il faut définir la foreign key des items liés

	}

	/**
	 * Permet de lancer l'execution d'une requête de suppression pour le model transmis en paramètre
	 * @param Object $obj généralement un objet de type Model contenant toutes les données à supprimer
	 * @return boolean résultat de la requete de suppression
	 */
	public function doDelete( $obj, $args = array() )
	{
                $this->events->dispatchEvent( ManagerEvent::BEFORE_DELETE , $args );

                $q = $this->delete();

		if( $obj->id() )
		{
			$q->where( "id" , $obj->id() );
		}
                else
		{
                    $cond = array();
                    $unmaked = $this->unmake($obj);
		    
		    $primaries = array();
		    $uniques = array();
		    
                    foreach($unmaked as $k => $v ){
                        $f = Field::getField($obj, "$k");
                        if( $f->options[Field::PRIMARY] /*|| $f->options[Field::UNIQUE]*/ ){
                            $primaries[$k] = $v;
                        }
			if( $f->options[Field::UNIQUE] ){
			    $uniques[$k] = $v;
			}

                    }
		    
		    if( $primaries ){
			$cond = $primaries;
		    }else{
			$cond = $uniques;
		    }

                    if( $cond ){
                        foreach( $cond as $k => $v ){
                            $q->where( $k , $v );
                        }
                    }else{
			foreach( $unmaked as $k => $v)
			{

				if( $v != null )
				{
					$q->where( $k , $v );
				}
			}
                    }
		}
                
		if( $this->trace )
		{
			trace($q->__toString());
			return;
		}
		//trace($q->__toString());
		$r = $q->run();

                $this->events->dispatchEvent( ManagerEvent::AFTER_DELETE , $args );

		return $r;

	}

	/**
	 * Renvoie la table telle que effectivement présente dans la BD (pas celle correspondant au Model)
	 * @return DbTable La table dans la base
	 */
	private function getDbTable()
	{
		$table = new DbTable( $this->table );
		$r = $this->source->query("SHOW COLUMNS FROM `{$this->table}`");

		if( $r === false )
		{
			return array();
		}

		foreach( $r->fetchAll() as $field )
		{
		//trace( $field );

			$f = $field["COLUMNS"];
			$newField = new DbColumn( $f['Field'] );
			$newField->type = $f['Type'];
			$newField->null = $f['Null'];
			$newField->key = $f['Key'];
			$newField->default = $f['Default'];
			$newField->extra = $f['Extra'];
			//trace($newField);
			$table->add( $newField );

		}

		//trace($table->create());

		return $table;
	}

	/**
	 * Renvoie les colonnes d'index de la table
	 */
	private function getDbIndexes()
	{
		$r = $this->source->query("SHOW INDEXES FROM `{$this->table}`");
		return $r;
	}

	/**
	 * Vérifie que la table correspond bien au modèle associé.
	 * Si non, soit on crée / altère la table si $mutate est TRUE, soit on lance une exception
	 * @param boolean $mutate True pour tenter d'altérer ou créer la table automatiquement
	 */
	public function checkTable( $mutate = true )
	{
		
		try
		{
			$currentTable = $this->getDbTable();
		}catch( DbException $e  )
		{
			
		}
		$modelTable = DbTable::fromModel( $this->model );

		if( $mutate )
		{

			if( !$currentTable || !$currentTable->columns )
			{

				$modelTable->doCreate( $this->source );

			}else
			{

				$currentTable->doAlterTo( $this->source , $modelTable );

			}
		}else
		{
			throw new Exception("Table `{$this->table}` doesn't correspond to Model definition [{$this->model}]");
		}

	}

	/**
	 * Permet de lancer l'execution d'une requête de suppression de tous les enregistrements de la table associé au DbManager
	 * @return boolean résultat de la requete de suppression
	 */
	public function clearAll()
	{
		return $this->query("TRUNCATE TABLE `{$this->table}`");
	}

	/**
	 * Initialisation du manager.
	 * Si self::$autoTables est à TRUE, on vérifie la table et on la créé / altère si nécessaire
	 */
	public function init()
	{
		//trace("init");
		//trace($this->model);
		if( DbManager::$autoTables === true )
		{
			$this->checkTable();
		}

		return parent::init();
	}

}

?>