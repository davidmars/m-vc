<?php
/* @var $this View */
/* @var $vv VV_layout */
$vv = $_vars;
?>
<?if(!$vv->isAjax):?>
<?$this->inside("press/layout/layout")?>
<?endif?>

<div class="container posts">
    <div class="row">
        <div class="span4 offset2 mt2">
            <div class="well">

                <form class="form-horizontal" data-login-box="true" data-login-redirect="<?=C_press::index(true);?>">

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


