<?
    /* @var $vv VV_subCatMedia */
    $vv = $_vars;

    /* @var $this View */
    $this->inside("press/layout", $vv);
?>
<div class="posts"
     data-model-id="<?=$vv->subCategoryMedia->id?>"
     data-model-type="M_subcategory_media"
     data-model-refresh-controller="<?=C_press::subCatMedia($vv->subCategoryMedia->id,"Page","0","all",true);?>"
     >
    <div class="row">
    <div class="subcatMedia span8">

        <?if($vv->isAdmin()):?>
            <div class="">
                <div class="pull-right">
                        <?// create and add a contact to the contacts?>
                    <a class="pull-right btn btn-success"
                        <?//the action to do?>
                       href="#Model.addNewChild()"
                        <?//the new model type to create?>
                       data-new-type="M_media"
                        <?//the field where to add the new item?>
                       data-new-field-target="medias">
                        Add a download
                    </a>
                </div>
            </div>
        <?endif?>


        <div class="item-media-section"><?=$vv->subCategoryMedia->title?></div>

        <?=$this->render("press/subCatMediaList",$vv)?>

        <div class="noGutter separatorTextBloc"></div>

    </div>
    </div>
</div>