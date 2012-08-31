<?
//include the stuff
require_once("ee09/php/includes.php");
Site::$root=("/some-design");
//the url from .htacces
$url=$_REQUEST["url"];
$urlControler=new UrlControler($url);
$startView=$urlControler->getView();

//header('Content-Type: text/html; charset=utf-8');
echo $startView->run($urlControler->context);

