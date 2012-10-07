<?
/* @var $this View */
/* @var $vv VV_admin_field */
$vv=$_vars;
?>
<div class="span4">
    <div class="control-group">
	<label class="control-label"><?=$vv->label?></label>
	<div class="controls">
	    <?=$vv->value?>
	</div>
	<span class="help-block"><?=$vv->comments?></span>
    </div>
</div>