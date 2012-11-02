<?
    /* @var $this View */
    /* @var $vv VV_layout */
    $vv = $_vars;
?>

<?if ($this->isAjax):?>
    <?=$this->insideContent?>
    <script>
        Press.setActiveTab("<?=$vv->getActiveTab()?>");
    </script>
<?else:?>
    <?
        $this->inside("press/layout/html5bp");
    ?>

    <?=$this->render("press/layout/embed-header-menu",$vv)?>

    <div class="container">

        <?=$this->render("press/layout/embed-header-submenu",$vv)?>


        <div class="row">
            <div class="span12">
                <?=$this->render("press/layout/header",$vv)?>
            </div>
        </div>

        <div class="row">
            <div class="span8">

                <?=$this->render("press/layout/main-menu",$vv)?>

                <!-- seperator bloc -->
                <div class="row">
                    <div class="span8">
                        <div class="padded separatorBloc"></div>
                    </div>
                </div>

                <!-- main content -->
                <div class="row">
                        <div id="mainContent" class="span8" data-nav-ajax-receiver="mainContent">
                            <?=$this->insideContent?>
                        </div>
                </div>

            </div>

            <!-- sideBar -->
            <div class="span4 sidebar" data-nav-ajax-receiver="sideBar" id="sideBar">
                    <?=$this->render("press/sidebar/sideBar", $vv)?>
            </div>

       </div>        
    </div>

    <?=$this->render("press/layout/embed-footer",$vv)?>

<?endif;?>

<?=$this->render("press/popin/popinloader")?>

<?//-----------------admin WYSIWYG configuration--------------------*/?>
<?if($vv->isAdmin()):?>
    <script>
        Config.apiUrl="/admin/api"
        Config.rootUrl="<?=Site::url("",true)?>";
    </script>
<?endif?>