<?
    $vv=new VV_404($_vars);
?>
<?$this->inside("doc/layout/commonPage",$vv);?>
<h1><?=$vv->title?></h1>
<p><?=$vv->message?></p>
