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
        <?/* Pop-in Close */?>
        <?//TODO::rai::voir avec juliette pour le close?>
        <?/*
        <div >
            <span class="pull-right">
                <a class="popincloser-inside" data-popinloder="close" href="#">
                    <i class="icon-white icon-remove"></i>
                </a>
            </span>
        </div>
         * 
         */?>
        
        <?/* Image Preview */?>
        <img src="<?=GiveMe::imageSizedWithoutCrop($vv->media->theFile,550,"auto","000000","jpg")?>">
        
        <?/* Download Button */?>
        <div class="download-buttons">
            <?if($vv->isAdmin()):?>
                <?=$this->render("press/popin/admin-uploads",$vv)?>
            <?else:?>
                <span class="button">
                    <a href="<?=$vv->media->theFile->download()?>"><i class="icon-download"></i>&nbsp;Download LD</a>
                </span>
                &nbsp;|&nbsp;
                <span class="button">
                    <a href="<?=$vv->media->theFileHd->download()?>"><i class="icon-download"></i>&nbsp;Download HD</a>
                </span>
            <?endif?>
        </div>
    </div>
</div>