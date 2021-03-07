<?php


class upload_legenda{
    
    public $error;
    private $filename;
    private $dirtosave;
    private $rand;
    private $initialname;
    private $tipos = '.srt';
    
    public function __construct($dirtosave,$filename,$rand,$initialname) {
        
        $this->dirtosave = $dirtosave;
        $this->filename = $filename;
        $this->rand = $rand;
        $this->initialname = $initialname;
        
        if($this->check_dir()){
            
            if($this->check_file()){
                
                $this->check_size();
                $this->check_type();
                $this->get_legenda_name();
                
            }
        
            
        }
        
    }
    
    public function save_legenda_in_dir(){
        
        if(move_uploaded_file($_FILES[$this->filename]['tmp_name'], $this->dirtosave.'/'.$this->get_legenda_name())){
            
            return true;
        }
        else{
            
            $this->error['file'] = 'Erro ao salvar a Legenda!';
            return false;
        }
    }
    
    public function get_legenda_name(){
        
        $type = strrchr($_FILES[$this->filename]['name'], '.');
        $newname = strtolower($this->initialname.'legenda-'.$this->rand.$_FILES[$this->filename]['name']);
        
        return $newname;
 
        
        
    }
    
    private function check_dir(){
        
     
        if(is_dir($this->dirtosave)){
            
        
            return true;
        }
        else{
            
            $this->error['file'] = 'Dir inválido!';
            return false;
        }
        
    }
    
    private function check_file(){
        
       
        if(isset($_FILES[$this->filename]) && !(empty($_FILES[$this->filename]['tmp_name']))){
            
           
            return true;
        }
        else{
         
            $this->error['file'] = 'Nenhum arquivo foi enviado!';
            return false;
        }
        
    }
    
    private function check_size(){
        
        if($_FILES[$this->filename]['size'] <= 2097152){
            
            return true;
        }
        else{
            
            $this->error['file'] = 'Envie um arquivo com até 2mb';
            return false;
        }
        
    } 
    
    private function check_type(){
     
       
       $type = strrchr($_FILES[$this->filename]['name'], '.');
       
       if(strstr($this->tipos, $type)){
           
          
           return true;
           
       }
       else{
           
           $this->error['file'] = 'Apenas Arquivo do tipo .srt';
           return false;
       }
        
    }
    
    
    
}

