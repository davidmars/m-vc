<?
/* @var $this View */
/* @var $vv VV_admin_field */
/* @var $field EnumField */
$vv=$_vars;
$field=$vv->field;
?>
<div class="span4">
    <div class="control-group">
	<label class="control-label"><?=$vv->name?> : <?=$vv->type?></label>
	<div class="controls">
	    <select>
		<?foreach($field->options[EnumField::STATES] as $state):?>
		    <option value="<?=$state?>" <?=$vv->value==$state?"selected":""?>><?=$state?></option>
		<?endforeach?>
	    </select>
	    <span class="help-block"><?=$vv->comments?></span>
	</div>
    </div>
</div>