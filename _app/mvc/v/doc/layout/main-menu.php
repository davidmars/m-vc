<?
$vv=new VV_doc_page($_vars);
?>
<div class=" navbar navbar-inverse navbar-fixed-top">
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
            $pages=$vv->getPages($vv); 
            foreach ($pages as $k=>$page):?>
                <li class="<?=$page->isActive? " active ":""?>">
                    <a href="<?=Site::url($page->routeUrl)?>"><?=$page->title?></a>
                </li>
            <?endforeach?>

        </ul>
        </div>
    </div>
    </div>
</div>