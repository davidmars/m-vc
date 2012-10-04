<?
/**
 *
 * Classe de modÃ¨le de base
 *
 * @package Core.model
 *
 **/
class Model implements IteratorAggregate
{

/**
 *
 * @var Manager Le manager de l'instance
 */
	protected $__manager__;

	/**
	 *
	 * @var array Tableau des Field de l'instance
	 */
	public $__fields__ = array();

	/**
	 *
	 * @var array Tableau des Field primaires de l'instance
	 */
	public $__primary__ = array();

	/**
	 *
	 * @var Manager occurence du manager chargÃ© de gÃ©rer le modÃ¨le.
	 * Les modÃ¨les peuvent gÃ©nÃ©ralement Ãªtre rÃ©cupÃ©rÃ©s par:
	 * <code>
	 * ClasseModele::$manager->select()
	 * </code>
	 */
	public static $manager;

	//private $_changed = false;

	/**
	 * Constructeur
	 **/
	public function __construct()
	{

		$this->__manager__ = Manager::getManager( get_class( $this ) );
                //Human::log($this->__manager__,"The fuckin manager!");
	}

	/**
	 * Getter automatique :
	 * est appelÃ© si $this->{$fieldName} n'existe pas.
	 * - renvoie le resultat de l'appel $this->__manager__->{"__get_".$fieldName}( $this ) si la mÃ©thode existe dans le Manager correspondant
	 * (exemple : <code>$user->isAdmin peut renvoyer User::$manager->__get_isAdmin( $user )</code> )
	 * - renvoie la valeur de Field::get si $fieldName correspond Ã  un champ
	 *
	 * @param string $fieldName nom du champ que l'on veut rÃ©cupÃ©rer
	 * @return mixed le champ demandÃ©
	 *
	 * @see Field::get
	 **/
	public function __get( $fieldName )
	{

	// on essaie d'abord en lower-case
	//if(property_exists( $this, strtolower( $fieldName ) )){
	//	return $this->{strtolower($fieldName)};
	//}

	// puis en upper case ...
	//if(property_exists( $this, strtoupper( $fieldName ) )){
	//	return $this->{strtoupper($fieldName)};
	//}

	// puis on essaie de voir si un getter correspondant existe
		if( method_exists( $this->__manager__ , "__get_$fieldName" ))
		{
			return $this->__manager__->{"__get_$fieldName"}( $this );
		}
		//trace("$fieldName");
		$field = $this->field( $fieldName );

		if( $field )
		{
			return $field->get();
		}

	}

	/**
	 * Setter automatique
	 * est appelÃ© lorsque l'on fait $monModel->fieldName = "valeur"
	 * @param string $fieldName du champ auquel on veut insÃ©rer une valeur
	 * @param Object $value valeur que l'on veut insÃ©rer au champ
	 * @return DbStatement rÃ©sultat de l'affectation de la valeur au champ
	 **/
	public function __set( $fieldName, $value )
	{
            
            Human::log("------set in model-----".$fieldName." = ".$value);
            
	// on essaie d'abord en lower-case
		if(property_exists( $this, strtolower( $fieldName ) ))
		{
			return $this->{strtolower($fieldName)} = $value;
		}

		// puis en upper case ...
		if(property_exists( $this, strtoupper( $fieldName ) ))
		{
			return $this->{strtoupper($fieldName)} = $value;
		}


            
		$field = Field::getField( $this, $fieldName );

		if( $field )
		{
			if( false && array_key_exists( $fieldName, $this->__fields__ ) )
			{
                            return $this->__fields__[$fieldName]->setter( $value );
			}else{
                            $newField = $field->attach( $this );
                            $newField->setter( $value );
                            $this->__fields__[$fieldName] = $newField;
			}

		}else
		{

			$this->{$fieldName} = $value;

		}

	//$this->_changed = true;

	}

	/**
	 * Destructeur automatique
	 * est appelÃ© lorsque l'on dÃ©truit le model (e charge de supprimer toutes les propriÃ©tÃ©s qui lui sont liÃ©es
	 **/
	public function __destruct()
	{

	//$this->__manager__->destructModel( $this );

		if( $this->__fields__)
		{
			foreach( $this->__fields__ as $name => $field )
			{
				if( is_a( $field , Assoc ))
				{
					$field->__destruct();
					unset( $field );
				//unset( $this->__fields__[$name] );
				}
				unset( $this->__fields__[$name] );
			}

		}

	//unset($this->__fields__);
	//unset($this->__manager__);

	}

	/**
	 * Retourne une string descriptive du model en cours
	 * @return string description de la classe
	 **/
	public function __toString()
	{
		
		$outp = get_class($this);
		if($this->id())
		{
			$outp .= "#".$this->id();
		}

		$outp .= "{\n";
		foreach( Field::getFields($obj) as $name => $field ){
			if( !is_a($field,Assoc)){
				$outp .= "\t$name : ".$field->get()."\n";
			}
		}
		$outp .= "}\n";
		
		return $outp;
	}

	/**
	 * Renvoie un itÃ©rateur des champs du modÃ¨le, lors d'un appel de type :
	 * <code>
	 * foreach( $monModel as $fieldName => $fieldValue )
	 * </code>
	 *
	 * @return ArrayIterator ItÃ©rateur sur les champs du modÃ¨le
	 */
	public function getIterator()
	{

		$outp = array();

		foreach( Field::getFields( $this ) as $k => $v )
		{
			if( is_a( $v , NAssoc ) )
			{
				$outp[$k] = $this->field($k)->all();
			}else
			{
				$outp[$k] = $this->field($k)->get();
			}
		}

		return new ArrayIterator( $outp );

	}

	/**
	 * Retourne le model sous la forme d'un array
	 * @return array tableau reprÃ©sentant la classe et ses donnÃ©es
	 **/
	public function asArray( $depth = 1 )
	{

		foreach( $this as $k => $v )
		{

			switch( gettype( $v ) )
			{

				case "string":
				case "integer":
				case "NULL":
					$outp[$k] = $v;
					break;

				case "object":
					if( $depth > 1 && method_exists( $v, "asArray" ) )
					{
						$outp[$k] = $v->asArray( $depth - 1 );
					}else
					{
						$outp[$k] = $this->field($k)->serialize();
					}
					break;
				case "array" :

					if( $depth > 1 )
					{
						$arr = array();
						foreach( $v as $k2 => $v2 )
						{
						//trace($v2);
							if( method_exists( $v2 , "asArray" ) )
							{
								$arr[$k2] = $v2->asArray( $depth - 1 );
							}
						}
						$outp[$k] = $arr;
					}

					break;
			}
		}



		return $outp;

	}

	/**
	 * Retourne un champ ayant pour nom celui passÃ© en paramÃ¨tre
	 * @param string $name reprÃ©sentant le nom du champ recherchÃ©
	 * @return Field recherchÃ©
	 **/
	public function field( $name )
	{

		if( !array_key_exists( $name, $this->__fields__ ) )
		{
		//trace(get_class($this). ":".$name);
			$field = Field::getField( $this , $name );
			if( $field )
			{
				$this->__fields__[$name] = &$field->attach( $this );
			}else
			{
				$this->__fields__[$name] = null;
			}

		}

		return $this->__fields__[$name];
	}

	/**
	 * Retourne tous les champs du model
	 * @return array des champs du model
	 **/
	public function fields()
	{
		$outp = array();
		foreach( Field::getFields( $this ) as $name => $field )
		{
			if( !array_key_exists( $name, $this->__fields__ ) )
			{

				$this->__fields__[$name] = $field->attach( $this );

			}
			$outp[$name] = $this->__fields__[$name];
		}
		return $outp;
	}


	/**
	 * crÃ©Ã© une classe Model automatiquement via eval();
	 * Retourne la manager du modÃ¨le
	 * @param string $model nom du model que l'on veut crÃ©er
	 * @param string $manager nom du manager que l'on veut associer Ã  ce model
	 * @param string $superClass nom de la classe dont hÃ©ritera le model Ã  crÃ©er
	 * @return Manager le manager nouvellement crÃ©Ã© et liÃ© au nouveau model
	 **/
	public static function generate( $model, $manager = Manager, $superClass = Model , $hasOwnManager = true )
	{

		$staticProxies = "";
		$validClass = "`^([a-zA-Z0-9_]+)$`si";
		$classes = array_slice( func_get_args() , 0 , 3 );

		foreach( $classes as $c )
		{
			if( !preg_match( $validClass , $c ) )
			{
				throw new Exception( "Class '$c' has an invalid name." );
			}
		}
		/*foreach( array( "get", "find", "findAll", "select" ) as $meth ){
			$staticProxies .= 
				 "static function $meth(){\n"
				."	\$args = func_get_args(); \n"
				."	\$m = Manager::getManager( '$model' ); \n"
			//	."	trace(\$m); "
				."	return call_user_func_array( array( \$m , '$meth' ), \$args ); \n"
				."}\n";
		}*/

		if( $manager != null )
		{
			$managerHook = "$model::\$manager = new $manager( $model )";
		}

		$eval = "";
		if( !class_exists( $model ) )
		{
			$eval .= "class $model extends $superClass { \n"
				.( $hasOwnManager ? "	static \$manager;\n" : "" )
				."	$staticProxies\n"
				."}\n";
		}
		$eval .="$managerHook;\n"
			."return $model::\$manager;\n";

		return eval($eval);

	}

        public static function load( $names ){
		$names = func_get_args();
		foreach( $names as $n ){
			class_exists( $n );
		}

	}

	/**
	 * Mise Ã  jour du modÃ¨le dans sa source de donnÃ©es
	 * @return DbStatement rÃ©sultat de la fonction doUpdate
	 * @see Manager::doUpdate
	 **/
	public function update()
	{

		return $this->__manager__->doUpdate( $this );

	}
	/**
	 * Insertion du modÃ¨le dans sa source de donnÃ©es
	 * @return DbStatement rÃ©sultat de la fonction doInsert
	 * @see Manager::doInsert
	 **/
	public function insert()
	{
            $args = func_get_args();
            array_unshift($args, $this);

            $res = $this->__manager__->doInsert( $this, $args );

            return $res;
	}
	/**
	 * Supression du modÃ¨le dans sa source de donnÃ©es
	 * @return DbStatement rÃ©sultat de la fonction doDelete
	 * @see Manager::doDelete
	 **/
	public function delete()
	{
            $args = func_get_args();
            array_unshift($args, $this);

            $res = $this->__manager__->doDelete( $this, $args );
            //une fois l'enregistrement supprimÃ© de la DB on peut le supprimer de la mÃ©moire
            $this->__manager__->destructModel($this);

            return $res;
	}

	/**
	 * Permet de mettre Ã  jour le model dans la BD (insert ou update)
	 * @return DbStatement rÃ©sultat de la fonction appellÃ©e
	 * @see Model::insert
	 * @see Model::update
	 **/
	public function save()
	{
	//if( $this->_changed ){

		//if( !$this->id() )
		//{
			try
			{
				$insert = $this->insert();
				return $insert;

			}catch(DbException $e ){

				return $this->update();
			}
			//trace("updating");
			
		/*}else
		{
			return $this->update();
		}*/
	//}

	}

	public function id()
	{
		return $this->id;
	}

	public function code()
	{
		$f = Field::getCode( $this );
		if( $f )
		{
			return $this->{$f->name};
		}
	}

	/**
	 * Renvoie le nom du model
	 * S'il possÃ¨de un champ $title, $name ou $code, on le renvoie
	 * Sinon, on renvoie "Nom de la class + id"
	 * @return string nom du modele
	 **/
	public function name()
	{
		foreach( array( "title", "name", "code" ) as $field )
		{
			if( $o = $this->{$field} )
			{
				return $o;
			}
		}
		return get_class($this)." #".$this->id();
	}

}

?>