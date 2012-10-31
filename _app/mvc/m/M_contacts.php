<?php

/**
 * This class is like a block but only for M_contact 
 */
class M_contacts extends M_{
    
    public static $manager;
    
    /**
     *
     * @var TextField The name of the contact list
     */
    public $title;
    
    /**
     * @var M_contact[] The contacts of the blog
     */
    public $contacts;        
}
?>
