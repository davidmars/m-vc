<?
/* @var $this View */
/* @var $vv VV_admin_field */
$vv=$_vars;
/* @var $field FileField */
$field=$vv->field;
?>
<div class="span4"
     data-field-type="File" 
     data-field="root[<?=$vv->name?>]"
     data-template="admin/fields/FileField">
    <div class="field-upload control-group <?= ($field->exists() || !$field->val()) ?"":"error"?>" >
	<label class="control-label"><?=$vv->label?></label>
	<div class="controls input-append">

	    <input class="span2" placeholder="select a file"
                   type="text" 
                   value="<?=$vv->value?>"
                   <?=$vv->editable?"":"disabled"?> 
                   ></input><span class="add-on btn-input-file btn">
            <input type="file" name="image_file" id="image_file" /><i class="icon-upload"></i> 
            </span><a href="#Fields.File.pick" class="add-on btn"><i class="icon-folder-open"></i></a>
            
            <div class="row">
                <div class="span2 progress progress-striped">
                    <div class="bar" style="width: 1%;"></div>
                </div>
            </div>
            
	</div>
	<span class="help-block"><?=$field->mime()?></span>
        <span class="help-block"><?=$field->fileSize()?></span>
	<span class="help-block"><?=$vv->comments?></span>
	
	<?=  get_class($field)?>
	
	<?if(get_class($field)=="ImageField" && $field->exists()):?>
	<img src="<?=GiveMe::imageSized($field, "300", "300")?>"></img>
	<img src="<?=GiveMe::url($field)?>"></img>
	<?endif?>
    </div>
</div>