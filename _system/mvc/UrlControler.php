<?php

/**
 * This class is used to convert an url into a route, later the route will be used by the Controler.
 *
 * @author David Marsalone
 */
class UrlControler {
    
    /**
     *
     * @var array the key is a regexp, the value is the internal route to the controller.
     */
    public static $routes=array();
    
    
    private static $systemRoutes=array(
         "pub/media/cache/img/(:any)"=>"imageTools/$1"
    );
    /**
     *
     * @var array reversed routes to get optimized urls. This array is automatically filed by reverseRoutes() function. 
     */
    private static $routesReversed;
    /**
     *
     * @param string $url search if a route match with the $url
     * @return string an url, this url will be an optimized on if it match, elsewhere it will return the same url you give as parameter.
     */
    public static function getRoute($url){
        //merge $systemRoutes & $routes
        while(count(self::$systemRoutes)>0){
             $r=array_pop(self::$systemRoutes);
             array_unshift(self::$routes, $r);
        }
        foreach(self::$routes as $k=>$v){
            Human::log($k."---->".$v, "Test route");
            // Convert wild-cards to RegEx
            $k = str_replace(':any', '.+', str_replace(':num', '[0-9]+', $k));
            if(preg_match('#^'.$k.'$#', $url)){
                Human::log("route match! ".$v, "Rouuuuuuuuuuuuute found");
                $route=preg_replace('#^'.$k.'$#', $v, $url);
                return $route;
            }
        }
        return $url;
    }
    /**
     *
     * @param string $url a route
     * @return string a route optimized by $routes regexps
     */
    public static function getOptimizedUrl($url){
        
        // Loop through routes to check for back-references
        $revRoutes = self::reverseRoutes(self::$routes);
        foreach ($revRoutes as $route) {
            if (preg_match($route['uri_pattern'], $url)) {
                $rewritten = preg_replace($route['uri_pattern'], $route['rewritten'], $url);
                return $rewritten;
            }
        }
        return $url; 
    }
    
    
    /**
     * Retrieve reverse routes
     * @author mostly inspired by mattalexx http://codeigniter.com/forums/viewthread/167693/
     * @return    array
     */
    private static function reverseRoutes()
    {
        if(self::$routesReversed){
            return self::$routesReversed;
        }

        // Get config routes
        $config_routes=  self::$routes;

        // Loop through routes to check for back-references
        $routes = array();
        foreach ($config_routes as $route_pattern => $route_destination) {

            // Every non-literal piece of regex needs to be within a backreference because the
            // parentheses themselves are used to find the regex parts.
            // So just add it straight to the array for literal matching.
            if (preg_match('/[^\(][.+?{\:]/', $route_pattern)
                || strpos($route_pattern, '(') === FALSE
                || strpos($route_destination, '$') === FALSE
                ) {
                $routes[] = array(
                    'uri_pattern' => '#^'.$route_destination.'$#',
                    'rewritten' => $route_pattern,
                    );
                continue;
            }
            
            $route_pattern = str_replace(array(':any', ':num'), array('.+?', '[0-9]+'), $route_pattern);
            
            // Find all back-references in route pattern
            preg_match_all('/(\(.+?\))/', $route_pattern, $matches);
            $route_pattern_backreferences = array();
            foreach ($matches[1] as $i => $match) {
                $n = $i + 1;
                $route_pattern_backreferences[$n] = $match;
            }

            // Find all references in route destination
            // Also, create an array that keeps the order of references
            preg_match_all('/\$(\d+?)/', $route_destination, $matches);
            $route_destination_references = array();
            $reference_order = array();
            foreach ($matches[1] as $n) {
                $route_destination_references[$n] = '$'.$n;
                $reference_order[] = $n;
            }
            asort($route_destination_references);
            
            // Create a rewritten URL for use as the second paramater of preg_replace
            $rewritten = $route_pattern;
            foreach ($reference_order as $n) {
                $rewritten = preg_replace('/(\(.+?\))/', '\\'.$route_destination_references[$n], $rewritten, 1);
            }
            
            $uri_pattern = $route_destination;
            foreach ($route_destination_references as $n => $reference) {
                if (isset($route_pattern_backreferences[$n])) {
                    $uri_pattern = str_replace($reference, $route_pattern_backreferences[$n], $uri_pattern);
                }
            }
            $uri_pattern = '#^'.$uri_pattern.'$#';
            
            $routes[] = array(
                'uri_pattern' => $uri_pattern,
                'rewritten' => $rewritten,
                );
        }
        self::$routesReversed=$routes;
        return $routes;
    }
    
    
}
