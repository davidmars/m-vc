<?php
    /* @var $this View */
    /* @var $vv VV_categoryPost */
    $vv = $_vars;   
?>

<div class="row">
    <div class="span8 bg-color1">
        <h3>More <?=$vv->categoryPost->title?></h3>
    </div>
    <div class="span8">        
        <?for($p = 1; $p < $vv->categoryPost->getNbPage() + 1; $p++):?>
        <a href="<?=C_press::categoryPost($vv->categoryPost->id, $p)->url()?>"><?=$p?></a>
        <?endfor;?>
    </div>
</div>
    