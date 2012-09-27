<?
/* @var $this View */
$vv=new VV_doc_page($_vars); 
?>
<?=$this->inside("doc/layout/html5bp",$vv)?>
<?=$this->render("doc/layout/main-menu",$vv)?>

<div class="container" style="padding-top: 100px;">
    <div class="row">
        <div class="span4">
            <div class="">
            <?=$this->render("doc/layout/sections-menu",$vv)?>
            </div>
        </div>
        <div class="span8">
            <?=$this->insideContent?>
            <?
            $sections=$vv->sections;
            foreach($sections as $k=>$v):?>
                <div class="section" id="<?=$v->id?>">
                    <?if($v->isHeader):?>
                        <div class="page-header">
                            <h2><?=$v->title?></h2>
                        </div>
                    <?elseif($v->isSeparator):?>
                        <hr></hr>
                    <?else:?>
                        <?/*---a real content----*/?>
                        <div class="page-header">
                            <h3 ><?=$v->title?></h3>
                            <h4><?=$v->templatePath?></h4>
                        </div>
                        <?=$this->render($v->templatePath)?>
                    <?endif?>
                </div>
            <?endforeach;?>
             
        </div>
    </div>
</div>