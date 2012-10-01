<?
/* @var $this View */
/* @var $vv VV_admin_field */
$vv=$_vars;
?>
<div class="span4">
    <div class="control-group" 
	 data-field-type="Text" 
	 data-field="root[<?=$vv->name?>]">
	<label class="control-label"><?=$vv->name?> : <?=$vv->type?></label>
	<div class="controls">
	    <textarea><?=$vv->value?></textarea>
	</div>
    </div>
</div>