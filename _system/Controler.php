<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Controler
 *
 * @author david marsalone
 */
class Controler {
    
    /**
     * the Default view is the view with the same controler "path/file-name of the controler"...except the suffix _c. 
     * @var View 
     */
    public $defaultView;
    
    /**
     * the data object that will feed the view
     * @var Array 
     */
    public $data=array();
    
    
    public function __construct() {
        
    }
    

}
