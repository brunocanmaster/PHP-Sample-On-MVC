<?php

Class Masks{
    
    public static function cpf($cpf) {
        return preg_replace('/(\d{3})(\d{3})(\d{3})/', '${1}.${2}.${3}-', $cpf);
    }

    public static function cep($cep) {
        return preg_replace('/(\d{5})(\d{3})/', '${1}-${2}', $cep);
    }

    public static function cnpj($cnpj) {
        return preg_replace('/(\d{2})(\d{3})(\d{3})(\d{4})/', '${1}.${2}.${3}/${4}-', $cnpj);
    }

    public static function data($data) {

        // evitando  \d{2,4} na expressÃ£o para evitar retornos invalidos com 3 digitos no ano
        return preg_replace('/(\d{2})(\d{2})(\d{4})|(\d{2})(\d{2})(\d{2})/', '${1}/${2}/${3}', $data);
    }

    public static function unMaskNumber($numero) {
        return preg_replace('/[^0-9]/', '', $numero);
    }
    
    public static function mask($mascara,$dado){

        $strlenMascara = strlen($mascara);
        $strlenDado = strlen($dado);
        
        if((substr_count($mascara, '#')) == (strlen($dado))){
        $dado = str_split($dado);
        $mascara = str_split($mascara);
        
        $mask = '';
        $mask = str_pad($mask, $strlenMascara);     
        
        for($i=0, $i2=0; $i<$strlenMascara; $i++){
 
            if(strstr($mascara[$i], '#')){

                $mask .= str_replace('#',$dado[$i2],$mascara[$i]);
                
                 if($i2<$strlenDado){
                    $i2++;
            }
                
            }
            else{

                $mask .= $mascara[$i];
            }
        } 
        
        echo $i2;
        return $mask;
        
        
        }
        else{
            
            echo 'Digite uma máscara que contenha o mesmo número de # em $mascara para o mesmo strlen de sua $dado.';
        }
        
        }
        
        // Remove caracteres inválidos
        public static function Limpar_dado($dado){
            
            $dado = preg_replace('/[^a-zA-Z]/i', '', $dado);
        }
}

