<?
$vv=new VV_doc_page($_vars);
?>
<div class="sections-menu">
<ul class="nav nav-list " data-spy="affix" data-offset-top="0">
  <?
  $list=$vv->sections;
  foreach ($list as $k=>$section):?>
    <?if($section->isHeader):?>
    
        <li class="nav-header">
            <?=$section->title?>
        </li>
    
    <?elseif($section->isSeparator):?>
        
        <li class="divider"> </li>
        
    <?else:?>
        
        <li>
            <a href="#<?=$section->id?>"><?=$section->title?></a>
        </li>
        
    <?endif?>
  <?endforeach;?>
</ul>
&nbsp;
</div>