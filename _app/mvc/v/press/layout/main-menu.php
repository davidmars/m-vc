<?
/* @var $this View */
/* @var $vv VV_layout */
$vv = $_vars;
?>
<!-- Menu vers chaque category -->
<div class="navBarComponent">
    <div class="row">

        <? foreach ($vv->getMainTabs() as $tab): ?>
        <div class="span2 item-nav <?=$tab->activeString()?>" data-main-tab="<?=$tab->uid()?>">
            <div class="marged">
                <a href="<?=$tab->url?>"
                   data-nav-is-ajax="true"
                   data-nav-is-ajax-target="mainContent"
                   data-is-item-nav="true">
                    <?if($tab->hasIcon):?>
                    <i class="sprite-item-nav"></i>
                    <?endif?>
                    <?=$tab->title?>
                </a>
                <span class="item-nav-arrow"></span>
            </div>
        </div>
        <?endforeach;?>
    </div>
</div>