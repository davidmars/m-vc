<?php
    /* @var $subCatMedia VV_subCatMedia */
    $subCatMedia = $_vars;

    /* @var $vv VV_layout */
    $vv = new VV_layout();


    $isAll = false;

    // if it's all media to show
    if (!$subCatMedia->currentIndex) {
        $isAll = true;
    }
?>

<!-- récupération de tous les médias -->
<?foreach ($subCatMedia->subCategoryMedia->medias as $m):?>
    <div class="span2 item-media-data"
         data-model-type="M_media"
         data-model-id="<?=$m->id?>"
         data-model-refresh-controller="<?=C_press::mediaAll($subCatMedia->currentCategoryId, true)?>"
         data-model-refresh-target-selector="#mainContent"
    >
        <div class="noGutter">
            <!-- Save of the Contact-->
            <?if($vv->isAdmin() && $isAll):?>
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
                        <?=$vv->isAdmin()&& $isAll?"contenteditable='true' ":""?>
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
<?endforeach;?>