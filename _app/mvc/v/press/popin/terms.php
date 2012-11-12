<?php
/* @var $this View */
/* @var $vv VV_layout */
$vv = $_vars;
?>
<div class="popinloaded shareEmail middleabs"
     data-model-type=""
     data-model-id=""
     data-model-refresh-controller="<?=C_press::showTerms(true);?>"
    <?//prevent for url browser address change?>
     data-model-refresh-controller-not-an-url="true"
        >

    <div class="top">
        <div>
            <div class="item-email-title" >
                <a class="item-email-close" data-popinloder="close" href="#">&nbsp;</a>
                TERMS AND CONDITIONS
            </div>
            <iframe src="<?=$vv->embedTermsUrl()?>" width="480px" height="320px" scrolling="no" frameborder="0"></iframe>
        </div>
    </div>
</div>