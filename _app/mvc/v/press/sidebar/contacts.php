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
            </span>

    </div>
    <?endif?>

    <?/*------------the contact list---------------*/?>
    <div class="item-content">
        <?foreach ($contactList->contacts as $contact): ?>
            <?=$this->render("press/sidebar/contact",$contact)?>
            <div class="separator-contact-bloc">&nbsp;</div>
        <? endforeach;?>

        <div class="clearfix"></div>
    </div>

</div>