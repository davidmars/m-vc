<?php
/**
 * here you configure your routes... routes are a way to beautify url but your should read the doc if you didn't know.
 * the key is a regexp, the value is the internal route to the controller. 
 */
UrlControler::$routes=array(   
        //documentation
        "pub/media/cache/img/(:any)"=>"imageTools/$1",
        "documentation"=>"doc/doc/index/overview",
        "documentation/"=>"doc/doc/index/overview",
        "documentation/(:any)"=>"doc/doc/index/$1",
        
        //home
        "page/(:any)/(:any)"=>"home/index/$1/$2",
        "page/(:any)"=>"home/index/$1",
        
        ""=>"home/index",
        "(.*)"=>"err404/index/$1",
        
        
        //okay its not managed...
);