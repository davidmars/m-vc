<?
    /* @var $vv VV_download */
    $vv = $_vars;
?>

<div class="downloadComponent"
    <?//the current model type?>
     data-model-type="M_download"
    <?//the current model id?>
     data-model-id="<?=$vv->id?>"
    <?//the controller url to use to refresh after actions?>
     data-model-refresh-controller="<?=C_press::sideBar(true)?>"
    <?//a jquery selector that define where to inject the data-model-refresh-controller html result?>
     data-model-refresh-target-selector="#sideBar"
    <?//prevent for url browser address change?>
     data-model-refresh-controller-not-an-url="true"
        >
    <div class="item-title">
        Download
    </div>

    <div class="row">
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
        </div>
    </div>


    <?/*<a href="<?=$vv->download->theFile->download()?>" class="item-content">

        <?//<img src="<?= GiveMe::url($vv->thumb)?" alt="press pack"  />?>

    </a>
    */?>
</div>