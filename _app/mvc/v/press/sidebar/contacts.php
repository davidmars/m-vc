<?php
/* @var $this View */
/* @var $vv VV_layout */
$vv = $_vars;

$contactList = $vv->getContactList();
?>

<!-- Contact  -->
<div class="contactComponent"
    <?//the current model type?>
     data-model-type="M_contacts"
    <?//the current model id?>
     data-model-id="<?=$contactList->model->id?>"
    <?//the controller url to use to refresh after actions?>
     data-model-refresh-controller="<?=C_press::sideBar(true)?>"
    <?//a jquery selector that define where to inject the data-model-refresh-controller html result?>
     data-model-refresh-target-selector="#sideBar"
    <?//prevent for url browser address change?>
     data-model-refresh-controller-not-an-url="true"
    >

    <div class="item-title">
        Contact
    </div>

    <?if($vv->isAdmin()):?>
    <div class="item-contact">
            <span class="pull-right">
                <?// create and add a contact to the contacts?>
                <a class=" btn btn-success btn-small"
                    <?//the action to do?>
                   href="#Model.addNewChild()"
                    <?//the new model type to create?>
                   data-new-type="M_contact"
                    <?//the field where to add the new post?>
                   data-new-field-target="contacts">
                    <i class="icon-plus-sign icon-white"></i>
                    Add a contact
                </a>
                <a class=" btn btn-small btn-success"
                   href="#Model.saveAll()">
                    <i class="icon-ok icon-white"></i>
                    Save
                </a>
                    </span>

    </div>
    <?endif?>

    <?/*------------the contact list---------------*/?>
    <div class="item-content">
        <?foreach ($contactList->contacts as $contact): ?>
            <?=$this->render("press/sidebar/contact",$contact)?>
        <? endforeach;?>

        <div class="clearfix"></div>
    </div>

</div>