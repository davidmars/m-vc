<? 
    /* @var $post M_post */
    $post = $_vars;
?>


<div class="row">
    <div class="postPreviewComponent">
        <div class="item-content">
            <div class="span2 item-thumbnail">
                <img src="http://actu.orangecaraibe.com/images1/zoom/1349434730877714817.jpg" alt="img tmp" />
            </div>
            <div class="span5 item-text">        
                <div class="item-title">
                    <?=$post->title?>
                </div>
                <br/>
                <div class="item-description">
                    Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim
                </div>
                <br/>
                <div class="item-link-readMore">
                    <a href="<?=C_press::post($post->id)->url()?>">Read More...</a>
                </div>                
            </div>
        </div>
    </div>
</div>
