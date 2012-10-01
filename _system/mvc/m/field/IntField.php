<?php
/**
 * Champ contenant un chiffre (int 255)
 *
 * @package Core.model
 * @subpackage Field
 */
class IntField extends Field {

	/*
	 * Option permettant d'obtenir un entier négatif (par défaut il ne peut être que positif (unsigned)
	 */
	const SIGNED = "signed";

	public function asDbColumn(){
		$col = parent::asDbColumn();
		$col->name = $this->name;
		$col->type = "int(255)";
		if(!$this->options[IntField::SIGNED])
		{
		     $col->type .= " unsigned";
		}

		//$col->index = DbColumn::UNIQUE;
		return $col;
	}

}

?>