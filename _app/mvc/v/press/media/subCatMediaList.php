<?php
    /* @var $this View */
    /* @var $vv VV_subCatMedia */
    $vv = $_vars;
?>
<div class="row subcatMediaList">
    <!-- récupération de tous les médias -->
    <? if($vv->medias):?>
        <?foreach ($vv->medias as $m):?>
            <?=$this->render("press/media/media",$m)?>
        <?endforeach;?>
    <?endif;?>

    <?if($vv->completeList):?>
    <div data-nav-ajax-autoload="<?=$vv->completeList?>"></div>
    <?endif?>

</div>


