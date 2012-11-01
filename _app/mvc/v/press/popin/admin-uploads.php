<?php
/* @var $this View */
/* @var $vv VV_media */
$vv = $_vars;
?>
<a class="btn btn-small btn-success"
   href="#Model.save">
    <i class="icon-white icon-ok"></i>
    Save
</a>


<?=$this->render("press/fields/file",$vv->theFileAdminField())?>
<?=$this->render("press/fields/file",$vv->theFileHdAdminField())?>