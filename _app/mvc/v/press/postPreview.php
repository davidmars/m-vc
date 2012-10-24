<?
/* @var $post M_post */
$post = $_vars;
?>
<div class="row">
    <div class="postPreviewComponent">
        <div class="item-content">
            <div class="span2 item-thumbnail">
                <a href="<?= C_press::post($post->id)->url() ?>"><img src="<?=$post->thumb->sizedWithoutCrop(171, 180, "000000", "jpg")?>" alt="<?= $post->title ?>"></a>
            </div>
            <div class="span6 item-text">
                    <div class="item-title">
                        <a href="<?= C_press::post($post->id)->url() ?>"><?= $post->title ?></a>
                    </div>
                    <br/>
                    <div class="item-description">
                        <?= $post->description?>
                    </div>
                    <br/>
                    <div class="item-link-readMore">
                        <a href="<?= C_press::post($post->id)->url() ?>" rel="nofollow">Read More...</a>
                    </div>                
            </div>
        </div>
    </div>
</div>
