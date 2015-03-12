<?php

Class HTML extends Controller {
    
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
        
        $cts = new Conta_Model(); 
        $this->assign("existe_aniversariantes", $cts->existe_aniversariantes());
        
        $eame = new Produtos_Model(); 
        $this->assign("existe_avise_me", $eame->existe_avise_me());
        $this->assign("num_de_qntdd_produtos", $eame->num_de_qntdd_produtos());
        
    }
    
    public function quem_somos() {
        
        if ($this->permitir_acesso($_SESSION["EMAIL"], $_SESSION["SENHA"], "ADMINISTRADOR")) {
            $model = new HTML_Model();
            $pagina = "quem_somos";

            if ($_POST) {
                $conteudo = trim(stripslashes($_POST['conteudo']));
                $model->update_conteudo($pagina, $conteudo);
                echo "<script>alert('* Dados atualizados com sucesso!')</script>";
            }

            $html = $model->get_page($pagina);
            $conteudo = $html->CONTEUDO;

            $this->assign("language", LANGUAGE);
            $this->assign("page", "quem_somos");
            $this->assign("conteudo", $conteudo);
            $this->assign("title", "Quem Somos | " . TITLE);
            $this->view_tpl("admin/quem_somos");
        }
    }

    public function promocoes() {
        if ($this->permitir_acesso($_SESSION["EMAIL"], $_SESSION["SENHA"], "ADMINISTRADOR")) {
            $model = new HTML_Model();
            $pagina = "promocoes";

            if ($_POST) {
                $conteudo = trim(stripslashes($_POST['conteudo']));
                $model->update_conteudo($pagina, $conteudo);
                echo "<script>alert('* Dados atualizados com sucesso!')</script>";
            }

            $html = $model->get_page($pagina);
            $conteudo = $html->CONTEUDO;

            $this->assign("language", LANGUAGE);
            $this->assign("page", "promocoes");
            $this->assign("conteudo", $conteudo);
            $this->assign("title", "Promoções | " . TITLE );
            $this->view_tpl("admin/promocoes");
        }
    }

    public function programa_vantagens() {

        if ($this->permitir_acesso($_SESSION["EMAIL"], $_SESSION["SENHA"], "ADMINISTRADOR")) {
            $model = new HTML_Model();
            $pagina = "programa_vantagens";

            if ($_POST) {
                $conteudo = trim(stripslashes($_POST['conteudo']));
                $model->update_conteudo($pagina, $conteudo);
                echo "<script>alert('* Dados atualizados com sucesso!')</script>";
            }

            $html = $model->get_page($pagina);
            $conteudo = $html->CONTEUDO;

            $this->assign("language", LANGUAGE);
            $this->assign("page", "programa_vantagens");
            $this->assign("conteudo", $conteudo);
            $this->assign("title", "Programa de Vantagens | " . TITLE);
            $this->view_tpl("admin/programa_vantagens");
        }
    }

    public function programa_fidelidade() {

        if ($this->permitir_acesso($_SESSION["EMAIL"], $_SESSION["SENHA"], "ADMINISTRADOR")) {
            $model = new HTML_Model();
            $pagina = "programa_fidelidade";

            if ($_POST) {
                $conteudo = trim(stripslashes($_POST['conteudo']));
                $model->update_conteudo($pagina, $conteudo);
                echo "<script>alert('* Dados atualizados com sucesso!')</script>";
            }

            $html = $model->get_page($pagina);
            $conteudo = $html->CONTEUDO;

            $this->assign("language", LANGUAGE);
            $this->assign("page", "programa_fidelidade");
            $this->assign("conteudo", $conteudo);
            $this->assign("title", "Programa de Fidelidade | " . TITLE);
            $this->view_tpl("admin/programa_fidelidade");
        }
    }

    public function politica_privacidade() {

        if ($this->permitir_acesso($_SESSION["EMAIL"], $_SESSION["SENHA"], "ADMINISTRADOR")) {
            $model = new HTML_Model();
            $pagina = "politica_privacidade";

            if ($_POST) {
                $conteudo = trim(stripslashes($_POST['conteudo']));
                $model->update_conteudo($pagina, $conteudo);
                echo "<script>alert('* Dados atualizados com sucesso!')</script>";
            }

            $html = $model->get_page($pagina);
            $conteudo = $html->CONTEUDO;

            $this->assign("language", LANGUAGE);
            $this->assign("page", "politica_privacidade");
            $this->assign("conteudo", $conteudo);
            $this->assign("title", "Política de Privacidade | " . TITLE);
            $this->view_tpl("admin/politica_privacidade");
        }
    }
    
    public function termos_servicos() {

        if ($this->permitir_acesso($_SESSION["EMAIL"], $_SESSION["SENHA"], "ADMINISTRADOR")) {
            $model = new HTML_Model();
            $pagina = "termos_servicos";

            if ($_POST) {
                $conteudo = trim(stripslashes($_POST['conteudo']));
                $model->update_conteudo($pagina, $conteudo);
                echo "<script>alert('* Dados atualizados com sucesso!')</script>";
            }

            $html = $model->get_page($pagina);
            $conteudo = $html->CONTEUDO;

            $this->assign("language", LANGUAGE);
            $this->assign("page", "termos_servicos");
            $this->assign("conteudo", $conteudo);
            $this->assign("title", "Termos de serviço | " . TITLE);
            $this->view_tpl("admin/termos_servicos");
        }
    }
    
    public function forma_pagamento() {

        if ($this->permitir_acesso($_SESSION["EMAIL"], $_SESSION["SENHA"], "ADMINISTRADOR")) {
            $model = new HTML_Model();
            $pagina = "forma_pagamento";

            if ($_POST) {
                $conteudo = trim(stripslashes($_POST['conteudo']));
                $model->update_conteudo($pagina, $conteudo);
                echo "<script>alert('* Dados atualizados com sucesso!')</script>";
            }

            $html = $model->get_page($pagina);
            $conteudo = $html->CONTEUDO;

            $this->assign("language", LANGUAGE);
            $this->assign("page", "forma_pagamento");
            $this->assign("conteudo", $conteudo);
            $this->assign("title", "Forma de Pagamento | " . TITLE);
            $this->view_tpl("admin/forma_pagamento");
        }
    }
    
    public function entrega_devolucao() {

        if ($this->permitir_acesso($_SESSION["EMAIL"], $_SESSION["SENHA"], "ADMINISTRADOR")) {
            $model = new HTML_Model();
            $pagina = "entrega_devolucao";

            if ($_POST) {
                $conteudo = trim(stripslashes($_POST['conteudo']));
                $model->update_conteudo($pagina, $conteudo);
                echo "<script>alert('* Dados atualizados com sucesso!')</script>";
            }

            $html = $model->get_page($pagina);
            $conteudo = $html->CONTEUDO;

            $this->assign("language", LANGUAGE);
            $this->assign("page", "entrega_devolucao");
            $this->assign("conteudo", $conteudo);
            $this->assign("title", "Entrega e Devolvolução | " . TITLE);
            $this->view_tpl("admin/entrega_devolucao");
        }
    }
    
    public function procon_rj() {

        if ($this->permitir_acesso($_SESSION["EMAIL"], $_SESSION["SENHA"], "ADMINISTRADOR")) {
            $model = new HTML_Model();
            $pagina = "procon_rj";

            if ($_POST) {
                $conteudo = trim(stripslashes($_POST['conteudo']));
                $model->update_conteudo($pagina, $conteudo);
                echo "<script>alert('* Dados atualizados com sucesso!')</script>";
            }

            $html = $model->get_page($pagina);
            $conteudo = $html->CONTEUDO;

            $this->assign("language", LANGUAGE);
            $this->assign("page", "procon_rj");
            $this->assign("conteudo", $conteudo);
            $this->assign("title", "PROCON-RJ | " . TITLE);
            $this->view_tpl("admin/procon_rj");
        }
    }
    
    public function perguntas_frequentes() {

        if ($this->permitir_acesso($_SESSION["EMAIL"], $_SESSION["SENHA"], "ADMINISTRADOR")) {
            $model = new HTML_Model();
            $pagina = "perguntas_frequentes";

            if ($_POST) {
                $conteudo = trim(stripslashes($_POST['conteudo']));
                $model->update_conteudo($pagina, $conteudo);
                echo "<script>alert('* Dados atualizados com sucesso!')</script>";
            }

            $html = $model->get_page($pagina);
            $conteudo = $html->CONTEUDO;

            $this->assign("language", LANGUAGE);
            $this->assign("page", "perguntas_frequentes");
            $this->assign("conteudo", $conteudo);
            $this->assign("title", "Perguntas Frequentes | " . TITLE);
            $this->view_tpl("admin/perguntas_frequentes");
        }
    }
    
    public function cuidados_produtos() {

        if ($this->permitir_acesso($_SESSION["EMAIL"], $_SESSION["SENHA"], "ADMINISTRADOR")) {
            $model = new HTML_Model();
            $pagina = "cuidados_produtos";

            if ($_POST) {
                $conteudo = trim(stripslashes($_POST['conteudo']));
                $model->update_conteudo($pagina, $conteudo);
                echo "<script>alert('* Dados atualizados com sucesso!')</script>";
            }

            $html = $model->get_page($pagina);
            $conteudo = $html->CONTEUDO;

            $this->assign("language", LANGUAGE);
            $this->assign("page", "cuidados_produtos");
            $this->assign("conteudo", $conteudo);
            $this->assign("title", "Cuidado com os Produtos | " . TITLE);
            $this->view_tpl("admin/cuidados_produtos");
        }
    }

}
