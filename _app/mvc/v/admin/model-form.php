<?php
/* @var $this View */
/* @var $vv VV_admin_model */
$vv=$_vars;
?>
<h3>Model type : <?=$vv->modelType?></h3>
<div class="row">
<?
/* @var $field VV_admin_field */
foreach($vv->fields as $field):?>
    <div class="span4">
        <h5><?=$field->name?> : <?=$field->type?></h5>
        <textarea><?=$field->value?></textarea>
    </div>
<? endforeach; ?>


</div>
<hr/>
