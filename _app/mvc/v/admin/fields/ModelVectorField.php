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
<div class="span8">
    <div class="control-group" 
         data-field="root[<?=$field->name?>]" 
         data-field-type="Assoc"
         data-childs-types="<?=$field->options[NtoNAssoc::TO]?>"
         >
	<label class="control-label">
        <?=$vv->label?>
    </label>
	<div class="controlzzzzzzzzzzzzzzzzzzzzzzzzzzzzzz">
        <table class="table">
            <thead>
            <tr>

                <td colspan="5" style="text-align: right;">
                    <a class="btn btn-small"
                       href="#Fields.Assoc.addItem">
                        <i class="icon-plus-sign"></i> Add a <?=$associatedModelClass?>
                    </a>
                </td>
            </tr>
            </thead>
            <tbody data-assoc-children-container="true">
                <?foreach($field as $m):?>
                <?=$this->render("admin/models/tr-sortable",$m);?>
                <?endforeach?>
            </tbody>


        </table>


	    <span class="help-block"><?=$vv->comments?></span>
	</div>
    </div>
</div>