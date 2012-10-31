<?
/* @var $this View */
/* @var $vv VV_subCatMedia */
$vv = $_vars;

?>
<div class="span8 subcatMedia subcatMediaPreview"
        data-model-id="<?=$vv->subCategoryMedia->id?>"
        data-model-type="M_subcategory_media"
        zzzzzzzdata-model-refresh-controller="<?=C_press::categoryMedia($vv->currentCategory->categoryMedia->id,0,true);?>"
        >
    <div class="noGutter">

            <?if($vv->isAdmin()):?>

            <div class="wysiwyg-menu">
                <div class="top-right">



                    <a class=""
                       href="#Model.previousPosition()"
                       data-model-target-type="M_category_media"
                       data-model-target-id="<?=$vv->currentCategory->categoryMedia->id?>"
                       data-model-target-field="subcategories">
                        <i class="icon-circle-arrow-up icon-white"></i>
                    </a>

                    <a class=""
                       href="#Model.nextPosition()"
                       data-model-target-type="M_category_media"
                       data-model-target-id="<?=$vv->currentCategory->categoryMedia->id?>"
                       data-model-target-field="subcategories">
                        <i class="icon-circle-arrow-down icon-white"></i>
                    </a>

                    <a class=""
                       href="#Model.delete">
                        <i class="icon-remove icon-white"></i>
                    </a>
                </div>
            </div>
            <?endif?>

        <h1 class="item-media-section"><?=$vv->subCategoryMedia->title?></h1>




        <?=$this->render("press/subCatMediaList",$vv)?>

        <div class="footer-preview">
            <div class="right">
                <?if($vv->isAdmin()):?>
                    <a class="btn btn-success btn-small" href="<?=C_press::subCatMedia($vv->subCategoryMedia->id,"Page","0","all",true)?>">
                        <i class="icon-edit icon-white"></i>
                        Edit this category
                    </a>
                <?else:?>
                    <a class=view-all href="<?=C_press::subCatMedia($vv->subCategoryMedia->id,"Page","0","all",true)?>">View all</a>
                <?endif?>

            </div>
        </div>

        <div class="clearfix"></div>
        <div class="noGutter separatorTextBloc"></div>
    </div>
</div>
