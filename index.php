<?php

require_once '_system/Controler.php';
require_once '_system/View.php';
require_once '_system/ViewVariables.php';

require_once '_system/libs/ChromePhp.php';
require_once '_system/utils/Human.php';

require_once '_app/mvc/view-variables/HelloVariables.php';
require_once '_app/mvc/view-variables/LayoutVariables.php';

//search for the correct controller, function and params
Human::log($_REQUEST["route"],"At the begining it was the route param");
$route=$_REQUEST["route"];
$controller=Controler::getByRoute($route);

Human::log($controller->routeParams);
$output=call_user_func_array(array($controller,$controller->routeFunction), $controller->routeParams);

if($output){
    echo $output;    
}else{
    echo "error";
}
