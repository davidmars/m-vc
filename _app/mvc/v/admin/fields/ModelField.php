<?
/* @var $this View */
/* @var $vv VV_admin_field */
/* @var $field OnetoOneAssoc */
$vv=$_vars;
$field=$vv->field;
/* @var $associatedModel M_ */
$associatedModel=$vv->value;

$associatedModelClass=$field->options[OnetoOneAssoc::TO];
$manager=  Manager::getManager($associatedModelClass);
$total=$manager->select()->count();

?>
<div class="span4">
    <div class="control-group" 
         data-field="root[<?=$field->name?>]" 
         data-field-type="ModelSelect">
	<label class="control-label"><?=$vv->label?></label>
	<div class="controls">
	    <?if($total<20):?>
	    <select class="span3" <?=$vv->editable?"":"disabled"?> >
		<?foreach($manager->select()->all() as $m):?>
		    <option value="<?=$m->id?>" <?=$vv->value->id==$m->id?"selected":""?>><?=$m->humanName()?></option>
		<?endforeach?>
	    </select>
	    <?else:?>
	    to many records a popin will be better!
	    <?endif?>
	    <span class="help-block"><?=$vv->comments?></span>
	</div>
    </div>
</div>