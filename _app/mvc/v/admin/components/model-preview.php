<?php
/* @var $this View */
/* @var $vv VV_admin_model */
$vv=$_vars;
?>
<div class="model-preview well">
    <div>
        <span class="model-name"><?=$vv->modelType?> / <?=$vv->model->humanName()?></span>
        <?=$this->render("admin/components/btn/model-save")?>
    </div>
     
    <div class="labels">
        <div class="labeled-property">
            <label>Created</label>   
            <div><?=$vv->model->created->val()?></div>   
        </div>
        <div class="labeled-property">
            <label>Last update</label>   
            <div><?=$vv->model->modified->val()?></div>   
        </div>
        <div class="labeled-property">
            <label>Identifier</label>   
            <div><?=$vv->model->id?></div>   
        </div>
    </div>
    <hr/>
</div>