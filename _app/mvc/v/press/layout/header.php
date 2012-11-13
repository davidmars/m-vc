<?
/* @var $this View */
/* @var $vv VV_layout */
$vv = $_vars;
?>
<div class="padded">
    <div class="logo-title">
        <a class="logo" href="<?=C_press::index(true) ?>">
            <img alt="Havana Club" src="<?=GiveMe::url("pub/app/press/img/logo-havana-club.png")?>">
        </a>
        <h1 class="title">
            <a class="font-title" href="<?=C_press::index(true) ?>">
                Havana Club Press Room
            </a>
        </h1>

        <?if($vv->isAdmin()):?>
        <a href="<?=Site::$host . "/havana_pressroom/logout"?>" class="btn pull-right btn-danger logout">Logout</a>
        <?endif;?>
    </div>
</div>