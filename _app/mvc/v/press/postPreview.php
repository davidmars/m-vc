<? 
    /* @var $post M_post */
    $post = $_vars;
?>


<div class="row">
    <div class="span2">
        <img src="http://actu.orangecaraibe.com/images1/zoom/1349434730877714817.jpg" alt="img tmp" />
    </div>
    <div class="span6">        
        <h2><?=$post->title?></h2>
        <p>
            Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim
        </p>
        <br/>
        <a href="<?=C_press::post($post->id)->url()?>">Read More...</a>
    </div>
</div>
