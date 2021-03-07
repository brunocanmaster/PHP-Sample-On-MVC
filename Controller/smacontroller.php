<?php
namespace Controller;

class sma extends main{
    
    public function __construct() {
        parent::__construct();
        
        
        \views::load_view('sma'); 
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
    
  
    public function showsma(){
        
        
        $args = func_get_args();
        
        if(isset($args[0][1]) || !(isset($args[0][0]))){
            
            $idsma = null;
            $this->content->content_404();
        }
        else{
            
            $idsma = $args[0][0];
            $this->content->content_sma_index($idsma);
            
            
        }
        
        
    
        
        
        
        
        
    }
    
    public function favoritar(){
        
        $args = func_get_args();
        
        \sessao::iniciar_sessao();
        if(isset($args[0][1]) || !(isset($args[0][0])) || !(isset($_SESSION['id_user']))){
            
            $this->content->content_404();
        }
        else{
           
            $id_sma = $args[0][0];
            $this->content->content_sma_favoritar($id_sma);
           
            
        
        }

        //$request = str_replace('/favoritar/', '/showsma/', $_REQUEST['path']);
        //$path = $_SERVER['HTTP_HOST'].'/mvc_tcc/'.$request;
     
       //header("Location: http://$path");
        
        

        //$page = ($_SESSION['page'] != null) ? $_SESSION['page']: 1;
        //$path = '/mvc_tcc/home/page/'.$page;
        
       // header("Location: $path");
       
        $path = $_SERVER['HTTP_REFERER'];
        $path = str_replace('http://localhost', '', $path);

        header("Location: $path");
        
    
        
  
        
    }
    
    public function desfavoritar(){
        
        $args = func_get_args();
        \sessao::iniciar_sessao();
        
        if(isset($args[0][1]) || !(isset($args[0][0])) || !(isset($_SESSION['id_user']))){
            
            $this->content->content_404();
        }
        else{
         
            $id_sma = $args[0][0];
            
            $this->content->content_sma_desfavoritar($id_sma);
         
            
           
        }
       // $request = str_replace('/desfavoritar/', '/showsma/', $_REQUEST['path']);
       // $path = $_SERVER['HTTP_HOST'].'/mvc_tcc/'.$request;
     
        //$page = ($_SESSION['page'] != null) ? $_SESSION['page']: 1;
       // $path = '/mvc_tcc/home/page/'.$page;
 
        $path = $_SERVER['HTTP_REFERER'];
        $path = str_replace('http://localhost', '', $path);

        header("Location: $path");
    }
    
    
    public function download(){
        
        
        
        $this->content->content_sma_download();
        
       
        
        
    }
    

            
          
  
  
}