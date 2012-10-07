<?
/* @var $this View */
/* @var $vv VV_admin_field */
$vv=$_vars;
?>
<div class="span<?=$vv->span?>" data-auto-height-textareas='true'>
    <div class="control-group" 
	 data-field-type="Text" 
	 data-field="root[<?=$vv->name?>]">
	<label class="control-label"><?=$vv->label?></label>
	<div class="controls">
	    <textarea class="span<?=$vv->span?>" <?=$vv->editable?"":"disabled"?>><?=$vv->value?></textarea>
	</div>
	<span class="help-block"><?=$vv->comments?></span>
    </div>
</div>