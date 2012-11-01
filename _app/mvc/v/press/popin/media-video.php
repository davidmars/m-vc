<?php
/* @var $this View */
/* @var $vv VV_media */
$vv = $_vars;
?>
    <div class="popinloaded video middleabs"
        data-model-type="M_media"
        data-model-id="<?=$vv->media->id?>"
        data-model-refresh-controller="<?=C_press::mediaPreview($vv->media->id,true);?>"
        <?//prevent for url browser address change?>
        data-model-refresh-controller-not-an-url="true"
        >
    <div class="top">
        <?=$vv->media->embed?>
    </div>

    <div class="bottom">
        <div class="container">
            <div class="row">
                <div class="span6">

                    <?if($vv->isAdmin()):?>
                        <div class="wysiwyg-embed" data-field="root[embed]" data-field-type="Text">
                            <b>Paste your embed code here</b>
                            <textarea class="embed"><?=$vv->media->embed?></textarea>
                        </div>
                    <?endif?>
                </div>
                <div class="span6">
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

</div>