<?php
/* @var $vv VV_layout */
$vv = $_vars;
?>

<!-- Insertion d'un composant de contact  -->
<div class="contactComponent">

    <!-- Insertion d'un composant de titre -->
    <div class="item-title">
        <div class="span4">
            <div class="noGutter">
                Contact
            </div>
        </div>
    </div>

    <!-- Insertion d'un composant de contenu -->    
    <div class="item-content">
        <div class="span4">
            <div class="noGutter">
                <? foreach ($vv->getAllContact() as $contact): ?>    
                    <div class="item-contact">
                        <br/>
                        <!-- The name of the Contact-->
                        <div class="item-contact-name">
                            <?= $contact->name ?>        
                        </div>

                        <!-- His function of the Contact-->
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
                            </div>
                            <br/>
                        <? endif; ?>

                        <!-- The email of the Contact-->
                        <div class="item-contact-email">
                            <?= $contact->email ?>
                        </div>
                        <br/>

                        <!-- The file of the Contact-->
                        <div class="item-contact-file">
                            <i class="icon-download">I</i>
                            Télécharger le contact
                        </div>
                        <br/>
                        <br/>

                    </div>

                    <div class="item-separator">&nbsp;</div>
                <? endforeach; ?>  </div>
        </div>
    </div>
    
</div>