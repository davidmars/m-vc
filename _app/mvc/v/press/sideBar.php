<?php
/* @var $vv VV_layout */
$vv = $_vars;
?>

<!-- Havana cultura press room link -->
<a href="" class="pressRoomComponent">
    <div class="item-content">
        <div class="item-subtitle">Go to the press room of</div>
        <div class="item-title">Havana Cultura</div>
    </div>    
</a>

<!-- Download -->
<div class="downloadComponent">
    <div class="item-title">
        Download
    </div>
    <a href="" class="item-content">
        <img src="<?= GiveMe::url("pub/app/press/img/media.png") ?>" alt="<?= $m->title ?>"  />
        <span class="item-titleIcon">Download</span>
        <span class="item-subtitle">Press pack</span>
    </a>        
</div>

<!-- Contacts -->
<?=
$this->render("press/contact", $vv)?>