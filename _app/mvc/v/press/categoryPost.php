<? 
    /* @var $vv VV_categoryPost */
    $vv = $_vars;
    
    /* @var $this View */
    $this->inside("press/layout", $vv);       
?>

<div class="posts"
     <?//the current model type?>
     data-model-type="M_category_post"
    <?//the current model id?>
     data-model-id="<?=$vv->categoryPost->id?>"
    <?//the controller url to use to refresh after actions?>
     data-model-refresh-controller="<?=C_press::categoryPost($vv->categoryPost->id,"0",true)?>"
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
               data-new-type="M_post"
               <?//the field where to add the new post?>
               data-new-field-target="posts">
                Add a post
            </a>
        </div>
    </div>
    <div class="row">
        <div class="span8">
            <div class="noGutter separatorTextBloc mb1"></div>
        </div>
    </div>
    <?endif?>

    <!-- Affichage de chaque preview réordonné -->

    <?foreach ($vv->posts as $post):?>
        <?/* @var $p M_post */?>
        <br/>
        <?=$this->render("press/postPreview", $post)?>
        <br/>
        <div class="row">
            <div class="span8">
                <div class="noGutter separatorTextBloc"></div>
            </div>
        </div>
    <?endforeach;?>            
</div>

<!-- Affichage de la pagination si > a 1 page -->
<?=$this->render("press/paginationCategoryPost", $vv)?>
