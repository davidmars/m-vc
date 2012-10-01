<?
/* @var $this View */
/* @var $vv VV_admin_field */
$vv=$_vars;
?>
<div class="span4">
    <div class="control-group">
	<label class="control-label"><?=$vv->name?> : <?=$vv->type?></label>
	<div class="controls">
	    <input type="checkbox" <?=$vv->value?"checked":""?>></input>
	</div>
    </div>
</div>