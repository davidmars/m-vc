<?
    /* @var $vv VV_block */
    $vv = $_vars;
/* @var $text M_text */
$text=$vv->block->getContent();
?>

<div class="span8"
     data-model-type="M_block"
     data-model-id="<?=$vv->block->id?>">



    <?if($vv->isAdmin()):?>
    <div class="wysiwyg-menu ">
        <div class="top-right">
            <span>Text</span>
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



    <div data-field="root[title]" data-field-type="Text">
        <div class="item-title">
            <span
                <?//editable ?>
                <?=$vv->isAdmin()?"contenteditable='true' ":""?>
                <?// no text formatting allowed here */?>
                    data-remove-format="true">
                <?=$text->title?>
            </span>
        </div>
    </div>
    <div data-field="root[text]" data-field-type="Text">
        <div class="item-text">
            <span
                <?//editable ?>
                <?=$vv->isAdmin()?"contenteditable='true' ":""?>
                <?// no text formatting allowed here */?>
                    data-remove-format="true">
                <?=$text->text?>
            </span>
        </div>
    </div>


</div>