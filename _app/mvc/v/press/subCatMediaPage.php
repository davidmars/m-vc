<?
    /* @var $vv VV_subCatMedia */
    $vv = $_vars;

    /* @var $this View */
    $this->inside("press/layout", $vv);
?>


<div class="posts"
    <!-- sub category media -->
    <div class="mediaPreviewComponent">
        <div class="item-media-section">
            <?=$vv->subCategoryMedia->title?>
        </div>
    </div>

    <div class="row">

        <!-- récupération de tous les médias -->
        <?foreach ($vv->medias as $m):?>
        <div class="mediaPreviewComponent">
            <div class="span2 item-media-data"
                 data-model-type="M_media"
                 data-model-id="<?=$m->id?>"
                 data-model-refresh-controller="<?=C_press::subCatMedia($vv->subCategoryMedia, $vv->template, $vv->start, $vv->nbItem, true)?>"
                 data-model-refresh-target-selector="#mainContent"
                    >
                <div class="noGutter">
                    <!-- Save of the Contact-->
                    <?if($vv->isAdmin()):?>
                    <div class="manageData">
                        <a class="pull-right btn btn-danger btn-small" href="#Model.delete"><i class="icon-remove icon-white"></i></a>
                        <a class="pull-right btn btn-success btn-small" href="#Model.save"><i class="icon-ok icon-white"></i></a>
                    </div>
                    <?endif?>


                    <a
                            href=""
                            data-nav-is-ajax-target="mainContent"
                            data-nav-is-ajax="true"
                            class="thumbnail">
                        <img src="<?=GiveMe::url($m->thumb)?>" alt="<?=$m->title?>" />
                    </a>


                    <div data-field="root[name]"
                         data-field-type="Text">
                        <div class="item-contact-name">
                                <span
                                    <?//editable ?>
                                    <?=$vv->isAdmin()?"contenteditable='true' ":""?>
                                    <?// no text formatting allowed here */?>
                                        data-remove-format="true">
                                         <?= $contact->name ?>
                                </span>
                        </div>
                    </div>

                    <div class="item-media-content">
                        <div class="item-media-name"
                             data-field="root[title]"
                             data-field-type="Text">
                            <span
                                <?//editable ?>
                                <?=$vv->isAdmin()?"contenteditable='true' ":""?>
                                <?// no text formatting allowed here */?>
                                    data-remove-format="true">
                                     <?=$m->title?>
                            </span>
                        </div>
                        <div class="item-media-link">
                            <a class="button" href="<?=$m->theFile->download()?>">
                                <i class="icon-download"></i> Télécharger
                            </a>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?endforeach;?>

    </div>
</div>