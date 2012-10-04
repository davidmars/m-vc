<?
/* @var $this View */
/* @var $vv VV_admin_field */
$vv=$_vars;
?>
<?switch($vv->type):
    case "BoolField": ?>
	<?=$this->render("admin/fields/BoolField",$vv)?>
    <?break;?>
    <?case "IdField": ?>
	<?=$this->render("admin/fields/IdField",$vv)?>
    <?break;?>

    <?case "EnumField": ?>
	<?=$this->render("admin/fields/EnumField",$vv)?>
    <?break;?>


    <?case "CreatedField":?>
    <?case "ModifiedField":?>
	<?=$this->render("admin/fields/DateTimeField",$vv)?>
    <?break;?>

    <?case "DateField":?>
        <?=$this->render("admin/fields/DateField",$vv)?>
    <?break;?>

    <?case "FileField":?>
	<?=$this->render("admin/fields/FileField",$vv)?>
    <?break;?>

    <?case "OnetoOneAssoc":?>
	<?=$this->render("admin/fields/ModelField",$vv)?>
    <?break;?>

    <?case "TextField":?>
    <?default:?>
	<?=$this->render("admin/fields/TextField",$vv)?>

<? endswitch;?>