<?php
namespace Controller;

class login extends main{
    
    
  public function __construct() {
      parent::__construct();
 
      if($this->loged){
          
          \functions::header_inicio();

      }

      \views::load_view('login');
      \views::replace_in_view('$#title#$', 'Login | Legendaz');
      
      

 
  }
  
  public function index(){

        \views::show_view();
          
  
  }
  
  public function logar(){
      
   
      
      $keys = POSTS_LOGIN;
      $post = $_POST;
      $toValidate = TO_VALIDATE_LOGIN;
      $toDB = TO_DB_LOGIN;
      $method = 'logar';
      $logar = new \modelcadastro($keys, $post, $toValidate, $toDB, $method);
      $errors = $logar->get_errors();
  
      if(!(empty($errors))){

          $padraohtml[0] = '$#title#$';
          $padraohtml[1] = 'action="login/logar"';
          $padraohtml[3] = 'href="home"';
          
          $dado[0] = 'Legendaz | Login';
          $dado[1] = 'action="../login/logar"';
          $dado[3] = 'href="../home"';

          if(isset($errors['email'])){
          $padraohtml[4] = '<!-- $#ERROR_EMAIL#$ -->';
          $dado[4] = $errors['email'];
          }
          if(isset($errors['senha'])){
          $padraohtml[5] = '<!-- $#ERROR_SENHA#$ -->';
          $dado[5] = $errors['senha'];
          }
          
          $padraohtml[6] = 'href="cadastro"';
          $dado[6] = 'href="../cadastro"';

         
          \views::replace_in_view($padraohtml,$dado);
          \views::show_view();
          
          
      }
      else{
          
          \functions::header_inicio();
      }
      
    
  }
    
}

