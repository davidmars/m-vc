<?php
/* @var $this View */
/* @var $vv VV_media */
$vv = $_vars;
?>
    <div class="popinloaded other middleabs"
        data-model-type="M_media"
        data-model-id="<?=$vv->media->id?>"
        data-model-refresh-controller="<?=C_press::mediaPreview($vv->media->id,true);?>"
        <?//prevent for url browser address change?>
        data-model-refresh-controller-not-an-url="true"
        >

    <div class="bottom">
        <div class="container">
            <div class="span4 offset2">
                This is the default pop in download....it should display on or two buttons to download
                <?if($vv->isAdmin()):?>
                    <?=$this->render("press/popin/admin-uploads",$vv)?>
                <?else:?>
                    dwd1
                    & ||
                    dwd2
                <?endif?>
            </div>
        </div>
    </div>

</div>