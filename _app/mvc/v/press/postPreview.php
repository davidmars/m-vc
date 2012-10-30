<?
/* @var $post VV_post */
$post = $_vars;

/* @var $vv VV_layout */
$vv = new VV_layout();

$refresh = C_press::post($post->post->getParentCategoryId(),true);
?>

<span data-model-type="M_post"
      data-model-id="<?=$post->post->id?>"
      data-model-refresh-controller="<?=$refresh?>"
    >
    <? if ($vv->isAdmin()):?>
            <div style="position:absolute; right:15px;"> <?//TODO:remove this shit?>

                <a class=" btn btn-danger btn-small"
                   href="#Model.delete">
                    <i class="icon-remove icon-white"></i>
                </a>

                <a class=" btn btn-small"
                   href="#Model.previousPosition()"
                   data-model-target-type="M_category_post"
                   data-model-target-id="<?=$post->parentCategory->id?>"
                   data-model-target-field="posts">
                    <i class="icon-arrow-up"></i>
                </a>
                <a class=" btn btn-small"
                   href="#Model.nextPosition()"
                   data-model-target-type="M_category_post"
                   data-model-target-id="<?=$post->parentCategory->id?>"
                   data-model-target-field="posts">
                    <i class="icon-arrow-down"></i>
                </a>
            </div>
    <?endif?>

    <div class="row">
        <div class="postPreviewComponent">
            <div class="item-content">
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
            </div>
        </div>
    </div>
</span>