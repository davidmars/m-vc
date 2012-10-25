<? 
    /* @var $vv VV_categoryMedia */
    $vv = $_vars;            
    
    /* @var $this View */
    $this->inside("press/layout", $vv);    
?>

<div class="posts">
    <!-- Affichage de chaque preview réordonné -->
    <?foreach ($vv->subCatMedias as $subMedia):?>
        <?/* @var $subMedia M_subcategory_media */?>
        <br/>
        <?=$this->render("press/mediaPreview", $subMedia)?>
        <br/>
        <div class="row">
            <div class="span8">
                <div class="noGutter separatorTextBloc"></div>
            </div>
        </div>
    <?endforeach;?>
</div>

<!-- Affichage de la pagination si > a 1 page -->
<?=$this->render("press/paginationCategoryMedia", $vv)?>