<?php
/* @var $this View */
/* @var $vv VV_media */
$vv = $_vars;
?>
    <div class="popinloaded photo middleabs"
        data-model-type="M_media"
        data-model-id="<?=$vv->media->id?>"
        >
    <div class="top">
        <img height="600" src="<?=GiveMe::imageSizedWithoutCrop($vv->media->theFile,"auto",550,"000000","jpg")?>">
    </div>

    <div class="bottom">
        <div class="container">
            <div class="span6">
                dwd1
            </div>
            <div class="span6">
                dwd2
            </div>
        </div>
    </div>

</div>