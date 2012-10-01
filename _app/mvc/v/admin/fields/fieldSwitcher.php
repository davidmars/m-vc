<?
/* @var $this View */
/* @var $vv VV_admin_field */
$vv=$_vars;
?>
<?switch($vv->type):
    case "BoolField": ?>
	<?=$this->render("admin/fields/BoolField",$vv)?>
    <?break;?>
    <?case "EnumField": ?>
	<?=$this->render("admin/fields/EnumField",$vv)?>
    <?break;?>


    <?case "CreatedField":?>
    <?case "ModifiedField":?>
	<?=$this->render("admin/fields/DateField",$vv)?>
    <?break;?>

    <?case "TextField":?>
    <?default:?>
	<?=$this->render("admin/fields/TextField",$vv)?>

<? endswitch;?>