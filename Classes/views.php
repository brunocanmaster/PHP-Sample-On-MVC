<?php

class views{
    
    private static $file;
    

    public static function load_view($nameView){
        
  
        $filepath = PASTA_VIEWS.'/'.$nameView.'.html';
        
        
        if( (file_exists($filepath))) 
        self::$file = file_get_contents($filepath);
 
    }
    
    public static function show_view() {

        echo self::$file;
        
        
        
  
    }
    
    public static function token_in_view(){
        
        $token = CONS_TOKEN.uniqid(time());
        
        self::$file = str_replace('$#TOKEN#$', $token, self::$file);
        
        
        sessao::iniciar_sessao();
        sessao::criar_sessao($token,'token',$cookie = false);
      
        
    }
    
    
    // Utilizando For
    public static function replace_in_view($padraohtml,$dado){
        
       

                self::$file = str_replace($padraohtml, $dado, self::$file);
          
   
    }
    
   
    public static function replace_in_view_complex($errors,$padraohtml){
        
        $newerrors = array();
        $newpadraohtml = array();
        
        $i = 0;
        foreach ($errors as $key => $value) {
        
            if(isset($padraohtml[$key])){
                
                $newerrors[$i] = $value;
                $newpadraohtml[$i] = $padraohtml[$key];
                
                $i++;
            }
            
        }
        
        self::$file = str_replace($newpadraohtml, $newerrors, self::$file);
    }
   

    public static function cut_in_view($padrao){

        $toreplace = "<!-- #$"."$padrao"."$# -->";
        $toreplaceEnd = "<!-- END #$"."$padrao"."$# -->";
 
        $pos = strpos(self::$file, $toreplace);
        $posend = strpos(self::$file, $toreplaceEnd);
        
        $strlen1 = strlen(substr(self::$file, $pos));
        $strlen12 = strlen(substr(self::$file, $posend));
        
        $result = substr(self::$file, $pos, $strlen1-$strlen12);
        self::$file = str_replace($result, '', self::$file);

       
    }
    
    
    
    
    
    
    
}

