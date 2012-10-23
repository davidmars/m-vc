<?
    /* @var $vv M_embed */
    $vv = $_vars;
    
    $id = $vv->id;    
    $span = 8;
    $offset = 0;
    $content = $vv->code;       
?>

<? // EMBED COMPONENT ?>
<div class="span<?=$span?> offset<?=$offset?>" data-model-type="Embed" data-model-id="<?=$id?>">
    <div class="noGutter">
        <div class="item-video">
            <?=$content?>
        </div>
    </div>
</div>