<?php
/**
 * Description of VV_categoryMedia
 *
 * @author francoisrai
 */
class VV_categoryMedia extends VV_layout {
    
    /**
     *
     * @var M_category_media It's the current category object 
     */
    public $categoryMedia;      
    
    /**
     *
     * @var int It's the current page of the category 
     */
    public $page;
    
    public function init($currentCategory, $pagination) {
        $this->currentCategoryId = $currentCategory->getCategoryId();        
        $this->categoryMedia = $currentCategory;                        
        $this->page = $pagination;
    }
}

?>
