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
     * @var int It's the current page of the subMedia
     */
    private $currentIndex;

    /**
     * @var int nb subMedia by page
     */
    private $subCatMediaByPage = 4;

    /**
     * @var VV_subCatMedia[] all subMedia of the category Media
     */
    public $subCatMedias;

    /**
     * @var VV_categoryMediaPagination[] all links
     */
    public $pages;

    public function init($currentCategory, $pagination) {
        $this->currentCategoryId = $currentCategory->id;
        if ($currentCategory) {
            $this->currentCategoryIdName = $currentCategory->getCategoryId();
        }

        $this->categoryMedia = $currentCategory;
        $this->currentIndex = $pagination;

        $limitX = $pagination * $this->subCatMediaByPage;


        $subCatMedias = $this->categoryMedia->subcategories->select()->limit($limitX, $this->subCatMediaByPage)->all();
        foreach ($subCatMedias as $subCat) {
            $s = new VV_subCatMedia();
            $s->init($subCat, 1, 4, "List");
            $this->subCatMedias[] = $s;
        }
        $this->setPages();
    }

    private function setPages() {
        $nbSubCatMedia = $this->categoryMedia->subcategories->select()->count();
        $nbPage = ceil($nbSubCatMedia / $this->subCatMediaByPage);

        for($i = 0; $i < $nbPage; $i++) {
            $link = new VV_categoryPostPagination();

            $link->name = $i + 1;
            $link->href = C_press::categoryMedia($this->currentCategoryId, "$i", true);

            $link->isCurrent = ($i == $this->currentIndex)?true:false;
            $this->pages[] = $link;
        }
    }
}

class VV_categoryMediaPagination extends  ViewVariables{
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
