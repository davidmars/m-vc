<?
/* @var $this View */
/* @var $vv VV_admin_field */
/* @var $field NtoNAssoc */
/* @var $m M_ */
$vv=$_vars;
$field=$vv->field;


$associatedModelClass=$field->options[OnetoOneAssoc::TO];
$manager=  Manager::getManager($associatedModelClass);
$total=$manager->select()->count();

?>
<div class="span4">
    <div class="control-group" 
         data-field="root[<?=$field->name?>]" 
         data-field-type="Assoc"
         data-childs-types="<?=$field->options[NtoNAssoc::TO]?>"
         >
	<label class="control-label"><?=$vv->label?></label>
	<div class="controlzzzzzzzzzzzzzzzzzzzzzzzzzzzzzz">
        <table class="table">
            <?foreach($field as $m):?>
                <tr data-model-type="<?=$m->modelName?>"
                     data-model-id="<?=$m->id?>">

                     <td><i class="icon-file"></i></td>
                     <td><?=$m->id?>/<?=$m->humanName()?></td>

                     <td><a href="#Assoc.move" data-move="before"><i class="icon-arrow-up"></i></a></td>
                     <td><a href="#Assoc.move" data-move="after"><i class="icon-arrow-down"></i></a></td>

                    <td><a href="#Model.removeDOM"><i class="icon-remove"></i></a></td>

                </tr>
            <?endforeach?>
        </table>


	    <span class="help-block"><?=$vv->comments?></span>
	</div>
    </div>
</div>