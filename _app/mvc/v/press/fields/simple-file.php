<?
/* @var $this View */
/* @var $vv VV_admin_field */
$vv = $_vars;
/* @var $field FileField */
$field=$vv->field;
?>
<div class="file-popin-left"
     data-field-type="File"
     data-field="root[<?=$vv->name?>]"
     data-template="press/fields/simple-file">

    <div class="wysiwyg ">
        <div class="item-media-link">
            <div class="progressContainer">  
                    <span class="btn-input-file">
                            <input type="file" /><i class="icon-upload"></i>
                    </span>                    
            </div>
        </div>


        <input class="span2"
               placeholder="select a file"
               type="text"
               value="<?=$vv->value?>"
        >
        <div class="progress progress-striped">                                                
            <div class="bar" style="width: 0%;"></div>
        </div>
        

    </div>
</div>