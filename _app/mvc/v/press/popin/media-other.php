<?php
/* @var $this View */
/* @var $vv VV_media */
$vv = $_vars;
?>
    <div class="popinloaded other middleabs"
        data-model-type="M_media"
        data-model-id="<?=$vv->media->id?>"
        data-model-refresh-controller="<?=C_press::mediaPreview($vv->media->id, "download",true);?>"
        <?//prevent for url browser address change?>
        data-model-refresh-controller-not-an-url="true"
        >

    <?/* Pop-in Close */?>
    <div class="popin-close">
        <span class="pull-left">
            <a class="popincloser-inside" data-popinloder="close" href="#">
                <i class="icon-white icon-remove"></i>
            </a>
        </span>
    </div>

    <?
        $single = "";
        if((!$vv->media->theFileHd->exists()) || (!$vv->media->theFile->exists())) {
            $single = "single";
        }
    ?>
        
    <div class="top <?=$single?> <?=($vv->isAdmin())?"admin":""?>">
        <?if($vv->isAdmin()):?>
            <?=$this->render("press/popin/admin-uploads",$vv)?>
        <?else:?>
            <div class="download-buttons">
                <div class="button">
                    <a href="<?=$vv->media->theFile->download()?>"><i class="icon-download"></i>&nbsp;Download LD</a>
                </div>
                <br/>
                <? if ($vv->media->theFileHd->exists() || $vv->isAdmin()):?>
                    <div class="button">
                        <a href="<?=$vv->media->theFileHd->download()?>"><i class="icon-download"></i>&nbsp;Download HD</a>
                    </div>
                <?endif?>
            </div>
        <?endif?>
    </div>
</div>