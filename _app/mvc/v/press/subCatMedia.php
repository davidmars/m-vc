<?
/* @var $this View */
/* @var $vv VV_subCatMedia */
$vv = $_vars;

?>
<div class="span8 subcatMedia subcatMediaPreview"
        data-model-id="<?=$vv->subCategoryMedia->id?>"
        data-model-type="M_subcategory_media"
        data-model-refresh-controller="<?=C_press::categoryMedia($vv->currentCategory->categoryMedia->id,0,true);?>"
        >

            <?if($vv->isAdmin()):?>

            <div class="wysiwyg-menu">
                <div class="top-right">



                    <a class=" btn btn-small"
                       href="#Model.previousPosition()"
                       data-model-target-type="M_category_media"
                       data-model-target-id="<?=$vv->currentCategory->categoryMedia->id?>"
                       data-model-target-field="subcategories">
                        <i class="icon-arrow-up"></i>
                    </a>

                    <a class=" btn btn-small"
                       href="#Model.nextPosition()"
                       data-model-target-type="M_category_media"
                       data-model-target-id="<?=$vv->currentCategory->categoryMedia->id?>"
                       data-model-target-field="subcategories">
                        <i class="icon-arrow-down"></i>
                    </a>

                    <a class=" btn btn-danger btn-small"
                       href="#Model.delete">
                        <i class="icon-remove icon-white"></i>
                    </a>
                </div>
            </div>
            <?endif?>

        <h1 class="item-media-section">Subcat media :<?=$vv->subCategoryMedia->title?></h1>




        <?=$this->render("press/subCatMediaList",$vv)?>
        <div>
        <div class="">
            <a href="<?=C_press::subCatMedia($vv->subCategoryMedia->id,"Page","0","all",true)?>">All</a>
        </div>
        </div>


        <div class="noGutter separatorTextBloc"></div>

</div>
