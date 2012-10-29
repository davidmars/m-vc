<?php
/**
 * Created by JetBrains PhpStorm.
 * User: francoisrai
 * Date: 26/10/12
 * Time: 15:43
 * To change this template use File | Settings | File Templates.
 */
class VV_subCatMedia extends VV_layout {


    /**
     * @var M_subcategoryMedia the current sub category
     */
    public $subCategoryMedia;

    /**
     * @var int The current index of the pagination
     */
    public $currentIndex;


    public function init($currentSubCategory, $pagination) {
        $this->currentCategoryId = $currentSubCategory->id;
        $this->currentCategoryIdName = $currentSubCategory->getCategoryId();
        $this->subCategoryMedia = $currentSubCategory;
        $this->currentIndex = $pagination;
    }
}