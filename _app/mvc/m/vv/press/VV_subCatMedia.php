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

    public $template;

    public $start;

    public $nbItem;

    /**
     * @var M_media[] all medias
     */
    public $medias;

    public function init($currentSubCategory, $start, $nbItem, $template) {
        $this->subCategoryMedia = $currentSubCategory;
        $this->currentIndex = $start;
        $this->medias = $currentSubCategory->medias->select()->limit($start, $nbItem)->all();
        $this->template = $template;
        $this->start = $start;
        $this->nbItem = $nbItem;
    }
}