<?php
    /* @var $this View */
    /* @var $vv VV_categoryPost */
    $vv = $_vars;   
?>

<br/>
<div class="row">
    <div class="span8">
        
        <!-- Insertion d'un composant de pagination -->
        <div class="paginationComponent">
            
            <!-- Insertion d'un composant de titre -->
            <div class="item-title">
                <div>More <?=$vv->categoryPost->title?></div>
            </div>
            
            <!-- Insertion d'un composant de contenu -->
            <div class="item-content">        
                <div class="item-pagination">
                    <div class="row">
                    <?for($p = 1; $p < $vv->categoryMedia->getNbPage() + 1; $p++):?>                
                        <div class="span1 item-pagination-number <?=($p == $vv->page)?("active"):("")?>">
                            <a href="<?=C_press::categoryMedia($vv->categoryMedia->id, $p)->url()?>"><?=$p?></a>
                        </div>
                        <?/* if($p != $vv->page):?>                        
                            <!--<div class="span1 item-separator">&nbsp;</div>                -->
                        <?endif;*/?>
                    <?endfor;?>
                    </div>
                </div>
            </div>
        </div>
        
        
    </div>
</div>    