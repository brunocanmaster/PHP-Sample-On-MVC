<?php
namespace Controller;

class cadastro extends main{
    
    public function __construct() {
        parent::__construct();
        
        if($this->loged){
            
            \functions::header_inicio();
            
        }
        
         \views::load_view('cadastro');
        
    }


    
    public function index(){

        
       
      
        \views::show_view();
        
    }
    
    public function cadastrar(){
        
         $dirtosave = PASTA_ARCHIVES.'/imgs/';
        $filename = 'sma_img';
        
        
       
        $img = new \upload_img($dirtosave, $filename);
        
      
        
        $_POST['sma_img'] = $img->get_img_name();
      
        $keys = POSTS_CADASTRO;
        $toValidate = TO_VALIDATE_CADASTRO;
        $toDB = TO_DB_CADASTRO;
        $post = $_POST;
        $method = 'cadastrar';
      
        $cadastro = new \modelcadastro($keys,$post,$toValidate,$toDB,$method);
     
        
        if(is_array($cadastro->get_errors()) && is_array($img->error)){
            $errors = array_merge($cadastro->get_errors(), $img->error);
        }
        elseif(empty($img->error)){
            
            $errors = $cadastro->get_errors();
         
            
        }
   
        if(empty($cadastro->get_errors())){

            if(empty($img->error)){
             
                $img->redimensionar('300', '300');
                $img->save_img_in_dir();
                
            }
        }

        if(!(empty($errors))){
            
            $padraohtml[0] = 'href="home"';
            $padraohtml[1] = 'href="login"';
            
            
            $dado[0] = 'href="../home"';
            $dado[1] = 'href="../login"';
            
       
            if(isset($errors['nome'])){
                $padraohtml[2] = "<!-- $#ERROR_NOME#$ -->";
                $dado[2] = $errors['nome'];
            }
            if(isset($errors['email'])){
                $padraohtml[3] = "<!-- $#ERROR_EMAIL#$ -->";
                $dado[3] = $errors['email'];
            } 
            if(isset($errors['senha'])){
                $padraohtml[4] = "<!-- $#ERROR_SENHA#$ -->";
                $dado[4] = $errors['senha'];
                
            }
            if(isset($errors['file'])){
                $padraohtml[5] = '<!-- $#ERROR_FOTO#$ -->';
                $dado[5] = $errors['file'];
            }
            
            $padraohtml[6] = 'action="cadastro/cadastrar"';
            $dado[6] = 'action="../cadastro/cadastrar"';
            
           
          
            \views::replace_in_view($padraohtml, $dado);
            \views::show_view();
            
        }
        else{
            
            \functions::header_login();
        }
      
      
  
    
        
    }
    
   
}

