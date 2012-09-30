<?php
/**
 * Classe de construction requête de BD adaptée à un manager.
 * Les resultats renvoyés sont convertis en Model, et non plus en tableaux
 *
 * @package Core.model
 * @subpackage db
 */
class DbManagerQuery extends DbQuery {

/**
 *
 * @var DbManager Manager cible
 */
	public $manager;
	/**
	 *
	 * @var boolean Active ou désactive la conversion des résultats en modèles
	 */
	private $managed = true;

	/**
	 * Active ou désactive la conversion des résultats en modèles
	 * @param boolean $flag True pour renvoyer des modèles
	 * @return DbManagerQuery
	 */
	public function manage( $flag = true ) {
		$this->managed = $flag;
		return $this;
	}

	/**
	 * Ajoute une ligne pour une requête INSERT. Si le paramètre est un modèle, on le convertit en array
	 * @see Manager::unmake
	 * @param Model|array $obj Item à inserer dans la requête
	 * @return DbManagerQuery
	 */
	public function row( $obj ) {

		if( is_a( $obj , Model )) {
			$obj = $this->manager->unmake( $obj );
		}

		//trace("obj ".$obj);
		return parent::row( $obj );
	}

	/*public function run() {
		if( $this->manager && $this->managed ) {
			return $this->manager->query( $this->__toString() );
		}else {
			return parent::run();
		}
	}*/
	/**
	 * Renvoie tous les résultats d'une requête sous forme de modèles
	 * @return array Tableau de modèles
	 */
	public function all() {
		if( $this->manager && $this->managed ) {
			return $this->manager->query( $this->__toString() );
		}else {
			$r = parent::run();
			return $r->fetchAll();
		}
	}
	/**
	 * Renvoie le premier résultat d'une requête sous forme de modèles
	 * @return Model
	 */
	public function one() {
		$q = clone $this;
		$q->limit(1);
		$r = $q->all();
		if( $r[0] ) return $r[0];
	}

	public function ids(){
		 $q = clone $this;
		 $q->fields("{$this->manager->model}.id");
		 $q->manage(false);

		 $r = $q->all();
		 $outp = array();
		 foreach( $r as $row ){
			 array_push( $outp , $row["{$this->manager->model}"]["id"] );
		 }
		 return $outp;

	}

	/**
	 * Ajoute une table dans FROM. Si $model est effectivement une instance de modèle, on ajoute le nom de la table correspondante
	 * @param Model|string $model objet ou nom de table
	 * @param string $alias Alias du from (AS)
	 * @return DbManagerQuery
	 */
	public function from( $model , $alias = null ) {
		$m = Manager::getManager( $model );

		if( $m ) {
			if( $alias == null ){
				$alias = $model;
			}
			return parent::from( $m->table , $alias );
		}else {
			return parent::from( $model , $alias );
		}

	}

	/**
	 * Ajoute une clause WHERE ... IN ... à la requête.
	 *
	 * @param array|DbQuery $values Valeurs à comparer (à droite)
	 * @param string $field Colonne
	 * @return DbQuery
	 */
	public function whereIn( $values , $field = "id" , $include = true ) {

		$ids = array();
		//trace($values);
		if( is_a( $values , DbQuery )) {
			return parent::whereIn( $values , $field , $include );
		}

		if( !is_array( $values )) {
			$values = explode(",", $values);
		}
		//trace($values);
		foreach( $values as $value ) {
			if( is_a( $value , Model ) ) {
				array_push( $ids ,  $value->id() );
			}else {
				array_push( $ids , $value );
			}
		}

		return parent::whereIn( $ids , $field , $include );

	}
	/**
	 * Ajoute une propriété booléenne nommée $alias aux Models retournés s'ils sont aussi retournés la requête $query
	 *
	 * @param string $alias Nom de la propriété
	 * @param DbQuery $query Requête
	 *
	 */
	public function intersect( $alias , $query ){
		
		$intersection = "Intersect_{$alias}";
		$model = $this->manager->model;

		$otherQuery = clone $query;
		$otherQuery->fields = array( "$model.id" );
		$otherQuery->limit();

		$this->fields[$alias] = "IFNULL( $intersection.id > 0 , 0 )";
		$this->leftJoin( $otherQuery , $intersection , "$intersection.id = $model.id" );

		return $this;

	}

	/**
	 * Méthode magique : Lors du chainage d'une requête, si la méthode appelée n'existe pas sur DbManagerQuery, on recherche son nom sur $this->manager
	 *
	 * Par exemple:
	 * <code>
	 * User::$manager->select()->inGroup(1)
	 * </code>
	 * comme "inGroup" ne correspond pas à une méthode de DbManagerQuery, cette méthode appelle UserManager::__query_inGroup( $dbQuery , 1 )
	 *
	 * Si la méthode n'existe pas non plus dans le DbManager, une erreur est générée
	 *
	 * @param string $func Nom de la fonction appelée
	 * @param array $args Paramètres de la fonction
	 * @return DbManagerQuery
	 */
	public function __call( $func, $args ) {

		if( method_exists( $this->manager , "__query_".$func ) ) {
			array_unshift( $args , $this );
			return call_user_func_array( array( $this->manager , "__query_".$func ) , $args );
		}

                if($events = $this->manager->events->getEvents())
                {

                    //si on a passé la désignation d'un field dans le premier paramètre alors il faut appliquer la fonction à ce field en
                    //particulier, sinon on l'applique au premier obs qui possède cette fonction
                    if(is_array($args[0]) && isset($args[0]["targetField"]))
                    {
                        $targetField = $args[0]["targetField"];
                        foreach($events as $evt)
                        {
                            foreach($evt["callback"] as $callback)
                            {
                                if( $callback[0]->name == $targetField && method_exists( $callback[0] , "__query_".$func ) ) {

                                    //retirer le tableau qui a permis de trouver le bon field
                                    array_shift($args);
                                    array_unshift( $args , $this );
                                    return call_user_func_array( array( $callback[0] , "__query_".$func ) , $args );
                                }
                            }
                        }
                    }
                    else
                    {
                        foreach($events as $evt)
                        {
                            foreach($evt["callback"] as $callback)
                            {
                                if( method_exists( $callback[0] , "__query_".$func ) ) {

                                    array_unshift( $args , $this );
                                    return call_user_func_array( array( $callback[0] , "__query_".$func ) , $args );
                                }
                            }
                        }
                    }
                }

		trigger_error("Call to undefined DbManagerQuery function '$func'", E_USER_ERROR );

	}
	
}
?>