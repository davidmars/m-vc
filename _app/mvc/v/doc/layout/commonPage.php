<?
    $vv=new VV_doc_page($_vars);
?>
<?=$this->inside("doc/layout/html5bp",$vv)?>
<?=$this->render("doc/layout/main-menu",$vv)?>

<div class="container" style="padding-top: 80px;">
    <div class="row">
        <div class="span4">
            <div class="">
            <?=$this->render("doc/layout/sections-menu",$vv)?>
            </div>
        </div>
        <div class="span8">
            <?=$_content?>
            <?
            $sections=$vv->sections;
            foreach($sections as $k=>$v):?>
                
                <?if($v->isHeader):?>
                    <div class="page-header">
                        <h2><?=$v->title?></h2>
                    </div>
                <?else:?>
                    <div class="page-header">
                        <h3><?=$v->title?></h3>
                    </div>
                    <?=$this->render($v->templatePath)?>
                <?endif?>
            <?endforeach;?>
            
        </div>
    </div>
</div>