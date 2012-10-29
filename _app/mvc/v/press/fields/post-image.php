<?
/* @var $this View */
/* @var $vv VV_admin_field */
$vv = $_vars;
/* @var $field ImageField */
$field=$vv->field;
?>
<div class="span2 item-thumbnail"
     data-field-type="File"
     data-field="root[thumb]"
     data-template="press/fields/post-image">

    <?//thumb ?>
    <img src="<?=$field->sizedWithoutCrop(171, 180, "000000", "jpg")?>" alt="<?/*=$vv->post->title*/?>" />

    <?if($vv->isAdmin()):?>
        <div class="wysiwyg">
            <span class="btn-input-file">
                            <input type="file" name="image_file" id="image_file" /><i class="icon-upload"></i>
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