<?php
/* @var $this View */
/* @var $vv VV_admin_model_list */
$vv=$this->viewVariables;
?>
<?$this->inside("doc/layout/html5bp")?>
<div class="container">
    
    <div class="row">
        
        <div class="span4">
            Here we will list all the models types.
        </div>
        
        <div class="span8">
            <div class="well">
                <h1>This is a list of : <?=$vv->modelType?></h1>
            </div>
            
            <?foreach($vv->models as $m):?>
                <?=$this->render("admin/model-form", $m)?>
            <?endforeach?>
        </div>

    </div>
</div>
