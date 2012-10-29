<?php
    /* @var $subCatMedia VV_subCatMedia */
    $subCatMedia = $_vars;
?>

<!-- récupération de tous les médias -->
<?foreach ($subCatMedia->subCategoryMedia->medias as $m):?>
    <div class="span2 item-media-data">
        <div class="noGutter">
            <a
                href=""
                data-nav-is-ajax-target="mainContent"
                data-nav-is-ajax="true"
                class="thumbnail">
                    <img src="<?=GiveMe::url($m->thumb)?>" alt="<?=$m->title?>" />
            </a>

            <div class="item-media-content">
                <div class="item-media-name">
                    <a href="" data-nav-is-ajax-target="mainContent" data-nav-is-ajax="true">
                        <?=$m->title?>
                    </a>
                </div>
                <div class="item-media-link"> <a class="button" href="<?=$m->theFile->download()?>">
                    <i class="icon-download"></i> Télécharger</a>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
<?endforeach;?>