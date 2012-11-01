<?
    /* @var $vv VV_subCatMedia */
    $vv = $_vars;

    /* @var $this View */
    $this->inside("press/layout/layout", $vv);
?>
<div class="row">
    <div class="span8">
        <div class="posts padded background-content"
             data-model-id="<?=$vv->subCategoryMedia->id?>"
             data-model-type="M_subcategory_media"
             data-model-refresh-controller="<?=C_press::subCatMedia($vv->subCategoryMedia->id,"Page","0","all",true);?>"
             >
            <div class="row">
                <div class="subcatMedia  span8">

                    <?if($vv->isAdmin()):?>
                        <div class="pt1 pb3">
                            <div class="pull-right">
                                    <?// create and add a contact to the contacts?>
                                <a class=" btn btn-success btn-small"
                                    <?//the action to do?>
                                   href="#Model.addNewChild()"
                                    <?//the new model type to create?>
                                   data-new-type="M_media"
                                    <?//the field where to add the new item?>
                                   data-new-field-target="medias">
                                    <i class="icon-plus-sign icon-white"></i>
                                    Add a download
                                </a>

                                <a class=" btn btn-success btn-small"
                                   href="#Model.saveAll()">
                                    <i class="icon-ok icon-white"></i>
                                    Save
                                </a>
                            </div>
                        </div>
                    <?endif?>

                        <?//-----------------title----------------------?>

                        <div class="item-media-section"
                             data-field="root[title]"
                             data-field-type="Text">
                            <span
                                <?//editable ?>
                                <?=$vv->isAdmin()?"contenteditable='true' ":""?>
                                <?// no text formatting allowed here */?>
                                    data-remove-format="true"><?=$vv->subCategoryMedia->title?></span>
                        </div>

                    <?//-----------------list----------------------?>
                    <?=$this->render("press/media/subCatMediaList",$vv)?>

                    <div class="padded separatorTextBloc"></div>

                </div>
            </div>
        </div>
    </div>
</div>