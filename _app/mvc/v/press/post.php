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
                            <img src="<?=$vv->post->thumb->sizedWithoutCrop(171, 180, "000000", "jpg")?>" alt="<?=$vv->post->title?>" />
                        </div>
                        <div class="span6 item-text">        
                            <div class="item-title">
                                <?=$vv->post->title?>
                            </div>
                            <br/>
                            <div class="item-description">
                                Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim
                            </div>                          
                        </div>
                    </div>
                </div>
                
                
                <!-- Start the block switcher -->
                <?  foreach ($vv->blocks as $block):?>
                    <?=$this->render("press/blocks/" . $block["modelType"], $block)?>
                <?  endforeach; ?>
                
                                
                <? // DOWNLOAD FILE COMPONENT ?>
                <div class="downloadFileComponent">
                    <div class="span8">
                        <div class="noGutter">
                            <div class="item-file">                                
                                <img src="<?= GiveMe::url("pub/app/press/img/icon_pdf.jpg") ?>" alt="" />                                
                                <div class="item-file-content">
                                    <div class="item-file-name">
                                        FileName (FileSize Ko)
                                    </div>
                                    <div class="item-file-download">
                                        <a href="">
                                            <i class="icon-download"></i>
                                            Télécharger
                                        </a>
                                    </div> 
                                </div>                                
                                <div class="clearfix"></div>                                
                            </div>
                            <div class="separatorTextBloc"></div>
                        </div>
                    </div>                    
                </div>
                
                <div class="clearfix"></div>
                <br/>
                
                <? // SHARE COMPONENT ?>
                <div class="span8">
                    <div class="item-share">
                        share links
                    </div>
                </div>
                
                <div class="clearfix"></div>
                <br/>
            </div>
        </div>
    </div>
    <br/>
</div>


