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
     * @var M_subcategory_media the current sub category
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
     * @var VV_categoryMedia the parent category
     */
    public $currentCategory;

    /**
     * @var M_media[] all medias
     */
    public $medias;

    /**
     * @param $currentSubCategory M_subcategory_media
     * @param $start
     * @param $nbItem
     * @param $template
     */
    public function init($currentSubCategory, $start, $nbItem, $template) {

        $this->subCategoryMedia = $currentSubCategory;
        $this->currentIndex = $start;

        if ($nbItem == 'all')  {
            $this->medias = $currentSubCategory->medias;
        }
        else {
            $this->medias = $currentSubCategory->medias->select()->limit(($start - 1), $nbItem)->all();
        }
        $this->template = $template;
        $this->start = $start;
        $this->nbItem = $nbItem;
    }
}