<?php
/* @var $this View */
/* @var $vv VV_categoryPost */
$vv = $_vars;
?>

<br/>
<br/>


<!-- Insertion d'un composant de pagination -->
<div class="paginationComponent">

    <!-- Insertion d'un composant de titre -->
    <div class="item-title">

        <div class="span8">
            <div class="noGutter">More <?= $vv->categoryPost->title ?></div>
        </div>
    </div>

    <!-- Insertion d'un composant de contenu -->
    <div class="item-content">        
        <div class="item-pagination">
            <div class="row">
                <? for ($p = 1; $p < $vv->categoryPost->getNbPage() + 1; $p++): ?>                
                    <div class="span1 item-pagination-number <?= ($p == $vv->page) ? ("active") : ("") ?>">
                        <a href="<?= C_press::categoryPost($vv->categoryPost->id, $p, true) ?>"><?= $p ?></a>
                    </div>
                    <? /* if($p != $vv->page):?>                        
                      <div class="span1 item-separator">&nbsp;</div>
                      <?endif; */ ?>
                <? endfor; ?>
            </div>
        </div>
    </div>
</div>    