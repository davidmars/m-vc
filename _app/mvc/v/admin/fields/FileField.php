<?
/* @var $this View */
/* @var $vv VV_admin_field */
$vv=$_vars;
/* @var $field FileField */
$field=$vv->field;
Human::log($field,"rrrrrrrrrrrrrrrrr");
?>
<div class="span4">
    <div class="control-group <?=$field->exists()?"":"error"?>" data-field-type="FileField" data-field="root[<?=$vv->name?>]">
	<label class="control-label"><?=$vv->name?> : <?=$vv->type?></label>
	<div class="controls">
	    <input class="span3 date-picker" 
                   type="text" 
                   value="<?=$field->val()?>"
                   <?=$vv->editable?"":"disabled"?> 
                   ></input>
	</div>
	<span class="help-block"><?=$vv->comments?></span>
    </div>
</div>