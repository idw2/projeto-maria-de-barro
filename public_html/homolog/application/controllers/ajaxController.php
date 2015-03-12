<?php

Class Ajax extends Controller {

    public function __construct() {
        $this->get_smarty();
        $this->run();
    }

    public function desconto_10() {

        $bonus_array["CODBONUS"] = $this->getPrimarykey();
        $bonus_array["CODCADASTRO"] = "11111111111111111111111111111111";
        $bonus_array['VALOR'] = "10";
        $bonus_array["CODIGO"] = substr($bonus_array["CODBONUS"], 0, 6);
        $bonus_array["TIPO"] = "desconto";
        $bonus_array["EMAIL"] = addslashes($_POST["email"]);

//        var_dump($bonus_array);        die();

        $model = new Bonus_Model();



        if (!$model->existe_codigo_bonus($bonus_array["EMAIL"])) {

            $model->insert_bonus($bonus_array);
            
            $quebra_linha = "\n";
            $emailsender = "maria@mariadebarro.com.br";
            $nomeremetente = "Maria de Barro";
            $emaildesitnatario = $bonus_array["EMAIL"];
            $assunto_texto = "Você ganhou 10% de desconto para compras em nossa loja!";
            $assunto = "=?UTF-8?B?" . base64_encode($assunto_texto) . "?=";

            $mensagemHTML = $this->view_email_print("emails/bonus_10", $bonus_array);

            $headers = "MIME-Version: 1.1{$quebra_linha}";
            $headers .= "Content-type: text/html; charset=UTF-8{$quebra_linha}";
            $headers .= "From: \"{$nomeremetente}\"<{$emailsender}>{$quebra_linha}";
            $headers .= "Return-Path: {$emailsender}{$quebra_linha}";
            $headers .= "Cc: {$comcopia}{$quebra_linha}";
            $headers .= "Reply-To: {$emaildesitnatario}{$quebra_linha}";
            $headers .= "X-Mailer: PHP/" . phpversion();

            mail($emaildesitnatario, $assunto, $mensagemHTML, $headers, "-f" . $emailsender);
        }
    }

}
