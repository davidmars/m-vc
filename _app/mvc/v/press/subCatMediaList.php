<?php
    /* @var $this View */
    /* @var $vv VV_subCatMedia */
    $vv = $_vars;
?>
<div class="row subcatMediaList">
    <!-- récupération de tous les médias -->
    <? if($vv->medias):?>
    <?foreach ($vv->medias as $m):?>

        <?/*-------------------one media box--------------------*/?>

        <?=$this->render("press/media",$m)?>

    <?endforeach;?>
    <?endif;?>
</div>
