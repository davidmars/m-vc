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
     data-model-refresh-controller="<?=C_press::categoryPost($vv->categoryPost->id,"0",true)?>"
    <?//a jquery selector that define where to inject the data-model-refresh-controller html result?>
     data-model-refresh-target-selector="#mainContent"
    >
    <div class="item-title">
        Contact
    </div>  
    <div class="item-content">
        <?foreach ($contactList->contacts as $contact): ?>    
            <div class="item-contact">
                <!-- The name of the Contact-->
                <div class="item-contact-name">
                    <?= $contact->name ?>        
                </div>

                <!-- The function of the Contact-->
                <div class="item-contact-function">
                    <?= $contact->function ?>        
                </div>
                <br/>

                <!-- The society of the Contact-->
                <? if ($contact->society): ?>
                    <div class="item-contact-society">
                        <?= $contact->society ?>        
                    </div>
                <? endif; ?>

                <!-- The address of the Contact-->
                <? if ($contact->street): ?>
                    <div class="item-contact-address">
                        <?= $contact->street ?>        
                        <br/>
                        <?= $contact->zip ?> <?= $contact->city ?> - <?= $contact->country ?>
                        <br/>
                        Tel: <?= $contact->number ?>
                        <br/>
                    </div>
                    <br/>
                <? endif; ?>

                <!-- The email of the Contact-->
                <div class="item-contact-email">
                    <a href="mailto:<?= $contact->email ?>"><?= $contact->email ?></a>
                </div>
                <br/>

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