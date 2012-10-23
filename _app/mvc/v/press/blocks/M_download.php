<?php
    /* @var $vv M_download */
    $vv = $_vars;
?>
 <div class="downloadFileComponent">
    <div class="span8">
        <div class="noGutter">
            <div class="item-file">                                
                <div class="icon-preview-mime" data-mime="<?=$vv->theFile->mime()?>"></div>
                <img src="<?= GiveMe::url("pub/app/press/img/icon_pdf.jpg") ?>" alt="" />                                
                <div class="item-file-content">
                    <div class="item-file-name">
                        <?=$vv->title?>
                    </div>
                    <div class="item-file-download">
                        <a href="<?=$vv->theFile->download()?>">
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