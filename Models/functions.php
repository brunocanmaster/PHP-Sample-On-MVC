<?php

class functions{
    
    
    // Checka a key no array e devolve o valor da mesma key.
    public static function check_array_key_and_return($array,$key){
        
        if((isset($array[$key])) && (!(empty($array[$key])))){
            
            return $array[$key];
            
        }
        
        return null;
    }
    
    
    
    public static function header_inicio(){
        
        $host = $_SERVER['HTTP_HOST'];
        $uri = rtrim(dirname($_SERVER['PHP_SELF']),'/\\');
        header("Location: http://$host$uri");
    }
    
    public static function header_home_or_sma(){
        
        
    }
    
    public static function header_request(){
        
        $request = '/mvc_tcc/'.$_REQUEST['path']; 
        header("Location: http://$request");
    }
    
    public static function header_login(){
        
        $host = $_SERVER['HTTP_HOST'];
        $uri = '/mvc_tcc/login';
        header("Location: http://$host$uri");
    }
    
    
}

