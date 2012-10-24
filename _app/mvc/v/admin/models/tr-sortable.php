<?php
/** @var $this View */
/** @var $_vars M_ Can be a model */
$m=$_vars;
?>
<tr data-model-type="<?=$m->modelName?>"
    data-model-id="<?=$m->id?>">

    <td><i class="icon-file"></i></td>
    <td><?=$m->id?>/<?=$m->humanName()?></td>

    <td><a href="#Fields.Assoc.move" data-move="before"><i class="icon-arrow-up"></i></a></td>
    <td><a href="#Fields.Assoc.move" data-move="after"><i class="icon-arrow-down"></i></a></td>

    <td><a href="#Model.removeDOM"><i class="icon-remove"></i></a></td>

</tr>