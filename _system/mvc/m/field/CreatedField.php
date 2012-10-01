<?
/**
 * Champ de modèle contenant la date/heure de création d'un modèle
 *
 * @package Core.model
 * @subpackage Field
 *
 */
class CreatedField extends DatetimeField {

	/**
	 * Renvoie la date/heure courante si le modèle n'a pas encore été enregistré, sinon renvoie sa valeur précédente
	 * @return string La date/heure dans un format stockable
	 */
	public function serialize(){
		if( !$this->model->id ){	
			$this->value = time();
		}
		return parent::serialize();
	}
	
		
}

?>