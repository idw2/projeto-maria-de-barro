<?php

Class Carros extends Controller {

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
        
    }
    
    function novidades() {
          
        $model = new Produtos_Model();
        $categoria = "novidades";
        $limit = "LIMIT 0,4";
        $lista_de_produtos_1 = $model->produtos_lista_categorias($categoria, $limit);
        
        $limit = "LIMIT 5,4";
        $lista_de_produtos_2 = $model->produtos_lista_categorias($categoria, $limit);
        
        $limit = "LIMIT 9,4";
        $lista_de_produtos_3 = $model->produtos_lista_categorias($categoria, $limit);
        
        if(sizeof($lista_de_produtos_1)>0){
            $this->assign("lista_de_produtos_1", $lista_de_produtos_1);
        }
        
        if(sizeof($lista_de_produtos_2)>0){
            $this->assign("lista_de_produtos_2", $lista_de_produtos_2);
        }
        
        if(sizeof($lista_de_produtos_3)>0){
            $this->assign("lista_de_produtos_3", $lista_de_produtos_3);
        }
        
        
        $this->assign("language", LANGUAGE);
        $this->assign("page", "index");
        $this->assign("abas", "novidades");
        $this->assign("title", TITLE . "Novidades");
        
        $this->view_tpl("index");
    }

    function zero_km() {

        $model = new Produtos_Model();
        $categoria = "zero_km";
        $limit = "LIMIT 0,4";
        $lista_de_produtos_1 = $model->produtos_lista_categorias($categoria, $limit);
        
        $limit = "LIMIT 5,4";
        $lista_de_produtos_2 = $model->produtos_lista_categorias($categoria, $limit);
        
        $limit = "LIMIT 9,4";
        $lista_de_produtos_3 = $model->produtos_lista_categorias($categoria, $limit);
        
        if(sizeof($lista_de_produtos_1)>0){
            $this->assign("lista_de_produtos_1", $lista_de_produtos_1);
        }
        
        if(sizeof($lista_de_produtos_2)>0){
            $this->assign("lista_de_produtos_2", $lista_de_produtos_2);
        }
        
        if(sizeof($lista_de_produtos_3)>0){
            $this->assign("lista_de_produtos_3", $lista_de_produtos_3);
        }
        
        
        $this->assign("language", LANGUAGE);
        $this->assign("page", "index");
        $this->assign("abas", "zero_km");
        $this->assign("title", TITLE . "Zero KM");
        $this->view_tpl("index");
    }

    function seminovos() {

        $model = new Produtos_Model();
        $categoria = "seminovos";
        $limit = "LIMIT 0,4";
        $lista_de_produtos_1 = $model->produtos_lista_categorias($categoria, $limit);
        
        $limit = "LIMIT 5,4";
        $lista_de_produtos_2 = $model->produtos_lista_categorias($categoria, $limit);
        
        $limit = "LIMIT 9,4";
        $lista_de_produtos_3 = $model->produtos_lista_categorias($categoria, $limit);
        
        if(sizeof($lista_de_produtos_1)>0){
            $this->assign("lista_de_produtos_1", $lista_de_produtos_1);
        }
        
        if(sizeof($lista_de_produtos_2)>0){
            $this->assign("lista_de_produtos_2", $lista_de_produtos_2);
        }
        
        if(sizeof($lista_de_produtos_3)>0){
            $this->assign("lista_de_produtos_3", $lista_de_produtos_3);
        }
        
        $this->assign("language", LANGUAGE);
        $this->assign("page", "index");
        $this->assign("abas", "seminovos");
        $this->assign("title", TITLE . "Seminovos");
        $this->view_tpl("index");
    }

}
