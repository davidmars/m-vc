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
     * @var string The text identifier of the current active tab.
     */
    private $activeTab;
    /**
     * @return VV_mainTab[] list of tabs to display
     */
    public function getMainTabs(){
        $ret=array();
        foreach(DataBaseIndexes::getMainNavModels() as $model){
            $vv=new VV_mainTab();
            $vv->model=$model;
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
            if(M_::areSame(VV_mainTab::$activeModel,$model)){
                $vv->active=true;
                $this->activeTab=$vv->uid();
            }
        }
        return $ret;
    }
    public function getActiveTab(){
        $this->getMainTabs();
        return $this->activeTab;
    }



    
    /**
     * Return the contact list to display in the sidebar.
     * @param int $id the id of the contact list
     * @return VV_contactList Return a contact block
     */
    public function getContactList() {
        $contacts=M_contacts::$manager->select()->where("title", DataBaseIndexes::$contactListTitle)->one();
        return new VV_contactList($contacts);
    }
    
    /**
     *
     * @return M_category_media[] Return all subcategories media of the current blog
     */
    public function getAllSubCategoriesMedia() {
        return M_subcategory_media::$manager->select()->all();
    }

    /**
     * @return VV_media Return the press pack VV_media object.
     */

    public  function getPressPackDownload() {
        $download = M_media::$manager->select()->where("title", StaticDatas::$downloadPack)->one();

        $vv = new VV_media();
        $vv->init($download);

        /* @var $vv VV_media */
        return  $vv;
    }

    /**
     * @return string Return the url of the Header menu script
     */
    public function embedHeaderMenuUrl() {
        return StaticDatas::$embedHeaderMenu;
    }

    /**
     * @return string Return the url of the subHeader menu script
     */
    public function embedHeaderSubMenuUrl() {
        return StaticDatas::$embedHeaderSubMenu;
    }

    /**
     * @return string Return the url of the footer menu scrip
     */
    public function embedFooterUrl() {
        return StaticDatas::$embedFooter;
    }

    /**
     * @var bool use true for the login page, beacause we are not looged in yet but we nee som admin functionnalities.
     */
    public $isLogin=false;
}
?>
