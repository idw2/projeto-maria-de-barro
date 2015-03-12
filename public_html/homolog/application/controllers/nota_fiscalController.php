<?php

Class Nota_Fiscal extends Controller {

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

        $arquivo_csv = new Nota_Fiscal_Model();
        $arquivo_csv_resultado = $arquivo_csv->get_cliente_csv();

        $this->assign("arquivo_csv_resultado", $arquivo_csv_resultado);

        $cts = new Conta_Model();
        $this->assign("existe_aniversariantes", $cts->existe_aniversariantes());

        $eame = new Produtos_Model();
        $this->assign("existe_avise_me", $eame->existe_avise_me());
        $this->assign("num_de_qntdd_produtos", $eame->num_de_qntdd_produtos());
        $this->assign("existe_novos_produtos_cadastrados", $eame->existe_novos_produtos_cadastrados());
    }

    public function index_action() {
        $this->exportar();
    }

    public function exportar() {
        if ($this->permitir_acesso($_SESSION["EMAIL"], $_SESSION["SENHA"])) {

            $this->assign("language", LANGUAGE);
            $this->assign("email", $email);
            $this->assign("page", "nota-fiscal");
            $this->assign("dados", $_SESSION);
            $this->assign("title", TITLE . "Nota Fiscal - Exportar");

            $this->view_tpl("admin/exportar");
        }
    }

    public function exportar_clientes() {
        if ($this->permitir_acesso($_SESSION["EMAIL"], $_SESSION["SENHA"])) {

            $clientes = new Nota_Fiscal_Model();
            $update = new Cadastro_Model();
            $d["WAS_EXPORTED"] = "sim";

            $menos = (int) $clientes->num_get_cadastro();
            $c = $clientes->get_cadastro();
            $csv = "";

//            $csv = utf8_decode("Nome do cliente / Nome Fantasia *,");	
//            $csv .= utf8_decode("Razão Social,");	
//            $csv .= utf8_decode("CNPJ,");	
//            $csv .= utf8_decode("CPF,");	
//            $csv .= utf8_decode("Email,");	
//            $csv .= utf8_decode("CEP,");	
//            $csv .= utf8_decode("Estado,");	
//            $csv .= utf8_decode("Cidade,");	
//            $csv .= utf8_decode("Endereço,");	
//            $csv .= utf8_decode("Bairro,");	
//            $csv .= utf8_decode("Número,");	
//            $csv .= utf8_decode("Complemento,");	
//            $csv .= utf8_decode("Telefone,");	
//            $csv .= utf8_decode("Contato,");	
//            $csv .= utf8_decode("Data de nascimento / Fundação,");
//            $csv .= "\n";

            if ($menos != 0) {
                $i = 1;
                foreach ($c as $obj) {

                    $csv .= trim($obj->NOME) . ",";
                    $csv .= trim($obj->RAZAO_SOCIAL) . ",";
                    $csv .= trim($obj->CNPJ) . ",";
                    $csv .= trim($obj->CPF) . ",";
                    $csv .= trim($obj->EMAIL) . ",";
                    $csv .= trim($obj->CEP) . ",";
                    $csv .= trim($obj->ESTADO) . ",";
                    $csv .= trim($obj->CIDADE) . ",";
                    $csv .= trim($obj->ENDERECO) . ",";
                    $csv .= trim($obj->BAIRRO) . ",";
                    $csv .= trim($obj->NUMERO) . ",";
                    $csv .= trim($obj->COMPLEMENTO) . ",";
                    $csv .= trim($obj->TELEFONE) . ",";
                    $csv .= trim($obj->CONTATO) . ",";
                    $csv .= trim($obj->NASCIMENTO);

                    if ($i != $menos) {
                        $csv .= "\n";
                    }
                    $i++;
                }


                $dados["CODCSV"] = $this->getPrimarykey();
                $dados["TIPO"] = "cliente";
                $file_name = strtolower($dados["CODCSV"]) . ".csv";
                $dados["LINK"] = "/web-files/csv/" . $file_name;
                $file_path = DIR . "/web-files/csv/" . $file_name;

                if ($clientes->insert_csv($dados)) {

//                    header("Content-Type: application/csv");
//                    header("Content-Disposition: attachment;Filename={$file_name}");
//                    echo $csv;
//                    die();


                    if (fwrite($file = fopen($file_path, 'w+'), $csv)) {
                        fclose($file);
                        foreach ($c as $obj) {
                            $update->update_cadastro($d, $obj->EMAIL);
                        }
                        echo "<script>alert('Arquivo gravado com sucesso!')</script>";
                    } else {
                        echo "<script>alert('Problemas ao gerar o arquivo, tente novamente!')</script>";
                    }
                } else {
                    echo "<script>alert('Ocorreu um erro ao tentar exportar clientes para .CSV!')</script>";
                    echo "<script>window.location='" . MEU_SITE . "nota-fiscal/exportar'</script>";
                }

                echo "<script>window.location='" . MEU_SITE . "nota-fiscal/exportar'</script>";
            } else {
                echo "<script>alert('" . utf8_decode("Não existem clientes para exportados!") . "')</script>";
                echo "<script>window.location='" . MEU_SITE . "nota-fiscal/exportar'</script>";
            }
        }
    }

    public function exportar_clientes_xls() {
        if ($this->permitir_acesso($_SESSION["EMAIL"], $_SESSION["SENHA"])) {

            $clientes = new Nota_Fiscal_Model();
            $update = new Cadastro_Model();
            $d["WAS_EXPORTED"] = "sim";

            $menos = (int) $clientes->num_get_cadastro();
            $c = $clientes->get_cadastro();
            $csv = "";

//            $csv = utf8_decode("Nome do cliente / Nome Fantasia *,");	
//            $csv .= utf8_decode("Razão Social,");	
//            $csv .= utf8_decode("CNPJ,");	
//            $csv .= utf8_decode("CPF,");	
//            $csv .= utf8_decode("Email,");	
//            $csv .= utf8_decode("CEP,");	
//            $csv .= utf8_decode("Estado,");	
//            $csv .= utf8_decode("Cidade,");	
//            $csv .= utf8_decode("Endereço,");	
//            $csv .= utf8_decode("Bairro,");	
//            $csv .= utf8_decode("Número,");	
//            $csv .= utf8_decode("Complemento,");	
//            $csv .= utf8_decode("Telefone,");	
//            $csv .= utf8_decode("Contato,");	
//            $csv .= utf8_decode("Data de nascimento / Fundação,");
//            $csv .= "\n";
            // Instanciamos a classe
            $objPHPExcel = new PHPExcel();

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
            $objPHPExcel->getActiveSheet()->getStyle('J1')->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle('K1')->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle('L1')->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle('M1')->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle('N1')->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle('O1')->getFont()->setBold(true);

            // Criamos as colunas
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue("A1", "Nome do cliente / Nome Fantasia *")
                    ->setCellValue("B1", "Razão Social")
                    ->setCellValue("C1", "CNPJ")
                    ->setCellValue("D1", "CPF")
                    ->setCellValue("E1", "Email")
                    ->setCellValue("F1", "CEP")
                    ->setCellValue("G1", "Estado")
                    ->setCellValue("H1", "Cidade")
                    ->setCellValue("I1", "Endereço")
                    ->setCellValue("J1", "Bairro")
                    ->setCellValue("K1", "Número")
                    ->setCellValue("L1", "Complemento")
                    ->setCellValue("M1", "Telefone")
                    ->setCellValue("N1", "Contato")
                    ->setCellValue("O1", "Data de nascimento / Fundação")
            ;

            // Podemos configurar diferentes larguras paras as colunas como padrão
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(40);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(40);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(40);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(40);
            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(40);
            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(40);
            $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(40);
            $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(40);
            $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(40);
            $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(40);
            $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(40);
            $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(40);
            $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(40);
            $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(40);
            $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(40);

            // Adicionamos um estilo de A1 até D1 
            $objPHPExcel->getActiveSheet()->getStyle('A1:O1')->applyFromArray(
                    array('fill' => array(
                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                            'color' => array('rgb' => 'E0EEEE')
                        ),
                    )
            );

            if ($menos != 0) {
                $i = 1;
                foreach ($c as $obj) {

                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, ($i + 1), trim($obj->NOME));
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, ($i + 1), trim($obj->RAZAO_SOCIAL));
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, ($i + 1), trim($obj->CNPJ));
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, ($i + 1), trim($obj->CPF));
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, ($i + 1), trim($obj->EMAIL));
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, ($i + 1), trim($obj->CEP));
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, ($i + 1), trim($obj->ESTADO));
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, ($i + 1), trim($obj->CIDADE));
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, ($i + 1), trim($obj->ENDERECO));
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, ($i + 1), trim($obj->BAIRRO));
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10, ($i + 1), trim($obj->NUMERO));
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11, ($i + 1), trim($obj->COMPLEMENTO));
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12, ($i + 1), trim($obj->TELEFONE));
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(13, ($i + 1), trim($obj->CONTATO));
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(14, ($i + 1), trim($obj->NASCIMENTO));

                    $i++;
                }


                // Podemos renomear o nome das planilha atual, lembrando que um único arquivo pode ter várias planilhas
                $objPHPExcel->getActiveSheet()->setTitle('Credenciamento para o Evento');

                $dados["CODCSV"] = $this->getPrimarykey();
                $dados["TIPO"] = "cliente";
                $file_name = strtolower($dados["CODCSV"]) . ".xls";
                $dados["LINK"] = "/web-files/csv/" . $file_name;
                $file_path = DIR . "/web-files/csv/" . $file_name;

                if ($clientes->insert_csv($dados)) {

                    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
                    $objWriter->save($file_path);

                    foreach ($c as $obj) {
                        $update->update_cadastro($d, $obj->EMAIL);
                    }
                    echo "<script>alert('Arquivo gravado com sucesso!')</script>";
                    echo "<script>window.location='" . MEU_SITE . "nota-fiscal/exportar'</script>";
                    die();
                    
                } else {
                    echo "<script>alert('Ocorreu um erro ao tentar exportar clientes para .CSV!')</script>";
                    echo "<script>window.location='" . MEU_SITE . "nota-fiscal/exportar'</script>";
                }

                echo "<script>window.location='" . MEU_SITE . "nota-fiscal/exportar'</script>";
            } else {
                echo "<script>alert('" . utf8_decode("Não existem clientes para exportados!") . "')</script>";
                echo "<script>window.location='" . MEU_SITE . "nota-fiscal/exportar'</script>";
            }
        }
    }

    public function exportar_produtos() {
        if ($this->permitir_acesso($_SESSION["EMAIL"], $_SESSION["SENHA"])) {

            $clientes = new Nota_Fiscal_Model();
            $update = new Produtos_Model();
            $d["WAS_EXPORTED"] = "sim";

            $menos = (int) $clientes->num_get_produto();
            $c = $clientes->get_produto();
            $csv = "";

            if ($menos != 0) {
                $i = 1;
                foreach ($c as $obj) {

                    ##Código	
                    ##Quantidade	
                    #Descrição do produto *	
                    ##Preço de Compra	
                    ##Preço de Venda	
                    ##Código de barras (GTIN/EAN)	=
                    ##Unidade	= volume, massa, kg, etc
                    ##NCM	
                    ##Categoria do produto	
                    ##Peso Bruto (quilos)	
                    #Peso Líquido (quilos)

                    $csv .= $obj->CODIGO . ",";
                    $csv .= $obj->QUANTIDADE . ",";
                    $csv .= $obj->DESCRICAO . ",";

                    $obj->PRECO_COMPRA = $this->formataReais($obj->PRECO_COMPRA);
                    $obj->PRECO_COMPRA = str_replace(".", "", $obj->PRECO_COMPRA);
                    $obj->PRECO_COMPRA = str_replace(",", ".", $obj->PRECO_COMPRA);
                    $csv .= $obj->PRECO_COMPRA . ",";

                    $obj->PRECO_VENDA = $this->formataReais($obj->PRECO_VENDA);
                    $obj->PRECO_VENDA = str_replace(".", "", $obj->PRECO_VENDA);
                    $obj->PRECO_VENDA = str_replace(",", ".", $obj->PRECO_VENDA);

                    $csv .= $obj->PRECO_VENDA . ",";

                    $csv .= $obj->CODIGO_BARRAS . ",";
                    $csv .= $obj->UNIDADE . "kg,";
                    $csv .= "71171900,";

                    $csv .= utf8_decode($obj->CATEGORIA) . ",";
                    $csv .= $obj->PESO . ",";

                    if ($i != $menos) {
                        $csv .= ",\n";
                    }
                    $i++;
                }

                $dados["CODCSV"] = $this->getPrimarykey();
                $dados["TIPO"] = "produto";
                $dados["LINK"] = "/web-files/csv/" . strtolower($dados["CODCSV"]) . ".csv";

                $file_path = DIR . "/web-files/csv/" . strtolower($dados["CODCSV"]) . ".csv";

                if ($clientes->insert_csv($dados)) {

                    if (fwrite($file = fopen($file_path, 'w+'), $csv)) {
                        fclose($file);
                        foreach ($c as $obj) {
                            $update->update_produto($d, $obj->CODPRODUTO);
                        }
                        echo "<script>alert('Arquivo gravado com sucesso!')</script>";
                    } else {
                        echo "<script>alert('Problemas ao gerar o arquivo, tente novamente!')</script>";
                    }
                } else {
                    echo "<script>alert('Ocorreu um erro ao tentar exportar clientes para .CSV!')</script>";
                    echo "<script>window.location='" . MEU_SITE . "nota-fiscal/exportar'</script>";
                }

                echo "<script>window.location='" . MEU_SITE . "nota-fiscal/exportar'</script>";
            } else {
                echo "<script>alert('" . utf8_decode("Não existem clientes para exportados!") . "')</script>";
                echo "<script>window.location='" . MEU_SITE . "nota-fiscal/exportar'</script>";
            }
        }
    }

    public function exportar_produtos_xls() {
        if ($this->permitir_acesso($_SESSION["EMAIL"], $_SESSION["SENHA"])) {

            $clientes = new Nota_Fiscal_Model();
            $update = new Produtos_Model();
            $d["WAS_EXPORTED"] = "sim";

            $menos = (int) $clientes->num_get_produto();
            $c = $clientes->get_produto();
            $csv = "";

            if ($menos != 0) {


                $objPHPExcel = new PHPExcel();

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
                $objPHPExcel->getActiveSheet()->getStyle('J1')->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->getStyle('L1')->getFont()->setBold(true);

                // Criamos as colunas
                $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue("A1", "Código")
                        ->setCellValue("B1", "Quantidade")
                        ->setCellValue("C1", "Descrição do produto *")
                        ->setCellValue("D1", "Preço de Compra")
                        ->setCellValue("E1", "Preço de Venda")
                        ->setCellValue("F1", "Código de barras (GTIN/EAN)")
                        ->setCellValue("G1", "Unidade")
                        ->setCellValue("H1", "NCM")
                        ->setCellValue("I1", "Categoria do produto")
                        ->setCellValue("J1", "Peso Bruto (quilos)")
                        ->setCellValue("L1", "Peso Líquido (quilos)");


                // Podemos configurar diferentes larguras paras as colunas como padrão
                $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(40);
                $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(40);
                $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(40);
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(40);
                $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(40);
                $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(40);
                $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(40);
                $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(40);
                $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(40);
                $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(40);
                $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(40);

                // Adicionamos um estilo de A1 até D1 
                $objPHPExcel->getActiveSheet()->getStyle('A1:L1')->applyFromArray(
                        array('fill' => array(
                                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                'color' => array('rgb' => 'E0EEEE')
                            ),
                        )
                );

                $i = 1;
                foreach ($c as $obj) {

                    ##Código	
                    ##Quantidade	
                    #Descrição do produto *	
                    ##Preço de Compra	
                    ##Preço de Venda	
                    ##Código de barras (GTIN/EAN)	=
                    ##Unidade	= volume, massa, kg, etc
                    ##NCM	
                    ##Categoria do produto	
                    ##Peso Bruto (quilos)	
                    #Peso Líquido (quilos)

                    $csv .= $obj->CODIGO . ",";
                    $csv .= $obj->QUANTIDADE . ",";
                    $csv .= $obj->DESCRICAO . ",";

                    $obj->PRECO_COMPRA = $this->formataReais($obj->PRECO_COMPRA);
                    $obj->PRECO_COMPRA = str_replace(".", "", $obj->PRECO_COMPRA);
                    $obj->PRECO_COMPRA = str_replace(",", ".", $obj->PRECO_COMPRA);
                    $csv .= $obj->PRECO_COMPRA . ",";

                    $obj->PRECO_VENDA = $this->formataReais($obj->PRECO_VENDA);
                    $obj->PRECO_VENDA = str_replace(".", "", $obj->PRECO_VENDA);
                    $obj->PRECO_VENDA = str_replace(",", ".", $obj->PRECO_VENDA);

                    $csv .= $obj->PRECO_VENDA . ",";

                    $csv .= $obj->CODIGO_BARRAS . ",";
                    $csv .= $obj->UNIDADE . "kg,";
                    $csv .= "71171900,";

                    $csv .= utf8_decode($obj->CATEGORIA) . ",";
                    $csv .= $obj->PESO . ",";

                    if ($i != $menos) {
                        $csv .= ",\n";
                    }

                    // Criamos as colunas
                    $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue("A1", "Código")
                            ->setCellValue("B1", "Quantidade")
                            ->setCellValue("C1", "Descrição do produto *")
                            ->setCellValue("D1", "Preço de Compra")
                            ->setCellValue("E1", "Preço de Venda")
                            ->setCellValue("F1", "Código de barras (GTIN/EAN)")
                            ->setCellValue("G1", "Unidade")
                            ->setCellValue("H1", "NCM")
                            ->setCellValue("I1", "Categoria do produto")
                            ->setCellValue("J1", "Peso Bruto (quilos)")
                            ->setCellValue("L1", "Peso Líquido (quilos)");

                    // Também podemos escolher a posição exata aonde o dado será inserido (coluna, linha, dado);    
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, ($i + 1), $obj->CODIGO);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, ($i + 1), $obj->QUANTIDADE);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, ($i + 1), $obj->DESCRICAO);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, ($i + 1), $obj->PRECO_COMPRA);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, ($i + 1), $obj->PRECO_VENDA);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, ($i + 1), $obj->CODIGO_BARRAS);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, ($i + 1), $obj->UNIDADE . "kg");
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, ($i + 1), "71171900");
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, ($i + 1), $obj->CATEGORIA);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, ($i + 1), $obj->PESO);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10, ($i + 1), "");

                    $i++;
                }

                // Podemos renomear o nome das planilha atual, lembrando que um único arquivo pode ter várias planilhas
                $objPHPExcel->getActiveSheet()->setTitle('Credenciamento para o Evento');

                $dados["CODCSV"] = $this->getPrimarykey();
                $dados["TIPO"] = "produto";
                $dados["LINK"] = "/web-files/csv/" . strtolower($dados["CODCSV"]) . ".xls";

                $file_path = DIR . "/web-files/csv/" . strtolower($dados["CODCSV"]) . ".xls";

                if ($clientes->insert_csv($dados)) {

                    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
                    $objWriter->save($file_path);

                    foreach ($c as $obj) {
                        $update->update_produto($d, $obj->CODPRODUTO);
                    }
                    echo "<script>alert('Arquivo gravado com sucesso!')</script>";
                    echo "<script>window.location='" . MEU_SITE . "nota-fiscal/exportar'</script>";
                    die();
                } else {
                    echo "<script>alert('Ocorreu um erro ao tentar exportar clientes para .CSV!')</script>";
                    echo "<script>window.location='" . MEU_SITE . "nota-fiscal/exportar'</script>";
                }

                echo "<script>window.location='" . MEU_SITE . "nota-fiscal/exportar'</script>";
            } else {
                echo "<script>alert('" . utf8_decode("Não existem clientes para exportados!") . "')</script>";
                echo "<script>window.location='" . MEU_SITE . "nota-fiscal/exportar'</script>";
            }
        }
    }

}
