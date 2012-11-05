<?php
/* @var $vv VV_block */
$vv = $_vars;
/* @var $media M_media */
$media=$vv->block->getContent();
?>
 <div class="downloadFileComponent "
         data-model-type="M_block"
         data-model-id="<?=$vv->block->id?>">
    <div class="span8 block-post">

        <?if($vv->isAdmin()):?>
        <div class="wysiwyg-menu ">
            <div class="top-right">
                <span>Download</span>
                <a class=""
                   href="#Model.delete">
                    <i class="icon-remove icon-white"></i>
                </a>


                <a class=""
                   href="#Model.previousPosition()"
                   data-model-target-type="M_post"
                   data-model-target-id="<?=$vv->parentModel->id?>"
                   data-model-target-field="blocks">
                    <i class="icon-circle-arrow-up icon-white"></i>
                </a>

                <a class=""
                   href="#Model.nextPosition()"
                   data-model-target-type="M_post"
                   data-model-target-id="<?=$vv->parentModel->id?>"
                   data-model-target-field="blocks">
                    <i class="icon-circle-arrow-down icon-white"></i>
                </a>
            </div>
        </div>
        <?endif?>


        <div class="padded">
            <div class="item-file">                                
                <div class="icon-preview-mime" data-mime="<?=$media->theFile->mime()?>"></div>
                <?/*img src="<?= GiveMe::url("pub/app/press/img/icon_pdf.jpg") ?>" alt="" */?>
                <img src="<?= GiveMe::imageSized($media->autoIcon(),56,56,"000000","jpg") ?>" alt="" />


                <div class="item-file-content">


                    <?/*------------------title-------------*/?>

                    <div class="" data-field="root[title]" data-field-type="Text">
                        <div class="item-file-name">
                            <span
                                <?//editable ?>
                                <?=$vv->isAdmin()?"contenteditable='true' ":""?>
                                <?// no text formatting allowed here */?>
                                    data-remove-format="true">
                                <?=$media->title?>
                            </span>
                        </div>
                    </div>



                    <?/*------------------dwd / upload-------------*/?>



                    <div class="item-file-download">
                        <?if($vv->isAdmin() ||
                            $media->theFile->exists() ||
                            $media->theFileHd->exists()):?>
                            <div class="button" data-popinloder="<?=C_press::mediaPreview($media->id,true)?>">
                                <i class="icon-download"></i> Download
                            </div>
                        <?endif?>
                    </div>






                </div>                                
                <div class="clearfix"></div>                                
            </div>
            <div class="separatorTextBloc"></div>
        </div>
    </div>                    
</div>