<?
/* @var $this View */
?>
<?if($_vars && count($_vars)>0):?>
<ul class="files-tree">

    <?foreach($_vars as $item):?>
    
        <?if($item["type"]=="file"):?>
	    <?
		$urlInfos=GiveMe::urlInfos("doc/doc/classDefinition/".$item["name"]);
	    ?>
	    <li>
		<i class="icon-file"></i>
		<?if($urlInfos->isCurrent()):?>
		    <b><?=$item["name"]?></b>
		<?else:?>
		    
		    <a href="<?=$urlInfos->urlOptimized?>">
			<?=$item["name"]?>
		    </a>
		<?endif?>
	    </li>
        <?elseif($item["type"]=="folder"):?>
            <li>
                <i class="icon-folder-open"></i> <?=$item["name"]?>
		<?  //Human::log($item["content"],"temp")?>
                <?=$this->render("doc/reference/menu-folder",$item["content"])?>
            </li>
            
        <?endif?>
    
    <?endforeach?>
</ul>
<?endif?>

