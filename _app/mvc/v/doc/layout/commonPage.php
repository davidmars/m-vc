<?
    $vv=new VV_doc_page($_vars);
?>
<?=$this->inside("doc/layout/html5bp",$vv)?>

<?=$this->render("doc/layout/main-menu",$vv)?>

<div class="container" style="padding-top: 80px;">
    <div class="row">
        <div class="span3">
            menu
        </div>
        <div class="span9">
                <?=$_content?>
        </div>
    </div>
</div>