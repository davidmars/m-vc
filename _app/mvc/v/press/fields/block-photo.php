<?
/* @var $this View */
/* @var $vv VV_admin_field */
$vv = $_vars;
/* @var $field ImageField */
$field=$vv->field;
?>

<div class="item-thumbnail"
     data-uplad-model-type="M_photo"
     data-field-type="File"
     data-field="root[photo]"
     data-template="press/fields/block-photo">

    <?//thumb ?>
    <img src="<?=$field->sized(800, "auto", "000000", "jpg")?>" alt="<?/*=$vv->post->title*/?>" />

    <?if($vv->isAdmin()):?>
        <div class="wysiwyg">
            <span class="btn-input-file">
                            <input type="file" /><i class="icon-upload"></i>
            </span>

             <input class="span2"
               placeholder="select a file"
               type="text"
               value="<?=$vv->value?>">

            <div class="progress progress-striped">
                <div class="bar" style="width: 0%;"></div>
            </div>
        </div>
    <?endif?>

</div>