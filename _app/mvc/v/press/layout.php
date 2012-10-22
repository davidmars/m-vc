<? 
    /* @var $this View */
    $this->inside("press/html5bp");
    
    /* @var $vv VV_layout */
    $vv = $_vars;
?>
<div class="container">
    
    <div class="row">        
        <div class="span12">
            <div class="noGutter">
                <div class="logo-title">
                    <a class="logo" href="<?=C_press::categoryPost(1,null,true) ?>">
                        <img alt="Havana Club" src="<?=GiveMe::url("pub/app/press/img/logo-havana-club.png")?>">
                    </a>
                    <h1 class="title">
                        <a class="font-title" href="<?=C_press::categoryPost(1,null,true) ?>">
                            Havana Club Press Room
                        </a>
                    </h1>
                </div>
            </div>
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
                        <div class="noGutter">
                            <a href="<?=C_press::categoryPost($category->id,null,true)?>"><?=$category->title?></a>
                            <span class="arrow"></span>
                        </div>                        
                    </div>                    
                    <?endforeach;?>                    
                    
                    <? foreach ($vv->getAllCategoriesMedia() as $category): ?>                                
                    <div class="span2 item-nav <?=($vv->currentCategoryId == $category->getCategoryId())?("active"):("")?>" data-main-tab="<?=$category->getCategoryId()?>">
                        <div class="noGutter">
                            <a href="<?=C_press::categoryMedia($category->id,null,true)?>"><?=$category->title?></a>
                            <span class="arrow"></span>
                        </div>                        
                    </div>  
                    <?endforeach;?>     
                </div>
            </div>
            
            <!-- seperator bloc -->
            <div class="row">
                <div class="span8">
                    <div class="noGutter">
                        <div class="separatorBloc"></div>
                    </div>                
                </div>
            </div>
            
            
            <!-- main content -->
            <div id="mainContent">
                <?=$this->insideContent?>
            </div>
            
        </div>
        
        <!-- sideBar -->
        <div class="span4 sidebar">
            <div class="noGutter">
                <?=$this->render("press/sideBar", $vv)?>
            </div>
        </div>
        
   </div>
    
</div>