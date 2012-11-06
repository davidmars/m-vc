<? 
    /* @var $vv VV_categoryMedia */
    $vv = $_vars;            
    
    /* @var $this View */
    $this->inside("press/layout/layout", $vv);
?>

<div class="row">
    <div class="span8">
        <div class="posts padded background-content"
            <?//the current model type?>
            data-model-type="M_category_media"
            <?//the current model id?>
            data-model-id="<?=$vv->categoryMedia->id?>"
            <?//the controller url to use to refresh after actions?>
            data-model-refresh-controller="<?=C_press::categoryMedia($vv->categoryMedia->id,$vv->currentPagination,true)?>"
            <?//a jquery selector that define where to inject the data-model-refresh-controller html result?>
            data-model-refresh-target-selector="#mainContent"
            >

            <?if($vv->isAdmin()):?>

                <div class="mb1 mt1 pull-right">
                    <?// create and add a post to the category?>
                    <a class="btn btn-success btn-small"
                        <?//the action to do?>
                       href="#Model.addNewChild()"
                        <?//the new model type to create?>
                       data-new-type="M_subcategory_media"
                        <?//where to go after the post creation?>
                       data-redirect-controller-after-action="<?=C_press::categoryMedia($vv->categoryMedia->id,"0",true)?>"
                        <?//the field where to add the new category_media?>
                       data-new-field-target="subcategories">
                       <i class="icon-plus-sign icon-white"></i>
                        Add a category
                    </a>
                </div>



            <?endif?>


            <!-- list all subCats -->
            <div class="row">
                <? foreach ($vv->subCatMedias as $subCat):?>
                    <?=$this->render("press/media/subCatMedia", $subCat)?>
                <? endforeach;?>
            </div>
        </div>
    </div>
</div>
<!-- Affichage de la pagination si > a 1 page -->
<?=$this->render("press/media/paginationCategoryMedia", $vv)?>