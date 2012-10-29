<?php
    /* @var $this View */
    /* @var $vv VV_categoryMedia */
    $vv = $_vars;   
?>

<br/>
<br/>
<!-- Insertion d'un composant de pagination -->
<div class="paginationComponent">
    <div class="row">
        <div class="span8">
            <div class="noGutter">
                <!-- Insertion d'un composant de titre -->
                <div class="item-title"> More
                    <?= $vv->categoryMedia->title ?>
                </div>
                <!-- Insertion d'un composant de contenu -->
                <div class="item-content">
                    <div class="item-pagination">
                        <div class="row">
                            <div class="span8">
                                <div class="noGutter">
                                    <? foreach($vv->pages as $page):?>
                                    <div class="span1 item-pagination-number <?= ($page->isCurrent) ? ("active") : ("") ?>"> <a
                                            href="<?=$page->href?>"
                                            data-nav-is-ajax="true"
                                            data-nav-is-ajax-target="mainContent">
                                        <?= $page->name ?>
                                    </a> </div>
                                    <? endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>