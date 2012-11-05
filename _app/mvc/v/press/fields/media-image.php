<?
/* @var $this View */
/* @var $vv VV_admin_field */
$vv = $_vars;
/* @var $field ImageField */
$field=$vv->field;

/* @var $media VV_media */
$media=$vv->field->model;

?>
<div class="item-thumbnail"
     data-field-type="File"
     data-field="root[thumb]"
     data-template="press/fields/media-image">

    <?//thumb ?>    
    <div>

        <?if($media->isVideo()):?>
            <div class="isVideoMedia">
                &nbsp;
            </div>
        <?endif;?>

        <img src="<?=$field->sized(200, 200, "ff0000", "jpg")?>" alt="<?/*=$vv->post->title*/?>" />
    </div>

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