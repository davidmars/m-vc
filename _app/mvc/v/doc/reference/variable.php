<?php
/* @var $vv ReflectionProperty */    
$vv=$_vars;
$comments=$vv->getDocComment();
$doc=  CodeComments::getVariable($comments);
?>
<div id="var_<?=$vv->name?>" class="doc-reference-variable">

<?=$this->render("doc/reference/toggleVarDump",$comments)?>
<h3>
<?if($vv->isStatic()):?><span class="text-color-grayLight"><?=$vv->class?>::</span><?endif?><?=$vv->name?> : 
<span class="text-color-grayLight"><?=$doc["type"]?></span>
</h3>
    
<div class="row">
    <div class="span8  fs-description"><?=$doc["description"]?></div>
    
    
    <div class="span8"><hr/></div>

    
    
    <div class="span2">Visibility</div>
    <div class="span6">
        <?if($vv->isPublic()):?>
        <span class="label label-success">Public</span>
        <?else:?>
        <span class="label label-inverse">Private</span>
        <?endif?>
    </div>
    
    
    <div class="span2">Scope</div>
    <div class="span6">
        <?if(!$vv->isStatic()):?>
            <span class="label">Object</span>
        <?else:?>
            <span class="label label-inverse">Static</span>
        <?endif?>
    </div>
    
    
    <div class="span2">Declared in </div>
    <div class="span6"><?=$vv->getDeclaringClass()->name?> <span class="text-color-grayLight"><?=$vv->getDeclaringClass()->getFileName()?></span> </div>
</div>


<hr>
</div>