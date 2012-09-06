<?php

/**
 * Shortcut methods to set headers
 *
 * @author David Marsalone
 */
class Nerd_Header {
    
    const ERR_404="404";
    const REDIRECT_301="301";
    const REDIRECT_302="302";
    const JSON="json";
    const XML="xml";
    const DOWNLOAD="DOWNLOAD";
    
    public function __construct($code=null,$redirectUrl=null) {
        $this->code=$code;
        $this->redirectUrl=$redirectUrl;
    }
    
     /**
     * @var string The code related to this header
     */
    public $code="";  
     /**
     * @var string the url where to redirect.
     */
    public $redirectUrl="";  
    
    /**
     * performs the header if $code is defined...so it will be run from a Controler...okay? 
     */
    public function run(){
        switch($this->code){
            
            case self::REDIRECT_301;
                 //self::redirect($this->redirectUrl,  301);
                 die("301 redirect There is a better URL : ".$this->redirectUrl);
                 break;
            case self::REDIRECT_302;
                 //self::redirect($this->redirectUrl,  302);
                die("302 redirect There is a better URL : ".$this->redirectUrl);
                 break;
             
            case self::ERR_404;
                 self::err404();
                 break;
             
            case self::JSON;
                 self::json();
                 break;
             
            case self::XML;
                 self::xml();
                 break;
             
             default:
                 
        }
    }


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
     /**
     * performs a redirection with header 301. 
     * Private because you don't want to perform header in a wrong place...isn't it?
     */
    private static function redirect( $url , $code = 301 ) {
            self::code( $code );
            header("Location: $url\0");
            die();
            //header("Content-type: text/plain; charset=UTF-8");

    }
    /**
    * Process an http header
    * @param int $code Code to return
    */
    private static function code( $code ) {
            header("HTTP/1.0 $code ".self::$httpCodes[$code]);
            header("Status: $code ".self::$httpCodes[$code]);
    }
    /**
    *
    * @staticvar array Tableau de correspondance entre codes HTTP et messages
    */
    static $httpCodes = array(
        404 => "Not Found",
        301 => "Moved Permanently",
        302 => "Moved Temporarily",
        304 => "Not Modified",
        403 => "Forbidden"
    );
}
