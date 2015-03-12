<?php

Class Categoria extends Controller {

    public function __construct() {
        $this->get_smarty();
        $this->run();
        
        $this->assign("facebook", FACEBOOK );
        $this->assign("instagram", INSTAGRAM);
        $this->assign("twitter", TWITTER);
        $this->assign("google_plus", GOOGLE_PLUS);
        $this->assign("papel", PAPEL);
        $this->assign("email_restricao", $_SESSION["EMAIL"]);
        $this->assign("protocolo", PROTOCOLO);
        $this->assign("source", SOURCE);
        $this->assign("web_files", WEB_FILES);
        $this->assign("meu_site", MEU_SITE);
        $this->assign("nome_logon", $_SESSION["NOME"]);
        $this->assign("email_logon", $_SESSION["EMAIL"]);
        $this->assign("saudacao", $this->saudacao());
        
        $lista_desejos = new Produtos_Model();
       $ld = $lista_desejos->get_drop_lista_desejos(null, CLIENT_HIDDEN);
        if ($ld) {
            $this->assign("ld", $ld);
            $nenhum_produto = false;
        } else {
            $this->assign("nenhum_produto", true);
            $nenhum_produto = true;
        }
        
        $total_geral = $lista_desejos->get_total_geral_lista_desejos(CLIENT_HIDDEN);
        if($total_geral){
            $this->assign("total_geral", $total_geral->TOTAL_GERAL);
        }
        
        $total_produtos = $lista_desejos->get_total_produtos_lista_desejos(CLIENT_HIDDEN);
        if($total_produtos){
            $this->assign("total_produtos", $total_produtos->TOTAL_PRODUTOS);
        }
        
    }
    
    public function index() {
       
        $this->index_action();
    }
    
    public function index_action() {
         echo "<script>window.location='" . MEU_SITE . "'</script>";
        return false;
    }

    public function conjuntos() {

        $categoria = "conjuntos";
        ($categoria == "geral") ? $ctgr = null : $ctgr = $categoria;
        
        $this->assign("page", "conjuntos");
        
        $url = explode("/", $_GET["url"]);
        
        $url[0] = AntiXSS::setEncoding($this->xss_clean($url[0]), "UTF-8");
        $url[1] = AntiXSS::setEncoding($this->xss_clean($url[1]), "UTF-8");
        $url[2] = AntiXSS::setEncoding($this->xss_clean($url[2]), "UTF-8");
        $url[3] = AntiXSS::setEncoding($this->xss_clean($url[3]), "UTF-8");
        $url[4] = AntiXSS::setEncoding($this->xss_clean($url[4]), "UTF-8");
        $url[5] = AntiXSS::setEncoding($this->xss_clean($url[5]), "UTF-8");
        $url[6] = AntiXSS::setEncoding($this->xss_clean($url[6]), "UTF-8");
        $url[7] = AntiXSS::setEncoding($this->xss_clean($url[7]), "UTF-8");
        $url[8] = AntiXSS::setEncoding($this->xss_clean($url[8]), "UTF-8");
        $url[9] = AntiXSS::setEncoding($this->xss_clean($url[9]), "UTF-8");
        
        $qntdd = AntiXSS::setEncoding($this->xss_clean($this->getParameters("qntdd")), "UTF-8");
                
        if($qntdd == "" && $url[2] != "sort"){
            $qntdd = 16;  
        } else {
            ($url[2] == "sort")? $qntdd = $url[5]: $qntdd;
        }
        $this->assign("qntdd", $qntdd);
        
        $sort = $this->getParameters("sort");
        if($sort == "" && $url[2] != "sort"){
            $sort = "mais_novos";    
        } else {
            ($url[2] == "sort")? $sort = $url[3]: $sort;
        }
        $this->assign("sort", $sort);
        
        $pagina = $this->getParameters("pagina");
        if($pagina == "" && $url[2] != "sort"){
            $pagina = 1;   
        } else {
            ($url[2] == "sort")? $pagina = $url[7]: $pagina;  
        } 
        $this->assign("pagina", $pagina);
        
        $model = new Produtos_Model();
        
        $total_produto = (int)$model->qnts_produtos($ctgr);
        $this->assign("total_produto", $total_produto);
        
        $resto = ( $total_produto % $qntdd);
        $divisao = (( $total_produto - $resto )/$qntdd);
        $ultima_pagina = ($divisao+1);
        
        $btn_anterior = ( $pagina == 1 ) ? "" : ($pagina-1);
        $btn_proximo = ( $pagina == $ultima_pagina ) ? "" : ($pagina+1);
        
        $this->assign("btn_anterior", $btn_anterior);
        if($btn_anterior == "" && $btn_proximo != ""){
            $this->assign("btn_proximo", "/". LANGUAGE ."/{$categoria}/sort/{$sort}/qntdd/{$qntdd}/pagina/{$btn_proximo}");
        } else {
            $this->assign("btn_proximo", $btn_proximo);
        }
        
        $qual_pagina = ( $pagina == 1) ? 0 : ($qntdd*($pagina-1));
        $limit = "LIMIT {$qual_pagina},{$qntdd}";
        
        for($i=1;$i<=$ultima_pagina;$i++){
           if($i <= $ultima_pagina){
                $paginacao[] = $i;
           }
        }
        
        $de_um = $qual_pagina;
        ($de_um == 0) ? $de_um = 1 : $de_um;
        $this->assign("de_um", $de_um);
        $qnts = ($de_um+$qntdd);
        $a_tal = $qnts;
        ( $a_tal >= $total_produto ) ? $a_tal = $total_produto : $a_tal;
        $this->assign("a_tal", $a_tal);
        
        $this->assign("paginacao", $paginacao);
        $arr = $model->get_lista_produtos_categorias($ctgr, $limit, $sort);
        $this->assign("categoria", $categoria);
        
        $lista_desejos = "CLIENT_HIDDEN=" . CLIENT_HIDDEN . "&CODPRODUTO=";
        $this->assign("lista_desejos", $lista_desejos);
        
        $this->assign("arr", $arr);
        $this->assign("language", LANGUAGE);
        $this->assign("title", "Conjuntos | " .  TITLE);
        $this->view_tpl("categorias");
    }
    
    public function aneis() {

        $categoria = "aneis";
        ($categoria == "geral") ? $ctgr = null : $ctgr = $categoria;
        
        $this->assign("page", "aneis");
        
        $url = explode("/", $_GET["url"]);
        
        $url[0] = AntiXSS::setEncoding($this->xss_clean($url[0]), "UTF-8");
        $url[1] = AntiXSS::setEncoding($this->xss_clean($url[1]), "UTF-8");
        $url[2] = AntiXSS::setEncoding($this->xss_clean($url[2]), "UTF-8");
        $url[3] = AntiXSS::setEncoding($this->xss_clean($url[3]), "UTF-8");
        $url[4] = AntiXSS::setEncoding($this->xss_clean($url[4]), "UTF-8");
        $url[5] = AntiXSS::setEncoding($this->xss_clean($url[5]), "UTF-8");
        $url[6] = AntiXSS::setEncoding($this->xss_clean($url[6]), "UTF-8");
        $url[7] = AntiXSS::setEncoding($this->xss_clean($url[7]), "UTF-8");
        $url[8] = AntiXSS::setEncoding($this->xss_clean($url[8]), "UTF-8");
        $url[9] = AntiXSS::setEncoding($this->xss_clean($url[9]), "UTF-8");
        
        $qntdd = AntiXSS::setEncoding($this->xss_clean($this->getParameters("qntdd")), "UTF-8");
        
        if($qntdd == "" && $url[2] != "sort"){
            $qntdd = 16;  
        } else {
            ($url[2] == "sort")? $qntdd = $url[5]: $qntdd;
        }
        $this->assign("qntdd", $qntdd);
        
        $sort = $this->getParameters("sort");
        if($sort == "" && $url[2] != "sort"){
            $sort = "mais_novos";    
        } else {
            ($url[2] == "sort")? $sort = $url[3]: $sort;
        }
        $this->assign("sort", $sort);
        
        $pagina = $this->getParameters("pagina");
        if($pagina == "" && $url[2] != "sort"){
            $pagina = 1;   
        } else {
            ($url[2] == "sort")? $pagina = $url[7]: $pagina;  
        } 
        $this->assign("pagina", $pagina);
        
        $model = new Produtos_Model();
        
        $total_produto = (int)$model->qnts_produtos($ctgr);
        $this->assign("total_produto", $total_produto);
        
        $resto = ( $total_produto % $qntdd);
        $divisao = (( $total_produto - $resto )/$qntdd);
        $ultima_pagina = ($divisao+1);
        
        $btn_anterior = ( $pagina == 1 ) ? "" : ($pagina-1);
        $btn_proximo = ( $pagina == $ultima_pagina ) ? "" : ($pagina+1);
        
        $this->assign("btn_anterior", $btn_anterior);
        if($btn_anterior == "" && $btn_proximo != ""){
            $this->assign("btn_proximo", "/". LANGUAGE ."/{$categoria}/sort/{$sort}/qntdd/{$qntdd}/pagina/{$btn_proximo}");
        } else {
            $this->assign("btn_proximo", $btn_proximo);
        }
        
        $qual_pagina = ( $pagina == 1) ? 0 : ($qntdd*($pagina-1));
        $limit = "LIMIT {$qual_pagina},{$qntdd}";
        
        for($i=1;$i<=$ultima_pagina;$i++){
           if($i <= $ultima_pagina){
                $paginacao[] = $i;
           }
        }
        
        $de_um = $qual_pagina;
        ($de_um == 0) ? $de_um = 1 : $de_um;
        $this->assign("de_um", $de_um);
        $qnts = ($de_um+$qntdd);
        $a_tal = $qnts;
        ( $a_tal >= $total_produto ) ? $a_tal = $total_produto : $a_tal;
        $this->assign("a_tal", $a_tal);
        
        $this->assign("paginacao", $paginacao);
        $arr = $model->get_lista_produtos_categorias($ctgr, $limit, $sort);
        $this->assign("categoria", $categoria);
        
        $lista_desejos = "CLIENT_HIDDEN=" . CLIENT_HIDDEN . "&CODPRODUTO=";
        $this->assign("lista_desejos", $lista_desejos);
        
        $this->assign("arr", $arr);
        $this->assign("language", LANGUAGE);
        $this->assign("title", "Anéis | " . TITLE);
        $this->view_tpl("categorias");
    }
    
    public function brincos() {

        $categoria = "brincos";
        ($categoria == "geral") ? $ctgr = null : $ctgr = $categoria;
        
        $this->assign("page", "brincos");
        
        $url = explode("/", $_GET["url"]);
        
        $url[0] = AntiXSS::setEncoding($this->xss_clean($url[0]), "UTF-8");
        $url[1] = AntiXSS::setEncoding($this->xss_clean($url[1]), "UTF-8");
        $url[2] = AntiXSS::setEncoding($this->xss_clean($url[2]), "UTF-8");
        $url[3] = AntiXSS::setEncoding($this->xss_clean($url[3]), "UTF-8");
        $url[4] = AntiXSS::setEncoding($this->xss_clean($url[4]), "UTF-8");
        $url[5] = AntiXSS::setEncoding($this->xss_clean($url[5]), "UTF-8");
        $url[6] = AntiXSS::setEncoding($this->xss_clean($url[6]), "UTF-8");
        $url[7] = AntiXSS::setEncoding($this->xss_clean($url[7]), "UTF-8");
        $url[8] = AntiXSS::setEncoding($this->xss_clean($url[8]), "UTF-8");
        $url[9] = AntiXSS::setEncoding($this->xss_clean($url[9]), "UTF-8");
        
        $qntdd = AntiXSS::setEncoding($this->xss_clean($this->getParameters("qntdd")), "UTF-8");
                
        if($qntdd == "" && $url[2] != "sort"){
            $qntdd = 16;  
        } else {
            ($url[2] == "sort")? $qntdd = $url[5]: $qntdd;
        }
        $this->assign("qntdd", $qntdd);
        
        $sort = $this->getParameters("sort");
        if($sort == "" && $url[2] != "sort"){
            $sort = "mais_novos";    
        } else {
            ($url[2] == "sort")? $sort = $url[3]: $sort;
        }
        $this->assign("sort", $sort);
        
        $pagina = $this->getParameters("pagina");
        if($pagina == "" && $url[2] != "sort"){
            $pagina = 1;   
        } else {
            ($url[2] == "sort")? $pagina = $url[7]: $pagina;  
        } 
        $this->assign("pagina", $pagina);
        
        $model = new Produtos_Model();
        
        $total_produto = (int)$model->qnts_produtos($ctgr);
        $this->assign("total_produto", $total_produto);
        
        $resto = ( $total_produto % $qntdd);
        $divisao = (( $total_produto - $resto )/$qntdd);
        $ultima_pagina = ($divisao+1);
        
        $btn_anterior = ( $pagina == 1 ) ? "" : ($pagina-1);
        $btn_proximo = ( $pagina == $ultima_pagina ) ? "" : ($pagina+1);
        
        $this->assign("btn_anterior", $btn_anterior);
        if($btn_anterior == "" && $btn_proximo != ""){
            $this->assign("btn_proximo", "/". LANGUAGE ."/{$categoria}/sort/{$sort}/qntdd/{$qntdd}/pagina/{$btn_proximo}");
        } else {
            $this->assign("btn_proximo", $btn_proximo);
        }
        
        $qual_pagina = ( $pagina == 1) ? 0 : ($qntdd*($pagina-1));
        $limit = "LIMIT {$qual_pagina},{$qntdd}";
        
        for($i=1;$i<=$ultima_pagina;$i++){
           if($i <= $ultima_pagina){
                $paginacao[] = $i;
           }
        }
        
        $de_um = $qual_pagina;
        ($de_um == 0) ? $de_um = 1 : $de_um;
        $this->assign("de_um", $de_um);
        $qnts = ($de_um+$qntdd);
        $a_tal = $qnts;
        ( $a_tal >= $total_produto ) ? $a_tal = $total_produto : $a_tal;
        $this->assign("a_tal", $a_tal);
        
        $this->assign("paginacao", $paginacao);
        $arr = $model->get_lista_produtos_categorias($ctgr, $limit, $sort);
        $this->assign("categoria", $categoria);
        
        $lista_desejos = "CLIENT_HIDDEN=" . CLIENT_HIDDEN . "&CODPRODUTO=";
        $this->assign("lista_desejos", $lista_desejos);
        
        $this->assign("arr", $arr);
        $this->assign("language", LANGUAGE);
        $this->assign("title", TITLE . "Categoria | Brincos");
        $this->view_tpl("categorias");
    }
    
    public function colares() {

        $categoria = "colares";
        ($categoria == "geral") ? $ctgr = null : $ctgr = $categoria;
        
        $this->assign("page", "colares");
        
        $url = explode("/", $_GET["url"]);
        
        $url[0] = AntiXSS::setEncoding($this->xss_clean($url[0]), "UTF-8");
        $url[1] = AntiXSS::setEncoding($this->xss_clean($url[1]), "UTF-8");
        $url[2] = AntiXSS::setEncoding($this->xss_clean($url[2]), "UTF-8");
        $url[3] = AntiXSS::setEncoding($this->xss_clean($url[3]), "UTF-8");
        $url[4] = AntiXSS::setEncoding($this->xss_clean($url[4]), "UTF-8");
        $url[5] = AntiXSS::setEncoding($this->xss_clean($url[5]), "UTF-8");
        $url[6] = AntiXSS::setEncoding($this->xss_clean($url[6]), "UTF-8");
        $url[7] = AntiXSS::setEncoding($this->xss_clean($url[7]), "UTF-8");
        $url[8] = AntiXSS::setEncoding($this->xss_clean($url[8]), "UTF-8");
        $url[9] = AntiXSS::setEncoding($this->xss_clean($url[9]), "UTF-8");
        
        $qntdd = AntiXSS::setEncoding($this->xss_clean($this->getParameters("qntdd")), "UTF-8");
        
        if($qntdd == "" && $url[2] != "sort"){
            $qntdd = 16;  
        } else {
            ($url[2] == "sort")? $qntdd = $url[5]: $qntdd;
        }
        
        $this->assign("qntdd", $qntdd);
        
        $sort = $this->getParameters("sort");
        if($sort == "" && $url[2] != "sort"){
            $sort = "mais_novos";    
        } else {
            ($url[2] == "sort")? $sort = $url[3]: $sort;
        }
        $this->assign("sort", $sort);
        
        $pagina = $this->getParameters("pagina");
        if($pagina == "" && $url[2] != "sort"){
            $pagina = 1;   
        } else {
            ($url[2] == "sort")? $pagina = $url[7]: $pagina;  
        } 
        $this->assign("pagina", $pagina);
        
        $model = new Produtos_Model();
        
        $total_produto = (int)$model->qnts_produtos($ctgr);
        $this->assign("total_produto", $total_produto);
        
        $resto = ( $total_produto % $qntdd);
        $divisao = (( $total_produto - $resto )/$qntdd);
        $ultima_pagina = ($divisao+1);
        
        $btn_anterior = ( $pagina == 1 ) ? "" : ($pagina-1);
        $btn_proximo = ( $pagina == $ultima_pagina ) ? "" : ($pagina+1);
        
        $this->assign("btn_anterior", $btn_anterior);
        if($btn_anterior == "" && $btn_proximo != ""){
            $this->assign("btn_proximo", "/". LANGUAGE ."/{$categoria}/sort/{$sort}/qntdd/{$qntdd}/pagina/{$btn_proximo}");
        } else {
            $this->assign("btn_proximo", $btn_proximo);
        }
        
        $qual_pagina = ( $pagina == 1) ? 0 : ($qntdd*($pagina-1));
        $limit = "LIMIT {$qual_pagina},{$qntdd}";
        
        for($i=1;$i<=$ultima_pagina;$i++){
           if($i <= $ultima_pagina){
                $paginacao[] = $i;
           }
        }
        
        $de_um = $qual_pagina;
        ($de_um == 0) ? $de_um = 1 : $de_um;
        $this->assign("de_um", $de_um);
        $qnts = ($de_um+$qntdd);
        $a_tal = $qnts;
        ( $a_tal >= $total_produto ) ? $a_tal = $total_produto : $a_tal;
        $this->assign("a_tal", $a_tal);
        
        $this->assign("paginacao", $paginacao);
        $arr = $model->get_lista_produtos_categorias($ctgr, $limit, $sort);
        $this->assign("categoria", $categoria);
        
        $lista_desejos = "CLIENT_HIDDEN=" . CLIENT_HIDDEN . "&CODPRODUTO=";
        $this->assign("lista_desejos", $lista_desejos);
        
        $this->assign("arr", $arr);
        $this->assign("language", LANGUAGE);
        $this->assign("title", "Colares | " . TITLE);
        $this->view_tpl("categorias");
    }
    
    public function pulseiras() {

        $categoria = "pulseiras";
        ($categoria == "geral") ? $ctgr = null : $ctgr = $categoria;
        
        $this->assign("page", "pulseiras");
        
        $url = explode("/", $_GET["url"]);
        
        $url[0] = AntiXSS::setEncoding($this->xss_clean($url[0]), "UTF-8");
        $url[1] = AntiXSS::setEncoding($this->xss_clean($url[1]), "UTF-8");
        $url[2] = AntiXSS::setEncoding($this->xss_clean($url[2]), "UTF-8");
        $url[3] = AntiXSS::setEncoding($this->xss_clean($url[3]), "UTF-8");
        $url[4] = AntiXSS::setEncoding($this->xss_clean($url[4]), "UTF-8");
        $url[5] = AntiXSS::setEncoding($this->xss_clean($url[5]), "UTF-8");
        $url[6] = AntiXSS::setEncoding($this->xss_clean($url[6]), "UTF-8");
        $url[7] = AntiXSS::setEncoding($this->xss_clean($url[7]), "UTF-8");
        $url[8] = AntiXSS::setEncoding($this->xss_clean($url[8]), "UTF-8");
        $url[9] = AntiXSS::setEncoding($this->xss_clean($url[9]), "UTF-8");
        
        $qntdd = AntiXSS::setEncoding($this->xss_clean($this->getParameters("qntdd")), "UTF-8");
        
        if($qntdd == "" && $url[2] != "sort"){
            $qntdd = 16;  
        } else {
            ($url[2] == "sort")? $qntdd = $url[5]: $qntdd;
        }
        $this->assign("qntdd", $qntdd);
        
        $sort = $this->getParameters("sort");
        if($sort == "" && $url[2] != "sort"){
            $sort = "mais_novos";    
        } else {
            ($url[2] == "sort")? $sort = $url[3]: $sort;
        }
        $this->assign("sort", $sort);
        
        $pagina = $this->getParameters("pagina");
        if($pagina == "" && $url[2] != "sort"){
            $pagina = 1;   
        } else {
            ($url[2] == "sort")? $pagina = $url[7]: $pagina;  
        } 
        $this->assign("pagina", $pagina);
        
        $model = new Produtos_Model();
        
        $total_produto = (int)$model->qnts_produtos($ctgr);
        $this->assign("total_produto", $total_produto);
        
        $resto = ( $total_produto % $qntdd);
        $divisao = (( $total_produto - $resto )/$qntdd);
        $ultima_pagina = ($divisao+1);
        
        $btn_anterior = ( $pagina == 1 ) ? "" : ($pagina-1);
        $btn_proximo = ( $pagina == $ultima_pagina ) ? "" : ($pagina+1);
        
        $this->assign("btn_anterior", $btn_anterior);
        if($btn_anterior == "" && $btn_proximo != ""){
            $this->assign("btn_proximo", "/". LANGUAGE ."/{$categoria}/sort/{$sort}/qntdd/{$qntdd}/pagina/{$btn_proximo}");
        } else {
            $this->assign("btn_proximo", $btn_proximo);
        }
        
        $qual_pagina = ( $pagina == 1) ? 0 : ($qntdd*($pagina-1));
        $limit = "LIMIT {$qual_pagina},{$qntdd}";
        
        for($i=1;$i<=$ultima_pagina;$i++){
           if($i <= $ultima_pagina){
                $paginacao[] = $i;
           }
        }
        
        $de_um = $qual_pagina;
        ($de_um == 0) ? $de_um = 1 : $de_um;
        $this->assign("de_um", $de_um);
        $qnts = ($de_um+$qntdd);
        $a_tal = $qnts;
        ( $a_tal >= $total_produto ) ? $a_tal = $total_produto : $a_tal;
        $this->assign("a_tal", $a_tal);
        
        $this->assign("paginacao", $paginacao);
        $arr = $model->get_lista_produtos_categorias($ctgr, $limit, $sort);
        $this->assign("categoria", $categoria);
        
        $lista_desejos = "CLIENT_HIDDEN=" . CLIENT_HIDDEN . "&CODPRODUTO=";
        $this->assign("lista_desejos", $lista_desejos);
        
        $this->assign("arr", $arr);
        $this->assign("language", LANGUAGE);
        $this->assign("title", "Pulseiras | " .  TITLE);
        $this->view_tpl("categorias");
    }
    
   public function promocoes() {

        $categoria = "promocoes";
        $ctgr = $categoria;
        
        $this->assign("page", "promocoes");
        
        $url = explode("/", $_GET["url"]);
        
        $url[0] = AntiXSS::setEncoding($this->xss_clean($url[0]), "UTF-8");
        $url[1] = AntiXSS::setEncoding($this->xss_clean($url[1]), "UTF-8");
        $url[2] = AntiXSS::setEncoding($this->xss_clean($url[2]), "UTF-8");
        $url[3] = AntiXSS::setEncoding($this->xss_clean($url[3]), "UTF-8");
        $url[4] = AntiXSS::setEncoding($this->xss_clean($url[4]), "UTF-8");
        $url[5] = AntiXSS::setEncoding($this->xss_clean($url[5]), "UTF-8");
        $url[6] = AntiXSS::setEncoding($this->xss_clean($url[6]), "UTF-8");
        $url[7] = AntiXSS::setEncoding($this->xss_clean($url[7]), "UTF-8");
        $url[8] = AntiXSS::setEncoding($this->xss_clean($url[8]), "UTF-8");
        $url[9] = AntiXSS::setEncoding($this->xss_clean($url[9]), "UTF-8");
        
        $qntdd = AntiXSS::setEncoding($this->xss_clean($this->getParameters("qntdd")), "UTF-8");
        
        if($qntdd == "" && $url[2] != "sort"){
            $qntdd = 16;  
        } else {
            ($url[2] == "sort")? $qntdd = $url[5]: $qntdd;
        }
        $this->assign("qntdd", $qntdd);
        
        $sort = $this->getParameters("sort");
        if($sort == "" && $url[2] != "sort"){
            $sort = "mais_novos";    
        } else {
            ($url[2] == "sort")? $sort = $url[3]: $sort;
        }
        $this->assign("sort", $sort);
        
        $pagina = $this->getParameters("pagina");
        if($pagina == "" && $url[2] != "sort"){
            $pagina = 1;   
        } else {
            ($url[2] == "sort")? $pagina = $url[7]: $pagina;  
        } 
        $this->assign("pagina", $pagina);
        
        $model = new Produtos_Model();
        
        $total_produto = (int)$model->qnts_produtos($ctgr);
        $this->assign("total_produto", $total_produto);
        
        $resto = ( $total_produto % $qntdd);
        $divisao = (( $total_produto - $resto )/$qntdd);
        $ultima_pagina = ($divisao+1);
        
        $btn_anterior = ( $pagina == 1 ) ? "" : ($pagina-1);
        $btn_proximo = ( $pagina == $ultima_pagina ) ? "" : ($pagina+1);
        
        $this->assign("btn_anterior", $btn_anterior);
        if($btn_anterior == "" && $btn_proximo != ""){
            $this->assign("btn_proximo", "/". LANGUAGE ."/{$categoria}/sort/{$sort}/qntdd/{$qntdd}/pagina/{$btn_proximo}");
        } else {
            $this->assign("btn_proximo", $btn_proximo);
        }
        
        $qual_pagina = ( $pagina == 1) ? 0 : ($qntdd*($pagina-1));
        $limit = "LIMIT {$qual_pagina},{$qntdd}";
        
        for($i=1;$i<=$ultima_pagina;$i++){
           if($i <= $ultima_pagina){
                $paginacao[] = $i;
           }
        }
        
        $de_um = $qual_pagina;
        ($de_um == 0) ? $de_um = 1 : $de_um;
        $this->assign("de_um", $de_um);
        $qnts = ($de_um+$qntdd);
        $a_tal = $qnts;
        ( $a_tal >= $total_produto ) ? $a_tal = $total_produto : $a_tal;
        $this->assign("a_tal", $a_tal);
        
        $this->assign("paginacao", $paginacao);
        $arr = $model->get_lista_produtos_categorias($ctgr, $limit, $sort);
        $this->assign("categoria", $categoria);
        
        $lista_desejos = "CLIENT_HIDDEN=" . CLIENT_HIDDEN . "&CODPRODUTO=";
        $this->assign("lista_desejos", $lista_desejos);
        
        $this->assign("arr", $arr);
        $this->assign("language", LANGUAGE);
        $this->assign("title", "Promoções | " .  TITLE);
        $this->view_tpl("categorias");
    }
    
    
    public function mais_vendidos() {

        $categoria = "mais_vendidos";
        $ctgr = $categoria;
        
        $this->assign("language", LANGUAGE);
        $this->assign("page", "index");
        $this->assign("abas", "novidades");
        
        $url = explode("/", $_GET["url"]);
        
        $url[0] = AntiXSS::setEncoding($this->xss_clean($url[0]), "UTF-8");
        $url[1] = AntiXSS::setEncoding($this->xss_clean($url[1]), "UTF-8");
        $url[2] = AntiXSS::setEncoding($this->xss_clean($url[2]), "UTF-8");
        $url[3] = AntiXSS::setEncoding($this->xss_clean($url[3]), "UTF-8");
        $url[4] = AntiXSS::setEncoding($this->xss_clean($url[4]), "UTF-8");
        $url[5] = AntiXSS::setEncoding($this->xss_clean($url[5]), "UTF-8");
        $url[6] = AntiXSS::setEncoding($this->xss_clean($url[6]), "UTF-8");
        $url[7] = AntiXSS::setEncoding($this->xss_clean($url[7]), "UTF-8");
        $url[8] = AntiXSS::setEncoding($this->xss_clean($url[8]), "UTF-8");
        $url[9] = AntiXSS::setEncoding($this->xss_clean($url[9]), "UTF-8");
        
        $qntdd = AntiXSS::setEncoding($this->xss_clean($this->getParameters("qntdd")), "UTF-8");
        
        if($qntdd == "" && $url[2] != "sort"){
            $qntdd = 16;  
        } else {
            ($url[2] == "sort")? $qntdd = $url[5]: $qntdd;
        }
        $this->assign("qntdd", $qntdd);
        
        $sort = $this->getParameters("sort");
        if($sort == "" && $url[2] != "sort"){
            $sort = "mais_novos";    
        } else {
            ($url[2] == "sort")? $sort = $url[3]: $sort;
        }
        $this->assign("sort", $sort);
        
        $pagina = $this->getParameters("pagina");
        if($pagina == "" && $url[2] != "sort"){
            $pagina = 1;   
        } else {
            ($url[2] == "sort")? $pagina = $url[7]: $pagina;  
        } 
        $this->assign("pagina", $pagina);
        
        $model = new Produtos_Model();
        
        $total_produto = (int)$model->qnts_produtos($ctgr);
        $this->assign("total_produto", $total_produto);
        
        $resto = ( $total_produto % $qntdd);
        $divisao = (( $total_produto - $resto )/$qntdd);
        $ultima_pagina = ($divisao+1);
        
        $btn_anterior = ( $pagina == 1 ) ? "" : ($pagina-1);
        $btn_proximo = ( $pagina == $ultima_pagina ) ? "" : ($pagina+1);
        
        $this->assign("btn_anterior", $btn_anterior);
        if($btn_anterior == "" && $btn_proximo != ""){
            $this->assign("btn_proximo", "/". LANGUAGE ."/{$categoria}/sort/{$sort}/qntdd/{$qntdd}/pagina/{$btn_proximo}");
        } else {
            $this->assign("btn_proximo", $btn_proximo);
        }
        
        $qual_pagina = ( $pagina == 1) ? 0 : ($qntdd*($pagina-1));
        $limit = "LIMIT {$qual_pagina},{$qntdd}";
        
        for($i=1;$i<=$ultima_pagina;$i++){
           if($i <= $ultima_pagina){
                $paginacao[] = $i;
           }
        }
        
        $de_um = $qual_pagina;
        ($de_um == 0) ? $de_um = 1 : $de_um;
        $this->assign("de_um", $de_um);
        $qnts = ($de_um+$qntdd);
        $a_tal = $qnts;
        ( $a_tal >= $total_produto ) ? $a_tal = $total_produto : $a_tal;
        $this->assign("a_tal", $a_tal);
        
        $this->assign("paginacao", $paginacao);
        $arr = $model->get_lista_produtos_categorias($ctgr, $limit, $sort);
        $this->assign("categoria", $categoria);
        
        $lista_desejos = "CLIENT_HIDDEN=" . CLIENT_HIDDEN . "&CODPRODUTO=";
        $this->assign("lista_desejos", $lista_desejos);
        
        $this->assign("arr", $arr);
        $this->assign("language", LANGUAGE);
        $this->assign("title", "Mais Vendidos | " . TITLE);
        $this->view_tpl("categorias");
    }
    
    function novos_produtos() {

        $categoria = "geral";
        ($categoria == "geral") ? $ctgr = null : $ctgr = $categoria;
        
        $this->assign("language", LANGUAGE);
        $this->assign("page", "index");
        $this->assign("abas", "novidades");
        
        $url = explode("/", $_GET["url"]);
        
        $url[0] = AntiXSS::setEncoding($this->xss_clean($url[0]), "UTF-8");
        $url[1] = AntiXSS::setEncoding($this->xss_clean($url[1]), "UTF-8");
        $url[2] = AntiXSS::setEncoding($this->xss_clean($url[2]), "UTF-8");
        $url[3] = AntiXSS::setEncoding($this->xss_clean($url[3]), "UTF-8");
        $url[4] = AntiXSS::setEncoding($this->xss_clean($url[4]), "UTF-8");
        $url[5] = AntiXSS::setEncoding($this->xss_clean($url[5]), "UTF-8");
        $url[6] = AntiXSS::setEncoding($this->xss_clean($url[6]), "UTF-8");
        $url[7] = AntiXSS::setEncoding($this->xss_clean($url[7]), "UTF-8");
        $url[8] = AntiXSS::setEncoding($this->xss_clean($url[8]), "UTF-8");
        $url[9] = AntiXSS::setEncoding($this->xss_clean($url[9]), "UTF-8");
        
        $qntdd = AntiXSS::setEncoding($this->xss_clean($this->getParameters("qntdd")), "UTF-8");
        
        if($qntdd == "" && $url[2] != "sort"){
            $qntdd = 16;  
        } else {
            ($url[2] == "sort")? $qntdd = $url[5]: $qntdd;
        }
        $this->assign("qntdd", $qntdd);
        
        $sort = $this->getParameters("sort");
        if($sort == "" && $url[2] != "sort"){
            $sort = "mais_novos";    
        } else {
            ($url[2] == "sort")? $sort = $url[3]: $sort;
        }
        $this->assign("sort", $sort);
        
        $pagina = $this->getParameters("pagina");
        if($pagina == "" && $url[2] != "sort"){
            $pagina = 1;   
        } else {
            ($url[2] == "sort")? $pagina = $url[7]: $pagina;  
        } 
        $this->assign("pagina", $pagina);
        
        $model = new Produtos_Model();
        
        if($_POST){
           $search = AntiXSS::setEncoding($this->xss_clean($_POST["search"]), "UTF-8");
        } else {
           $search = AntiXSS::setEncoding($this->xss_clean($this->getParameters("search")), "UTF-8");
        }
        
        if( $search != ""){
            $this->assign("search", $search);
        }
        
        $total_produto = (int)$model->qnts_produtos($ctgr, $search);
        $this->assign("total_produto", $total_produto);
        
        $resto = ( $total_produto % $qntdd);
        $divisao = (( $total_produto - $resto )/$qntdd);
        $ultima_pagina = ($divisao+1);
        
        $btn_anterior = ( $pagina == 1 ) ? "" : ($pagina-1);
        $btn_proximo = ( $pagina == $ultima_pagina ) ? "" : ($pagina+1);
        
        $this->assign("btn_anterior", $btn_anterior);
        if($btn_anterior == "" && $btn_proximo != ""){
            $this->assign("btn_proximo", "/". LANGUAGE ."/{$categoria}/sort/{$sort}/qntdd/{$qntdd}/pagina/{$btn_proximo}");
        } else {
            $this->assign("btn_proximo", $btn_proximo);
        }
        
        $qual_pagina = ( $pagina == 1) ? 0 : ($qntdd*($pagina-1));
        $limit = "LIMIT {$qual_pagina},{$qntdd}";
        
        for($i=1;$i<=$ultima_pagina;$i++){
           if($i <= $ultima_pagina){
                $paginacao[] = $i;
           }
        }
        
        $de_um = $qual_pagina;
        ($de_um == 0) ? $de_um = 1 : $de_um;
        $this->assign("de_um", $de_um);
        $qnts = ($de_um+$qntdd);
        $a_tal = $qnts;
        ( $a_tal >= $total_produto ) ? $a_tal = $total_produto : $a_tal;
        $this->assign("a_tal", $a_tal);
        
        $this->assign("paginacao", $paginacao);
        $arr = $model->get_lista_produtos_categorias($ctgr, $limit, $sort, $search);
        $this->assign("categoria", $categoria);
        
        $lista_desejos = "CLIENT_HIDDEN=" . CLIENT_HIDDEN . "&CODPRODUTO=";
        $this->assign("lista_desejos", $lista_desejos);
        
        $this->assign("arr", $arr);
        $this->assign("language", LANGUAGE);
        $this->assign("title", "Categorias | " . TITLE);
        $this->view_tpl("categorias");
    }

}
