<?php
/**
 *
 * Association 1 à N implémentée selon la technique du Nested Set Model, permettant de gérer plus rapidement les arborescences dans une BDD relationnelle
 *
 * @package core.model.assoc
 * @link http://dev.mysql.com/tech-resources/articles/hierarchical-data.html
 *
 */
class NestedAssoc extends NAssoc {

	/**
	 * Option : Nom du champ de gauche par defaut
	 */
	const LEFT_FIELD = "lft";
	/**
	 * Option : Nom du champ de droite par defaut
	 */
	const RIGHT_FIELD = "rgt";
	/**
	 * Option : Nom du champ de profondeur par defaut
	 */
	const DEPTH_FIELD = "dpt";

	/**
	 * Option du delete : suppression de l'element et de tous ses enfants
	 * Option du moveTo : déplacement de l'element et de tous ses enfants dans l'element cible
	 * Option du moveOutside : déplacement de l'element et de tous ses enfants en dehors du tree
	 */
	const CHILDREN_WITH = "CHILDREN_WITH";
	/**
	 * Option du moveTo : déplacement des enfants de l'élement uniquement
	 */
	const CHILDREN_ONLY = "CHILDREN_ONLY";
	/**
	 * Option du delete : suppression de l'element et placement des enfants au niveau du root (l'élement ayant pour left 1)
	 */
	const CHILDREN_ROOT = "CHILDREN_ROOT";
	/**
	 * Option du delete : suppression de l'element et placement des enfants au pere passe via le parametre suivant
	 */
	const CHILDREN_TO_FATHER = "CHILDREN_TO_FATHER";
	/**
	 * Option du delete : suppression de l'element et placement des enfants sans parent
	 */
	const CHILDREN_ORPHAN = "CHILDREN_ORPHAN";
	/**
	 * Option du moveTo : déplacement l'element ou/et ses enfants en dehors du tree
	 */
	const OUTSIDE = 0;
	/**
	 * Option du moveTo : signifie que l'élément sera inséré AVANT les autres enfants de l'élément dans lequel on insert le node
         * Option de l'insert : signifie que l'élément sera inséré AVANT les autres enfants de l'élément dans lequel on insert le node
	 */
	const BEGIN = "BEGIN";
	/**
	 * Option du moveTo : signifie que l'élément sera inséré APRES les autres enfants de l'élément dans lequel on insert le node
         * Option de l'insert : signifie que l'élément sera inséré APRES les autres enfants de l'élément dans lequel on insert le node
	 * (comportement par défaut si non précisé)
	 */
	const END = "END";
	/**
	 * Option du reorder : réordonne les enfants de l'élement en inversant leur place
	 */
	const REVERSE = "REVERSE";
	/**
	 * Option du reorder : réordonne les enfants et sous-enfants de l'élement en inversant leur place
	 */
	const REVERSE_RECURSIF = "REVERSE_RECURSIF";
	/**
	 * Option du reorder : place les éléments passés en parametres au debut de l'élément
	 */
	const UNSHIFT = "UNSHIFT";
	/**
	 * Option du reorder : place les éléments passés en parametres à la fin de l'élément
	 */
	const SHIFT = "SHIFT";


	/**
	 * Option du getFullTree : permet d'ordonner les éléments de manière verticale (on descend en profondeur prioritairement et non en largeur)
	 */
	const VERTICAL = "VERTICAL";
	/**
	 * Option du getFullTree : permet d'ordonner les éléments de manière horizontale (on descend en largeur prioritairement et non en profondeur)
	 */
	const HORIZONTAL = "HORIZONTAL";


	/**
	 *
	 * @var Field Champ de gauche
	 */
	public $leftField;
	/**
	 *
	 * @var Field Champ de droite
	 */
	public $rightField;
	/**
	 *
	 * @var Field Champ de profondeur
	 */
	public $depthField;


	/**
	 *
	 * @var Model Modèle auquel est attaché l'assoc
	 */
	public $model;


	/**
	 * Constructeur
	 * Génère les champs gauche et droite si nécessaire
	 *
	 * @param string $path Nom de l'association
	 * @param array $options Options de l'association
	 */
	public function __construct( $path , $options = array() ){

	    //////// ATTENTION : moveOutside, moveTo, insert et delete CHILDREN_ROOT sont les 4 seules fonctionnalitées deplacant  ////////
	    //		     des enregistrements à la FIN et non au DEBUT. (concernant insert et moveTo on peut leur passer le           //
            //		     parametre BEGIN pour le déplacer avant les enfants du noeud dans lequel on move/insert)                     //
	    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	    //////// A FAIRE : dans afterDelete avec arg CHILDREN_ROOT : faire en sorte de passer les éléments à la fin et         ////////
	    //	     non au début du root (les mettre après ses propres enfants)						   ////////
	    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	    parent::__construct( $path, $options );

	    //ici on definit les indices lft, rgt et dpt de l'association. Si ceux-ci ont ete definis on les entre dans le tableau, sinon ils
	    //s'appellent lft, rgt et dpt par defaut
	    $left = ($this->options[self::LEFT_FIELD])?$this->options[self::LEFT_FIELD]:self::LEFT_FIELD;
	    $right = ($this->options[self::RIGHT_FIELD])?$this->options[self::RIGHT_FIELD]:self::RIGHT_FIELD;
	    $depth = ($this->options[self::DEPTH_FIELD])?$this->options[self::DEPTH_FIELD]:self::DEPTH_FIELD;

	    //on verifie qu'aucun champ du model ne s'appelle deja comme ces champs, si c'est le cas on fait en sorte qu'ils soient uniques
            $listeFields = Field::getFields($this->from);
	    $left = $this->getUniqueFieldName($listeFields, $left);
	    $right = $this->getUniqueFieldName($listeFields, $right);
	    $depth = $this->getUniqueFieldName($listeFields, $depth);

	    $this->options[self::LEFT_FIELD] = $left;
	    $this->options[self::RIGHT_FIELD] = $right;
	    $this->options[self::DEPTH_FIELD] = $depth;

	    Field::create( "{$this->from}.{$left}", IntField, array(Field::EDITABLE => false) );
	    Field::create( "{$this->from}.{$right}", IntField, array(Field::EDITABLE => false) );
	    Field::create( "{$this->from}.{$depth}", IntField, array(Field::EDITABLE => false) );

	    //on met en place les écouteurs relatifs aux insert et delete
            Manager::getManager($this->from)->events->addEvent(ManagerEvent::AFTER_INSERT, array( $this , "afterInsert" ));
            Manager::getManager($this->from)->events->addEvent(ManagerEvent::BEFORE_DELETE, array( $this , "beforeDelete" ));
            Manager::getManager($this->from)->events->addEvent(ManagerEvent::AFTER_DELETE, array( $this , "afterDelete" ));
	}

	/**
	 * Appelé au moment de l'attachement du Field à un Model.
	 * Les champs gauche et droite sont récupérés sur le modèle
	 * @param Model $model Modèle auquel est attaché ce champ
	 * @return Field L'occurence du Field associé au Model
	 */
	public function attach( $model ){

	    $leftName = $this->options[self::LEFT_FIELD];
	    $rightName = $this->options[self::RIGHT_FIELD];
	    $depthName = $this->options[self::DEPTH_FIELD];

	    $this->leftField = $model->field( $leftName );
	    $this->rightField = $model->field( $rightName );
	    $this->depthField = $model->field( $depthName );

	    $this->model = $model;

	    return parent::attach( $model );

	}

	/**
	 * Renvoie tous les champs de type NestedAssoc du model passé en paramètre
	 * @param Object $obj généralement un Model, dans lequel on cherche tous les champs
	 * @return array les champs correspondant au modèle passé en paramètre
	 **/
	static function getFields( $obj ){

	    $outp = array();
	    foreach( Field::getFields( $obj ) as $name => $field ){

		if(is_a($field, "NestedAssoc"))
		{
		    $outp[$name] = $field;
		}
	    }
	    return $outp;

	}

	/**
	 * Pas de colonne dans la base de données, les Field gauche et droite sont créés à part
	 * @see NestedAssoc::generateField
	 * @return void
	 */
	public function asDbColumn(){
		return ;
	}

	/**
	 * Getter
	 * @return NestedAssoc $this renvoie l'association
	 */
	public function get() {
		return $this;
	}

	/**
	 * Retourne une requete retournant tous les elements de l'association
	 * @see DbQuery
	 * @return DbQuery requete prete à être executée
	 */
	public function select() {

	    $manager = Manager::getManager( $this->from );

	    if( !$this->model->id() ) {

		return DbQuery::dummy();

	    }

	    $query = $manager->select();
	    $query->tables[$this->from] = $this->from;

	    return $query;

	}





	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////// FONCTIONS DECLENCHEES LORS D'INSERT/DELETE D'UN ////////////////////////////////////////
	////////////////////////////////////	    ELEMENT POSSEDANT UNE NESTEDASSOC	     ////////////////////////////////////////
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        /**
         * Fonction appelée avant une insertion d'une instance de modèle possédant une assoc de type NestedAssoc (déclenchée 1 fois par assoc)
         * Pour le moment aucun écouteur n'est placé sur cet évènement car nous n'en avons pas besoin
         */
	public function beforeInsert()
	{
	    //pour l'insert etant donne que les champs des tree sont censes etre vides tout est fait apres l'insert
            trace("COUCOU BEFORE");
	}

        /**
         * Fonction appelée après une insertion d'une instance de modèle possédant une assoc de type NestedAssoc (déclenchée 1 fois par assoc)
         * Elle effectue les opérations necessaires à l'intégration du nouvel élément inséré par rapport au tree.
         * Si aucun paramètre n'est passé à $instance->insert() alors l'élément est inséré en dehors du tree
         * Si un paramètre est passé à la fonction d'insertion du Model alors l'élément sera inséré quelque part dans le tree (en fonction du parametre transmis)
         * de la première NestedAssoc du modele. Pour insérer un élément dans le tree d'une autre NestedAssoc il est nécessaire de passer par la nested directement.
         * Par exemple : $instance->nestedTree2->insert($param)
         *
         * Paramètres possibles :
         * - AUCUN : l'élément n'est pas inséré dans le tree
         * - NestedAssoc::END : insère l'élément à la fin du tree de la première nestedAssoc
         * - NestedAssoc::BEGIN : insère l'élément au début du tree de la première nestedAssoc
         * - int : si le model possedant l'association possède un identifiant unique de type int, l'élément sera inséré en tant qu'enfant d'une instance ayant pour
         * identifiant le int passé en paramètre
         * - object de type Model : insère l'élément en tant qu'enfant de l'instance d'une classe Model de même type que l'élément. (On n'insère un élément de type
         * User que dans une instance de type User)
         * - array : tableau associatif de nature suivante : array(nomField => valeurField, etc..). Permet d'insérer l'élément en tant qu'enfant d'une instance
         * correspondant aux couples nomField/valeurField transmis. A n'utiliser que si les 2 moyens précédents ne peuvent être utilisés pour cibler le node père.
         * EXCEPTION : pour les 3 derniers types de paramètres si aucune cible n'est trouvée une exception est levée
         * EXCEPTION : pour les 3 derniers types de paramètres si plus d'1 cible est trouvée une exception est levée
         *
         * EXCEPTION : Si un paramètre est entré et ne correspond à aucun des type de paramètres acceptés une exception est levée
         */
	public function afterInsert()
	{
            $args = func_get_args();
            if(!is_array($args)) $args = array($args);

            //suivant les arguments que l'on reçoit après le premier on les tri suivant leur type (par défaut inséré à la fin)
	    foreach($args as $arg)
	    {
		if($arg == self::BEGIN || $arg == self::END)
		{
		    $side = $arg;
		}
	    }
            if(!$side) $side = self::END;

            $model = $args[0];
	    $manager = Manager::getManager($this->from);
	    $leftName = $this->options[self::LEFT_FIELD];
	    $rightName = $this->options[self::RIGHT_FIELD];
	    $depthName = $this->options[self::DEPTH_FIELD];

	    /////////////////////////// PREMIER CAS ///////////////////////////
	    //dans le cas ou on a pas de parametre (hormis le model lui-même) cela signifie qu'on place
	    //l'élément en dehors du tree (lft/rgt/dpt = 0)
	    if(sizeof($args) == 1)
	    {
		$q = $manager->select("MAX(".$rightName.") as maxRight")->one();
		$maxRight = $q->maxRight;
		$tabBornes = array($leftName => $maxRight+1, $rightName => $maxRight+2);

		//ajout des valeurs des bornes left et right
		$q = $manager->update();
		$values[$leftName] = 0;
		$values[$rightName] = 0;
		$values[$depthName] = 0;
		$q->values( $values );
		$pks = array_keys(Field::getPrimaryFields($model));
		//var_dump($args);
                foreach($pks as $pk){$q->where($pk." = '".$model->{$pk}."'");}
		//trace("".$q);
		$q->run();
	    }
	    else
	    {
		/////////////////////////// DEUXIEME CAS ///////////////////////////
		//dans le cas ou le premier parametre est END, alors on insere l'élément à la fin de l'arborescence
		if($args[1] == self::END)
		{
		    $q = $manager->select("MAX(".$rightName.") as maxRight")->one();
		    $maxRight = $q->maxRight;
		    $tabBornes = array($leftName => $maxRight+1, $rightName => $maxRight+2);

		    //ajout des valeurs des bornes left et right
		    $q = $manager->update();
		    $values[$leftName] = $maxRight+1;
		    $values[$rightName] = $maxRight+2;
		    $values[$depthName] = 1;
		    $q->values( $values );
		    $pks = array_keys(Field::getPrimaryFields($model));
		    foreach($pks as $pk){$q->where($pk." = '".$model->{$pk}."'");}
		    //trace("".$q);
		    $q->run();
		}
		/////////////////////////// TROISIEME CAS ///////////////////////////
		//dans le cas ou le premier parametre est BEGIN, alors on insere l'élément au début de l'arborescence
		elseif($args[1] == self::BEGIN)
		{
		    //on decale tous les autres éléments de 1 vers la droite
		    $q = $manager->update();
		    $values = array();
		    $values[$leftName] = $leftName." + 2";
		    $values[$rightName] = $rightName." + 2";
		    $q->values( $values );
		    $q->where($leftName." != 0");
		    //trace("".$q);
		    $q->run();

		    //insérer l'élément en début d'arborescence
		    $q = $manager->update();
		    $values = array();
		    $values[$leftName] = 1;
		    $values[$rightName] = 2;
		    $values[$depthName] = 1;
		    $q->values( $values );
		    $pks = array_keys(Field::getPrimaryFields($model));
		    foreach($pks as $pk){$q->where($pk." = '".$model->{$pk}."'");}
		    //trace("".$q);
		    $q->run();
		}
		/////////////////////////// QUATRIEME CAS ///////////////////////////
		//dans le cas ou le premier parametre est un chiffre ou un tableau alors cela signifie que l'on veut inserer
		//l'occurence dans une autre occurence du model ayant pour identifiant ceux transmis en parametre
		elseif(is_numeric($args[1]) || is_array($args[1]) || is_a($args[1], $this->from))
		{
		    //dans un premier temps il faut recuperer la liste des champs primaires
		    $q = $manager->select("@myLeft := ".$leftName." as myLeft, @myRight := ".$rightName." as myRight, @myDepth := ".$depthName." as myDepth");
		    $q = $this->getWhereThis($q, $args[1]);

		    //trace($q."");
		    $res = $q->one();
		    //si le noeud passé en paramètre ne correspond a aucun noeud alors on lance une erreur
		    if(!$res)
		    {
			trigger_error("The target of insert doesn't exists in the tree.", E_USER_ERROR );
			//return $this->afterInsert(array($model));
		    }
		    elseif($q->count() > 1)
		    {
			trigger_error("The target of insert get more than 1 result in the tree : ".serialize($args[1]), E_USER_ERROR );
		    }
                    elseif($res->myLeft == 0)
                    {
                        trigger_error("The target of insert is not inserted in the tree, we can't insert the element in the target.", E_USER_ERROR );
                    }

		    $q = $manager->update();
		    $q->values(array($rightName => $rightName." + 2"));
                    if($side == self::END)
                    {
                        $q->where($rightName." >= @myRight");
                    }
                    else
                    {
                        $q->where($rightName." > @myLeft");
                    }
		    
		    //trace($q."");
		    $q->run();
		    $q = $manager->update();
		    $q->values(array($leftName => $leftName." + 2"));
                    if($side == self::END)
                    {
                        $q->where($leftName." > @myRight");
                    }
                    else
                    {
                        $q->where($leftName." > @myLeft");
                    }

		    //trace($q."");
		    $q->run();

		    //on met a jour les bornes gauches et droites, ainsi que la profondeur de l'element insere
		    $q = $manager->update();
                    if($side == self::END)
                    {
                        $values[$leftName] = "@myRight";
                        $values[$rightName] = "@myRight + 1";
                    }
                    else
                    {
                        $values[$leftName] = "@myLeft + 1";
                        $values[$rightName] = "@myLeft + 2";
                    }
		    $values[$depthName] = "@myDepth + 1";
		    $q->values($values);
		    $pks = array_keys(Field::getPrimaryFields($model));
		    foreach($pks as $pk){$q->where($pk." = '".$model->{$pk}."'");}
		    //trace($q."");
		    $q->run();
		}
		else
		{
                    trigger_error("les parametres transmis ne correspondent a aucun traitement de cet evenement : ".$args[1], E_USER_ERROR );
		}
	    }

	    //on lance un get sur l'élément qui vient d'être inséré pour mettre à jour les champs lft/rgt/dpt
	    //de l'objet php avec leur nouvelle valeur
	    $q = $manager->select();
	    $pks = array_keys(Field::getPrimaryFields($model));
	    foreach($pks as $pk){$q->where($pk." = '".$model->{$pk}."'");}
	    $temp = $q->one();

	    $this->model->field($leftName)->set($temp->{$leftName});
	    $this->model->field($rightName)->set($temp->{$rightName});
	    $this->model->field($depthName)->set($temp->{$depthName});
	}


	/**
	 * Requêtes executées avant la suppression de l'élement
	 * Ici nous récupérons des informations necessaires pour les requetes d'apres la suppression de l'élément ciblé
	 *
         * Pour la liste des paramètres et leur effet voir la fonction "afterDelete"
	 */
	public function beforeDelete()
	{
            $args = func_get_args();
            if(!is_array($args)) $args = array($args);

	    $model = $args[0];
	    $manager = Manager::getManager($this->from);
	    $leftName = $this->options[self::LEFT_FIELD];
	    $rightName = $this->options[self::RIGHT_FIELD];
	    $depthName = $this->options[self::DEPTH_FIELD];

	    //suivant le premier parametre passe (ou non => default) on delete et on update ce qu'il faut
            switch($args[1])
	    {
		case self::CHILDREN_WITH:

		    $q = $manager->select("@".$this->name."_left := ".$leftName.", @".$this->name."_right := ".$rightName.", @".$this->name."_width := ".$rightName." - ".$leftName." + 1");
		    $q = $this->getWhereThis($q, $model);
                    $q->run();
		    break;

		case self::CHILDREN_ROOT:
		    $q = $manager->select("@".$this->name."_left := ".$leftName.", @".$this->name."_right := ".$rightName.", @".$this->name."_depth := ".$depthName.", @".$this->name."_width := ".$rightName." - ".$leftName." + 1, @".$this->name."_decalage := ".$rightName." - ".$leftName." - 1");
		    $q = $this->getWhereThis($q, $model);
		    $q->run();
		    break;

		case self::CHILDREN_TO_FATHER:
		    $q = $manager->select("@".$this->name."_left := ".$leftName.", @".$this->name."_right := ".$rightName.", @".$this->name."_width := ".$rightName." - ".$leftName." + 1, @".$this->name."_decalage := ".$rightName." - ".$leftName." - 1");
		    $q = $this->getWhereThis($q, $model);
                    //trace("$q;");
		    $q->run();
		    $q = $manager->select("@".$this->name."_leftFather := ".$leftName, "@".$this->name."_rightFather := ".$rightName);
		    $q->where($leftName." BETWEEN ".$leftName." AND ".$rightName);
		    $q->where($leftName." < @".$this->name."_left AND ".$rightName." > @".$this->name."_right");
		    $q->orderBy(array("(".$rightName." - ".$leftName.")"));
		    $q->limit(1);
                    //trace("$q;");
                    $q->run();
		    
                    $checkFather = DbManager::$cnx->query("SELECT @".$this->name."_leftFather")->fetchAll();
                    if($checkFather[0]["@".$this->name."_leftFather"] === null)
                    {
                        trigger_error("This node got no father, choose an other option for deletion, like CHILDREN_ROOT, CHILDREN_ORPHAN or CHILDREN_WITH", E_USER_ERROR );
                    }

		    break;

		case self::CHILDREN_ORPHAN:
		default:
		    $q = $manager->select("@".$this->name."_left := ".$leftName.", @".$this->name."_right := ".$rightName.", @".$this->name."_depth := ".$depthName.", @".$this->name."_width := ".$rightName." - ".$leftName." + 1");
		    //$q = $manager->select("@".$this->name."_left := ".$leftName.", @".$this->name."_right := ".$rightName.", @".$this->name."_depth := ".$depthName.", @".$this->name."_width := 0");
		    $q = $this->getWhereThis($q, $model);
		    //trace($q."");
		    $q->run();
		    $q = $manager->select("@".$this->name."_maxRight := max(".$rightName.")");
		    //trace($q."");
		    $q->run();
	    }
	}

        /**
         * Fonction appelée après une suppression d'une instance de modèle possédant une assoc de type NestedAssoc (déclenchée 1 fois par assoc)
         * Elle effectue les opérations necessaires à la réorganisation du tree après la suppression d'un de ses éléments.
         * Si aucun paramètre n'est passé à $instance->delete() alors l'élément est supprimé de la DB (et donc du tree) et ses enfants sont déplacés
         * selon le comportement CHILDREN_ORPHAN par défaut (voir paramètres plus bas).
         * Si aucun paramètre n'est passé à $instance->nestedAssoc->delete() alors le comportement est similaire au précédent, excepté que l'élément n'est
         * pas supprimé de la DB mais que seul sa présence au sein du tree de la nestedAssoc concernée est supprimée.
         *
         * Paramètres possibles :
         * - AUCUN : l'élément est supprimé de la DB ou du tree et ses enfants sont réorganisés comme si le paramètre NestedAssoc::CHILDREN_ORPHAN avait été transmis
         * - NestedAssoc::CHILDREN_ORPHAN : les enfants du noeud venant d'être supprimé n'ont plus de parent et sont placé en haut et à la fin de l'arbre. Ils
         * conservent leur hierarchie (c'est à dire que les petits-enfants du noeud supprimé restent les enfants des enfants directs du noeud supprimé)
         * - NestedAssoc::CHILDREN_WITH : les enfants du noeud et toute leur hierarchie sont supprimés en même temps que le noeud parent venant d'être supprimé.
         * Si le noeud devait être complètement supprimé (ex : $instance->delete() ), les noeuds enfants sont complètement supprimés de la DB. Si le noeud devait
         * seulement être supprimé de l'arborescence de la nestedAssoc (ex : $instance->nestedAssoc->delete() ) alors les enfants sont seulement retirés de
         * l'arborescence de la nestedAssoc.
         * - NestedAssoc::CHILDREN_ROOT : les enfants du noeud supprimé deviennent les enfants du noeud ayant pour left = 1. ATTENTION, cela n'est pas forcement
         * un noeud parent du noeud supprimé. Comportement susceptible de changer ultérieurement.
         * - NestedAssoc::CHILDREN_TO_FATHER : les enfants du noeud supprimé deviennent les enfants du noeud parent du noeud supprimé (ex : si le node A est enfant
         * du node B qui est lui-même enfant du node C, si l'on décide de supprimer le node B comme ceci : $instanceB->delete(NestedAssoc::CHILDREN_TO_FATHER) alors
         * le node A deviendra enfant du node C.
         * EXCEPTION : si le node supprimé n'a pas de noeud parent une exception est levée et la suppression n'a pas lieu.
         */
	public function afterDelete()
	{
            $args = func_get_args();
            if(!is_array($args)) $args = array($args);

            $model = $args[0];
	    $manager = Manager::getManager($this->from);
	    $leftName = $this->options[self::LEFT_FIELD];
	    $rightName = $this->options[self::RIGHT_FIELD];
	    $depthName = $this->options[self::DEPTH_FIELD];

            //si l'instance courante n'est pas intégré dans le tree (n'a pas d'arborescence : lft = 0 ou rgt = 0)
            //alors il est inutile d'aller plus loin car aucune opération n'est requise
            if($model->{$leftName} != 0 && $model->{$rightName} != 0)
            {
                //suivant le premier parametre passé (ou non => default) on delete et on update ce qu'il faut
                switch($args[1])
                {
                    case self::CHILDREN_WITH:

                        //faire la distinction entre un delete complet du noeud et un simple delete de son intégration au tree.
                        foreach($args as $arg)
                        {
                            if($arg == "justRemoveNested")
                            {
                                $justRemoveNested = true;
                            }
                        }
                        //Ici on delete seulement la présence des enfants dans le tree (il reste enregistrés en DB)
                        if($justRemoveNested === true)
                        {
                            $q = $manager->update();
                            $values = array();
                            $values[$leftName] = 0;
                            $values[$rightName] = 0;
                            $values[$depthName] = 0;
                            $q->values($values);
                        }
                        //tandis qu'ici on supprime completement les noeud
                        else
                        {
                            $q = $manager->delete();
                        }
                        $q->where($leftName." BETWEEN @".$this->name."_left AND @".$this->name."_right");
                        //trace("".$q);
                        $q->run();

                        $q = $manager->update();
                        $values = array();
                        $values[$rightName] = $rightName." - @".$this->name."_width";
                        $q->values($values);
                        $q->where($rightName." > @".$this->name."_right");
                        $q->run();

                        $q = $manager->update();
                        $values = array();
                        $values[$leftName] = $leftName." - @".$this->name."_width";
                        $q->values($values);
                        $q->where($leftName." > @".$this->name."_right");
                        $q->run();
                        break;

                    case self::CHILDREN_ROOT:
                        $q = $manager->update();
                        $values = array();
                        $values[$leftName] = $leftName." + @".$this->name."_decalage";
                        $q->values($values);
                        $q->where($leftName." != '0'");
                        $q->where($leftName." != '1'");
                        $q->run();

                        $q = $manager->update();
                        $values = array();
                        $values[$rightName] = $rightName." + @".$this->name."_decalage";
                        $q->values($values);
                        $q->where($leftName." != '0'");
                        $q->run();

                        $q = $manager->update();
                        $values = array();
                        $values[$leftName] = $leftName." - @".$this->name."_decalage - @".$this->name."_left + 1";
                        $values[$rightName] = $rightName." - @".$this->name."_decalage - @".$this->name."_left + 1";
                        $values[$depthName] = $depthName." - @".$this->name."_depth + 1";
                        $q->values($values);
                        $q->where($leftName." BETWEEN @".$this->name."_left + @".$this->name."_decalage AND @".$this->name."_right + @".$this->name."_decalage");
                        $q->run();

                        $q = $manager->update();
                        $values = array();
                        $values[$rightName] = $rightName." - @".$this->name."_width";
                        $q->values($values);
                        $q->where($rightName." > @".$this->name."_right");
                        $q->run();

                        $q = $manager->update();
                        $values = array();
                        $values[$leftName] = $leftName." - @".$this->name."_width";
                        $q->values($values);
                        $q->where($leftName." > @".$this->name."_right");
                        $q->run();
                        break;

                    case self::CHILDREN_TO_FATHER:

                        $q = $manager->update();
                        $values = array();
                        $values[$leftName] = $leftName." + @".$this->name."_decalage";
                        $q->values($values);
                        $q->where($leftName." > @".$this->name."_leftFather");
                        $q->run();

                        $q = $manager->update();
                        $values = array();
                        $values[$rightName] = $rightName." + @".$this->name."_decalage";
                        $q->values($values);
                        $q->where($rightName." >= @".$this->name."_leftFather");
                        $q->run();

                        $q = $manager->update();
                        $values = array();
                        $values[$leftName] = $leftName." - @".$this->name."_decalage - @".$this->name."_left + @".$this->name."_leftFather";
                        $values[$rightName] = $rightName." - @".$this->name."_decalage - @".$this->name."_left + @".$this->name."_leftFather";
                        $values[$depthName] = $depthName." - 1";
                        $q->values($values);
                        $q->where($leftName." BETWEEN @".$this->name."_left + @".$this->name."_decalage AND @".$this->name."_right + @".$this->name."_decalage");
                        $q->run();

                        $q = $manager->update();
                        $values = array();
                        $values[$rightName] = $rightName." - @".$this->name."_width";
                        $q->values($values);
                        $q->where($rightName." > @".$this->name."_right");
                        $q->run();

                        $q = $manager->update();
                        $values = array();
                        $values[$leftName] = $leftName." - @".$this->name."_width";
                        $q->values($values);
                        $q->where($leftName." > @".$this->name."_right");
                        $q->run();
                        break;

                    case self::CHILDREN_ORPHAN:
                    default:

                        $q = $manager->update();
                        $values = array();
                        $values[$leftName] = $leftName." + @".$this->name."_maxRight - @".$this->name."_left";
                        $values[$rightName] = $rightName." + @".$this->name."_maxRight - @".$this->name."_left";
                        $values[$depthName] = $depthName." - @".$this->name."_depth";
                        $q->values($values);
                        $q->where($leftName." BETWEEN @".$this->name."_left AND @".$this->name."_right");
                        $q->where($leftName." != 0");
                        //trace($q."");
                        $q->run();

                        $q = $manager->update();
                        $values = array();
                        $values[$rightName] = $rightName." - @".$this->name."_width";
                        $q->values($values);
                        $q->where($rightName." > @".$this->name."_right");
                        $q->where($rightName." <= @".$this->name."_maxRight");
                        //trace($q."");
                        $q->run();

                        $q = $manager->update();
                        $values = array();
                        $values[$leftName] = $leftName." - @".$this->name."_width";
                        $q->values($values);
                        $q->where($leftName." > @".$this->name."_right");
                        $q->where($leftName." < @".$this->name."_maxRight");
                        //trace($q."");
                        $q->run();

                        $q = $manager->update();
                        $values = array();
                        $values[$leftName] = $leftName." - @".$this->name."_width";
                        $values[$rightName] = $rightName." - @".$this->name."_width";
                        $q->values($values);
                        $q->where($leftName." > @".$this->name."_maxRight");
                        //trace($q."");
                        $q->run();
                }
            }
	}


	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////// FONCTIONS CONCERNANT LES MANIPULATIONS DANS LE TREE ////////////////////////////////////
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


	/**
	 * Permet d'insérer l'élément dans le tree si il n'y est pas déjà.
         * Pour les paramètres voir fonction "afterInsert"
         * EXCEPTION une exception est levée lorsque l'on essaie d'insérer un élément dans le tree alors qu'il y est déjà
	 */
	public function insert()
	{
            $leftName = $this->options[self::LEFT_FIELD];
	    if($this->model->{$leftName} != 0)
	    {
		trigger_error("This element (".$this->name().") is already inserted in tree. Use function moveTo, moveAfter or moveBefore in order to move the element in an other place", E_USER_ERROR );
	    }

	    $args = func_get_args();
	    array_unshift($args, $this->model);

            //suivant les arguments que l'on reçoit après le premier on les tri suivant leur type
	    foreach($args as $arg)
	    {
		if($arg == self::BEGIN || $arg == self::END)
		{
		    $side = $arg;
		}
	    }
	    //si il n'y a pas de paramètre déterminant le côté d'insertion on insère l'élément à la fin du tree par defaut
	    if(!$side)
	    {
		$args[] = self::END;
	    }

            call_user_func_array( array($this, "beforeInsert") , $args );
            call_user_func_array( array($this, "afterInsert") , $args );

	    return true;
	}


	/**
	 * Permet de supprimer l'élément du tree (met l'élément a lft 0, rgt 0 et dpt 0)
         * Pour les paramètres voir fonction "afterDelete"
	 */
	public function delete()
	{
	    $args = func_get_args();
	    array_unshift($args, $this->model);
            //ici l'on ne fait que sortir le noeud de l'arbre donc on précise que dans le cas où l'on veut delete les children (param CHILDREN_WITH)
            //on ne fait que remove leur intégration à l'arbre et on ne les delete pas complètement contrairement au cas où on ferait $instance->delete();
            //ici on est dans le cas de $instance->nestedAssoc->delete()
            $args[] = "justRemoveNested";

	    $manager = Manager::getManager($this->from);
	    $leftName = $this->options[self::LEFT_FIELD];
	    $rightName = $this->options[self::RIGHT_FIELD];
	    $depthName = $this->options[self::DEPTH_FIELD];

            call_user_func_array( array($this, "beforeDelete") , $args );
	    //$this->beforeDelete($args);

	    $q = $manager->update();
	    $values[$leftName] = 0;
	    $values[$rightName] = 0;
	    $values[$depthName] = 0;
	    $q->values($values);
	    $q = $this->getWhereThis($q, $this->model);
	    //trace($q."");
	    $q->run();

            call_user_func_array( array($this, "afterDelete") , $args );
	    //$this->afterDelete($args);

	    return true;
	}


	/**
	 * Permet de supprimer du tree tous les enfants de l'élement
	 */
	public function deleteChildren()
	{
	    $manager = Manager::getManager($this->from);
	    $leftName = $this->options[self::LEFT_FIELD];
	    $rightName = $this->options[self::RIGHT_FIELD];

	    $q = $manager->delete();
	    $q->where($leftName." > ".$this->model->{$leftName}." AND ".$leftName." < ".$this->model->{$rightName});
	    $nbDeleted = $q->run();

	    $q = $manager->update();
	    $values = array();
	    $values[$leftName] = $leftName." - ".($nbDeleted*2);
	    $q->values($values);
	    $q->where($leftName." > ".$this->model->{$leftName});
	    $q->run();

	    $q = $manager->update();
	    $values = array();
	    $values[$rightName] = $rightName." - ".($nbDeleted*2);
	    $q->values($values);
	    $q->where($rightName." >= ".$this->model->{$rightName});
	    $q->run();
	}

	/**
	 * Permet de déplacer un noeud au sein d'un autre (devient enfant du noeud cible) ou en dehors du tree
	 * @param $destination offrant 5 possibilités :
         * => désignation d'un noeud cible dans lequel on veut insérer l'élément :
         * - int : si le model possedant l'association possède un identifiant unique de type int, l'élément sera inséré en tant qu'enfant d'une instance ayant pour
         * identifiant le int passé en paramètre
         * - object de type Model : insère l'élément en tant qu'enfant de l'instance d'une classe Model de même type que l'élément. (On n'insère un élément de type
         * User que dans une instance de type User)
         * - array : tableau associatif de nature suivante : array(nomField => valeurField, etc..). Permet d'insérer l'élément en tant qu'enfant d'une instance
         * correspondant aux couples nomField/valeurField transmis. A n'utiliser que si les 2 moyens précédents ne peuvent être utilisés pour cibler le node père.
         * => désignation du tree lui-même (cas où l'on désire déplacer le noeud en haut du tree, signifiant par là que l'élément ne possèdera plus de parent) :
         * - 0
         * - NestedAssoc::OUTSIDE
         * Ces 2 valeurs sont équivalentes
         *
         * Paramètres facultatifs au nombre de 2 :
         * 1er paramètre => comportement des enfants offrant 3 possibilités :
         * - NestedAssoc::CHILDREN_ONLY : on ne déplace que les enfants de l'élément vers l'élément cible (ou en dehors du tree). C'est l'élément cible qui devient
         * alors parent des enfants de l'élément. Ou ceci sont placé en haut du tree dans le cas d'un déplacement vers le tree.
         * - NestedAssoc::CHILDREN_WITH : on déplace le noeud et ses enfants avec. La hierarchie n'est donc pas modifié au niveau du noeud lui-même.
         * (c'est à dire que les enfants du noeud déplacé restent enfant du noeud et deviennent par conséquent sous-enfant du noeud cible)
         * - AUCUN (équivalent à NestedAssoc::CHILDREN_WITH)
         * 2ème paramètre => ordre dans lequel est inséré le noeud au sein de la cible, 3 possibilités :
         * - NestedAssoc::BEGIN : déplace le noeud au début du noeud cible (cela signifie que si le noeud cible possède des enfants, l'élément sera placé AVANT
         * les enfants). Dans le cas d'un déplacement au niveau du tree, celui-ci sera placé au début du tree (lft = 1)
         * - NestedAssoc::END : déplace le noeud à la fin du noeud cible (cela signifie que si le noeud cible possède des enfants, l'élément sera placé APRES
         * les enfants). Dans le cas d'un déplacement au niveau du tree, celui-ci sera placé à la fin du tree
         * - AUCUN (équivalent à NestedAssoc::END)
         *
         * Les 2 paramètres facultatifs peuvent être passés à la fonction dans n'importe quel ordre après le paramètre $destination.
         * ex :
         * 1) $instance->nestedAssoc->moveTo(15, NestedAssoc::CHILDREN_ONLY, NestedAssoc::BEGIN)
         * 2) $instance->nestedAssoc->moveTo(0, NestedAssoc::END, NestedAssoc::CHILDREN_WITH )
         * 3) $instance->nestedAssoc->moveTo(15, NestedAssoc::BEGIN)
         * ATTENTION, dans le cas où 2 valeurs associé au même paramètre sont transmises, seule la dernière sera prise en compte.
         * ex : $instance->nestedAssoc->moveTo(15, NestedAssoc::BEGIN, NestedAssoc::END) est équivalent à
         *      $instance->nestedAssoc->moveTo(15, NestedAssoc::END)
         *
	 */
	public function moveTo($destination)
	{
	    $args = func_get_args();
	    $manager = Manager::getManager($this->from);
	    $leftName = $this->options[self::LEFT_FIELD];
	    $rightName = $this->options[self::RIGHT_FIELD];
	    $depthName = $this->options[self::DEPTH_FIELD];

	    //suivant les arguments que l'on reçoit après le premier on les tri suivant leur type
	    foreach($args as $arg)
	    {
		if($arg == self::CHILDREN_ONLY || $arg == self::CHILDREN_WITH)
		{
		    $children = $arg;
		}
		if($arg == self::BEGIN || $arg == self::END)
		{
		    $order = $arg;
		}
	    }

	    //Permet de déplacer un noeud en dehors du tree
	    if($destination == 0 || $destination == self::OUTSIDE)
	    {
		switch($children)
		{
		    case self::CHILDREN_ONLY:
		    case self::CHILDREN_WITH:
		    default:
			if($children === self::CHILDREN_ONLY){
			    $width = $this->model->{$rightName} - $this->model->{$leftName} - 1;
			}else{
			    $width = $this->model->{$rightName} - $this->model->{$leftName} + 1;
			}
			$q = $manager->select("max(".$rightName.") as maxRight");
			$res = $q->one();

			if($children === self::CHILDREN_ONLY){
			    if($order === self::BEGIN)
			    {
				$decalage = 1 - $this->model->{$leftName} - 1;
			    }
			    else
			    {
				$decalage = $res->maxRight - $this->model->{$leftName};
			    }
			}else{
			    if($order === self::BEGIN)
			    {
				$decalage = 1 - $this->model->{$leftName};
			    }
			    else
			    {
				$decalage = $res->maxRight - $this->model->{$leftName} + 1;
			    }
			}

			if($order === self::BEGIN)
			{
			    $q = $manager->update();
			    $values = array();
			    $values[$leftName] = $leftName." + ".$width;
			    $values[$rightName] = $rightName." + ".$width;
			    $q->where($leftName." != '0'");
			    $q->values($values);
			    $q->run();

			    $whereLeft = $leftName." > ".$this->model->{$leftName}." + ".$width;
			    $whereRight = $rightName." >= ".$this->model->{$rightName}." + ".$width;
			}
			else
			{
			    $whereLeft = $leftName." > ".$this->model->{$leftName};
			    $whereRight = $rightName." >= ".$this->model->{$rightName};
			}



			$q = $manager->update();
			$values = array();
			if($order === self::BEGIN){
			    $values[$leftName] = $leftName." + ".$decalage." - ".$width;
			    $values[$rightName] = $rightName." + ".$decalage." - ".$width;
			}
			else
			{
			    $values[$leftName] = $leftName." + ".$decalage;
			    $values[$rightName] = $rightName." + ".$decalage;
			}
			if($children === self::CHILDREN_ONLY){
			    $values[$depthName] = $depthName." - ".$this->model->{$depthName};
			}else{
			    $values[$depthName] = $depthName." - ".$this->model->{$depthName}." + 1";
			}
			$q->values($values);
			if($children === self::CHILDREN_ONLY){
			    if($order === self::BEGIN){
				$q->where($leftName." > ".$this->model->{$leftName}." + ".$width." AND ".$leftName." < ".$this->model->{$rightName}." + ".$width);
			    }
			    else
			    {
				$q->where($leftName." > ".$this->model->{$leftName}." AND ".$leftName." < ".$this->model->{$rightName});
			    }
			}else{
			    if($order === self::BEGIN){
				$q->where($leftName." BETWEEN ".$this->model->{$leftName}." + ".$width." AND ".$this->model->{$rightName}." + ".$width);
			    }
			    else
			    {
				$q->where($leftName." BETWEEN ".$this->model->{$leftName}." AND ".$this->model->{$rightName});
			    }
			}
			$q->run();

			$q = $manager->update();
			$values = array();
			$values[$leftName] = $leftName." - ".$width;
			$q->values($values);
			$q->where($whereLeft);
			$q->run();

			$q = $manager->update();
			$values = array();
			$values[$rightName] = $rightName." - ".$width;
			$q->values($values);
			$q->where($whereRight);
			$q->run();
		}
	    }
	    //Ou dans un élément passé en parametre
	    else
	    {
                //vérifier que la cible du moveTo est présente dans le tree (lft et rgt != 0), sinon produire une erreur
                $q = $manager->select();
                $q = $this->getWhereThis($q, $destination);
                $cible = $q->one();
                if(!$cible)
                {
                    trigger_error("The target of moveTo doesn't exists in the tree.", E_USER_ERROR );
                }elseif($cible->{$leftName} == 0 || $cible->{$rightName} == 0){
                    trigger_error("The target of moveTo is outside the tree. Insert the target into the tree before moving something in", E_USER_ERROR );
                }
                //vérifier que la cible n'est pas un enfant du noeud à déplacer : on ne déplace pas un noeud dans un de ses enfants
                if($this->model->{$leftName} < $cible->{$leftName} && $this->model->{$rightName} > $cible->{$rightName} )
                {
                    trigger_error("The target of moveTo is a child of the node. You can't move a parent into its child", E_USER_ERROR );
                }

                //attention, si jamais l'element que l'on veut déplacer se trouve en dehors du tree il faut d'abord l'insérer dedans avant de le déplacer
                //car on se sert du couple left-right censé être unique seulement si le node est inséré dans le tree.
                if($this->model->{$leftName} == 0 || $this->model->{$rightName} == 0)
                {
                    $this->insert();
                }

		switch($children)
		{
		    case self::CHILDREN_ONLY:
		    case self::CHILDREN_WITH:
		    default:
			if($children === self::CHILDREN_ONLY){
			    $width = $this->model->{$rightName} - $this->model->{$leftName} - 1;
			}else{
			    $width = $this->model->{$rightName} - $this->model->{$leftName} + 1;
			}

			if($children === self::CHILDREN_ONLY){
			    if($order === self::BEGIN)
			    {
				$decalage = $cible->{$leftName} - $this->model->{$leftName};
			    }
			    else
			    {
				$decalage = $cible->{$rightName} - $this->model->{$leftName} - 1;
			    }
			}else{
			    if($order === self::BEGIN)
			    {
				$decalage = $cible->{$leftName} - $this->model->{$leftName} + 1;
			    }
			    else
			    {
				$decalage = $cible->{$rightName} - $this->model->{$leftName};
			    }
			}

			//suivant le sens du décalage : vers la gauche ou la droite, on ne prépare pas les mêmes opérations
			if($decalage < 0)
			{
			    $newLeft = $leftName." + ".$decalage." - ".$width;
			    $newRight = $rightName." + ".$decalage." - ".$width;
			    $whereLft = $this->model->{$leftName}." + ".$width;
			    $whereRgt = $this->model->{$rightName}." + ".$width;
			}
			else
			{
			    $newLeft = $leftName." + ".$decalage;
			    $newRight = $rightName." + ".$decalage;
			    $whereLft = $this->model->{$leftName};
			    $whereRgt = $this->model->{$rightName};
			}


			$q = $manager->update();
			$values = array();
			$values[$leftName] = $leftName." + ".$width;
			$q->values($values);
			if($order === self::BEGIN)
			{
			    $q->where($leftName." > ".$cible->{$leftName});
			}
			else
			{
			    $q->where($leftName." > ".$cible->{$rightName}." - 1");
			}
			//trace("".$q);
			$q->run();

			$q = $manager->update();
			$values = array();
			$values[$rightName] = $rightName." + ".$width;
			$q->values($values);
			if($order === self::BEGIN)
			{
			    $q->where($rightName." > ".$cible->{$leftName});
			}
			else
			{
			    $q->where($rightName." > ".$cible->{$rightName}." - 1");
			}
			//trace("".$q);
			$q->run();

			$q = $manager->update();
			$values = array();
			$values[$leftName] = $newLeft;
			$values[$rightName] = $newRight;
			if($children === self::CHILDREN_ONLY){
			    $values[$depthName] = $cible->{$depthName}." + ".$depthName." - ".$this->model->{$depthName};
			}else{
			    $values[$depthName] = $cible->{$depthName}." + ".$depthName." - ".$this->model->{$depthName}." + 1";
			}
			$q->values($values);
			if($children === self::CHILDREN_ONLY){
			    $q->where($leftName." > ".$whereLft." AND ".$leftName." < ".$whereRgt);
			}else{
			    $q->where($leftName." BETWEEN ".$whereLft." AND ".$whereRgt);
			}
			//trace("".$q);
			$q->run();

			$q = $manager->update();
			$values = array();
			$values[$leftName] = $leftName." - ".$width;
			$q->values($values);
			$q->where($leftName." > ".$this->model->{$rightName});
			//trace("".$q);
			$q->run();

			$q = $manager->update();
			$values = array();
			$values[$rightName] = $rightName." - ".$width;
			$q->values($values);
			if($children === self::CHILDREN_ONLY){
			    $q->where($rightName." >= ".$this->model->{$rightName});
			}else{
			    $q->where($rightName." > ".$this->model->{$rightName});
			}
			//trace("".$q);
			$q->run();

		}
	    }
	}

	/**
	 * Permet de déplacer un noeud après un autre noeud
         * @param $destination offrant 3 possibilités :
         * => désignation d'un noeud cible dans lequel on veut insérer l'élément :
         * - int : si le model possedant l'association possède un identifiant unique de type int, l'élément sera inséré au même niveau et derrière une instance
         * ayant pour identifiant le int passé en paramètre mais derrière
         * - object de type Model : insère l'élément au même niveau et derrière une instance d'une classe Model de même type que l'élément. (On n'insère un élément
         * de type User que dans une instance de type User)
         * - array : tableau associatif de nature suivante : array(nomField => valeurField, etc..). Permet d'insérer l'élément au même niveau et derrière une instance
         * correspondant aux couples nomField/valeurField transmis. A n'utiliser que si les 2 moyens précédents ne peuvent être utilisés pour cibler le node cible.
         * 
         * Pour le moment on ne peut déplacer que le noeud et ses enfants. Une mise à jour ultérieure pourrait proposer l'apparition d'un paramètre facultatif
         * permettant de ne déplacer que les enfants de l'élément
         *
	 * A FAIRE : déplacement uniquement des enfants ?
	 */
	public function moveAfter($destination)
	{
	    $args = func_get_args();
	    $manager = Manager::getManager($this->from);
	    $leftName = $this->options[self::LEFT_FIELD];
	    $rightName = $this->options[self::RIGHT_FIELD];
	    $depthName = $this->options[self::DEPTH_FIELD];

	    switch($args[1])
	    {
		//case self::CHILDREN_ONLY:
		case self::CHILDREN_WITH:
		default:
		    //if($args[1] == self::CHILDREN_ONLY){
			//$width = $this->model->{$rightName} - $this->model->{$leftName} - 1;
		    //}else{
			$width = $this->model->{$rightName} - $this->model->{$leftName} + 1;
		    //}
		    $q = $manager->select();
		    $q = $this->getWhereThis($q, $destination);
		    $cible = $q->one();
		    //if($args[1] == self::CHILDREN_ONLY){
			//$decalage = $cible->{$leftName} - $this->model->{$leftName};
		    //}else{
			$decalage = $cible->{$rightName} - $this->model->{$leftName} + 1;
		    //}

		    //suivant le sens du décalage : vers la gauche ou la droite, on ne prépare pas les mêmes opérations
		    if($decalage < 0)
		    {
			//if($args[1] == self::CHILDREN_ONLY){
			    //$whereLft = $leftName." > (".$this->model->{$leftName}."+".$width.") AND ".$rightName." < (".$this->model->{$rightName}."+".$width.")";
			//}
			//else
			//{
			    $whereLft = $leftName." BETWEEN (".$this->model->{$leftName}."+".$width.") AND (".$this->model->{$rightName}."+".$width.")";
			//}
			$decalageFinal = $decalage - $width;
			$whereLeft = $leftName." > ".$this->model->{$leftName}." + ".$width;
			$whereRight = $rightName." > ".$this->model->{$rightName}." + ".$width;
		    }
		    else
		    {
			//if($args[1] == self::CHILDREN_ONLY){
			    //$whereLft = $leftName." > ".$this->model->{$leftName}." AND ".$rightName." < ".$this->model->{$rightName};
			//}
			//else
			//{
			    $whereLft = $leftName." BETWEEN ".$this->model->{$leftName}." AND ".$this->model->{$rightName};
			//}
			$decalageFinal = $decalage;
			$whereLeft = $leftName." > ".$this->model->{$leftName};
			$whereRight = $rightName." > ".$this->model->{$rightName};
		    }

		    $q = $manager->update();
		    $values = array();
		    $values[$leftName] = $leftName." + ".$width;
		    $q->values($values);
		    $q->where($leftName." > ".$cible->{$rightName});
		    //trace("".$q);
		    $q->run();

		    $q = $manager->update();
		    $values = array();
		    $values[$rightName] = $rightName." + ".$width;
		    $q->values($values);
		    $q->where($rightName." > ".$cible->{$rightName});
		    //trace("".$q);
		    $q->run();

		    $q = $manager->update();
		    $values = array();
		    $values[$depthName] = $cible->{$depthName}." + (".$depthName." - ".$this->model->{$depthName}.")";
		    $q->values($values);
		    $q->where($whereLft);
		    //trace("".$q);
		    $q->run();

		    $q = $manager->update();
		    $values = array();
		    $values[$leftName] = $leftName." + ".$decalageFinal;
		    $values[$rightName] = $rightName." + ".$decalageFinal;
		    $q->values($values);
		    $q->where($whereLft);
		    //trace("".$q);
		    $q->run();

		    $q = $manager->update();
		    $values = array();
		    $values[$leftName] = $leftName." - ".$width;
		    $q->values($values);
		    $q->where($whereLeft);
		    //trace("".$q);
		    $q->run();

		    $q = $manager->update();
		    $values = array();
		    $values[$rightName] = $rightName." - ".$width;
		    $q->values($values);
		    $q->where($whereRight);
		    //trace("".$q);
		    $q->run();
	    }
	}

	/**
	 * Permet de déplacer un noeud avant un autre noeud
         * @param $destination offrant 3 possibilités :
         * => désignation d'un noeud cible dans lequel on veut insérer l'élément :
         * - int : si le model possedant l'association possède un identifiant unique de type int, l'élément sera inséré au même niveau et devant une instance
         * ayant pour identifiant le int passé en paramètre mais derrière
         * - object de type Model : insère l'élément au même niveau et devant une instance d'une classe Model de même type que l'élément. (On n'insère un élément
         * de type User que dans une instance de type User)
         * - array : tableau associatif de nature suivante : array(nomField => valeurField, etc..). Permet d'insérer l'élément au même niveau et devant une instance
         * correspondant aux couples nomField/valeurField transmis. A n'utiliser que si les 2 moyens précédents ne peuvent être utilisés pour cibler le node cible.
         *
         * Pour le moment on ne peut déplacer que le noeud et ses enfants. Une mise à jour ultérieure pourrait proposer l'apparition d'un paramètre facultatif
         * permettant de ne déplacer que les enfants de l'élément
         *
	 * A FAIRE : déplacement uniquement des enfants ?
	 */
	public function moveBefore($destination)
	{
	    $args = func_get_args();
	    $manager = Manager::getManager($this->from);
	    $leftName = $this->options[self::LEFT_FIELD];
	    $rightName = $this->options[self::RIGHT_FIELD];
	    $depthName = $this->options[self::DEPTH_FIELD];

	    switch($args[1])
	    {
		//case self::CHILDREN_ONLY:
		case self::CHILDREN_WITH:
		default:
		    //if($args[1] == self::CHILDREN_ONLY){
			//$width = $this->model->{$rightName} - $this->model->{$leftName} - 1;
		    //}else{
			$width = $this->model->{$rightName} - $this->model->{$leftName} + 1;
		    //}
		    $q = $manager->select();
		    $q = $this->getWhereThis($q, $destination);
		    $cible = $q->one();
		    //if($args[1] == self::CHILDREN_ONLY){
			//$decalage = $cible->{$leftName} - $this->model->{$leftName};
		    //}else{
			$decalage = $cible->{$leftName} - $this->model->{$leftName};
		    //}

		    //suivant le sens du décalage : vers la gauche ou la droite, on ne prépare pas les mêmes opérations
		    if($decalage < 0)
		    {
			//if($args[1] == self::CHILDREN_ONLY){
			    //$whereLft = $leftName." > (".$this->model->{$leftName}."+".$width.") AND ".$rightName." < (".$this->model->{$rightName}."+".$width.")";
			//}
			//else
			//{
			    $whereLft = $leftName." BETWEEN (".$this->model->{$leftName}."+".$width.") AND (".$this->model->{$rightName}."+".$width.")";
			//}
			$decalageFinal = $decalage - $width;
			$whereLeft = $leftName." > ".$this->model->{$leftName}." + ".$width;
			$whereRight = $rightName." > ".$this->model->{$rightName}." + ".$width;
		    }
		    else
		    {
			//if($args[1] == self::CHILDREN_ONLY){
			    //$whereLft = $leftName." > ".$this->model->{$leftName}." AND ".$rightName." < ".$this->model->{$rightName};
			//}
			//else
			//{
			    $whereLft = $leftName." BETWEEN ".$this->model->{$leftName}." AND ".$this->model->{$rightName};
			//}
			$decalageFinal = $decalage;
			$whereLeft = $leftName." > ".$this->model->{$leftName};
			$whereRight = $rightName." > ".$this->model->{$rightName};
		    }

		    $q = $manager->update();
		    $values = array();
		    $values[$leftName] = $leftName." + ".$width;
		    $q->values($values);
		    $q->where($leftName." >= ".$cible->{$leftName});
		    //trace("".$q);
		    $q->run();

		    $q = $manager->update();
		    $values = array();
		    $values[$rightName] = $rightName." + ".$width;
		    $q->values($values);
		    $q->where($rightName." > ".$cible->{$leftName});
		    //trace("".$q);
		    $q->run();

		    $q = $manager->update();
		    $values = array();
		    $values[$depthName] = $cible->{$depthName}." + (".$depthName." - ".$this->model->{$depthName}.")";
		    $q->values($values);
		    $q->where($whereLft);
		    //trace("".$q);
		    $q->run();

		    $q = $manager->update();
		    $values = array();
		    $values[$leftName] = $leftName." + ".$decalageFinal;
		    $values[$rightName] = $rightName." + ".$decalageFinal;
		    $q->values($values);
		    $q->where($whereLft);
		    //trace("".$q);
		    $q->run();

		    $q = $manager->update();
		    $values = array();
		    $values[$leftName] = $leftName." - ".$width;
		    $q->values($values);
		    $q->where($whereLeft);
		    //trace("".$q);
		    $q->run();

		    $q = $manager->update();
		    $values = array();
		    $values[$rightName] = $rightName." - ".$width;
		    $q->values($values);
		    $q->where($whereRight);
		    //trace("".$q);
		    $q->run();
	    }
	}

	/**
	 * Permet de réordonner les enfants de l'élement
         * @param string $typeReorder type de réordonnancement offrant 4 possibilités :
         * - NestedAssoc::REVERSE : permet d'inverser l'ordre des enfants directs (pas les petit-enfants) de l'élément
         * - NestedAssoc::REVERSE_RECURSIF : permet d'inverser l'ordre de tous les enfants et petit-enfants de l'élément
         * - NestedAssoc::UNSHIFT : permet de réordonner les enfants passés en 2nd paramètre en les plaçant au début des noeuds enfants.
         * Par ex : le noeud A contient les enfants B, C, D, E, F. Si on fait $instance->nestedAssoc->reorder(NestedAssoc::UNSHIFT, array(C, D, F)) on obtient :
         * le noeud A contient les enfants C, D, F, B, E
         * - NestedAssoc::PUSH : permet de réordonner les enfants passés en 2nd paramètre en les plaçant à la fin des noeuds enfants
         * Par ex : le noeud A contient les enfants B, C, D, E, F. Si on fait $instance->nestedAssoc->reorder(NestedAssoc::PUSH, array(F, B, D)) on obtient :
         * le noeud A contient les enfants C, E, F, B, D
         * ATTENTION, les paramètres NestedAssoc::UNSHIFT et NestedAssoc::PUSH doivent s'accompagner d'un 2ème paramètre obligatoirement. Ce 2nd paramètre
         * est un array composé d'un int, d'un array de couples nomField/valeurField, ou d'un objet de même Model (voir fonction "afterInsert" pour plus de précision
         * à ce sujet). Cet array doit contenir des éléments qui ne doivent correspondre qu'à des enfants de l'élément. Si d'autres noeuds sont passés via ce
         * paramètre ils seront alors ignorés.
         *
         * Paramètre facultatif (nécessaire que dans le cas d'un $typeReorder == NestedAssoc::UNSHIFT ou $typeReorder == NestedAssoc::PUSH) :
         *
         * Array de X variables représentant chacune un noeud de l'arbre via un int, un array ou un objet (voir le ATTENTION précédent). Chaque noeud peut être donné
         * sous n'importe quelle forme.
         * Ex :
         * $instance = ModelX::$manager->get(1);
         * $node57 = ModelX::$manager->get(57);
         * $instance->nestedAssoc->reorder(NestedAssoc::PUSH, array(84,76,array("name" => 77, "value" => 3),$node57))
         * Dans cet exemple si le node d'identifiant 76 n'est pas un enfant du node 1 alors seuls le node 84, le node ayant pour name 77 et value 3, et le node 57
         * seront réordonnés et placés à la fin des enfants du node 1
	 */
	public function reorder($typeReorder)
	{
	    $args = func_get_args();
	    $manager = Manager::getManager($this->from);
	    $leftName = $this->options[self::LEFT_FIELD];
	    $rightName = $this->options[self::RIGHT_FIELD];
	    $depthName = $this->options[self::DEPTH_FIELD];

	    switch($typeReorder)
	    {
		case self::REVERSE:
		    //classer les elements dans l'ordre dans lequel on veut les updater afin de simplement les update avec un increment
		    $sq = $manager->select($this->from.".*, (COUNT(parent.".$leftName.") - 1) AS depth, IF(COUNT(parent.".$leftName.") = 1, ".$this->from.".".$leftName.", parent.".$leftName.") as lftDirectChild, @increment := 0");
		    $sq->from($this->from, "parent");
		    $sq->where($this->from.".".$leftName." BETWEEN parent.".$leftName." AND parent.".$rightName);
		    $sq->where("parent.".$leftName." > ".$this->model->{$leftName}." AND parent.".$rightName." < ".$this->model->{$rightName});
		    $sq = $this->groupByPrimaries($sq);
		    $sq->orderBy(array("lftDirectChild" => "DESC", $leftName));

		    $qu = $manager->update();
		    $qu->from($sq, "targetsToReorder");
		    $pks = array_keys(Field::getPrimaryFields($this->from));
		    foreach($pks as $pk){$qu->where($this->from.".".$pk." = targetsToReorder.".$pk);}
		    $values = array();
		    $values[$this->from.".".$leftName] = $this->model->{$leftName}." + (@increment := @increment + 1) - targetsToReorder.depth";
		    $values[$this->from.".".$rightName] = $this->model->{$leftName}." + (@increment := @increment + 1) - targetsToReorder.depth + (".$this->from.".".$rightName." - ".$this->from.".".$leftName." - 1)";
		    $qu->values($values);
		    //trace("".$qu);
		    $qu->run();
		    break;

		case self::REVERSE_RECURSIF:
		    $q = $manager->update();
		    $values = array();
		    //obligé de passer par une table temporaire pour inverser les 2 valeurs, sinon lft change avant d'etre prise en compte correctement par rgt
		    $q->from($this->from, "temp");
		    $q = $this->linkedByPrimaries($q, $this->from, "temp");
		    $values[$this->from.".".$leftName] = $this->model->{$rightName}." - ".$this->from.".".$rightName." + ".$this->model->{$leftName};
		    $values[$this->from.".".$rightName] = $this->model->{$rightName}." - temp.".$leftName." + ".$this->model->{$leftName};
		    $q->values($values);
		    $q->where($this->from.".".$leftName." > ".$this->model->{$leftName}." AND ".$this->from.".".$rightName." < ".$this->model->{$rightName});
		    $q->run();
		    break;

		case self::UNSHIFT:
		case self::PUSH:

		    //initialise le compteur incremental
		    $q = $manager->select("@increment := 0");
		    //trace("".$q);
		    $temp = $q->one();

		    if($typeReorder == self::UNSHIFT)
		    {
			$sq = $manager->select("*, (".$this->orderWithArgs($sq, $args[1]).") as __arrayOrder__");
		    }
		    else
		    {
			$sq = $manager->select("*, (".$this->orderWithArgs($sq, $args[1], false).") as __arrayOrder__");
		    }
		    $q = $manager->select();
		    $q->from($sq, "parent");
		    $q->where($this->from.".".$leftName." BETWEEN parent.".$leftName." AND parent.".$rightName);
		    $q->where($this->from.".".$leftName." > ".$this->model->{$leftName}." AND ".$this->from.".".$rightName." < ".$this->model->{$rightName});
		    $q->where("parent.".$depthName." = ".$this->model->{$depthName}." + 1");
		    $q = $this->groupByPrimaries($q);
		    $q->orderBy(array("parent.__arrayOrder__", $this->from.".".$leftName));
		    //trace("".$q);

		    //on update le tout en decrementant correctement petit à petit les enfants et petits enfants que l'on réordonne en début
		    //de l'élément parent. Ceci à partir du rgt du parent
		    $qu = $manager->update();
		    $qu->from($q, "targetsToReorder");
		    $pks = array_keys(Field::getPrimaryFields($this->from));
		    foreach($pks as $pk){$qu->where($this->from.".".$pk." = targetsToReorder.".$pk);}
		    $values = array();
		    $values[$this->from.".".$leftName] = $this->model->{$leftName}." + (@increment := @increment + 1) - (targetsToReorder.dpt - ".$this->model->{$depthName}." - 1)";
		    $values[$this->from.".".$rightName] = $this->model->{$leftName}." + (@increment := @increment + 1) - (targetsToReorder.dpt - ".$this->model->{$depthName}." - 1) + (".$this->from.".".$rightName." - ".$this->from.".".$leftName." - 1)";
		    $qu->values($values);
		    //trace("".$qu);
		    $qu->run();


		    break;

		default:
		    //trace("DEFAULT, ON NE FAIT RIEN DE SPECIAL");
	    }
	}


	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////// FONCTIONS QUERIES APPELEES DEPUIS UNE DBQUERY //////////////////////////////////////////
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



	/**
	 * Retourne l'ensemble des éléments présents au sein de l'arbre (lft != 0)
         * @param DbQuery $q
	 * @param string $order : facultatif. Permet d'ordonner les éléments verticalement (NestedAssoc::VERTICAL) ou horizontalement (NestedAssoc::HORIZONTAL)
	 */
	public function __query_getFullTree($q, $order = null)
	{
	    $leftName = $this->options[self::LEFT_FIELD];
	    $depthName = $this->options[self::DEPTH_FIELD];

	    if($order == self::HORIZONTAL)
	    {
		$q->orderBy(array($this->from.".".$depthName, $this->from.".".$leftName));
	    }
	    elseif($order == self::VERTICAL) {
		$q->orderBy(array($this->from.".".$leftName));
	    }
	    $q->where($leftName." != '0'");
	    return $q;
	}

	/**
	 * Retourne les feuilles (noeuds n'ayant aucun enfant) de l'arbre
         * @param DbQuery $q
	 */
	public function __query_getLeaves($q)
	{
	    $leftName = $this->options[self::LEFT_FIELD];
	    $rightName = $this->options[self::RIGHT_FIELD];

	    $q->where($rightName." = ".$leftName." + 1");
	    return $q;
	}

	/**
	 * Retourne l'ensemble de l'arbre de l'élément passé en paramètre. Seuls l'élément et tous ses enfants/sous-enfants sont retournés
         * @param DbQuery $q
         * @param $target désignation d'un noeud cible à partir duquel on va récupérer un arbre composé de lui-même et de tous ses enfants
         * - int : si le model possedant l'association possède un identifiant unique de type int
         * - object de type Model : instance d'une classe Model de même type que l'élément.
         * - array : tableau associatif de nature suivante : array(nomField => valeurField, etc..). Instance correspondant aux couples nomField/valeurField transmis.
         * A n'utiliser que si les 2 moyens précédents ne peuvent être utilisés pour cibler le node cible.
	 * @param string $order : facultatif. Permet d'ordonner les éléments verticalement (NestedAssoc::VERTICAL) ou horizontalement (NestedAssoc::HORIZONTAL)
	 */
	public function __query_getTreeFrom($q, $target, $order = null)
	{
	    $leftName = $this->options[self::LEFT_FIELD];
	    $rightName = $this->options[self::RIGHT_FIELD];
	    $depthName = $this->options[self::DEPTH_FIELD];
	    $manager = $q->manager;

	    $q->from($this->from, "__parentTF__");
	    $q->where($this->from.".".$leftName." BETWEEN __parentTF__.".$leftName." AND __parentTF__.".$rightName);
	    $q = $this->getWhereThis($q, $target, "__parentTF__");
	    if($order == self::HORIZONTAL)
	    {
		$q->orderBy(array($this->from.".".$depthName, $this->from.".".$leftName));
	    }
	    elseif($order == self::VERTICAL) {
		$q->orderBy(array($this->from.".".$leftName));
	    }
	    $q->where($this->from.".".$leftName." != '0'");

	    //trace("".$q);
	    return $q;
	}

	/**
	 * Retourne le noeud parent de l'element passé en paramètre
         * @param DbQuery $q
         * @param $target désignation d'un noeud cible à partir duquel on va récupérer le parent.
         * - int : si le model possedant l'association possède un identifiant unique de type int
         * - object de type Model : instance d'une classe Model de même type que l'élément.
         * - array : tableau associatif de nature suivante : array(nomField => valeurField, etc..). Instance correspondant aux couples nomField/valeurField transmis.
         * A n'utiliser que si les 2 moyens précédents ne peuvent être utilisés pour cibler le node cible.
	 */
	public function __query_getParent($q, $target)
	{
	    $leftName = $this->options[self::LEFT_FIELD];
	    $rightName = $this->options[self::RIGHT_FIELD];
	    $depthName = $this->options[self::DEPTH_FIELD];
	    $manager = $q->manager;

	    //faire une sous-requete nous permettant de récupérer la target sur laquelle on va faire notre recherche
	    $sq = $manager->select();
	    $sq = $this->getWhereThis($sq, $target);
	    $sq->limit(1);

	    $q->where($this->from.".".$leftName." BETWEEN ".$this->from.".".$leftName." AND ".$this->from.".".$rightName);
	    $q->where($this->from.".".$leftName." < __target__.".$leftName." AND ".$this->from.".".$rightName." > __target__.".$rightName);
	    $q->from($sq, "__target__");
	    $q->orderBy(array($depthName => "DESC"));
	    $q->limit(1);
	    //trace($q."");
	    return $q;
	}

	/**
	 * Retourne les noeuds parents de l'element passé en paramètre classés du plus vieux vers le plus jeune ou vice-versa suivant le 2ème paramètre facultatif
         * @param DbQuery $q
         * @param $target désignation d'un noeud cible à partir duquel on va récupérer tous les noeuds parents.
         * - int : si le model possedant l'association possède un identifiant unique de type int
         * - object de type Model : instance d'une classe Model de même type que l'élément.
         * - array : tableau associatif de nature suivante : array(nomField => valeurField, etc..). Instance correspondant aux couples nomField/valeurField transmis.
         * A n'utiliser que si les 2 moyens précédents ne peuvent être utilisés pour cibler le node cible.
	 * @param string $order : facultatif. Permet d'ordonner les éléments du plus vieux au plus jeune ("ASC") ou du plus jeune au plus vieux ("DESC")
	 */
	public function __query_getParents($q, $target, $order = null)
	{
	    $leftName = $this->options[self::LEFT_FIELD];
	    $rightName = $this->options[self::RIGHT_FIELD];
	    $depthName = $this->options[self::DEPTH_FIELD];
	    $manager = $q->manager;

	    //faire une sous-requete nous permettant de récupérer la target sur laquelle on va faire notre recherche
	    $sq = $manager->select();
	    $sq = $this->getWhereThis($sq, $target);
	    $sq->limit(1);

	    $q->where($this->from.".".$leftName." BETWEEN ".$this->from.".".$leftName." AND ".$this->from.".".$rightName);
	    $q->where($this->from.".".$leftName." < __target__.".$leftName." AND ".$this->from.".".$rightName." > __target__.".$rightName);
	    $q->from($sq, "__target__");
	    if($order)
	    {
		$q->orderBy(array($depthName => $order));
	    }
	    //trace($q."");
	    return $q;
	}



	/**
	 * Retourne les noeuds enfants/sous-enfants de l'element passé en paramètre
         * @param DbQuery $q
         * @param $target désignation d'un noeud cible à partir duquel on va récupérer tous les noeuds enfants/sous-enfants.
         * - int : si le model possedant l'association possède un identifiant unique de type int
         * - object de type Model : instance d'une classe Model de même type que l'élément.
         * - array : tableau associatif de nature suivante : array(nomField => valeurField, etc..). Instance correspondant aux couples nomField/valeurField transmis.
         * A n'utiliser que si les 2 moyens précédents ne peuvent être utilisés pour cibler le node cible.
         * @param string $order : facultatif. Permet d'ordonner les éléments verticalement (NestedAssoc::VERTICAL) ou horizontalement (NestedAssoc::HORIZONTAL)
	 */
	public function __query_getChildren($q, $target, $order = null)
	{
	    $leftName = $this->options[self::LEFT_FIELD];
	    $rightName = $this->options[self::RIGHT_FIELD];
	    $depthName = $this->options[self::DEPTH_FIELD];

	    $q->from($this->from, "parent");
	    $q->where($this->from.".".$leftName." BETWEEN parent.".$leftName." AND parent.".$rightName);
	    $q = $this->getWhereThis($q, $target, "parent");
	    if($order == self::HORIZONTAL)
	    {
		$q->orderBy(array($this->from.".".$depthName, $this->from.".".$leftName));
	    }
	    elseif($order == self::VERTICAL) {
		$q->orderBy(array($this->from.".".$leftName));
	    }

	    //trace($q."");
	    return $q;
	}

	/**
	 * Retourne les noeuds enfants immédiats (et non les sous-enfants) de l'element passé en paramètre
         * @param DbQuery $q
         * @param $target désignation d'un noeud cible à partir duquel on va récupérer tous les noeuds enfants.
         * - int : si le model possedant l'association possède un identifiant unique de type int
         * - object de type Model : instance d'une classe Model de même type que l'élément.
         * - array : tableau associatif de nature suivante : array(nomField => valeurField, etc..). Instance correspondant aux couples nomField/valeurField transmis.
         * A n'utiliser que si les 2 moyens précédents ne peuvent être utilisés pour cibler le node cible.
	 */
	public function __query_getImmediateChildren($q, $target)
	{
	    $depthName = $this->options[self::DEPTH_FIELD];

	    $q = $this->__query_getChildren($q, $target);
	    $q->where($this->from.".".$depthName." = parent.".$depthName." + 1");

	    return $q;
	}















	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////// FONCTIONS UTILITAIRES (PRIVATE) DE MANIPULATION SQL ////////////////////////////////////
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


	/**
	 * Ajoute à une requête les where indispensables pour faire le lien avec l'element passé en paramètre
	 * @param <type> $q
	 * @param <type> $params
	 * @return <type>
	 */
	private function getWhereThis($q, $params, $model = NULL)
	{
	    if(!$model) $model = $this->from;

	    if(is_numeric($params))
	    {
		$id = array_keys(Field::getPrimaryFields($this->from));
		$q->where($model.".".$id[0]." = ".$q->quote($params));
	    }
	    elseif(is_array($params))
	    {
		foreach($params as $name => $value)
		{
		    $q->where($model.".".$name." = ".$q->quote($value));
		}
	    }
	    else
	    {
		$pks = array_keys(Field::getPrimaryFields($params));
		foreach($pks as $pk){$q->where($model.".".$pk." = '".$params->{$pk}."'");}
	    }

	    return $q;
	}


	/**
	 * Ajoute à une requête les where indispensables pour faire les liens avec les elements passés en paramètre
	 * @param <type> $q
	 * @param <type> $params
	 * @param <type> $find si cette variable est à false c'est que l'on veut récupérer tout ce qui n'est PAS passé en paramètre via params
	 * @return <type>
	 */
	private function getWhereThose($q, $listeParams, $find = true)
	{
	    if($find)
	    {
		$equal = "=";
	    }
	    else
	    {
		$equal = "!=";
	    }

	    $where = "(";
	    $i = 0;
	    foreach($listeParams as $params)
	    {
		if($i!=0) $where .= ") OR (";

		if(is_numeric($params))
		{
		    $id = array_keys(Field::getPrimaryFields($this->from));
		    $where .= $this->from.".".$id[0]." ".$equal." ".$q->quote($params);
		}
		elseif(is_array($params))
		{
		    $j = 0;
		    foreach($params as $name => $value)
		    {
			if($j!=0) $where .= " AND ";
			$where .= $this->from.".".$name." ".$equal." ".$q->quote($value);
			$j++;
		    }
		}
		else
		{
		    $pks = array_keys(Field::getPrimaryFields($params));
		    $j = 0;
		    foreach($pks as $pk)
		    {
			if($j!=0) $where .= " AND ";
			$where .= $this->from.".".$pk." ".$equal." '".$params->{$pk}."'";
			$j++;
		    }
		}

		$i++;
	    }
	    $where .= ")";
	    $q->where($where);

	    return $q;
	}

	/**
	 * Permet de faire en sorte d'avoir un orderBy qui retourne des enregistrements dans le même ordre que le tableau passé en paramètre
	 * @param <type> $q
	 * @param <type> $listeParams
	 * @param <type> $order si order = DESC alors l'ordre donné doit constituer la fin de l'ordonnencement et non-plus le début
	 */
	private function orderWithArgs($q, $listeParams, $isAscOrder = true)
	{
	    //on parcours la liste des paramètres avant de construire la requete car si les elements n'ont pas le meme nombre d'argument
	    //par exemple le cas d'un id numérique + un model + un tableau (où le tableau contient 2 données et non 1 comme les autres)
	    //il ne faut ordonner que sur le plus petit denominateur commun, dans notre cas juste l'id

	    $elements = array();
	    $fields = array();
	    //si l'ordre est inversé ($isAscOrder == false) alors on commence à 2 car tous les autres éléments seront classé en tant que 1
	    //pour être devant
	    $i = ($isAscOrder)?1:2;
	    foreach($listeParams as $params)
	    {
		if(is_numeric($params))
		{
		    $id = array_keys(Field::getPrimaryFields($this->from));
		    $element = array();
		    $element[$this->from.".".$id[0]] = $params;
		    array_push($fields, $this->from.".".$id[0]);
		    $element["__ordercase__"] = $i;
		    array_push($elements, $element);

		}
		elseif(is_array($params))
		{
		    $element = array();
		    foreach($params as $name => $value)
		    {
			$element[$this->from.".".$name] = $value;
			array_push($fields, $this->from.".".$name);
		    }
		    $element["__ordercase__"] = $i;
		    array_push($elements, $element);
		}
		else
		{
		    $pks = array_keys(Field::getPrimaryFields($params));
		    $element = array();
		    foreach($pks as $pk)
		    {
			$element[$this->from.".".$pk] = $params->{$pk};
			array_push($fields, $this->from.".".$pk);
		    }
		    $element["__ordercase__"] = $i;
		    array_push($elements, $element);
		}

		$i++;
	    }

	    $fields = array_unique($fields);

	    $order = "CASE ";
	    if(sizeof($fields) == 1)
	    {
		$order .= $fields[0];
	    }
	    else
	    {
		$order .= "CONCAT(";
		$j = 0;
		foreach($fields as $field)
		{
		    if($j > 0) $order .= ", ";
		    $order .= $field;
		    $j++;
		}
		$order .= ")";
	    }

	    foreach($elements as $element)
	    {
		$order .= " WHEN ";
		if(sizeof($fields) > 1) $order .= " CONCAT(";
		$j = 0;
		foreach($fields as $field)
		{
		    if($j > 0) $order .= ", ";
		    $order .= ($element[$field])?$element[$field]:$field;
		    $j++;
		}
		if(sizeof($fields) > 1) $order .= ")";
		$order .= " THEN ".$element["__ordercase__"];
	    }

	    //si l'ordre est inversé ($order = "DESC") alors on donne 1 en ordonnencement plutot que 99999 car tous les autres éléments
	    //seront classé en suivant (2 à X)
	    //pour être devant
	    $order .= ($isAscOrder)?" ELSE 99999 END":" ELSE 1 END";

	    return $order;
	}

	/**
	 * Retourne une string pour le groupBy
	 */
	private function groupByPrimaries($q)
	{
	    $gb = "";

	    $pks = array_keys(Field::getPrimaryFields($this->from));
	    $j = 0;
	    foreach($pks as $pk)
	    {
		if($j!=0) $gb .= ", ";
		$gb .= $pk;
		$j++;
	    }

	    return $q->groupBy($this->from.".".$gb);
	}

	/**
	 * Permet de lier 2 modèle du type de model associé a cette assoc ($this->from) par leurs ids respectifs
	 * @param <type> $q
	 * @param <type> $firstTable
	 * @param <type> $secondTable
	 */
	private function linkedByPrimaries($q, $firstTable, $secondTable)
	{
	    $where = "";

	    $pks = array_keys(Field::getPrimaryFields($this->from));
	    $j = 0;
	    foreach($pks as $pk)
	    {
		if($j!=0) $where .= " AND ";
		$where .= $firstTable.".".$pk." = ".$secondTable.".".$pk;
		$j++;
	    }

	    return $q->where($where);
	}

	/**
	 * Permet d'ordonner le modèle par ses identifiants primaires
	 * @param <type> $q
	 * @param <type> $nextOrders
	 *
	 */
	private function orderByPrimaries($q, $alias = null, $nextOrders = array())
	{
	    if(!$alias) $alias = $this->from;

	    $order = array();
	    $pks = array_keys(Field::getPrimaryFields($this->from));
	    foreach($pks as $pk)
	    {
		array_push($order, $alias.".".$pk);
	    }

	    return $q->orderBy(array_merge($order, $nextOrders));
	}

	/**
	 * Permet de trouver un nom unique pour la creation d'un champ dans le model dont depend cette association. Ceci par rapport
	 * au nom transmis en parametre
	 * @param array $listeFields liste des champs du model concerne
	 * @param string $name nom a rendre unique
	 * @return string nom unique et non présent dans le model
	 */
	private function getUniqueFieldName($listeFields, $name)
	{
            if( isset($listeFields[$name.$i]) )
	    {
		for($i = 2;isset($listeFields[$name.$i]);$i++)
		{
		    //boucle permettant de trouver un nom non pris
		}
		$name = $name.$i;
	    }
	    return $name;
            
            //désormais on compose le nom avec le nom de l'assoc
            //return $this->name."_".$name;
	}
}


?>