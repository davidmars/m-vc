<?
$vv=new VV_doc_reference_class($_vars);
?>
<?$this->inside("doc/layout/html5bp")?>

<div class="container doc-reference" style="padding-top: 80px;">
    <div class="row">
        <div class="span4">
            <div class="">
                <?=$this->render("doc/reference/menu",$vv)?>
            </div>
        </div>
        <div class="span8">
            <div class="well">
                <h1><?=$vv->className?></h1>
                
                <small><b>Extends : </b><?=$vv->extends?></small><br/>
                <small><b>Location : </b><?=$vv->file?></small><br/>
                
                <?if($vv->author):?>
                    <small>
                        <b>Author</b> <?=$vv->author?><br/>
                    </small>
                    
                <?endif?>
                <?var_dump($vv->author)?>
                <p>
                    <?=$vv->description?><br/>
                    <? var_dump($vv->description); ?>
                </p>
                
                <? var_dump($vv->comments); ?>
                
                <hr/>

                
            </div>
            
            <h2>Public functions</h2>
            <?
            $functions=$vv->publicFunctions;
            foreach($functions as $k=>$v):?>
                <?=$this->render("doc/reference/function",$v)?>
            <?endforeach;?>
            
            
            <h3>Function name</h3>
            <h4>Description</h4>
            <h4>Parameters</h4>
            <h4>Return</h4>
        </div>
    </div>
</div>