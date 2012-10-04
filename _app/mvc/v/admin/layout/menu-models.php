<?php
/* @var $this View */
/* @var $vv VV_admin_model_list */
$vv=$_vars;
?>
<div class="row">
    <div class="span3">
        <ul class="nav nav-list "  >
        <?foreach(M_::$allNames as $modelName):?>
            <li class="<?=$modelName==$vv->modelType?"active":""?> ">
                <a href="<?=GiveMe::url("admin/admin_model/listModels/".$modelName)?> ">
                    <?=$modelName?> (<?
                    $m=new $modelName();
                    echo $m->qTotal();?>)
                </a>
            </li>
        <?endforeach;?>
        </ul>
    </div>
</div>