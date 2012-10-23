<?php
/**
 * Created by JetBrains PhpStorm.
 * User: juliette david
 * Date: 23/10/12
 * Time: 07:25
 * To change this template use File | Settings | File Templates.
 */
class LinkModel extends Model {

    public function name(){
        $name = array();
        foreach( $this->fields() as $f ){
            if( is_a( $f , NtoOneAssoc ) ){
                if( $item = $this->{$f->name} ){
                    $name[] = $item->name();
                }else{
                    $name[] = $f->to;
                }
            }
        }
        return join(" / ",$name);
    }

}
