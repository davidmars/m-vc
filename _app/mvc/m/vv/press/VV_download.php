<?php

    /*
     * To change this template, choose Tools | Templates
     * and open the template in the editor.
     */

    /**
     * Description of VV_download
     *
     * @author francoisrai
     */
class VV_download extends VV_layout {
    /**
     * @var M_dowload
     */
    public $download;

    /**
     * This function is an easy way to get an admin field for the media->theFile field.
     * @return VV_admin_field
     */
    public function theFileAdminField(){
        $editableField=new VV_admin_field();
        $editableField->init($this->download,"theFile");
        $editableField->label="Download";
        return $editableField;
    }
    /**
     * This function is an easy way to get an admin field for the media->theFileHd field.
     * @return VV_admin_field
     */
    public function theFileHdAdminField(){

        $editableField=new VV_admin_field();
        $editableField->init($this->download,"theFileHd");
        $editableField->label="Download HD";
        return $editableField;
    }
    /**
     * This function is an easy way to get an admin field for the M_media->thumb field.
     * @return VV_admin_field
     */
    public function thumbAdminField(){
        $editableField=new VV_admin_field();
        $editableField->init($this->download,"thumb");
        return $editableField;
    }

    /**
     * @param $download M_dowload
     */
    public function init($download) {
        $this->download=$download;
        if($this->download->title==""){
            $this->download->title="...";
        }
    }

    /**
     * @return bool true if the first download is an image
     */
    public function isImage(){
        if(preg_match("#image#",$this->download->theFile->mime())){
            return true;
        }else{
            return false;
        }
    }
}