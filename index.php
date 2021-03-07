<?php


require_once 'header.php';
require_once 'config.php';


routes::add_route('editadados/', 'editadados.index');
routes::add_route('home/', 'home.index');
routes::add_route('cadastro/', 'cadastro.index');
routes::add_route('admin/', 'admin.index');
routes::add_route('sma/', 'sma.index');
routes::add_route('login/', 'login.index');
routes::add_route('usuario/', 'usuario.index');



routes::add_route('admin/add_sma', 'admin.add_sma');
routes::add_route('admin/add_ep', 'admin.add_ep');
routes::add_route('home/page', 'home.page');
routes::add_route('home/meusfavoritos', 'home.meusfavoritos');




routes::add_route('cadastro/cadastrar', 'cadastro.cadastrar');

$a = new legendas();


