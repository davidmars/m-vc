<?php

/**
 * Shortcut methods to set headers
 *
 * @author David Marsalone
 */
class Header {
    /**
     * performs a Content-type: application/json header 
     */
    public static function json(){
        header('Content-type: application/json');
    }
    /**
     * performs a Content-type: text/xml; charset=utf-8 
     */
    public static function xml(){
        header("Content-type: text/xml; charset=utf-8"); 
    }
}
