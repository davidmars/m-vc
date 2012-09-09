<?php
$vv=new VV_doc_reference($_vars);
?>
<div class="sections-menu">
    <ul class="nav nav-list " zzzdata-spy="affix" zzzdata-offset-top="0">
            <li class="nav-header">
                Controllers / app
            </li>
            <li>
                <?=$this->render("doc/reference/menu-folder",$vv->appControllers)?>
            </li>
            <li class="nav-header">
                Models / app
            </li>
            <li>
                <?=$this->render("doc/reference/menu-folder",$vv->appModels)?>
            </li>

    </ul>
    &nbsp;
</div>