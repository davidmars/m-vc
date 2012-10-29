<?php

/**
 * Content common include settings for css and js.
 *
 * @author David Marsalone
 */
class POV_CssAndJs {
    

    /**
     * the minimal libs...need to add a Main javascript file and a main Less file after.
     */
    public static function applyCommonSettings (){
        //modernizer
        JS::addToHeader("pub/libs/modernizr-2.5.3-respond-1.1.0.min.js");
        //jquery
        JS::addAfterBody("pub/libs/jquery-1.7.2.js");
        JS::addAfterBody("pub/libs/jquery.history.js");
        //bootstrap
        JS::addAfterBody("pub/libs/bootstrap/js/bootstrap.js");

        JS::addAfterBody("pub/tools/EventDispatcher.js");

    }
    /**
     * Final setting for documentation 
     */
    public static function docSettings(){
        
        self::applyCommonSettings();
   
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
    /**
     * Settings for admin, need to be added
     * @param bool $final si true, incluera les fichiers de base
     */
    public static function adminSettings($final=true){
        
        if($final){
        self::applyCommonSettings();
        }

	JS::addToHeader("pub/app/admin/api/Config.js");
	

	JS::addAfterBody("pub/app/admin/JQ.js");
	
    JS::addAfterBody("pub/app/admin/utils/Utils.js");
        
        
        
	JS::addAfterBody("pub/app/admin/api/Fields.js");

    //dates
	JS::addAfterBody("pub/app/admin/lib/date.js");
	JS::addAfterBody("pub/app/admin/lib/jquery.datePicker.js");
	CSS::addToHeader("pub/app/admin/lib/jquery.datePicker.css");
	JS::addAfterBody("pub/app/admin/api/Fields/Fields.Date.js");
	JS::addAfterBody("pub/app/admin/api/Fields/Fields.Assoc.js");
	JS::addAfterBody("pub/app/admin/api/LoginForm.js");

	JS::addAfterBody("pub/app/admin/api/Fields/Fields.Text.js");
	JS::addAfterBody("pub/app/admin/api/Fields/Fields.File.js");
	
	JS::addAfterBody("pub/app/admin/api/Api.js");
	JS::addAfterBody("pub/app/admin/api/Model.js");
        
	JS::addAfterBody("pub/app/admin/api/ModalsManager.js");
	JS::addAfterBody("pub/app/admin/api/ModelBrowser.js");
        
	JS::addAfterBody("pub/app/admin/Application.js");
	
        
        //---------boot------------
        
        //compile and integrate less files
        $lessVariables=array(
            "phpAppFolder"=>"'".Site::url("pub")."'"
        );
        //get the compiled less file
        $lessFile=Less::getCss("pub/app/admin/Admin",$lessVariables);
        //add the file to header section
        CSS::addToHeader($lessFile);
        
        //app...the last one!
        //JS::addAfterBody("pub/app/Main.js");
        
        
	
    }
}
