<?php

class errormap{
    
    const nome_invalido = 'Nome inválido';
    const email_invalido = 'Email Inválido';
    const senha_invalido = 'Senha Inválida';
    const cpf_invalido = 'CPF inválido';
    const cnpj_invalido = 'CNPJ inválido';
   
    const campo_vazio = 'Campo Obrigatório';
    const token = 'Token esperado não foi recebido';
    
    //VALOR NÃO ESPERADO
    const nao_esperado = 'Valor não esperado recebido';
    
    // ERRORS DE DB UNIQUES
    const email_existente = 'Esse Email já está em uso';
    const email_cadastro_existente = 'Esse Email já foi cadastrado';
    const sma_existente = 'Essa Série já foi cadastrada';
    const sma_existente_temp_ep = 'Essa temporada e episódio já foram cadastrados';
    const sma_name_ep = 'O nome desse episódio já foi cadastrado';
    
    
     
    //SMA ERRORS
    const sma_tip = 'Tipo de série inválida';
    const sma_descricao = 'Descricao muito longa';
    const sma_nao_cadastrado = 'Nenhum SMA foi cadastrado!';
    const sma_nao_cadastrado_ep_temp = 'Nenhuma Legenda cadastrada!';
     
    
   
    public static function errno_querys($errno,$var){
        
       
        if($errno == 1062){
           
            switch ($var) {
                case 'sma':
                    return self::sma_existente;
                    break;

                case 'email':
                    return self::email_existente;
                    break;
                
                case 'email_cadastro':
                    return self::email_cadastro_existente;
                    break;
                
                case 'sma_ep';
                    
               
                    return self::sma_name_ep;
                    break;
               
            }
           
       
        }
    }
    
    public static function var_min_caracters($key,$qt){
        
        $var = 'Digite um(a) '.$key.' com no mínimo '.$qt.' caracteres';
        return $var;
    }
    
    public static function var_max_caracters($key,$qt){
        
        $var = 'Digite um(a) '.$key.' com até '.$qt.'caracteres';
    }
    
}
