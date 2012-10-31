<?
/* @var $vv VV_block */
$vv = $_vars;
/* @var $model M_photo */
$photo=$vv->block->getContent();


?>

<div class="span<?=$span?> offset<?=$offset?>"
     data-model-type="Photo"
     data-model-id="<?=$vv->id?>"

     >
    <div class="item-photo">
        <img src="<?=$photo->photo->sized(800,"auto","ff0000","jpg")?>" alt="image-<?=$vv->id?>" />
    </div>
</div>