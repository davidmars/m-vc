<?
/* @var $this View */
/* @var $vv VV_post */
$vv = $_vars;
    
$this->inside("press/layout/layout", $vv);
?>

<div class="row"
     data-model-type="M_post"
     data-model-id="<?=$vv->post->id?>"
     data-model-refresh-controller="<?=C_press::post($vv->post->id,true)?>"
    >
    <div class="span8">
        <div class="post padded background-content postPreviewComponent"

             >
                <div class="row">

                    <?if($vv->isAdmin()):?>

                    <div class="span8 mb1 mt1">
                        <div class="pull-right">
                            <a class=" btn btn-small btn-success"
                               href="#Model.saveAll()">
                                <i class="icon-ok icon-white"></i>
                                Save
                            </a>
                        </div>
                    </div>

                    <?endif?>


                    <?=$this->render("press/post/header-preview",$vv)?>


                </div>

                <div class="row mt1">

                        <div class="span8">

                             <?=$this->render("press/post/admin-blocks-buttons",$vv)?>

                             <div class="row">
                                <!-- Start the block switcher -->
                                <?  foreach ($vv->blocks as $bl):?>
                                    <? if ($bl->block->getContent()):?>
                                        <?=$this->render("press/blocks/" . $bl->block->modelType, $bl)?>
                                    <? endif;?>
                                <?  endforeach; ?>
                            </div>

                        <div class="clearfix"></div>

                        <? // SHARE COMPONENT ?>
                        <div class="shareComponent mt1 mb1">
                            <div class="row">
                                <?php $id = uniqid(); ?>
                                <div class="span8">
                                        <div class="item-share" id="<?= $id ?>">

                                            <div class="item-email" data-popinloder="<?=C_press::sendToFriend(true)?>"></div>
                                            <?=GiveMe::socialGoogle(GiveMe::currentUrl())?>
                                            <?=GiveMe::socialTwitter(GiveMe::currentUrl())?>
                                            <?=GiveMe::socialFB()?>
                                        </div>
                                </div>
                            </div>
                        </div>

                        <div class="clearfix"></div>

                    </div>
                </div>
        </div>

    </div>
</div>

<div class="backComponent mt1"
     href="<?=C_press::categoryPost($vv->getCategory()->id, "", true)?>"
    data-nav-is-ajax-target="mainContent"
    data-nav-is-ajax="true">
    <div class="row">
        <div class="span8">
            <div class="marged">
                <!-- Insertion d'un composant de titre -->
                <div class="item-title">GO  BACK TO <?=$vv->getCategory()->title?></div>
            </div>
        </div>
    </div>
</div>    


