<?php

/**
 * Shortcut methods to set headers
 *
 * @author David Marsalone
 */
class Nerd_Header {
    
    const ERR_404="404";
    const JSON="json";
    const XML="xml";
    const DOWNLOAD="DOWNLOAD";

    public function __construct($code=null) {
        $this->code=$code;
    }
    /**
     * performs the header if $code is defined...so it will be run from a Controler...okay? 
     */
    public function run(){
        switch($this->code){
            
            case self::ERR_404;
                 self::err404();
                 break;
             
             default:
                 
        }
    }
    /**
     * @var string The code related to this header
     */
    public $code="";

    /**
     * performs a Content-type: application/json header. 
     * Private because you don't want to perform header in a wrong place...isn't it? 
     */
    private static function json(){
        header('Content-type: application/json');
    }
    /**
     * performs a Content-type: text/xml; charset=utf-8. 
     * Private because you don't want to perform header in a wrong place...isn't it? 
     */
    private static function xml(){
        header("Content-type: text/xml; charset=utf-8"); 
    }
     /**
     * performs a header 404. 
     * Private because you don't want to perform header in a wrong place...isn't it?
     */
    private static function err404(){
        header("HTTP/1.0 404 Not Found");
        header("Status: 404 Not Found");
    }
}
