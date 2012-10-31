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


<div class="span2 item-media-data downloadBox <?=$vv->isAdmin()?"is-admin":""?>"
     data-model-type="M_media"
     data-model-id="<?=$vv->media->id?>"
        >

    <!-- Save of the download-->
    <?if($vv->isAdmin()):?>
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

    <div class="noGutter">

        <?if($vv->isImage()):?>
            <div data-popinloder="<?=C_press::mediaPreview($vv->media->id,true)?>">
                <?=$this->render("press/fields/media-image",$vv->thumbAdminField())?>
            </div>
        <?else:?>
            <?=$this->render("press/fields/media-image",$vv->thumbAdminField())?>
        <?endif?>

        <div class="item-media-content">

            <div class="item-media-name"
                 data-field="root[title]"
                 data-field-type="Text">
                        <span
                            <?//editable ?>
                            <?=$vv->isAdmin()?"contenteditable='true' ":""?>
                            <?// no text formatting allowed here */?>
                                data-remove-format="true"><?=$vv->media->title?></span>
            </div>




            <?if($vv->isAdmin()):?>

            <?/*-----------------upload btn-------------------*/?>
            <?=$this->render("press/fields/file",$vv->theFileAdminField())?>
            <?=$this->render("press/fields/file",$vv->theFileHdAdminField())?>
            <?else:?>

            <?/*-----------------downloads btn-------------------*/?>


            <div class="item-media-link">
                <?if($vv->media->theFile->exists()):?>
                <a class="button" href="<?=$vv->media->theFile->download()?>">
                    <i class="icon-download"></i> Download.
                </a>
                <?endif?>
                <?if($vv->media->theFileHd->exists()):?>
                <a class="button" href="<?=$vv->media->theFileHd->download()?>">
                    <i class="icon-download"></i> Download HD
                </a>
                <?endif?>
            </div>




            <?endif?>

        </div>

    </div>

</div>
