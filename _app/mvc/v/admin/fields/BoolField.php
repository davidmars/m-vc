<?
/* @var $this View */
/* @var $vv VV_admin_field */
$vv=$_vars;
?>
<div class="span4">
    <div class="control-group" data-field="root[<?=$vv->field->name?>]" data-field-type="BoolField">
	<label class="control-label"><?=$vv->label?></label>
	<div class="controls">
	    <select class="span3" <?=$vv->editable?"":"disabled"?> >
		<option value="1" <?=$vv->value?"selected":""?>>Yes</option>
		<option value="0" <?=$vv->value?"":"selected"?>>No</option>
	    </select>
	</div>
	<span class="help-block"><?=$vv->comments?></span>
    </div>
</div>