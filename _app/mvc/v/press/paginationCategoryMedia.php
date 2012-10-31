<?php
    /* @var $this View */
    /* @var $vv VV_categoryMedia */
    $vv = $_vars;   
?>

<br/>
<br/>

<div class="paginationComponent">
    <div class="row">
        <div class="span8">
            <div class="noGutter">
                <!-- Insertion d'un composant de titre -->
                <div class="item-title">More Downloads</div>
            </div>
        </div>
    </div>
    <div class="row">
                <!-- Insertion d'un composant de contenu -->
        <div class="span8 item-content">
            <div class="noGutter">
                <div class="item-pagination">
                    <div class="row">
                        <? foreach($vv->pages as $page):?>
                            <div class="span1 item-pagination-number <?= ($page->isCurrent) ? ("active") : ("") ?>">
                                <div class="noGutter">
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