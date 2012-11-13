<?
/* @var $this View */
/* @var $vv VV_post */
$vv = $_vars;
if($vv->isPreview){
    $linkInside="data-nav-is-ajax='true'";
}else{
    $linkInside="";
}
?>

<div class="span8" <?=$linkInside?>>
    <div class="row">

        <div class="span2">
            <?=$this->render("press/fields/post-image",$vv->thumbAdminField())?>
        </div>

        <div class="span6">

            <?//title ?>
            <div data-field="root[title]"
                 data-field-type="Text">
                <div class="item-title">
                    <span
                        data-meta-title="true"
                        <?//editable ?>
                        <?=$vv->isAdmin()?"contenteditable='true' ":""?>
                        <?// no text formatting allowed here */?>
                            data-remove-format="true">
                         <?=$vv->post->title?>
                    </span>
                </div>
            </div>

            <br/>

            <?//description ?>
            <div data-field="root[description]" data-field-type="Text">
                <div class="item-description">
                    <span
                        data-meta-description="true"
                        <?//editable ?>
                        <?=$vv->isAdmin()?"contenteditable='true' ":""?>
                        <?// no text formatting allowed here */?>
                            data-remove-format="true">
                        <?=$vv->post->description?>
                    </span>
                </div>
            </div>

            <?if($vv->isPreview):?>
                <div class="item-link-readMore">
                    <a
                            href="<?= C_press::post($vv->post->id,true) ?>" rel="nofollow"
                            data-nav-is-ajax="true"
                            data-nav-is-ajax-target="mainContent">
                        Read More...
                    </a>
                </div>

            <?endif?>

        </div>
    </div>
    <?if($vv->isPreview):?>
    <div class="marged separatorTextBloc"></div>
    <?endif?>

</div>