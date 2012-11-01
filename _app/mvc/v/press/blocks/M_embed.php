<?
/* @var $vv VV_block */
$vv = $_vars;

/* @var $embed M_embed */
$embed=$vv->block->getContent();




?>

<? // EMBED COMPONENT ?>
<div class="span8 block-post"
     data-model-type="M_block"
     data-model-id="<?=$vv->block->id?>">

    <?if($vv->isAdmin()):?>
    <div class="wysiwyg-menu ">
        <div class="top-right">
            <span>Embed</span>
            <a class=""
               href="#Model.delete">
                <i class="icon-remove icon-white"></i>
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


    <div class="">
        <div class="item-video">
            <?=$embed->code?>
        </div>
    </div>

    <?if($vv->isAdmin()):?>
    <div class="wysiwyg-embed" data-field="root[code]" data-field-type="Text">
        <b>Paste your embed code here</b>
        <textarea class="embed"><?=$embed->code?></textarea>
    </div>
    <?endif?>


</div>