<?php
    /* @var $this View */
    /* @var $vv VV_categoryMedia */
    $vv = $_vars;   
?>

<div class="row">
    <div class="span8 bg-color1">
        <h3>More <?=$vv->categoryMedia->title?></h3>
    </div>
    <div class="span8">        
        <?for($p = 1; $p < $vv->categoryMedia->getNbPage() + 1; $p++):?>
        <a href="<?=C_press::categoryMedia($vv->categoryMedia->id, $p)->url()?>"><?=$p?></a>
        <?endfor;?>
    </div>
</div>
    