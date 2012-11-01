<?php
/**
 * User: juliette david
 * Date: 01/11/12
 * Time: 09:06
 * This class define static variables that make relationship beetween the database and the project structure.
 * This is in config because your database can change from a server to an other one.
 */
class DataBaseIndexes
{
    /**
     * @return M_[] list of models that will help us to build the main menu.
     */
    public static function getMainNavModels(){
        $ret=array();
        $ret[]=M_category_post::$manager->get("press-release");
        $ret[]=M_category_post::$manager->get("recipes");
        $ret[]=M_category_post::$manager->get("products");
        $ret[]=M_category_media::$manager->get("downloads");
        return $ret;
    }
}
