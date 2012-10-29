<?
/* @var $this View */
?>
<?$this->inside("doc/layout/html5bp")?>

<?/*--------the nav--------------------*/?>

<div class="navbar navbar-inverse navbar-fixed-top">

    <div class="navbar-inner">
        <div class="container">

            <ul class="nav">
                <li><span>This is the generic admin</span></li>
            </ul>

            <ul class="nav pull-right">

                <li class="divider-vertical"></li>

                <?if(M_user::currentUser()->canWrite()):?>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?=M_user::currentUser()->humanName()?> <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li class="nav-header"></span><i class="icon-user"></i> <?=M_user::currentUser()->humanName()?></li>
                            <li class="divider"></li>
                            <li><a href="#Api.logout()">Logout</a></li>
                        </ul>
                    </li>
                <?else:?>
                    <li><a href="<?=C_admin_model::login(true)?>">Login</a></li>
                <?endif?>



            </ul>

        </div>
    </div>
</div>

<div class="pov-admin mt3">
    <?=$this->insideContent?>
</div>

<?//The main loading ?>
<div class="loading-full" data-admin-loading="main"></div>

<?//A modal template that will be cloned each time we need a modal?>
<div data-modals-manager-template="true">
    <div class='modal hide' >
        <div class='modal-header'>
            <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
            <h3 data-title="true">The title</h3>
        </div>
        <div class='modal-body loading-soft'>
            ...
        </div>
        <div class='modal-footer'>
            <a href='#' data-dismiss='modal' class='btn'>Close</a>
            <a href='#' data-modal-btn-validate="true" class='btn btn-primary'>Save changes</a>
        </div>
    </div>
</div>

<script>
    Config.apiUrl="/admin/api"
    Config.rootUrl="<?=Site::$root?>";
</script>