<?php
/* @var $this View */
/* @var $vv VV_admin_model_list */
$vv=$_vars;
?>
<?$this->inside("doc/layout/html5bp")?>
<div class="container">
    
    <div class="row">
        <div class="span4">
            <ul class="nav nav-list">
            <?foreach(M_::$allNames as $modelName):?>
                <li class="<?=$modelName==$vv->modelType?"active":""?> ">
                    <a href="<?=GiveMe::url("admin/admin_model/listModels/".$modelName)?> ">
                    <?=$modelName?> (<?
		    $m=new $modelName();
		    echo $m->qTotal();?>)
                    </a>
                </li>
            <?endforeach;?>
            </ul>

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
<script>
    Config.apiUrl="/admin/api/index/"
    Config.rootUrl="<?=Site::$root?>";
</script>    
