<?php

/**
 * Description of home
 *
 * @author david marsalone
 */
class ImageToolsController extends Controller {
    
    	public function sized()
	{
            ImageTools::$doTheJob=true;
            $params=func_get_args();
            Human::log($params);
            $img=ImageTools::processUrl("sized", $params,$this->extension);
            //ImageTools::output($img);
            
	}
    	
}

