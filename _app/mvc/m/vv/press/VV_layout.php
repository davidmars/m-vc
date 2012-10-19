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
     * @return Array<M_category_media> Return all subcategories media of the current blog
     */
    public function getAllSubCategoriesMedia() {
        return M_subcategory_media::$manager->select()->all();
    }
}
?>