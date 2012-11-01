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
            <?//TODO::rai::put the ref to the main page in app/config + on vv_layout, no id hard coded in templates!!! ?>
            <a class="font-title" href="<?=C_press::categoryPost(1,null,true) ?>">
                Havana Club Press Room
            </a>
        </h1>
    </div>
</div>