<?
/**
 *
 * Classe représentant une table de base de données
 *
 * @see DbColumn
 *
 * @package Core.model
 * @subpackage db
 *
 */
class DbTable {
	/**
	 *
	 * @var string Nom de la table
	 */
	public $name;
	/**
	 *
	 * @var string Moteur de la table
	 */
	public $engine = "MYISAM";
	/**
	 *
	 * @var string Encodage des caractères de la table
	 */
	public $charset = "utf8";

	/**
	 *
	 * @var array Tableau des colonnes de la table
	 */
	public $columns = array();
	/**
	 *
	 * @var array Tableau des clés primaires de la table
	 */
	public $primaries = array();
	/**
	 *
	 * @var array Tableau des indexes de la table
	 */
	public $indexes = array();
	/**
	 *
	 * @var array Tableau des colonnes uniques de la table
	 */
	public $uniques = array();

	/**
	 *
	 * @var Log Log de modification des tables
	 */
	public $log;

	/**
	 * Constructeur
	 * @param string $name Nom de la table
	 * @param array $columns Tableau de DbColumn de la table
	 */
	public function __construct( $name , $columns = array() ){
		$this->name = $name;
		foreach( $columns as $col ){
			$this->add( $col );
		}
		$this->log = new Log("alter-$name");
	}

	/**
	 * Ajoute une colonne à la table
	 *
	 * @param DbColumn $dbCol Colonne à ajouter
	 */
	public function add( DbColumn $dbCol ){
		if( $dbCol->name ){
			
			$this->columns[$dbCol->name] = $dbCol;
			
			switch( $dbCol->key ){
				case DbColumn::PRIMARY :
					$this->primary( $dbCol );
				break;
				case DbColumn::INDEX :
					$this->index( $dbCol );
				break;
				case DbColumn::UNIQUE :
					$this->unique( $dbCol );
				break;
			
			}
		}
	}

	/**
	 * Crée une clé primaire sur les colonnes passées en paramètre
	 * @param DbColumn $dbCols Colonne(s) à indexer en temps que clé primaire
	 */
	public function primary( $dbCols ){
		
		$args = func_get_args();
		if( count( $args ) > 1 ){
			foreach( $args as $arg ){
				$this->primary( $arg );
			}
		}elseif( is_a( $dbCols , DbColumn ) ){
			$this->primaries[$dbCols->name] = $dbCols;
			
			// si on a une clé primaire non-unique, on va également indexer chaque colonne
			if( count( $this->primaries ) > 1 ){
        		$this->indexes = array_merge( $this->primaries , $this->indexes );
			}
			
		}
	}

	/**
	 * Crée un index (multiple) sur les colonnes passées en paramètre
	 * @param DbColumn $dbCols Colonne(s) à indexer en tant que clé multiple
	 */
	public function index( $dbCols ){
		$args = func_get_args();
		if( count( $args ) > 1 ){
			foreach( $args as $arg ){
				$this->index( $arg );
			}
		}elseif( is_a( $dbCols , DbColumn ) ){
			$this->indexes[$dbCols->name] = $dbCols;
		}
	}

	/**
	 * Crée un index unique sur les colonnes passées en paramètre
	 * @param DbColumn $dbCols Colonne(s) à indexer en tant que clé unique
	 */
	public function unique( $dbCols ){
		$args = func_get_args();
		if( count( $args ) > 1 ){
			foreach( $args as $arg ){
				$this->index( $arg );
			}
		}elseif( is_a( $dbCols , DbColumn ) ){
			$this->uniques[$dbCols->name] = $dbCols;
		}
	}
	
	/**
	 * Renvoie une requête (texte) de création de la table
	 * @return string Requête CREATE TABLE IF NOT EXISTS ...
	 */
	public function create() {
        $q = "CREATE TABLE IF NOT EXISTS `{$this->name}`";
		$columns = array();
        $indexes = array();
        $primary = "";
        
        sort( $this->primaries );
		        
        foreach( $this->columns as $name => $dbColumn ) { 
          	array_push( $columns , $dbColumn->asMySQL() ); 
        }
        
        if( $this->primaries ){
        	$primary = "PRIMARY KEY ( ";
        	$first = true;
        	foreach( $this->primaries as $name => $col ){
       			if( !$first ) $primary .= " , ";
        		$primary .=  "`{$col->name}`";
        		$first = false;        	
			}
        	$primary .= " ) ";
        }
        
        foreach( $this->indexes as $name => $dbColumn ) { 
        
          	array_push( $indexes , "KEY `$name` ( `$name` )" ); 
        
        }
        
        foreach( $this->uniques as $name => $dbColumn ) { 
        
          	array_push( $indexes , "UNIQUE KEY `$name` ( `$name` )" ); 
        
        }
        
        $q .= "( ";
        
        $q .= join(" , ", $columns );
                
		if( $primary ){
			$q .= " , ".$primary;
		}
		if( $indexes ){
			$q .= " , ". join(" , ", $indexes );
		}

        $q .= " )";

        $q .= " ENGINE = {$this->engine} DEFAULT CHARSET={$this->charset}";
		//trace($q);
		return $q;
        
    }

	/**
	 * Renvoie une requête ALTER TO ayant pour schéma de destination la table $table
	 * @param DbTable $table Table de destination
	 * @return string Requête d'altération de la table
	 */
    public function alterTo( DbTable $table ){
    	
    	$alters = array();
    	$adds = array();
    	$removes = array();
    	
    	sort( $this->primaries );
		sort( $table->primaries );

		
    	foreach( $table->columns as $name => $toCol ){
    		
    		$fromCol = $this->columns[$name];
    		if( !$fromCol ){
    			array_push( $adds , $toCol );
			}elseif( !$toCol ){
				array_push( $removes , $toCol );
			}else{
				$alters[$fromCol->name] = $toCol;
			}
    		
		}
		
		$changes = array();
		
		$sanitize = "`['\" ]*`siu";
						
		foreach( $alters as $name => $column ){
			
			$old = $this->columns[ $name ];				
			
			if( preg_replace( $sanitize , "" ,  $column->asMySQL() ) != preg_replace( $sanitize , "" ,  $old->asMySQL() ) ){
				array_push( $changes , " MODIFY " . $column->asMySQL() );
			}
			
		}
		foreach( $adds as $column ){
			array_push( $changes , " ADD ". $column->asMySQL() );
			//$this->query("ALTER TABLE `{$this->table}` ADD " . $column->asMySQL() );
		}
		foreach( $removes as $column ){
			array_push( $changes , " DROP ". $column->asMySQL() );
		}
		//trace($this->primaries);
		//trace($table->primaries);
		if( array_keys( $this->primaries ) != array_keys( $table->primaries ) ){
			if( $this->primaries ){
				array_push( $changes, " DROP PRIMARY KEY " );
			}

			if( !empty( $table->primaries ) ){
				$primary = "PRIMARY KEY ( ";
				$first = true;
				foreach( $table->primaries as $name => $col ){
					if( !$first ) $primary .= " , ";
					$primary .=  "`{$col->name}`";
					$first = false;
				}
				$primary .= " ) ";


				array_push( $changes , " ADD $primary" );
			}else{
				throw new Exception("No primary key defined in {$table->name}");
			}
		}

		/*
		// TODO : ALTER avec UNIQUE et KEYS
		foreach( $this->indexes as $name => $dbColumn ) { 
        
          	array_push( $indexes , "KEY `$name` ( `$name` )" ); 
        
        }
        
        foreach( $this->uniques as $name => $dbColumn ) { 
        
          	array_push( $indexes , "UNIQUE KEY `$name` ( `$name` )" ); 
        
        }
		*/		
		if( $changes ) {
			$query = "ALTER TABLE `{$this->name}` " . join(",", $changes);
		}else{
			$query = "";
		}
		//trace($this);
		//trace($query);
		return $query;		
    	
	}

	/**
	 * Crée la table sur la connection $db
	 * @param DbConnection $db Connection de BD cible
	 * @return DbStatement Résultat de la requête
	 */
        public function doCreate( DbConnection $db ){
            return $db->query( $this->create() );	
	}

	/**
	 * Altère la table sur la connection $db, pour l'adapter à la structure $to
	 * @param DbConnection $db Connection de BD cible
	 * @param DbTable $to Table de destination
	 * @return DbStatement Résultat de la requête
	 */
	public function doAlterTo( DbConnection $db , DbTable $to ){
		$q = $this->alterTo( $to );
		if( $q ){
			$this->log->write($q);
			//try{
				return $db->query( $q );
			//}catch( DbException $e ){
				//trace($e->query);
			//	trace($e->query);
			//}
		}else{
			return true;
		}
	}

	/**
	 * Convertit un modèle en table de base de données
	 * @see Field::asDbColumn
	 * @param string $model Nom du modèle
	 * @return DbTable Une table de BD contenant les colonnes nécéssaires au stockage du modèle
	 */
	public static function fromModel( $model ){
		$m = Manager::getManager( $model );
		$table = new DbTable( $m->table );
		
		foreach( Field::getFields( $model ) as $name => $field ){
			$col = $field->asDbColumn();
			if( is_array( $col ) ){
				foreach( $col as $c ){
					$table->add( $col );
				}
			}else if( $col ){
				$table->add( $col );
			}
			
		}
		
		return $table;
	}

}

?>