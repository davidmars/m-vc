<?
    $vv=new VV_404($_vars);
?>
<?=$this->inside("doc/layout/html5bp",$vv)?>
<?=$this->render("doc/layout/main-menu",$vv)?>

<div class="container" style="padding-top: 80px;">
    <div class="well">
        <h1><?=$vv->title?></h1>
        <p><?=$vv->message?></p>
    </div>    
</div>

