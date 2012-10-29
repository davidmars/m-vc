<? 
    /* @var $media VV_subCatMedia */
    $media = $_vars;

    /* @var $vv VV_layout */
    $vv = new VV_layout();
?>


<!-- sub category media -->
<div class="mediaPreviewComponent">
    <!-- Save of the Contact-->
    <?if($vv->isAdmin()):?>
    <div>
        <a class="pull-right btn btn-danger btn-small" href="#Model.delete"><i class="icon-remove icon-white"></i></a>
        <a class="pull-right btn btn-success btn-small" href="#Model.save"><i class="icon-ok icon-white"></i></a>
    </div>
    <?endif?>

    <div class="item-media-section">
        <?=$media->subCategoryMedia->title?>
    </div>
</div>


<div class="row">

    <?=$this->render("press/media", $media)?>

    <div class="span8">
        <div class="pull-right">
            <a
                href=""
                data-nav-is-ajax-target="mainContent"
                data-nav-is-ajax="true"
                rel="nofollow"
                class="font-media-link">
                    View all
            </a>
        </div>
    </div>
</div>