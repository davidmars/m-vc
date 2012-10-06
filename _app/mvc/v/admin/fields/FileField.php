<?
/* @var $this View */
/* @var $vv VV_admin_field */
$vv=$_vars;
/* @var $field FileField */
$field=$vv->field;
?>
<div class="span4">
    <div class="control-group <?= ($field->exists() || !$field->val()) ?"":"error"?>" data-field-type="File" data-field="root[<?=$vv->name?>]">
	<label class="control-label"><?=$vv->name?> : <?=$vv->type?></label>
	<div class="controls input-append">
	    <input class="span2" placeholder="select a file"
                   type="text" 
                   value="<?=$vv->value?>"
                   <?=$vv->editable?"":"disabled"?> 
                   ></input><span class="add-on btn-input-file btn">
                        <input type="file" name="image_file" id="image_file" /><i class="icon-upload"></i> 
                        </span><a href="#Fields.File.pick" class="add-on btn"><i class="icon-folder-open"></i></a>
	</div>
	<span class="help-block"><?=$field->mime()?></span>
        <span class="help-block"><?=$field->fileSize()?></span>
	<span class="help-block"><?=$vv->comments?></span>
    </div>
</div>