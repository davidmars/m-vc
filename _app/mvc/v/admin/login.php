<?php
/* @var $this View */
?>
<?if(!$vv->isAjax):?>
<?$this->inside("admin/layout/admin-layout")?>
<?endif?>

<div class="container ">
    <div class="row">
        <div class="span4 offset4 mt2">
            <div class="well">

                <form class="form-horizontal" data-login-box="true" data-login-redirect="<?=C_admin_model::listModels("M_post",true);?>">

                    <legend>Welcome.</legend>

                    <div data-messages-container="true">
                        <?//here will be appended success or error messages?>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="email">Email</label>
                        <div class="controls">
                            <input class="span2" data-login-email="true" type="text" placeholder="email@email.com">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="password">Password</label>
                        <div class="controls">
                            <input class="span2" data-login-password="true" type="password" placeholder="your password">
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="controls">
                            <button  type="submit" class="btn pull-right btn-success" data-loading-text="Wait...">Login</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


