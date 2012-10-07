<?
/* @var $this View */
/* @var $vv VV_admin_field */
$vv=$_vars;
?>
<div class="span4">
    <div class="control-group" data-field-type="Date" data-field="root[<?=$vv->name?>]">
	<label class="control-label"><?=$vv->label?></label>
	<div class="controls">
	    <input class="span3 date-picker" 
                   type="text" 
                   value="<?=$vv->value->format("d/m/Y")?>" 
                   <?=$vv->editable?"":"disabled"?> >
            </input>
	</div>
	<span class="help-block"><?=$vv->comments?></span>
    </div>
</div>