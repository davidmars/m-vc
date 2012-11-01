<?php
/**
 * Created by JetBrains PhpStorm.
 * User: francoisrai
 * Date: 29/10/12
 * Time: 20:03
 * To change this template use File | Settings | File Templates.
 */

/* @var $this View */
/* @var $vv VV_media */
$vv = $_vars;
?>


<div class="span2 item-media-data downloadBox  <?=$vv->isAdmin()?"is-admin":""?>"
     data-model-type="M_media"
     data-model-id="<?=$vv->media->id?>"
        >
        <div class="marged pb1">



            <!-- Save of the download-->
            <?if($vv->isAdmin()):?>
            <div class="wysiwyg-menu ">
                <div class="top-right">

                    <a class=""
                       href="#Model.delete">
                        <i class="icon-remove icon-white"></i>
                    </a>

                    <a class=""
                       href="#Model.previousPosition()"
                       data-model-target-type="M_subcategory_media"
                       data-model-target-id="<?=$vv->subCategory->id?>"
                       data-model-target-field="medias">
                        <i class="icon-circle-arrow-left icon-white"></i>
                    </a>

                    <a class=""
                       href="#Model.nextPosition()"
                       data-model-target-type="M_subcategory_media"
                       data-model-target-id="<?=$vv->subCategory->id?>"
                       data-model-target-field="medias">
                        <i class="icon-circle-arrow-right icon-white"></i>
                    </a>
                </div>
            </div>
            <?endif?>






            <div class="row">
                <div class="span2">

                    <?//------------image----------------?>
                    <div class="marged">
                        <?/*
                         *
                         * Open the pop all the time in fact...
                         *  --- admin because the edition is in the popin.
                         *  --- embed video.
                         *  --- preview photo.
                         *  --- download in any cases.
                         */?>

                            <div data-popinloder="<?=C_press::mediaPreview($vv->media->id,true)?>">
                                <?=$this->render("press/fields/media-image",$vv->thumbAdminField())?>
                            </div>

                    </div>

                    <?//-----------title---------------?>

                    <div class="item-media-name"
                         data-field="root[title]"
                         data-field-type="Text">
                        <span
                            <?//editable ?>
                            <?=$vv->isAdmin()?"contenteditable='true' ":""?>
                            <?// no text formatting allowed here */?>
                                data-remove-format="true"><?=$vv->media->title?></span>
                    </div>

                    <?//----------downloads------------?>


                    <div class="item-media-content">
                        <?/*
                        <?if($vv->isAdmin()):?>
                        -----------------upload btn-------------------
                        <?=$this->render("press/fields/file",$vv->theFileAdminField())?>
                        <?=$this->render("press/fields/file",$vv->theFileHdAdminField())?>
                        <?else:?>
                        */?>
                        <?/*-----------------downloads btn-------------------*/?>
                        <div class="item-media-link">
                            <?if($vv->media->theFile->exists() || $vv->media->theFileHd->exists()):?>
                            <div class="button" data-popinloder="<?=C_press::mediaPreview($vv->media->id,true)?>" hqqqref="<?=$vv->media->theFile->download()?>">
                                <i class="icon-download"></i> Download.
                            </div>
                            <?endif?>
                        </div>

                    </div>

                </div>
            </div>











        </div>





</div>
