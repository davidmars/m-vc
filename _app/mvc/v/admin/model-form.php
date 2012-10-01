<?php
/* @var $this View */
/* @var $vv VV_admin_model */
$vv=$_vars;
?>

<h3>Model type : <?=$vv->modelType?></h3>
<div class="row">
    <div class="form" data-model-id="<?=$vv->model->id?>" data-model-type="<?=get_class($vv->model)?>">  
	
	<?
	/* @var $field VV_admin_field */
	foreach($vv->fields as $field):?>
		<?=$this->render("admin/fields/fieldSwitcher",$field)?>
	<? endforeach; ?>


	
	<div class="span8 ">
	<a href="#Model.save" class="btn pull-right">save</a>
	</div>
	
    </div>
</div>
<hr/>
