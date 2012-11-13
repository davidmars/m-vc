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
                SEND TO YOUR FRIENDS
            </div>
            <div class="item-email-content">
               <div class="item-email-form">
                   <p class="warning">I am of legal age and will send it to a legal age person</p>
                   <form id="emailform" name="sentoafriend" method="post" class="emailform" action="<?=C_press::sendToFriend(true);?>">
                       <? //email ?>
                       <label class="item-label" for="senderemail">
                           Your E-mail  <span class="required">*</span>
                       </label>
                       <input type="text" name="senderemail" value="" class="input" id="senderEmail"/>
                       <div class="clear"></div>

                       <? // email de l'ami ?>
                       <label class="item-label" for="friendEmail">
                           Your friend's e-mail  <span class="required">*</span>
                       </label>
                       <input type="text" name="friendemail" value="" class="input" id="friendEmail"/>
                       <div class="clear"></div>

                       <? // description ?>
                       <label class="item-label" for="textareaMessage">
                           Your message
                       </label>
                       <textarea name="message" id="textareaMessage" class="textarea"></textarea>
                       <div class="clear"></div>

                   <div class="item-email-from-footer  font3">
                       <input type="submit" name="submit" value="Send" class="submit">
                       <?/*TODO::RAI::Remove style put in inside class find why it's doesn't work*/?>
                       <span class="required-msg"><span class="required" style="color:#DD0000;">*</span> Required Fields</span>
                       <div id="popin_response_post" class="popin_response_post hidden" style="color: #990000;">Your email has been sent.</div>
                       <div id="popin_response_error" class="popin_response_error hidden" style="color:#DD0000;">Please correct the following errors:</div>
                       <div id="popin_response_error_mail" class="popin_response_error required hidden" style="color:#DD0000;">Enter a postal address</div>
                       <div id="popin_response_error_mail_valid" class="popin_response_error required hidden" style="color:#DD0000;">Enter a valid postal address</div>
                   </div>

                       <input id="sharedId" type="hidden" value="<?=GiveMe::currentUrl()?>" name="pageid"/>
                   </form>
               </div>
            </div>
        </div>

        <?/*
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
        */?>

    </div>
</div>