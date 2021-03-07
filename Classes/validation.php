<?php

class validation{
    
    
    private $toValidate;
    
    
    public function is_sma_ep_name(){
        
        $min = 2;
        $max = 60;
        
        if((strlen($this->toValidate) < $min)){
            
            echo 'false';
            $this->toValidate = errormap::var_min_caracters('nome', '2');
            return false;
        }
        elseif((strlen($this->toValidate) > $max)){
            
            echo 'false';
            $this->toValidate = errormap::var_max_caracters('nome','60');
            return false;
        }
        
        return true;
    }
    
    public function is_sma_ep(){
        
       
        if((is_numeric($this->toValidate)) && ($this->toValidate >= 1) && ($this->toValidate <= 10)){
            
            return true;
            
        }
        else{
            
            $this->toValidate = errormap::nao_esperado;
            return false;
        }
        
    }
    
    public function is_sma_img(){
       
        if(stristr($this->toValidate, 'image') && (stristr($this->toValidate, '.jpeg')
        || stristr($this->toValidate, '.jpg')) || stristr($this->toValidate, '.gif')
        || stristr($this->toValidate, '.png')){
            
            
            
            return true;
        }
        return false;
        
    }
    
    public function is_sma_legenda(){
        
        if(strstr($this->toValidate,'legenda') && strstr($this->toValidate, '.srt')){
            
            return true;
        }
        return false;
    }
    
    public function is_sma_name(){
        
        if($this->is_nome() != false){
            
            return true;
        }
        return false;
        
    }
   
    
    public function is_sma_tip(){
        
        if($this->toValidate == 's' || $this->toValidate == 'm' || $this->toValidate == 'a'){
            
            switch ($this->toValidate) {
                case 's':
                    $this->toValidate = 0;

                    break;

                case 'm':
                    $this->toValidate = 1;
                    break;
                
                case 'a':
                    $this->toValidate = 2;
                    break;
            }
            
            return true;
        }
        else{
            
            $this->toValidate = errormap::nao_esperado;
            return false;
        }
        
    }
    
    
    public function is_sma_temp(){
        
        if(is_numeric($this->toValidate) && ($this->toValidate >= 1) && ($this->toValidate <= 10))
        {
            return true;
        }
        $this->toValidate = errormap::nao_esperado;
        return false;
        
    }
    
    public function is_sma_descricao(){
        
        $this->toValidate = trim($this->toValidate);
        if(strlen($this->toValidate) <= 1000){
            
            return true;
        }
        else{
            
            $this->toValidate = errormap::sma_descricao;
            return false;
        }
        
    }

  
    public function is_email(){
     
        
       
            
            if(!(empty($this->toValidate))){
            list($usuario,$dominio) = explode('@', $this->toValidate);
            }
            //checkdnsrr($dominio, "MX") && filter_var($this->toValidate, FILTER_VALIDATE_EMAIL) && 
            if($this->is_empty()){
                
                return true;
            }
   
            else{
        
            $this->toValidate = errormap::email_invalido;
            return false;
            
            }
    }
     
     
    
    public function is_nome(){
        
       
        $min = 2;
        $max = 60;
        
        if((strlen($this->toValidate) < $min)){
            
            echo 'false';
            $this->toValidate = errormap::var_min_caracters('nome', '2');
            return false;
        }
        elseif((strlen($this->toValidate) > $max)){
            
            echo 'false';
            $this->toValidate = errormap::var_max_caracters('nome','60');
            return false;
        }
        
        return true;
       
            
        
        
        
    }
    
    public function is_senha(){
        
        $min = 2;
        $max = 60;
        
        if((strlen($this->toValidate) < $min)){
            
            $this->toValidate = errormap::var_min_caracters('senha', '2');
            return false;
        }
        elseif((strlen($this->toValidate) > $max)){
            
            $this->toValidate = errormap::var_max_caracters('senha','60');
            return false;
        }
        return true;
        
    }
    
    public function is_token(){
        
     
        sessao::iniciar_sessao();
 
    
        if(isset($_SESSION['token'])){
            
            
            if($this->toValidate == $_SESSION['token']){
                
                unset($_SESSION['token']);
                return true;
                
            }
    
            
        }
     
        
        $this->toValidate = errormap::token;
        return false;
        
        
     
        
        
    }

    public function is_empty(){
        
        if(empty($this->toValidate)){
            
            $this->toValidate = errormap::campo_vazio;
            return false;
            
        }
        return true;
        
    }
    

    public function get_toValidate(){
        
        return $this->toValidate;
    }
    
    public function set_toValidate($var){
        
        $this->toValidate = $var;
    }
   
    
    
}

