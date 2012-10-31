<?
/* @var $this View */
/* @var $vv VV_block */
$vv = $_vars;
/* @var $model M_photo */
$photo=$vv->block->getContent();


?>

<div class="span8  block-post"
     data-model-type="M_block"
     data-model-id="<?=$vv->block->id?>">

    <?if($vv->isAdmin()):?>
    <div class="wysiwyg-menu ">
        <div class="top-right">
            <span>Photo</span>
            <a class=""
               href="#Model.delete">
                <i class="icon-remove icon-white"></i>
            </a>
            <a class=""
               href="#Model.save">
                <i class="icon-ok icon-white"></i>
            </a>

            <a class=""
               href="#Model.previousPosition()"
               data-model-target-type="M_post"
               data-model-target-id="<?=$vv->parentModel->id?>"
               data-model-target-field="blocks">
                <i class="icon-circle-arrow-up icon-white"></i>
            </a>

            <a class=""
               href="#Model.nextPosition()"
               data-model-target-type="M_post"
               data-model-target-id="<?=$vv->parentModel->id?>"
               data-model-target-field="blocks">
                <i class="icon-circle-arrow-down icon-white"></i>
            </a>
        </div>
    </div>
    <?endif?>

    <div class="item-photo">
        <?/*<img src="<?=$photo->photo->sized(800,"auto","ff0000","jpg")?>" alt="image-<?=$vv->id?>" />*/?>
        <?=$this->render("press/fields/block-photo",$vv->blockPhotoAdminField())?>
    </div>

</div>