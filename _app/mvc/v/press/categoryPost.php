<? 
    /* @var $vv VV_categoryPost */
    $vv = $_vars;            
    
    /* @var $this View */
    $this->inside("press/layout", $vv);       
?>

<div class="posts">
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
