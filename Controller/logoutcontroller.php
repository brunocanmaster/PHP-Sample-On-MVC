<?php

namespace Controller;

class logout{
    
    public function __construct() {
        
        \sessao::iniciar_sessao();
        \sessao::destroir_sessao();
        \cookies::destroy_cookies();
       
        
        \functions::header_inicio();
        
    }
}

