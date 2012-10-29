<? 
    /* @var $vv VV_categoryMedia */
    $vv = $_vars;            
    
    /* @var $this View */
    $this->inside("press/layout", $vv);    
?>

<div class="posts"
    <?//the current model type?>
     data-model-type="M_category_media<"
    <?//the current model id?>
     data-model-id="<?=$vv->categoryPost->id?>"
    <?//the controller url to use to refresh after actions?>
     data-model-refresh-controller="<?=C_press::categoryPost($vv->categoryPost->id,"0",true)?>"
    <?//a jquery selector that define where to inject the data-model-refresh-controller html result?>
     data-model-refresh-target-selector="#mainContent"
    >
    <!-- Affichage de chaque preview réordonné -->
    <? foreach ($vv->subCatMedias as $subMedia):?>
        <?/* @var $subMedia M_subcategory_media */?>
        <?=$this->render("press/mediaPreview", $subMedia)?>
        <br/>
        <div class="row">
            <div class="span8">
                <div class="noGutter separatorTextBloc"></div>
            </div>
        </div>
    <? endforeach;?>
</div>

<!-- Affichage de la pagination si > a 1 page -->
<?=$this->render("press/paginationCategoryMedia", $vv)?>