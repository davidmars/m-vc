<?php
/* @var $vv VV_layout */
$vv = $_vars;

$contactList = $vv->getContact("Havana PressRoom");
?>

<!-- Contact  -->
<div class="contactComponent"
    <?//the current model type?>
     data-model-type="M_contacts"
    <?//the current model id?>
     data-model-id="<?=$contactList->id?>"
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
                <a class="pull-right btn btn-success btn-small"
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

    <div class="item-content">
        <?foreach ($contactList->contacts as $contact): ?>    
            <div class="item-contact"
                 data-model-type="M_contact"
                 data-model-id="<?=$contact->id?>"
            >

                <!-- Save of the Contact-->
                <?if($vv->isAdmin()):?>
                    <div class="wysiwyg-menu ">
                        <div class="top-right">

                            <a class=""
                               href="#Model.previousPosition()"
                               data-model-target-type="M_contacts"
                               data-model-target-id="<?=$vv->getContact()->id?>"
                               data-model-target-field="contacts">
                                <i class="icon-circle-arrow-up icon-white"></i>
                            </a>

                            <a class=""
                               href="#Model.nextPosition()"
                               data-model-target-type="M_contacts"
                               data-model-target-id="<?=$vv->getContact()->id?>"
                               data-model-target-field="contacts">
                                <i class="icon-circle-arrow-down icon-white"></i>
                            </a>
                            <a class="" href="#Model.delete">
                                <i class="icon-remove icon-white"></i>
                            </a>
                            <a class="" href="#Model.save">
                                <i class="icon-ok icon-white"></i>
                            </a>
                        </div>
                    </div>
                <?endif?>

                <!-- The name of the Contact-->
                <div data-field="root[name]"
                    data-field-type="Text">
                    <div class="item-contact-name">
                        <span
                            <?//editable ?>
                            <?=$vv->isAdmin()?"contenteditable='true' ":""?>
                            <?// no text formatting allowed here */?>
                                data-remove-format="true">
                                 <?= $contact->name ?>
                        </span>
                    </div>
                </div>

                <!-- The function of the Contact-->

                <div data-field="root[role]"
                     data-field-type="Text">
                    <div class="item-contact-function">
                        <span
                            <?//editable ?>
                            <?=$vv->isAdmin()?"contenteditable='true' ":""?>
                            <?// no text formatting allowed here */?>
                                data-remove-format="true">
                                 <?= $contact->role ?>
                        </span>
                    </div>
                </div>
                <br/>

                <!-- The society of the Contact-->
                <? if ($contact->society): ?>
                    <div data-field="root[society]"
                         data-field-type="Text">
                        <div class="item-contact-society">
                            <span
                                <?//editable ?>
                                <?=$vv->isAdmin()?"contenteditable='true' ":""?>
                                <?// no text formatting allowed here */?>
                                    data-remove-format="true">
                                 <?= $contact->society ?>
                            </span>
                        </div>
                    </div>
                <? endif; ?>

                <!-- The address of the Contact-->
                <? if ($contact->street): ?>
                    <div class="item-contact-address">
                        <!-- The street of the Contact-->
                        <div data-field="root[street]"
                             data-field-type="Text">
                            <span
                                <?//editable ?>
                                <?=$vv->isAdmin()?"contenteditable='true' ":""?>
                                <?// no text formatting allowed here */?>
                                    data-remove-format="true">
                                 <?= $contact->street ?>
                            </span>
                        </div>

                        <!-- The zip of the Contact-->
                        <span data-field="root[zip]"
                             data-field-type="Text">
                            <span
                                <?//editable ?>
                                <?=$vv->isAdmin()?"contenteditable='true' ":""?>
                                <?// no text formatting allowed here */?>
                                    data-remove-format="true">
                                    <?= $contact->zip ?>
                            </span>
                        </span>

                        <!-- The city of the Contact-->
                        <span data-field="root[city]"
                              data-field-type="Text">
                            <span
                                <?//editable ?>
                                <?=$vv->isAdmin()?"contenteditable='true' ":""?>
                                <?// no text formatting allowed here */?>
                                    data-remove-format="true">
                                    <?= $contact->city ?>
                            </span>
                        </span>

                        <!-- The country of the Contact-->
                        <span data-field="root[country]"
                              data-field-type="Text">
                            -
                            <span
                                <?//editable ?>
                                <?=$vv->isAdmin()?"contenteditable='true' ":""?>
                                <?// no text formatting allowed here */?>
                                    data-remove-format="true">
                                    <?= $contact->country ?>
                            </span>
                        </span>

                        <!-- The number of the Contact-->
                        <div data-field="root[number]"
                             data-field-type="Text">
                            Tel:
                            <span
                                <?//editable ?>
                                <?=$vv->isAdmin()?"contenteditable='true' ":""?>
                                <?// no text formatting allowed here */?>
                                    data-remove-format="true">
                                 <?= $contact->number ?>
                            </span>
                        </div>
                    </div>
                <? endif; ?>

                <!-- The email of the Contact-->
                <div data-field="root[email]"
                    data-field-type="Text">
                    <div class="item-contact-email">
                        <a href="<?=!$vv->isAdmin()?"mailto:".$contact->email:"#"?>">
                            <span
                                <?//editable ?>
                                <?=$vv->isAdmin()?"contenteditable='true' ":""?>
                                <?// no text formatting allowed here */?>
                                    data-remove-format="true">
                                 <?= $contact->email ?>
                            </span>
                        </a>
                    </div>
                </div>

                <!-- The file of the Contact-->
                <a class="item-contact-file">
                    <i class="icon-download"></i>
                    Télécharger le contact
                </a>

                <div class="clearfix"></div>
            </div>

            <div class="item-separator">&nbsp;</div>
        <? endforeach;?>

        <div class="clearfix"></div>
    </div>

</div>