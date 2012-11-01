<?php
    /* @var $vv VV_categoryPost */
    $vv = $_vars;            
    
    /* @var $this View */
    $this->inside("press/layout/layout", $vv);
    
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
<style>
    .span-test{
        background-color: #ffff00;
        /*opacity: 0.8;*/
        margin-bottom: 20px;;
    }
    .span-test .padded,
    .span-test .padded-right,
    .span-test .padded-left{
        background-color: #ff0000;
        /*opacity: 0.8;*/
    }
    .span-test .t{
        background-color: #000000;
        color: #fff;
    }
</style>
<div class="row">
    <div class="span8">
        <div class="padded bg-image-style-guide">



    <h1>Havana Style Guide </h1>

    <br/>

    <h2>Grid system</h2>

    <div class="row">

        <h3 class="span8">Native Bootstrap grid system...</h3>

        <?for($i=1;$i<9;$i++):?>
            <div class="span-test span1">.span1</div>
        <?endfor?>

        <?for($i=1;$i<9;$i++):?>
            <div class="span-test span<?=$i?>">
                <div class="t">.span<?=$i?></div>
            </div>
        <?endfor?>

        <h3 class="span8">Fill the gutters with padding...</h3>

        <?for($i=1;$i<9;$i++):?>
            <div class="span-test span1">
                <div class="padded">
                    <div class="t">.span1</div>
                </div>
            </div>
        <?endfor?>

        <?for($i=1;$i<9;$i++):?>
            <div class="span-test span<?=$i?>">
                <div class="padded">
                    <div class="t">.span<?=$i?></div>
                </div>
             </div>
        <?endfor?>

        <h3 class="span8">Fill the left gutters with padding...</h3>

        <?for($i=1;$i<9;$i++):?>
            <div class="span-test span1">
                <div class="padded-left">
                    <div class="t">.span1</div>
                </div>
            </div>
        <?endfor?>

        <?for($i=1;$i<9;$i++):?>
            <div class="span-test span<?=$i?>">
                <div class="padded-left">
                    <div class="t">.span<?=$i?></div>
                </div>
             </div>
        <?endfor?>

        <h3 class="span8">Fill the right gutters with padding...</h3>

        <?for($i=1;$i<9;$i++):?>
            <div class="span-test span1">
                <div class="padded-right">
                    <div class="t">.span1</div>
                </div>
            </div>
        <?endfor?>

        <?for($i=1;$i<9;$i++):?>
            <div class="span-test span<?=$i?>">
                <div class="padded-right">
                    <div class="t">.span<?=$i?></div>
                </div>
             </div>
        <?endfor?>

        <h3 class="span8">Fill the gutters with margins...</h3>

        <?for($i=1;$i<9;$i++):?>
            <div class="span-test span1">
                <div class="marged">
                    <div class="t">.span1</div>
                </div>
            </div>
        <?endfor?>

        <?for($i=1;$i<9;$i++):?>
            <div class="span-test span<?=$i?>">
                <div class="marged">
                    <div class="t">.span<?=$i?></div>
                </div>
             </div>
        <?endfor?>

    </div>

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
    </div>
</div>