<?
/* @var $this View */
/* @var $media VV_media */
$vv_media = $_vars;            
/* @var $vv VV_admin_field */
$vv = $vv_media->thumbAdminField();
/* @var $field ImageField */
$field=$vv->field;
?>
<div class="item-thumbnail"
     data-field-type="File"
     data-field="root[thumb]"
     data-template="press/fields/media-image">

    <?//thumb ?>    
    <div>
        <?if($vv_media->media->isVideo()):?>
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