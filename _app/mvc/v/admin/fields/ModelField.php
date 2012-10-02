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
if($associatedModel){
    
}else{
    
}
?>
<div class="span4">
    <div class="control-group" data-field="root[<?=$field->name?>]" data-field-type="ModelSelect">
	<label class="control-label"><?=$vv->name?> : <?=$vv->type?></label>
	<div class="controls">
	    current value : <?=$vv->value->id?><br/>
	    <?if($total<20):?>
	    <select>
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