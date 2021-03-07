<?php
namespace Controller;

class Admin extends main{
    
    
    
    public function __construct() {
       
        parent::__construct();
        
        if($this->loged){
            
            \views::load_view('admin');
            $this->content->content_admin_construct();
        
            
        }
        else{
            
            \functions::header_login();
        }
        

        
        
        
        
        
    }
    
    public function index(){
        
        if($this->loged){
            
            \views::show_view();
        }
   
    }

    
    public function add_ep(){
       
        $this->content->content_admin_addep();
        \views::show_view();
  
    }
  
    
    public function add_sma(){
        
      
        $this->content->content_admin_addsma();
        \views::show_view();
        
        
  
    }
    
    
      
    public function buscar_legenda(){
        
        $this->content->content_admin_buscarlegenda();
        \views::show_view();
       
        
    }
    
    public function excluir_legenda(){
        
        $this->content->content_admin_excluirlegenda();
        \views::show_view();
        
    
    }
  
}
