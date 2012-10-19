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
        <div>Download</div>
    </div>    
    <div class="item-content">
        <br/>
    </div>
</div>

<!-- Contacts -->
<?=$this->render("press/contact", $vv)?>