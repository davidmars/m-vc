<?php

class VV_layout extends ViewVariables {
    /**
     *
     * @var string It's the current category ID
     */
    public $currentCategoryId;
    
                    
    /**
     *
     * @return Array<M_category_post> Return all categories post of the current blog
     */
    public function getAllCategoriesPost(){
         return M_category_post::$manager->select()->all();
    }
    
    /**
     *
     * @return Array<M_category_media> Return all categories media of the current blog
     */
    public function getAllCategoriesMedia(){
         return M_category_media::$manager->select()->all();
    }
    
    /**
     *
     * @return Array<M_contact> Return all contact of the current blog
     */
    public function getAllContact() {
        return M_contact::$manager->select()->all();
    }
    
    /**
     *
     * @param int $id the id of the contact list
     * @return M_contacts Return a contact block
     */
    public function getContact($id) {
        return M_contacts::$manager->get($id);
    }
    
    /**
     *
     * @return Array<M_category_media> Return all subcategories media of the current blog
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
