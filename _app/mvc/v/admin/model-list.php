<?php
/* @var $this View */
/* @var $vv VV_admin_model_list */
$vv=$_vars;
?>
<?$this->inside("admin/layout/admin-layout")?>
<div class="container">
    
    <div class="row">
        <div class="span4">
            <div class="">
                <div class="affix" data-spy="affix" data-offset-top="0">
                    <?=$this->render("admin/layout/menu-models", $vv)?>
                </div>
                &nbsp;
            </div>
        </div>
        
        <div class="span8">
	    

	    <div class="well">
		<h1><?=$vv->modelType?></h1>
		<p><?$rc=new ReflectionClass($vv->modelType);
			echo CodeComments::getDescription($rc->getDocComment())?></p>
	    </div>

	    
	    
	    <h2>New <?=$vv->modelType?></h2>
	    <?=$this->render("admin/model-form",$vv->emptyModel)?>
	    
            <div class="well">
                <h1>This is a list of : <?=$vv->modelType?></h1>
            </div>
            
            <?foreach($vv->models as $m):?>
                <?=$this->render("admin/model-form", $m)?>
            <?endforeach?>
        </div>

    </div>
</div>
   
