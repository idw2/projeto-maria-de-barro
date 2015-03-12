<?php

Class Descricao extends Controller {

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
        $this->assign("cep_remetente", CEP_REMETENTE);
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

    public function index_action() {
        $this->produtos_lista();
    }

    public function categoria() {
        
        $params = $this->array_url();
        
        $params[0] = AntiXSS::setEncoding($this->xss_clean($params[0]), "UTF-8");
        $params[1] = AntiXSS::setEncoding($this->xss_clean($params[1]), "UTF-8");
        $params[2] = AntiXSS::setEncoding($this->xss_clean($params[2]), "UTF-8");
        
        
        $url = explode("/", $_GET["url"]);
        
        $categoria = ( $params[0] == "") ? $url[1] : $params[0];
        $url_amigavel = ( $params[1] == "") ? $url[2] : $params[1];
        $abas = $params[2];
        
        if( $abas == "" || $abas == null ){
            $abas = "mais_informacoes";
        }
        
        $this->assign("page", $categoria);
        $this->assign("ctgr", $categoria);
        
        $model = new Produtos_Model();
        
        $produto = $model->get_produto($url_amigavel);
        $produto->NOME = utf8_encode($produto->NOME);
        $this->assign("total_parcial", $produto->PRECO);
        $this->assign("total_impostos", 0);
        $produto->PRECO = $this->formataReais($produto->PRECO);
        $produto->DE = $this->formataReais($produto->DE);
        $categoria_default = $produto->CATEGORIA;
        
        switch($produto->CATEGORIA){
            case "aneis": $produto->CATEGORIA = "Anéis";
            break;
            case "brincos": $produto->CATEGORIA= "Brinco";
            break;
            case "colares": $produto->CATEGORIA= "Colares";
            break;
            case "pulseiras": $produto->CATEGORIA= "Pulseiras";
            break;
        }

        $this->assign("codcadastro", $_SESSION["CODCADASTRO"]);
        $this->assign("url_amigavel", $url_amigavel);
        $this->assign("abas", $abas);
        $this->assign("codproduto", $produto->CODPRODUTO);
        $this->assign("dta", $produto->DTA);
        $this->assign("nome", $produto->NOME);
        $this->assign("url_amigavel", $produto->URL_AMIGAVEL);
        $this->assign("categoria", $produto->CATEGORIA);
        $this->assign("peso", (float)$produto->PESO);
        $this->assign("categoria_default", $categoria_default);
        $this->assign("preco", $produto->PRECO);
        $this->assign("preco_6", $model->preco_6x($produto->PRECO));
        $this->assign("linha_1", $produto->LINHA_1);
        $this->assign("linha_2", $produto->LINHA_2);
        $this->assign("linha_3", $produto->LINHA_3);
        $this->assign("is_promocao", $produto->IS_PROMOCAO);
        $this->assign("referencia", $produto->REFERENCIA);
        $this->assign("de", $produto->DE);
        $this->assign("ano", $produto->ANO);
        $this->assign("km", $produto->KM);
        $this->assign("cor", $produto->COR);
        $this->assign("combustivel", $produto->COMBUSTIVEL);
        $this->assign("portas", $produto->PORTAS);
        $this->assign("final_placa", $produto->FINAL_PLACA);
        $this->assign("carroceria", $produto->CARROCERIA);
        $this->assign("descricao", $produto->DESCRICAO);
        $this->assign("especificacoes", $produto->ESPECIFICACOES);
        $this->assign("destaque", $produto->DESTAQUE);
        $this->assign("ordem", $produto->ORDEM);
        $this->assign("quantidade",  $produto->QUANTIDADE);
        $this->assign("status",  $produto->STATUS);
        
        $fotos =  $model->get_crop_770($url_amigavel, 1);
        if(is_array($fotos)){
            foreach ($fotos as $foto){
                 $this->assign("foto_770", $foto->FOTO);
            }
        }
        
        $fotos =  $model->get_crop_550($url_amigavel, 1);
        if(is_array($fotos)){
            foreach ($fotos as $foto){
                 $this->assign("foto_550", $foto->FOTO);
            }
        }
        
        $fotos =  $model->get_crop_268($url_amigavel, 1);
        if(is_array($fotos)){
            foreach ($fotos as $foto){
                 $this->assign("foto_268", $foto->FOTO);
            }
        }
       
        $limit = "LIMIT 0,4";        
        $arr = $model->get_lista_produtos_relacionados_randon($categoria_default, $limit, $url_amigavel);
        $this->assign("arr", $arr);
        
        $limit = "LIMIT 0,8";        
        $promocoes = $model->get_lista_produtos_promocao($limit, $url_amigavel);
        
        $this->assign("promocoes", $promocoes);
        
        $fotos_full = $model->get_crop_full_images($url_amigavel);
        $this->assign("fotos_full", $fotos_full);
        
        $lista_desejos = "CLIENT_HIDDEN=" . CLIENT_HIDDEN . "&CODPRODUTO=" . $produto->CODPRODUTO;
        $this->assign("lista_desejos", $lista_desejos);
        
        //$fb_post_url =  "http://" . SITE . LANGUAGE ."/descricao/categoria/{$categoria_default}/{$url_amigavel}/comentarios";
        $fb_post_url =  "http://" . SITE . LANGUAGE ."{$categoria_default}/{$url_amigavel}";
        
        $this->assign("og_title", "{$produto->NOME} - mariadebarro.com");
        $this->assign("og_type", OG_TYPE);
        $this->assign("og_site_name", OG_SITE_NAME);
        $this->assign("og_descripition", preg_replace("/<(.+?)[\s]*\/?[\s]*>/si", "", $produto->DESCRICAO));
        $this->assign("og_email", OG_EMAIL);
        $this->assign("og_phone_number", OG_PHONE_NUMBER);
        $this->assign("og_street_address", OG_STREET_ADDRESS);
        $this->assign("og_locality", OG_LOCALITY);
        $this->assign("og_region", OG_REGION);
        $this->assign("og_country_name", OG_COUNTRY_NAME);
        $this->assign("og_postal_code", OG_POSTAL_CODE);
        
        $this->assign("fb_post_url", $fb_post_url);
        $this->assign("language", LANGUAGE);
        $this->assign("site", "http://" . SITE);
        $this->assign("dados", $_SESSION);
        $this->assign("title", $produto->NOME . " | " . TITLE);
        $this->view_tpl("descricao");
      
    }
}
