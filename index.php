<?php

error_reporting(E_ALL ^ E_NOTICE);
error_reporting(E_COMPILE_ERROR|E_RECOVERABLE_ERROR|E_ERROR|E_CORE_ERROR);

require_once '_system/Boot.php'; // the same...

/*
 * 
 * 
 * here you configure your directories if needed
 * 
 * 
 */

//Site::$appFolder="tests/appFolder";
//Site::$mediaFolder="this/folder/is/777";


/*
 * 
 * Here you configure site public URLs if needed
 * 
 */

/*
Site::$host="http://david.de.shic.cc";

Site::$redirectToBestUrl=true;
*/



//remove this comment to debug your config.
//die(Boot::testConfig());


Boot::theSystem();



