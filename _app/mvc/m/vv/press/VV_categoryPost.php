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
    private $currentIndex;

    /**
     * @var int nb post by page
     */
    private $postByPage = 4;

    /**
     * @var M_post[] all posts of the category
     */
    public $posts;

    /**
     * @var VV_categoryPostPagination[] all links
     */
    public $pages;
    
    public function init($currentCategory, $pagination) {
        $this->currentCategoryId = $currentCategory->id;
        $this->currentCategoryIdName = $currentCategory->getCategoryId();
        $this->categoryPost = $currentCategory;                        
        $this->currentIndex = $pagination;

        $limitX = $pagination * $this->postByPage;

        $this->posts = $this->categoryPost->posts->select()->limit($limitX, $this->postByPage)->all();
        $this->setPages();
    }

    private function setPages() {
        $nbPost = $this->categoryPost->posts->select()->count();
        $nbPage = ceil($nbPost / $this->postByPage);

        for($i = 0; $i < $nbPage; $i++) {
            $link = new VV_categoryPostPagination();

            $link->name = $i + 1;
            $link->href = C_press::categoryPost($this->currentCategoryId, "$i", true);

            $link->isCurrent = ($i == $this->currentIndex)?true:false;
            $this->pages[] = $link;
        }
    }
}

class VV_categoryPostPagination extends  ViewVariables{
    /**
     * @var string index name
     */
    public $name;

    /**
     * @var string the link to the paginated categoryPost
     */
    public $href;

    /**
     * @var bool true it's the current page
     */
    public $isCurrent;
}

?>
