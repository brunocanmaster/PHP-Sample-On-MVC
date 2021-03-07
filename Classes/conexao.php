<?php


namespace Database;


class conexao{
    
    const hostname = DB_HOST;
    const user_db = DB_USER;
    const password_db = DB_PASSWORD;
    const charset_db = 'utf8';
    const db = DB;
    
    private static $instance;
    public $mysql;
    public $conexao;
    
    
    private function __construct() {
        
        
       
        $this->mysql = new \mysqli;
        $this->mysql->connect(self::hostname, self::user_db, self::password_db, self::db);
        $this->mysql->set_charset(self::charset_db);
        $this->mysql->field_count;
        $this->mysql->affected_rows;
        
    
    
        
    
        
        
    }
    
    
    //Instancia a classe dentro da própria classe e retorna ela mesma, útil para evitar duplicações
    // de conexões
    public static function singleton(){
        
        if(!(isset(self::$instance))){
            
            $conexao = __CLASS__;
            self::$instance = new $conexao;
        }
            return self::$instance;
        
        
    }
    
   /* public function __destruct() {
        
        
        if(method_exists($this->mysql, 'close')){
        $this->mysql->close();    
        }
        
    }
    * */

    
    
    
    
}