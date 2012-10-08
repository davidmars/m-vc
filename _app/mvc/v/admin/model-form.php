<?$this->inside("admin/layout/model-layout")?>
<?php
/* @var $this View */
/* @var $vv VV_admin_model */
$vv=$_vars;
?>


<div class="row model-form" 
     data-model-id="<?=$vv->model->id?>" 
     data-model-type="<?=get_class($vv->model)?>" 
     data-model-template="<?=$this->path?>">
    
    <div class="span8">
        <?=$this->render("admin/components/model-preview", $vv)?>
    </div>
    
    <div class="form">  
        
	<?
	/* @var $field VV_admin_field */
	foreach($vv->fields as $field):?>
		<?=$this->render("admin/fields/fieldSwitcher",$field)?>
	<? endforeach; ?>

	<div class="span8 ">
            <?=$this->render("admin/components/btn/model-save")?> 
	</div>
	
    </div>
    
    <hr/>
</div>

