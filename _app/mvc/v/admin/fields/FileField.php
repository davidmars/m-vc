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
	
        <?        
            $mime = $field->mime();
                        
            if (preg_match("/image/", $mime, $matches)) {
                $typeFile = $matches[0];
            }
            else if (preg_match("/pdf/", $mime, $matches)) {
                $typeFile = $matches[0];
            }
            else if (preg_match("/illustrator/", $mime, $matches)) {
                $typeFile = $matches[0];
            }
            else if (preg_match("/text/", $mime, $matches)) {
                $typeFile = $matches[0];
            }
            else {
                $typeFile = "other";
            }           
        
            switch ($typeFile) {
                case "image":
                    $imgUrl = GiveMe::imageSizedWithoutCrop($field->get(), 55, 54);
                break;
            
                case "pdf":
                    $imgUrl = GiveMe::url("/pub/app/admin/img/icon_pdf.jpg");
                break;
            
                case "illustator":
                    $imgUrl = GiveMe::url("/pub/app/admin/img/icon_illustrator.jpg");
                break;
                
                case "text":
                    $imgUrl = GiveMe::url("/pub/app/admin/img/icon_font.jpg");
                break;
            }
        ?>
        <?if(get_class($field)=="FileField" && $field->exists()):?>
            <img src="<?=$imgUrl?>" alt="mime"></img>
        <?endif?>
        
        <span class="help-block"><?=$field->mime()?></span>
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