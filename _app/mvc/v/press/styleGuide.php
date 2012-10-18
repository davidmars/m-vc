<?php
    /* @var $vv VV_categoryPost */
    $vv = $_vars;            
    
    /* @var $this View */
    $this->inside("press/layout", $vv); 
    
    $backgrounds = array(
        "bg-color-title-bloc",
        "bg-color-download-bloc",
        "bg-color-contact-bloc",
        "bg-color-text-bloc",
        "bg-color-pop-in",
        "bg-color-separator-bloc"
    );
    
    $separators = array(
        "separator-nav-tab",
        "separator-homepage-bloc",
        "separator-download-page",
        "separator-text-bloc",
        "separator-download-attachment",
        "separator-contact-bloc"
    );
    
    $borders = array(
        "border-download-nav",
        "border-download-pop-in",
        "border-havana-pressroom-banner"
    );
    
    $fonts = array(
        "font-nav-tab-title",
        "font-bloc-title",
        "font-bloc-title active",
        "font-subtitle-download-page",
        "font-subtitle-text-bloc",
        "font-subtitle-description-receipes-page",
        "font-description-receipes-page",
        "font-text-content-category-post",
        "font-text-content-category-post important",
        "font-download-page",
        "font-download-text-bloc",
        "font-link-download-page",
        "font-link-download-page decoration",
        "font-link-products-page",
        "font-link-products-page decoration",
        "font-link-attachment-text",
        "font-contact-name",
        "font-contact-function",
        "font-contact-society",
        "font-contact-address",
        "font-contact-email",
        "font-link-pressroom",
        "font-havana-cultura",
        "font-banner-title",
        "font-banner-content"
    );
    
    $sizes = array(
        "picture-download-thumb",
        "picture-article-thumb",
        "picture-article-picture"
    );
?>
<div class="bg-image-style-guide">
    <h1>Style Guide Havana</h1>

    <br/>

    <h2><i><u>Backgrounds</u></i></h2><br/>
    <?foreach ($backgrounds as $background):?>
        <div class="<?=$background?>"><?=$background?></div>
        <br/>
    <? endforeach; ?>

    <br/>

    <h2><i><u>Separators</u></i></h2><br/>
    <?foreach ($separators as $separator):?>
        <div class="<?=$separator?>"><?=$separator?></div>
        <br/>
    <? endforeach; ?>

    <br/>

    <h2><i><u>Borders</u></i></h2><br/>
    <?foreach ($borders as $border):?>
        <div class="<?=$border?>"><?=$border?></div>
        <br/>
    <? endforeach; ?>


    <br/>

    <h2><i><u>Fonts</u></i></h2><br/>
    <?foreach ($fonts as $font):?>
        <div class="<?=$font?>"><?=$font?></div>
        <br/>
    <? endforeach; ?>

    <br/>

    <h2><i><u>Sizes</u></i></h2><br/>
    <?foreach ($sizes as $size):?>
    <div class="<?=$size?>" style="background-color: yellow;"><?=$size?></div>
        <br/>
    <? endforeach; ?>
</div>