<?php
/* @var $vv ReflectionMethod */    
$vv=$_vars;
/* @var $param ReflectionParameter */
$param="";
/* @var $parsed DocParser */

$parsed=new DocParser($vv->getDocComment());
$parsed->parse();
$params=$parsed->getParams();
?>
<h3><?=$vv->getName()?>()</h3>
<p>
    <?=$parsed->getDesc()?>
</p>
<p>
    <?=$parsed->getShortDesc()?>
</p>
<p>
    <?for($i=0;$i<count($params);$i++):?>
        <?=$params[$i]?> ***
    <?endfor?>
</p>
<p>
    <?var_dump($params)?>
</p>

<?if($vv->getParameters()):?>
    
    <b>Parameters</b>
    
    <ul class="unstyled">
    <? foreach ($vv->getParameters() as $k=>$param):?>
        <li>
            <?=$param->name?>
                <?if($param->isDefaultValueAvailable()):?>
            = "<?=$param->getDefaultValue()?>"
                <?endif?>
                <?if($param->isOptional()):?>
                    (optional)
                <?else:?>
                    (required)
                <?endif?>
        </li>
    <? endforeach;?>
    </ul>
<?endif?>
