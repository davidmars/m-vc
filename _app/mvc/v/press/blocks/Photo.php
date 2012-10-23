<?
    $vv = $_vars;
    
    $id = $vv["id"];
    $modelType = $vv["modelType"];
    $span = $vv["span"];
    $offset = $vv["offset"];
    $content = $vv["content"];       
?>

<div class="span<?=$span?> offset<?=$offset?>" data-model-type="Photo" data-model-id="<?=$id?>">
    <div class="item-photo">
        <img src="<?=GiveMe::url($content)?>" alt="image-<?=$id?>" />
    </div>
</div>