<?php

class VV_layout extends ViewVariables {
    /**
     *
     * @var string It's the current category ID
     */
    public $currentCategoryId;

    /**
     * @var string the category id + name
     */
    public $currentCategoryIdName;


    /**
     * @return VV_mainTab[] list of tabs to display
     */
    public function getMainTabs(){
        $ret=array();
        foreach(DataBaseIndexes::getMainNavModels() as $model){
            $vv=new VV_mainTab();
            if(M_::areSame(VV_mainTab::$activeModel,$model)){
                $vv->active=true;
            }
            switch($model->modelName){
                case "M_category_post":
                    /** @var $model M_category_post  */
                    $vv->title=$model->title;
                    $vv->url=C_press::categoryPost($model->code,"0",true);
                    $ret[]=$vv;
                    break;
                case "M_category_media":
                    /** @var $model M_category_media  */
                    $vv->title=$model->title;
                    $vv->url=C_press::categoryMedia($model->code,"0",true);
                    $vv->hasIcon=true;
                    $ret[]=$vv;
                    break;
            }
        }
        return $ret;
    }





    
    /**
     *
     * @return M_contact[] Return all contact of the current blog
     */
    public function getAllContact() {
        return M_contact::$manager->select()->all();
    }
    
    /**
     *
     * @param int $id the id of the contact list
     * @return M_contacts Return a contact block
     */
    public function getContact($title="Havana PressRoom") {
        return M_contacts::$manager->select()->where("title", $title)->one();
    }
    
    /**
     *
     * @return M_category_media[] Return all subcategories media of the current blog
     */
    public function getAllSubCategoriesMedia() {
        return M_subcategory_media::$manager->select()->all();
    }

    /**
     * @return M_download Return the url for the download pack link
     */

    public  function getPressPackDownload() {
        $download = M_download::$manager->get(2);
        /* @var $download M_download */
        return  $download;
    }
}
?>
