<?php
/* @var $vv ReflectionMethod */    
$vv=$_vars;
/* @var $param ReflectionParameter */
$param="";

$comments=$vv->getDocComment();
$return=CodeComments::getReturn($comments);
?>
<div id="fn_<?=$vv->name?>" class="doc-reference-function">
<?=$this->render("doc/reference/toggleVarDump",$comments)?>
<h3><?if($vv->isStatic()):?><span class="text-color-grayLight"><?=$vv->class?>::</span><?endif?><?=$vv->name?>
    (<span class="text-color-grayLight">
        <?=CodeComments::getParametersOverview($vv)?>
    </span>)
    :   <?=CodeComments::getReturnOverview($comments)?>
</h3>
    
<div class="row">
    <div class="span8  fs-description"><?=CodeComments::getDescription($comments)?></div>
    
    
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



<div class="row">
    
    <div class="span8">
        <hr/>
    </div>   
    
    <div class="span2">
        <b>Return</b>
    </div>
    <?if($return["type"]!="void"):?>
        <div class="span6">
            -
        </div>
        <div class="span2">
            Type
        </div>
        <div class="span6">
            <?=$return["type"]?><br/>
        </div>
        <div class="span2">
            Description
        </div>
        <div class="span6">
            <?=$return["description"]?>
        </div>

    <?else:?>
        <div class="span6 text-color-grayLight">
            Nothing
        </div>
    <?endif?>
    


    
 <?if(count($vv->getParameters())>0):?> 
    
    <div class="span8">
        <hr/>
    </div>
    
    <div class="span2"><b>Parameters...</b></div>
    <div class="span6">-</div>
    <? foreach ($vv->getParameters() as $k=>$param):?>
        <?=$this->render("doc/reference/function-param",array("param"=>$param,"comments"=>$comments))?>  
    <?endforeach;//each parameter?>
<?endif //if parameters?>
</div> 
<hr>
</div>