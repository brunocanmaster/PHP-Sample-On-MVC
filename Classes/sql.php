<?php
namespace Database;

class sql{
    
    private $conexao;
    private $mysql;
    private $query;
  
    
    public function __construct() {
        
        
        $this->mysql = conexao::singleton()->mysql;
     
        
       
        
       
      
 
    }
    
    
    public function get_affected_rows(){
        
         return $this->mysql->affected_rows;
    }
    
    public function get_field_count(){
        
        return $this->mysql->field_count;
    }

    
    public function get_error_list(){
        

        return $this->mysql->error_list;
        
    }
    
    public function get_error(){
        
        return $this->mysql->error;
    }
    
    public function get_errno(){
        

        return $this->mysql->errno;
    }
  
    public function get_link(){
        
        
        
    }
    
    // Query simples, útil para comandos tipo INSERT / DROP / UPDATE
    public function query($query){
       
        
        $query = $this->mysql->query($query);
        
        
        return $query;
        
 
    }
    
    public function query_fetch_assoc($query){
        
        $query = $this->mysql->query($query);
        $r = $query->fetch_assoc();
        
        return $r;
    }

    public function query_fetch_all($query){

       $query = $this->mysql->query($query);

       for($r = array(); $tmp = $query->fetch_array(MYSQLI_ASSOC);)
       $r[] = $tmp;

       return $r;

    }
    
    public function query_consulta_login($query){
        
        if($sql = $this->mysql->prepare($query)){
            
            if($sql->execute()){
                
               
                if($sql->bind_result($id,$nome,$email,$senha,$img)){
             
                $r = array();
                while ($sql->fetch()) {
                    
                    $r[0] = $id;
                    $r[1] = $nome;
                    $r[2] = $email;
                    $r[3] = $senha;
                    $r[4] = $img;
                }
                
                
                return $r;
                }
               
                
                
            }
            
        }
        
        
    }
    
    public function escape_string($string_to_escape){
        
        return $this->mysql->escape_string($string_to_escape);
    }
 
    public function prepare_values($values = array()) {
        
       
        foreach ($values as $key => $value) {
            
            $value = $this->mysql->escape_string($value);
            $value = htmlentities($value);
        }
        
        return $values;
    }
    

  
    
  
}
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

						