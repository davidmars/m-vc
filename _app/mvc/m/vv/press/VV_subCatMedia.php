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
     * @var VV_media[] all medias
     */
    public $medias;


    /**
     * @var string The controller url to retrieve the complete list of media in pagination
     */
    public $completeList=null;

    /**
     * @param $currentSubCategory M_subcategory_media
     * @param $start
     * @param $nbItem
     * @param $template
     */
    public function init($currentSubCategory, $start, $nbItem, $template) {

        $this->subCategoryMedia = $currentSubCategory;
        $this->currentIndex = $start;

        $parent=$currentSubCategory->getParent();
        VV_mainTab::$activeModel=$parent;

        if ($nbItem == 'all')  {
            $medias = $currentSubCategory->medias;
        }
        else {
            $medias = $currentSubCategory->medias->select()->limit(($start - 1), $nbItem)->all();
        }

        foreach($medias as $m){
            $vvm=new VV_media();
            $vvm->init($m);
            //admin functionnalities for download will be available on the page only !
            if($template!="Page"){
                $vvm->disableLocalAdmin=true;
            }
            $vvm->subCategory=$currentSubCategory;
            $this->medias[]=$vvm;
        }

        $this->template = $template;

        if($template!="Page"){
            $nb=$currentSubCategory->medias->select()->count();
            if($nb>4 && $start!=5){ //if there is more than 4 and if we are not yet in the targeted controller/view
                $this->completeList=C_press::subCatMedia($currentSubCategory->id,"list",5,1000,true);
            }
        }

        $this->start = $start;
        $this->nbItem = $nbItem;
    }
}