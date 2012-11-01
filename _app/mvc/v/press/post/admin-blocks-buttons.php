<?
/* @var $this View */
/* @var $vv VV_post */
$vv = $_vars;

?>
<?if($vv->isAdmin()):?>
<div class="pull-right mt1">
    <a class=" btn btn-success btn-small" data-block-field-target="blocks" data-block-type="M_text" href="#Model.addBlock()">
        <i class="icon-white icon-plus-sign"></i>
        Add a text
    </a>

    <a class=" btn btn-success btn-small" data-block-field-target="blocks" data-block-type="M_embed" href="#Model.addBlock()">
        <i class="icon-white icon-plus-sign"></i>
        Add an embed
    </a>

    <a class=" btn btn-success btn-small" data-block-field-target="blocks" data-block-type="M_photo" href="#Model.addBlock()">
        <i class="icon-white icon-plus-sign"></i>
        Add a photo
    </a>
    <a class=" btn btn-success btn-small" data-block-field-target="blocks" data-block-type="M_media" href="#Model.addBlock()">
        <i class="icon-white icon-plus-sign"></i>
        Add a download
    </a>
</div>
<?endif?>