<?php
    /* @var $vv VV_layout */
    $vv = $_vars;
?>

<div class="marged">
    <? // PRESS ROOM COMPONENT ?>
    <a href="" class="pressRoomComponent">
        <div class="item-content">
            <div class="item-subtitle">Go to the press room of</div>
            <div class="item-title">Havana Cultura<i class="sprite-item-title"></i></div>
        </div>
    </a>

    <? // PRESS PACK COMPONENT ?>
    <?=$this->render("press/sidebar/pressPack", $vv->getPressPackDownload())?>

    <? // CONTACT COMPONENT ?>
    <?=$this->render("press/sidebar/contacts", $vv)?>
</div>