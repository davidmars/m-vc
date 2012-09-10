<?php
/**
 * Here you configure your routes... routes are a way to beautify url but you should read the doc if you didn't know.
 * The key is a regexp, the value is the internal route to the controller. 
 */
UrlControler::$routes=array(   
        //documentation
       
        "documentation"=>"doc/doc/index/overview",
        "documentation/"=>"doc/doc/index/overview",
        "documentation/(:any)"=>"doc/doc/index/$1",
        
        //home
        "page/(:any)/(:any)"=>"home/index/$1/$2",
        "page/(:any)"=>"home/index/$1",
        
        ""=>"home/index",
        "(.*)"=>"err404/index/$1"
        
        
        //okay its not managed...
);