<? 
    /* @var $this View */
    $this->inside("press/html5bp");
    
    /* @var $vv VV_layout */
    $vv = $_vars;
?>
<div class="container">
    
    <div class="row">        
        <div class="span12 logo-title">
            
            <a class="logo" href="<?=C_press::categoryPost(1)->url() ?>">
                <img alt="Havana Club" src="<?=GiveMe::url("pub/app/press/img/logo-havana-club.png")?>">
            </a>
            <h1 class="title">
                <a class="font-title" href="<?=C_press::categoryPost(1)->url() ?>">
                    Havana Club Press Room
                </a>
            </h1>
            
        </div>        
    </div>
    
    <div class="row">        
        <div class="span8">
            
            <!-- Menu vers chaque category -->
            <div class="navBarComponent">  
                <div class="row">                
                    <!-- Pour chaque category post -->
                    <? foreach ($vv->getAllCategoriesPost() as $category): ?>
                    <div class="span2 item-nav <?=($vv->currentCategoryId == $category->getCategoryId())?("active"):("")?>" data-main-tab="<?=$category->getCategoryId()?>">
                        <a href="<?=C_press::categoryPost($category->id)->url()?>"><?=$category->title?></a>
                        <span class="arrow"></span>
                    </div>                    
                    <?endforeach;?>                    
                    
                    <? foreach ($vv->getAllCategoriesMedia() as $category): ?>                                
                    <div class="span2 item-nav <?=($vv->currentCategoryId == $category->getCategoryId())?("active"):("")?>" data-main-tab="<?=$category->getCategoryId()?>">
                        <a href="<?=C_press::categoryMedia($category->id)->url()?>"><?=$category->title?></a>
                        <span class="arrow"></span>
                    </div>  
                    <?endforeach;?>     
                </div>
            </div>
            
            <!-- seperator bloc -->
            <div class="separatorBloc">&nbsp;</div>
            
            <!-- main content -->
            <div id="mainContent">
                <?=$this->insideContent?>
            </div>
            
        </div>
        
        <!-- sideBar -->
        <div class="span4 sidebar">
            <?=$this->render("press/sideBar", $vv)?>
        </div>
        
   </div>
    
</div>