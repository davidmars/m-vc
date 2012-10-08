<?
/**
 *
 * Champ de base d'un modèle
 *
 * Les Field émulent des propriétés de modèles, en y ajoutant un typage permettant :
 * - de générer les colonnes appropriées dans la BD
 * - de générer des formulaires d'édition automatiquement
 * - de faciliter l'utilisation des modèles dans les templates
 *
 * Example de création d'un champ dans un modèle :
 * <code>
 * // Fichier app/model/MonModele.php
 *
 * // génère le modèle MonModel
 * Model::generate("MonModel", "DbManager");
 *
 * // création de champs
 * Field::create("MonModel.id", IdField);
 * Field::create("MonModel.title", Field);
 * Field::create("MonModel.text", Field);
 * Field::create("MonModel.children", OneToNAssoc , array( Assoc::TO => MonModel ) );
 * </code>
 *
 * @package Core.model
 * @subpackage Field
 */
class Field {

    /**
     * Option : Clé primaire
     */
    const PRIMARY = "primary";
    /**
     * Option : Clé unique
     */
    const UNIQUE = "unique";
    /**
     * Option : Index multiple
     */
    const INDEX = "index";
    /**
     * Option : Longueur maximum
     */
    const LENGTH = "length";
    /**
     * Option : Valeur par défaut
     */
    const DEFAULT_VALUE = "defaultValue";
    /**
     * Option : Pass through
     * Désactive l'interfaçage par get()/set(), en définissant directement la propriété sur l'instance du modèle
     */
    const PASS_THROUGH = "passThrough";
    /**
     * Option : editable
     * Désactive la possibilité de modifier publiquement ce field. Seule manière de l'éditer : passer par une requête de type update
     */
    const EDITABLE = "editable";
    const COMMENTS = "comments";

    /**
     * @var array Options
     */
    public $options = array(
	    //self::PASS_THROUGH => true
    );
    /**
     *
     * @var string the comments found in the code for this field 
     */
    public $comments;
    
    /**
     * Returns the field value that will be readable by an human 
     * @return string A way to get the field value that will be readable by an human 
     */
    public function val(){
        return $this->value;
    }
    
    /*
    public function getDatas(){
        
    }
    */
    /**
     *
     * @var Model Instance du modèle associé
     */
    public $model;

    /**
     *
     * @var array Tableau de champs "parallélisé"
     */
    public $parallels = array();

    /**
     *
     * @var string Nom du modèle associé
     */
    public $from;

    /**
     *
     * @var string Nom complet du champ (Model.champ)
     */
    public $fullname;

    /**
     *
     * @var bool Is the field editable by an admin user?
     */
    public $editableByHuman=true;
    /**
     *
     * @var bool Définit si le field est éditable ou non (lecture seule)
     */
    public $editable;

    /**
     *
     * @var string Nom du champ
     */
    public $name;

    /**
     *
     * @var mixed Valeur du champ
     */
    protected $value;

    /**
     *
     * @var array Index de tous les Field
     */
    static protected $fields = array();

    /**
     *
     * @var array Options par défaut
     */
    static public $defaults = array(
    // array de modèles (par exemple: Langue)
    "parallels" => array()
    );


    /**
    * Constructeur
    * @param string $path
    * @param array $options options à intégrer à l'association comme ses liaisons, sa clé, son ordre, etc...
    */
    public function __construct( $path, $options = array() ) {

	$splitted = preg_split("/\\./", $path);
	$this->fullname = $path;
	$this->from = $splitted[0];
	$this->name = $splitted[1];

        $this->editable = true;
	$this->options = array_merge( self::$defaults , $options );
        $this->comments= $options[self::COMMENTS];
        if(isset($options[self::EDITABLE]) && $options[self::EDITABLE] == false)
        {
            $this->editable = false;
        }

	if( array_key_exists( self::DEFAULT_VALUE , $this->options ) ) {
	    $this->value = $this->options[self::DEFAULT_VALUE];
	}

    }

    /**
    * Destructeur automatique
    * Détruit toutes ses propriétés ici et dans toutes ses liaisons (items)
    */
    public function __destruct() {

	//if( $this->items ) {
	//	foreach( $this->items as $k => $item ) {
	//		$item->__destruct();
	//		$this->items[$k] = null;
	//	}
	//}
	//
	//if( $this->item ) {
	//	$this->item->__destruct();
	unset($this->item);
	unset($this->items);
	//}
	unset($this->model);
	unset($this->from);
	unset($this->to);
	unset($this->value);

	if( $this->model ) {
	    unset($this->model);
	    $this->model = null;
	}
    }

    /**
     * Getter
     * @see Model::__get
     * @return mixed La valeur actuelle du champ
     */
    function get() {
	//trace("hello");
	if( $this->options[self::PASS_THROUGH] ){
	    //trace("pass through");
	    //trace("{$this->name} = {$this->value}");
	    return $this->model->{$this->name};
	}else{
	    //trace("{$this->name} = {$this->value}");
	    return $this->value;
	}
    }
    /**
     * 
     * @return Field Return the field object itself and not its value
     */
    public function getFieldObject(){
        return $this;
    }

    /**
      * Setter
      * @see Model::__set
      * @param mixed $value La nouvelle valeur
      */
    function set( $value ) {
        $this->insideValue = $value;
        Human::log("set field value ".$this->name." = ".$value);
	if( $this->options[self::PASS_THROUGH]){
	    $this->model->{$this->name} = $value;
	}else{
	    $this->value = $value;
	}
    }
    public $insideValue;
    /**
     * Setter publique
     * @see Model::__set
     * @param mixed $value La nouvelle valeur
     */
    function setter ($value)
    {
        //trace("COUCOU : ".$this->from." / ".$this->name." => ".$value);
        if($this->editable)
        {
            $this->set($value);
        }
        else
        {
            
            trigger_error("The field ".$this->name." can't be edited. See the definition of Model '".$this->from."' or the constructors of its assocs", E_USER_ERROR );
        }
    }
   

    /**
     * Renvoie la valeur stockée dans le champ dans un format stockable
     * @return string
     */
    function serialize() {
	return $this->get();
    }

    /**
     * Met à jour la valeur du champ à partir d'une valeur stockée
     * @param string|array $data nouvelle valeur du champ
     */
    function unserialize( $data ) {
	$this->set( $data );
    }

    /**
     * Conversion en string... renvoie $this->value
     * @return string
     **/
    public function __toString() {
	if( $this->options[self::PASS_THROUGH] ){
	//	$this->model->{$this->name} = $value;
	    return "".$this->model->{$this->name};
	}else{
	    return "".$this->value;
	}
    }

    /**
     * Renvoie le champ $name defini pour le modele $obj
     * @param Object $obj généralement un Model auquel est attaché le champ recherché
     * @param string $name nom du champ à rechercher
     * @return Field le champ trouvé
     **/
    static function getField( $obj, $name = null ) {

	if( $name == null ) {
	    // il s'agit d'un nom complet
	    $split = preg_split("/\\./", $obj );
	    $obj = $split[0];
	    $name = $split[1];
	}

	if(is_string( $obj )) {
		    $cl = $obj;
	}else {
	    $cl = get_class( $obj );
	}
	//trace("$cl : ".(class_exists($cl, false) ? "yes" : "no" ) );
	if( class_exists( $cl , true ) && array_key_exists( $cl, self::$fields ) ) {
	    return self::$fields[$cl][$name];
	}

	/*return array();

	$fields = self::getFields( $obj );

	if( array_key_exists( $name, $fields ) ) {
	//trace($fields[$name]);
		return $fields[ $name ];
	}

	return false;*/

    }


    /**
     * Renvoie tous les champs du Model passé en paramètre
     * @param Object $obj généralement un Model, dans lequel on cherche tous les champs
     * @return array les champs correspondant au modèle passé en paramètre
     **/
    static function getFields( $obj ) {

	$fields = array();

	if(is_string( $obj )) {
	    $cl = $obj;
	}else {
	    $cl = get_class( $obj );
	}

	if( class_exists( $cl , true ) && array_key_exists( $cl, self::$fields ) ) {
	    return self::$fields[ $cl ];
	}

	return array();
    }

    /**
     * Renvoie tous les champs primaires du Model passé en paramètre
     * @param Object $obj généralement un Model, dans lequel on cherche tous les champs
     * @return array les champs correspondant au modèle passé en paramètre
     **/
    static function getPrimaryFields( $obj ){

	$outp = array();
	foreach( self::getFields( $obj ) as $name => $field ){
	    if( $field->options[Field::PRIMARY] ){
		$outp[$name] = $field;
	    }
	}
	return $outp;

    }

    /**
    * Renvoie une variable structurée comme une colonne de base de donnée à partir de l'association et de ses caractéristiques
    * @see DbColumn
    * @return DbColumn occurence d'un champ de base de donnée basé sur l'association
    */
    function asDbColumn() {
	$field = new DbColumn( $this->name );
	if( $this->options[self::LENGTH] ) {
	    $field->type = "varchar(".$this->options[self::LENGTH].")";
	}else {
	    $field->type = "text";
	}
	$field->null = "NO";
	$field->extra = "";
	if( $def = $this->options[self::DEFAULT_VALUE] ){
	    $field->extra .= " DEFAULT '".$def."'";
	}

	if( $this->options[self::PRIMARY] ) {
	    $field->key = "PRI";
	}elseif( $this->options[self::UNIQUE] ) {
	    $field->key = "UNI";
	}elseif( $this->options[self::INDEX] ) {
	    $field->key = "MUL";
	}else {
	    $field->key = "";
	}

	return $field;
    }


    /**
     * Attache un clone de l'objet field à une instance de modele:
     * clone le prototype, et définit son "parent"
     * @param Model $obj model auquel on attache le clone du field
     * @return Field le field cloné attaché au model passé en paramètre
     **/
    function attach( $obj ) {
	$field = clone $this;
	$field->model = $obj;
	return $field;

    }

    /**
     * Crée un "prototype" de Field, utilisé pour la configuration
     * Ce "Field" symbolique est ensuite attaché à un objet via "attach"
     * @param string $path chemin où l'on peut trouver le fichier du champ à créer
     * @param Field $fieldType type de champ que l'on veut créer
     * @param array $options liste des options que l'on veut ajouter au champ à créer
     * @return Field nouveau champ créé du type passé en paramètre (par défaut de type Field)
     **/
    static function create( $path , $fieldType = Field, $options = array() ) {

	$fieldDef = new $fieldType( $path, $options );

	self::$fields[$fieldDef->from][$fieldDef->name] = $fieldDef;

	if( $options["parallels"] ) {
	    $parallels = $options["parallels"];
	    if( is_array( $parallels ) ) {
		foreach( $parallels as $pModel => $pTarget ) {
		// pModel est le modèle parallèle (par exemple : MonModel_Langue)
		// pTarget est le modèle de destination (
		    if( is_numeric( $pModel ) ) {

			$fieldDef->parallelize( $pTarget );

		    }else {

			$fieldDef->parallelize( $pTarget , $pModel );

		    }
		}

	    }else {

		$fieldDef->parallelize( $parallels );

	    }
	}

	return $fieldDef;

    }

    /**
     * Supprime un champ
     * @param Model $model model dans lequel on veut supprimer un champ
     * @param string $name nom du champ à supprimer
     **/
    static function remove( $model, $name ) {
	if( is_object($model) ) {
	    $model = get_class( $model );
	}
	//trace("Removing $model...$name");
	unset( self::$fields[$model][$name] );

    }

    /**
     * Fonction chargée de définir des champs "parallels", c a d des champs
     * de type traduit (par langue) par exemple.
     *
     * En gros, on créé un autre modèle ( par exemple : MonModel_Langue ) qui aura:
     * - un ID correspondant à l'id du modèle de base ( $this->to )
     * - un ID correspondant à l'id du modèle de destination ( par exemple Langue )
     *
     * @param Model $target model de destination (par exemple MonModele)
     * @param Model $pModel model de parallelisation (par exemple MonModele_Langue)
     **/

    public function parallelize( $target , $pModel = null ) {

	if( $pModel == null ) {
	    $pModel = "{$this->from}_$target";
	}

	if( !class_exists( $target , true ) ) {
	    throw new Exception( "Model '$target' could not be loaded !" );
	}

	if( !class_exists( $pModel , true ) ) {
	    Model::generate( $pModel , DbManager );

	    $selfId = Field::getField( $this->from , "id" );
	    $targetId = Field::getField( $target , "id" );

	    Field::create( "$pModel.{$this->from}" , NtoOneAssoc , array( "to" => $this->from ) );
	    Field::create( "$pModel.$target" , NtoOneAssoc , array( "to" => $this->target ) );
	}

	// on enlève "parallels" de la liste des options, sans quoi ça tourne en boucle
	$options = $this->options;
	$options["parallels"] = array();

	// le champ en question
	$nestedField = Field::create( "$pModel.{$this->name}" , get_class( $this ) , $options );
	Field::create( "{$this->from}.{$this->name}" , ParallelizedField , array(
	    "to"			=> $target,
	    "linkModel" 	=> $pModel,
	    "selfKey" 		=> $this->from,
	    "foreignKey" 	=> $target,
	    /*"arrayAccess" 	=> $this->name,*/
	    "field"			=> $nestedField
	));

	//trace(Field::getFields("TestNode"));

	$selfManager = Manager::getManager( $this->from );
	$selfManager->checkTables();

	$m = Manager::getManager( $pModel );
	$m->checkTables();

    }

    /**
     * Renvoie le nom du champ
     * @return string nom du champ
     */
    public function name() {
	return ucwords( $this->name );
    }

    /**
     * Renvoie la valeur brute du champ
     * @return mixed La valeur brute (interne)
     */
    public function raw() {
	return $this->value;
    }



}

?>