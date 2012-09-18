<?
/* @var $template View View object related to this template*/
$template=$_view;
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
        <a class="brand" href="<?=GiveMe::url("doc/doc/index/overview")?>">
            <img src="<?=  GiveMe::imageSizedWithoutCrop("pub/app/fmk/img/logo.png", 100, "auto", "ffffff")?>"/>
            <div>Point Of View</div>
        </a>
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