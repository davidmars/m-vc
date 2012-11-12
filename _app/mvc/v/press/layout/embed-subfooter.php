<?
    /* @var $this View */
    /* @var $vv VV_layout */
    $vv = $_vars;
?>

<div class="hidden" id="terms" link="<?=C_press::showTerms(true)?>"></div>
<div class="hidden" id="privacy" link="<?=C_press::showPrivacy(true)?>"></div>

<footer id="press_subfooter" class="container-fluid">
    <div class="container">
        <div class="row">
            <div class="span12">
                <div class="marged">
                    <div class="row">
                        <script src="<?=$vv->embedSubFooterUrl()?>"></script>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>