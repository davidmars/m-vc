<?php
require_once '_system/Site.php';
require_once '_system/Boot.php';

/*
 * 
 * Here you configure site if needed
 * 
 */

Site::$host="http://david.de.shic.cc";
Site::$root="/m-vc";

Boot::theSystem();


//search for the correct controller, function and params
Human::log($_REQUEST["route"],"At the begining it was the route param");


$route=$_REQUEST["route"];
$controller=Controler::getByRoute($route);

Human::log($controller->routeParams);
$view=$controller->run();


if($view){
    switch ($controller->outputType){
        case Controler::OUTPUT_JSON:
            header('Content-type: application/json');
            echo $view->viewVariables->json();
            break;
        case Controler::OUTPUT_XML:
            header("Content-type: text/xml; charset=utf-8"); 
            echo $view->viewVariables->xml();
            break;
        default :
            echo $view->render();
            break;
    }  
}else{
    echo "error in index";
}
