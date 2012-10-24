<? 
    /* @var $vv VV_categoryMedia */
    $vv = $_vars;            
    
    /* @var $this View */
    $this->inside("press/layout", $vv);    
?>


<!-- Affichage de chaque preview -->
<div class="posts">
    <!-- Affichage de chaque preview réordonné -->
    <?foreach ($vv->categoryMedia->subcategory as $s):?>
        <?/* @var $s M_subcategory_media */?>
        <?=$this->render("press/mediaPreview", $s)?>
        <div class="row">
            <div class="span8">
                <div class="noGutter separatorBloc"></div>
            </div>
        </div>    
    <?endforeach;?>      
</div>


<!-- Affichage de la pagination si > a 1 page -->
<? /*
<?if($vv->categoryMedia->getNbPage() > 1):?>
<?=$this->render("press/paginationCategoryMedia", $vv)?>
<?endif?> 
*/ ?>