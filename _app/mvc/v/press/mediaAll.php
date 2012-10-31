<?
    /* @var $vv VV_media */
    $vv = $_vars;

    /* @var $this View */
    $this->inside("press/layout", $vv);

    /* @var $media M_subcategory_media */
    $media = $vv->subCategoryMedia;

    $refresh = C_press::mediaAll($media->id, true);
?>
<div class="row">
    <div class="span8">
        <div class="posts noGutter background-content"
            <?//the current model type?>
            data-model-type="M_subcategory_media"
            <?//the current model id?>
            data-model-id="<?=$media->id?>"
            <?//the controller url to use to refresh after actions?>
            data-model-refresh-controller="<?=$refresh?>"
            <?//a jquery selector that define where to inject the data-model-refresh-controller html result?>
            data-model-refresh-target-selector="#mainContent"
            >

            <?if($vv->isAdmin()):?>
            <div class="row">
                <div class="span8 mb1 mt1">
                    <?// create and add a post to the category?>
                    <a class="pull-right btn btn-success"
                        <?//the action to do?>
                       href="#Model.addNewChild()"
                        <?//the new model type to create?>
                       data-new-type="M_media"
                        <?//the field where to add the new category_media?>
                       data-new-field-target="posts">
                        Add a media
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="span8">
                    <div class="noGutter separatorTextBloc"></div>
                </div>
            </div>
            <?endif?>

            <!-- Affichage de chaque preview réordonné -->
            <br/>
            <div class="row">
                <div class="span8">
                    <!-- sub category media -->
                    <div class="mediaPreviewComponent">
                        <div class="item-media-section">
                            <?=$media->title?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="mediaPreviewComponent" data-nav-ajax-autoload="<?=C_press::subCatMedia($media->id, "", true)?>"></div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>