<?php
/**
 * A category can contain posts, but a post can have only one category.  
 */
class M_category_media extends M_{

    public static $manager;
    /**
     *
     * @var TextField The name of the category media
     */
    public $title;
    
    /**
     * @var M_subcategory_media[] The associated subcategory to this category
     */
    public $subcategories;
    
    /**
     *
     * @param int $page It's the current page
     * @return Array<M_subcategory_media> Return all subcategory media of the current blog for the given page
     */
    public function getSubCategoryMediaForPage($page) {
        $offset = 4;

        $limitX = ($page - 1) * $offset;
        $limitY = $page * $offset;
               
        $subcategory_media = M_subcategory_media::$manager->select()->orderBy(array("id" => "asc"))->limit($limitX, $offset)->all();        
               
        return $subcategory_media;
    }
    
    /**
     *
     * @return int Return the number of page that this category can be display 
     */
    public function getNbPage() {
        $offset = 4;
        
        return ceil(M_subcategory_media::$manager->select()->count() / $offset);
    }
        
    /**
     *
     * @return string text identifier of model M_categoryMedia_1
     */
    public function getCategoryId() {
        return $this->modelName . "_" . $this->id;
    }
}



