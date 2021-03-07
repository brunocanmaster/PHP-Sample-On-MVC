<?php

class contents{
    
    private $loged;
    private $rhome;
    private $conexao;
    
    public function __construct($loged = false) {
        
        $this->loged = $loged;
        
        $this->conexao = new Database\sql();
        
    }
    
    
    // @BEGIN CONTENTS ADMIN:
    
    public function content_admin_construct(){
        
        $query2 = "SELECT sma_name FROM sma limit 10";

  
        $r = $this->conexao->query_fetch_all($query2);
        

        if(isset($r) && !(empty($r))){
            
         
        $countr = count($r);
        
        $newerror = array();
        $newpadrao = array();

        

        $i2 = 1;
        for($i=0; $i < $countr; $i++){
            
            
            foreach ($r[$i] as $key => $value) {
     
                

                switch ($key) {
                    
                    case 'sma_name':
                        
                        
                        $newpadrao[$i2] = ' <!-- #$SMA_NAME$# -->';
                        $newerror[$i2] = '<option name="sma_name" value="'.$value.'" >'.$value.'</option>'.$newpadrao[$i2];
   
                        break;

                }
                $i2++;
                
                
            }
        }

        }
        else{
            
              
            $newpadrao[0] = '<!-- #$SMA_NAME$# -->';
            $newerror[0] = '<option name="sma_name" value="">Nenhuma série cadastrada</option>';
        }
        
        
     
        
        
        
        if($_REQUEST['path'] == 'admin'){
            
            $i2 = 0;
            $newpadrao[$i2+1] = 'action="add_ep"';
            $newerror[$i2+1] = 'action="admin/add_ep"';
            $newpadrao[$i2+2] = 'action="add_sma"';
            $newerror[$i2+2] = 'action="admin/add_sma"';
            $newpadrao[$i2+3] = 'action="add_legenda"';
            $newerror[$i2+3] = 'action="admin/add_legenda"';
            $newpadrao[$i2+4] = 'action="buscar_legenda"';
            $newerror[$i2+4] = 'action="admin/buscar_legenda"';
        }
      
       
        \views::replace_in_view($newpadrao, $newerror);
    }
    
    public function content_admin_addep(){
       

        $dirtosave = PASTA_ARCHIVES.'/legendas/';
        $filename = 'sma_legenda';
        
        
        $rand = rand(0, 1000);
        
        $temp = ($_POST['sma_temp'] >= 10) ? 'S'.$_POST['sma_temp']:'S0'.$_POST['sma_ep'];
        $ep = ($_POST['sma_ep'] >= 10) ? 'E'.$_POST['sma_temp']:'E0'.$_POST['sma_ep']; 
        $smaname = $_POST['sma_name'];
        
        $initialname = $smaname.'.'.$temp.'.'.$ep.'.';
        
        $legenda = new \upload_legenda($dirtosave, $filename,$rand,$initialname);
   
       
        
        $_POST['sma_legenda'] = $legenda->get_legenda_name();
        $keys = 'sma_name.sma_temp.sma_ep.sma_ep_name.sma_legenda';
        $post = $_POST;
        $toValidate = 'sma_temp.sma_ep.sma_ep_name.sma_legenda';
        $toDB = 'sma_temp.sma_ep.sma_ep_name.sma_legenda';
        $method = 'add_ep';
        
        
        
        $add_ep = new \modelcadastro($keys, $post, $toValidate, $toDB, $method);
      
        
        if(is_array($add_ep->get_errors()) && is_array($legenda->error)){
            
            $error = array_merge($add_ep->get_errors(),$legenda->error);
        }
        elseif(empty($legenda->error)){
            
            
            $error = $add_ep->get_errors();
        }
        
      
       
        
        $padraohtml['tohide1'] = "<!-- $#DOCUMENT#$ -->";
        $error['tohide1'] = 'document.getElementById("form_adicionar_serie").style.display="none"; '.$padraohtml['tohide1'];
        $padraohtml['tohide2'] = "<!-- $#DOCUMENT#$ -->";
        $error['tohide2'] = 'document.getElementById("form_adicionar_episodio").style.display="block"; '.$padraohtml['tohide2'];
        
       
        
        if(!(empty($add_ep->get_errors()))){
           
            $padraohtml['sma_name'] = '<!-- #$ERRORSMANAME-EP$# -->';
            $padraohtml['sma_temp'] = '<!-- #$ERRORSMATEMP$# -->';
            $padraohtml['sma_ep'] = '<!-- #$ERRORSMAEP$# -->';
            $padraohtml['sma_ep_name']= '<!-- #$ERRORSMA_EP_NAME$# -->';
            $padraohtml['file'] = '<!-- #$ERRORSMA_SMA_LEGENDA$# -->';
            
            $padraohtml['action'] = 'action="admin/add_sma"';
            $error['action'] = 'action="add_sma"';
            $padraohtml['action2'] = 'action="admin/add_ep';
            $error['action2'] = 'action="add_ep"';
            
            
            
            
       
            
            
                    
            
        }
        else{
            
            $padraohtml['sucesso'] = '<!-- #$SUCESSO-ADD_EP$# -->';
            $error['sucesso'] = 'Episódio Adicionado com Suceso! ';
            
            if(empty($legenda->error)){
                
                $legenda->save_legenda_in_dir();
            }
            
        }
        
       
        
        \views::replace_in_view_complex($error, $padraohtml);
      
    }
    
    public function content_admin_addsma(){
        
        $dirtosave = PASTA_ARCHIVES.'/imgs/';
        $filename = 'sma_image';
      
       
        
        //Inicia validação de imagens
        $img = new \upload_img($dirtosave, $filename);
      
        
        $_POST['sma_img'] = $img->get_img_name();
        $keys = 'sma_name.sma_tip.sma_descricao.sma_img';
        $post = $_POST;
        $toValidate = 'sma_name.sma_tip.sma_descricao.sma_img';
        $toDB = 'sma_name.sma_tip.sma_descricao.sma_img';
        $method = 'add_sma';

        // Inicia validação de formulários
        $add_sma = new \modelcadastro($keys, $post, $toValidate, $toDB, $method);


        if(is_array($add_sma->get_errors()) && is_array($img->error)){
            $errors = array_merge($add_sma->get_errors(), $img->error);
        }
        elseif(empty($img->error)){
            
            $errors = $add_sma->get_errors();
         
            
        }
   
        if(empty($add_sma->get_errors())){

            if(empty($img->error)){
             
                $img->redimensionar('300', '300');
                $img->save_img_in_dir();
                
            }
        }
        
        if(isset($errors) && !(empty($errors))){
            
            $padraohtml['sma_name'] = '<!-- #$ERRORSMANAME$# -->';
            $padraohtml['sma_tip'] = '<!-- #$ERRORSMATIP$# -->';
            
            $padraohtml['sma_descricao'] = '<!-- #$ERRORSMADESCRICAO -->';
            $padraohtml['file'] = '<!-- #$ERRORFILE#$ -->';
            
        
            
            
       
            
        }
        else{
            
            $padraohtml['sucesso-sma'] = '<!-- #$SUCESSO-ADD_SERIE$# -->';
            $errors['sucesso-sma'] = 'Série Adicionada com sucesso!';
    
        }
        \views::replace_in_view_complex($errors, $padraohtml);
    }
    
    public function content_admin_buscarlegenda(){
        
        $keys = 'sma_name';
        $post= $_POST;
        $toValidate = 'sma_name';
        $toDB = 'sma_name';
        $method = 'buscar_legenda';
        
        $buscar_legenda = new \modelcadastro($keys, $post, $toValidate, $toDB, $method);
        
        $r = $buscar_legenda->get_db_r();
        
        $errors = $buscar_legenda->get_errors();
        
        $padraohtml['tohide1'] = "<!-- $#DOCUMENT#$ -->";
        $errors['tohide1'] = 'document.getElementById("form_adicionar_serie").style.display="none"; '.$padraohtml['tohide1'];
        $padraohtml['tohide2'] = "<!-- $#DOCUMENT#$ -->";;
        $errors['tohide2'] = 'document.getElementById("form_adicionar_episodio").style.display="none"; '.$padraohtml['tohide2'];
        $padraohtml['tohide3'] = "<!-- $#DOCUMENT#$ -->";
        $errors['tohide3'] = 'document.getElementById("form_adicionar_legenda").style.display="block"; '.$padraohtml['tohide3'];
        $padraohtml['tohide4'] = "<!-- $#DOCUMENT#$ -->";
        $errors['tohide4'] = 'document.getElementById("legenda").style.display="block"; ';
  
        if(!(empty($errors))){
        
        $padraohtml['sma_name'] = '<!-- #$ERRORSMANAME-GSMA$# -->';
        }


        if(empty($r)){    
        $padraohtml['tohide5'] = $errors['tohide4'];
        $errors['tohide5'] = 'document.getElementById("legenda").style.display="none"; ';
        
        }
        else{
            
            if(is_array($r)){
            $i = 0;
            foreach ($r as $key => $value) {
                
                
                $padraohtml['tohide6'] = '<!-- #$TITLE-SMA$# -->';
                $errors['tohide6'] = '<div class="linhas_sma_propor border_bottom"><h3>'.$value['sma_name'].'</h3></div>';
                
                $padraohtml[$key] = '<!-- #$NEW-LINE#$ -->';
                $errors[$key] = '<div class="linhas_sma_propor border_bottom">'
                        . '<label for="check'.$i.'" class="img_sma">'.$i.'</label>'
                        . '<div class="text_sma" title="SMA"> '.$value['sma_name'].'</div>'
                        . '<div class="text_sma" title="TEMPORADA"> S0'.$value['temp'].'</div>'
                        . '<div class="text_sma" title="EPISÓDIO"> E0'.$value['ep'].'</div>'
                        . '<div class="text_sma" title="NOME EPISÓDIO"> '.$value['name_ep'].'</div>'
                        . '<div class="text_sma" title="LEGENDA">'.$value['name_legenda'].'</div>'
                        . '<input id="check'.$i.'" name="check'.$i.'" type="checkbox" class="text_sma margin-top" value="'.$value['id_sma_ep'].'" />'
                        . '</div>'.$padraohtml[$key];
              
                $i++;
             
                
            }
            }
        }
        
        \views::replace_in_view_complex($errors, $padraohtml);
    }
    
    public function content_admin_excluirlegenda(){
        

        
        $keys = array_keys($_POST);
        $post = $_POST;
        $toValidate = false;
        $toDB = $keys;
        $method = 'excluir_legenda';
        
        $excluir_legenda = new \modelcadastro($keys, $post, $toValidate, $toDB, $method);
        
        $padraohtml['sma_name'] = '<!-- #$ERRORSMANAME-GSMA$# -->';
        $errors = $excluir_legenda->get_errors();
        
       
        
        if(empty($errors)){
           
            $errors['sma_name'] = '<a style="color: green;">Sucesso!</a>';
        }
        
        $padraohtml['tohide1'] = "<!-- $#DOCUMENT#$ -->";
        $errors['tohide1'] = 'document.getElementById("form_adicionar_serie").style.display="none"; '.$padraohtml['tohide1'];
        $padraohtml['tohide2'] = "<!-- $#DOCUMENT#$ -->";;
        $errors['tohide2'] = 'document.getElementById("form_adicionar_episodio").style.display="none"; '.$padraohtml['tohide2'];
        $padraohtml['tohide3'] = "<!-- $#DOCUMENT#$ -->";
        $errors['tohide3'] = 'document.getElementById("form_adicionar_legenda").style.display="block"; '.$padraohtml['tohide3'];
        $padraohtml['tohide4'] = "<!-- $#DOCUMENT#$ -->";
        $errors['tohide4'] = 'document.getElementById("legenda").style.display="block"; ';
        
        \views::replace_in_view_complex($errors, $padraohtml);
        
    }
    // #END OF CONTENDS ADMIN 
    
    
    // @BEGIN CONTENTS SMA
    public function content_sma_index($idsma = null){
        
            if(!empty($idsma)){
            $this->conexao = new \Database\sql();
           
            
            sessao::iniciar_sessao();
            if(!(isset($_SESSION['id_user']))){
                $_SESSION['id_user'] = 1;
            }
            
            $iduser = $_SESSION['id_user'];
            
            $query2 = "SELECT (SELECT MAX(sma_ep.temp) FROM sma_ep WHERE sma_ep.id_sma = "."'$idsma'"." ) as temp"
                    . ",(SELECT COUNT(sma_ep.ep) FROM sma_ep WHERE sma_ep.id_sma = "."'$idsma' ) as ep"
                    . ",(SELECT sma_favorito.id_sma FROM sma_favorito WHERE sma_favorito.id_usuarios = "."'$iduser'".
                    "AND sma_favorito.id_sma = sma.id_sma LIMIT 1) as favorito"
                    . ",sma.sma_name,sma.sma_tip,sma.sma_descricao,sma.sma_img FROM sma,sma_ep WHERE sma.id_sma = "."'$idsma' ORDER BY ep ASC";
            
            $r = $this->conexao->query_fetch_assoc($query2);
            
 
            if(!(empty($r))){
                
             
                $query = "INSERT INTO sma_visitas(id_sma,visitas) VALUES ("."'$idsma'".",'1')";
                $rvisitas = $this->conexao->query($query);
                
                if(empty($r['temp'])){
                    $r['temp'] = 0;
                }
                
                if(empty($r['ep'])){
                    
                    $r['ep'] = 0;
                }
                
                if(isset($r['sma_tip'])){
                switch ($r['sma_tip']) {
                    case 0:
                        
                        $r['sma_tip'] = 'Série';
                        break;
                    
                    case 1:
                        
                        $r['sma_tip'] = 'Filme';
                        break;
                    
                    case 2:
                        
                        $r['sma_tip'] = 'Anime';
                        break;
                }
                }
                
                $padraohtml[0] = '<!-- #$SMA-TIP$# -->';
                $dado[0] = $r['sma_tip'];
                $padraohtml[1] = '<!-- #$SMAIMG$# -->';
                $dado[1] = '<img id="capa" src="/archives/imgs/'.$r['sma_img'].'" />';
                $padraohtml[2] = '<!-- #$TITLE-SMA$# -->';
                $dado[2] = $r['sma_name'];
                $padraohtml[3] = '<!-- #$DESCRICAO-SMA$# -->';
                $dado[3] = $r['sma_descricao'];
                $padraohtml[4] = '<!-- #$TEMP$# -->';
                $dado[4] = $r['temp'];
                $padraohtml[5] = '<!-- #$EP$# -->';
                $dado[5] = $r['ep'];
                
              
                $favorito = '';
                if($r['favorito'] == $idsma){
                    
                    
                    if($this->loged){
                    $favorito = '<a id="sustenta_favorito_sma"  href="/sma/desfavoritar/'.$idsma.'" title="Desfavoritar SMA">
                                 
                                        <div id="icon_favorito" class="favoritado"></div>
                                </a>';
                    }
                }
                else{
                    
                    if($this->loged){
                    $favorito = '<a id="sustenta_favorito_sma"  href="/sma/favoritar/'.$idsma.'" title="Favoritar SMA">
                                       
                                        <div id="icon_favorito" class="desfavoritado" ></div>
                                </a>';
                    }
                }
                
                $padraohtml[6] = '<!-- #$FAVORITO$# -->';
                $dado[6] = $favorito;
                
                
                $count = 7;
                for($i = 1; $i <= $r['temp']; $i++){
                    
                    $padraohtml[$count] = '<!-- #$TEMP-I$#-->';
                    $dado[$count] = '<div class="user_capa_text"> S0'.$i.'</div>'. $padraohtml[$count];
                    $count++;
                    
                }
               
                
                $queryusuarios = "SELECT DISTINCT(id_usuarios) FROM interacao WHERE id_sma = "."'$idsma'" ;
                $rusuario = $this->conexao->query_fetch_all($queryusuarios);
                
                if(!empty($rusuario)){
                    
                    $tosearch = '';
                    $i = 1;
                    $countusuario = count($rusuario);
                    
                    foreach ($rusuario as $key => $value) {
                    
                         $tosearch .= "'{$value['id_usuarios']}'";
                         if($i < $countusuario){
                             
                             $tosearch .= ',';
                         }
                         $i++;
                         
                    }
                    
                    $queryusuarios2 = "SELECT nome,email,sma_img FROM usuarios WHERE id_usuarios IN (".$tosearch.")";
                    $rusuario2 = $this->conexao->query_fetch_all($queryusuarios2);
                    
                    
                    if(count($rusuario2) == 1){
                        $textusuario = 'Usuário interagiu com esse SMA';
                    }
                    else{
                        $textusuario = 'Usuários interagiram com esse SMA';
                    }
                    
                    $padraohtml['num_usuarios'] = '<!-- #$NUM-USUARIOS$# -->';
                    $dado['num_usuarios'] = count($rusuario2).' '.$textusuario;
                    foreach ($rusuario2 as $key => $value) {
                        
                        $img = 'src="/archives/imgs/'.$value['sma_img'].'" />';
                       
                        $value['nome'] = substr($value['nome'], 0, 20);
                        $padraohtml['linha'.$key] = '<!-- #$LINHA-USUARIO$# -->';
                        $dado['linha'.$key] = '<div class="linha_equipe">'
                                . '              <img class="equipe img_equipe"'.$img
                                . '              <div class="equipe nome_equipe">'.$value['nome'].'</div>'
                                . '            </div>'
                                . $padraohtml['linha'.$key];
           
                    }
                    
                  
                    }
                    
                    $query = "SELECT "
                 . "sma_ep.id_sma_ep,sma.sma_name,sma_ep.name_ep,sma_ep.ep,sma_ep.temp,sma_ep.name_legenda "
                 . "FROM sma,sma_ep "
                 . "WHERE sma.id_sma ='$idsma' AND sma_ep.id_sma = '$idsma'"
                 . "ORDER BY sma_ep.temp,sma_ep.ep";
                    
                   $query = "SELECT id_sma_ep,ep,temp,name_ep,name_legenda FROM sma_ep WHERE id_sma='$idsma'"
                           ." ORDER BY temp";
                   $rdownloads = $this->conexao->query_fetch_all($query);
                   
                 
                   
                   if(!(empty($rdownloads))){
                       
                   
                   
                   $i2 = 0;
                   $temp = 'S0';
                   $ep = 'E0';
                   foreach ($rdownloads as $key => $value) {
                   
                       if($value['temp'] >= 10){
                           
                           $temp = 'S';
                       }
                       
                       if($value['ep'] >= 10){
                           
                           $ep = 'E';
                       }
                       
                       $padraohtml['downloads_'.$key] = '<!-- #$LINHA-DOWNLOAD$# -->';
                       $dado['downloads_'.$key] = '<div class="full_line">'
                               . '                    <label for="check'.$i2.'" class="lines_texts" >'
                               .                        ''    
                               .                        '<a class="line_texts" title="Nome episódio"> '.$value['name_ep'].'</a>'
                               .                        '<a class="line_texts" title="Temporada" style="color:#0ca4e2; font-weight: bold;">'
                               .                        $temp.$value['temp'].'</a>'
                               .                        '<a class="line_texts" title="Episódio"><strong>'.$ep.$value['ep'].'</strong></a>'
                               .                        '<a class="line_texts" title="Legenda">'.$value['name_legenda'].'</a>'
                               .                      '</label>'
                               .                    '<input type="checkbox" id="check'.$i2.'" class="checkbox" value="'.$value['name_legenda'].'" name="'.$key.'" />'
                               .                   '</div> '.$padraohtml['downloads_'.$key];
                       $i2++;
                   
                   }
                   }
                   else{
                       
                       $padraohtml['downloads'] = '<!-- #$LINHA-DOWNLOAD$# -->';
                       $dado['downloads'] = '<div style="margin-top: 20px; padding:10px;" > <strong><p><br><br>Nenhuma legenda cadastrada!</p></strong></div>';
                   }
                
                
                
             
                \views::replace_in_view($padraohtml, $dado);
                \views::show_view();
                
            }
            else{
                
               
                \views::load_view('404');
                \views::show_view();
            }
            
            }
            
  
            
   
            
            
        
    }
    
    public function content_sma_download(){
        
    
        $dir = PASTA_ARCHIVES;
        $zip = new \ZipArchive();
       
        $md5 = md5(time());
        $name = $dir.'/legendas/'.$md5.'.zip';

        if($zip->open($name, \ZipArchive::CREATE)){
            
            if(empty($_POST)){
                    
                $zip->addFile($dir.'/legendas/'.'Aviso.txt', 'Aviso.txt');
             }

            foreach ($_POST as $key => $value) {
               
                $zip->addFile($dir.'/legendas/'.$value, $value);
             
              
            }

            $zip->close();
        }

        set_time_limit(0);
        
        header('Content-Type: application/zip');
        header('Content-Disposition: attachment; filename="download'.time().'.zip"');
        readfile($name);
        
        unlink($name);
     
    
    }
    
    public function content_sma_favoritar($idsma){
   
            $id_user = $_SESSION['id_user'];
 
            $query = "INSERT INTO sma_favorito(id_usuarios,id_sma) VALUES("."'$id_user'".",'$idsma')";
            $r = $this->conexao->query($query);
        
    }
    
    public function content_sma_desfavoritar($idsma){
        
        
            $id_user = $_SESSION['id_user'];
      
            
            $query = "DELETE FROM sma_favorito WHERE id_usuarios="."'$id_user'"." AND id_sma="."'$idsma'";
            $r = $this->conexao->query($query);
    }
    // #END CONTENTS SMA
   
    // @BEGIN CONTENTS USUARIO
    public function content_usuario_construct(){
        
        if(isset($_SESSION['sma_img'])){
            $sma_img = $_SESSION['sma_img'];
        }
        if(isset($_SESSION['nome'])){
            $nome = ($_SESSION['nome'] != null) ? $_SESSION['nome'] : '';
        }
        
        
        $padraohtml[0] = '<!-- #$IMG$# -->';
        $dado[0] = '<img id="img_login_late" src="/archives/imgs/'.$sma_img.'" >';
        $padraohtml[1] = '<!-- #$IMG-TWO$# -->';
        $dado[1] = '<img id="img" src="/archives/imgs/'.$sma_img.'" >';
        $padraohtml[2] = '<!-- #$NAME$# -->';
        $dado[2] = $nome; 
        
        
        
        views::replace_in_view($padraohtml, $dado);

        
    }
    
    public function content_home_meusfavoritos(){
        
            
      
        views::cut_in_view('destaque-semana');
    }
    
    
    // #END CONTENTS USUARIO
    
    // @BEGIN CONTENTS HOME
    public function content_home_construct(){
        
        
        
        
    }
    
    public function content_home_termos(){
        
        $padraohtml[0] = '<!-- #$TITLE-SMA$# -->';
        $dado[0] = 'Termos de uso';
      
        
        views::replace_in_view($padraohtml, $dado);
        views::cut_in_view('page');
        views::cut_in_view('destaque-semana');
    }
    
    public function content_home_politicadeprivacidade(){
        
        $padraohtml[0] = '<!-- #$TITLE-SMA$# -->';
        $dado[0] = '<h2> Política de Privacidade </h2>';
        $padraohtml[1] = '<!-- $#STYLEIFNEED#$ -->';
        $dado[1] = 'min-height: 2752px !important;';
        
        views::replace_in_view($padraohtml, $dado);
        views::cut_in_view('page');
        views::cut_in_view('destaque-semana');
    }
    
    public function content_home_ajuda(){
        
    }
    
    public function content_home_index($page,$meusfavoritos = false){
     
        views::cut_in_view('ajuda');

        $porpagina = EXIBIR_POR_PAGINA;

        
        $y = $porpagina*($page);
        $x = $y - $porpagina;
        $x = ($x == 0)? 0:($x-1);

        
        if($this->loged){
            
            
            sessao::iniciar_sessao();
            $userid = $_SESSION['id_user'];
      
           
            if(!($meusfavoritos)){
                $query = "SELECT sma.sma_name,sma.id_sma,sma.sma_img"
                    . ",(SELECT MAX(sma_ep.temp) FROM sma_ep WHERE sma_ep.id_sma = sma.id_sma AND sma_ep.ep <= sma_ep.temp) as temp"
                    . ",(SELECT COUNT(sma_ep.ep) FROM sma_ep WHERE sma_ep.id_sma = sma.id_sma) as ep"
                    . ",(SELECT sma_favorito.id_sma FROM sma_favorito WHERE sma_favorito.id_sma = sma.id_sma "
                    . " AND sma_favorito.id_usuarios = "."'$userid' limit 1 )"." as favorito"
                    . ",(SELECT COUNT(sma_visitas.id_sma) FROM sma_visitas WHERE sma_visitas.id_sma = sma.id_sma) as visitas"
                    . " FROM sma LIMIT "."$x,".$y;
            }
            else{
                 
                 $query = "SELECT sma.sma_name,sma.id_sma,sma.sma_img,sma_favorito.id_sma as favorito"
                         . ",(SELECT MAX(sma_ep.temp) FROM sma_ep WHERE sma_ep.id_sma = sma_favorito.id_sma  AND sma_ep.ep <= sma_ep.temp) as temp"
                         . ",(SELECT COUNT(sma_ep.ep) FROM sma_ep WHERE sma_ep.id_sma = sma_favorito.id_sma) as ep"
                         . " FROM sma,sma_favorito WHERE sma.id_sma = sma_favorito.id_sma AND sma_favorito.id_usuarios='$userid' LIMIT "."$x,".$y;
           
    
            }
            
            }
        else{
  
            
            $query  = "SELECT sma.sma_name,sma.id_sma,sma.sma_img"
                . ",(SELECT MAX(sma_ep.temp) FROM sma_ep WHERE sma_ep.id_sma = sma.id_sma AND sma_ep.ep <= sma_ep.temp) as temp"
                . ",(SELECT COUNT(sma_ep.ep) FROM sma_ep WHERE sma_ep.id_sma = sma.id_sma) as ep"
                . ",(SELECT COUNT(sma_visitas.id_sma) FROM sma_visitas WHERE sma_visitas.id_sma = sma.id_sma) as visitas"
                . " FROM sma LIMIT "."$x,".$y;
  
        }
        
        
        $sql = new \Database\sql();
        
        if(!($meusfavoritos)){

        $countsma = "SELECT COUNT(id_sma) as linhas FROM sma";
        }
        else{

        $countsma = "SELECT COUNT(sma_favorito.id_sma) as linhas FROM sma_favorito WHERE sma_favorito.id_usuarios = '".$userid."'";
        }
        
       
        
        $rcountsma = $sql->query_fetch_assoc($countsma)['linhas'];

        $rcountsma = (($rcountsma % $porpagina) >= 0) ? (int)($rcountsma / $porpagina) + 1 : ($rcountsma / $porpagina);


       
        for($i = 1; $i <= $rcountsma; $i++){
            
            $href = (($meusfavoritos)) ? 'href="/home/meusfavoritos/':'href="/home/page/';

            $padraohtml['page'.$i] = '<!-- #$NEW-PAGE$# -->';
            $dado['page'.$i] = '<a class="number_abaixo_abaixo" '.$href.$i.'" >'.$i.'</a> '.
            $padraohtml['page'.$i];
        }
        
        $r = $sql->query_fetch_all($query);
        $linhas = $sql->get_affected_rows();

        if($linhas != 0){
        $favorito = '';
        $idsmas = '';
        
        $padraohtml['title'] = '<!-- #$TITLE-SMA$# --> ';
        $dado['title'] = 'Todos os destaques';
        
        $countr = count($r)-1;
        
        $favorito = '';
        if(!(empty($r))){
            
        foreach ($r as $key => $value){
            
            if(empty($value['visitas']) || is_null($value['visitas'])){ $value['visitas'] = 0;}
            
            $max[$key] = $value['visitas'];
            $keymax[$key] = $key;
            if(isset($value['favorito']) && ($value['favorito']) == $value['id_sma']){
                
                if(isset($favorito) && $this->loged){
                    
                    
                    $favorito = '<a class="favoritos_sma sma_favoritado" title="Remover'
                            . ' dos favoritos" onclick="teste()" href="/sma/desfavoritar/'.$value['id_sma'].'"></a>';
                }
            }
            else{
                
                if(isset($favorito) && $this->loged){
                    
                    $favorito = '<a class="favoritos_sma" title="Adicionar aos favoritos"'
                            . ' onclick="teste()" href="/sma/favoritar/'.$value['id_sma'].'" ></a>';
                }
                
            }
          
     
            if(empty($value['temp'])){
                $value['temp'] = '0';
            }
            if(empty($value['ep'])){
                $value['ep'] = '0';
            }
            
            $value['sma_name'] = substr($value['sma_name'], 0,20);
            $padraohtml[$key] = '<!-- #$NEW-SMA$# -->';
            $dado[$key] = '<div class="sustenta_sma">'
                    . '             <div class="menus_sma">'
                    . '                 '.$favorito
                    . '             </div>'
                    . '             <img class="img_sma" src="/archives/imgs/' .$value['sma_img'].'" >'
                    . '             <div class="sustenta_text_sma">'
                    . ''
                    . '                 <div class="title_sma"><strong >'.$value['sma_name'].'</strong> </div>'
                    . '                 <div class="text_downloads"> Temporadas Lançadas </div>'
                    . '                 <div class="text_downloads release">'.$value['temp'].'</div>'
                    . ''
                    . '                 <div class="text_downloads">Episódios Lançados </div>'
                    . '                 <div class="text_downloads release">'.$value['ep'].'</div>'
                    . ''
                    . '                 <div class="sustenta_botao_downloads">'
                    . '                     <a class="botao_downloads" href="/sma/showsma/'.$value['id_sma'].'"> Download </a>'
                    . '                 </div>'
                    . '              </div> '
                    . '      </div>'.$padraohtml[$key];
             
            
                    
                    
                    if($countr == $key && !($meusfavoritos)){
                        
                        
                        $keysvalue = array_keys($max);
                        
                        if(count($max) < 4){
                            $countmax = count($max);
                        }
                        else{
                            $countmax = 4;
                        }
                   
                        for($i = 0; $i < $countmax; $i++){
            
                            $newmax[$i] = max($max);
                            $chave = array_keys($max, $newmax[$i], '==');
                 
             
                            $padraohtml[$key.$i] = '<!-- #$DESTAQUE-SEMANA$# -->';
                            $dado[$key.$i] = '<a class="destaques" href="/sma/showsma/'.$r[$chave[0]]['id_sma'].'" >'
                                    . '         <img class="img_destaques" src="/archives/imgs/'.$r[$chave[0]]['sma_img'].'" />'
                                    .           '<div class="text1_destaques">'.$r[$chave[0]]['sma_name'].' </div>'
                                    .           '<div class="text2_destaques">'.'</div>'
                                    .        '</a>' .$padraohtml[$key.$i];
                            
                            unset($max[$chave[0]]);
   
                        }
                   
                    }
                    
                    
      
            
        }
  
        }
        else{
            
            $padraohtml = '';
            $dado = '';
        }
        }
        else{
            
            views::load_view('404');
           
        }
        
     
        
        \views::replace_in_view($padraohtml, $dado);
       
        
    }
    
     public function content_home_busca($busca){
         
     
         views::cut_in_view('ajuda');
         $padraohtml['title'] = '<!-- #$TITLE-SMA$# --> ';
         $dado['title'] = 'Resultado da Busca';
         
         
         $busca = strtolower($busca);
         $favorito = '';
       
         
         if(!(empty($busca))){
             
            if($this->loged){
            
            
            sessao::iniciar_sessao();
            $userid = $_SESSION['id_user'];
      
            
            $query = "SELECT sma.sma_name,sma.id_sma,sma.sma_img"
                . ",(SELECT MAX(sma_ep.temp) FROM sma_ep WHERE sma_ep.id_sma = sma.id_sma AND sma_ep.ep <= sma_ep.temp) as temp"
                . ",(SELECT COUNT(sma_ep.ep) FROM sma_ep WHERE sma_ep.id_sma = sma.id_sma) as ep"
                . ",(SELECT sma_favorito.id_sma FROM sma_favorito WHERE sma_favorito.id_sma = sma.id_sma "
                . " AND sma_favorito.id_usuarios = "."'$userid' limit 1 )"." as favorito"
                . " FROM sma WHERE LOWER(sma.sma_name) LIKE ("."'%$busca%') LIMIT 10";
            
            }
            else{
  
            
            $query  = "SELECT sma.sma_name,sma.id_sma,sma.sma_img"
                . ",(SELECT MAX(sma_ep.temp) FROM sma_ep WHERE sma_ep.id_sma = sma.id_sma AND sma_ep.ep <= sma_ep.temp) as temp"
                . ",(SELECT COUNT(sma_ep.ep) FROM sma_ep WHERE sma_ep.id_sma = sma.id_sma) as ep"
                . " FROM sma WHERE LOWER(sma.sma_name) LIKE ("."'%$busca%') LIMIT 15";
  
            }
         
            //$query = "SELECT sma.id_sma,sma.sma_name,sma.sma_tip,sma.sma_descricao,sma.sma_img"
              //   . ",(SELECT) FROM sma WHERE LOWER(sma_name) LIKE("."'%$busca%')";
         
         
         $r = $this->conexao->query_fetch_all($query);
         }
         
         if(isset($r) && !empty($r)){
            
       
         foreach ($r as $key => $value){
            
            
            if(isset($value['favorito']) && ($value['favorito']) == $value['id_sma']){
                
                if(isset($favorito) && $this->loged){
                    
                    
                    $favorito = '<a class="favoritos_sma sma_favoritado" title="Remover'
                            . ' dos favoritos" href="/sma/desfavoritar/'.$value['id_sma'].'"></a>';
                }
            }
            else{
                
                if(isset($favorito) && $this->loged){
                    
                    $favorito = '<a class="favoritos_sma" title="Adicionar aos favoritos"'
                            . ' href="/sma/favoritar/'.$value['id_sma'].'" ></a>';
                }
                
            }
          
     
            if(empty($value['temp'])){
                $value['temp'] = '0';
            }
            if(empty($value['ep'])){
                $value['ep'] = '0';
            }
            $padraohtml[$key] = '<!-- #$NEW-SMA$# -->';
            $dado[$key] = '<div class="sustenta_sma">'
                    . '             <div class="menus_sma">'
                    . '                 '.$favorito
                    . '             </div>'
                    . '             <img class="img_sma" src="/archives/imgs/' .$value['sma_img'].'" >'
                    . '             <div class="sustenta_text_sma">'
                    . ''
                    . '                 <div class="title_sma"><strong >'.$value['sma_name'].'</strong> </div>'
                    . '                 <div class="text_downloads"> Temporadas Lançadas </div>'
                    . '                 <div class="text_downloads release">'.$value['temp'].'</div>'
                    . ''
                    . '                 <div class="text_downloads">Episódios Lançados </div>'
                    . '                 <div class="text_downloads release">'.$value['ep'].'</div>'
                    . ''
                    . '                 <div class="sustenta_botao_downloads">'
                    . '                     <a class="botao_downloads" href="/sma/showsma/'.$value['id_sma'].'"> Download </a>'
                    . '                 </div>'
                    . '              </div> '
                    . '      </div>'.$padraohtml[$key];
             
  
      
            
        }
         
        }
        else{
            
            if(empty($busca)){
                
                $padraohtml['sma'] = '<!-- #$NEW-SMA$# -->';
                $dado['sma'] = '<div style="color: red;">Por favor, forneça um nome de qualquer SMA.</div>';
            }
            else{
            $padraohtml['sma'] = '<!-- #$NEW-SMA$# -->';
            $dado['sma'] = '<div style="color: red;"> Nos desculpe, não conseguimos encontrar esse SMA.</div>';
            }
            
        }
       
         views::cut_in_view('page');
         views::cut_in_view('destaque-semana');
         views::replace_in_view($padraohtml, $dado);
         
         
         
     }
     
     
     public function content_404(){
         
            \views::load_view('404');
            \views::show_view();
     }
}

