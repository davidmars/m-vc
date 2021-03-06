<? 
    /* @var $vv VV_categoryPost */
    $vv = $_vars;
    
    /* @var $this View */
    $this->inside("press/layout/layout", $vv);
?>

<div class="hidden" data-meta-title="true"><?=$vv->categoryPost->title?></div>

<div class="row">
    <div class="span8">
        <div class="padded posts background-content"
            <?//the current model type?>
            data-model-type="M_category_post"
            <?//the current model id?>
            data-model-id="<?=$vv->categoryPost->id?>"
            <?//the controller url to use to refresh after actions?>
            data-model-refresh-controller="<?=C_press::categoryPost($vv->categoryPost->id,$vv->currentPagination,true)?>"
            <?//a jquery selector that define where to inject the data-model-refresh-controller html result?>
            data-model-refresh-target-selector="#mainContent"
            >
            <div class="row">
            <?if($vv->isAdmin()):?>

                <div class="span8 mb1 mt1">
                    <?// create and add a post to the category?>
                    <a class="pull-right btn btn-success btn-small"
                       <?//the action to do?>
                       href="#Model.addNewChild()"
                       <?//the new model type to create?>
                       data-new-type="M_post"
                       <?//the field where to add the new post?>
                       data-new-field-target="posts"
                        <?//where to go after the post creation?>
                       data-redirect-controller-after-action="<?=C_press::categoryPost($vv->categoryPost->id,0,true)?>">
                        <i class="icon-plus-sign icon-white"></i>
                        Add a post
                    </a>
                </div>


                <div class="span8">
                    <div class="marged separatorTextBloc"></div>
                </div>

            <?endif?>

                <!-- Affichage de chaque preview réordonné -->

                <div class="span8">
                    <div class="row">
                        <?foreach ($vv->posts as $post):?>
                            <?=$this->render("press/post/postPreview", $post)?>
                        <?endforeach;?>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- Affichage de la pagination si > a 1 page -->
<?=$this->render("press/post/paginationCategoryPost", $vv)?>
