<?
/* @var $this View */
/* @var $vv VV_admin_field */
/* @var $field EnumField */
$vv=$_vars;
$field=$vv->field;
?>
<div class="span4">
    <div class="control-group"
         data-field="root[<?=$vv->name?>]"
         data-field-type="SelectBox">
	<label class="control-label"><?=$vv->label?></label>
	<div class="controls">
	    <select class="span3" <?=$vv->editable?"":"disabled"?> >
		<?foreach($field->options[EnumField::STATES] as $state):?>
		    <option value="<?=$state?>" <?=$vv->value==$state?"selected":""?>><?=$state?></option>
		<?endforeach?>
	    </select>
	    <span class="help-block"><?=$vv->comments?></span>
	</div>
    </div>
</div>