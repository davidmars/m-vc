<?php
/**
 * Created by JetBrains PhpStorm.
 * User: david
 * Date: 01/11/12
 * Time: 16:14
 * To change this template use File | Settings | File Templates.
 */
class VV_contact extends ViewVariables
{
    /**
     * @param $contact M_contact
     * @param $contacts VV_contactList
     */
    public function __construct($contact,$contactList){
        $this->contact=$contact;
        $this->contactList=$contactList;
    }

    /**
     * @var M_contact The contact itself
     */
    public $contact;
    /**
     * @var VV_contactList The parent contact list
     */
    public $contactList;
}
