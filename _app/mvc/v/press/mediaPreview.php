<? 
    /* @var $post M_post */
    $media = $_vars;
?>

<div class="row">
    <div class="mediaPreviewComponent">
        <div class="item-media-section">            
            <?=$media->title?>
        </div>
        <div class="item-media-content">       
            <!-- récupération de tous les médias -->
            <?  for ($i=1; $i < 5; $i++):?>
            <div class="span2 item-media-data">
                <img src="http://francois.de.shic.cc/havana_pressroom/pub/app/press/img/media.png" alt="img tmp" />
                <br/>
                <div class="item-media-name">
                    Lorem impsum
                </div>
            </div>
            <?  endfor;?>            
        </div>
    </div>
</div>
