<?
    $vv = $_vars;
    
    $id = $vv["id"];
    $modelType = $vv["modelType"];
    $span = $vv["span"];
    $offset = $vv["offset"];
    $content = $vv["content"];       
?>

<? // EMBED COMPONENT ?>
<div class="span<?=$span?> offset<?=$offset?>" data-model-type="Embed" data-model-id="<?=$id?>">
    <div class="noGutter">
        <div class="item-video">
            <?=$content?>
        </div>
    </div>
</div>