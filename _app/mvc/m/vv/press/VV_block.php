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
     * @var M_ the model that conatain this block
     */
    public $parentModel;

    /**
     * @param $block M_block
     */
    public function init($block){
        $this->block=$block;
    }

    /**
     * This function is an easy way to get an admin field for the block->photo->photo field.
     * @return VV_admin_field
     */
    public function blockPhotoAdminField(){
        $editableField=new VV_admin_field();
        $editableField->init($this->block->getContent(),"photo");
        return $editableField;
    }
}
