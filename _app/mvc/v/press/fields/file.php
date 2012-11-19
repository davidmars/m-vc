<?
/* @var $this View */
/* @var $vv VV_admin_field */
$vv = $_vars;
/* @var $field FileField */
$field=$vv->field;
?>
<div class="file-popin"
     data-field-type="File"
     data-field="root[<?=$vv->name?>]"
     data-template="press/fields/file">

    <div class="wysiwyg ">


        <div class="item-media-link">


            <div class="progressContainer">                                
                <a class="button"
                   <?
                    if($field->exists()){
                       $help=$field->fileName()." / ".$field->fileSize();
                    }else{
                       $help="Click on the arrow icon to upload a file here";
                    }
                   ?>
                   title="<?=$help?>"

                   href="<?=$field->download()?>">
                    <i class="icon-download"></i>
                    <?
                    switch($field->name){

                        case "theFileHd":
                            if(!$field->exists()){
                                $label="Download HD empty";
                            }else{
                                $label="Download HD";
                            }
                            break;
                        default:
                            if(!$field->exists()){
                                $label="Download LD empty";
                            }else{
                                $label="Download LD";
                            }
                    }

                    ?>
                    <?=$label?>
                    <div class="progress progress-striped">
                        <div class="bar" style="width: 0%;"></div>
                    </div>

                </a>                    
                    <span class="btn-input-file">
                        <input type="file"/><i class="icon-upload"></i>
                    </span>
                    <?if($field->exists()):?>
                        <br/>
                        <span class="btn-input-file">
                        <a href="#Fields.File.delete"><i class="icon-remove-sign"></i></a>
                        </span>
                    <?endif;?>
            </div>


        </div>


        <input class="span2"
               placeholder="select a file"
               type="text"
               value="<?=$vv->value?>">


    </div>
</div>