<?
    $vv=new HelloVariables($_vars);
?>
<?$this->inside("samples/layout/html",$vv->layoutVariables)?>

<h1 style="color:<?=$vv->color?>;">
    Hello <?=$vv->name1?> & <?=$vv->name2?>
</h1>

<?=$vv->color?>