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
                <?=$this->render("doc/reference/toggleVarDump",$vv->comments)?>
                <h1><?=$vv->className?></h1>
                
                <small><b>Extends : </b><?=$vv->extends?></small><br/>
                <small><b>Location : </b><?=$vv->file?></small><br/>
                
                <?if($vv->author):?>
                    <small>
                        <b>Author</b> <?=$vv->author?><br/>
                    </small>
                    
                <?endif?>
                
                <hr/>
                
                <p>
                    <?=$vv->description?><br/>
                </p>
                

                
                

                
            </div>
            
            <h2>Functions</h2>
            <?
            $functions=$vv->publicFunctions;
            foreach($functions as $k=>$v):?>
                <?=$this->render("doc/reference/function",$v)?>
            <?endforeach;?>
            
            <h2>Static functions</h2>
            <?
            $functions=$vv->publicStaticFunctions;
            foreach($functions as $k=>$v):?>
                <?=$this->render("doc/reference/function",$v)?>
            <?endforeach;?>
            
            <h2>Inherited functions</h2>
            <?
            $functions=$vv->inheritPublicFunctions;
            foreach($functions as $k=>$v):?>
                <?=$this->render("doc/reference/function",$v)?>
            <?endforeach;?>
            
            <h2>Inherited static functions</h2>
            <?
            $functions=$vv->inheritPublicStaticFunctions;
            foreach($functions as $k=>$v):?>
                <?=$this->render("doc/reference/function",$v)?>
            <?endforeach;?>
            
            
        </div>
    </div>
</div>