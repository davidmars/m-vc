<?php

/**
 * This controller will manage the images maniplulation process flow.
 * Most of time when you will run a function in this controller, it will result an image. 
 * Later, beacause the image was crated, you will no more run this controller, and you will no more run php in fact.
 * 
 *
 * @author david marsalone
 */
class C_Img extends Controller {
        /**
         * This contoller function refers to ImageTools::sized function
         */
    	public static function sized()
	{
            
            ImageTools::$doTheJob=true;
            $params=func_get_args();
            
            $img=ImageTools::processUrl("sized", $params,"png");
            
             ImageTools::output($img);
            //die("toto".$img);
	}
    	
}

