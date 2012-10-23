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
         *
         * @param FileField $file
         * @param bool $returnUrl
         * @return mixed
         */
    	public static function download($file,$returnUrl=false)
	{
	    if($returnUrl){
	       $c = new C_Download();
	       return $c->url(); 
	    }
            
	    //header to download
            $name = basename($file->fileName());            
            if($file)
            {
                $filePath = $file->val();

                if (file_exists($filePath))
                {
                    $size = filesize($filePath);
                    header("Content-Type: application/force-download; name=\"" . $name . "\"");
                    header("Content-Transfer-Encoding: binary");
                    header("Content-Length: $size");
                    header("Content-Disposition: attachment; filename=\"" . $name . "\"");
                    header("Expires: 0");
                    header("Cache-Control: no-cache, must-revalidate");
                    header("Pragma: no-cache");
                    readfile($filePath);
                    exit();
                }
            }
            die();		    
        }
    	
}

