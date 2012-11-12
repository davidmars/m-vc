<?php
/* @var $this View */
/* @var $vv VV_layout */
$vv = $_vars;
?>
<div class="popinloaded contact middleabs"
     data-model-type=""
     data-model-id=""
     data-model-refresh-controller="<?=C_press::showContact(true);?>"
    <?//prevent for url browser address change?>
     data-model-refresh-controller-not-an-url="true"
        >

    <div class="top">
        <div>
            <div class="item-email-title" >
                <a class="item-email-close" data-popinloder="close" href="#">&nbsp;</a>
                CONTACT
            </div>
            <iframe src="<?=$vv->embedContactUrl()?>" width="480px" height="480px" scrolling="no" frameborder="0"></iframe>
        </div>
    </div>
</div>