<?php

Class Atendimento extends Controller {

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

    public function index_action() {
       
       if (((int)date("H") >= 9 && (int)date("i") >= 0 ) 
       && ((int)date("H") <= 17 && (int)date("i") <= 59 )
       && ( (int)date("N") != 6 && (int)date("N") != 7 )){
            $model = new Atendimento_Model();
            if( $model->existe_atendimento() ){
                $this->view_tpl("atendimento/pagina_inicial");
             } else {
                $this->view_tpl("atendimento/nenhum_atendente");
             }
       } else {
           $this->view_tpl("atendimento/horario_funcionamento");
       }
        
    }
    
    public function meu_status() {
        if ($this->permitir_acesso($_SESSION["EMAIL"], $_SESSION["SENHA"], "ATENDENTE")) {

            $model = new Admin_Model();
            
            $atendentes = $model->get_atendentes();
            if(!$atendentes){
                $this->assign("ERRO_NAO_EXITE_ATENDENTE", "ERRO_NAO_EXITE_ATENDENTE");
            }
            $this->assign("atendentes", $atendentes);
            
            $this->assign("language", LANGUAGE);
            $this->assign("page", "meu_status");
            $this->assign("dados", $_SESSION);
            $this->assign("title", TITLE . "Meu status");
            $this->view_tpl("admin/meu_status");
        }
    }
    
    public function on_line() {
        if ($this->permitir_acesso($_SESSION["EMAIL"], $_SESSION["SENHA"], "ATENDENTE")) {

            $arr = $this->array_url();
            $email = $arr[1];
            $stt = $arr[0];

            $model = new Admin_Model();
            $model->update_status_online($email, $stt);

            echo "<script>window.location='" . MEU_SITE . "atendimento/meu-status'</script>";
            exit();
        }        
    }

    public function valida_dados() {
        
        if($_POST){
            
            $nome = $_POST["nome"];
            $email = $_POST["email"];
            $enviar_email = ($_POST["enviar_email"] == "on") ? 1 : 0;
            $erro = "";
            
            $this->assign("nome", $this->trata_nome($nome));
            $this->assign("email", $email);
            $this->assign("enviar_email", $enviar_email);
            
            if($nome == "" && $email == ""){
                $erro = "Preencha todos os campos!";
            } else if (!preg_match('/^[a-zA-ZÁ-Üá-ü]{1,}([ ]{1}[a-zA-ZÁ-Üá-ü]{1,})+$/', $nome)) {
                $erro = "Nome e sobrenome requerido!";
            } else if (!preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $email)) {
                $erro = "E-mail inválido!";
            } 
            
            if( $erro == ""){
                
                $dados["CODATENDIMENTO"] = $this->getPrimarykey();
                $dados["ENVIAR_EMAIL"] = $enviar_email;
                $dados["NOME"] = trim($this->trata_nome($nome));
                $dados["EMAIL"] = trim($email);
                $dados["STATUS"] = 1;
                
                $model = new Atendimento_Model();
                if($model->insert_atendimento($dados)){
                            
                    $chat["CODCHAT"] = $this->getPrimarykey();
                    $chat["CODATENDIMENTO"] = $dados["CODATENDIMENTO"];
                    $chat["MENSAGEM"] = "{$this->saudacao()} <strong>{$nome}</strong>, o chat ainda não iniciou, breve um de nossos atendentes falará com você!";
                    $chat["ENVIADO_POR"] = "sistema";
                    $chat["VIEW_POR"] = "ninguem";
                    
                    $model->insert_chat($chat);
                    
                    $this->assign("codatendimento", $dados["CODATENDIMENTO"]);
                    $this->assign("enviado_por", $chat["ENVIADO_POR"]);
                    $this->assign("mensagem", $chat["MENSAGEM"]);
                    
                    $this->view_tpl("atendimento/panel");
                    
                } else {
                    $this->assign("erro", "Erro inesperado!");
                    $this->view_tpl("atendimento/pagina_inicial");
                }
                
            } else {
                $this->assign("erro", $erro);
                $this->view_tpl("atendimento/pagina_inicial");
            }            
                
        }
        
    }
    
    public function get_atendente() {
        echo "codatendente: "+$_POST["codatendente"].rand(); 
    }
    
    public function meus_atendimentos() {
        if ($this->permitir_acesso($_SESSION["EMAIL"], $_SESSION["SENHA"], "ATENDENTE")) {

            $model = new Admin_Model();
            
            $this->assign("language", LANGUAGE);
            $this->assign("page", "meus_atendimentos");
            $this->assign("dados", $_SESSION);
            $this->assign("title", TITLE . "Meus atendimentos");
            $this->view_tpl("admin/meus_atendimentos");
        }
    }
    
    public function get_usuarios_fila() {
        if ($this->permitir_acesso($_SESSION["EMAIL"], $_SESSION["SENHA"], "ATENDENTE")) {
            
            $model = new Atendimento_Model();
            $atendimentos_aberto = $model->get_atendimentos_aberto();
            
            $this->assign("atendimentos_aberto", $atendimentos_aberto);
            $this->assign("language", LANGUAGE);
            $this->assign("dados", $_SESSION);
            
            $this->view_tpl("admin/lista_atendimentos");
        }
    }
    
    public function chat() {
        if ($this->permitir_acesso($_SESSION["EMAIL"], $_SESSION["SENHA"], "ATENDENTE")) {
            
            $model = new Atendimento_Model();
           
            $arr = $this->array_url();
            $codatendimento = strtoupper($arr[0]);
            $dados["CODATENDENTE"] = $_SESSION["CODCONTA"];
            
            $model->insert_atendente($dados, $codatendimento);
            
            $enviado_por[0] = "sistema";
            $enviado_por[1] = "guest";
            
            $mensagem = $model->get_chat($codatendimento, $enviado_por); 
            $this->assign("mensagens", $mensagem);
            
            $this->assign("codatendimento", $codatendimento);
            $this->assign("language", LANGUAGE);
            $this->assign("dados", $_SESSION);
            
            $this->view_tpl("admin/form_atendimento");
        }
    }

}
