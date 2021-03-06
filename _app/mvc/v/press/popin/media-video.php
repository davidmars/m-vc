<?php
/* @var $this View */
/* @var $vv VV_media */
$vv = $_vars;
?>
    <div class="popinloaded video middleabs"
        data-model-type="M_media"
        data-model-id="<?=$vv->media->id?>"
        data-model-refresh-controller="<?=C_press::mediaPreview($vv->media->id, "preview",true);?>"
        <?//prevent for url browser address change?>
        data-model-refresh-controller-not-an-url="true"
        >
        
    <?/* Pop-in Close */?>
    <div >
        <span class="pull-left">
            <a class="popincloser-inside" data-popinloder="close" href="#">
                <i class="icon-white icon-remove"></i>
            </a>
        </span>
    </div>
        
    <div class="top">
        <?=$vv->media->embed?>
        <?if($vv->isAdmin()):?>
            <div class="wysiwyg-embed" data-field="root[embed]" data-field-type="Text">
                <div class="popin-embed-text"><b>Paste your embed code here</b></div>
                <textarea class="embed"><?=$vv->media->embed?></textarea>
            </div>
        <?endif?>
        
        <?/* Download Button */?>
        <?if($vv->isAdmin()):?>
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
        <?endif?>
    </div>        
</div>