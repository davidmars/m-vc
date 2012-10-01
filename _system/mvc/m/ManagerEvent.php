<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class ManagerEvent {

    const BEFORE_UPDATE = "beforeUpdate";
    const AFTER_UPDATE = "afterUpdate";

    const BEFORE_INSERT = "beforeInsert";
    const AFTER_INSERT = "afterInsert";

    const BEFORE_DELETE = "beforeDelete";
    const AFTER_DELETE = "afterDelete";

    const BEFORE_LINK = "beforeLink";
    const AFTER_LINK = "afterLink";

    private $events = array();

    public static $__id = 0;

    public function __construct( $model ){
	$this->id = self::$__id++;
	$this->model = $model;

    }

    public function getEvents()
    {
	return $this->events;
    }

    public function addEvent( $type , $callback, $args = array() ){

	$this->events[$type]["callback"][] = $callback;
	if( !is_array( $args ) ){
	    $args = array($args);
	}
	$this->events[$type]["args"][] = $args;
    }


    public function dispatchEvent( $type , $args ){
	if( !is_array( $this->events[$type]["callback"] ) ){
	    return;
	}
	if( !is_array( $args ) ){
	    $args = array($args);
	}

	foreach( $this->events[$type]["callback"] as $key => $callback ){
	    $args = array_merge($args, $this->events[$type]["args"][$key]);
	    call_user_func_array( $callback , $args );
	}
    }

}

?>