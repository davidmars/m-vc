<?
/* @var $vv VV_block */
$vv = $_vars;

/* @var $embed M_embed */
$embed=$vv->block->getContent();

$id = $vv->id;
$span = 8;
$offset = 0;
$content = $vv->code;

?>

<? // EMBED COMPONENT ?>
<div class="span<?=$span?>
      offset<?=$offset?>"
     data-model-type="Embed"
     data-model-id="<?=$id?>">

    <?if(M_user::currentUser()->canWrite()):?>
    <div class="wysiwyg-menu ">
        <div class="top-right">
            <span>Embed</span>
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
               data-model-target-type="<?=$vv->block->modelType?>"
               data-model-target-id="<?=$vv->block->modelId?>"
               data-model-target-field="medias">
                <i class="icon-circle-arrow-up icon-white"></i>
            </a>

            <a class=""
               href="#Model.nextPosition()"
               data-model-target-type="<?=$vv->block->modelType?>"
               data-model-target-id="<?=$vv->block->modelId?>"
               data-model-target-field="medias">
                <i class="icon-circle-arrow-down icon-white"></i>
            </a>




        </div>
    </div>
    <?endif?>


    <div class="noGutter">
        <div class="item-video">
            <?=$content?>
        </div>
    </div>
</div>