<?
/* @var $this View */
/* @var $vv VV_admin_field */
$vv=$_vars;
?>
<div class="span4">
    <div class="control-group" data-field-type="Text" data-field="root[<?=$vv->name?>]">
	<label class="control-label"><?=$vv->name?> : <?=$vv->type?></label>
	<div class="controls">
	    <input type="text" value="<?=$vv->value?>"></input>
	</div>
    </div>
</div>