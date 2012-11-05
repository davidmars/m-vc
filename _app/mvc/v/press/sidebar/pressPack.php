<?
    /* @var $vv VV_media */
    $vv = $_vars;
?>

<div class="downloadComponent"
    <?//the current model type?>
     data-model-type="M_media"
    <?//the current model id?>
     data-model-id="<?=$vv->media->id?>"
        >
    <div class="item-title">
        Download
    </div>

    <div class="row">
        <?if(!$vv->isAdmin()):?>
        <a href="<?=$vv->media->theFile->download()?>" class="">
        <?endif;?>
            <div class="span1 item-logo-thumbnail">            
                <?=$this->render("press/fields/download-image",$vv->thumbAdminField())?>
            </div>
            <div class="span3 item-download-text">
                <div>
                    <table>
                        <tr>
                            <td><i class="sprite-item-titleIcon"></i></td>
                            <td><span class="item-titleIcon">Download</span></td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td><span class="item-subtitle">Press pack</span></td>
                        </tr>
                    </table>

                </div>
                <?if($vv->isAdmin()):?>
                    <div class="the-upload">
                    <?=$this->render("press/fields/simple-file",$vv->theFileAdminField())?>
                    </div>
                <?endif;?>
            </div>
        <?if(!$vv->isAdmin()):?>
        </a>
        <?endif;?>
    </div>


    <?/*<a href="<?=$vv->download->theFile->download()?>" class="item-content">

        <?//<img src="<?= GiveMe::url($vv->thumb)?" alt="press pack"  />?>

    </a>
    */?>
</div>