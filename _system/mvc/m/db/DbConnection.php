<?


/**
 * Classe de connection à la base de données utilisé pour remplacer PDO
 *
 */
	class DbConnection {
                /**
                 *
                 * @var int Just a count of performed requests 
                 */
                public static $numberOfRequest=0;
		/**
		 *
		 * @var array Tableau d'index des connections établies
		 */
		public static $instances = array();

		/**
		 *
		 * @var string Serveur hôte
		 */
		public $host;
		/**
		 *
		 * @var string Nom de la base de données
		 */
		public $dbname;
		/**
		 *
		 * @var string Nom du driver (ex: "mysql")
		 */
		public $driver;
		/**
		 *
		 * @var string Nom d'utilisateur
		 */
		public $username;
		/**
		 *
		 * @var string Password
		 */
		public $password;
		/**
		 *
		 * @var array Options du driver
		 */
		public $driverOptions;

		/**
		 *
		 * @var resource Ressource de connection
		 */
		private $resource;
		/**
		 *
		 * @var Log Objet de log des requêtes
		 */
		public $log;

		/**
		 *
		 * @var bool Mode debug (trace toutes les requêtes)
		 */
		public $debug;


		/**
		 * Constructeur
		 * Se connecte à la base de données fournie en paramètre et établit la connection en UTF8
		 *
		 * @param <type> $host
		 * @param <type> $dbname
		 * @param <type> $username
		 * @param <type> $password
		 * @param <type> $driver
		 * @param <type> $driverOptions
		 */
		public function __construct( $host, $dbname , $username = null, $password = null, $driver = "mysql", $driverOptions = array() ) {
                    //Human::log("NEW DB CONNECTION !!!!!!!!!!!!!!!!!!!!!!");
			$this->host = $host;
			$this->dbname = $dbname;
			$this->driver = $driver;
			$this->username = $username;
			$this->password = $password;
			$this->driverOptions = $driverOptions;

			//$this->log = new Log( "db" );
			//parent::__construct( $dsn, $username, $password, $driver_options );
			
			array_push( self::$instances , $this );
                        $this->connect();

		}

		private function connect(){
                        //Human::log("MYSQL CONNECT");
			if( $this->driver == "mysql" ) {
				$this->resource = mysql_connect( $this->host, $this->username, $this->password , true );
				// trace($this->dbname);
				mysql_select_db( $this->dbname , $this->resource );
				mysql_query("set names 'utf8'", $this->resource);
			}
		}

		/**
		 * Execute une requête sur la connection.
		 * Peut lancer une exception en cas d'erreur
		 *
		 * @see DbException
		 * @param string $query La requête à executer
		 * @return DbStatement|int Un DbStatement contenant les lignes en cas de SELECT, un nombre de lignes affectés en cas d'UPDATE, DELETE, INSERT,...
		 *
		 */
		public function query( $query ) {

			if( $this->debug ){
				trace("$query;");
			}

			if( !$this->resource ){
				$this->connect();
			}

			if( $this->log ){
				$this->log->write( "$query" );
			}

			$result = mysql_query( $query , $this->resource );
                        self::$numberOfRequest++;

			if(is_bool($result)) {
				if( $result === false ) {
					$ex = new DbException();
					$ex->query = $query;
					$ex->code = $this->errorCode();
					$ex->message = $this->errorInfo();
					//trace($ex);
					//trace("$query");
					throw $ex;
				}else {

				//trace($result);
				//trace($query);
				//trace("affected : ".mysql_affected_rows());

					return mysql_affected_rows();
				}
			} else {
				return new DbStatement( $result , $this );
			}

		//}
		}
		/**
		 * Renvoie la première instance de DbConnection trouvée
		 * @return DbConnection
		 */
		public function getInstance() {
			if( count( $this->instances ) ) {
				return $this->instances[0];
			}
		}

		/**
		 * Ajoute des guillemets et échappe une string pour l'utiliser comme valeur dans une requête
		 *
		 * @param string $str La chaine d'entrée
		 * @return string La chaine échappée avec les guillemets
		 */
		public function quote( $str ) {
			if( !$this->resource ){
				$this->connect();
			}
			return '"'.mysql_real_escape_string( "$str" , $this->resource ).'"';
		}

		/**
		 * Renvoie le dernier code d'erreur renvoyé par le serveur
		 *
		 * @return int Code d'erreur de BDD
		 */
		public function errorCode() {
			return mysql_errno( $this->resource );
		}
		/**
		 * Renvoie le dernier message d'erreur renvoyé par le serveur
		 *
		 * @return string Message d'erreur de BDD
		 */
		public function errorInfo() {
			return mysql_error( $this->resource );
		}
		/**
		 * Renvoie le dernier identifiant inseré
		 *
		 * @return mixed Dernier identifiant inseré
		 */
		public function lastInsertId() {
			return mysql_insert_id( $this->resource );
		}

	}

	/**
	 * Représente le résultat d'une requête SELECT sur une BDD
	 *
	 */
	class DbStatement {

		/**
		 *
		 * @var array Tableau à deux dimensions des valeurs reçues avec [nom de table][nom de colonne] = valeur
		 */
		public $results = array();
		/**
		 *
		 * @var DbConnection Connection de BDD cible
		 */
		public $cnx;
		/**
		 *
		 * @var resource Réponse brute
		 */
		private $__response__;

		/**
		 * Constructeur
		 * @see DbConnection::query
		 * @param resource $response Identifiant ressource de la réponse
		 * @param DbConnection $cnx Connection source
		 */
		public function __construct( $response , $cnx ) {
			$this->__response__ = $response;
			$this->cnx = $cnx;
		}

		/**
		 * Renvoie toutes les lignes reçues de la BDD
		 * @return array Tableau des résultats reçus, avec pour chaque ligne [nom de table][nom de colonne] = valeur
		 */
		public function fetchAll() {

			$outp = array();

			if( gettype($this->__response__) == "boolean" ) {
				return array();
			}

			$fields = array();
			for($i=0; $i<mysql_num_fields( $this->__response__ ); $i++ ) {
				array_push( $fields, mysql_fetch_field( $this->__response__ , $i ) );
			}

			while( $row = mysql_fetch_array( $this->__response__, MYSQL_NUM ) ) {
				$result = array();
				foreach( $fields as $k => $v ) {
				//trace( $row[$k] );
					$fieldDef = $v;
					$fieldValue = $row[$k];
					$fieldPath = "{$fieldDef->table}.{$fieldDef->name}";
					//trace($fieldDef);
					// trace($fieldValue);
					if( $fieldDef->table ) {
						$result[$fieldDef->table][$fieldDef->name] = $fieldValue;
					//$result[$fieldPath] = $fieldValue;
					}else {
						$result[$fieldDef->name] = $fieldValue;
					}

				}

				array_push( $outp , $result );

			}

			return $outp;
		}

	}

	/**
	 * Classe d'exception de BDD. Utilisée pour gérer les erreurs renvoyées par le serveur de BD
	 */
	class DbException extends RuntimeException {

		/**
		 * Code renvoyé lors de l'insert d'un champ unique pré-éxistant
		 */
		const ERROR_DUPLICATE_ENTRY = 1062;

		/**
		 *
		 * @var array Tableau d'infos sur l'erreur
		 */
		public $errorInfo = array();
		/**
		 *
		 * @var string Message d'erreur
		 */
		public $message = "";
		/**
		 *
		 * @var string Code d'erreur
		 */
		public $code = "";
		/**
		 *
		 * @var string Requête ayant provoqué l'erreur
		 */
		public $query = "";
	}

//}

?>