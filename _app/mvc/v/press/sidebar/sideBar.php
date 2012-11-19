<?php
/* @var $this View */
/* @var $vv VV_layout */
$vv = $_vars;
?>

<div class="marged">
    <? // PRESS ROOM COMPONENT ?>
    <a href="" class="pressRoomComponent">
        <div class="item-content">
            <div class="item-subtitle">Go to press room</div>
            <div class="item-title">Havana Cultura<i class="sprite-item-title"></i></div>
        </div>
    </a>
    <?=$this->render("press/sidebar/content",$vv)?>

</div>