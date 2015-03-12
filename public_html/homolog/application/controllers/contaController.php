<?php

Class Conta extends Controller {

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
        $this->assign("site", SITE);
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

        if (strlen($_SESSION["CODCADASTRO"]) == 32) {
            $this->assign("controle", TRUE);
            $this->assign("nome", $_SESSION["NOME"]);
            $this->assign("email", $_SESSION["EMAIL"]);
            $this->assign("saudacao", $this->saudacao());
        }
        
        $cts = new Conta_Model(); 
        $this->assign("existe_aniversariantes", $cts->existe_aniversariantes());
        
        $eame = new Produtos_Model(); 
        $this->assign("existe_avise_me", $eame->existe_avise_me());
        $this->assign("num_de_qntdd_produtos", $eame->num_de_qntdd_produtos());
    }

    public function index_action() {
        if ($this->permitir_acesso_comprador_redirect()) {
            $this->meus_pedidos();
        } else {
            $this->login_cadastro();
        }
    }

    public function login_cadastro() {

        $model = new Cadastro_Model();

        if ($_POST["actionType"] == "criar_conta") {


            $email = AntiXSS::setEncoding($this->xss_clean($_POST["email"]), "UTF-8");
            $this->assign("email_conta", $email);
            if (!preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $email)) {
                $this->assign("msg_erro", "E-mail inválido");
            } else if ($model->existe_cadastro($_POST["email"])) {
                $this->assign("msg_erro", "E-mail já registrado! Caso tenha dificuldades em acessar sua conta, por favor, vá em \"Esqueceu sua Senha\"!");
            } else {

                $quebra_linha = "\n";
                $emailsender = "maria@mariadebarro.com.br";
                $nomeremetente = "Maria de Barro";
                $emaildesitnatario = "maria@mariadebarro.com.br";
                $comcopia = $email;
                $assunto_texto = "Solicitação de criação de conta!";
                $assunto = "=?UTF-8?B?" . base64_encode($assunto_texto) . "?=";

                $_SERVER['EMAIL_CRIACAO'] = base64_encode($email);
                
                echo "<script>window.location='https://www.mariadebarro.com.br/pt/conta/criar-conta/email/" . $_SERVER['EMAIL_CRIACAO'] . "'</script>";     
                die();
                        
                $this->view_email("emails/criacao_conta");
                $mensagemHTML = $_SERVER['EMAIL_HTML'];

                $headers = "MIME-Version: 1.1{$quebra_linha}";
                $headers .= "Content-type: text/html; charset=UTF-8{$quebra_linha}";
                $headers .= "From: \"{$nomeremetente}\"<{$emailsender}>{$quebra_linha}";
                $headers .= "Return-Path: {$emailsender}{$quebra_linha}";
                $headers .= "Cc: {$comcopia}{$quebra_linha}";
                $headers .= "Reply-To: {$emaildesitnatario}{$quebra_linha}";
                $headers .= "X-Mailer: PHP/" . phpversion();

                mail($emaildesitnatario, $assunto, $mensagemHTML, $headers, ALIAS_EMAIL . $emailsender);

                $this->assign("msg_erro", "Uma mensagem foi encaminhada para seu e-mail!");
            }
        } else if ($_POST["actionType"] == "login") {

            $email = AntiXSS::setEncoding($this->xss_clean($_POST["email"]), "UTF-8");
            $this->assign("email_login", $email);
            $password = AntiXSS::setEncoding($this->xss_clean($_POST["senha"]), "UTF-8");

            $model = new Cadastro_Model();

            if ($email == "") {
                $this->assign("msg_erro_login", "E-mail requerido!");
            } elseif ($password == "") {
                $this->assign("msg_erro_login", "Senha requerida!");
            } else {
                if ($model->existe_cadastro($email)) {
                    $password = $this->senhaMd5($password);
                    if ($model->valida_cadastro($email, $password)) {

                        foreach ($model->get_dados_cadastro($email) as $name => $value) {
                            $_SESSION[$name] = $value;
                        }
                        //echo "<script>window.location='" . MEU_SITE . "conta/login-cadastro/'</script>";
                        echo "<script>window.location='" . MEU_SITE . "'</script>";
                        exit();
                    } else {
                        $this->assign("msg_erro_login", "Senha inválida!");
                    }
                } else {
                    $this->assign("msg_erro_login", "E-mail não existe!");
                }
            }
        }

        $this->assign("language", LANGUAGE);
        $this->assign("dados", $_SESSION);

        $url_checkout = "CLIENT_HIDDEN=" . CLIENT_HIDDEN . "&CODPRODUTO=";

        $this->assign("url_checkout", $url_checkout);
        $this->assign("cep_remetente", CEP_REMETENTE);
        $this->assign("title", "Login | " .  TITLE);
        $this->assign("page", "minha-conta");
        $return["pagina"] = $this->view_tpl("autenticacao2");
        //echo json_encode($return);
    }

    public function endereco() {

        if ($this->permitir_acesso_comprador()) {

            $model = new Cadastro_Model();
            $this->assign("language", LANGUAGE);
            $this->assign("dados", $_SESSION);
            $this->assign("erro", "");

            $url_checkout = "CLIENT_HIDDEN=" . CLIENT_HIDDEN . "&CODPRODUTO=";

            if ($_POST) {

                foreach ($_POST as $name => $value) {
                    $this->assign($name, $value);
                }


                #echo AntiXSS::setEncoding($_POST["cidade"], "UTF-8");
                #echo $this->xss_clean(utf8_decode($_POST["cidade"]));

                $dados['CODENDERECO'] = $this->getPrimarykey();
                $dados['CEP'] = AntiXSS::setEncoding($_POST["cep"], "UTF-8");
                $dados['LOGRADOURO'] = AntiXSS::setEncoding($_POST["logradouro"], "UTF-8");
                $dados['NUMERO'] = AntiXSS::setEncoding($_POST["numero"], "UTF-8");
                $dados['COMPLEMENTO'] = AntiXSS::setEncoding($_POST["complemento"], "UTF-8");
                $dados['BAIRRO'] = AntiXSS::setEncoding($_POST["bairro"], "UTF-8");
                $dados['CIDADE'] = AntiXSS::setEncoding($_POST["cidade"], "UTF-8");
                $dados['UF'] = AntiXSS::setEncoding($_POST["estado"], "UTF-8");

                if (strlen($dados['CEP']) != 9) {
                    $erro = "* CEP requerido ou inválido!";
                } else if ($dados['LOGRADOURO'] == "") {
                    $erro = "* Logradouro requerido!";
                } else if ($dados['NUMERO'] == "") {
                    $erro = "* Número requerido!";
                } else if ($dados['BAIRRO'] == "") {
                    $erro = "* Bairro requerido!";
                } else if ($dados['CIDADE'] == "") {
                    $erro = "* Cidade requerida!";
                } else if (strlen($dados['UF']) != 2) {
                    $erro = "* UF requerida ou inválido!";
                }

                if ($erro == "") {

                    ($model->existe_enderecos($_SESSION['CODCADASTRO'])) ? $dados['STATUS'] = 0 : $dados['STATUS'] = 1;

                    if ($model->insert_endereco($dados)) {

                        $dados_rel['CODCADASTRO'] = $_SESSION['CODCADASTRO'];
                        $dados_rel['CODENDERECO'] = $dados['CODENDERECO'];

                        if (!$model->insert_cadastro_rel_endereco($dados_rel)) {
                            $erro = "Ocorreu um erro ao tentar cadastrar este endereço, tente mais novamente tarde!";
                        } else {
                            foreach ($_POST as $name => $value) {
                                $this->assign($name, "");
                                if ($name == "complemento" || $name == "enviar") {
                                    continue;
                                }
                            }
                        }
                    } else {
                        $erro = "Ocorreu um erro ao tentar cadastrar este endereço, tente mais novamente tarde!";
                    }
                }
            }

            $this->assign("sem_endereco", (int) $model->qtdd_enderecos($_SESSION["CODCADASTRO"]));
            $this->assign("endereco_list", $model->get_enderecos($_SESSION['CODCADASTRO']));
            $this->assign("codcadastro", $_SESSION['CODCADASTRO']);
            $this->assign("erro", $erro);
            $this->assign("nome", "{$this->saudacao()} {$_SESSION["NOME"]}");
            $this->assign("url_checkout", $url_checkout);
            $this->assign("cep_remetente", CEP_REMETENTE);
            $this->assign("title", "Meus Endereços | " . TITLE);
            $this->assign("page", "meus-enderecos");
            $this->view_tpl("endereco2");
        }
    }

    public function sair() {

        session_destroy();
        //echo "<script>window.location='" . MEU_SITE . "conta/login-cadastro/'</script>";
        echo "<script>window.location='" . MEU_SITE . "'</script>";
        exit();
    }

    public function criar_conta() {

        $model = new Produtos_Model();

        $this->assign("language", LANGUAGE);
        $this->assign("dados", $_SESSION);

        $url_checkout = "CLIENT_HIDDEN=" . CLIENT_HIDDEN . "&CODPRODUTO=";

        $arr = $this->array_url();

        $email = base64_decode($arr[1]);
        if ($email) {
            $this->assign("email", $email);
            $this->assign("email_base", $arr[1]);
        }

        $dia = "<select name='dia' class='form-control'>";
        $dia .= "<optgroup label='Dia'>";
        for ($i = 1; $i < 32; $i++) {
            (strlen($i) == 1) ? $count = "0{$i}" : $count = $i;
            ($_POST["dia"] == $count) ? $dia .= "<option value='{$count}' selected>{$count}</option>" : $dia .= "<option value='{$count}'>{$count}</option>";
        }
        $dia .= "</optgroup>";
        $dia .= "</select>";

        $mes = "<select name='mes' class='form-control'>";
        $mes .= "<optgroup label='Mês'>";
        for ($i = 1; $i < 13; $i++) {
            (strlen($i) == 1) ? $count = "0{$i}" : $count = $i;
            ($_POST["mes"] == $count) ? $mes .= "<option value='{$count}' selected>{$count}</option>" : $mes .= "<option value='{$count}'>{$count}</option>";
        }
        $mes .= "</optgroup>";
        $mes .= "</select>";


        $ano = "<select name='ano' class='form-control'>";
        $ano .= "<optgroup label='Ano'>";

        $y = (int) date("Y");
        $y = ($y - 14);
        $ref = 1899;
        while ($y != $ref) {
            ($_POST["ano"] == $y) ? $ano .= "<option value='{$y}' selected>{$y}</option>" : $ano .= "<option value='{$y}'>{$y}</option>";
            $y--;
        }
        $ano .= "</optgroup>";
        $ano .= "</select>";
        $aniversario = $dia . "&nbsp;" . $mes . "&nbsp;" . $ano;

        $model = new Cadastro_Model();

        if ($_POST) {

            if (sizeof($_POST)) {
                foreach ($_POST as $name => $value) {
                    $this->assign("{$name}", "{$value}");
                }
            }

            $codcadastro = $this->getPrimarykey();
            $nome = AntiXSS::setEncoding($this->xss_clean($this->trata_nome($_POST["nome"])), "UTF-8");
            $email = AntiXSS::setEncoding($this->xss_clean(strtolower($_POST["email"])), "UTF-8");
            $nascimento = AntiXSS::setEncoding($this->xss_clean($_POST["ano"] . "-" . $_POST["mes"] . "-" . $_POST["dia"]), "UTF-8");
            $sexo = AntiXSS::setEncoding($this->xss_clean($_POST["sexo"]), "UTF-8");
            $ddd = AntiXSS::setEncoding($this->xss_clean($_POST["ddd"]), "UTF-8");
            $tel = AntiXSS::setEncoding($this->xss_clean($_POST["tel"]), "UTF-8");
            $ramal = AntiXSS::setEncoding($this->xss_clean($_POST["ramal"]), "UTF-8");
            $passwd = AntiXSS::setEncoding($this->xss_clean($_POST["passwd"]), "UTF-8");
            $passwd2 = AntiXSS::setEncoding($this->xss_clean($_POST["passwd2"]), "UTF-8");
            $lembrete = AntiXSS::setEncoding($this->xss_clean($_POST["lembrete"]), "UTF-8");
            $cpf = AntiXSS::setEncoding($this->xss_clean($this->limpaCpf($_POST["cpf"])), "UTF-8");

            if (!preg_match('/^[a-zA-ZÁ-Üá-ü]{1,}([ ]{1}[a-zA-ZÁ-Üá-ü]{1,})+$/', $nome)) {
                $erro = "Confira o nome digitado!";
            } elseif (!preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $email)) {
                $erro = "E-mail inválido!";
            } elseif ($ddd == "") {
                $erro = "Campo DDD requerido!";
            } elseif ($sexo == "") {
                $erro = "Sexo requerido!";
            } elseif ($nascimento == "") {
                $erro = "Data de nacimento requerido!";
            } elseif ($tel == "") {
                $erro = "Campo Telefone requerido!";
            } elseif (!$this->validaCPF($cpf)) {
                $erro = "CPF inválido!";
            } elseif ($model->existe_cpf($cpf) > 0) {
                $erro = "CPF já cadastrado!";
            } elseif ($passwd == "") {
                $erro = "Campo Senha requerido!";
            } elseif ($passwd2 == "") {
                $erro = "Campo Repetir senha requerido!";
            } elseif ($passwd2 != $passwd) {
                $erro = "Senhas digitadas são diferentes!";
            } elseif ($lembrete == "") {
                $erro = "Campo Lembrete de senha requerido!";
            }

            if ($erro == "") {

                if ($model->existe_cadastro($email)) {
                    $erro = "Este e-mail já está cadastrado!";
                } else {
                    $passwd = $this->senhaMd5($passwd);

                    $dados["CODCADASTRO"] = $codcadastro;
                    $dados["SEXO"] = $sexo;
                    $dados["NASCIMENTO"] = $nascimento;
                    $dados["NOME"] = $nome;
                    $dados["EMAIL"] = $email;
                    $dados["DDD"] = $ddd;
                    $dados["TELEFONE"] = $tel;
                    $dados["CPF"] = $cpf;
                    $dados["RAMAL"] = $ramal;
                    $dados["PASSWORD"] = $passwd;
                    $dados["LEMBRETE"] = $lembrete;
                    $dados["STATUS"] = 1;

                    if (!$model->insert_cadastro($dados)) {
                        $erro = "Problemas ao tentar criar a sua conta, tente novamente!";
                    } else {

                        $quebra_linha = "\n";
                        $emailsender = "maria@mariadebarro.com.br";
                        $nomeremetente = "Maria de Barro";
                        $emaildesitnatario = "maria@mariadebarro.com.br";
                        $comcopia = $email;
                        $assunto_texto = "Conta criada com sucesso!";
                        $assunto = "=?UTF-8?B?" . base64_encode($assunto_texto) . "?=";

                        $_SERVER["EMAIL_NOME_CONTA"] = $nome;
                        $_SERVER["EMAIL_LINK"] = $link;
                        $_SERVER["EMAIL_EMAIL"] = $email;
                        $_SERVER["EMAIL_LEMBRETE"] = $lembrete;

                        $this->view_email("emails/confirmacao_cadastro");
                        $mensagemHTML = $_SERVER['EMAIL_HTML'];

                        $headers = "MIME-Version: 1.1{$quebra_linha}";
                        $headers .= "Content-type: text/html; charset=UTF-8{$quebra_linha}";
                        $headers .= "From: \"{$nomeremetente}\"<{$emailsender}>{$quebra_linha}";
                        $headers .= "Return-Path: {$emailsender}{$quebra_linha}";
                        $headers .= "Cc: {$comcopia}{$quebra_linha}";
                        $headers .= "Reply-To: {$emaildesitnatario}{$quebra_linha}";
                        $headers .= "X-Mailer: PHP/" . phpversion();

                        mail($emaildesitnatario, $assunto, $mensagemHTML, $headers, ALIAS_EMAIL . $emailsender);

                        foreach ($dados as $n => $v) {
                            $_SESSION[$n] = $v;
                        }
                        //echo "<script>window.location='" . MEU_SITE . "conta/login-cadastro/'</script>";
                        echo "<script>window.location='" . MEU_SITE . "produtos/checkout/'</script>";
                        //echo "<script>window.location='" . MEU_SITE . "'</script>";
                        exit();
                    }
                }
            }
        }


        $this->assign("aniversario", $aniversario);
        $this->assign("erro", $erro);
        $this->assign("url_checkout", $url_checkout);
        $this->assign("cep_remetente", CEP_REMETENTE);
        $this->assign("title", "Criar conta | " .  TITLE );
        $this->assign("page", "login");
        $this->view_tpl("criar_conta");
    }

    public function meus_dados() {

        if ($this->permitir_acesso_comprador()) {

            $model = new Produtos_Model();

            $this->assign("language", LANGUAGE);
            $this->assign("dados", $_SESSION);

            $url_checkout = "CLIENT_HIDDEN=" . CLIENT_HIDDEN . "&CODPRODUTO=";


            $email = $_SESSION["EMAIL"];

            if ($email) {
                $this->assign("email", $email);
                $anv = explode("-", $_SESSION["NASCIMENTO"]);

                $d = $anv[2];
                $m = $anv[1];
                $a = $anv[0];
            }

            $dia = "<select name='dia' class='form-control'>";
            $dia .= "<optgroup label='Dia'>";
            for ($i = 1; $i < 32; $i++) {
                (strlen($i) == 1) ? $count = "0{$i}" : $count = $i;
                ($_POST["dia"] == $count || $d == $count) ? $dia .= "<option value='{$count}' selected>{$count}</option>" : $dia .= "<option value='{$count}'>{$count}</option>";
            }
            $dia .= "</optgroup>";
            $dia .= "</select>";

            $mes = "<select name='mes' class='form-control'>";
            $mes .= "<optgroup label='Mês'>";
            for ($i = 1; $i < 13; $i++) {
                (strlen($i) == 1) ? $count = "0{$i}" : $count = $i;
                ($_POST["mes"] == $count || $m == $count) ? $mes .= "<option value='{$count}' selected>{$count}</option>" : $mes .= "<option value='{$count}'>{$count}</option>";
            }
            $mes .= "</optgroup>";
            $mes .= "</select>";


            $ano = "<select name='ano' class='form-control'>";
            $ano .= "<optgroup label='Ano'>";

            $y = (int) date("Y");
            $y = ($y - 14);
            $ref = 1899;
            while ($y != $ref) {
                ($_POST["ano"] == $y || $a == $y) ? $ano .= "<option value='{$y}' selected>{$y}</option>" : $ano .= "<option value='{$y}'>{$y}</option>";
                $y--;
            }
            $ano .= "</optgroup>";
            $ano .= "</select>";
            $aniversario = $dia . "&nbsp;" . $mes . "&nbsp;" . $ano;


            if ($_POST) {

                if (sizeof($_POST)) {
                    foreach ($_POST as $name => $value) {
                        $this->assign("{$name}", "{$value}");
                    }
                }

                $this->assign("cpf", $this->formataCpf($_SESSION["CPF"]));

                $codcadastro = $this->getPrimarykey();
                $nome = AntiXSS::setEncoding($this->xss_clean($this->trata_nome($_POST["nome"])), "UTF-8");
                $email = AntiXSS::setEncoding($this->xss_clean(strtolower($_POST["email"])), "UTF-8");
                $nascimento = AntiXSS::setEncoding($this->xss_clean($_POST["ano"] . "-" . $_POST["mes"] . "-" . $_POST["dia"]), "UTF-8");
                $sexo = AntiXSS::setEncoding($this->xss_clean($_POST["sexo"]), "UTF-8");
                $ddd = AntiXSS::setEncoding($this->xss_clean($_POST["ddd"]), "UTF-8");
                $tel = AntiXSS::setEncoding($this->xss_clean($_POST["tel"]), "UTF-8");
                $ramal = AntiXSS::setEncoding($this->xss_clean($_POST["ramal"]), "UTF-8");
                $passwd = AntiXSS::setEncoding($this->xss_clean($_POST["passwd"]), "UTF-8");
                $passwd2 = AntiXSS::setEncoding($this->xss_clean($_POST["passwd2"]), "UTF-8");
                $lembrete = AntiXSS::setEncoding($this->xss_clean($_POST["lembrete"]), "UTF-8");
                $updatePassword = AntiXSS::setEncoding($this->xss_clean($_POST["updatePassword"]), "UTF-8");

                if ($updatePassword == "on") {
                    $this->assign("updatePassword", "on");
                }

                if (!preg_match('/^[a-zA-ZÁ-Üá-ü]{1,}([ ]{1}[a-zA-ZÁ-Üá-ü]{1,})+$/', $nome)) {
                    $erro = "Confira o nome digitado!";
                } elseif (!preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $email)) {
                    $erro = "E-mail inválido!";
                } elseif ($ddd == "") {
                    $erro = "Campo DDD requerido!";
                } elseif ($sexo == "") {
                    $erro = "Sexo requerido!";
                } elseif ($nascimento == "") {
                    $erro = "Data de nacimento requerido!";
                } elseif ($tel == "") {
                    $erro = "Campo Telefone requerido!";
                } elseif ($passwd == "" && $updatePassword == "on") {
                    $erro = "Campo Senha requerido!";
                } elseif ($passwd2 == "" && $updatePassword == "on") {
                    $erro = "Campo Repetir senha requerido!";
                } elseif ($passwd2 != $passwd && $updatePassword == "on") {
                    $erro = "Senhas digitadas são diferentes!";
                } elseif ($lembrete == "" && $updatePassword == "on") {
                    $erro = "Campo Lembrete de senha requerido!";
                }

                if ($erro == "") {
                    $model = new Cadastro_Model();
//                    if ($model->existe_cadastro($email)) {
//                        $erro = "Este e-mail já está cadastrado!";
//                    } else {
                    $passwd = $this->senhaMd5($passwd);

                    $dados["CODCADASTRO"] = $codcadastro;
                    $dados["SEXO"] = $sexo;
                    $dados["NASCIMENTO"] = $nascimento;
                    $dados["NOME"] = $nome;
                    $dados["EMAIL"] = $email;
                    $dados["DDD"] = $ddd;
                    $dados["TELEFONE"] = $tel;
                    $dados["RAMAL"] = $ramal;
                    if ($updatePassword == "on") {
                        $dados["PASSWORD"] = $passwd;
                        $dados["LEMBRETE"] = $lembrete;
                    }
                    $dados["STATUS"] = 1;

                    if (!$model->update_cadastro($dados, $email)) {
                        $erro = "Problemas ao tentar atualizar a sua conta, tente novamente!";
                    } else {

                        // /////////////////////////////
                        // JOAO: DESNECESSARIO ENVIAR EMAIL
                        // /////////////////////////////
//                        $quebra_linha = "\n";
//                        $emailsender = "maria@mariadebarro.com.br";
//                        $nomeremetente = "Maria de Barro";
//                        $emaildesitnatario = "maria@mariadebarro.com.br";
//                        $comcopia = $email;
//                        $assunto_texto = "Conta atualizada com sucesso!";
//                        $assunto = "=?UTF-8?B?" . base64_encode($assunto_texto) . "?=";
//
//                        $_SERVER["EMAIL_LEMBRETE"] = $lembrete;
//                        
//                        $this->view_email("emails/atualizacao_conta");
//                        $mensagemHTML = $_SERVER['EMAIL_HTML'];
//
//                        $headers = "MIME-Version: 1.1{$quebra_linha}";
//                        $headers .= "Content-type: text/html; charset=UTF-8{$quebra_linha}";
//                        $headers .= "From: \"{$nomeremetente}\"<{$emailsender}>{$quebra_linha}";
//                        $headers .= "Return-Path: {$emailsender}{$quebra_linha}";
//                        $headers .= "Cc: {$comcopia}{$quebra_linha}";
//                        $headers .= "Reply-To: {$emaildesitnatario}{$quebra_linha}";
//                        $headers .= "X-Mailer: PHP/" . phpversion();
//                        mail($emaildesitnatario, $assunto, $mensagemHTML, $headers, ALIAS_EMAIL . $emailsender);

                        foreach ($dados as $n => $v) {
                            $_SESSION[$n] = $v;
                        }
                        $this->assign("success", 1);
                    }
                    //}
                }
            } else {
                $this->assign("nome", $_SESSION["NOME"]);
                $this->assign("sexo", $_SESSION["SEXO"]);
                $this->assign("cpf", $this->formataCpf($_SESSION["CPF"]));
                $this->assign("ddd", $_SESSION["DDD"]);
                $this->assign("tel", $_SESSION["TELEFONE"]);
                $this->assign("ramal", $_SESSION["RAMAL"]);
                $this->assign("lembrete", $_SESSION["LEMBRETE"]);
            }


            $this->assign("aniversario", $aniversario);
            $this->assign("codcadastro", $_SESSION['CODCADASTRO']);
            $this->assign("erro", $erro);
            $this->assign("url_checkout", $url_checkout);
            $this->assign("cep_remetente", CEP_REMETENTE);
            $this->assign("title", "Meus dados | " .  TITLE );
            $this->assign("page", "meus-dados");
            $this->view_tpl("minha_conta");
        }
    }

    public function wishlist() {

        $model = new Produtos_Model();

        $this->assign("language", LANGUAGE);
        $this->assign("dados", $_SESSION);

        $url_checkout = "CLIENT_HIDDEN=" . CLIENT_HIDDEN . "&CODPRODUTO=";

        $this->assign("url_checkout", $url_checkout);
        $this->assign("cep_remetente", CEP_REMETENTE);
        $this->assign("title", "Minha lista de desejos | " . TITLE);
        $this->assign("page", "wishlist");
        $this->assign("embalar_presente", $model->embalar_presente(CLIENT_HIDDEN));

        $this->view_tpl("wishlist");
    }

    public function meus_pedidos() {
        if ($this->permitir_acesso_comprador()) {

            $model = new Pedido_Model();

            if ($_POST["actionType"] == "search") {

                $this->assign("pedidos", $model->get_lista_pedidos_search($_POST["search"], $_SESSION["CODCADASTRO"]));
            } else {

                $this->assign("pedidos", $model->get_lista_pedidos($_SESSION["CODCADASTRO"]));
            }

            $this->assign("compras_all", $model->get_compras_all());
            $this->assign("language", LANGUAGE);
            $this->assign("page", "meus-pedidos");
            $this->assign("dados", $_SESSION);
            $this->assign("title", "Minha Lista de Pedidos | " . TITLE);
            $this->view_tpl("meus_pedidos");
        }
    }

    public function view() {
        if ($this->permitir_acesso_comprador()) {

            $model = new Pedido_Model();

            $arr = $this->array_url();
            $codpedido = strtoupper($arr[1]);


            $this->assign("compras", $model->get_compras($codpedido));
            $cadastro = $model->get_cadastro_for_pedido($codpedido);
            $this->assign("cadastro", $cadastro);

            foreach ($cadastro as $obj) {
                $cad = $obj;
            }

            $pedido = $model->get_pedido($codpedido, $cad->CODCADASTRO);

            $pedido->IMP = (int) $this->limpaValorReal($pedido->TOTAL_GERAL) - (int) $this->limpaValorReal($pedido->TAXA_ENTREGA);
            $pedido->IMP = $this->formataReais($pedido->IMP);

            $this->assign("pedido", $pedido);
            $this->assign("endereco_entrega", $model->get_endereco_entrega($codpedido));
            $this->assign("anotacoes", $model->get_anotacao_pedido($codpedido));

            $this->assign("language", LANGUAGE);
            $this->assign("page", "meus-pedidos");
            $this->assign("dados", $_SESSION);
            $this->assign("title", "Visualizar Meu Pedido | " . TITLE);
            $this->view_tpl("meus_pedidos_view");
        }
    }

    public function paypal_confirmado() {
        if ($this->permitir_acesso_comprador()) {
            $this->assign("language", LANGUAGE);
            $saudacao = str_replace(",", "", $this->saudacao());
            $this->assign("saudacao", $saudacao);
            foreach ($_SESSION as $nome => $valor) {
                $this->assign($nome, $valor);
            }

            $arr = $this->array_url();
            $codpedido = strtoupper($arr[1]);
            $status = 1;

            $model = new Pedido_Model();
            $model->update_status_pedido($codpedido, $status);

            $this->view_tpl("paypal_confirmado");
        }
    }

    public function paypal_cancelamento() {
        if ($this->permitir_acesso_comprador()) {
            $this->assign("language", LANGUAGE);

            ( $_SESSION["SEXO"] == "M") ? $saudacao = "Prezado" : $saudacao = "Prezada";
            $this->assign("saudacao", $saudacao);

            foreach ($_SESSION as $nome => $valor) {
                $this->assign($nome, $valor);
            }

            $arr = $this->array_url();
            $codpedido = strtoupper($arr[1]);
            $status = 0;

            $model = new Pedido_Model();
            $model->update_status_pedido($codpedido, $status);

            $this->view_tpl("paypal_cancelamento");
        }
    }

    public function paypal_notificacao() {
        if ($this->permitir_acesso_comprador()) {
            $this->assign("language", LANGUAGE);

            ( $_SESSION["SEXO"] == "M") ? $saudacao = "Prezado" : $saudacao = "Prezada";
            $this->assign("saudacao", $saudacao);

            foreach ($_SESSION as $nome => $valor) {
                $this->assign($nome, $valor);
            }

            $arr = $this->array_url();
            $codpedido = strtoupper($arr[1]);
            $status = 0;

            $model = new Pedido_Model();
            $model->update_status_pedido($codpedido, $status);

            $this->view_tpl("paypal_notificacao");
        }
    }

    public function esqueceu_senha() {

        $erro = "";
        $sucesso = "FALSE";

        $this->assign("language", LANGUAGE);

        if ($_POST) {
            $email = $_POST["email"];
            $model = new Cadastro_Model();

            if ($email == "") {
                $erro = "E-mail requerido!";
            } elseif ($model->existe_email($email)) {
                $dados = $model->get_email($email);
                
                foreach ($dados as $key => $value) {
                    $_SERVER[$key] = $value;
                }
                
                $sucesso = "TRUE";

                $quebra_linha = "\n";
                $emailsender = "maria@mariadebarro.com.br";
                $nomeremetente = "Maria de Barro";
                $emaildesitnatario = "maria@mariadebarro.com.br";
                $comcopia = $email;
                $assunto_texto = "Recuperação de Senha!";
                $assunto = "=?UTF-8?B?" . base64_encode($assunto_texto) . "?=";

                $link = "https://" . SITE;
                
                $_SERVER['EMAIL_LINK'] = "https://" . SITE;
                $_SERVER['EMAIL_LINK_2'] = "https://" . SITE . LANGUAGE . "/conta/trocar-senha/codigo/" . strtolower($dados->CODCADASTRO);

                $mensagemHTML = $this->view_email('emails/recuperar_senha');

                $headers = "MIME-Version: 1.1{$quebra_linha}";
                $headers .= "Content-type: text/html; charset=UTF-8{$quebra_linha}";
                $headers .= "From: \"{$nomeremetente}\"<{$emailsender}>{$quebra_linha}";
                $headers .= "Return-Path: {$emailsender}{$quebra_linha}";
                $headers .= "Cc: {$comcopia}{$quebra_linha}";
                $headers .= "Reply-To: {$emaildesitnatario}{$quebra_linha}";
                $headers .= "X-Mailer: PHP/" . phpversion();

                mail($emaildesitnatario, $assunto, $mensagemHTML, $headers, "-f" . $emailsender);


                $erro = "Uma mensagem foi enviada para seu e-mail!";
            } else {
                $erro = "E-mail não cadastrado!";
            }
        }

        $this->assign("title", "Recuperar senha | " . TITLE);
        $this->assign("id", $id);
        $this->assign("erro", $erro);
        $this->assign("sucesso", $sucesso);
        $this->view_tpl("esqueceu_senha");
    }

    public function trocar_senha() {

        $arr = $this->array_url();

        $codcadastro = strtoupper($arr[1]);
        $model = new Cadastro_Model();

        $this->assign("language", LANGUAGE);

        $senha = AntiXSS::setEncoding($this->xss_clean($_POST["senha"]), "UTF-8");
        $repetir_senha = AntiXSS::setEncoding($this->xss_clean($_POST["repetir_senha"]), "UTF-8");
        $novo_lembrete = AntiXSS::setEncoding($this->xss_clean($_POST["novo_lembrete"]), "UTF-8");

        $erro = "";

        if ($_POST) {

            if ($senha == "") {
                $erro = "* Senha requerida!";
            } elseif ($repetir_senha == "") {
                $erro = "* Repetir senha requerida!";
            } elseif ($novo_lembrete == "") {
                $erro = "* Lembrar senha requerido!";
            } elseif ($senha != $repetir_senha) {
                $erro = "* Senhas diferentes!";
            }

            if ($erro == "") {

                $erro = "* Sua senha foi atualizada com sucesso!";
                $this->assign("sucesso", "TRUE");
                $this->assign("title", "Trocar senha | " . TITLE);
                $this->assign("erro", $erro);
                $this->assign("codcadastro", strtolower($codcadastro));

                if ($model->update_senha(strtoupper($codcadastro), $this->senhaMd5($senha), $novo_lembrete)) {

                    $cadastro = $model->get_cadastro_with_codcadastro($codcadastro);

                    // /////////////////////////////
                    // JOAO: DESNECESSARIO ENVIAR EMAIL
                    // /////////////////////////////
//                    $quebra_linha = "\n";
//                    $emailsender = "maria@mariadebarro.com.br";
//                    $nomeremetente = "Maria de Barro";
//                    $emaildesitnatario = "maria@mariadebarro.com.br";
//                    $comcopia = $cadastro->EMAIL;
//                    $assunto_texto = "Conta atualizada com sucesso!";
//                    $assunto = "=?UTF-8?B?" . base64_encode($assunto_texto) . "?=";
//
//                    $link = "https://" . SITE;
//
//                    $mensagemHTML = "<pre><div style='font-size: 14px;'>
//                        <h3>Solicitação de atualização de conta!</h3>
//                        <div>{$this->saudacao()} <strong>{$cadastro->NOME}</strong><div><br/>
//                        <div>Recentemente seu dados foram atualizados em nosso site.<div><br/>
//                        <div>Obrigado por utilizar nossos serviços.<div><br/>
//                        <div>O seu ID de acesso é: <strong>{$cadastro->EMAIL}</strong><div><br/>
//                        <div>O seu lembrete de senha é a seguinte frase: <strong>{$cadastro->LEMBRETE}</strong><div><br/>
//                        <div><a href='{$link}'><img src='{$link}" . LOGO . "' alt='" . TITLE_LOJA . "' title='" . TITLE_LOJA . "' border='0'/></a></div><br/>
//                        <div><strong>* Não responder a este e-mail</strong></div><br/>
//                        </div></pre>";
//
//                    $headers = "MIME-Version: 1.1{$quebra_linha}";
//                    $headers .= "Content-type: text/html; charset=UTF-8{$quebra_linha}";
//                    $headers .= "From: \"{$nomeremetente}\"<{$emailsender}>{$quebra_linha}";
//                    $headers .= "Return-Path: {$emailsender}{$quebra_linha}";
//                    $headers .= "Cc: {$comcopia}{$quebra_linha}";
//                    $headers .= "Reply-To: {$emaildesitnatario}{$quebra_linha}";
//                    $headers .= "X-Mailer: PHP/" . phpversion();
//                    mail($emaildesitnatario, $assunto, $mensagemHTML, $headers, "-f" . $emailsender);

                    foreach ($cadastro as $nome => $value) {
                        $_SESSION[$nome] = $value;
                    }

                    if ($this->permitir_acesso_comprador()) {
                        $this->assign("controle", TRUE);
                        $this->assign("nome", $_SESSION["NOME"]);
                        $this->assign("email", $_SESSION["EMAIL"]);
                        $this->assign("saudacao", $this->saudacao());
                    }

                    echo "<script>window.location='" . MEU_SITE . "'</script>";
                    exit();
                }
            } else {
                $this->assign("sucesso", "FALSE");
                $this->assign("title", "Trocar senha | " . TITLE);
                $this->assign("erro", $erro);
                $this->assign("codcadastro", strtolower($codcadastro));
            }
        } else {

            $this->assign("title", "Trocar senha | " . TITLE);
            $this->assign("erro", $erro);
            $this->assign("codcadastro", strtolower($codcadastro));
        }


        $this->view_tpl("trocar_senha");
    }

    public function lista() {
        if ($this->permitir_acesso($_SESSION["EMAIL"], $_SESSION["SENHA"], "ADMINISTRADOR")) {

            $model = new Conta_Model();


            if ($_POST["search"] != "") {
                $search = $_POST["search"];
                $contas = $model->get_clientes(null, $search);
                $this->assign("search", $search);
            } else {
                $contas = $model->get_clientes();
            }

            $this->assign("contas", $contas);
            $this->assign("language", LANGUAGE);
            $this->assign("page", "conta-lista");
            $this->assign("dados", $_SESSION);
            $this->assign("title", "Lista de Clientes | " . TITLE );
            $this->view_tpl("admin/contas_lista");
        }
    }

    public function aniversariantes() {
        if ($this->permitir_acesso($_SESSION["EMAIL"], $_SESSION["SENHA"], "ADMINISTRADOR")) {

            $model = new Conta_Model();


            if ($_POST["search"] != "") {
                $search = $_POST["search"];
                $contas = $model->get_aniversariantes(null, $search);
                $this->assign("search", $search);
            } else {
                $contas = $model->get_aniversariantes();
            }
            
            $this->assign("contas", $contas);
            $this->assign("language", LANGUAGE);
            $this->assign("page", "aniversariantes-lista");
            $this->assign("dados", $_SESSION);
            $this->assign("title", "Lista de Clientes | " . TITLE);
            $this->view_tpl("admin/contas_aniversariantes_lista");
        }
    }

    public function email_aniversariantes() {
        if ($this->permitir_acesso($_SESSION["EMAIL"], $_SESSION["SENHA"], "ADMINISTRADOR")) {

            $model = new Conta_Model();


            $contas = $model->get_aniversariantes();

            if ($contas) {
                $i=0;
                foreach ($contas as $conta) {

                    $conta->CODCADASTRO; #string(32) "1fde338e0bd1199ade238445b47be4ce" 
                    $conta->DTA; #string(18) "01/12/2014 - 14h57" 
                    $conta->NOME; #string(26) "RogÃ©rio de Almeida Pontes" 
                    $conta->EMAIL; #string(24) "rogerio@designlab.com.br"
                    $conta->NASCIMENTO; #string(10) "04/12/1977" 
                    $conta->SEXO; #string(1) "M" 
                    $conta->DDD; #string(2) "61" 
                    $conta->TELEFONE; #string(8) "39678750" 
                    $conta->RAMAL; #string(0) "" 
                    $conta->CPF; #string(14) "829.297.501-21" 
                    $conta->PASSWORD; #string(32) "202CB962AC59075B964B07152D234B70" 
                    $conta->LEMBRETE; #string(25) "apenas teste um dois tres" 
                    $conta->WAS_EXPORTED; #string(3) "nao" 
                    $conta->STATUS; #string(1) "1" 

                    $piece = explode("/", $conta->NASCIMENTO);
                    switch ($piece[1]) {
                        case '01': $piece[1] = "Janeiro";
                            break;
                        case '02': $piece[1] = "Fevereiro";
                            break;
                        case '03': $piece[1] = "Março";
                            break;
                        case '04': $piece[1] = "Abril";
                            break;
                        case '05': $piece[1] = "Maio";
                            break;
                        case '06': $piece[1] = "Junho";
                            break;
                        case '07': $piece[1] = "Julho";
                            break;
                        case '08': $piece[1] = "Agosto";
                            break;
                        case '09': $piece[1] = "Setembro";
                            break;
                        case '10': $piece[1] = "Outubro";
                            break;
                        case '11': $piece[1] = "Novembro";
                            break;
                        case '12': $piece[1] = "Dezembro";
                            break;
                    }
                   

                    $bonus_array["CODBONUS"] = strtoupper(md5($this->getPrimarykey().$i));
                    $bonus_array["CODCADASTRO"] = strtoupper($conta->CODCADASTRO);
                    $bonus_array["CODIGO"] = substr($bonus_array["CODBONUS"], 0, 6);
                    $bonus_array["TIPO"] = 'aniversario';
                    $bonus_array["VALOR"] = '10';

                    $quebra_linha = "\n";
                    $emailsender = "maria@mariadebarro.com.br";
                    $nomeremetente = "Maria de Barro";
                    $emaildesitnatario = $conta->EMAIL;
                    $assunto_texto = "Feliz aniversário {$conta->NOME}";
                    $assunto = "=?UTF-8?B?" . base64_encode($assunto_texto) . "?=";
                    
                    $vars["dia"] = $piece[0];
                    $vars["mes"] = $piece[1];
                    $vars["ano"] = date("Y");
                    $vars["nome"] = $conta->NOME;
                    $vars["codigo"] = $bonus_array['CODIGO'];
                    
                    
                    if( $model->existe_bonus_aniversario($conta->CODCADASTRO, $vars["ano"]) ){
                        $bonus = $model->get_bonus_aniversario($conta->CODCADASTRO, $vars["ano"]);
                        $vars["codigo"] = $bonus->CODIGO;
                    } else {
                        $model->insert_bonus($bonus_array);
                    }
                    
                    $mensagemHTML = $this->view_email_print("emails/aniversario_cupom", $vars);

                    $headers = "MIME-Version: 1.1{$quebra_linha}";
                    $headers .= "Content-type: text/html; charset=UTF-8{$quebra_linha}";
                    $headers .= "From: \"{$nomeremetente}\"<{$emailsender}>{$quebra_linha}";
                    $headers .= "Return-Path: {$emailsender}{$quebra_linha}";
                    $headers .= "Cc: {$comcopia}{$quebra_linha}";
                    $headers .= "Reply-To: {$emaildesitnatario}{$quebra_linha}";
                    $headers .= "X-Mailer: PHP/" . phpversion();

                    mail($emaildesitnatario, $assunto, $mensagemHTML, $headers, "-f" . $emailsender);
                    $i++;
                }
                echo "<script>window.location='" . MEU_SITE . "conta/aniversariantes'</script>";
                exit();
            } else {
                echo "<script>alert('Nenhum e-mail foi enviado!')</script>";
                echo "<script>window.location='" . MEU_SITE . "conta/aniversariantes'</script>";
                exit();
            }

            $this->assign("contas", $contas);
            $this->assign("language", LANGUAGE);
            $this->assign("page", "aniversariantes-lista");
            $this->assign("dados", $_SESSION);
            $this->assign("title", "Lista de Clientes | " . TITLE);
            $this->view_tpl("admin/contas_aniversariantes_lista");
        }
    }

    public function status() {
        if ($this->permitir_acesso($_SESSION["EMAIL"], $_SESSION["SENHA"], "ADMINISTRADOR")) {

            $arr = $this->array_url();
            $key = strtoupper($arr[1]);
            $stt = $arr[0];

            $model = new Conta_Model();
            $model->update_status($key, $stt);

            echo "<script>window.location='" . MEU_SITE . "conta/lista'</script>";
            exit();
        }
    }

    public function editar() {
        if ($this->permitir_acesso($_SESSION["EMAIL"], $_SESSION["SENHA"], "ADMINISTRADOR")) {

            $model = new Produtos_Model();
            $model2 = new Conta_Model();


            $arr = $this->array_url();
            $key = strtoupper($arr[0]);

            $contas = $model2->get_clientes($key);
            if ($contas) {
                foreach ($contas as $obj) {
                    $conta = $obj;
                }
            }


            $this->assign("language", LANGUAGE);
            $this->assign("dados", $_SESSION);

            $url_checkout = "CLIENT_HIDDEN=" . CLIENT_HIDDEN . "&CODPRODUTO=";


            $email = $conta->EMAIL;

            $this->assign("email", $email);
            $anv = explode("/", $conta->NASCIMENTO);

            $d = $anv[0];
            $m = $anv[1];
            $a = $anv[2];

            $dia = "<select name='dia' class='form-control'>";
            $dia .= "<optgroup label='Dia'>";
            for ($i = 1; $i < 32; $i++) {
                (strlen($i) == 1) ? $count = "0{$i}" : $count = $i;
                ($_POST["dia"] == $count || $d == $count) ? $dia .= "<option value='{$count}' selected>{$count}</option>" : $dia .= "<option value='{$count}'>{$count}</option>";
            }

            $dia .= "</optgroup>";
            $dia .= "</select>";

            $mes = "<select name='mes' class='form-control'>";
            $mes .= "<optgroup label='Mês'>";
            for ($i = 1; $i < 13; $i++) {
                (strlen($i) == 1) ? $count = "0{$i}" : $count = $i;
                ($_POST["mes"] == $count || $m == $count) ? $mes .= "<option value='{$count}' selected>{$count}</option>" : $mes .= "<option value='{$count}'>{$count}</option>";
            }
            $mes .= "</optgroup>";
            $mes .= "</select>";


            $ano = "<select name='ano' class='form-control'>";
            $ano .= "<optgroup label='Ano'>";

            $y = (int) date("Y");
            $y = ($y - 14);
            $ref = 1899;
            while ($y != $ref) {
                ($_POST["ano"] == $y || $a == $y) ? $ano .= "<option value='{$y}' selected>{$y}</option>" : $ano .= "<option value='{$y}'>{$y}</option>";
                $y--;
            }
            $ano .= "</optgroup>";
            $ano .= "</select>";
            $aniversario = $dia . "&nbsp;" . $mes . "&nbsp;" . $ano;


            if ($_POST) {

                if (sizeof($_POST)) {
                    foreach ($_POST as $name => $value) {
                        $this->assign("{$name}", "{$value}");
                    }
                }

                $this->assign("cpf", $this->formataCpf($_SESSION["CPF"]));

                $codcadastro = $key;
                $nome = AntiXSS::setEncoding($this->xss_clean($this->trata_nome($_POST["nome"])), "UTF-8");
                $email = AntiXSS::setEncoding($this->xss_clean(strtolower($_POST["email"])), "UTF-8");
                $nascimento = AntiXSS::setEncoding($this->xss_clean($_POST["ano"] . "-" . $_POST["mes"] . "-" . $_POST["dia"]), "UTF-8");
                $sexo = AntiXSS::setEncoding($this->xss_clean($_POST["sexo"]), "UTF-8");
                $ddd = AntiXSS::setEncoding($this->xss_clean($_POST["ddd"]), "UTF-8");
                $tel = AntiXSS::setEncoding($this->xss_clean($_POST["tel"]), "UTF-8");
                $ramal = AntiXSS::setEncoding($this->xss_clean($_POST["ramal"]), "UTF-8");
                $passwd = AntiXSS::setEncoding($this->xss_clean($_POST["passwd"]), "UTF-8");
                $passwd2 = AntiXSS::setEncoding($this->xss_clean($_POST["passwd2"]), "UTF-8");
                $lembrete = AntiXSS::setEncoding($this->xss_clean($_POST["lembrete"]), "UTF-8");
                $updatePassword = AntiXSS::setEncoding($this->xss_clean($_POST["updatePassword"]), "UTF-8");

                if ($updatePassword == "on") {
                    $this->assign("updatePassword", "on");
                }

                if (!preg_match('/^[a-zA-ZÁ-Üá-ü]{1,}([ ]{1}[a-zA-ZÁ-Üá-ü]{1,})+$/', $nome)) {
                    $erro = "Confira o nome digitado!";
                } elseif (!preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $email)) {
                    $erro = "E-mail inválido!";
                } elseif ($ddd == "") {
                    $erro = "Campo DDD requerido!";
                } elseif ($sexo == "") {
                    $erro = "Sexo requerido!";
                } elseif ($nascimento == "") {
                    $erro = "Data de nacimento requerido!";
                } elseif ($tel == "") {
                    $erro = "Campo Telefone requerido!";
                } elseif ($passwd == "" && $updatePassword == "on") {
                    $erro = "Campo Senha requerido!";
                } elseif ($passwd2 == "" && $updatePassword == "on") {
                    $erro = "Campo Repetir senha requerido!";
                } elseif ($passwd2 != $passwd && $updatePassword == "on") {
                    $erro = "Senhas digitadas são diferentes!";
                } elseif ($lembrete == "" && $updatePassword == "on") {
                    $erro = "Campo Lembrete de senha requerido!";
                }

                if ($erro == "") {
                    $model = new Cadastro_Model();

                    $passwd = $this->senhaMd5($passwd);

                    $dados["CODCADASTRO"] = $codcadastro;
                    $dados["SEXO"] = $sexo;
                    $dados["NASCIMENTO"] = $nascimento;
                    $dados["NOME"] = $nome;
                    $dados["CPF"] = $this->limpaCpf($_POST["cpf"]);
                    $dados["EMAIL"] = $email;
                    $dados["DDD"] = $ddd;
                    $dados["TELEFONE"] = $tel;
                    $dados["RAMAL"] = $ramal;
                    if ($updatePassword == "on") {
                        $dados["PASSWORD"] = $passwd;
                        $dados["LEMBRETE"] = $lembrete;
                    }
                    $dados["STATUS"] = 1;

                    if (!$model->update_cadastro($dados, $email)) {
                        $erro = "Problemas ao tentar atualizar a sua conta, tente novamente!";
                    } else {

                        echo "<script>window.location='" . MEU_SITE . "conta/lista'</script>";
                        exit();
                    }
                }
            } else {
                $this->assign("nome", $conta->NOME);
                $this->assign("sexo", $conta->SEXO);
                $this->assign("cpf", $conta->CPF);
                $this->assign("ddd", $conta->DDD);
                $this->assign("tel", $conta->TELEFONE);
                $this->assign("ramal", $conta->RAMAL);
                $this->assign("lembrete", $conta->LEMBRETE);
            }

            $this->assign("aniversario", $aniversario);
            $this->assign("codcadastro", $_SESSION['CODCADASTRO']);
            $this->assign("erro", $erro);
            $this->assign("url_checkout", $url_checkout);
            $this->assign("cep_remetente", CEP_REMETENTE);
            $this->assign("title", "Meus dados | " . TITLE);
            $this->assign("page", "meus-dados");
            $this->view_tpl("admin/contas_editar");
        }
    }

    function pdf_aniversariantes() {

        $model = new Conta_Model();

        if ($this->permitir_acesso($_SESSION["EMAIL"], $_SESSION["SENHA"], "ADMINISTRADOR")) {

//            $vars["page_reference"] = "empresas-entidades";
//            $vars["page_internal"] = "estagiarios-empresas-entidades";
//            $vars["page_search"] = true;
//            $vars["pagina"] = "Lista de Estagiarios Empresa/Entidade!";
//
//            if ($_POST["search"] != "") {
//                $search = $_POST["search"];
//                $vars["search"] = $_POST["search"];
//            } else {
//                $search = null;
//            }
//
//            if ($_SESSION["PAPEL"] == "MASTER") {
//                $cadastro = $model->get_lista_cadastro_entidade_estagiarios(null, null, $search);
//                $vars["lista_estagiarios"] = $cadastro;
//            } else if ($_SESSION["PAPEL"] == "EMPRESA_ENTIDADE") {
//                $cadastro = $model->get_lista_cadastro_entidade_estagiarios($_SESSION["CODCADASTRO"], null, $search);
//                $vars["lista_estagiarios"] = $cadastro;
//            } else if ($_SESSION["PAPEL"] == "GESTOR") {
//                #$_SESSION["CODEMPRESA_CONFIG"]
//                $cadastro = $model->get_lista_cadastro_entidade_estagiarios($_SESSION["CODCADASTRO"], null, $search);
//                $vars["lista_estagiarios"] = $cadastro;
//            } else if ($_SESSION["PAPEL"] == "ESTAGIARIO") {
//                #$_SESSION["CODEMPRESA_CONFIG"]
//                $cadastro = $model->get_lista_cadastro_entidade_estagiarios($_SESSION["CODCADASTRO"], null, $search);
//                $vars["lista_estagiarios"] = $cadastro;
//            }
//
//            if ($_SESSION["PAPEL"] == "GESTOR") {
//                $vars["info_empresa"] = $model->get_cadastro($_SESSION["CODEMPRESA_CONFIG"]);
//            } else {
//                $vars["info_empresa"] = false;
//            }

            $vars["maria_de_barro"] = "MARIA DE BARRO ACESSÓRIO FEMININOS LTDA.";

            $html = $this->view_pdf("pdf/pdf_relacao_aniversariantes", $vars);

            $mpdf = new mPDF();
            $mpdf->WriteHTML($html);
            $mpdf->Output();

            exit();
        }
    }

}
