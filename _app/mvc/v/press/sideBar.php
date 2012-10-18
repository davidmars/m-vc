<?php
    /* @var $vv VV_layout */
    $vv = $_vars;      
?>

<!-- Havana cultura press room link -->
<div class="pressRoomComponent">
    <div class="item-content">
        <div class="item-subtitle">Go to press room</div>
        <div class="item-title">Havana Cultura</div>
    </div>
    
</div>

<!-- Download -->
<div class="downloadComponent">
    <div class="item-title">
        <div>Download</div>
    </div>    
    <div class="item-content">
        <br/>
    </div>
</div>

<!-- Contacts -->
<?=$this->render("press/contact", $vv)?>