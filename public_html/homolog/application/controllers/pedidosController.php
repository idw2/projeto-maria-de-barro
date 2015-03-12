<?php

Class Pedidos extends Controller {

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

        $arquivo_xls = new Pedido_Model();
        $arquivo_xls_resultado = $arquivo_xls->get_cliente_xls();

        $this->assign("arquivo_xls_resultado", $arquivo_xls_resultado);

        $cts = new Conta_Model();
        $this->assign("existe_aniversariantes", $cts->existe_aniversariantes());

        $eame = new Produtos_Model();
        $this->assign("existe_avise_me", $eame->existe_avise_me());
        $this->assign("num_de_qntdd_produtos", $eame->num_de_qntdd_produtos());
        $this->assign("existe_novos_produtos_cadastrados", $eame->existe_novos_produtos_cadastrados());
    }

    public function index_action() {
        $this->pedidos_lista();
    }

    public function pedidos_lista() {
        if ($this->permitir_acesso($_SESSION["EMAIL"], $_SESSION["SENHA"], "ADMINISTRADOR")) {

            $model = new Pedido_Model();

            if ($_POST["actionType"] == "search") {

                $this->assign("pedidos", $model->get_lista_pedidos_search($_POST["search"]));
            } else {

                $this->assign("pedidos", $model->get_lista_pedidos());
            }

            $this->assign("compras_all", $model->get_compras_all());
            $this->assign("language", LANGUAGE);
            $this->assign("page", "pedidos_lista");
            $this->assign("dados", $_SESSION);
            $this->assign("title", TITLE . "Lista de Pedidos");
            $this->view_tpl("admin/pedidos_lista");
        }
    }

    public function status() {
        if ($this->permitir_acesso($_SESSION["EMAIL"], $_SESSION["SENHA"], "ADMINISTRADOR")) {

            $arr = $this->array_url();
            $codpedido = strtoupper($arr[1]);

            ( $arr[0] == 1 ) ? $status = 0 : $status = 1;

            $model = new Pedido_Model();
            $model->update_status_pedido($codpedido, $status);

            $quebra_linha = "\n";
            $emailsender = "maria@mariadebarro.com.br";
            $nomeremetente = "Maria de Barro";
            $comcopia = $email;

            $vars["compras"] = $model->get_compras($codpedido);

            $cadastro = $model->get_cadastro_for_pedido($codpedido);

            foreach ($cadastro as $obj) {
                $cad = $obj;
                $vars["cadastro"] = $obj;
            }

            $pedido = $model->get_pedido($codpedido, $cad->CODCADASTRO);
            $vars["pedido"] = $pedido;

            if ($status == 1) {
                $assunto_texto = "Confirmação de Venda, Nº - {$pedido->N_PEDIDO}";
            } else {
                $assunto_texto = "Venda cancelada, Nº - {$pedido->N_PEDIDO}";
            }

            $assunto = "=?UTF-8?B?" . base64_encode($assunto_texto) . "?=";

            $endereco_entrega = $model->get_endereco_entrega($codpedido);

            foreach ($endereco_entrega as $obj) {
                $vars["endereco"] = $obj;
            }

            $mensagemHTML = $this->view_email_print("emails/alerta_compra", $vars);

            $headers = "MIME-Version: 1.1{$quebra_linha}";
            $headers .= "Content-type: text/html; charset=UTF-8{$quebra_linha}";
            $headers .= "From: \"{$nomeremetente}\"<{$emailsender}>{$quebra_linha}";
            $headers .= "Return-Path: {$emailsender}{$quebra_linha}";
            $headers .= "Cc: {$comcopia}{$quebra_linha}";
            $headers .= "Reply-To: {$emaildesitnatario}{$quebra_linha}";
            $headers .= "X-Mailer: PHP/" . phpversion();

            $emaildesitnatario = "maria@mariadebarro.com.br";
            mail($emaildesitnatario, $assunto, $mensagemHTML, $headers, "-f" . $emailsender);

            $emaildesitnatario = "fabiano@mariadebarro.com.br";
            mail($emaildesitnatario, $assunto, $mensagemHTML, $headers, "-f" . $emailsender);

            $emaildesitnatario = "thais@mariadebarro.com.br";
            mail($emaildesitnatario, $assunto, $mensagemHTML, $headers, "-f" . $emailsender);

            echo "<script>window.location='" . MEU_SITE . "pedidos/pedidos_lista'</script>";
            exit();
        }
    }

    public function delete() {
        if ($this->permitir_acesso($_SESSION["EMAIL"], $_SESSION["SENHA"], "ADMINISTRADOR")) {

            $arr = $this->array_url();
            $codpedido = strtoupper($arr[1]);

            $model = new Pedido_Model();
            
            $sem_compras = $model->get_compras_return_produtos($codpedido);
            
            if ($sem_compras) {
                foreach ($sem_compras as $compra) {
                    $model->update_produtos_return_qntdd($compra->CODPRODUTO, $compra->QUANTIDADE);
                }
            }
            
            $model->delete_pedido($codpedido);

            echo "<script>window.location='" . MEU_SITE . "pedidos/pedidos-lista'</script>";
            exit();
        }
    }

    public function view() {
        if ($this->permitir_acesso($_SESSION["EMAIL"], $_SESSION["SENHA"], "ADMINISTRADOR")) {

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

            $this->assign("pedido", $pedido);
            $endereco_entrega = $model->get_endereco_entrega($codpedido);
            $this->assign("endereco_entrega", $endereco_entrega);
            $anotacoes = $model->get_anotacao_pedido($codpedido);
            $this->assign("anotacoes", $anotacoes);

            if ($_POST) {

                $dados["CODANOTACAO"] = $this->getPrimarykey();
                $dados["STATUS"] = $_POST["situacao"];

                if ($dados["STATUS"] == "Concluido") {
                    $dados["APONTAMENTO"] = "Obrigado por adiquirir nosso produtos! Para sugestões ou críticas favor enviar e-mails para \"maria@mariadebarro.com.br\"<br><br><b>" . trim(stripslashes($_POST["observacoes"])) ."</b>";
                    $model->update_status_pedido($codpedido, 1);
                } else {
                    $dados["APONTAMENTO"] = trim(stripslashes($_POST["observacoes"]));
                }

                $model->insert_anotacao($dados);

                $relacionamento["CODPEDIDO"] = $codpedido;
                $relacionamento["CODANOTACAO"] = $dados["CODANOTACAO"];

                if ($dados["APONTAMENTO"] != "") {
                    $model->insert_pedidos_rel_anotacao($relacionamento);
                }

                $vars["nome"] = $cad->NOME;
                $vars["email"] = $cad->EMAIL;
                $vars["status"] = $dados["STATUS"];
                $vars["n_pedido"] = $pedido->N_PEDIDO;
                $vars["apontamento"] = $dados["APONTAMENTO"];
                $vars["timestamp"] = $model->getTimestamp();


                $quebra_linha = "\n";
                $emailsender = "maria@mariadebarro.com.br";
                $nomeremetente = "Maria de Barro";
                $emaildesitnatario = $vars["email"];
                $assunto_texto = "Serviço de Rastreamento do pedido {$pedido->N_PEDIDO} em {$vars['timestamp']}!";
                $assunto = "=?UTF-8?B?" . base64_encode($assunto_texto) . "?=";

                $mensagemHTML = $this->view_email_print("emails/restreamento", $vars);

                $headers = "MIME-Version: 1.1{$quebra_linha}";
                $headers .= "Content-type: text/html; charset=UTF-8{$quebra_linha}";
                $headers .= "From: \"{$nomeremetente}\"<{$emailsender}>{$quebra_linha}";
                $headers .= "Return-Path: {$emailsender}{$quebra_linha}";
                $headers .= "Cc: {$comcopia}{$quebra_linha}";
                $headers .= "Reply-To: {$emaildesitnatario}{$quebra_linha}";
                $headers .= "X-Mailer: PHP/" . phpversion();

                mail($emaildesitnatario, $assunto, $mensagemHTML, $headers, "-f" . $emailsender);

                echo "<script>window.location='" . MEU_SITE . "pedidos/view/codpedido/" . $arr[1] . "/'</script>";
                exit();
            }

            $this->assign("language", LANGUAGE);
            $this->assign("page", "pedidos_lista");
            $this->assign("dados", $_SESSION);
            $this->assign("title", TITLE . "Visualizar Pedido");
            $this->view_tpl("admin/view");
        }
    }

    public function exportar_endereco() {
        if ($this->permitir_acesso($_SESSION["EMAIL"], $_SESSION["SENHA"], "ADMINISTRADOR")) {

            // Instanciamos a classe
            $objPHPExcel = new PHPExcel();
            $model = new Pedido_Model();

            // Definimos o estilo da fonte
            $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle('D1')->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle('E1')->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle('F1')->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle('G1')->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle('H1')->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle('I1')->getFont()->setBold(true);

            // Criamos as colunas
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue("A1", "PEDIDO")
                    ->setCellValue("B1", "NOME")
                    ->setCellValue("C1", "ENDERECO")
                    ->setCellValue("D1", "NUMERO")
                    ->setCellValue("E1", "COMPLEMENTO")
                    ->setCellValue("F1", "BAIRRO")
                    ->setCellValue("G1", "CIDADE")
                    ->setCellValue("H1", "UF")
                    ->setCellValue("I1", "CEP");


            // Podemos configurar diferentes larguras paras as colunas como padrão
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(11);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(40);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(40);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(40);
            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(40);
            $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(40);
            $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(5);
            $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(10);

            // Adicionamos um estilo de A1 até D1 
            $objPHPExcel->getActiveSheet()->getStyle('A1:I1')->applyFromArray(
                    array('fill' => array(
                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                            'color' => array('rgb' => 'E0EEEE')
                        ),
                    )
            );

            $size = $model->num_pedidos_endereco_entrega();
            $endEntrega = $model->get_pedidos_endereco_entrega();

            $txt = "";
            $txtW = "";

            if ($size > 0) {

                $i = 1;
                foreach ($endEntrega as $obj) {

                    // Também podemos escolher a posição exata aonde o dado será inserido (coluna, linha, dado);    
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, ($i + 1), $obj->CODIGO);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, ($i + 1), $obj->NOME);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, ($i + 1), $obj->ENDERECO);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, ($i + 1), $obj->NUMERO);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, ($i + 1), $obj->COMPLEMENTO);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, ($i + 1), $obj->BAIRRO);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, ($i + 1), $obj->CIDADE);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, ($i + 1), $obj->UF);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, ($i + 1), $obj->CEP);

                    $txt .= "Pedido: {$obj->CODIGO}\n";
                    $txt .= "{$obj->NOME}\n";
                    $txt .= "{$obj->ENDERECO} n: {$obj->NUMERO}, {$obj->COMPLEMENTO} - {$obj->BAIRRO}\n";
                    $txt .= "{$obj->CIDADE}/{$obj->UF}\n";
                    $txt .= "CEP: {$obj->CEP}\n";
                    $txt .= "--\n";
                    $txt .= "----------------------------------------------------------------------------\n";
                    $txt .= "--\n";

                    $txtW .= "Pedido: {$obj->CODIGO}\r\n";
                    $txtW .= "{$obj->NOME}\r\n";
                    $txtW .= "{$obj->ENDERECO} n: {$obj->NUMERO}, {$obj->COMPLEMENTO} - {$obj->BAIRRO}\r\n";
                    $txtW .= "{$obj->CIDADE}/{$obj->UF}\r\n";
                    $txtW .= "CEP: {$obj->CEP}\r\n";
                    $txtW .= "--\r\n";
                    $txtW .= "----------------------------------------------------------------------------\r\n";
                    $txtW .= "--\r\n";

                    $size = ($size - $i);
                    $i++;
                }
            } else {
                echo "<script>alert('" . utf8_decode("Não existem endereços para exportados!") . "')</script>";
                echo "<script>window.location='" . MEU_SITE . "pedidos/exportar'</script>";
                die();
            }

            // Podemos renomear o nome das planilha atual, lembrando que um único arquivo pode ter várias planilhas
            $objPHPExcel->getActiveSheet()->setTitle('Credenciamento para o Evento');

            $dados["CODXLS"] = $this->getPrimarykey();
            $dados["TIPO"] = "Planilha de Endereços para Entrega";

            $file_name = strtolower($dados["CODXLS"]) . ".xls";
            $file_name_txt = strtolower($dados["CODXLS"]) . ".txt";
            $file_name_txtW = strtolower($dados["CODXLS"] . "_W") . ".txt";

            $dados["LINK"] = "/web-files/xls/" . $file_name;
            $dados["LINK2"] = "/web-files/txt/" . $file_name_txt;
            $dados["LINK3"] = "/web-files/txt/" . $file_name_txtW;

            $file_path = DIR . "/web-files/xls/" . $file_name;
            $file_path_txt = DIR . "/web-files/txt/" . $file_name_txt;
            $file_path_txtW = DIR . "/web-files/txt/" . $file_name_txtW;

            $d["WAS_EXPORTED"] = "sim";

            if ($model->insert_xls($dados)) {

                $f = fopen($file_path_txt, 'a');
                fwrite($f, $txt);
                fclose($f);

                $fW = fopen($file_path_txtW, 'a');
                fwrite($fW, $txtW);
                fclose($fW);

                foreach ($endEntrega as $obj) {
                    $model->update_pedido_was_exportad_xls($d, $obj->CODPEDIDO);
                }
            }

            // Cabeçalho do arquivo para ele baixar
            //header("Content-Type: application/vnd.ms-excel");
            //header("Content-Disposition: attachment;filename='{$file_name}'");
            //header("Cache-Control: max-age=0");
            // Se for o IE9, isso talvez seja necessário
            //header("Cache-Control: max-age=1");
            // Acessamos o 'Writer' para poder salvar o arquivo
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

            // Salva diretamente no output, poderíamos mudar arqui para um nome de arquivo em um diretório ,caso não quisessemos jogar na tela
            $objWriter->save($file_path);
            echo "<script>window.location='" . MEU_SITE . "pedidos/exportar'</script>";
            exit;
        }
    }

    public function exportar() {
        if ($this->permitir_acesso($_SESSION["EMAIL"], $_SESSION["SENHA"], "ADMINISTRADOR")) {


            $this->assign("language", LANGUAGE);
            $this->assign("page", "exportar");
            $this->assign("dados", $_SESSION);
            $this->assign("title", TITLE . "Exportar Pedidos");
            $this->view_tpl("admin/exportar_pedidos");

//            $arr = $this->array_url();
//            $codpedido = strtoupper($arr[1]);
//          
//            ( $arr[0] == 1 ) ? $status = 0 : $status = 1;
//
//            $model = new Pedido_Model();
//            $model->update_status_pedido($codpedido, $status);
//
//            echo "<script>window.location='" . MEU_SITE . "pedidos/pedidos_lista'</script>";
//            exit();
        }
    }

}
