<?php
/**
 * Champ contenant un chiffre (int 255)
 *
 * @package core.model
 * @subpackage field
 */
class FloatField extends Field {

        const DOUBLE = "double";

	public function asDbColumn(){
		$col = parent::asDbColumn();
		$col->name = $this->name;
                if($this->options[FloatField::DOUBLE] == true)
                {
                    $col->type = "double";
                }
                else
                {
                    $col->type = "float";
                }
		//$col->index = DbColumn::UNIQUE;
		return $col;
	}

}

?>