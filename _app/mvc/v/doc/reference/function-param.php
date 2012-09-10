<?
/* @var $param ReflectionParameter */
$param=$_vars["param"];
$doc=CodeComments::getArgument($param->name,$_vars["comments"]);

?>
<div class="span8">&nbsp;</div>

<div class="span2"><b>$<?=$param->name?></b></div>
<div class="span6">
    <?if($param->isOptional()):?>
        <span class="label label-success">Optional</span>
    <?else:?>
        <span class="label label-warning">Required!</span>
    <?endif?> 
</div>

<div class="span2">Type</div>
<div class="span6">
    <?=$doc["type"]?>
</div>

<div class="span2">Default value</div>
<div class="span6">
    <?if($param->isDefaultValueAvailable()):?>
            <?
                $dv=$param->getDefaultValue();
                if(!$dv && $doc["type"]=="string"){
                    $dv="empty string";
                }elseif($dv===null){
                    $dv="null";
                }elseif($dv===false){
                    $dv="false";
                }
            ?>
            <?=$dv?> 
        <?else:?>
            <span class="text-color-grayLight">There is no default value for this parameter.</span>
        <?endif?>
</div>

<div class="span2">Description</div>
<div class="span6">
    <?= $doc["description"]?>
</div>