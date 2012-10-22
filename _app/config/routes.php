<?php
/**
 * Here you configure your routes... routes are a way to beautify url but you should read the doc if you didn't know.
 * The key is a regexp, the value is the internal route to the controller. 
 */
UrlControler::$routes=array(   
        //documentation
       
        "documentation"=>"doc/doc/index/overview",
        "documentation/"=>"doc/doc/index/overview",
	"documentation/class/(:any)"=>"doc/doc/classDefinition/$1",
        "documentation/(:any)"=>"doc/doc/index/$1",
        
    //"car/[[:alnum:]/]*/(.*)"=>"lolo/index/$1",
         
	
	
	"pressroom/category/post/(:any)"=>"press/categoryPost/$1",
	"pressroom/downloads/(:any)"=>"press/categoryMedia/$1",
	"pressroom/post/(:any)"=>"press/post/$1",
    
        //home
        "page/(:any)/(:any)"=>"home/index/$1/$2",
        "page/(:any)"=>"home/index/$1",
         
        ""=>"home/index",
        "(.*)"=>"err404/index/$1"
        
        
        //okay its not managed...
);