<?php
/* @var $this View */
/* @var $vv VV_layout */
$vv = $_vars;
?>
<div class="popinloaded shareEmail middleabs"
     data-model-type=""
     data-model-id=""
     data-model-refresh-controller="<?=C_press::sendToFriend(true);?>"
    <?//prevent for url browser address change?>
     data-model-refresh-controller-not-an-url="true"
        >

    <div class="top">
        <div>
            <div class="item-email-title" >
                <a class="item-email-close" data-popinloder="close" href="#">&nbsp;</a>
                envoyer à un ami
            </div>
            <div class="item-email-content">
               <div class="item-email-form">
                   <p class="warning">Il est interdit d’envoyer cet email à une personne mineure.</p>
                   <form id="emailform" name="sentoafriend" method="post" class="emailform" action="<?=C_press::sendToFriend(true);?>">
                       <? //email ?>
                       <label class="item-label" for="senderemail">
                           Votre E-mail <span class="required">*</span>
                       </label>
                       <input type="text" name="senderemail" value="" class="input" id="senderEmail"/>
                       <div class="clear"></div>

                       <? // email de l'ami ?>
                       <label class="item-label" for="friendEmail">
                           E-mail de votre ami <span class="required">*</span>
                       </label>
                       <input type="text" name="friendemail" value="" class="input" id="friendEmail"/>
                       <div class="clear"></div>

                       <? // description ?>
                       <label class="item-label" for="textareaMessage">
                           Votre message
                       </label>
                       <textarea name="message" id="textareaMessage" class="textarea"></textarea>
                       <div class="clear"></div>

                   <div class="item-email-from-footer  font3">
                       <input type="submit" name="submit" value="Envoyer" class="submit">
                       <span class="required-msg"><span class="required">*</span> Champs obligatoires</span>
                   </div>

                   </form>
               </div>
            </div>
        </div>
        <?/*
        <div id="popinEmail_<?= $uid = uniqid() ?>" class="popin-mail popinEmail">
            <div class="popin-box">



                <div class="red-title"><a href="javascript:;" class="right close-popin closePopin" id="closePopin" title="<?= $tr('BOUTON_CLOSE') ?>"><?= $tr('BOUTON_CLOSE') ?></a><?=$tr('GOODIES_SEND_TO_YOUR_FRIENDS') ?></div>
                <div class="popin-form">
                    <p class="warning"><?=$tr('CHAMP_LEGALOK'); ?></p>
                    <form id="emailform" name="sentoafriend" method="post" class="emailform" action="<?="test"?>">

                        <? // email ?>
                        <label class="label font3" for="senderEmail">
                            <?=$tr('SHARE_YOUR_EMAIL_HERE') ?> <span class="required">*</span>
                        </label>
                        <input type="text" name="senderemail" value="" class="input senderEmail" id="senderEmail"/>
                        <div class="clear"></div>

                        <? // email de l'ami ?>
                        <label class="label font3" for="friendEmail">
                            <?=$tr('SHARE_FRIEND_EMAIL_HERE') ?> <span class="required">*</span>
                        </label>
                        <input type="text" name="friendemail" value="" class="input friendEmail" id="friendEmail"/>
                        <div class="clear"></div>

                        <? // description ?>
                        <label class="label font3" for="textareaMessage">
                            <?=$tr('SHARE_YOUR_MESSAGE_HERE')?>
                        </label>
                        <textarea name="message" id="textareaMessage" class="textarea textareaMessage"></textarea>
                        <div class="clear"></div>

                        <div class="popin-form-footer font3">
                            <input type="submit" name="submit" value="<?=$tr('BOUTON_ENVOYER') ?>" class="submit">
                            <span class="required-msg"><span class="required">*</span> <?=$tr('CHAMP_CHAMPSOBLIGATOIRES') ?></span>
                            <div id="popin_response_post" class="popin_response_post contact-msg" style="display:none;"><?=$tr('MAIL_sent') ?></div>
                            <div id="popin_response_error" class="popin_response_error required" style="display:none;"><?=$tr('COMMENT_post_error') ?></div>
                            <div id="popin_response_error_mail" class="popin_response_error_mail required" style="display:none;"><?=$tr('COMMENT_post_error_mail') ?></div>
                            <div id="popin_response_error_mail_valid" class="popin_response_error_mail_valid required" style="display:none;"><?=$tr('COMMENT_post_error_mail_valid') ?></div>
                            <div class="clear"></div>
                            <input id="sharedId" type="hidden" value="<?="id"?>" name="pageid"/>
                        </div>
                    </form>
                </div>




            </div>
        </div> */?>
    </div>
</div>