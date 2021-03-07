<?php



class legendas{
    
  private $controlador = 'home';
  private $receiverclass;
  private $acao = 'index';
  private $parametros;

  private $mask;
  
  public function __construct() {
      
      
    
    
      $this->get_url();
      $routes = routes::get_routes();
      $url = $this->controlador.'/'.$this->acao;
   
      if(array_key_exists($url, $routes)){
          
    
          $method = explode('.', $routes[$url]);
          $this->controlador = $method[0];
          if(isset($method[1])){
              $this->acao = $method[1];
          }
          
          
      }

      /* [3] Verifica se arquivo e classe de controlador existem senão retorna 404*/
      if(!($this->file_controller($this->controlador)) && !(class_exists($this->controlador,true))){
          
          views::load_view('404');
          views::show_view();
          return;
      }
      /* [!3] */
      
      
      /* [4] Verifica se foi enviado o controloador para logout */
      if($this->controlador=='logout'){
          
          $this->controlador = 'logout';
      }
      if($this->acao=='logout'){
          $this->controlador = 'logout';
          $this->acao = NULL;
      }
      
  
      /* [!4] */
      
      
      /* [4] Inicia o controlador, verifica se existe a ação e executa-a */
      $className = '\\Controller\\'.$this->controlador;
      $methodName = $this->acao;

      $this->receiverclass = new $className;
     
     
      if(method_exists($this->receiverclass, $methodName) ){
             
          $this->receiverclass->$methodName($this->parametros);
      }
      else{
 
          if(!(empty($this->acao))){
          views::load_view('404');
          views::show_view();
          }
  
      }
      /* [!4] */
      
    
      
      
  }
  

  
  private function file_controller($fileName){
      
      
      if(file_exists(PASTA_CONTROLLER.'/'.$fileName.'controller.php')){
         return true;
      }
      
      
  }
 

  public function get_url(){
      
     
      
      if(isset($_GET['path'])){
          $path = $_GET['path'];
          $path = rtrim($path,'/');
          $path = filter_var($path, FILTER_SANITIZE_URL);
          //Array de parametros: http://www.teste.com/bla/blu/ble - bla<=0,blu<=1,ble<=2
          $path = explode('/', $path);
          
          foreach ($path as $key => $value) {
              
              strtolower($value);
          }
          
          $this->controlador = functions::check_array_key_and_return($path, 0);
          $this->acao = functions::check_array_key_and_return($path, 1);
          
          if(functions::check_array_key_and_return($path, 2) != null){
              
              unset($path[0]);
              unset($path[1]);
              
              
              $this->parametros = array_values($path);
          }
      }
      
   
  }
  
  public function show_vars(){
      
      
      
      echo '<br><br>---------------------------------------------------<br><br>';
      echo '<br>Controlador: '.$this->controlador.'<br><br>'
      .'<br>Ação: '.$this->acao.'<br><br>';
      echo '<br>Parametros: '.  print_r($this->parametros).'<br>';
      echo '<br><br>---------------------------------------------------<br><br>';
      
      
  }
  
  public function show_session_cookie(){
      
      echo '<br> COOKIES: '.print_r($_COOKIE).'<br>';
    
      sessao::iniciar_sessao();
      sessao::show_sessao();
    
      
  }

    
}

