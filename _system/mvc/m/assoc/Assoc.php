<?
/**
 * 
 * Classe d'association de base
 *
 * @package Core.model
 * 
 **/
class Assoc extends Field {

	/**
	 * Option : string Modèle associé
	 */
	const TO = "to";
	/**
	 * Option : string Identifiant du champ contenant l'association réciproque
	 */
	const SYMETRY = "symetry";
	/**
	 * Option : string Clé d'association
	 */
	const KEY = "key";
	/**
	 * Option : string Identifiant du champ d'ordre, pour les association multiples
	 */
	const ORDER	= "order";
	/**
	 * Option : int Priorité déterminant l'ordre d'insertion et d'update par rapport aux autres Field du modèle
	 */
	const PRIORITY = "priority";
	/**
	 * Option : int booleen déterminant si cette association implique un vidage de cache lorsque l'on applique un vidage de cache
	 * sur son model associé
	 */
	const CACHE_DEPENDANT = "cacheDependant";
	
	/**
	 * Classe de destination
	 * @var Model
	 **/
	public $to;

	/**
	* Constructeur
	* @param Object $path
	* @param Object $options options à intégrer à l'association comme ses liaisons, sa clé, son ordre, etc...
	*/
	public function __construct( $path, $options = array() ){
		
		parent::__construct( $path, array_merge( $this->options, $options ) );
		
		if( $this->options[self::TO] ){
			$this->to = $this->options[self::TO];
		}
		
	}

	/**
	* Renvoit une variable structurée comme une colonne de base de donnée à partir de l'association et de ses caractéristiques
	* @see DbColumn
	* @return DbColumn occurence d'un champ de base de donnée basé sur l'association
	*/
	function asDbColumn(){
		//if( $this->key == $this ){	
			$dbField = new DbColumn( $this->name );
			
                        $primaries = Field::getPrimaryFields($this->to);
                        $idField = array_shift($primaries);
                        
                        //$idField = Field::getField( $this->to , "id" );
			
			if( $idField ){
				$targetField = $idField->asDbColumn();
				$dbField->type = $targetField->type;/*"int(255) unsigned"*/;
			}else{
				$dbField->type = "int(255) unsigned";
			}
			if( $this->options[self::PRIMARY] ){
				$dbField->key = "PRI";
			}else{
				$dbField->key = "MUL";
			}
					
			return $dbField;
		//}	
	}
	
}

?>
