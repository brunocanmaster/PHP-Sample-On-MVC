<?php


class cookies {
    
    
    
    public static function criar_cookie($name,$value){
        
 
        $path = '/';
        $domain = 'mvc_tcc';
        $secure = false;
        $httponly = true;
        setcookie($name, $value, EXPIRE_COOKIE, $path, $domain, $secure, $httponly);
       
    }
    
    public static function destroy_cookies(){
        
        if(isset($_COOKIE['email'],$_COOKIE['senha'])){
            

            unset($_COOKIE['email']);
            unset($_COOKIE['senha']);
            define('email', NULL);
            define('senha', NULL);
            
        }
        unset($_COOKIE);
        
        
    }
    
    public static function get_cookie($key){
        
        if(isset($_COOKIE[$key])){
        return $_COOKIE[$key];
        }
        else{
            
            return null;
        }
        
    }
    
    public static function show_cookies(){
        
        foreach ($_COOKIE as $key => $value){
            
            echo "<br> COOKIE [".$key."] = ".$value;
        }
     
    }
}
