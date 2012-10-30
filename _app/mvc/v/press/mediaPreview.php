<? 
    /* @var $vv VV_subCatMedia */
    $vv = $_vars;
?>


<!-- sub category media -->
<div class="mediaPreviewComponent">

    <div class="row">
            <div class=span8>

                <?if($vv->isAdmin()):?>
                    <div class=wysiwyg-menu>
                        <div class="top-right">
                            <a class="btn btn-danger btn-small" href="#Model.delete"><i class="icon-remove icon-white"></i></a>
                            <a class="btn btn-success btn-small" href="#Model.save"><i class="icon-ok icon-white"></i></a>
                        </div>
                    </div>
                <?endif?>

                <div class="item-media-section">
                    <div class="row">
                        <?=$vv->subCategoryMedia->title?>
                    </div>
                </div>



                <?=$this->render("press/media", $vv)?>


                <div class="pull-right">
                    <a
                        href="<?=C_press::subCatMedia($vv->subCategoryMedia->id, "Page", 1, "all", true)?>"
                        data-nav-is-ajax-target="mainContent"
                        data-nav-is-ajax="true"
                        rel="nofollow"
                        class="font-media-link">
                            View all
                    </a>
                </div>


            </div>
    </div>
</div>