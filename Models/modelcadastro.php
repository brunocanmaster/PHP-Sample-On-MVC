<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of cadastro
 *
 * @author alunos.senai
 */


class modelcadastro{
    
   private $keys;
   private $post;
   private $toValidate;
   private $toDB;
   private $queryCreated;
   private $errors;
   private $conexao;
    
    public function __construct($keys,$post,$toValidate,$toDB,$method) {
        
        
        
        $this->keys = $keys;
        $this->post = $post;
        $this->toValidate = $toValidate;
        $this->toDB = $toDB;
        
        $this->conexao = new Database\sql();

        if($method != 'excluir_legenda'){
            
            $this->explode_vars();
        }
     
        
        if($this->unifica_posts()){
        
        if($this->toValidate != false){  
        $this->loop_validation();
        }
   
        if((empty($this->errors))){

        $this->create_query();
        
        switch ($method) {
            
            case 'cadastrar':
                
                $this->cadastrar();
                break;

            case 'logar':
                
                $this->logar();
                break;
            
            case 'add_sma':
                
                $this->add_sma();
                break;
            
            case 'add_ep';
                
                $this->add_ep();
                break;
            
            case 'add_temp':
                
                $this->add_temp();
                break;
            
            case 'buscar_legenda':
                
                $this->buscar_legenda();
                break;
            
            case 'excluir_legenda':
                
                $this->excluir_legenda();
                break;
        }

        }
        }
        else{
            
            $this->errors['post'] = 'Não recebemos os campos esperados.';
           
        }
       


        
        
        

        
      
    
        
    }
    
    public function get_errors(){
        
        return $this->errors;
        
    }
    
    public function get_columns(){
        
        return $this->queryCreated['columns'];
    }
    
    public function get_values(){
        
        return $this->queryCreated['values'];
    }

     private function explode_vars(){
         
         if(strstr($this->keys, '.')){
         $this->keys = explode('.', $this->keys);
         }
         if(strstr($this->toValidate, '.')){
             $this->toValidate = explode('.', $this->toValidate);
         }
         if(strstr($this->toDB, '.')){
             
             $this->toDB = explode('.', $this->toDB);
         }
      
     }
     
     private function unifica_posts(){
       
        
       
        
         
         
            if(is_array($this->keys)){
            $countpost = count($this->post);
    
            
          
             $i = 0;
             $i2 = 0;

             foreach ($this->keys as $key => $value) {
                 
           
                 if(isset($this->post[$value])){
                     $i++;
                     
                 }
                 
                 elseif(strstr($value, POSTS_EXCEPTION_LOGIN)){
                     $i++;
                     $i2++;
                 }
                 
           
              
                 
             }
         
             
             
             if(($countpost+$i2) == $i){
                 
                 
                 return true;
                 
             }
          
             
       
             return false;
        
            }
            else{
                
               
                if(isset($this->post[$this->keys])){
               
                    return true;
                    
                }
                return false;
                
            }
   
   
     }
     
     private function create_query(){
         
         $this->queryCreated['columns'] = '';
         $this->queryCreated['values'] = '';
         
         if(is_array($this->toDB)){
         $count = count($this->toDB);
         $i = 0;
         foreach ($this->toDB as $key => $value) {
         
             $i++;
             
             $x = $this->post[$value];
             $this->queryCreated['columns'] .= $value;
             $this->queryCreated['values'] .= "'$x'";
         
             if($i < $count){
             
             
                 $this->queryCreated['columns'] .= ',';
                 $this->queryCreated['values'] .= ',';
         
             
             }
             
         }
         }
         else{
             
             $this->queryCreated['columns'] = $this->toDB;
             $value = $this->post[$this->toDB];
             $this->queryCreated['values'] = "'$value'";
           
         }
    
         
     }
   
     private function loop_validation(){
         
         $validation = new validation();
         
         
         if(is_array($this->toValidate)){
         foreach ($this->toValidate as $key => $value) {
             
            
             $methodname = 'is_'.$value;
                  
                if(isset($this->post[$value])){
                 $validation->set_toValidate($this->post[$value]);
                }
                 if(method_exists($validation, $methodname )){
                   
                     if($validation->is_empty() != false){
                         
                        if($validation->$methodname() != false){
                         
                         
                            
                            $this->post[$value] = $validation->get_toValidate();
                         
                         
                        }
                        else{
                            
                           
                           
                            $this->errors[$value] = $validation->get_toValidate();
                            
                        }
                    }
                    else{
                        
                        $this->errors[$value] = $validation->get_toValidate();
                    }
                     
                     
                     
                 }
                 else{
                     
                     
                     $this->errors[$value] = 'Impossível efetuar validação para '.$value;
                     
                 }
                 
                 
             
             
         }
         }
         else{
             
            $methodname = 'is_'.$this->toValidate;
            $validation->set_toValidate($this->toValidate);
            
            if(method_exists($validation, $methodname)){
                
                if($validation->is_empty() != false){
                    
                    if($validation->$methodname() != false){
                        
                        $this->post[$this->toValidate] = $validation->get_toValidate();
                    }
                    else{
                        
                        $this->errors[$this->toValidate] = $validation->get_toValidate();
                    }
                    
                    
                }
                else{
                    
                    
                    $this->errors[$this->toValidate] = $validation->get_toValidate();
                }
            }
            
            
            
         }
         
         
     }
  
     
     private function cadastrar(){
     
        
         if(empty($this->errors)){
             
          
             
        
         $query = "INSERT INTO usuarios (".  $this->queryCreated['columns'].") VALUES (".  
         $this->queryCreated['values'].")";

         

         $this->conexao->query($query);

         if(!(empty($this->conexao->get_error()))){

            $this->errors['email'] = errormap::errno_querys($this->conexao->get_errno(), 'email_cadastro');  
         }
   
         }
    
         
        
         
         
     }
     
     private function logar(){
         
        
         $query = "SELECT id_usuarios,nome,email,senha,sma_img FROM usuarios WHERE email='".
         $this->post['email']."'";
         
 
        $r = $this->conexao->query_consulta_login($query);
        if(!(empty($this->conexao->get_error()))){
         $this->errors['email'] = errormap::errno_querys($this->conexao->get_errno(), 'email');
        }
         
        $r2 = 0;

        if(isset($r[2]) && $r[2] == $this->post['email']){
            $r2++;
        }
        else{
            
            $this->errors['email'] = errormap::email_invalido;
        }
        
        if(isset($r[3]) && $r[3] == $this->post['senha']){
            
            $r2++;
        }
        else{
            
            $this->errors['senha'] = errormap::senha_invalido;
        }
        
        if($r2 == 2){
            
            $dados['id_user'] = $r[0];
            $dados['nome'] = $r[1];
            $dados['email'] = $r[2];
            $dados['senha'] = $r[3];
            $dados['sma_img'] = $r[4];
          
            if(isset($_POST['auto_login'])){
                $cookie = true;
            }
            else{
                
                $cookie = false;
            }
            sessao::criar_sessao($dados,$key = false, $cookie);
         

        }
       
        
     
            
      
         
     }
     
     private function add_sma(){
         
         
         $query = "INSERT INTO sma(".$this->queryCreated['columns'].") VALUES (".
         $this->queryCreated['values'].")";


         $errno = $this->conexao->get_errno();

         $r = $this->conexao->query($query);
         if(!(empty($this->conexao->get_error()))){
         $this->errors['sma_name'] = errormap::errno_querys($this->conexao->get_errno(), 'sma');
         }
       
         
         

         
         
     }
  
     
     private function add_ep(){
        
         
         $smaname = $_POST['sma_name'];
         $smaep = $_POST['sma_ep'];
         $smatemp = $_POST['sma_temp'];
         
         
         $r_id_sma = $this->conexao->query_fetch_assoc("SELECT id_sma FROM sma WHERE sma_name='$smaname'");
         $id_sma = $r_id_sma['id_sma'];
         
         if(empty($r_id_sma) || !(empty($this->conexao->get_error()))){
             
             $this->errors['sma_name'] = errormap::sma_nao_cadastrado;
         }
         
         $r_sma_ep = $this->conexao->query_fetch_assoc("SELECT ep,temp FROM sma_ep WHERE ep='$smaep' AND temp='$smatemp' AND id_sma='$id_sma'");
    
         
         if(isset($r_sma_ep['temp'],$r_sma_ep['ep']) && $r_sma_ep['temp'] == $smatemp && $r_sma_ep['ep'] == $smaep){
             
             
             $this->errors['sma_temp'] = errormap::sma_existente_temp_ep;
             
         }
         
         if(empty($this->errors)){
             
             

             $query = "INSERT INTO sma_ep (id_sma,temp,ep,name_ep,name_legenda) VALUES ("."'$id_sma'".",".$this->queryCreated['values'].")";
             $result = $this->conexao->query($query);
             
             $idusuarios = $_SESSION['id_user'];
             $query2 = "INSERT INTO interacao(id_sma,id_usuarios) VALUES("."'$id_sma'".",'$idusuarios')";
             $result2 = $this->conexao->query($query2);
             
             if(!(empty($this->conexao->get_errno()))){
                 $this->errors['sma_ep_name'] = errormap::errno_querys($this->conexao->get_errno(), 'sma_ep');
                 
             }
         }

     }
     
        
     private function buscar_legenda(){
        
         $smaname = $_POST['sma_name'];
         $query = "SELECT "
                 . " sma_ep.id_sma_ep,sma.sma_name,sma_ep.name_ep,sma_ep.ep,sma_ep.temp,sma_ep.name_legenda FROM sma,sma_ep WHERE sma.id_sma = "
                 . "(SELECT sma.id_sma FROM sma WHERE sma.sma_name='$smaname' AND sma_ep.id_sma = sma.id_sma)  ORDER BY sma_ep.temp,sma_ep.ep";
         
         
         
         $r = $this->conexao->query_fetch_all($query);
         
         if(empty($r)){
             
             $this->errors['sma_name'] = errormap::sma_nao_cadastrado_ep_temp;
         }
 
         $this->toDB = $r;
         
        
     }
     
     private function excluir_legenda(){
         

         
         /* $pasta = 'archives/legendas/';
         if(is_dir($pasta)){
             
           
             $dir = dir('archives/legendas/');
             $arquivo = $dir->read();
             
             print_r($arquivo);
    
             while($arquivo = $dir->read()){
                 
                 echo '<br>';
                 
                 echo '<br> Arquivo: '.print_r($arquivo).'<br>';
                 print_r($dir);
                 echo 'teste';
             }
             
         }
         
         echo '<br>';
         print_r($dir);
           echo '<br>--------------------------------------------------------------------------<br><br>';
          * 
          */

         $query = "DELETE FROM sma_ep WHERE id_sma_ep in (".$this->queryCreated['values'].")";
        
         
         $r = $this->conexao->query($query);
         
         
        if(!(empty($this->conexao->get_error()))){
             
             $this->errors['sma_name'] = 'Selecione um SMA para excluir!';
         }
         

         
         
         
  
         
         
      
         
        
     
         
     }
     
     
     public function get_db_r(){
         
         return $this->toDB;
     }

     
     private function show_vars() {
         
         echo '<br><br> SESSIONS: ';
         sessao::iniciar_sessao();
        print_r($_SESSION);
        echo '<Br><br> ERRORS: ';
        print_r($this->errors);
        echo '<br><br> POSTS: ';
        print_r($this->post);
     }
     
    
     
    
    
    
    
}
