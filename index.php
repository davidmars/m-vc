<?php

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



