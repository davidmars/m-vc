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
                            <img src="http://actu.orangecaraibe.com/images1/zoom/1349434730877714817.jpg" alt="<?=$vv->post->title?>" />
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
                
                <div class="clearfix"></div>
                <br/>
                
                <? // VIDEO COMPONENT ?>
                <div class="span8">
                    <div class="noGutter">
                        <div class="item-video">
                            <iframe width="640" height="395" src="http://www.youtube.com/embed/OsHGFNWVWcA?autoplay=0&amp;rel=0&amp;theme=light&amp;showinfo=0&amp;modestbranding=0&amp;autohide=0&amp;wmode=opaque" frameborder="0" allowfullscreen></iframe>
                        </div>
                    </div>
                </div>
                
                <div class="clearfix"></div>
                <br/>
                
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
                <div class="shareComponent">
                    <?php $id = uniqid(); ?>
                    <div class="span8">
                        <div class="item-share" id="<?= $id ?>">

                            <a class="item-email" data-page=""></a>
                            <div class="item-google"><g:plusone href="" size="medium" count="false"></g:plusone></div>
                            <a class="item-twitter" href="http://twitter.com/share" data-url="" data-count="none" data-lang="en">Tweet</a>
                            <fb:like href="" send="true" layout="button_count" show_faces="false" width="200" font=""></fb:like>      

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


