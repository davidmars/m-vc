<? 
    /* @var $vv VV_categoryPost */
    $vv = $_vars;            
    
    /* @var $this View */
    $this->inside("press/layout", $vv);    
?>

<div class="posts">
    <!-- Affichage de chaque preview -->
    <? foreach ($vv->categoryPost->getPostsForPage($vv->page) as $post): ?>
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
<?if($vv->categoryPost->getNbPage() > 1):?>
<?=$this->render("press/paginationCategoryPost", $vv)?>
<?endif?> 