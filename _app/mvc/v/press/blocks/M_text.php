<?
    /* @var $vv M_text */
    $vv = $_vars;        
    
    $id = 0;
    $span = 8;
    $offset = 0;    
?>

<div class="span<?=$span?> offset<?=$offset?>" data-model-type="Text" data-model-id="<?=$vv->id?>">
    <div class="item-title">
        <?=$vv->title?>
    </div>
    <div class="item-text">
        <?=$vv->text?>
    </div>
</div>