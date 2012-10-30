<?php
/**
 * Created by JetBrains PhpStorm.
 * User: francoisrai
 * Date: 26/10/12
 * Time: 15:43
 * To change this template use File | Settings | File Templates.
 */
class VV_media extends VV_layout {

    /**
     * @var M_media
     */
    public $media;

    /**
     * This function is an easy way to get an admin field for the media->theFile field.
     * @return VV_admin_field
     */
    public function theFileAdminField(){
        $editableField=new VV_admin_field();
        $editableField->init($this->media,"theFile");
        $editableField->label="Download";
        return $editableField;
    }
    /**
     * This function is an easy way to get an admin field for the media->theFileHd field.
     * @return VV_admin_field
     */
    public function theFileHdAdminField(){

        $editableField=new VV_admin_field();
        $editableField->init($this->media,"theFileHd");
        $editableField->label="Download HD";
        return $editableField;
    }

    public function init($media) {
        $this->media=$media;
    }
}