<? 
    /* @var $vv VV_post */
    $vv = $_vars;
    
    /* @var $this View */
    $this->inside("press/layout", $vv);
?>
<div class="post"
     data-model-type="M_post"
     data-model-id="<?=$vv->post->id?>"
     data-model-refresh-controller="<?=C_press::post($vv->post->id,true)?>"
     >
    <br/>
    <div class="row">
        <div class="postPreviewComponent">
            <div class="item-content">                                                              
                <? // POST COMPONENT ?>

                <div class="span8">



                    <div class="row">

                        <?if($vv->isAdmin()):?>
                            <div class="span8 mb1">
                            <a class="pull-right btn btn-success" href="#Model.save">Save</a>
                            </div>
                        <?endif?>

                        <?=$this->render("press/fields/post-image",$vv->thumbAdminField())?>

                        <div class="span6 item-text">
                            <?//title ?>
                            <div data-field="root[title]"
                                 data-field-type="Text">
                                <div class="item-title">
                                    <span
                                        <?//editable ?>
                                        <?=$vv->isAdmin()?"contenteditable='true' ":""?>
                                        <?// no text formatting allowed here */?>
                                            data-remove-format="true">
                                         <?=$vv->post->title?>
                                    </span>
                                </div>
                            </div>

                            <br/>
                            <?//description ?>
                            <div data-field="root[description]" data-field-type="Text">
                                <div class="item-description">
                                    <span
                                           <?//editable ?>
                                           <?=$vv->isAdmin()?"contenteditable='true' ":""?>
                                           <?// no text formatting allowed here */?>
                                           data-remove-format="true">
                                        <?=$vv->post->description?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <?if($vv->isAdmin()):?>
                <div class="span8 mt1">
                    <a class=" btn btn-success" data-block-type="M_text" href="#Model.addBlock">
                        <i class="icon-white icon-plus-sign"></i>
                        Add a text
                    </a>
                </div>
                <?endif?>


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
                            <?=GiveMe::socialGoogle()?>
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


