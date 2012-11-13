<?php
/* @var $this View */
/* @var $vv VV_categoryPost */
$vv = $_vars;
?>

<div class="paginationComponent mt1">
    <div class="row">
        <div class="span8">
            <div class="marged">
                <!-- Insertion d'un composant de titre -->
                <div class="item-title">More <?=$vv->categoryPost->title?></div>
            </div>
        </div>
    </div>
    <div class="row">
                <!-- Insertion d'un composant de contenu -->
        <div class="span8 item-content">
            <div class="marged">
                <div class="item-pagination">
                    <div class="row">
                        <? foreach($vv->pages as $page):?>
                            <div class="span1 item-pagination-number <?= ($page->isCurrent) ? ("active") : ("") ?>">
                                <div class="marged">
                                    <a
                                        href="<?=$page->href?>"
                                        data-nav-is-ajax="true"
                                        data-nav-is-ajax-target="mainContent">
                                        <?= $page->name ?>

                                    </a>
                                </div>
                            </div>
                        <? endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
