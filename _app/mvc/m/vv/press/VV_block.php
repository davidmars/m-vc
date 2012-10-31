<?php
/**
 * Created by JetBrains PhpStorm.
 * User: david
 * Date: 31/10/12
 * Time: 09:50
 * To change this template use File | Settings | File Templates.
 */
class VV_block extends ViewVariables
{
    /**
     * @var M_block The related block.
     */
    public $block;

    /**
     * @param $block M_block
     */
    public function init($block){
        $this->block=$block;
    }
}
