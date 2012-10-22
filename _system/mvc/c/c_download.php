<?php

/**
 * This controller will manage the images maniplulation process flow.
 * Most of time when you will run a function in this controller, it will result an image. 
 * Later, beacause the image was crated, you will no more run this controller, and you will no more run php in fact.
 * 
 *
 * @author david marsalone
 */
class C_Download extends Controller {
        /**
         * This contoller function refers to ImageTools::sized function
         */
    	public static function download($file,$returnUrl=false)
	{
	    if($returnUrl){
	       $c = new C_Download();
	       return $c->url(); 
	    }
	    //replace zzzzz by / to get file name
	    //headerblabla....
		    
	    }
    	
}

