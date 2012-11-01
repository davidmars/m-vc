<?php
/**
 * Created by JetBrains PhpStorm.
 * User: david
 * Date: 01/11/12
 * Time: 16:27
 * To change this template use File | Settings | File Templates.
 */
class VV_contactList extends ViewVariables{
    /**
     * @param $model M_contacts
     */
    public function __construct($model){
        $this->model=$model;
        $this->contacts=array();
        foreach($this->model->contacts as $contact){
            $vv=new VV_contact($contact,$this);
            $this->contacts[]=$vv;
        }
    }

    /**
     * @var M_contacts The real M_contacts model
     */
    public $model;
    /**
     * @var VV_contact[]
     */
    public $contacts;


}

