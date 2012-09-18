<?php
$vv=new VV_doc_reference_class($_vars);
/* @var $template View */
$template=$_view;
?>
<div class="row">

    <div class="span4">
        &nbsp;
        <div style="position: fixed;top: 100px;bottom:0px;">
            
            <div class="row">

                
                <div class="span4" style="position: absolute;height:100%;">
                    
                    <ul class="nav nav-tabs">
                        <li><a href="#project_tab" data-toggle="tab">All Classes</a></li>
                        <li class="active"><a href="#here_tab"  data-toggle="tab"><?=$vv->className?></a></li>
                    </ul>

                    <div class="tab-content" style="position: absolute; top:40px; bottom: 0px; width:100%; overflow-x: auto;overflow-y: auto;">

                        <div id="here_tab" class="tab-pane active class-overview sections-menu" >
                            <?=$template->render("doc/reference/menu/class-overwiew", $vv)?>
                        </div>

                        <div id="project_tab" class="tab-pane">
                            <?=$template->render("doc/reference/menu/all-classes", $vv)?>
                        </div>
                        
                    </div>
                </div>
            </div>
  
         </div>
     </div>    
</div>