<?
/* @var $this View */
/* @var $vv VV_admin_field */
$vv=$_vars;
?>
<div class="span4" data-auto-height-textareas='true'>
    <div class="control-group" 
	 data-field-type="Text" 
	 data-field="root[<?=$vv->name?>]">
	<label class="control-label"><?=$vv->name?> : <?=$vv->type?></label>
	<div class="controls">
	    <textarea class="span3" <?=$vv->editable?"":"disabled"?>><?=$vv->value?></textarea>
	</div>
	<span class="help-block"><?=$vv->comments?></span>
    </div>
</div>