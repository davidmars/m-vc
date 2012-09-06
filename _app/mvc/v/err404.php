<?
/**
 * this is defined in the controller 
 */
$vv=new VV_fmk_page($_vars);
?>
<?
/*
 * we put this content in the framework default layout page...so we will get:
 * 
 * -twitter bootstrap
 * -jquery
 * -framework stylesheet default 
 * 
 * 
 */


?>
<?$this->inside("fmk-default/layout/commonPage")?>
<div class="well">
    <h1>
        <?=$vv->title?>
    </h1>
    
    <?if($vv->param1):?>
    <p>The requested page doesn't exists </p>
    <code>
        <?=Site::url($vv->param1, true)?>
    </code>
    <?endif?>
</div>

