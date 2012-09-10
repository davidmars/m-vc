<ul class="files-tree">
    <?foreach($_vars as $item):?>
    
        <?if($item["type"]=="file"):?>
    <li><i class="icon-file"></i> <a href="<?=GiveMe::url("doc/doc/classDefinition/".$item["name"])?>"><?=$item["name"]?></a></li>
        <?else:?>
            <li>
                <i class="icon-folder-open"></i> <?=$item["name"]?>
                <?=$this->render("doc/reference/menu-folder",$item["content"])?>
            </li>
            
        <?endif?>
    
    <?endforeach?>
</ul>
