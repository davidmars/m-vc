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
    <!-- récupération de tous les médias -->
    <?  foreach ($media->medias as $m):?>
    <?
                /* @var $m M_media */
            ?>
    <div class="span2 item-media-data">
      <div class="noGutter">
      	<a href="" data-nav-is-ajax-target="mainContent" data-nav-is-ajax="true" class="thumbnail"><img src="<?=GiveMe::url($m->thumb)?>" alt="<?=$m->title?>" /></a>
        <div class="item-media-content">
          <div class="item-media-name"> <a href="" data-nav-is-ajax-target="mainContent" data-nav-is-ajax="true">
            <?=$m->title?>
            </a> </div>
          <div class="item-media-link"> <a class="button" href="<?=$m->theFile->download()?>"> <i class="icon-download"></i> Télécharger</a>
            <div class="clearfix"></div>
          </div>
        </div>
      </div>
    </div>
    <? endforeach;?>
  </div>
  <? /*
<div class="pagination">
          Pagination => <?=$subPagination?>
</div>
    */?>
  <div class="span8">
    <div class="pull-right"> <a href="" data-nav-is-ajax-target="mainContent" data-nav-is-ajax="true" rel="nofollow">View all</a> </div>
  </div>
</div>
