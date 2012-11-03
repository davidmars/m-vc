<?php
/* @var $this View */
/* @var $vv VV_media */
$vv = $_vars;
?>
    <div class="popinloaded photo middleabs"
        data-model-type="M_media"
        data-model-id="<?=$vv->media->id?>"
        data-model-refresh-controller="<?=C_press::mediaPreview($vv->media->id,true);?>"
        <?//prevent for url browser address change?>
        data-model-refresh-controller-not-an-url="true"
        >    
        
    <div class="top">
        <img src="<?=GiveMe::imageSizedWithoutCrop($vv->media->theFile,"auto",550,"000000","jpg")?>">              
        <?if($vv->isAdmin()):?>
                <?=$this->render("press/popin/admin-uploads",$vv)?>
        <?else:?>
            <div class="download-buttons">
                <span class="button">
                    <a href="<?=$vv->media->theFile->download()?>"><i class="icon-download"></i>&nbsp;Download LD</a>
                </span>
                &nbsp;|&nbsp;
                <span class="button">
                    <a href="<?=$vv->media->theFileHd->download()?>"><i class="icon-download"></i>&nbsp;Download HD</a>
                </span>
            </div>
        <?endif?>
    </div>
</div>