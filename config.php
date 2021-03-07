<?php

// ------------------ CONFIGURAÇÕES DB ----------------------------------- // 

define('DB','my_database');
define('DB_HOST', 'my_host');
define('DB_USER', 'my_user');
define('DB_PASSWORD', 'my_password');


// ------------------ CONFIGURAÇÕES DIR'S (PASTAS) ---------------------- // 
define('PASTA_RAIZ', $_SERVER['DOCUMENT_ROOT'] . '/');
define('PASTA_INCLUDES', $_SERVER['DOCUMENT_ROOT'] . '/Includes');
define('PASTA_CONTROLLER', $_SERVER['DOCUMENT_ROOT'] . '/Controller');
define('PASTA_MODELS', $_SERVER['DOCUMENT_ROOT'] . '/Models');
define('PASTA_VIEWS', $_SERVER['DOCUMENT_ROOT'] . '/Views');
define('PASTA_CLASSES', $_SERVER['DOCUMENT_ROOT'] . '/Classes');
define('PASTA_ARCHIVES', $_SERVER['DOCUMENT_ROOT'].'/archives');

// ------------------- CONFIGURAÇÕES COOKIES --------------------------- //
define('EXPIRE_COOKIE', (3600 * 5) + time());


// ----------------- CONFIGURAÇÕES DE SESSÕES --------------------------- // 
define('NAME_SESSION', md5('seg'.$_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT']));


// ---------------- CONFIGURAÇÃO DAS CONSTANTES USADAS EM MD5 -----------------

define('CONS_SESSION', '48w9q5m9p7z3t1b');
define('CONS_TOKEN', mt_rand(0, 100));
define('CONS_COOKIE', '4z6h21xpw9lc23as');

// --------------- CONFIGURAÇÃO DE VERIFICAÇÃO DE LOGIN -----------------------




// --------------- CONFIGURAÇÃO DE POSTS --------------------------------------

// O que é esperado receber dos formulários;
define('POSTS_CADASTRO', 'nome.email.senha.sma_img');
define('POSTS_LOGIN', 'email.senha.auto_login');


// Formulários checkbox, radio ou inputs;
define('POSTS_EXCEPTION_LOGIN','auto_login');


// O que é obrigatório e tem de ser verificado;
define('TO_VALIDATE_CADASTRO','nome.email.senha.sma_img');
define('TO_VALIDATE_LOGIN','email.senha');


// O que tem de ser gravado no DB;
define('TO_DB_CADASTRO', 'nome.email.senha.sma_img');
define('TO_DB_LOGIN', 'email.senha');


// Quantidade de páginas a ser exibidas por página:
define('EXIBIR_POR_PAGINA', 9);

//Função Anônima 
spl_autoload_register(function ($className) {

    $className = strtolower($className);
    $className = explode('\\', $className);
    $className = array_pop($className);

  
  
   
    if (file_exists(PASTA_CLASSES . '/' . $className . '.php')) {



        require_once PASTA_CLASSES . '/' . $className . '.php';
        return;
    }
    if (file_exists(PASTA_CONTROLLER . '/' . $className . 'controller.php')) {




        $className = $className . 'controller.php';

        require_once PASTA_CONTROLLER . '/' . $className;
        return;
    }
    if (file_exists(PASTA_RAIZ . '/' . $className . '.php')) {


        require_once PASTA_RAIZ . '/' . $className . '.php';
        return;
    }
    
    if (file_exists(PASTA_MODELS . '/' . $className . '.php')) {

    
       
        require_once PASTA_MODELS . '/' . $className . '.php';
        return;
    }



    return false;
});




