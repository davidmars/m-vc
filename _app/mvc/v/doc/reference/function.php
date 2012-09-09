<?php
/* @var $vv ReflectionMethod */    
$vv=$_vars;
/* @var $param ReflectionParameter */
$param="";

$comments=$vv->getDocComment();
?>


<h3><?=$vv->name?>(<span class="text-color-grayLight"><?=CodeComments::getParametersOverview($vv)?></span>)</h3>
<small><b>Declared in </b><?=$vv->getDeclaringClass()->name?></small>
<p><b>Description : </b><?=CodeComments::getDescription($comments)?></p>


<?var_dump($comments)?>


<?if($vv->getParameters()):?>
    
    <h4>Parameters</h4>
    
    
    <? foreach ($vv->getParameters() as $k=>$param):?>
            <?
            $doc=CodeComments::getArgument($param->name,$comments);
            ?>
            <h5>
                $<?=$param->name?> : <?=$doc["type"]?>
                <?if($param->isOptional()):?>
                <span class="label label-success">Optional</span>
                <?else:?>
                <span class="label label-warning">Required!</span>
                <?endif?>
            </h5>
            
            <p>
                <b>Description : </b><?= $doc["description"]?>            
            </p>

            <?if($param->isDefaultValueAvailable()):?>
                <p>
                    <b>Default value : </b><?=$param->getDefaultValue()?>            
                </p>
            <?endif?>

                    
    <? endforeach;?>

<?endif?>
<hr>