<? 
    /* @var $media M_subcategory_media */
    $media = $_vars;
    
    $medias = $media->getMediaForPage(1);     
    
    $subPagination = $media->getNbPage();   
?>

<div class="mediaPreviewComponent">
    <div class="item-media-section">            
        <?=$media->title?>
    </div>
</div>
<div class="row">
    <div class="mediaPreviewComponent">
        <div class="item-media-content">       
            <!-- récupération de tous les médias -->
            <?  foreach ($medias as $m):?>
            <div class="span2 item-media-data">
                <div class="noGutter">
                    <img src="<?=GiveMe::url("pub/app/press/img/media.png")?>" alt="<?=$m->title?>" />
                    <br/>
                    <div class="item-media-name">
                        <?=$m->title?>
                    </div>
                </div>
            </div>         
            <? endforeach;?>
        </div>                
    </div>
</div>

<div class="row">
    <div class="pagination">
              Pagination => <?=$subPagination?>
    </div>
</div>
