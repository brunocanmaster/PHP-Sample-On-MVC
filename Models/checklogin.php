<?php



class checklogin{
 
    private $tocheck;
    private $tip;
    public $r = false;
  

    public function __construct() {
       

        $this->seta_dados();
        if(!(empty($this->tocheck['email'])) && !(empty($this->tocheck['senha']))){
            
            
            $conexao = new Database\sql();
            $query = "SELECT id_usuarios,nome,email,senha,sma_img FROM usuarios WHERE email='".
            $this->tocheck['email']."'";
            
            $r = $conexao->query_consulta_login($query) or die($r = $conexao->get_error());
    
            switch ($this->tip) {
                case 'cookie':
           
                    $r[2] = $r[2];
                    $r[3] = $r[3];

                    break;

                
                case 'session': 
                   
                default:
                    
                 
                    break;
            }

            if($this->tocheck['email'] == $r[2] && $this->tocheck['senha'] == $r[3]){
  
       
                $this->r = true;
                
              
                
            }
           
            
            
            
            
        }
    }
    
    private function seta_dados()
    {
        
       
        $this->tocheck['email'] = null;
        $this->tocheck['senha'] = null;
        $this->tip = null;
        
       
        $emailcookie = cookies::get_cookie('email');
        $senhacookie = cookies::get_cookie('senha');
       
   
        
        if(isset($emailcookie,$senhacookie) && !(empty($emailcookie)) && !(empty($senhacookie))){
            
      
            $this->tocheck['email'] = $_COOKIE['email'];
            $this->tocheck['senha'] = $_COOKIE['senha'];
            $this->tip = 'cookie';
            
        
        }
        else{
            
            sessao::iniciar_sessao();
            if(isset($_SESSION['email'],$_SESSION['senha'])){
           
                unset($_COOKIE);
                $this->tocheck['email'] = $_SESSION['email'];
                $this->tocheck['senha'] = $_SESSION['senha'];
                $this->tip = 'session';
     
            }
            
        }
        
    }
    
  
    
   
    
    
    
}

