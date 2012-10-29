<? 
    /* @var $vv VV_categoryMedia */
    $vv = $_vars;            
    
    /* @var $this View */
    $this->inside("press/layout", $vv);    
?>

<div class="posts"
    <?//the current model type?>
    data-model-type="M_category_media"
    <?//the current model id?>
    data-model-id="<?=$vv->categoryMedia->id?>"
    <?//the controller url to use to refresh after actions?>
    data-model-refresh-controller="<?=C_press::categoryMedia($vv->categoryMedia->id,"0",true)?>"
    <?//a jquery selector that define where to inject the data-model-refresh-controller html result?>
    data-model-refresh-target-selector="#mainContent"
    >

    <?if($vv->isAdmin()):?>
    <div class="row">
        <div class="span8 mb1 mt1">
            <?// create and add a post to the category?>
            <a class="pull-right btn btn-success"
                <?//the action to do?>
               href="#Model.addNewChild()"
                <?//the new model type to create?>
               data-new-type="M_subcategory_media"
                <?//the field where to add the new category_media?>
               data-new-field-target="subcategories">
                Add a category
            </a>
        </div>
    </div>
    <div class="row">
        <div class="span8">
            <div class="noGutter separatorTextBloc"></div>
        </div>
    </div>
    <?endif?>


    <!-- Affichage de chaque preview réordonné -->
    <? foreach ($vv->subCatMedias as $subMedia):?>
        <?/* @var $subMedia VV_subCatMedia */?>
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