<?php

namespace Controller;

class home extends main{
    
  
    
    public function __construct() {
 
        
   
       parent::__construct();
       \views::load_view('home_html');
     
       
       if($this->loged){
           
           \views::cut_in_view('login');
           
           $img = ' src="/mvc_tcc/archives/imgs/'.$_SESSION['sma_img'].' " />';
           $padraohtml[0] = '<!-- #$IMG$# -->';
           $dado[0] = '<img id="img_login_late"'.$img;
           
           if(isset($_SESSION['nome'])){
           $padraohtml[1] = '<!-- #$NAME$# -->';
           $dado[1] = substr($_SESSION['nome'], 0, 5);
           }
           
           \views::replace_in_view($padraohtml, $dado);
       }
       else{
           
           \views::cut_in_view('login_late');
       }
       
       
       
       
    }
    

    public function index() {
     
        
        \sessao::iniciar_sessao();
        if(!(isset($_SESSION['page']))){
            $_SESSION['page'] = 1;
        }
        
       
        $this->content->content_home_index(1);
        \views::cut_in_view('politicadeprivacidade');
        \views::show_view();
       
      

        
    }
    
    public function page(){
        
        
        
        $args = func_get_args();
        
        if(isset($args[0][0]) && !(is_null($args[0][0]))){
        $this->content->content_home_index($args[0][0]);
        }
        
        \sessao::iniciar_sessao();
        $_SESSION['page'] = 1;
        
        \views::cut_in_view('politicadeprivacidade');
        \views::show_view();
        
        
    }
    
    public function busca(){
        
       
        $busca = (isset($_POST['busca'])) ? $busca = $_POST['busca'] : $busca = null;
        $this->content->content_home_busca($busca);
        \views::cut_in_view('politicadeprivacidade');
        \views::show_view();
        
        
    }
    
    public function termos(){
        
        $this->content->content_home_termos();
        \views::cut_in_view('politicadeprivacidade');
        \views::show_view();
    }
    
    public function politicadeprivacidade(){
        
        $this->content->content_home_politicadeprivacidade();
        \views::cut_in_view('ajuda');
        \views::show_view();
    }
    
    
    public function meusfavoritos(){
     
        
        
        if($this->loged){
        if(isset($_SESSION['page'])){
            
            $page = ($_SESSION != null)? $_SESSION['page']: 1;
        }
        $args = func_get_args();
        if(!(isset($args)) || !(isset($args[0][0]))){

            $args[0][0] = $page;
        }
        
       
        $this->content->content_home_meusfavoritos();
        $this->content->content_home_index($args[0][0],true);
        \views::cut_in_view('politicadeprivacidade');
        \views::replace_in_view('Todos os destaques', 'Meus Favoritos');
        \views::show_view();
        }
        else{
            
            \functions::header_inicio();
        }
    }
 
    
    
  
}

