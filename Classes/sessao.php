<?php

class sessao{
    



    public static function iniciar_sessao(){
        
        if(session_status() == PHP_SESSION_DISABLED || session_status() == PHP_SESSION_NONE){
            
           
            session_start();
            
           
            
            
        }
        
        
        
    }
    
 
    
    public static function criar_sessao($dados,$key = false,$cookie = false){
        
            if(is_array($dados)){
                
            foreach ($dados as $key => $value) {

                    $_SESSION[$key] = $value;
                    
                    
  
                if($cookie != false && (!(strstr($key, 'id')))){
                    cookies::criar_cookie($key, $value);
                }

            }
         
            return;
        }
        
        
        if($key != false){
        
        $_SESSION["$key"] = $dados;
        
        if($cookie != false){
            
        cookies::criar_cookie($key, $dados);
        }
        
        return;
        }
         
        
        
    }
    
    
    public static function destroir_sessao(){
        
        if(session_status() == PHP_SESSION_ACTIVE || session_status() == PHP_SESSION_NONE){
            
            
            
            session_destroy();
        }
        
    }
    
    public static function limpar_sessao(){
        
        session_unset();
    }
    
    public static function show_sessao(){
        
        
        sessao::iniciar_sessao();
        echo '<br>-------------------------<br>';
        echo 'Sessãos: ';
        if(isset($_SESSION)){
        print_r($_SESSION);
        }
        echo '<br>-------------------------<br>';
       
    }
}

