<?php
/* @var $this View */
/* @var $vv VV_admin_model_list */
$vv=$_vars;
?>

<?if($this->isAjax):?>
    <?=$this->insideContent?>
<?else:?>
    <?$this->inside("admin/layout/admin-layout")?>

    <div class="container">

        <div class="row">
            <div class="span4">
                <div class="">
                    <div class="affix" data-spy="affix" data-offset-top="0">
                        <?=$this->render("admin/layout/menu-models", $vv)?>
                    </div>
                    &nbsp;
                </div>
            </div>

            <div class="span8">
                <?=$this->insideContent?>
            </div>
        </div>
    </div>
<?endif?>