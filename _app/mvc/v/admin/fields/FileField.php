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
        <?
            switch ($field->mime()) {
                case "image/png":
                    $imgUrm = GiveMe::imageSizedWithoutCrop("", 50, 50);
                break;
            }
        ?>
        <img src="" alt="mime"></img>
        
        <span class="help-block"><?=$field->fileSize()?></span>
	<span class="help-block"><?=$vv->comments?></span>
	
	
	<?if(get_class($field)=="ImageField" && $field->exists()):?>
	<?
	    /* @var $field ImageField */
	?>
	<img src="<?=$field->sizedWithoutCrop(300, 300, "ffff00", "jpg")?>"></img>
	<?endif?>
    </div>
</div>