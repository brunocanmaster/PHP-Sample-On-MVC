<?php


class upload_img{
    
    public $error;
    private $data;
    private $file;
    private $filename;
    private $dirtosave;
    private $tipos = 'jpeg; png; gif; srt';
    
    public function __construct($dirtosave,$filename) {

        $this->dirtosave = $dirtosave;
        $this->filename = $filename;
        
        if($this->check_dir()){

            
            if($this->check_file()){
                
               
                $this->get_image_data();
                $this->check_size();
                $this->check_types();
            }
            
        }
       
        
        return $this->error;
        
        
        
        
    }
    
    private function check_dir(){
        
        if(is_dir($this->dirtosave)){
            
            return true;
        }
        else{
            
         //  $this->error = new ; 
         $this->error['file'] = 'dir inválido';
            
            
        }
        
    }
    
    private function check_file(){
        
        
        if(isset($_FILES[$this->filename]) && !(empty($_FILES[$this->filename]['tmp_name']))){
            $this->file = $_FILES[$this->filename]['tmp_name'];
            return true;
        }
        else{
            
            $this->error['file'] = 'Nenhum arquivo foi enviado';
            return false;
        }
    }
    
    
    private function check_types(){
  
        $mime = explode('/', $this->data['type']);
  
        if(strstr($this->tipos, $mime[1])){
            
            return true;
        }
        else{
            
            $this->error['file'] = 'Apenas imagens do tipo JPG, GIF e PNG.';
            return false;
        }
    }
    
    private function check_size(){
        
        if($this->data['size'] <= 2097152){
            
            return true;
        }
        else{
            
            $this->error['file'] = 'Envie um arquivo com até 2mb';
            return false;
        }
        
    }
    
    private function get_image_data(){
        
        
        
        list($this->data['width_old'],  $this->data['height_old'], $this->data['type'], $this->data['width_and_height']) = getimagesize($this->file);
        $this->data['type'] = image_type_to_mime_type($this->data['type']);
        $this->data['size'] = $_FILES[$this->filename]['size'];
  
   
    }
    
    
    public function redimensionar($newidth,$newheight){
        
        if($this->data['width_old'] > $this->data['height_old']){
            
            $newheight = ($newidth/$this->data['width_old'])*$this->data['height_old'];
        }
        elseif($this->data['width_old'] < $this->data['height_old']){
            
            $newidth = ($newheight/$this->data['height_old'])*$this->data['width_old'];
            
        }
        
        
        
        $oldwidth = $this->data['width_old'];
        $oldheight = $this->data['height_old'];
        $newimg = imagecreatetruecolor($newidth, $newheight);
        
        
        switch ($this->data['type']) {
            
            case 'image/gif':
                $imgtemp = imagecreatefromgif($this->file);
                imagecopyresampled($newimg, $imgtemp, 0, 0, 0, 0, $newidth, $newheight,$oldwidth, $oldheight);
                imagegif($newimg, $this->file);

                break;
            
            case 'image/jpg':
                case 'image/jpeg':
                    $imgtemp = imagecreatefromjpeg($this->file);
                    imagecopyresampled($newimg, $imgtemp, 0, 0, 0, 0, $newidth, $newheight, $oldwidth, $oldheight);
                    imagejpeg($newimg, $this->file);
                break;
            
            case 'image/png':
                $imgtemp = imagecreatefrompng($this->file);
                imagecopyresampled($newimg, $imgtemp, 0, 0, 0, 0, $newidth, $newheight, $oldwidth, $oldheight);
                imagepng($newimg, $this->file);
                break;
          
                    
                
            
          
            
        }
        
        
        imagedestroy($newimg);
        imagedestroy($imgtemp);
        
        
        
        
    }
    
    public function save_img_in_dir(){
        
       
        
        if(move_uploaded_file($this->file, $this->dirtosave.$this->get_img_name())){
            
            return true;
        }
        else{
            
            $this->error['file'] = 'Erro ao salvar a imagem em '.$this->dirtosave;
            
        }
   
    }

    public function get_img_name(){
        
        $type = explode('/', $this->data['type']);
        if(isset($_FILES[$this->filename]['name'])){
        $name = explode('.', $_FILES[$this->filename]['name']);
        }
        
        $newname = '';
        if(isset($type[1],$name[0])){
            
        $name[0] = substr($name[0], 2);
        $newname = strtolower('image-'.$name[0].'.'.$type[1]);
        }
        return $newname;
    }
   
    

    
}

