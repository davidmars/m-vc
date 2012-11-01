<?php
/**
 * Created by JetBrains PhpStorm.
 * User: david
 * Date: 01/11/12
 * Time: 09:53
 * To change this template use File | Settings | File Templates.
 */
class VV_mainTab extends VV_layout
{
    /**
     * @var text displayed in the button
     */
    public $title;
    /**
     * @var url displayed in the link
     */
    public $url;
    /**
     * @var bool will be true if the tab is active
     */
    public $active=false;

    /** @var M_ the related model */
    public $model;

    /**
     * @var M_ set this one to define the tab to set as active.
     */
    public static $activeModel;
    /**
     * @var bool will be true if an specific icon should be shown
     */
    public $hasIcon=false;
    /**
     * @return string will be "active" or nothing
     */
    public function activeString(){
        if($this->active){
            return "active";
        }else{
            return "";
        }
    }


    /**
     * @return string Something like "M_myModel_myId"
     */
    public function uid(){
        return $this->model->modelName."_____".$this->model->id;
    }
}
