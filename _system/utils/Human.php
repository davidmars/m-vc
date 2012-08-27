<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Human
 *
 * @author  david marsalone
 */
class Human {
    
    const TYPE_ERROR ="error";
    const TYPE_WARN ="warn";
    const TYPE_LOG ="log";


    public static function log($obj,$title="Php Trace",$type=self::TYPE_WARN){
        switch ($type){
            case self::TYPE_LOG:
            ChromePhp::log($title,$obj);
            break;
        
            case self::TYPE_ERROR:
            ChromePhp::error($title,$obj);
            break;
        
            case self::TYPE_WARN:
            default:
            ChromePhp::warn($title,$obj);
            break;
        
        }

        
        // test
        //debug('test message');
        //debug('SELECT * FROM users', 'sql');
        //unkownFunction($unkownVar);
    }
}
