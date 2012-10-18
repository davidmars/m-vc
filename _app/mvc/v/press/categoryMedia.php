<? 
    /* @var $vv VV_categoryMedia */
    $vv = $_vars;            
    
    /* @var $this View */
    $this->inside("press/layout", $vv);    
?>


<!-- Affichage de chaque preview -->
<div class="posts">
    <!-- Affichage de chaque preview -->
    <? foreach ($vv->categoryMedia->getSubCategoryMediaForPage($vv->page) as $subcategory): ?>
    <br/>
    <?=$this->render("press/mediaPreview", $subcategory)?>
    <br/>
    <div class="separatorBloc">&nbsp;</div>    
    <?endforeach;?>
</div>


<!-- Affichage de la pagination si > a 1 page -->
<?if($vv->categoryMedia->getNbPage() > 1):?>
<?=$this->render("press/paginationCategoryMedia", $vv)?>
<?endif?> 
