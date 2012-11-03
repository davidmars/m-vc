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
    <div class="top">
        <?if($vv->isAdmin()):?>
            <?=$this->render("press/popin/admin-uploads",$vv)?>
        <?else:?>
            <div class="download-buttons">
                <div class="button">
                    <a href="<?=$vv->media->theFile->download()?>"><i class="icon-download"></i>&nbsp;Download LD</a>
                </div>
                <br/>
                <div class="button">
                    <a href="<?=$vv->media->theFileHd->download()?>"><i class="icon-download"></i>&nbsp;Download HD</a>
                </div>
            </div>
        <?endif?>
    </div>
</div>