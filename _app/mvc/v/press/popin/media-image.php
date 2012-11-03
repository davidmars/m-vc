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
        <br/>
        <?if($vv->isAdmin()):?>
                <?=$this->render("press/popin/admin-uploads",$vv)?>
        <?else:?>
            <div class="download-buttons">
                <span class="button"><i class="icon-download"></i>&nbsp;Download LD</span>
                &nbsp;|&nbsp;
                <span class="button"><i class="icon-download"></i>&nbsp;Download HD</span>
            </div>
        <?endif?>
    </div>
</div>