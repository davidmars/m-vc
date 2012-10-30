<?php
    /* @var $vv VV_subCatMedia */
    $vv = $_vars;
?>
<div class="row subcatMediaList">
    <!-- récupération de tous les médias -->
    <?foreach ($vv->medias as $m):?>

        <?/*-------------------one media box--------------------*/?>

        <div class="span2 item-media-data downloadBox"
             data-model-type="M_media"
             data-model-id="<?=$m->id?>"
             data-model-refresh-controller="<?=C_press::categoryMedia($vv->currentCategory->categoryMedia->id,$vv->currentCategory->currentPagination,true)?>"
             data-model-refresh-target-selector="#mainContent"
        >

            <!-- Save of the download-->
            <?if($vv->isAdmin()):?>
            <div class="wysiwyg-menu ">
                <div class="top-right">

                    <a class="btn btn-danger btn-small"
                       href="#Model.delete">
                        <i class="icon-remove icon-white"></i>
                    </a>
                    <a class="btn btn-success btn-small"
                       href="#Model.save">
                        <i class="icon-ok icon-white"></i>
                    </a>

                    <a class=" btn btn-small"
                       href="#Model.previousPosition()"
                       data-model-target-type="M_subcategory_media"
                       data-model-target-id="<?=$vv->subCategoryMedia->id?>"
                       data-model-target-field="medias">
                        <i class="icon-arrow-left"></i>
                    </a>

                    <a class=" btn btn-small"
                       href="#Model.nextPosition()"
                       data-model-target-type="M_subcategory_media"
                       data-model-target-id="<?=$vv->subCategoryMedia->id?>"
                       data-model-target-field="medias">
                        <i class="icon-arrow-right"></i>
                    </a>




                </div>
            </div>
            <?endif?>

            <div class="noGutter">

                <a
                    href=""
                    data-nav-is-ajax-target="mainContent"
                    data-nav-is-ajax="true"
                    class="thumbnail">
                        <img src="<?=$m->thumb->sizedWithoutCrop(200,200,"000000","jpg")?>" alt="<?=$m->title?>" />
                </a>
                <p><?=C_press::categoryMedia($vv->currentCategory->categoryMedia->id,$vv->currentCategory->currentPagination,true)?></p>


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
                    </div>

                </div>

             </div>

        </div>
    <?endforeach;?>
</div>
