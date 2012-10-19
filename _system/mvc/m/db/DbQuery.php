<?
/**
 *
 * Classe d'écriture de requête, présentant l'avantage d'être chaînable et aggrégable (sous-requêtes)
 *
 * @package Core.model
 * @subpackage db
 */
class DbQuery implements IteratorAggregate
{

/**
 * Requête select
 */
	const SELECT = "SELECT";
	/**
	 * Requête update
	 */
	const UPDATE = "UPDATE";
	/**
	 * Requête insert
	 */
	const INSERT = "INSERT";
	/**
	 * Requête delete
	 */
	const DELETE = "DELETE";
	/**
	 * Requête Union
	 */
	const UNION = "UNION";

	/**
	 *
	 * @var string Type de requête
	 */
	public $type;

	/**
	 *
	 * @var array Champs pour un SELECT, avec "nom de colonne"=>"alias"
	 */
	public $fields = array();
	/**
	 *
	 * @var array Valeurs pour un INSERT ou un UPDATE
	 */
	public $values = array();
	/**
	 *
	 * @var array Tables pour un FROM ou INTO, avec "nom de table"=>"alias"
	 */
	public $tables = array();
	/**
	 *
	 * @var array Conditions WHERE, liées par un AND
	 */
	public $where = array();
	/**
	 *
	 * @var array Conditions HAVING, liées par un AND
	 */
	public $having = array();
	/**
	 *
	 * @var array Requêtes UNION supplémentaires
	 */
	public $union = array();
	/**
	 *
	 * @var array Champs ORDER BY, avec "nom de colonne" => "direction(ASC|DESC)"
	 */
	public $orderBy = array();
	/**
	 *
	 * @var array Champs GROUP BY
	 */
	public $groupBy = null;
	/**
	 *
	 * @var array Valeurs LIMIT, donc un tableau de 1 ou 2 integers
	 */
	public $limit = null;
	/**
	 *
	 * @var boolean Ajoute DISTINCT à un SELECT si true
	 */
	public $distinct = false;
	/**
	 *
	 * @var boolean Ajoute IGNORE à un INSERT si true
	 */
	public $ignore = false;
	/**
	 *
	 * @var boolean Rend la requête inopérante si true
	 */
	public $dummy = false;
	/**
	 *
	 * @var array Tableau des LEFT JOIN avec "nom de table"=>"alias"
	 */
	public $leftJoin = array();
	/**
	 *
	 * @var array Tableau des conditions ON
	 */
	public $on = array(
	"leftJoin" => array()
	);
	/**
	 *
	 * @var array Tables USING, avec "nom de table" => "alias"
	 */
	public $using = array();
	/**
	 *
	 * @var array Lignes à insérer lors d'un INSERT multiple
	 */
	public $rows = array();

	/**
	 *
	 * @var string Nom d'une table temporaire
	 */
	public $temporaryTable;

	/**
	 *
	 * @var DbConnection Connection BD cible
	 */
	public $source = null;

	/**
	 *
	 * @var array Resultats de la requête
	 */
	public $results;

	/**
	 * Constructeur
	 * Initialise la requête avec des paramètres de base passés en paramètre
	 *
	 * @param string $type type de requete executée
	 * @param array fields regroupe l'ensemble des champs affectées par la requête (id, name, etc..)
	 * @param array $tables regroupe l'ensemble des tables affectées par la requête (FROM)
	 * @param array $where regroupe l'ensemble des conditions de recherche de la requête (WHERE)
	 * @param array $orderBy regroupe l'ensemble des champs par lesquels on ordonne la requête (ORDER BY)
	 * @param array $groupBy regroupe l'ensemble des champs qui sont regroupés (GROUP BY)
	 * @param array $limit représente la limitation au niveau du nombre de résultats retournés
	 **/
	public function __construct( $type = null , $fields = array(), $tables = array(), $where = array(), $orderBy = array(), $groupBy = null, $limit = array() )
	{
		$this->type = $type;
		$this->fields = $fields;
		$this->tables = $tables;
		$this->where = $where;
		$this->orderBy = $orderBy;
		$this->groupBy = $groupBy;
		$this->limit = $limit;
	}

	/**
	 * Ajoute des guillemets autour d'une expression et l'échappe
	 * (Alias de DbConnection::quote)
	 *
	 * @param string $val La chaine à échapper
	 * @return string La chaine échappée
	 */
	public function quote( $val )
	{
		return $this->source->quote( $val );
	}

	/**
	 * Retourne le résultat d'une requete SELECT avec les arguments passés en paramètre
	 *
	 * @return DbQuery une requête select initialisée avec les paramètres passés à la fonction
	 */
	public static function select()
	{
		$args = func_get_args();
		return new DbQuery( DbQuery::SELECT, $args );
	}

	/**
	 * Ajoute un type de champ et eventuellement sa valeur (tableau associatif) dans un INSERT (exemple insert table (ICI, ICI, ICI) values (ET_LA, ET_LA, ET_LA)   )
	 *
	 * @param array $values ensemble des valeurs a inserer (ET_LA). Peut aussi être un tableau associatif contenant des clés (ICI) couplées à leur valeur (ET_LA)
	 *  @return DbQuery $this
	 */
	public function row( $values )
	{
		if( !$this->values )
		{
		//trace(array_keys($values));
			$this->values = array_keys( $values );
		}else if( count( $this->values ) != count( $values ))
			{
				return $this;
			}

		array_push( $this->rows , $values );

		return $this;
	}

	/**
	 * Ne sélectionne que les champs passés en paramètres
	 * Attention : pas de possibilités d'alias
	 *
	 * @return DbQuery $this
	 */
	public function fields()
	{
		$this->fields = func_get_args();
		return $this;
	}
	/*
	public function field( $str ){
		$this->fields = split(",",$str);
		return $this;
	}*/

	/**
	 * Ajoute une table à la liste des tables composant le FROM de la requete
	 *
	 * @param string $table table à ajouter au from de la requete
	 * @param string $alias l'alias donné à la table passé en paramètre
	 * @return DbQuery la requete
	 */
	public function from($table, $alias = null)
	{

		if( $alias == null )
		{
			$this->tables[$table] = $table;
		}else
		{
			$this->tables[$alias] = $table;
		}

		return $this;
	}

	/**
	 * Ajoute une table à la liste des tables composant le USING de la requete
	 *
	 * @param string $table table à ajouter au using de la requete
	 * @param string $alias l'alias donné à la table passé en paramètre
	 * @return DbQuery la requete
	 */
	public function using($table, $alias = null)
	{

		if( $alias == null )
		{
			$this->using[$table] = $table;
		}else
		{
			$this->using[$alias] = $table;
		}

		return $this;
	}

	/**
	 * Ajoute une condition à la liste des conditions composant le WHERE de la requete. Cette condition est sous la forme de xx in ('', '', etc...)
	 *
	 * @param array $values liste des valeurs recherchées parmis le champ passé en paramètre
	 * @param string $field champ sur lequel on effectue une recherche
	 * @param boolean $include Si false, on exclut les valeurs au lieu de les inclure
	 * @return DbQuery la requete
	 */
	public function whereIn( $values = array() , $field = "id" , $include = true )
	{

		if( is_a( $values , DbQuery ) )
		{
			return $this->where( "$field ".( $include ? " " : "NOT " ) ."IN ($values)");
		}
		if( is_array( $values ) && !empty( $values ) )
		{
			return $this->where( "$field ".( $include ? " " : "NOT " )."IN (".join( "," , array_map( array( $this->source, "quote" ) , $values ) ).")" );
		}

		// si il n'y a pas de valeurs, on renvoie une requete vide
		return $this->where(0);
	}
	/**
	 * Rajoute des valeurs pour un insert ou un update
	 *
	 * @param array|DbQuery $values Valeurs sous forme array ou DbQuery
	 */
	public function values( $values = array() )
	{
		$this->values = $values;
		return $this;
	}

	/**
	 * Ajoute une condition à la liste des condition composant le WHERE de la requete
	 *
	 * Exemple :
	 *  - $query->where("id = '12'")
	 *  - $query->where("id" , 12 )
	 *  - $query->where("order" , ">" , 50 )
	 *
	 * @param string $args paramètres nécessaires à la composition de la condition
	 * @return DbQuery la requete
	 */
	public function where( )
	{
		$args = func_get_args();

		switch( count( $args ) )
		{
			case 2:
			// equality
				array_push( $this->where, "`$args[0]` = ".$this->source->quote( $args[1] ) );
				break;
			case 3:
			// operator
				array_push( $this->where, "`$args[0]` $args[1] ".$this->source->quote( $args[2] ) );
				break;
			default:
			// raw condition
				foreach( $args as $arg )
				{
					array_push( $this->where , $arg );
				}
				break;
		}

		return $this;
	}

	/**
	 * Ajoute une condition à la liste des condition composant le HAVING de la requete
	 *
	 * @param string $args paramètres nécessaires à la composition de la condition
	 * @return DbQuery la requete
	 */
	public function having( )
	{
		$args = func_get_args();

		switch( count( $args ) )
		{
			case 2:
			// equality
				array_push( $this->having, "`$args[0]` = ".$this->source->quote( $args[1] ) );
				break;
			case 3:
			// operator
				array_push( $this->having, "`$args[0]` $args[1] ".$this->source->quote( $args[2] ) );
				break;
			default:
			// raw condition
				foreach( $args as $arg )
				{
					array_push( $this->having , $arg );
				}
				break;
		}

		return $this;
	}

	/**
	 * Ajoute une demi-jointure à la requete
	 *
	 * @param string $table table ajoutée par cette demi-jointure
	 * @param string $alias alias donné à la table jointe
	 * @param string $on condition de la demi-jointure
	 * @return DbQuery la requête
	 */
	public function leftJoin( $table , $alias , $on )
	{

		$this->leftJoin[$alias] = $table;

		if( !is_array( $this->on["leftJoin"][$alias]) )
		{
			$this->on["leftJoin"][$alias] = array();
		}

		array_push( $this->on["leftJoin"][$alias] , $on );
		return $this;
	}

	/**
	 * Ajoute une condition à la liste des conditions composant le WHERE de la requete. Cette condition est sous la forme de xx not in ('', '', etc...)
	 *
	 * @param string $field champ sur lequel on effectue une recherche
	 * @param array $values liste des valeurs recherchées parmis le champ passé en paramètre
	 * @return DbQuery la requete
	 */
	public function notIn( $field , $values )
	{

		$qValues = array_map( array( $this->source , "quote" ) , $values );

		return $this->where( "$field NOT IN (". join(",",$qValues).")");
	}

	/**
	 * Ajoute un ordre de classement à la requete
	 *
	 * @param string $args liste des champs permettant le classement de la requete
	 * @return DbQuery The modified request
	 */
	public function orderBy( $order )
	{
		$this->orderBy = $order;
		return $this;
	}

	/**
	 * Ajoute un groupement sur un champ à la requete
	 *
	 * @param string $field champ regrouper dans la requete
	 * @return DbQuery la requete
	 */
	public function groupBy( $field )
	{
		$this->groupBy = $field;
		return $this;
	}

	/**
	 * Ajoute une limite la requete
	 *
	 * @param string $args paramètres définissant la limite à appliquer à la requete
	 * @return DbQuery la requete
	 */
	public function limit()
	{
		$args = func_get_args();
		//$args = array_map( "intval", $args );
		$this->limit = $args;
		return $this;
	}

	////////////////////////////////////////////////////////////// FLAGS //////////////////////////////////////////////////////////////


	/**
	 * Ajoute un DISTINCT à la requete
	 *
	 * @param boolean $flag booléen précisant la présence ou non d'une clause distinct
	 * @return DbQuery la requete
	 */
	public function distinct($flag = true)
	{
		$this->distinct = $flag;
		return $this;
	}

	/**
	 * Ajoute un IGNORE à la requete
	 *
	 * @param boolean $flag booléen précisant la présence ou non d'une clause ignore
	 * @return DbQuery la requete
	 */
	public function ignore($flag = true)
	{
		$this->ignore = $flag;
		return $this;
	}

	/**
	 * Permet de formater la requête SQL en une string interpretable par mySQL suivant les attributs précedemment enregistrés
	 *
	 * @return string requête prête à être interprétée par mySQL
	 */
	public function __toString()
	{
		switch( $this->type )
		{
			case DbQuery::SELECT :
				return $this->formatSelect();
				break;
			case DbQuery::UPDATE :
				return $this->formatUpdate();
				break;
			case DbQuery::INSERT :
				return $this->formatInsert();
				break;
			case DbQuery::DELETE :
				return $this->formatDelete();
				break;
			case DbQuery::UNION :
				return $this->formatUnion();
				break;
		}
	}

	/**
	 * Permet de formater une requête SQL de type SELECT
	 *
	 * @return string requête prête à être interprétée par mySQL
	 */
	private function formatSelect()
	{

		$query = "{$this->type}";

		if( $this->distinct )
		{
			$query .= " DISTINCT";
		}
		
		$query .= "\n";

		if( empty( $this->fields ) )
		{
			$query .= "*";
		}else
		{
			$first = true;
			foreach( $this->fields as $k => $f )
			{
				if(!$first)
				{
					$query .= ",\n";
				}
				if( is_a( $f , DbQuery ) )
				{
					$f = "\t($f)";
				}
				if( !is_numeric( $k ) )
				{

					$query .= "\t{$f} AS {$k}";

				}else
				{

					$query .= "\t{$f}";

				}
				$first = false;
			}

		}

		$query .= "\nFROM (\n";

		$query .= $this->formatTables()."\n";

		$query .= ")\n";

		$query .= $this->formatLeftJoins()."\n";

		//$query .= $this->formatUnions();

		$query .= "WHERE\n";

		if( empty( $this->where ) )
		{
			$query .= "1";
		}else
		{
			$query .= "\t(".join(") \n\tAND (", $this->where ).")";
		}
		
		$query .="\n";

		if( !empty( $this->groupBy ) )
		{
			$query .= "\tGROUP BY {$this->groupBy}\n";
		}

		if( !empty( $this->having ) )
		{
			$query .= "HAVING \n\t(".join(")\n\tAND (", $this->having ).")\n";
		}

		if( !empty( $this->orderBy ) )
		{
			$query .= "ORDER BY\n";

			$order = array();
			//trace($this->orderBy);
			foreach( $this->orderBy as $field => $dir )
			{
				if( strtoupper($dir) != "ASC" && strtoupper($dir) != "DESC" )
				{
					$field = $dir;
					$dir = "ASC";
				}
				array_push( $order, "$field $dir");
			}
			$query .= "\t".join(" ,\n\t" , $order);
		}

		if( !empty( $this->limit ) )
		{
			$query .= "\nLIMIT ";
			$query .= join(" , ",$this->limit);
		}
		//trace($this);
		
		return $query;

	}

	public function formatUnion()
	{

		$query = "";
		$first = true;

		foreach( $this->union as $q )
		{
			if( $first )
			{
				$first = false;
			}else
			{
				$query .= " UNION ";
			}
			$query .= "($q)";
		}

		if( !empty( $this->groupBy ) )
		{
			$query .= " GROUP BY {$this->groupBy}";
		}

		if( !empty( $this->having ) )
		{
			$query .= " HAVING (".join(") AND (", $this->having ).")";
		}

		if( !empty( $this->orderBy ) )
		{
			$query .= " ORDER BY ";

			$order = array();
			//trace($this->orderBy);
			foreach( $this->orderBy as $field => $dir )
			{
				if( strtoupper($dir) != "ASC" && strtoupper($dir) != "DESC" )
				{
					$field = $dir;
					$dir = "ASC";
				}
				array_push( $order, "$field $dir");
			}
			$query .= join(" , " , $order);
		}

		if( !empty( $this->limit ) )
		{
			$query .= " LIMIT ";
			$query .= join(" , ",$this->limit);
		}

		return $query;

	}
	/**
	 * Formate les tables d'une requête (FROM, INTO)
	 * @return string
	 */
	private function formatTables()
	{

		if( empty( $this->tables) )
		{

			throw new Exception("No tables");

		}else
		{

			$aliases = array();

			foreach( array_reverse($this->tables) as $alias => $table )
			{
				if( is_a( $table, DbQuery ))
				{
					array_push( $aliases , "\t( $table ) AS $alias" );
				}elseif(is_string( $alias ) && $alias != $table)
				{
					array_push( $aliases , "\t`$table` AS $alias" );
				}else
				{
					array_push( $aliases , "\t`$table`" );
				}
			}

			return join( " ,\n", $aliases );
		//$query .= join( "," , $this->tables );
		}

	}

	/**
	 * Permet de formater une requête SQL de type UPDATE
	 *
	 * @return string requête prête à être interprétée par mySQL
	 */
	private function formatUpdate()
	{
		$query = "{$this->type} " ;
		//trace($query);
		$query .= $this->formatTables();

		$query .= $this->formatLeftJoins();

		if( $this->using )
		{
			$query .= " USING ";
			$query .= "`".join("` , `",$this->using)."`";

		}

		$query .= " SET ";

		$updates = array();
		$values = $this->values;
		//trace("values");
		//trace($values);
		foreach( $values as $k=>$v )
		{
			if( strpos( $k , "." ) === false )
			{
				$k = "`$k`";
			}
			array_push( $updates, "$k = ".$v );

		}

		$query .= join( " , " , $updates );

		if( $this->where )
		{
			$query .= " WHERE (". join(") AND (", $this->where) . ")";
		}else
		{
			$query .= " WHERE 1";
		}

		if( !empty( $this->orderBy ) 
			&& ( ( count( $this->tables ) + count( $this->leftJoin) ) <= 1 ) )
		{
			$query .= " ORDER BY\n";

			$order = array();
			//trace($this->orderBy);
			foreach( $this->orderBy as $field => $dir )
			{
				if( strtoupper($dir) != "ASC" && strtoupper($dir) != "DESC" )
				{
					$field = $dir;
					$dir = "ASC";
				}
				array_push( $order, "$field $dir");
			}
			$query .= "\t".join(" ,\n\t" , $order);
		}

		//trace($query);

		return $query;

	}

	/**
	 * Permet de formater une requête SQL de type INSERT
	 *
	 * @return string requête prête à être interprétée par mySQL
	 */
	private function formatInsert()
	{
		$query = "{$this->type}";

		if( $this->ignore )
		{
			$query .= " IGNORE ";
		}

		$query .= " INTO " ;

		$query .= "`".array_shift(array_slice( $this->tables , 0, 1))."`";

		if( $this->rows )
		{
			$keys = array();
			//trace($this->values);
			//trace($this->rows);
			foreach( $this->values as $key)
			{
				array_push($keys, "$key");
			}

			$query .= " ( `".join("` , `", $keys)."` ) ";

			$query .= " VALUES ";

			$rows = array();

			foreach( $this->rows as $values )
			{

				$row = array();

				foreach( $values as $k=>$v )
				{

					array_push( $row, $v /*$this->source->quote($v)*/ );
				}

				array_push( $rows , "(". join(",",$row) .")" );
			}

			$query .= join(" , ", $rows );

		}elseif( $this->values )
		{
		//trace($this->values);
			if( is_array( $this->values ) )
			{
				$query .= " ( `".join("` , `", array_keys( $this->values ) )."` ) ";

				$i = 0;

				$query .= " SELECT * FROM ";

				foreach( $this->values as $v )
				{
					if( $i > 0 )
					{
						$query .= ",";
					}
					if( is_a( $v , DbQuery ) )
					{
						$query .= "($v) as v$i";
					}else
					{
						$query .= $v;
					}
					$i++;
				}

			}elseif( is_a($this->values , DbQuery) )
			{
				$query .= "{$this->values}";
			}
		}else
		{
			return "";
		}

		
		//
		////trace($query);

		return $query;

	}

	/**
	 * Permet de formater une requête SQL de type DELETE
	 *
	 * @return string requête prête à être interprétée par mySQL
	 */
	private function formatDelete()
	{
	//trace("hello");

		$query = "{$this->type} FROM " ;

		$query .= $this->formatTables();
		//$query .= "`".array_pop( array_slice( $this->tables , 0 ) );

		if( $this->using )
		{
			$query .= " USING ";
			$query .= "`".join("` , `",$this->using)."`";

		}

		$query .= " WHERE ";

		if( $this->where )
		{
			$query .= join(" AND ", $this->where);
		}else
		{
			$query .= "1";
		}

		return $query;

	}

	/**
	 * Formatte les LEFT JOIN d'une requête
	 * @return string
	 */
	private function formatLeftJoins()
	{
		$query = "";
		if( $this->leftJoin )
		{
			$first = true;
			foreach( $this->leftJoin as $alias => $table )
			{
				/*if( !$first ) {
					$query .= ",";
				}*/

				$query .= "LEFT JOIN\n";

				if( is_a($table , DbQuery ))
				{
					$query .= "\t($table) AS $alias\n";
				}else
				{
					$query .= "\t$table AS $alias\n";
				}

				if( $this->on["leftJoin"][$alias] )
				{
					$query .= "\tON ( ".join(",",$this->on["leftJoin"][$alias])." )\n";
				}

				$first = false;
			}
		}
		return $query;

	}

	/**
	 * Permet d'envoyer la requete précedemment paramétrée à la base de donnée afin de retourner un résultat mySQL
	 *
	 * @return $obj résultat de la requête (sous forme de int [nombre d'enregistrement affectés] ou de DbStatement qui contient les résultats de la requête SQL
	 */
	public function run()
	{

		if( $this->dummy )
		{
			return array();
		}
                $this->source=  DbManager::$cnx;
		if( $this->source == null && $this->source = DbConnection::getInstance())
		{
			throw new Exception( "No valid DB connection found" );
			//Human::log( "No valid DB connection found","POV DbQuery",Human::TYPE_ERROR );
		}
		//trace($query);
                //Human::log( $query );
		$q = $this->__toString();

		return $this->source->query( $q );

	}

	/**
	 * Permet d'envoyer une requete de comptage du nombre de résultats renvoyés par la requête SQL précedemment paramétrée
	 *
	 * @return string nombre de résultats renvoyés par la requete
	 */
	public function count()
	{

		$expr = "COUNT(*)";

		//$q = clone $this;
		$q = DbQuery::select($expr)
			->from( $this , "__count__" );

		$q->source = $this->source;

		//trace($q->__toString());
		$r = $q->run();
		//trace($r->fetchAll());
		if( $r )
		{
			$r = $r->fetchAll();
			return $r[0][$expr];
		}else
		{
			return 0;
		}
	}

	/**
	 * Evalue une expression arbitraire sur une requête
	 *
	 * @param string $expr Une expression (ex: COUNT(*), MAX(created), ...)
	 * @return mixed L'expression évaluée
	 */

	public function calc( $expr )
	{
		$q = clone $this;
		$q->fields = array($expr);
		// trace("$q");
		// $log = new Log("test");
		// $log->write( "$q" );
		//trace("$q");
		$r = $q->run();
		if( $r )
		{
			$r = $r->fetchAll();
			return $r[0][$expr];
		}else
		{
			return 0;
		}
	}

	/**
	 * Permet d'envoyer une requete ne renvoyant que le premier résultat de la requête SQL précedemment paramétrée
	 *
	 * @return string résultat de la requête
	 */
	public function one()
	{
		$q = clone $this;
		$q->limit(1);

		$r = $q->run();//->fetch( PDO::FETCH_ASSOC );
		if( $r[0] )
		{
			return $r[0];
		}
	}

	/**
	 * Permet d'envoyer une requete renvoyant l'ensemble des résultat de la requête SQL précedemment paramétrée
	 *
	 * @return string résultat de la requête
	 */
	public function all()
	{
	//trace($this);
		$q = $this;
		return $q->run();
	}

	public function createTemp( $tmpName )
	{

		$q = clone $this;
		$q->type = DbQuery::SELECT;

		$this->source->query("DROP TEMPORARY TABLE IF EXISTS `$tmpName`");

		$query = "CREATE TEMPORARY TABLE IF NOT EXISTS `$tmpName` $q";
		//Session::message( "$query");
		//trace($query);
		return $this->source->query($query);
	}

	/**
	 * Renvoie un itérateur sur tous les résultats de la requête
	 *
	 * @return ArrayIterator Itérateur sur tous les résultats de la requête
	 */
	public function getIterator()
	{
		if($this->results == null)
		{
			$this->results = $this->run();
		}
		//trace($r);
		if($this->results)
		{
		//trace(gettype($r));
		//trace(is_array($r) ? "ARRAY" : "NOT AN ARRAY" );
			return new ArrayIterator( $this->results );
		}else
		{
			return new ArrayIterator( array() );
		}
	}
	/*
	public function __get( $field ){
		if( $this->results == null ){
			if($this->limit == null){
				$noLimit = true;
				$this->limit = array(1);
			}
			$this->results = $this->run();
			// leave it unchanged
			if($noLimit){
				$this->limit = null;
			}
		}
		if( count( $this->results ) ){
			$obj = $this->results[0];
			return $obj->{$field};
		}
	}
	*/

	/**
	 * Créé une requête vide.
	 * @return DbQuery requête vide
	 */
	public static function dummy()
	{
		$q = new DbQuery();
		$q->dummy = true;
		return $q;
	}
	/**
	 * Opère un UNION entre plusieurs requetes
	 *
	 * Exemple :
	 * $q1 = User::$manager->select()->where("name LIKE '%A%'");
	 * $q2 = User::$manager->select()->where("name LIKE '%B%'");
	 *
	 * $q = DbQuery::union( $q1 , $q2 )->groupBy("User.id")->all();
	 *
	 * // retourne : SELECT User.* FROM ((SELECT User.* FROM User WHERE name LIKE '%A%') UNION (SELECT User.* FROM User WHERE name LIKE '%A%')) AS User GROUP BY User.id
	 *
	 * @param DbQuery $q1 Requête 1
	 * @param DbQuery $q2 Requête 2
	 * @return DbQuery La requête Union
	 */
	public static function union($q1, $q2)
	{

		$queries = func_get_args();

		$u = new DbQuery( DbQuery::UNION );

		foreach( $queries as $q )
		{
			$u->union[] = $q;
		}

		//$u->source = $queries[0]->source;

		return $u;

	}

}

?>
