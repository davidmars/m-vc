<?php
/* @var $this View */
/* @var $vv VV_admin_model */
$vv=$_vars;
?>


<div class="row" data-model-id="<?=$vv->model->id?>" data-model-type="<?=get_class($vv->model)?>" data-model-template="<?=$this->path?>">
    <div class="form">  
        <div class="span8">
            <h3>Model type : <?=$vv->modelType?></h3>
        </div>
        
	<?
	/* @var $field VV_admin_field */
	foreach($vv->fields as $field):?>
		<?=$this->render("admin/fields/fieldSwitcher",$field)?>
	<? endforeach; ?>

	<div class="span8 ">
            <a href="#Model.save" class="btn pull-right">save</a>
	</div>
	
    </div>
    <hr/>
</div>

