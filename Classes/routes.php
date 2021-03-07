<?php

class routes{
    
    private static $routes = false;
    private static $methods = false;
    
    
    public static function add_route($url,$controller){
        
     
        self::$routes[$url] = $controller;
        
        foreach (self::$routes as $key => $value) {

        }
      
    }
    
    public static function get_routes(){
        
        return self::$routes;
    }
    
    
}

