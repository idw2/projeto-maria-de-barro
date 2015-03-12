<?php

Class Informacoes extends Controller {

    function index() {
        return false;
    }

    public function __construct() {
        $this->get_smarty();
        $this->run();

        $this->assign("facebook", FACEBOOK);
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
        if ($total_geral) {
            $this->assign("total_geral", $total_geral->TOTAL_GERAL);
        }

        $total_produtos = $lista_desejos->get_total_produtos_lista_desejos(CLIENT_HIDDEN);
        if ($total_produtos) {
            $this->assign("total_produtos", $total_produtos->TOTAL_PRODUTOS);
        }
        
        $cts = new Conta_Model(); 
        $this->assign("existe_aniversariantes", $cts->existe_aniversariantes());
        
        $eame = new Produtos_Model(); 
        $this->assign("existe_avise_me", $eame->existe_avise_me());
        $this->assign("num_de_qntdd_produtos", $eame->num_de_qntdd_produtos());
        $this->assign("existe_novos_produtos_cadastrados", $eame->existe_novos_produtos_cadastrados());
    }

    function index_action() {

        $this->contato();
    }

    function quem_somos() {

        $model = new HTML_Model();
        $pagina = "quem_somos";
        $html = $model->get_page($pagina);
        $conteudo = $html->CONTEUDO;

        $this->assign("language", LANGUAGE);
        $this->assign("page", "quem_somos");
        $this->assign("conteudo", $conteudo);
        $this->assign("title", "Quem somos | " . TITLE);
        $this->view_tpl("quem_somos");
    }

    function politica_privacidade() {

        $model = new HTML_Model();
        $pagina = "politica_privacidade";
        $html = $model->get_page($pagina);
        $conteudo = $html->CONTEUDO;

        $this->assign("language", LANGUAGE);
        $this->assign("page", "politica_privacidade");
        $this->assign("conteudo", $conteudo);
        $this->assign("title", TITLE . "Política de Privacidade");
        $this->view_tpl("politica_privacidade");
    }

    function promocoes() {

        $model = new HTML_Model();
        $pagina = "promocoes";
        $html = $model->get_page($pagina);
        $conteudo = $html->CONTEUDO;

        $this->assign("language", LANGUAGE);
        $this->assign("page", "promocoes");
        $this->assign("conteudo", $conteudo);
        $this->assign("title", TITLE . "Promoções");
        $this->view_tpl("promocoes");
    }

    function programa_vantagens() {

        $model = new HTML_Model();
        $pagina = "programa_vantagens";
        $html = $model->get_page($pagina);
        $conteudo = $html->CONTEUDO;

        $this->assign("language", LANGUAGE);
        $this->assign("page", "programa_vantagens");
        $this->assign("conteudo", $conteudo);
        $this->assign("title", TITLE . "Programa de Vantages");
        $this->view_tpl("programa_vantagens");
    }

    function programa_fidelidade() {

        $model = new HTML_Model();
        $pagina = "programa_fidelidade";
        $html = $model->get_page($pagina);
        $conteudo = $html->CONTEUDO;

        $this->assign("language", LANGUAGE);
        $this->assign("page", "programa_fidelidade");
        $this->assign("conteudo", $conteudo);
        $this->assign("title", TITLE . "Programa de Fidelidade");
        $this->view_tpl("programa_fidelidade");
    }

    function termos_servicos() {

        $model = new HTML_Model();
        $pagina = "termos_servicos";
        $html = $model->get_page($pagina);
        $conteudo = $html->CONTEUDO;

        $this->assign("language", LANGUAGE);
        $this->assign("page", "termos_servicos");
        $this->assign("conteudo", $conteudo);
        $this->assign("title", TITLE . "Termos de Serviço");
        $this->view_tpl("termos_servicos");
    }

    function forma_pagamento() {

        $model = new HTML_Model();
        $pagina = "forma_pagamento";
        $html = $model->get_page($pagina);
        $conteudo = $html->CONTEUDO;

        $this->assign("language", LANGUAGE);
        $this->assign("page", "termos_servicos");
        $this->assign("conteudo", $conteudo);
        $this->assign("title", TITLE . "Forma de Pagamento");
        $this->view_tpl("forma_pagamento");
    }

    function trocas_e_devolucoes() {

        $model = new HTML_Model();
        $pagina = "entrega_devolucao";
        $html = $model->get_page($pagina);
        $conteudo = $html->CONTEUDO;

        $this->assign("language", LANGUAGE);
        $this->assign("page", "entrega_devolucao");
        $this->assign("conteudo", $conteudo);
        $this->assign("title", TITLE . "Entrega e Devolução");
        $this->view_tpl("entrega_devolucao");
    }

    function procon_rj() {

        $model = new HTML_Model();
        $pagina = "procon_rj";
        $html = $model->get_page($pagina);
        $conteudo = $html->CONTEUDO;

        $this->assign("language", LANGUAGE);
        $this->assign("page", "procon_rj");
        $this->assign("conteudo", $conteudo);
        $this->assign("title", TITLE . "PROCON-RJ");
        $this->view_tpl("procon_rj");
    }

    function perguntas_frequentes() {

        $model = new HTML_Model();
        $pagina = "perguntas_frequentes";
        $html = $model->get_page($pagina);
        $conteudo = $html->CONTEUDO;

        $this->assign("language", LANGUAGE);
        $this->assign("page", "perguntas_frequentes");
        $this->assign("conteudo", $conteudo);
        $this->assign("title", TITLE . "Perguntas Frequentes");
        $this->view_tpl("perguntas_frequentes");
    }

    function cuidados_produtos() {

        $model = new HTML_Model();
        $pagina = "cuidados_produtos";
        $html = $model->get_page($pagina);
        $conteudo = $html->CONTEUDO;

        $this->assign("language", LANGUAGE);
        $this->assign("page", "cuidados_produtos");
        $this->assign("conteudo", $conteudo);
        $this->assign("title", TITLE . "Cuidado com os Produtos");
        $this->view_tpl("cuidados_produtos");
    }

    public function contato() {

        $erro = "";
        $sucesso = "FALSE";

        if ($_POST) {

            $nome = $this->trata_nome($_POST["nome"]);
            $email = AntiXSS::setEncoding($this->xss_clean($_POST["email"]), "UTF-8");
            //$assunto = "=?UTF-8?B?".base64_encode($_POST["assunto"])."?=";
            $assunto = AntiXSS::setEncoding($this->xss_clean($_POST["assunto"]), "UTF-8");
            $mensagem = AntiXSS::setEncoding($this->xss_clean(stripslashes($_POST["mensagem"])), "UTF-8");

            $this->assign("nome", $nome);
            $this->assign("email", $email);
            $this->assign("assunto", $assunto);
            $this->assign("mensagem", $mensagem);

            if (!preg_match('/^[a-zA-ZÁ-Üá-ü]{1,}([ ]{1}[a-zA-ZÁ-Üá-ü]{1,})+$/', $nome)) {
                $erro = "Confira o nome digitado!";
            } else if (!preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $email)) {
                $erro = "E-mail inválido!";
            } else if ($assunto == "") {
                $erro = "Assunto requerido!";
            } else if ($mensagem == "") {
                $erro = "Escreva a sua mensagem!";
            }

            if ($erro == "") {

                $sucesso = "TRUE";
                $this->assign("nome", "");
                $this->assign("email", "");
                $this->assign("assunto", "");
                $this->assign("mensagem", "");
                $erro = "Mensagem enviada com sucesso!";

                $quebra_linha = "\n";
                $emailsender = "maria@mariadebarro.com.br";
                $nomeremetente = "Maria de Barro";
                $emaildesitnatario = "maria@mariadebarro.com.br";
                $comcopia = $email;
                $assunto_texto = $assunto;
                $assunto = "=?UTF-8?B?" . base64_encode($assunto) . "?=";

                $link = "https://" . SITE;


                $vars["nome"] = $nome;
                $vars["email"] = $email;
                $vars["mensagem"] = $mensagem;
                $vars["assunto"] = $assunto_texto;
                $model = new Informacoes_Model();
                $vars["timestamp"] = $model->getTimestamp();
                
                $mensagemHTML = $this->view_email_print("emails/contato", $vars);

                $headers = "MIME-Version: 1.1{$quebra_linha}";
                $headers .= "Content-type: text/html; charset=UTF-8{$quebra_linha}";
                $headers .= "From: \"{$nomeremetente}\"<{$emailsender}>{$quebra_linha}";
                $headers .= "Return-Path: {$emailsender}{$quebra_linha}";
                $headers .= "Cc: {$comcopia}{$quebra_linha}";
                $headers .= "Reply-To: {$emaildesitnatario}{$quebra_linha}";
                $headers .= "X-Mailer: PHP/" . phpversion();

                mail($emaildesitnatario, '[CONTATO] ' . $assunto, $mensagemHTML, $headers, "-f" . $emailsender);
            }

            $this->assign("language", LANGUAGE);
            $this->assign("erro", $erro);
            $this->assign("sucesso", $sucesso);
            $this->assign("title", TITLE . "Fale conosco");
            $this->view_tpl("contato");
        } else {

            $this->assign("language", LANGUAGE);
            $this->assign("erro", $erro);
            $this->assign("sucesso", $sucesso);
            $this->assign("title", TITLE . "Fale conosco");
            $this->view_tpl("contato");
        }
    }

    public function newsletter_footer() {

        $email = $_POST["email"];

        if ($email == "") {
            echo "<span style='color: yellow;'>* E-mail requerido!</span>";
        } else if (!preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $email)) {
            echo "<span style='color: yellow;'>* E-mail inválido!</span>";
        } else {

            $model = new Informacoes_Model();

            if ($model->existe_email_newsletter($email)) {
                $inscrito = $model->get_inscrito_newsletter($email);
                $model->update_status_newsletter($inscrito->CODNEWSLETTER, 1);
                echo "<span style='color: yellow;'>* E-mail já cadastrado em nossa newsletter!</span>";
            } else {

                $dados["CODNEWSLETTER"] = $this->getPrimarykey();
                $dados["NOME"] = AntiXSS::setEncoding($this->xss_clean(trim($nome)), "UTF-8");
                $dados["EMAIL"] = AntiXSS::setEncoding($this->xss_clean(trim($email)), "UTF-8");
                $dados["SEXO"] = AntiXSS::setEncoding($this->xss_clean($sexo), "UTF-8");
                $dados["STATUS"] = 1;

                $model->insert_newsletter($dados);
                echo "<span style='color: yellow;'>* Inscrição realizada com sucesso!</span>";

                $link = "https://" . SITE;

                $quebra_linha = "\n";
                $emailsender = "maria@mariadebarro.com.br";
                $nomeremetente = "Maria de Barro";
                $emaildesitnatario = $email;
                $assunto = "=?UTF-8?B?" . base64_encode("Inscrição de newsletter") . "?=";

                $mensagemHTML = $this->view_email('emails/newsletter_footer');

                $headers = "MIME-Version: 1.1{$quebra_linha}";
                $headers .= "Content-type: text/html; charset=UTF-8{$quebra_linha}";
                $headers .= "From: \"{$nomeremetente}\"<{$emailsender}>{$quebra_linha}";
                $headers .= "Return-Path: {$emailsender}{$quebra_linha}";
                $headers .= "Reply-To: {$comcopia}{$quebra_linha}";
                $headers .= "X-Mailer: PHP/" . phpversion();

                mail($emaildesitnatario, $assunto, $mensagemHTML, $headers, "-f" . $emailsender);
            }
        }
        exit();
    }

    public function newsletter() {

        $erro = "";
        $sucesso = "FALSE";
        $this->assign("language", LANGUAGE);

        $this->assign("email", $_POST["email"]);


        if ($_POST) {

            $nome = AntiXSS::setEncoding($this->xss_clean($this->trata_nome($_POST["nome"])), "UTF-8");
            $email = AntiXSS::setEncoding($this->xss_clean($_POST["email"]), "UTF-8");
            $sexo = AntiXSS::setEncoding($this->xss_clean($this->trata_nome($_POST["sexo"])), "UTF-8");
            $termos = AntiXSS::setEncoding($this->xss_clean($_POST["termos"]), "UTF-8");

            $this->assign("nome", $nome);
            $this->assign("email", $email);
            $this->assign("sexo", $sexo);
            $this->assign("termos", $termos);

            if (!preg_match('/^[a-zA-ZÁ-Üá-ü]{1,}([ ]{1}[a-zA-ZÁ-Üá-ü]{1,})+$/', $nome)) {
                $erro = "Confira o seu nome!";
            } else if (!preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $email)) {
                $erro = "E-mail inválido!";
            } else if ($termos == "") {
                $erro = "Termos requerido!";
            }

            if ($erro == "") {

                $sucesso = "TRUE";
                $this->assign("nome", "");
                $this->assign("email", "");
                $this->assign("sexo", "");
                $this->assign("termos", "");

                $dados["CODNEWSLETTER"] = $this->getPrimarykey();
                $dados["NOME"] = trim($nome);
                $dados["EMAIL"] = trim($email);
                $dados["SEXO"] = $sexo;
                $dados["STATUS"] = 1;

                $model = new Informacoes_Model();

                if ($model->existe_email_newsletter($email)) {
                    $inscrito = $model->get_inscrito_newsletter($email);
                    $model->update_status_newsletter($inscrito->CODNEWSLETTER, 1);

                    $sucesso = "FALSE";
                    $erro = "E-mail já cadastrado em nossa newsletter!";
                } else {

                    $model->insert_newsletter($dados);

                    $erro = "Inscrição realizada com sucesso!";

                    $link = "https://" . SITE;

                    $quebra_linha = "\n";
                    $emailsender = "maria@mariadebarro.com.br";
                    $nomeremetente = "Maria de Barro";
                    $emaildesitnatario = $email;
                    $assunto = "=?UTF-8?B?" . base64_encode("Inscrição de newsletter") . "?=";

                    $vars["nome"] = $dados["NOME"];
                    
                    $mensagemHTML = $this->view_email_print('emails/newsletter', $vars);

                    $headers = "MIME-Version: 1.1{$quebra_linha}";
                    $headers .= "Content-type: text/html; charset=UTF-8{$quebra_linha}";
                    $headers .= "From: \"{$nomeremetente}\"<{$emailsender}>{$quebra_linha}";
                    $headers .= "Return-Path: {$emailsender}{$quebra_linha}";
                    $headers .= "Reply-To: {$comcopia}{$quebra_linha}";
                    $headers .= "X-Mailer: PHP/" . phpversion();

                    mail($emaildesitnatario, $assunto, $mensagemHTML, $headers, "-f" . $emailsender);
                }
            }


            $this->assign("erro", $erro);
            $this->assign("sucesso", $sucesso);
            $this->assign("title", TITLE . "Inscrição de newsletter");
            $this->view_tpl("newsletter");
        } else {

            $this->assign("erro", $erro);
            $this->assign("sucesso", $sucesso);
            $this->assign("title", TITLE . "Inscrição de newsletter");
            $this->view_tpl("newsletter");
        }
    }

    public function newsletter_lista() {
        if ($this->permitir_acesso($_SESSION["EMAIL"], $_SESSION["SENHA"], "ADMINISTRADOR")) {

            $model = new Informacoes_Model();

            $this->assign("categoria", "todos");

            if ($_POST["actionType"] == "pesquisa_categoria") {

                $_POST["categoria"];
                $this->assign("categoria", $_POST["categoria"]);

                if ($_POST["categoria"] != "todos") {
                    $meus_produtos = $model->select_produtos_all($_POST["categoria"]);
                } else {
                    $meus_produtos = $model->select_produtos_all();
                }

                if (!$meus_produtos) {
                    $this->assign("ERRO_NAO_EXISTE_PRODUTOS", "ERRO_NAO_EXISTE_PRODUTOS");
                }
                $this->assign("meus_produtos", $meus_produtos);
            } else if ($_POST["actionType"] == "search" && $_POST["search"] != "") {

                $meus_produtos = $model->select_produtos_all_search($_POST["search"]);
                if (!$meus_produtos) {
                    $this->assign("ERRO_NAO_EXISTE_PRODUTOS", "ERRO_NAO_EXISTE_PRODUTOS");
                }
                $this->assign("meus_produtos", $meus_produtos);
            } else {

                $newsletters = $model->get_newsletter();
                if (!$newsletters) {
                    $this->assign("ERRO_NAO_NEWSLETTER", "ERRO_NAO_NEWSLETTER");
                }
                $this->assign("newsletters", $newsletters);
            }

            $this->assign("language", LANGUAGE);
            $this->assign("email", $email);
            $this->assign("page", "newsletter_lista");
            $this->assign("dados", $_SESSION);
            $this->assign("title", TITLE . "Lista de Newsletter");
            $this->view_tpl("admin/newsletter_lista");
        }
    }

    public function newsletter_status() {
        if ($this->permitir_acesso($_SESSION["EMAIL"], $_SESSION["SENHA"], "ADMINISTRADOR")) {

            $arr = $this->array_url();
            $email = $arr[1];
            $stt = $arr[0];

            $model = new Informacoes_Model();
            $model->update_status($email, $stt);

            echo "<script>window.location='/" . LANGUAGE . "/informacoes/newsletter_lista'</script>";
            exit();
        }
    }

    public function avise_me_chegar() {


        $email = AntiXSS::setEncoding($this->xss_clean($_POST["EMAIL"]), "UTF-8");
        $referencia = AntiXSS::setEncoding($this->xss_clean($_POST["REFERENCIA"]), "UTF-8");

        if (!preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $email)) {
            echo "E-mail inválido!";
        } else {

            $dados["CODNEWSLETTER"] = $this->getPrimarykey();
            $dados["NOME"] = trim($nome);
            $dados["EMAIL"] = trim($email);
            $dados["SEXO"] = $sexo;
            $dados["STATUS"] = 1;

            $model = new Informacoes_Model();

            if ($model->existe_email_newsletter($email)) {
                $inscrito = $model->get_inscrito_newsletter($email);
                $model->update_status_newsletter($inscrito->CODNEWSLETTER, 1);
                

                $avise_me["CODAVISEME"] = $this->getPrimarykey();
                $avise_me["EMAIL"] = trim($email);
                $avise_me["REFERENCIA"] = trim($referencia);
                $avise_me["STATUS"] = 1;
                
                if(!$model->existe_avise_me($email, $referencia)){
                    $model->insert_avise_me($avise_me);
                }
                echo "OK!";
                
            } else {

                $model->insert_newsletter($dados);
                
                $avise_me["CODAVISEME"] = $this->getPrimarykey();
                $avise_me["EMAIL"] = trim($email);
                $avise_me["REFERENCIA"] = trim($referencia);
                $avise_me["STATUS"] = 1;
                
                if(!$model->existe_avise_me($email, $referencia)){
                    $model->insert_avise_me($avise_me);
                }
                echo "OK!";
                
            }
        }
    }
}
