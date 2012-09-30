<?
/**
 * Classe représentant une colonne de base de données, conçue pour être compatible avec des requête SHOW COLUMNS
 *
 * @see DbTable
 *
 * @package Core.model
 * @subpackage db
 */
class DbColumn {

	/**
	 * Primaire
	 */
	const PRIMARY 	= "PRI";
	/**
	 * Unique
	 */
	const UNIQUE 	= "UNI";
	/**
	 * Index
	 */
	const INDEX 		= "MUL";
	/**
	 * Auto-increment
	 */
	const AUTO_INCREMENT = "auto_increment";

	/**
	 *
	 * @var string Nom de la colonne
	 */
	public $name;
	/**
	 *
	 * @var string Type de colonne (ex: text, varchar(255), int(255))
	 */
	public $type = "text";
	/**
	 *
	 * @var string Nullabilité : NO si non null, YES si null
	 */
	public $null = "NO";
	/**
	 *
	 * @var string Valeur par défaut
	 */
	public $default = "";
	/**
	 *
	 * @var string Options supplémentaires (ex: auto_increment)
	 */
	public $extra = "";

	/**
	 *
	 * @param string $name Nom de la colonne
	 */
	public function __construct( $name ){
		$this->name = $name;
	}

	/**
	 * Renvoie une représentation de la colonne utilisable dans une requête CREATE TABLE ou ALTER TABLE
	 * @return string Représentation MySQL de la colonne
	 */
	function asMySQL(){
		
		$outp = "`{$this->name}` {$this->type} ";
		
		if( $this->null == "NO" ){
			$outp .= "NOT NULL ";
		}	
		
		$outp .= "{$this->extra} ";

		if( $this->default ){
			$outp .= "DEFAULT {$this->default}";
		}
			
		return $outp;
	}

}

?>