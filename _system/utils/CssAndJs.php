<?php

/**
 * Content common include settings for css and js.
 *
 * @author David Marsalone
 */
class POV_CssAndJs {
    public static function applyCommonSettings (){
        //modernizer
        JS::addToHeader("pub/libs/modernizr-2.5.3-respond-1.1.0.min.js");
        //jquery
        JS::addAfterBody("pub/libs/jquery-1.7.2.js");
        //bootstrap
        JS::addAfterBody("pub/libs/bootstrap/js/bootstrap.js");

        //vkbeautify (to manage code formating like indentation in xmls)
        JS::addAfterBody("pub/libs/code-prettify/vkbeautify.0.98.01.beta.js"); // bug if compress and minified
        //google code prettify
        JS::addAfterBody("pub/libs/code-prettify/google-code-prettify/prettify.js");
        CSS::addToHeader("pub/libs/code-prettify/google-code-prettify/prettify.css");
        //our class that manage both librairies
        JS::addAfterBody("pub/libs/code-prettify/Prettify.js");
        
        //compile and integrate less files
        $lessVariables=array(
            "phpAppFolder"=>"'".Site::url("pub")."'"
        );
        //get the compiled less file
        $lessFile=Less::getCss("pub/app/Doc",$lessVariables);
        //add the file to header section
        CSS::addToHeader($lessFile);
        
        
        //app...the last one!
        JS::addAfterBody("pub/app/Main.js");
    }
    public static function applyAdminSettings(){
	self::applyCommonSettings();
	
	
	JS::addToHeader("pub/app/admin/api/Config.js");
	

	
	JS::addAfterBody("pub/app/admin/lib/jquery.history.js");
	JS::addAfterBody("pub/app/admin/JQ.js");
	JS::addAfterBody("pub/app/admin/api/Fields.js");
	
	JS::addAfterBody("pub/app/admin/lib/date.js");
	JS::addAfterBody("pub/app/admin/lib/jquery.datePicker.js");
	CSS::addToHeader("pub/app/admin/lib/jquery.datePicker.css");
	JS::addAfterBody("pub/app/admin/api/Fields/Fields.Date.js");
	
	
	
	JS::addAfterBody("pub/app/admin/api/Api.js");
	
	
	JS::addAfterBody("pub/app/admin/Application.js");
	JS::addAfterBody("pub/app/admin/api/Model.js");
	
    }
}
