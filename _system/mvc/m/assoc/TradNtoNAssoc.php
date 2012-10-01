<?
/**
 *
 * Classe Field chargée des associations N à N, par exemple les "tags", "related to", etc
 * Désigne une association N à N unique entre deux Modèles.
 *
 * @package Core.model.assoc
 *
 **/
class TradNtoNAssoc extends NtoNAssoc implements ArrayAccess {


    /**
     * Getter
     * @return $this NtoNAssoc renvoie l'association
     */
    public function get() {

	return $this;
	//return parent::offsetGet(Langue::$current);
    }
    /**
     * 
     * @param <type> $name
     * @return <type>
     */
    public function __get( $name ){

	$linkFields = array_keys( Field::getFields( $this->linkModel ) );

	if( Langue::$current && in_array( $name , $linkFields ) ) {

	    $trad = $this->offsetGet( Langue::$current );
	    return $trad->{$name};
	}
    }
    /**
     * returns an array containing the untranslated languages. 
     * @return Array each key in this array is a Langue model. 
     */
    public function missingTranslations(){
        $missing=array();
        foreach( Langue::$manager->select()->all() as $l ){
            if(!$this->exist($l)){
                $missing[]=$l;
            }
        }
        return $missing;
    }
    /**
     * return tru if the translation in the specified languages exists. Note, this method arbitrary uses the title translated field to do this check.
     * @param Langue $lang the language to test.
     * @return boolean true if the translation exists, false in the other case.
     */
    public function exist($lang){
        $trad = $this->offsetGet( $lang );
        if($trad->title || $trad->text){
           return true;
        }else{
           return false;
        }
            
    }

}

?>
