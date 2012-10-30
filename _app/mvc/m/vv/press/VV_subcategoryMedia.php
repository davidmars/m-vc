<?php
/**
 * Description of VV_subcategoryMedia
 *
 * @author francoisrai
 */
class VV_subcategoryMedia  {
    
    /**
     *
     * @var M_category_media It's the current category object 
     */
    public $categoryMedia;      

    
    public function init($currentCategory) {
        $this->currentCategoryId = $currentCategory->getCategoryId();        
        $this->categoryMedia = $currentCategory;                        
    }
}

?>