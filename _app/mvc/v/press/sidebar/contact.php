<?
/* @var $this View */
/* @var $vv VV_contact */
$vv = $_vars;

$contact=$vv->contact;

?>
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
               data-model-target-id="<?=$vv->contactList->model->id?>"
               data-model-target-field="contacts">
                <i class="icon-circle-arrow-up icon-white"></i>
            </a>

            <a class=""
               href="#Model.nextPosition()"
               data-model-target-type="M_contacts"
               data-model-target-id="<?=$vv->contactList->model->id?>"
               data-model-target-field="contacts">
                <i class="icon-circle-arrow-down icon-white"></i>
            </a>
            <a class="" href="#Model.delete">
                <i class="icon-remove icon-white"></i>
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
    
    <!-- The details of the Contact-->
    <div data-field="root[details]"
         data-field-type="Text">
        <div class="item-contact-address">
                            <span
                                <?//editable ?>
                                <?=$vv->isAdmin()?"contenteditable='true' ":""?>
                                <?// no text formatting allowed here */?>
                                    data-remove-format="true">
                                 <?= $contact->details ?>
                            </span>
        </div>
    </div>

    <!-- The function of the Contact-->
    <?/*
    <div data-field="root[role]"
         data-field-type="Text">
        <div class="item-contact-function">
                        <span
                            <?//editable ?>
                            <?=$vv->isAdmin()?"contenteditable='true' ":""?>
                                data-remove-format="true">
                                 <?= $contact->role ?>
                        </span>
        </div>
    </div>
    <br/>
    */?>           

    <!-- The address of the Contact-->
            <?/*
    <? if (!empty($contact->street) || $vv->isAdmin()): ?>
    <div class="item-contact-address">
        <!-- The street of the Contact-->
        <div data-field="root[street]"
             data-field-type="Text">
                            <span
                                <?//editable ?>
                                <?=$vv->isAdmin()?"contenteditable='true' ":""?>
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
                                    data-remove-format="true">
                                 <?= $contact->number ?>
                            </span>
        </div>
         * 
         
    </div>
    <? endif; ?>
             * */?>

    <!-- The email of the Contact-->
    <div data-field="root[email]"
         data-field-type="Text">
        <div class="item-contact-email">
            <a href="<?=!$vv->isAdmin()?"mailto:".trim($contact->email):"#"?>">
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
    <a class="item-contact-file" href="<?=$vv->contact->theFile->download()?>">
        <i class="icon-download"></i>
        Download contact

    </a>

    <?if($vv->isAdmin()):?>
    <div class="pull-right mt1">
        <div class="the-upload">
            <?=$this->render("press/fields/simple-file",$vv->theFileAdminField())?>&nbsp;<br/>
        </div>
    </div>

    <?endif;?>

    <div class="clearfix"></div>
</div>