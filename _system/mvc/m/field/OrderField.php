<?php
/**
 * Champ d'ordre (numérique) s'updatant automatiquement avec la valeur suivante
 *
 * @package Core.model
 * @subpackage Field
 */

class OrderField extends Field {

	public $query;

	public function __construct( $path, $options = array() ) {
		parent::__construct( $path, $options );
		if( $this->options["query"] ){
			$this->query = $this->options["query"];
		}else{
			$m = Manager::getManager( $this->from );

			if( $m ){
				$this->query = $m->select();
				$this->query->fields = array("nextOrder"=>"MAX({$this->fullname}) + 1");
				$this->query->manage( false );

			}
		}
	}

	/*public function attach( $model ){
		if( !$this->query ){
			$m = Manager::getManager( $this->from );

			if( $m ){
				$this->query = $m->select();
				$this->query->fields = array("nextOrder"=>"MAX({$this->fullname}) + 1");
				$this->query->manage( false );

			}
		}
		return parent::attach( $model );
	}*/
	
	public function serialize(){
		if( $this->value == null ){
			$r = $this->query->one();
			return $r["nextOrder"];
		}else{
			return $this->value;
		}
	}

	function asDbColumn(){
		$field = parent::asDbColumn();
		$field->type = "int(255) unsigned";
		$field->null = "NO";
		$field->key = DbColumn::INDEX;

		return $field;
	}

}

?>
