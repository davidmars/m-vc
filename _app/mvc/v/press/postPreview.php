<?
/* @var $post M_post */
$post = $_vars;
?>
<div class="row">
    <div class="postPreviewComponent">
        <div class="item-content">
            <div class="span2 item-thumbnail">
                <a href="<?= C_press::post($post->id)->url() ?>"><img src="http://francois.de.shic.cc/havana_pressroom/pub/app/press/img/recipes.png" alt="<?= $post->title ?>"></a>
            </div>
            <div class="span6 item-text">
                    <div class="item-title">
                        <a href="<?= C_press::post($post->id)->url() ?>"><?= $post->title ?></a>
                    </div>
                    <br/>
                    <div class="item-description">
                        Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim
                    </div>
                    <br/>
                    <div class="item-link-readMore">
                        <a href="<?= C_press::post($post->id)->url() ?>" rel="nofollow">Read More...</a>
                    </div>                
            </div>
        </div>
    </div>
</div>
