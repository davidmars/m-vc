<? 
    /* @var $vv VV_post */
    $vv = $_vars;
    
    /* @var $this View */
    $this->inside("press/layout", $vv);
?>
<div class="post">
    <br/>
    <div class="row">
        <div class="postPreviewComponent">
            <div class="item-content">                                                              
                <? // POST COMPONENT ?>
                <div class="span8">
                    <div class="row">
                        <div class="span2 item-thumbnail">
                            <img src="<?=$vv->post->thumb->sizedWithoutCrop(171, 180, "000000", "jpg")?>" alt="<?=$vv->post->title?>">
                        </div>
                        <div class="span6 item-text">        
                            <div class="item-title">
                                <?=$vv->post->title?>
                            </div>
                            <br/>
                            <div class="item-description">
                                <?=$vv->post->description?>
                            </div>                          
                        </div>
                    </div>
                </div>
                
                
                <!-- Start the block switcher -->
                <?  foreach ($vv->post->blocks as $b):?>
                    <? /* @var $b M_block */ ?>
                                    
                    <? if ($b->getContent()):?>
                        <?=$this->render("press/blocks/" . $b->modelType, $b->getContent())?>
                    <? endif;?>
                <?  endforeach; ?>

                <div class="clearfix"></div>
                <br/>
                
                <? // SHARE COMPONENT ?>
                <div class="shareComponent">
                    <?php $id = uniqid(); ?>
                    <div class="span8">
                        <div class="item-share" id="<?= $id ?>">

                            <a class="item-email" data-page=""></a>
                            <?=GiveMe::socialGoogle($mapage)?>
                            <?=GiveMe::socialTwitter()?>
                            <?=GiveMe::socialFB()?>
                        </div>
                    </div>
                </div>
                
                <div class="clearfix"></div>
                <br/>
            </div>
        </div>
    </div>
    <br/>
</div>


