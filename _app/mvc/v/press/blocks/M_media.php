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


        <div class="noGutter">
            <div class="item-file">                                
                <div class="icon-preview-mime" data-mime="<?=$media->theFile->mime()?>"></div>
                <img src="<?= GiveMe::url("pub/app/press/img/icon_pdf.jpg") ?>" alt="" />                                
                <div class="item-file-content">
                    <div class="item-file-name">
                        <?=$media->title?>
                    </div>
                    <div class="item-file-download">
                        <a href="<?=$media->theFile->download()?>">
                            <i class="icon-download"></i>
                            Télécharger
                        </a>
                    </div> 
                </div>                                
                <div class="clearfix"></div>                                
            </div>
            <div class="separatorTextBloc"></div>
        </div>
    </div>                    
</div>