<?
$vv=new VV_doc_page($_vars);
?>
<ul class="nav nav-list">
  <?
  $list=$vv->sections;
  foreach ($list as $k=>$section):?>
    <?if($section->isHeader):?>
    
        <li class="nav-header">
            <?=$section->title?>
        </li>
    

    <?else:?>
        
        <li>
            <a href="#<?=$section->title?>"><?=$section->title?></a>
        </li>
        
    <?endif?>
  <?endforeach;?>
</ul>
