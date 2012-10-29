<? 
    /* @var $media M_subcategory_media */
    $media = $_vars;
?>

<div class="mediaPreviewComponent">
    <div class="item-media-section">
        <?=$media->title?>
    </div>
</div>

<div class="row">
    <div class="mediaPreviewComponent" data-nav-ajax-autoload="<?=C_press::subCatMedia($media->id, 0, true)?>"></div>

    <?/*
    <div class="pagination">
          Pagination => <?=$subPagination?>
    </div>
    */?>

    <div class="span8">
        <div class="pull-right">
            <a
                href="<?=C_press::mediaAll($media->id, true)?>"
                data-nav-is-ajax-target="mainContent"
                data-nav-is-ajax="true"
                rel="nofollow"
                class="font-media-link">
                    View all
            </a>
        </div>
    </div>
</div>