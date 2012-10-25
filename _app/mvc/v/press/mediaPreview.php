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
        <div class="item-media-content" data-nav-ajax-autoload="<?=C_press::subCatMedia($media->id, 0, true)?>">
            <?/*


            <!-- récupération de tous les médias -->
            <?  foreach ($media->medias as $m):?>
            <?
                /* @var $m M_media /
            ?>
            <div class="span2 item-media-data">
                <div class="noGutter">
                    <img src="<?=GiveMe::url($m->thumb)?>" alt="<?=$m->title?>" />
                    <br/>
                    <div class="item-media-name">
                        <a href=""><?=$m->title?></a>
                    </div>                    
                    <a class="button" href="<?=$m->theFile->download()?>">
                        <i class="icon-download"></i>
                        Télécharger
                    </a>
                    <div class="clearfix"></div>
                </div>
            </div>         
            <? endforeach;?>
            */?>
        </div>                
    </div>
</div>

    <? /*
<div class="pagination">
          Pagination => <?=$subPagination?>
</div>
    */?>

<div class="pull-right">
    View all
</div>