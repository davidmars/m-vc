
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
			<?=$item["name"]?> <?=$urlInfos->urlOptimized?>
		    </a>
		<?endif?>
	    </li>
        <?else:?>
            <li>
                <i class="icon-folder-open"></i> <?=$item["name"]?>
                <?=$this->render("doc/reference/menu-folder",$item["content"])?>
            </li>
            
        <?endif?>
    
    <?endforeach?>
</ul>
