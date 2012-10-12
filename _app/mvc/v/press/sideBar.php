<?php
    /* @var $vv VV_layout */
    $vv = $_vars;      
?>

<h1>Sidebar</h1>

<div>
    Go to press Room Havana >
</div>

<h2>Contact</h2>
<!-- Pour chaque category post -->
<? foreach ($vv->getAllContact() as $contact): ?>
<!-- The title of the Contact-->
<div>
    <?=$contact->title?>
    <br/>
    <small><?=$contact->post?></small>
</div>

<!-- The description of the contact -->
<div>
    <br/>
    <?=$contact->description?>
    
</div>
<?endforeach;?>   