<?
/* @var $this View */
/* @var $vv VV_admin_field */
$vv = $_vars;
/* @var $field ImageField */
$field=$vv->field;
?>
<div class="item-thumbnail"
     data-field-type="File"
     data-field="root[thumb]"
     data-template="press/fields/download-image">
    <div class="padded">

        <?//thumb ?>
        <img src="<?=$field->sized(64, 64, "000000", "jpg")?>" alt="<?/*=$vv->post->title*/?>" class="no-want-effect" />

        <?if($vv->isAdmin()):?>
        <div class="wysiwyg">
                <span class="btn-input-file no-want-effect">
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
</div>