<?php
    /* @var $this View */
    /* @var $vv VV_subCatMedia */
    $vv = $_vars;
?>
<div class="row subcatMediaList">
    <!-- récupération de tous les médias -->
    <? if($vv->medias):?>
    <?foreach ($vv->medias as $m):?>

        <?/*-------------------one media box--------------------*/?>

        <div class="span2 item-media-data downloadBox <?=$m->isAdmin()?"is-admin":""?>"
             data-model-type="M_media"
             data-model-id="<?=$m->media->id?>"
        >

            <!-- Save of the download-->
            <?if($m->isAdmin()):?>
            <div class="wysiwyg-menu ">
                <div class="top-right">

                    <a class=""
                       href="#Model.delete">
                        <i class="icon-remove icon-white"></i>
                    </a>
                    <a class=""
                       href="#Model.save">
                        <i class="icon-ok icon-white"></i>
                    </a>

                    <a class=""
                       href="#Model.previousPosition()"
                       data-model-target-type="M_subcategory_media"
                       data-model-target-id="<?=$vv->subCategoryMedia->id?>"
                       data-model-target-field="medias">
                        <i class="icon-circle-arrow-left icon-white"></i>
                    </a>

                    <a class=""
                       href="#Model.nextPosition()"
                       data-model-target-type="M_subcategory_media"
                       data-model-target-id="<?=$vv->subCategoryMedia->id?>"
                       data-model-target-field="medias">
                        <i class="icon-circle-arrow-right icon-white"></i>
                    </a>




                </div>
            </div>
            <?endif?>

            <div class="noGutter">


                <?=$this->render("press/fields/media-image",$m->thumbAdminField())?>


                <div class="item-media-content">

                    <div class="item-media-name"
                         data-field="root[title]"
                         data-field-type="Text">
                        <span
                            <?//editable ?>
                            <?=$m->isAdmin()?"contenteditable='true' ":""?>
                            <?// no text formatting allowed here */?>
                                data-remove-format="true"><?=$m->media->title?></span>
                    </div>




                    <?if($m->isAdmin()):?>

                        <?/*-----------------upload btn-------------------*/?>
                        <?=$this->render("press/fields/file",$m->theFileAdminField())?>
                        <?=$this->render("press/fields/file",$m->theFileHdAdminField())?>
                    <?else:?>

                    <?/*-----------------downloads btn-------------------*/?>


                        <div class="item-media-link">
                            <?if($m->media->theFile->exists()):?>
                            <a class="button" href="<?=$m->media->theFile->download()?>">
                                <i class="icon-download"></i> Download
                            </a>
                            <?endif?>
                            <?if($m->media->theFileHd->exists()):?>
                            <a class="button" href="<?=$m->media->theFileHd->download()?>">
                                <i class="icon-download"></i> Download HD
                            </a>
                            <?endif?>
                        </div>




                    <?endif?>

                </div>

             </div>

        </div>
    <?endforeach;?>
    <?endif;?>
</div>
