<?
    $vv=new VV_doc_page($_vars);
?>
<?=$this->inside("doc/layout/html5bp",$vv)?>

<div class="navbar navbar-inverse navbar-fixed-top">
    <div class="navbar-inner">
    <div class="container">
        <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        </button>
        <a class="brand" href="./index.html">Point of view</a>
        <div class="nav-collapse collapse">
        <ul class="nav">
            <?
            $pages=$vv->getPages(); 
            foreach ($pages as $k=>$page):?>
                <li class="zzzzactive">
                    <a href="<?=Site::url($page->routeUrl)?>"><?=$page->name?></a>
                </li>
            <?endforeach?>

        </ul>
        </div>
    </div>
    </div>
</div>
<div class="container" style="padding-top: 80px;">
    <?=$_content?>
</div>