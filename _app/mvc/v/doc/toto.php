<?php
$vv=new ViewVariables($_vars);
?>
<h1>
   <?=$vv->anarchy["variableInTheView1"]?>
</h1>
<h2>
   <?=$vv->anarchy["variableInTheView2"]?>
</h2>

 <?=$vv->json()?>