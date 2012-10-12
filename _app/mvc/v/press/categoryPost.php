<? 
    /* @var $vv VV_categoryPost */
    $vv = $_vars;            
    
    /* @var $this View */
    $this->inside("press/layout", $vv);    
?>

<!-- Affichage de chaque preview -->
<? foreach ($vv->categoryPost->getPostsForPage($vv->page) as $post): ?>
<?=$this->render("press/postPreview", $post)?>
<?endforeach;?>

<!-- Affichage de la pagination si > a 1 page -->
<?if($vv->categoryPost->getNbPage() > 1):?>
<?=$this->render("press/paginationCategoryPost", $vv)?>
<?endif?> 