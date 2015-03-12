<?php

Class Admin extends Controller {

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

    public function index_action() {
        $this->login();
    }

    public function login() {

        $erro = "";
        $sucesso = "FALSE";

        $model = new Conta_Model();

        if ($model->confere_senha($_SESSION["EMAIL"], $_SESSION["SENHA"])) {
            echo "<script>window.location='" . MEU_SITE . "admin/welcome'</script>";
            exit();
        }

        if ($_POST) {

            
            
            $email = AntiXSS::setEncoding($this->xss_clean($_POST["email"]), "UTF-8");
            $senha = AntiXSS::setEncoding($this->xss_clean($_POST["senha"]), "UTF-8");

            if ($email == "" && $senha == "") {
                $erro = "Preencha todos os campos!";
            } else if (!preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $email)) {
                $erro = "E-mail inválido!";
            } else if ($senha == "") {
                $erro = "Senha requerida!";
            } else {



                if ($model->existe_conta($email)) {

                    $senha = $this->senhaMd5($senha);
                    if ($model->confere_senha($email, $senha)) {
                        if ($model->testa_status($email, $senha)) {

                            foreach ($model->get_dados_conta($email) as $name => $value) {
                                $_SESSION[$name] = $value;
                            }
                            echo "<script>window.location='" . MEU_SITE . "admin/welcome'</script>";
                            return false;
                        } else {
                            $erro = "Acesso negado, entre em contato com o administrador!";
                        }
                    } else {
                        $erro = "Senha não confere!";
                    }
                } else {
                    $erro = "E-mail inexistente!";
                }
            }


            $this->assign("language", LANGUAGE);
            $this->assign("erro", $erro);
            $this->assign("sucesso", $sucesso);
            $this->assign("email", $email);
            $this->assign("title", TITLE . "Painel administrativo");
            $this->view_tpl("admin/index");
        } else {

            $this->assign("language", LANGUAGE);
            $this->assign("erro", $erro);
            $this->assign("sucesso", $sucesso);
            $this->assign("title", TITLE . "Painel administrativo");
            $this->view_tpl("admin/index");
        }
    }

    public function welcome() {
        if ($this->permitir_acesso($_SESSION["EMAIL"], $_SESSION["SENHA"])) {

            $this->assign("language", LANGUAGE);
            $this->assign("email", $email);
            $this->assign("page", "welcome");
            $this->assign("dados", $_SESSION);
            $this->assign("title", TITLE . "Bem vindo");
            $this->view_tpl("admin/welcome");
        }
    }

    public function logout() {

        session_destroy();

        $this->assign("language", LANGUAGE);
        $this->assign("erro", $erro);
        $this->assign("sucesso", $sucesso);
        $this->assign("title", TITLE . "Painel administrativo");
        $this->view_tpl("admin/index");
    }

    public function alterar_senha() {
        if ($this->permitir_acesso($_SESSION["EMAIL"], $_SESSION["SENHA"])) {

            $sucesso = "FALSE";
            $erro = "";

            if ($_POST) {
                
                $senha_atual = AntiXSS::setEncoding($this->xss_clean($_POST["senha_atual"]), "UTF-8");
                $senha_nova = AntiXSS::setEncoding($this->xss_clean($_POST["senha_nova"]), "UTF-8");
                $senha_repetir = AntiXSS::setEncoding($this->xss_clean($_POST["senha_repetir"]), "UTF-8");

                if ($senha_atual == "") {
                    $erro = "Senha atual requerida!";
                } else if ($senha_nova == "") {
                    $erro = "Nova senha requerida!";
                } else if ($senha_repetir == "") {
                    $erro = "Repetir senha requerida!";
                } else if ($this->senhaMd5($senha_atual) != $_SESSION["SENHA"]) {
                    $erro = "Senha atual não confere!";
                } else if ($senha_nova != $senha_repetir) {
                    $erro = "Senhas digitadas diferentes!";
                } else {
                    $model = new Conta_Model();
                    if ($model->update_senha($_SESSION["CODCONTA"], $this->senhaMd5($senha_nova))) {
                        echo "<script>alert('Senha atualizada com sucesso, sua sessão será encerrada!')</script>";
                        $this->logout();
                        return false;
                    }
                }
            }

            $this->assign("language", LANGUAGE);
            $this->assign("erro", $erro);
            $this->assign("sucesso", $sucesso);
            $this->assign("page", "alterar_senha");
            $this->assign("dados", $_SESSION);
            $this->assign("title", TITLE . "Alterar senha");
            $this->view_tpl("admin/alterar_senha");
        }
    }

    public function atendentes_lista() {
        if ($this->permitir_acesso($_SESSION["EMAIL"], $_SESSION["SENHA"], "ADMINISTRADOR")) {

            $model = new Admin_Model();
            
            $atendentes = $model->get_atendentes();
            if(!$atendentes){
                $this->assign("ERRO_NAO_EXITE_ATENDENTE", "ERRO_NAO_EXITE_ATENDENTE");
            }
            $this->assign("atendentes", $atendentes);
            
            $this->assign("language", LANGUAGE);
            $this->assign("page", "atendentes_lista");
            $this->assign("dados", $_SESSION);
            $this->assign("title", TITLE . "Lista de atendentes");
            $this->view_tpl("admin/atendentes_lista");
        }
    }

    public function cadastrar_atendente() {
        if ($this->permitir_acesso($_SESSION["EMAIL"], $_SESSION["SENHA"], "ADMINISTRADOR")) {

            $sucesso = "FALSE";
            $erro = "";

            if ($_POST) {

                $nome = AntiXSS::setEncoding($this->xss_clean($this->trata_nome($_POST["nome"])), "UTF-8");
                $email = AntiXSS::setEncoding($this->xss_clean($_POST["email"]), "UTF-8");
                $sexo = AntiXSS::setEncoding($this->xss_clean($this->trata_nome($_POST["sexo"])), "UTF-8");
                $status = AntiXSS::setEncoding($this->xss_clean(($_POST["status"] == "on") ? 1 : 0), "UTF-8");
                $senha = AntiXSS::setEncoding($this->xss_clean($this->senhaMd5($_POST["senha"])), "UTF-8");

                $this->assign("nome", $nome);
                $this->assign("email", $email);
                $this->assign("sexo", $sexo);
                $this->assign("status", $status);

                if (!preg_match('/^[a-zA-ZÁ-Üá-ü]{1,}([ ]{1}[a-zA-ZÁ-Üá-ü]{1,})+$/', $nome)) {
                    $erro = "Confira o seu nome!";
                } else if (!preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $email)) {
                    $erro = "E-mail inválido!";
                } 

                if ($erro == "") {

                    $sucesso = "TRUE";

                    $dados["CODCONTA"] = $this->getPrimarykey();
                    $dados["NOME"] = trim($nome);
                    $dados["EMAIL"] = trim($email);
                    $dados["SEXO"] = $sexo;
                    $dados["STATUS"] = $status;
                    $dados["PAPEL"] = "ATENDENTE";
                    $dados["SENHA"] = $senha;
                    
                    $model = new Admin_Model();

                    if ($model->existe_email_conta($email)) {
                        $sucesso = "FALSE";
                        $erro = "E-mail já cadastrado!";
                    } else {
                        $model->insert_conta($dados);
                        echo "<script>window.location='/" . LANGUAGE . "/admin/atendentes_lista'</script>";
                        exit();
                    }

                }

                $this->assign("language", LANGUAGE);
                $this->assign("erro", $erro);
                $this->assign("sucesso", $sucesso);
                $this->assign("page", "atendentes_lista");
                $this->assign("dados", $_SESSION);
                $this->assign("title", TITLE . "Cadastro de atendente");
                $this->view_tpl("admin/cadastrar_atendente");
                
            } else {

                $this->assign("language", LANGUAGE);
                $this->assign("erro", $erro);
                $this->assign("sucesso", $sucesso);
                $this->assign("page", "atendentes_lista");
                $this->assign("dados", $_SESSION);
                $this->assign("title", TITLE . "Cadastro de atendente");
                $this->view_tpl("admin/cadastrar_atendente");
            }
        }
    }
    
    public function status() {
        if ($this->permitir_acesso($_SESSION["EMAIL"], $_SESSION["SENHA"], "ADMINISTRADOR")) {

            $arr = $this->array_url();
            $email = $arr[1];
            $stt = $arr[0];

            $model = new Admin_Model();
            $model->update_status_conta($email, $stt);

            echo "<script>window.location='" . MEU_SITE . "admin/atendentes_lista'</script>";
            exit();
        }        
    }
    
    public function delete() {
        if ($this->permitir_acesso($_SESSION["EMAIL"], $_SESSION["SENHA"], "ADMINISTRADOR")) {

            $arr = $this->array_url();
            $email = $arr[0];

            $model = new Admin_Model();
            $model->del_conta($email);

            echo "<script>window.location='" . MEU_SITE . "admin/atendentes_lista'</script>";
            exit();
        }
    }
    
    public function editar() {
        
        if ($this->permitir_acesso($_SESSION["EMAIL"], $_SESSION["SENHA"], "ADMINISTRADOR")) {

            $sucesso = "FALSE";
            $erro = "";
            
            $arr = $this->array_url();
            $email = $arr[0];

            $model = new Admin_Model();
            
            $conta = $model->get_conta($email);
            
            $this->assign("nome", $conta->NOME);
            $this->assign("sexo", $conta->SEXO);
            $this->assign("status", $conta->STATUS);
            $this->assign("email", $conta->EMAIL);
            
            if ($_POST) {

                $nome = AntiXSS::setEncoding($this->xss_clean($this->trata_nome($_POST["nome"])), "UTF-8");
                $sexo = AntiXSS::setEncoding($this->xss_clean($this->trata_nome($_POST["sexo"])), "UTF-8");
                $status = AntiXSS::setEncoding($this->xss_clean(($_POST["status"] == "on") ? 1 : 0), "UTF-8");
                $senha = AntiXSS::setEncoding($this->xss_clean($this->senhaMd5($_POST["senha"])), "UTF-8");
                $trocar_senha = AntiXSS::setEncoding($this->xss_clean(($_POST["trocar_senha"] == "on") ? true : false), "UTF-8");

                $this->assign("nome", $nome);
                $this->assign("sexo", $sexo);
                $this->assign("status", $status);

                if (!preg_match('/^[a-zA-ZÁ-Üá-ü]{1,}([ ]{1}[a-zA-ZÁ-Üá-ü]{1,})+$/', $nome)) {
                    $erro = "Confira o seu nome!";
                } 

                if ($erro == "") {

                    $sucesso = "TRUE";

                    $dados["CODCONTA"] = $this->getPrimarykey();
                    $dados["NOME"] = trim($nome);
                    $dados["SEXO"] = $sexo;
                    $dados["STATUS"] = $status;
                    if($trocar_senha){
                        $dados["SENHA"] = $senha;
                    }                    
                    
                    $model->update_conta($dados, $email);
                    echo "<script>window.location='" . MEU_SITE . "admin/atendentes_lista'</script>";
                    exit();

                }

                $this->assign("language", LANGUAGE);
                $this->assign("erro", $erro);
                $this->assign("sucesso", $sucesso);
                $this->assign("page", "atendentes_lista");
                $this->assign("dados", $_SESSION);
                $this->assign("title", TITLE . "Editar atendente");
                $this->view_tpl("admin/editar_atendente");
                
            } else {

                $this->assign("language", LANGUAGE);
                $this->assign("erro", $erro);
                $this->assign("sucesso", $sucesso);
                $this->assign("page", "atendentes_lista");
                $this->assign("dados", $_SESSION);
                $this->assign("title", TITLE . "Editar atendente");
                $this->view_tpl("admin/editar_atendente");
            }
        }
    }
}
