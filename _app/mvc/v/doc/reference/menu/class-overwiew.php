<?

$vv=new VV_doc_reference_class($_vars);
?>
<div class="row">
    <ul class=" span3 nav nav-list " >

        <li class="nav-header">Properties</li>
        
        <?
        $variables=$vv->publicVariables;
        foreach($variables as $k=>$v):?>
            <?
            $doc=CodeComments::getVariable($v->getDocComment());
            ?>
            <li><a href="#var_<?=$v->name?>"><?=$v->name?>: <?=$doc["type"]?></a></li>
        <?endforeach?>
            
        <li class="divider"></li>
        
        <?
        $variables=$vv->publicStaticVariables;
        foreach($variables as $k=>$v):?>
            <?
            $doc=CodeComments::getVariable($v->getDocComment());
            ?>
            <li><a href="#var_<?=$v->name?>">Static <?=$v->name?>: <?=$doc["type"]?></a></li>
        <?endforeach?>
            
            
        <li class="nav-header">Functions</li>
        <?
        $variables=$vv->publicFunctions;

        foreach($variables as $k=>$v):?>
            <?
            $r=  CodeComments::getReturn($v->getDocComment());
            ?>
            <li><a href="#fn_<?=$v->name?>"><?=$v->name?>(): <?=$r["type"]?></a></li>
        <?endforeach?>
        
        <li class="divider"></li>
        <?
        $variables=$vv->publicStaticFunctions;
        foreach($variables as $k=>$v):?>
            <?
            $r=  CodeComments::getReturn($v->getDocComment());
            ?>
            <li><a href="#fn_<?=$v->name?>">Static <?=$v->name?>(): <?=$r["type"]?></a></li>
        <?endforeach?>

    </ul>
</div>
&nbsp;