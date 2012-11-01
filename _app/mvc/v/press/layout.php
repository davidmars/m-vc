<?
    /* @var $this View */
    /* @var $vv VV_layout */
    $vv = $_vars;
?>

<?if ($this->isAjax):?>
    <?=$this->insideContent?>
<?else:?>
    <?
        $this->inside("press/html5bp");
    ?>
  
    <div class="navbar navbar-inverse navbar-fixed-top">
        <div class="navbar-inner">
            <div class="container">
                <div class="row">
                    <div class="span12">
                        <div class="noGutter">
                            <div class="nav-collapse collapse">
                                <script src="http://havanaclub.shic.cc/embedMenu"></script>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="container">

        <div class="row top_submenu">
            <div class="span12">
                <div class="noGutter">
                    <div class="row">
                        <script src="http://havanaclub.shic.cc/embedSubMenu"></script>
                    </div>
                </div>
            </div>
        </div>


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
                <div id="mainContent" data-nav-ajax-receiver="mainContent">
                    <?=$this->insideContent?>
                </div>

            </div>

            <!-- sideBar -->
            <div class="span4 sidebar" data-nav-ajax-receiver="sideBar" id="sideBar">
                    <?=$this->render("press/sideBar", $vv)?>
            </div>

       </div>        
    </div>

    <?=$this->render("press/layout/embed-footer",$vv)?>

<?endif;?>

<div id="popinloader">
       <div class="bg" data-popinloder="close"></div>
        <a class="popincloser" data-popinloder="close" href="#">
            <i class="icon-white icon-remove"></i>
        </a>

        <div id="popincontent"></div>

</div>


<?//-----------------admin WYSIWYG configuration--------------------*/?>
<?if($vv->isAdmin()):?>
    <script>
        Config.apiUrl="/admin/api"
        Config.rootUrl="<?=Site::url("",true)?>";
    </script>
<?endif?>