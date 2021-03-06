<?
/* @var $this View */
/* @var $vv VV_subCatMedia */
$vv = $_vars;

?>

<div class="span8 subcatMedia subcatMediaPreview"
        data-slider="true"
        data-model-id="<?=$vv->subCategoryMedia->id?>"
        data-model-type="M_subcategory_media"
        >


            <?if($vv->isAdmin()):?>

            <?/*-----------------up down delete--------------*/?>

            <div class="wysiwyg-menu">
                <div class="top-right">

                    <a class=""
                       href="#Model.previousPosition()"
                       data-model-target-type="M_category_media"
                       data-model-target-id="<?=$vv->currentCategory->categoryMedia->id?>"
                       data-model-target-field="subcategories">
                        <i class="icon-circle-arrow-up icon-white"></i>
                    </a>

                    <a class=""
                       href="#Model.nextPosition()"
                       data-model-target-type="M_category_media"
                       data-model-target-id="<?=$vv->currentCategory->categoryMedia->id?>"
                       data-model-target-field="subcategories">
                        <i class="icon-circle-arrow-down icon-white"></i>
                    </a>

                    <a class=""
                       href="#Model.delete">
                        <i class="icon-remove icon-white"></i>
                    </a>
                </div>
            </div>
            <?endif?>


        <?/*--------------title---------------*/?>

        <h1 class="item-media-section"><?=$vv->subCategoryMedia->title?></h1>


        <?/*------------the list--------------*/?>
        <div class="slider">
            <div class="move">
                <?=$this->render("press/media/subCatMediaList",$vv)?>

            </div>
        </div>

        <?/*-----------footer-------------*/?>

        <div class="footer-preview">
            <div class="pull-right">
                <?if($vv->isAdmin()):?>
                    <a class="btn btn-success btn-small" href="<?=C_press::subCatMedia($vv->subCategoryMedia->id,"Page","0","all",true)?>">
                        <i class="icon-edit icon-white"></i>
                        Edit this category
                    </a>
                <?else:?>
                    <a class=view-all href="<?=C_press::subCatMedia($vv->subCategoryMedia->id,"Page","0","all",true)?>"
                       data-nav-is-ajax="true" data-nav-is-ajax-target="mainContent">
                        View all
                    </a>
                <?endif?>
            </div>
            <?if($vv->hasSlider()):?>
            <div class="pull-left">
                <div class="pagination pagination-small">
                    <?//pages list?>
                    <ul>
                        <li><a class="prev" href="#Press.Slider.prev()"><i class="icon-left-arrow"></i></a></li>
                        <?for($i=0;$i<$vv->getSlides();$i++):?>
                            <li><a href="#Press.Slider.toPage()" data-page="<?=$i?>"><?=$i+1?></a></li>
                        <?endfor?>
                        <li><a class="next" href="#Press.Slider.next()"><i class="icon-right-arrow"></i></a></li>
                    </ul>
                    <div class="clearfix"></div>
                </div>

            </div>
            <div class="clearfix"></div>
            <?endif?>
        </div>

        <div class="clearfix"></div>
        <div class="padded separatorTextBloc"></div>


</div>

