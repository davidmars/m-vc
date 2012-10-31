<?
/* @var $post VV_post */
$post = $_vars;

/* @var $vv VV_layout */
$vv = new VV_layout();

$refresh = C_press::post($post->post->getParentCategoryId(),true);
?>

<div class="span8"
     data-model-type="M_post"
     data-model-id="<?=$post->post->id?>"
     <?/*data-model-refresh-controller="<?=$refresh?>">*/?>
    >


    <div class="row postPreviewComponent">

        <? if ($vv->isAdmin()):?>
        <div class="wysiwyg-menu">
            <div class="top-right">

                <a class=""
                   href="#Model.previousPosition()"
                   data-model-target-type="M_category_post"
                   data-model-target-id="<?=$post->parentCategory->id?>"
                   data-model-target-field="posts">
                    <i class="icon-circle-arrow-up icon-white"></i>
                </a>

                <a class=""
                   href="#Model.nextPosition()"
                   data-model-target-type="M_category_post"
                   data-model-target-id="<?=$post->parentCategory->id?>"
                   data-model-target-field="posts">
                    <i class="icon-circle-arrow-down icon-white"></i>
                </a>

                <a class=""
                   href="#Model.delete">
                    <i class="icon-remove icon-white"></i>
                </a>
            </div>
        </div>
        <?endif?>


        <?/*<div class="postPreviewComponent">
            <?/*<div class="item-content">*/?>
                <div class="span2 item-thumbnail ppreview">
                    <a
                        href="<?= C_press::post($post->post->id)->url() ?>"
                        data-nav-is-ajax="true"
                        data-nav-is-ajax-target="mainContent">
                            <img src="<?=$post->post->thumb->sizedWithoutCrop(171, 180, "000000", "jpg")?>" alt="<?= $post->post->title ?>">
                    </a>
                </div>
                <div class="span6 item-text">
                        <div class="item-title">
                            <a
                                href="<?= C_press::post($post->post->id)->url() ?>"
                                data-nav-is-ajax="true"
                                data-nav-is-ajax-target="mainContent">
                                    <?= $post->post->title ?>
                            </a>
                        </div>
                        <br/>
                        <div class="item-description">
                            <?= $post->post->description?>
                        </div>
                        <br/>
                        <div class="item-link-readMore">
                            <a
                                href="<?= C_press::post($post->post->id)->url() ?>" rel="nofollow"
                                data-nav-is-ajax="true"
                                data-nav-is-ajax-target="mainContent">
                                    Read More...
                            </a>
                        </div>
                </div>
           <?/* </div>
        </div>*/?>
        <div class=span8>
            <div class="noGutter separatorTextBloc"></div>
        </div>
    </div>



</div>
