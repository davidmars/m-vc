<?php
require_once '_system/Site.php'; //by default it should works, if you change the _system folder location, you will have to change this line.
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


Site::$host="http://david.de.shic.cc";
Site::$root="/m-vc";
Site::$redirectToBestUrl=true;

//remove this comment to debug your config.
//die(Boot::testConfig());


Boot::theSystem();



