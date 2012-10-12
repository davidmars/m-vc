<?php
/**
 * Description of VV_categoryPost
 *
 * @author francoisrai
 */
class VV_categoryPost extends VV_layout {
    
    /**
     *
     * @var M_category_post It's the current category object 
     */
    public $categoryPost;      
    
    /**
     *
     * @var int It's the current page of the category 
     */
    public $page;
    
    public function init($currentCategory, $pagination) {
        $this->currentCategoryId = $currentCategory->getCategoryId();        
        $this->categoryPost = $currentCategory;                        
        $this->page = $pagination;
    }
}

?>
