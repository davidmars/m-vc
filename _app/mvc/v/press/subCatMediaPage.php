<?
    /* @var $vv VV_subCatMedia */
    $vv = $_vars;

    /* @var $this View */
    $this->inside("press/layout", $vv);
?>
<div class="posts">
    <div class="row">
    <div class="subcatMedia span8"
         data-model-id="<?=$vv->subCategoryMedia->id?>"
         data-model-type="M_subcategory_media"
         data-model-refresh-controller="<?=C_press::categoryMedia($vv->currentCategory->categoryMedia->id,0,true);?>"
            >

        <?if($vv->isAdmin()):?>
            save | add new  ?
        <?endif?>

        <h1 class="item-media-section"><?=$vv->subCategoryMedia->title?></h1>

        <?=$this->render("press/subCatMediaList",$vv)?>

        <div class="noGutter separatorTextBloc"></div>

    </div>
    </div>
</div>