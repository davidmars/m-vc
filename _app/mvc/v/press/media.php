<?php
/**
 * Created by JetBrains PhpStorm.
 * User: francoisrai
 * Date: 29/10/12
 * Time: 20:03
 * To change this template use File | Settings | File Templates.
 */

/* @var $vv VV_subCatMedia */
$vv = $_vars;
?>


<? // first a display the for first media ?>
<?=$this->render("press/subCatMediaList", $vv)?>

<? /*
<? if($vv->nextToLoad): ?>
    <div class="mediaPreviewComponent" data-nav-ajax-autoload="<?=C_press::subCatMedia($vv->subCategoryMedia, "page", 0, 4, true )?>"></div>
<?endif?>
 */
 ?>
