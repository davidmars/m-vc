<?
/* @var $this View */
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
        <?=$this->render("press/post/header-preview",$post)?>

    </div>

</div>
