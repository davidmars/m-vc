<?php
/* @var $vv VV_block */
$vv = $_vars;
/* @var $media M_media */
$media=$vv->block->getContent();
?>
 <div class="downloadFileComponent">
    <div class="span8">
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