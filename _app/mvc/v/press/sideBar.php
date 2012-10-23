<?php
/* @var $vv VV_layout */
$vv = $_vars;
?>

<? // PRESS ROOM COMPONENT ?>
<a href="" class="pressRoomComponent">
    <div class="item-content">
        <div class="item-subtitle">Go to the press room of</div>
        <div class="item-title">Havana Cultura<i class="sprite-item-title"></i></div>
    </div>    
</a>

<? // DOWNLOAD COMPONENT ?>
<div class="downloadComponent">
    <div class="item-title">
        Download
    </div>
    <a href="" class="item-content">
        <img src="<?= GiveMe::url("pub/app/press/img/media.png") ?>" alt="<?= $m->title ?>"  />        
        <i class="sprite-item-titleIcon"></i><span class="item-titleIcon">Download</span>
        <span class="item-subtitle">Press pack</span>        
    </a>    
</div>

<? // CONTACT COMPONENT ?>
<?=$this->render("press/contact", $vv)?>