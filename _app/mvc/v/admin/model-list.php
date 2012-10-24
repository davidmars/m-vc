<?php
/* @var $this View */

/* @var $vv VV_admin_model_list */
/* @var $m VV_admin_model */
$vv=$_vars;
?>
<?$this->inside("admin/layout/model-layout")?>


	    
		<h1><?=$vv->modelType?></h1>
		<p>
                    <?
                    $rc=new ReflectionClass($vv->modelType);
                    ?>
                    <?=CodeComments::getDescription($rc->getDocComment())?>
                    <?
                    $c=new c_admin_model();
                    
                    ?>
                </p>
                

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Creation date</th>
                        <th>Last update</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?
                    $m=$vv->emptyModel;
                    ?>
                    <tr data-model-type="<?=$m->modelType?>" data-model-id="new">
                        <td><b>New <?=$m->model->humanName()?></b></td>
                        <td><?=$m->model->created->val()?></td>
                        <td><?=$m->model->modified->val()?></td>
                        <td><a class="btn btn-small btn-success" href="<?=GiveMe::url("admin/admin_model/editModel/".$m->modelType."/".$m->model->id)?>">Add</a></td>
                    </tr>  
                    <?foreach($vv->models as $m):?>
                    <tr data-model-type="<?=$m->modelType?>" data-model-id="<?=$m->model->id?>">
                        <td><b><?=$m->model->humanName()?></b></td>
                        <td><?=$m->model->created->val()?></td>
                        <td><?=$m->model->modified->val()?></td>
                        <?/*<td><a class="btn btn-small" href="<?=GiveMe::url("admin/admin_model/editModel/".$m->modelType."/".$m->model->id)?>">Edit</a></td>*/?>
                        <td>
                            <a class="btn btn-small"
                               data-model-btn-select="true"
                               href="<?=C_admin_model::editModel($m->modelType, $m->model->id)->url()?>">
                                Edit
                            </a>
                        </td>
                        
                    </tr>       
                    <?endforeach?>
                </tbody>
            </table>


   
