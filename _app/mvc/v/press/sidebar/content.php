<?php
/* @var $this View */
/* @var $vv VV_layout */
$vv = $_vars;
?>

<div data-model-type="nothing"
     data-model-id="nothing"
    <?//the controller url to use to refresh after actions?>
     data-model-refresh-controller="<?=C_press::sideBar(true)?>"
    <?//a jquery selector that define where to inject the data-model-refresh-controller html result?>
     data-model-refresh-target-selector="#sideBar"
    <?//prevent for url browser address change?>
     data-model-refresh-controller-not-an-url="true">

    <?if($vv->isAdmin()):?>
    <div class="row">
        <div class="span4 mt1 mb1">
            <span class="pull-right">
                <a class=" btn btn-small btn-success"
                   href="#Model.saveAll()">
                    <i class="icon-ok icon-white"></i>
                    Save
                </a>
            </span>
        </div>
    </div>
    <?endif?>
    <? // PRESS PACK COMPONENT ?>
    <?=$this->render("press/sidebar/pressPack", $vv->getPressPackDownload())?>

    <? // CONTACT COMPONENT ?>
    <?=$this->render("press/sidebar/contacts", $vv)?>
</div>