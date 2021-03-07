<?php


namespace Controller;

class main{
    
   

    protected $loged = false;
    protected $content;

    
   
    protected function __construct() {
        
        $checklogin = new \checklogin();
        if($checklogin->r){

            $this->loged = true;
     
        }
        else{
            
            $this->loged = false;
        }
        
        
        $this->content = new \contents($this->loged);
        
        
    }
   
    
  
   
   
    
    
}

