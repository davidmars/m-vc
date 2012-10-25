<? 
    /* @var $vv VV_categoryPost */
    $vv = $_vars;            
    
    /* @var $this View */
    $this->inside("press/layout", $vv);       
?>

<div class="posts">
    <!-- Affichage de chaque preview réordonné -->
    <?foreach ($vv->categoryPost->posts as $p):?>
        <?/* @var $p M_post */?>
        <br/>
        <?=$this->render("press/postPreview", $p)?>
        <br/>
        <div class="row">
            <div class="span8">
                <div class="noGutter separatorTextBloc"></div>
            </div>
        </div>  
    <?endforeach;?>            
</div>

<!-- Affichage de la pagination si > a 1 page -->
<?
// Need to be change to works with block of post 
/*
<?if($vv->categoryPost->getNbPage() > 1):?>
<?=$this->render("press/paginationCategoryPost", $vv)?>
<?endif?> 
 * 
 */?>