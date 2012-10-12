<? 
    /* @var $this View */
    $this->inside("press/html5bp");
    
    /* @var $vv VV_layout */
    $vv = $_vars;
?>
<div class="container">    
    <div class="row">
        
        <div class="span8">
            <!-- Menu vers chaque category -->
            <div class="row">
                <!-- Pour chaque category post -->
                <? foreach ($vv->getAllCategoriesPost() as $category): ?>
                <div class="span2 <?=($vv->currentCategoryId == $category->getCategoryId())?("bg-color1"):("")?>" data-main-tab="<?=$category->getCategoryId()?>">
                    <a href="<?=C_press::categoryPost($category->id)->url()?>">
                        <h1><?=$category->title?></h1>
                    </a>
                </div>
                <?endforeach;?>   

                <!-- Pour chaque category media -->
                <? foreach ($vv->getAllCategoriesMedia() as $category): ?>                                
                <div class="span2 <?=($vv->currentCategoryId == $category->getCategoryId())?("bg-color1"):("")?>" data-main-tab="<?=$category->getCategoryId()?>">
                    <a href="<?=C_press::categoryMedia($category->id)->url()?>">
                        <h1><?=$category->title?></h1>
                    </a>
                </div>
                <?endforeach;?>   
            </div>
            
            <!-- main content -->
            <div id="mainContent">
                <?=$this->insideContent?>
            </div>
        </div>
        
        <!-- sideBar -->
        <div class="span4">
                <?=$this->render("press/sideBar", $vv)?>
        </div>        
   </div> 
</div>