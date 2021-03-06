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


        //generic admin
        "admin"=>"admin/admin_model/listModels/M_post",

        "login"=>"press/login",
        "logout"=>"press/logout",
        "pressroom/category/post/(:num)/(:num)"=>"press/categoryPost/$1/$2",
        "pressroom/downloads/(:num)/(:num)"=>"press/categoryMedia/$1/$2",
        "pressroom/post/(:any)"=>"press/post/$1",
        "pressroom/media/(:any)/(:any)/(:any)/(:any)"=>"press/mediaAll/$1/$2/$3/$4",

        ""=>"press/index",
         

        "(.*)"=>"err404/index/$1"
        
        
        //okay its not managed...
);