<?php

Class Produtos extends Controller {

    public function __construct() {
        $this->get_smarty();
        $this->run();

        $this->assign("facebook", FACEBOOK);
        $this->assign("instagram", INSTAGRAM);
        $this->assign("twitter", TWITTER);
        $this->assign("google_plus", GOOGLE_PLUS);
        $this->assign("papel", PAPEL);
        $this->assign("email_restricao", $_SESSION["EMAIL"]);
        $this->assign("papel", PAPEL);
        $this->assign("protocolo", PROTOCOLO);
        $this->assign("source", SOURCE);
        $this->assign("web_files", WEB_FILES);
        $this->assign("meu_site", MEU_SITE);
        $this->assign("language", LANGUAGE);
        $this->assign("nome_logon", $_SESSION["NOME"]);
        $this->assign("email_logon", $_SESSION["EMAIL"]);
        $this->assign("saudacao", $this->saudacao());

        /*
         * INSTANCIAMOS A CLASSE PRODUTOS 
         */
        $lista_desejos = new Produtos_Model();
        /*
         * GERA UM ARRAY DE OBJETOS OS PRODUTOS DESEJADO PELO CLIENTE
         */
        $primeira_lista = $lista_desejos->get_drop_lista_desejos(null, CLIENT_HIDDEN);
        /*
         * CASO ESTE ARRAY EXISTA SEGUE O PROXIMO PASSO
         */
        if ($primeira_lista) {

            /*
             * CRIAMOS UM ARREY PARA SALVAR INFORMACOES DO OBJETO INTERADO PELA PRIMEIRA LISTAGEM
             */
            $array_primeira_interacao = array();
            /*
             * FAZENDO A INTERACAO COM A PRIMEIRA LISTA DE DESEJOS
             */
            foreach ($primeira_lista as $pl) {
                /*
                 * COMPARA SE A QUANTIDADE DE PRODUTOS SOLICITADOS E MAIOR DO EXISTENTE EM ESTOQUE
                 */
                if ($pl->QUANTIDADE > $pl->QUANTIDADE_EXISTENTE) {

                    /*
                     * MONTA UM NOVO ARRAY TEMPORARIO PARA SALVAR AS NOVAS INFORMACOES
                     */
                    $new['CODLISTADESEJOS'] = $this->getPrimarykey();
                    $new['CLIENT_HIDDEN'] = CLIENT_HIDDEN;
                    $new['CODPRODUTO'] = $pl->CODPRODUTO;
                    $new['QUANTIDADE'] = $pl->QUANTIDADE_EXISTENTE;
                    /*
                     * DELETA O DESEJO COM A QUANTIDADE DE PRODUTOS ERRADO
                     */
                    $lista_desejos->del_row_wishlist($new['CODPRODUTO'], $new['CLIENT_HIDDEN']);
                    /*
                     * SALVA NOVA LISTA DE DESEJOS
                     */
                    $lista_desejos->add_lista_desejos($new);
                    /*
                     * MATA O ARRAY TEMPORARIO
                     */
                    unset($new);
                }
                /*
                 * SALAVA O OBJETO NA PRIMEIRA INTERACAO
                 */
                $array_primeira_interacao[] = $pl;
            }
            /*
             * SEGUNDA INTERACAO
             */
            $segunda_lista = $lista_desejos->get_drop_lista_desejos(null, CLIENT_HIDDEN);
            /*
             * CRIAMOS UM ARREY PARA SALVAR INFORMACOES DO OBJETO INTERADO PELA SEGUNDA LISTAGEM
             */
            $array_segunda_interacao = array();
            $i = 0;
            foreach ($segunda_lista as $sl) {
                /*
                 * CRIAMOS UM OBJETO TEMPORARIO PARA COMPARACAO COM A SEGUNDA INTERACAO
                 */
                $obj_tmp = $array_primeira_interacao[$i];
                /*
                 * REALIZA A MESMA CHECAGEM COM A INTERACAO ANTERIOS
                 */
                if ($obj_tmp->QUANTIDADE > $obj_tmp->QUANTIDADE_EXISTENTE) {
                    /*
                     * SALVA NO SEGUNDO ARRAY A MENSAGEM DE ALERTA
                     */
                    if ($obj_tmp->QUANTIDADE_EXISTENTE == 1) {
                        $sl->ALERT = "Apenas 1 item disponivel para venda!";
                    } else {
                        $sl->ALERT = "Apenas {$obj_tmp->QUANTIDADE_EXISTENTE} itens disponivel para venda!";
                    }
                    /*
                     * MATA O OBJETO TEMPORARIO
                     */
                    unset($obj_tmp);
                }
                /*
                 * SALAVA O OBJETO NA PRIMEIRA INTERACAO
                 */
                $array_segunda_interacao[] = $sl;
                $i++;
            }

            /*
             * CRIA UM ARRAY PASSANDO O RESULTADO PARA O OBJETO SMARTY
             */
            $this->assign("ld", $array_segunda_interacao);
            $nenhum_produto = false;
        } else {
            /*
             * SE NÃO EXISTIR NADA NA LISTA DE DESEJOS EXIBE QUE O CARRINHO ESTA VAZIO
             */
            $this->assign("nenhum_produto", true);
            $nenhum_produto = true;
        }
        /*
         * CARREGA O TOTAL GERAL EM UM OBJETO E SALVA VARIAVEL SMARTY
         */
        $total_geral = $lista_desejos->get_total_geral_lista_desejos(CLIENT_HIDDEN);
        if ($total_geral) {
            $this->assign("total_geral", $total_geral->TOTAL_GERAL);
        }
        /*
         * CARREGA O TOTAL DO PRODUTOS EM UM OBJETO E SALVA VARIAVEL SMARTY
         */
        $total_produtos = $lista_desejos->get_total_produtos_lista_desejos(CLIENT_HIDDEN);
        if ($total_produtos) {
            $this->assign("total_produtos", $total_produtos->TOTAL_PRODUTOS);
        }
        /*
         * CARREGA O TOTAL DE PESO EM UM OBJETO E SALVA VARIAVEL SMARTY
         */
        $total_peso = $lista_desejos->get_total_peso_lista_desejos(CLIENT_HIDDEN);
        if ($total_peso) {
            $this->assign("total_peso", (float) $total_peso->TOTAL_PESO);
        }

        if (!$nenhum_produto) {
            /*
             * CARREGA O IMPOSTO SOBRE A COMPRA EM UM OBJETO E SALVA VARIAVEL SMARTY
             */
            $sobre_valor = str_replace(",", "", $total_geral->TOTAL_GERAL);
            $sobre_valor = str_replace(".", "", $sobre_valor);

            $imposto = $lista_desejos->calcula_imposto(IMPOSTO, $sobre_valor);
            $this->assign("imposto", IMPOSTO);

            if ($imposto) {
                $this->assign("sobre_valor", $imposto->IMPOSTO);
            }

            $sem_impostos = str_replace(".", "", $imposto->IMPOSTO);
            $sem_impostos = str_replace(",", "", $sem_impostos);

            $this->assign("sem_impostos", $this->formataReais(($sobre_valor - $sem_impostos)));

            $bonus = $this->formataReais(round($sobre_valor / BONUS) - $sobre_valor);
            $this->assign("bonus", $bonus);
        }

        /*
         * CARREGA OS PARAMETROS DA LOJA JUNTO A CIELO E SALVA VARIAVEL SMARTY
         * OS PARAMETROS CIELO ESTAO INFORMADO NA INDEX DO PROJETO EM VARIAVEIS GLOBAIS
         */
        $this->assign("CIELO_N", CIELO_N);
        $this->assign("CIELO_KEY", CIELO_KEY);
        $this->assign("CIELO_URL", CIELO_URL);
        $this->assign("site", PROTOCOLO . SITE . SOURCE);

        $cts = new Conta_Model();
        $this->assign("existe_aniversariantes", $cts->existe_aniversariantes());

        $eame = new Produtos_Model();
        $this->assign("existe_avise_me", $eame->existe_avise_me());
        $this->assign("num_de_qntdd_produtos", $eame->num_de_qntdd_produtos());
        $this->assign("existe_novos_produtos_cadastrados", $eame->existe_novos_produtos_cadastrados());
    }

    public function index_action() {
        $this->produtos_lista();
    }

    public function produtos_lista() {
        if ($this->permitir_acesso($_SESSION["EMAIL"], $_SESSION["SENHA"], "ADMINISTRADOR")) {

            $model = new Produtos_Model();

            #$this->assign("categoria", "todos");

            if ($_POST["actionType"] == "pesquisa_categoria") {
                $_SESSION["X"] = $_POST["categoria"];
                unset($_SESSION["Y"]);
            } else if ($_POST["actionType"] == "search") {
                unset($_SESSION["X"]);
                $_SESSION["Y"] = $_POST["search"];
            }

            if ($_POST["actionType"] == "pesquisa_categoria") {

                $_POST["categoria"];
                $this->assign("categoria", $_POST["categoria"]);

                if ($_POST["categoria"] != "todos") {
                    $meus_produtos = $model->select_produtos_all($_POST["categoria"]);
                } else {
                    $meus_produtos = $model->select_produtos_all();
                }

                if (!$meus_produtos) {
                    unset($_SESSION["X"]);
                    unset($_SESSION["Y"]);
                    $this->assign("ERRO_NAO_EXISTE_PRODUTOS", "ERRO_NAO_EXISTE_PRODUTOS");
                }
                $this->assign("meus_produtos", $meus_produtos);
            } else if (isset($_SESSION["X"])) {

                $_POST["categoria"] = $_SESSION["X"];
                $this->assign("categoria", $_POST["categoria"]);

                if ($_POST["categoria"] != "todos") {
                    $meus_produtos = $model->select_produtos_all($_POST["categoria"]);
                } else {
                    $meus_produtos = $model->select_produtos_all();
                }

                if (!$meus_produtos) {
                    unset($_SESSION["X"]);
                    unset($_SESSION["Y"]);
                    $this->assign("ERRO_NAO_EXISTE_PRODUTOS", "ERRO_NAO_EXISTE_PRODUTOS");
                }
                $this->assign("meus_produtos", $meus_produtos);
            } else if ($_POST["actionType"] == "search" && $_POST["search"] != "") {
                $meus_produtos = $model->select_produtos_all_search(utf8_decode($_POST["search"]));
                if (!$meus_produtos) {
                    unset($_SESSION["X"]);
                    unset($_SESSION["Y"]);
                    $this->assign("ERRO_NAO_EXISTE_PRODUTOS", "ERRO_NAO_EXISTE_PRODUTOS");
                }
                $this->assign("search", $_POST["search"]);
                $this->assign("meus_produtos", $meus_produtos);
            } else if (isset($_SESSION["Y"])) {
                $meus_produtos = $model->select_produtos_all_search(utf8_decode($_SESSION["Y"]));
                if (!$meus_produtos) {
                    unset($_SESSION["X"]);
                    unset($_SESSION["Y"]);
                    $this->assign("ERRO_NAO_EXISTE_PRODUTOS", "ERRO_NAO_EXISTE_PRODUTOS");
                }
                $this->assign("search", $_SESSION["Y"]);
                $this->assign("meus_produtos", $meus_produtos);
            } else {

                $meus_produtos = $model->select_produtos_all();
                if (!$meus_produtos) {
                    $this->assign("ERRO_NAO_EXISTE_PRODUTOS", "ERRO_NAO_EXISTE_PRODUTOS");
                }
                $this->assign("meus_produtos", $meus_produtos);
            }

            if ($model->num_de_qntdd_produtos() > 0) {
                $this->assign("falta_produtos_estoque", TRUE);
                $this->assign("num_produtos_que_faltam", $model->num_de_qntdd_produtos());
                $this->assign("referencia_nome_produtos", $model->get_referencia_nome_produtos());
            } else {
                $this->assign("falta_produtos_estoque", FALSE);
            }

            $this->assign("qtdd_aneis", $model->qnts_produtos_for_categoria("aneis"));
            $this->assign("qtdd_brincos", $model->qnts_produtos_for_categoria("brincos"));
            $this->assign("qtdd_colares", $model->qnts_produtos_for_categoria("colares"));
            $this->assign("qtdd_pulseiras", $model->qnts_produtos_for_categoria("pulseiras"));
            $this->assign("qtdd_conjuntos", $model->qnts_produtos_for_categoria("conjuntos"));
            $this->assign("total_produtos", (int) $model->qnts_produtos_for_categoria("aneis") + (int) $model->qnts_produtos_for_categoria("brincos") + (int) $model->qnts_produtos_for_categoria("colares") + (int) $model->qnts_produtos_for_categoria("pulseiras") + (int) $model->qnts_produtos_for_categoria("conjuntos"));

            $this->assign("language", LANGUAGE);
            $this->assign("email", $email);
            $this->assign("page", "produtos_lista");
            $this->assign("dados", $_SESSION);
            $this->assign("title", TITLE . "Lista de Produtos");
            $this->view_tpl("admin/produtos_lista");
        }
    }

    public function estoque() {
        if ($this->permitir_acesso($_SESSION["EMAIL"], $_SESSION["SENHA"], "ADMINISTRADOR")) {

            $model = new Produtos_Model();

            #$this->assign("categoria", "todos");

            if ($_POST["actionType"] == "pesquisa_categoria") {
                $_SESSION["A"] = $_POST["categoria"];
                unset($_SESSION["B"]);
            } else if ($_POST["actionType"] == "search") {
                unset($_SESSION["A"]);
                $_SESSION["B"] = $_POST["search"];
            }

            if ($_POST["actionType"] == "pesquisa_categoria") {

                $_POST["categoria"];
                $this->assign("categoria", $_POST["categoria"]);

                if ($_POST["categoria"] != "todos") {
                    $meus_produtos = $model->select_produtos_all($_POST["categoria"]);
                } else {
                    $meus_produtos = $model->select_produtos_all();
                }

                if (!$meus_produtos) {
                    unset($_SESSION["A"]);
                    unset($_SESSION["B"]);
                    $this->assign("ERRO_NAO_EXISTE_PRODUTOS", "ERRO_NAO_EXISTE_PRODUTOS");
                }
                $this->assign("meus_produtos", $meus_produtos);
            } else if (isset($_SESSION["A"])) {

                $_POST["categoria"] = $_SESSION["A"];
                $this->assign("categoria", $_POST["categoria"]);

                if ($_POST["categoria"] != "todos") {
                    $meus_produtos = $model->select_produtos_all($_POST["categoria"]);
                } else {
                    $meus_produtos = $model->select_produtos_all();
                }

                if (!$meus_produtos) {
                    unset($_SESSION["A"]);
                    unset($_SESSION["B"]);
                    $this->assign("ERRO_NAO_EXISTE_PRODUTOS", "ERRO_NAO_EXISTE_PRODUTOS");
                }
                $this->assign("meus_produtos", $meus_produtos);
            } else if ($_POST["actionType"] == "search" && $_POST["search"] != "") {

                $meus_produtos = $model->select_produtos_all_search(utf8_decode($_POST["search"]));
                if (!$meus_produtos) {
                    unset($_SESSION["A"]);
                    unset($_SESSION["B"]);
                    $this->assign("ERRO_NAO_EXISTE_PRODUTOS", "ERRO_NAO_EXISTE_PRODUTOS");
                }
                $this->assign("search", $_POST["search"]);
                $this->assign("meus_produtos", $meus_produtos);
            } else if (isset($_SESSION["B"])) {

                $meus_produtos = $model->select_produtos_all_search(utf8_decode($_SESSION["B"]));
                if (!$meus_produtos) {
                    unset($_SESSION["A"]);
                    unset($_SESSION["B"]);
                    $this->assign("ERRO_NAO_EXISTE_PRODUTOS", "ERRO_NAO_EXISTE_PRODUTOS");
                }
                $this->assign("search", $_SESSION["B"]);
                $this->assign("meus_produtos", $meus_produtos);
            } else {

                $meus_produtos = $model->select_produtos_all();
                if (!$meus_produtos) {
                    $this->assign("ERRO_NAO_EXISTE_PRODUTOS", "ERRO_NAO_EXISTE_PRODUTOS");
                }
                $this->assign("meus_produtos", $meus_produtos);
            }

            if ($model->num_de_qntdd_produtos() > 0) {
                $this->assign("falta_produtos_estoque", TRUE);
                $this->assign("num_produtos_que_faltam", $model->num_de_qntdd_produtos());
                $this->assign("referencia_nome_produtos", $model->get_referencia_nome_produtos());
            } else {
                $this->assign("falta_produtos_estoque", FALSE);
            }

            $this->assign("qtdd_aneis", $model->qnts_produtos_for_categoria("aneis"));
            $this->assign("qtdd_brincos", $model->qnts_produtos_for_categoria("brincos"));
            $this->assign("qtdd_colares", $model->qnts_produtos_for_categoria("colares"));
            $this->assign("qtdd_pulseiras", $model->qnts_produtos_for_categoria("pulseiras"));
            $this->assign("qtdd_conjuntos", $model->qnts_produtos_for_categoria("conjuntos"));
            $this->assign("total_produtos", (int) $model->qnts_produtos_for_categoria("aneis") + (int) $model->qnts_produtos_for_categoria("brincos") + (int) $model->qnts_produtos_for_categoria("colares") + (int) $model->qnts_produtos_for_categoria("pulseiras") + (int) $model->qnts_produtos_for_categoria("conjuntos"));

            $this->assign("language", LANGUAGE);
            $this->assign("email", $email);
            $this->assign("page", "estoque");
            $this->assign("dados", $_SESSION);
            $this->assign("title", TITLE . "Lista de Estoque");
            $this->view_tpl("admin/estoque");
        }
    }

    public function mais_vendidos_site() {
        if ($this->permitir_acesso($_SESSION["EMAIL"], $_SESSION["SENHA"], "ADMINISTRADOR")) {

            $model = new Produtos_Model();


            $meus_produtos = $model->select_mais_vendidos_site();
            if (!$meus_produtos) {
                $this->assign("ERRO_NAO_EXISTE_PRODUTOS", "ERRO_NAO_EXISTE_PRODUTOS");
            }
            $this->assign("meus_produtos", $meus_produtos);

            $this->assign("language", LANGUAGE);
            $this->assign("email", $email);
            $this->assign("page", "mais-vendidos-site");
            $this->assign("dados", $_SESSION);
            $this->assign("title", TITLE . "Lista de Produtos mais Vendidos");
            $this->view_tpl("admin/mais_vendidos_site");
        }
    }

    public function exportar_estoque_xls() {
        if ($this->permitir_acesso($_SESSION["EMAIL"], $_SESSION["SENHA"], "ADMINISTRADOR")) {

            $model = new Produtos_Model();

            $meus_produtos = $model->select_produtos_all();


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

            // Criamos as colunas
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue("A1", "Referência")
                    ->setCellValue("B1", "Nome")
                    ->setCellValue("C1", "Categoria")
                    ->setCellValue("D1", "Peso/Kg.")
                    ->setCellValue("E1", "Quantidade")
                    ->setCellValue("F1", "Preço Final do Produto por Unidade")
                    ->setCellValue("G1", "Preço Unitário de Compra do Produto")
                    ->setCellValue("H1", "Total da Compra");


            // Podemos configurar diferentes larguras paras as colunas como padrão
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(12);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(40);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(10);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(12);
            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(33);
            $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(33);
            $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(17);

            // Adicionamos um estilo de A1 até D1 
            $objPHPExcel->getActiveSheet()->getStyle('A1:H1')->applyFromArray(
                    array('fill' => array(
                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                            'color' => array('rgb' => 'E0EEEE')
                        ),
                    )
            );

            $i = 1;
            $teste = "";
            if ($meus_produtos) {
                foreach ($meus_produtos as $obj) {

                    if ($teste != $obj->REFERENCIA) {
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, ($i + 1), $obj->REFERENCIA);
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, ($i + 1), $obj->NOME);
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, ($i + 1), $obj->CATEGORIA);
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, ($i + 1), $obj->PESO);
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, ($i + 1), $obj->QUANTIDADE);
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, ($i + 1), $obj->PRECO);
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, ($i + 1), $obj->PRECO_UNITARIO);
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, ($i + 1), $obj->PRECO_COMPRA);
                        $teste = $obj->REFERENCIA;
                        $i++;
                    }
                }
            }

            // Podemos renomear o nome das planilha atual, lembrando que um único arquivo pode ter várias planilhas
            $objPHPExcel->getActiveSheet()->setTitle('Controle de Estoque');

            $explode = $model->getTimestamp();
            $explode = explode(":", $explode);

            $file_name = "Planilha de Estoque - " . $explode[0] . "h" . $explode[1] . " e " . $explode[1] . "s " . ".xls";

            // Cabeçalho do arquivo para ele baixar
            header("Content-Type: application/vnd.ms-excel");
            header("Content-Disposition: attachment;filename='{$file_name}'");
            header("Cache-Control: max-age=0");
            // Se for o IE9, isso talvez seja necessário
            header("Cache-Control: max-age=1");
            // Acessamos o 'Writer' para poder salvar o arquivo
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save('php://output');

            die();
        }
    }

    public function mais_vendidos_site_xls() {
        if ($this->permitir_acesso($_SESSION["EMAIL"], $_SESSION["SENHA"], "ADMINISTRADOR")) {

            $model = new Produtos_Model();

            $meus_produtos = $model->select_mais_vendidos_site();


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

            // Criamos as colunas
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue("A1", "Quantidade Vendida")
                    ->setCellValue("B1", "Referência")
                    ->setCellValue("C1", "Nome")
                    ->setCellValue("D1", "Categoria")
                    ->setCellValue("E1", "Peso/Kg.")
                    ->setCellValue("F1", "Preço Final do Produto por Unidade")
                    ->setCellValue("G1", "Preço Unitário de Compra do Produto")
                    ->setCellValue("H1", "Total da Compra");


            // Podemos configurar diferentes larguras paras as colunas como padrão
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(12);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(40);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(10);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(12);
            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(33);
            $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(33);
            $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(17);

            // Adicionamos um estilo de A1 até D1 
            $objPHPExcel->getActiveSheet()->getStyle('A1:H1')->applyFromArray(
                    array('fill' => array(
                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                            'color' => array('rgb' => 'E0EEEE')
                        ),
                    )
            );

            $i = 1;
            $teste = "";
            if ($meus_produtos) {
                foreach ($meus_produtos as $obj) {

                    if ($teste != $obj->REFERENCIA) {
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, ($i + 1), $obj->MAIS_VENDIDOS);
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, ($i + 1), $obj->REFERENCIA);
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, ($i + 1), $obj->NOME);
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, ($i + 1), $obj->CATEGORIA);
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, ($i + 1), $obj->PESO);
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, ($i + 1), $obj->PRECO);
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, ($i + 1), $obj->PRECO_UNITARIO);
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, ($i + 1), $obj->PRECO_COMPRA);
                        $teste = $obj->REFERENCIA;
                        $i++;
                    }
                }
            }

            // Podemos renomear o nome das planilha atual, lembrando que um único arquivo pode ter várias planilhas
            $objPHPExcel->getActiveSheet()->setTitle('Mais Vendido Site');

            $explode = $model->getTimestamp();
            $explode = explode(":", $explode);

            $file_name = "Planilha de Produtos Mais vendidos Site - " . $explode[0] . "h" . $explode[1] . " e " . $explode[1] . "s " . ".xls";

            // Cabeçalho do arquivo para ele baixar
            header("Content-Type: application/vnd.ms-excel");
            header("Content-Disposition: attachment;filename='{$file_name}'");
            header("Cache-Control: max-age=0");
            // Se for o IE9, isso talvez seja necessário
            header("Cache-Control: max-age=1");
            // Acessamos o 'Writer' para poder salvar o arquivo
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save('php://output');

            die();
        }
    }

    public function estoque_baixo() {
        if ($this->permitir_acesso($_SESSION["EMAIL"], $_SESSION["SENHA"], "ADMINISTRADOR")) {

            $model = new Produtos_Model();

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

                $meus_produtos = $model->select_produtos_all_search(utf8_decode($_POST["search"]));
                if (!$meus_produtos) {
                    $this->assign("ERRO_NAO_EXISTE_PRODUTOS", "ERRO_NAO_EXISTE_PRODUTOS");
                }
                $this->assign("search", $_POST["search"]);
                $this->assign("meus_produtos", $meus_produtos);
            } else {

                $meus_produtos = $model->select_produtos_all();
                if (!$meus_produtos) {
                    $this->assign("ERRO_NAO_EXISTE_PRODUTOS", "ERRO_NAO_EXISTE_PRODUTOS");
                }
                $this->assign("meus_produtos", $meus_produtos);
            }

            if ($model->num_de_qntdd_produtos() > 0) {
                $this->assign("falta_produtos_estoque", TRUE);
                $this->assign("num_produtos_que_faltam", $model->num_de_qntdd_produtos());
                $this->assign("referencia_nome_produtos", $model->get_referencia_nome_produtos());
            } else {
                $this->assign("falta_produtos_estoque", FALSE);
            }

            $this->assign("qtdd_aneis", $model->qnts_produtos_for_categoria("aneis"));
            $this->assign("qtdd_brincos", $model->qnts_produtos_for_categoria("brincos"));
            $this->assign("qtdd_colares", $model->qnts_produtos_for_categoria("colares"));
            $this->assign("qtdd_pulseiras", $model->qnts_produtos_for_categoria("pulseiras"));
            $this->assign("qtdd_conjuntos", $model->qnts_produtos_for_categoria("conjuntos"));
            $this->assign("total_produtos", (int) $model->qnts_produtos_for_categoria("aneis") + (int) $model->qnts_produtos_for_categoria("brincos") + (int) $model->qnts_produtos_for_categoria("colares") + (int) $model->qnts_produtos_for_categoria("pulseiras") + (int) $model->qnts_produtos_for_categoria("conjuntos"));

            $this->assign("language", LANGUAGE);
            $this->assign("email", $email);
            $this->assign("page", "estoque-baixo");
            $this->assign("dados", $_SESSION);
            $this->assign("title", TITLE . "Estoque Baixo");
            $this->view_tpl("admin/estoque_baixo");
        }
    }

    public function avise_me() {
        if ($this->permitir_acesso($_SESSION["EMAIL"], $_SESSION["SENHA"], "ADMINISTRADOR")) {

            $model = new Produtos_Model();

            $this->assign("avise_me", $model->get_avise_me());

//            $this->assign("ERRO_NAO_EXISTE_SOLICITACAO", "ERRO_NAO_EXISTE_SOLICITACAO");
            $this->assign("language", LANGUAGE);
            $this->assign("email", $email);
            $this->assign("page", "avise-me");
            $this->assign("dados", $_SESSION);
            $this->assign("title", TITLE . "Lista de Estoque");
            $this->view_tpl("admin/avise_me");
        }
    }

    public function update_nome() {
        if ($this->permitir_acesso($_SESSION["EMAIL"], $_SESSION["SENHA"], "ADMINISTRADOR")) {

            $model = new Produtos_Model();

            $key = $_POST["codproduto"];
            $dados["NOME"] = utf8_decode($_POST["nome"]);
            $model->update_produto($dados, $key);
            exit();
        }
    }

    public function enviar_aviso() {
        if ($this->permitir_acesso($_SESSION["EMAIL"], $_SESSION["SENHA"], "ADMINISTRADOR")) {

            $model = new Produtos_Model();

            $arr = $this->array_url();
            $codaviseme = $arr[0];
            $vars["email"] = base64_encode($arr[1]);

            $item = $model->get_avise_me_itens(null, $codaviseme);

            foreach ($item as $key => $value) {
                $vars[strtolower($key)] = $value;
            }

            $quebra_linha = "\n";
            $emailsender = "maria@mariadebarro.com.br";
            $nomeremetente = "Maria de Barro";
            $emaildesitnatario = $vars["email"];
            $assunto_texto = "Chegou o item {$item->REFERENCIA} que você solicitou!";
            $assunto = "=?UTF-8?B?" . base64_encode($assunto_texto) . "?=";

            $mensagemHTML = $this->view_email_print("emails/enviar_aviso_produto", $vars);

            $headers = "MIME-Version: 1.1{$quebra_linha}";
            $headers .= "Content-type: text/html; charset=UTF-8{$quebra_linha}";
            $headers .= "From: \"{$nomeremetente}\"<{$emailsender}>{$quebra_linha}";
            $headers .= "Return-Path: {$emailsender}{$quebra_linha}";
            $headers .= "Cc: {$comcopia}{$quebra_linha}";
            $headers .= "Reply-To: {$emaildesitnatario}{$quebra_linha}";
            $headers .= "X-Mailer: PHP/" . phpversion();

            mail($emaildesitnatario, $assunto, $mensagemHTML, $headers, "-f" . $emailsender);

            $model->del_avise_me($codaviseme);

            echo "<script>window.location='" . MEU_SITE . "/produtos/avise-me'</script>";
            exit();
        }
    }

//    public function status() {
//        if ($this->permitir_acesso($_SESSION["EMAIL"], $_SESSION["SENHA"], "ADMINISTRADOR")) {
//
//            $arr = $this->array_url();
//            $key = $arr[1];
//            $stt = $arr[0];
//
//            $model = new Produtos_Model();
//            $model->update_status($key, $stt);
//
//            echo "<script>window.location='" . MEU_SITE . "produtos/produtos_lista'</script>";
//            exit();
//        }
//    }
    public function status() {
        if ($this->permitir_acesso($_SESSION["EMAIL"], $_SESSION["SENHA"], "ADMINISTRADOR")) {

            $arr = $this->array_url();
            $key = $arr[1];
            $stt = $arr[0];

            $model = new Produtos_Model();
            $model->update_status($key, $stt);

            echo $stt;
            exit();
        }
    }

//    public function classificar_novo() {
//        if ($this->permitir_acesso($_SESSION["EMAIL"], $_SESSION["SENHA"], "ADMINISTRADOR")) {
//
//            $arr = $this->array_url();
//            $key = $arr[1];
//            $stt = $arr[0];
//
//            $model = new Produtos_Model();
//            $model->update_novo($key, $stt);
//
//            echo "<script>window.location='" . MEU_SITE . "produtos/produtos_lista'</script>";
//            exit();
//        }
//    }
    public function classificar_novo() {
        if ($this->permitir_acesso($_SESSION["EMAIL"], $_SESSION["SENHA"], "ADMINISTRADOR")) {

            $arr = $this->array_url();
            $key = $arr[1];
            $stt = $arr[0];

            $model = new Produtos_Model();
            $model->update_novo($key, $stt);

//            echo "<script>window.location='" . MEU_SITE . "produtos/produtos_lista'</script>";
            echo $stt;
            exit();
        }
    }

//    public function classificar_promocao() {
//        if ($this->permitir_acesso($_SESSION["EMAIL"], $_SESSION["SENHA"], "ADMINISTRADOR")) {
//
//            $arr = $this->array_url();
//            $key = $arr[1];
//            $stt = $arr[0];
//
//            $model = new Produtos_Model();
//
//            $model->update_promocao($key, $stt);
//
//            echo "<script>window.location='" . MEU_SITE . "produtos/produtos_lista'</script>";
//            exit();
//        }
//    }
    public function classificar_promocao() {
        if ($this->permitir_acesso($_SESSION["EMAIL"], $_SESSION["SENHA"], "ADMINISTRADOR")) {

            $arr = $this->array_url();
            $key = $arr[1];
            $stt = $arr[0];

            $model = new Produtos_Model();

            $model->update_promocao($key, $stt);

//            echo "<script>window.location='" . MEU_SITE . "produtos/produtos_lista'</script>";
            echo $stt;
            exit();
        }
    }

    public function classificar_mais_vendidos() {
        if ($this->permitir_acesso($_SESSION["EMAIL"], $_SESSION["SENHA"], "ADMINISTRADOR")) {

            $arr = $this->array_url();
            $key = $arr[1];
            $stt = $arr[0];

            $model = new Produtos_Model();

            $model->update_mais_vendido($key, $stt);

            echo "<script>window.location='" . MEU_SITE . "produtos/produtos_lista'</script>";
            exit();
        }
    }

//    public function delete() {
//        if ($this->permitir_acesso($_SESSION["EMAIL"], $_SESSION["SENHA"], "ADMINISTRADOR")) {
//
//            $arr = $this->array_url();
//            $key = $arr[0];
//
//            $model = new Produtos_Model();
//            $fotos = $model->get_fotos_all($key);
//
//            if (is_array($fotos)) {
//                foreach ($fotos as $foto) {
//                    $foto->CODFOTO = strtoupper($foto->CODFOTO);
//                    if (is_dir(getcwd() . $foto->RAIZ)) {
//                        if (file_exists(getcwd() . $foto->ORIGINAL)) {
//                            @unlink($foto->ORIGINAL);
//                        }
//                        if (file_exists(getcwd() . $foto->CROP770)) {
//                            @unlink($foto->CROP770);
//                        }
//                        if (file_exists(getcwd() . $foto->CROP550)) {
//                            @unlink(getcwd() . $foto->CROP550);
//                        }
//                        if (file_exists(getcwd() . $foto->CROP268)) {
//                            @unlink(getcwd() . $foto->CROP268);
//                        }
//                        @rmdir(getcwd() . $foto->RAIZ);
//                    }
//                    $model->del_foto($foto->CODFOTO);
//                    $model->del_rel_foto($foto->CODFOTO);
//                }
//            }
//
//            $model->del_produto($key);
//            echo "<script>window.location='" . MEU_SITE . "produtos/produtos_lista'</script>";
//        }
//    }

    public function delete() {
        if ($this->permitir_acesso($_SESSION["EMAIL"], $_SESSION["SENHA"], "ADMINISTRADOR")) {

            $arr = $this->array_url();
            $key = $arr[0];

            $model = new Produtos_Model();
            $fotos = $model->get_fotos_all($key);

            if (is_array($fotos)) {
                foreach ($fotos as $foto) {
                    $foto->CODFOTO = strtoupper($foto->CODFOTO);
                    if (is_dir(getcwd() . $foto->RAIZ)) {
                        if (file_exists(getcwd() . $foto->ORIGINAL)) {
                            @unlink($foto->ORIGINAL);
                        }
                        if (file_exists(getcwd() . $foto->CROP770)) {
                            @unlink($foto->CROP770);
                        }
                        if (file_exists(getcwd() . $foto->CROP550)) {
                            @unlink(getcwd() . $foto->CROP550);
                        }
                        if (file_exists(getcwd() . $foto->CROP268)) {
                            @unlink(getcwd() . $foto->CROP268);
                        }
                        @rmdir(getcwd() . $foto->RAIZ);
                    }
                    $model->del_foto($foto->CODFOTO);
                    $model->del_rel_foto($foto->CODFOTO);
                }
            }

            $model->del_produto($key);
//            echo "<script>window.location='" . MEU_SITE . "produtos/produtos_lista'</script>";
            echo "OK";
            exit();
        }
    }

    public function cadastrar() {
        if ($this->permitir_acesso($_SESSION["EMAIL"], $_SESSION["SENHA"], "ADMINISTRADOR")) {

            $erro = "";
            $sucesso = FALSE;
            $model = new Produtos_Model();

            if ($_POST) {

                foreach ($_POST as $n => $v) {

                    $this->assign($n, $v);
                }

                $preco = $_POST["preco"];
                $de = $_POST["de"];
                $nome = $_POST["nome"];
                $nome = preg_replace("/\s{2,}/", " ", $nome);

                $categoria = $_POST["categoria"];
                $linha_1 = $_POST["linha_1"];
                $linha_2 = $_POST["linha_2"];
                $linha_3 = $_POST["linha_3"];

                $ano = $_POST["ano"];
                $km = $_POST["quilometragem"];
                $cor = $_POST["cor"];
                $combustivel = $_POST["combustivel"];
                $portas = $_POST["portas"];
                $final_placa = $_POST["placa"];
                $carroceria = $_POST["carroceria"];
                $descricao = $_POST["descricao"];
                $especificacoes = $_POST["especificacoes"];
                $quantidade = $_POST["quantidade"];

                $referencia = strtoupper($_POST["referencia"]);
                $referencia = preg_replace("/\s{2,}/", " ", $referencia);
                $referencia = str_replace(" ", "-", $referencia);

                $peso = strtoupper($_POST["peso"]);

                if ($de == "") {
                    $erro = 'Valor "de" requerido!';
                } else if ($preco == "") {
                    $erro = "Preço requerido!";
                } else if ($nome == "") {
                    $erro = "Nome requerido!";
                } else if ((int) $preco > (int) $de) {
                    $erro = "Preço sujerido é maior que o desconto!";
                } else if ($model->existe_referencia($referencia)) {
                    $erro = "Referência já cadastrada!";
                } else {

                    $url_amigavel = $this->url_amigavel($nome);
                    $preco = str_replace(",", "", $preco);
                    $preco = str_replace(".", "", $preco);
                    $de = str_replace(",", "", $de);
                    $de = str_replace(".", "", $de);
                    $km = str_replace(",", "", $km);
                    $km = str_replace(".", "", $km);


                    if ($model->existe_url_amigavel($url_amigavel)) {
                        $check = true;
                        $i = 1;
                        while ($check) {
                            if ($model->existe_url_amigavel($url_amigavel . "-" . $i)) {
                                $check = true;
                            } else {
                                $url_amigavel = $url_amigavel . "-" . $i;
                                $check = false;
                            }
                            $i++;
                        }
                    }

                    $dados["CODPRODUTO"] = $this->getPrimarykey();
                    $dados["NOME"] = $nome;
                    $dados["URL_AMIGAVEL"] = $url_amigavel;
                    $dados["CATEGORIA"] = $categoria;
                    $dados["PRECO"] = $preco;
                    $dados["DE"] = $de;
                    $dados["LINHA_1"] = $linha_1;
                    $dados["LINHA_2"] = $linha_2;
                    $dados["LINHA_3"] = $linha_3;
                    $dados["DESTAQUE"] = 0;
                    $dados["STATUS"] = 1;
                    $dados["ORDEM"] = ($model->qnts_produtos() + 1);
                    $dados["ANO"] = $ano;
                    $dados["KM"] = $km;
                    $dados["COR"] = $cor;
                    $dados["COMBUSTIVEL"] = $combustivel;
                    $dados["REFERENCIA"] = $referencia;
                    $dados["PORTAS"] = $portas;
                    $dados["PESO"] = $peso;
                    $dados["FINAL_PLACA"] = $final_placa;
                    $dados["CARROCERIA"] = $carroceria;
                    $dados["DESCRICAO"] = trim(stripslashes($descricao));
                    $dados["ESPECIFICACOES"] = trim(stripslashes($especificacoes));
                    $dados["QUANTIDADE"] = ( $quantidade == null || $quantidade == "") ? $quantidade = 0 : $quantidade;

                    if ($model->insert_produto($dados)) {
                        echo "<script>window.location='" . MEU_SITE . "produtos/produtos_lista'</script>";
                    }

                    exit();
                }
            }

            $this->assign("sucesso", $sucesso);
            $this->assign("erro", $erro);
            $this->assign("language", LANGUAGE);
            $this->assign("page", "produtos_lista");
            $this->assign("dados", $_SESSION);
            $this->assign("title", TITLE . "Cadastro de Produtos");
            $this->view_tpl("admin/cadastrar");
        }
    }

    public function editar_get_dados() {
        if ($this->permitir_acesso($_SESSION["EMAIL"], $_SESSION["SENHA"], "ADMINISTRADOR")) {

            $erro = "";
            $sucesso = FALSE;
            $model = new Produtos_Model();

            $produto = $model->get_produto_with_codproduto($_POST["codproduto"]);

            echo "<form id='pFromSubmit_{$produto->CODPRODUTO}' class='navbar-form navbar-left' style='width: 100%' action='/pt/produtos/editar-textarea/{$produto->URL_AMIGAVEL}' method='post'>" .
            "<h2 style='width: 550px'><center>{$produto->NOME}</center></h2>" .
            "<div class='panel panel-default'>" .
            "<div class='panel-heading'><center>{$produto->REFERENCIA}</center></div>" .
            "<table class='table' style='width: 550px'>" .
            "<thead>" .
            "<tr>" .
            "<th>Descrição Rápida</th>" .
            "</tr>" .
            "</thead>" .
            "<tbody>" .
            "<tr>" .
            "<td><textarea class='form-control' rows='10' style='min-width: 100%' id='descricao' name='descricao'>{$produto->DESCRICAO}</textarea></td>" .
            "</tr>" .
            "</tbody>" .
            "<thead>" .
            "<tr>" .
            "<th>Descrição Rápida</th>" .
            "</tr>" .
            "</thead>" .
            "<tbody>" .
            "<tr>" .
            "<td><textarea class='form-control' rows='10' style='min-width: 100%' id='especificacoes' name='especificacoes'>{$produto->ESPECIFICACOES}</textarea></td>" .
            "</tr>" .
            "</tbody>" .
            "<tbody>" .
            "<tr>" .
            "<td align='right'>" .
            "<div class='input-group input-group-lg'>" .
            "<div class='btn btn-primary btn-lg btn-primary-maria' onclick=\"javascript:pTextAreaUpdateSubmit('pFromSubmit_{$produto->CODPRODUTO}','{$produto->CODPRODUTO}','/pt/produtos/editar-textarea/{$produto->CODPRODUTO}')\">Atualizar</div>" .
            "</div>" .
            "</td>" .
            "</tr>" .
            "</tbody>" .
            "</table>" .
            "</div>" .
            "</form>";

            exit();
        }
    }

    public function editar() {
        if ($this->permitir_acesso($_SESSION["EMAIL"], $_SESSION["SENHA"], "ADMINISTRADOR")) {

            $erro = "";
            $sucesso = FALSE;
            $model = new Produtos_Model();

            $arr = $this->array_url();
            $key = $arr[0];

            $model = new Produtos_Model();
            $produto = $model->get_produto($key);

            $foto_destaque = $model->get_foto_destaque($key);
            $this->assign("foto_destaque", $foto_destaque->IMG);

            if ($produto) {

                $produto->DE = $this->formataReais($produto->DE);
                $produto->PRECO = $this->formataReais($produto->PRECO);
                $produto->NOME = utf8_encode($produto->NOME);
                $produto->LINHA_1 = utf8_encode($produto->LINHA_1);
                $produto->LINHA_2 = utf8_encode($produto->LINHA_2);
                $produto->LINHA_3 = utf8_encode($produto->LINHA_3);
                $produto->COR = utf8_encode($produto->COR);
                $produto->PESO = utf8_encode($produto->PESO);
                $produto->COMBUSTIVEL = utf8_encode($produto->COMBUSTIVEL);
                $produto->FINAL_PLACA = utf8_encode($produto->FINAL_PLACA);
                $produto->ESPECIFICACOES = utf8_encode($produto->ESPECIFICACOES);
                $produto->REFERENCIA = utf8_encode($produto->REFERENCIA);
                $produto->DESCRICAO = utf8_encode($produto->DESCRICAO);
                $produto->KM = $this->formataReais(utf8_encode($produto->KM));

                $this->assign("produto", $produto);
                $this->assign("url_amigavel", $key);
            }

            if ($_POST) {

                $preco = $_POST["preco"];
                $de = $_POST["de"];
                $nome = $_POST["nome"];
                $nome = preg_replace("/\s{2,}/", " ", $nome);

                $categoria = $_POST["categoria"];
                $linha_1 = $_POST["linha_1"];
                $linha_2 = $_POST["linha_2"];
                $linha_3 = $_POST["linha_3"];

                $ano = $_POST["ano"];
                $km = $_POST["quilometragem"];
                $cor = $_POST["cor"];
                $combustivel = $_POST["combustivel"];
                $portas = $_POST["portas"];
                $final_placa = $_POST["placa"];
                $carroceria = $_POST["carroceria"];
                $descricao = $_POST["descricao"];
                $especificacoes = $_POST["especificacoes"];
                $quantidade = $_POST["quantidade"];

                $referencia = strtoupper($_POST["referencia"]);
                $referencia = preg_replace("/\s{2,}/", " ", $referencia);
                $referencia = str_replace(" ", "-", $referencia);

                $peso = strtoupper($_POST["peso"]);

                if ($de == "") {
                    $erro = 'Valor "de" requerido!';
                } else if ($preco == "") {
                    $erro = "Preço requerido!";
                } else if ($nome == "") {
                    $erro = "Nome requerido!";
                } else if ((int) $preco > (int) $de) {
                    $erro = "Preço sujerido é maior que o desconto!";
                } else if ($model->existe_referencia($referencia) > 1) {
                    $erro = "Referência já cadastrada!";
                } else {

                    $url_amigavel = $this->url_amigavel($nome);
                    $preco = str_replace(",", "", $preco);
                    $preco = str_replace(".", "", $preco);
                    $de = str_replace(",", "", $de);
                    $de = str_replace(".", "", $de);
                    $km = str_replace(",", "", $km);
                    $km = str_replace(".", "", $km);

                    if ($model->existe_url_amigavel($url_amigavel)) {
                        $check = true;
                        $i = 1;
                        while ($check) {
                            if ($model->existe_url_amigavel($url_amigavel . "-" . $i)) {
                                $check = true;
                            } else {
                                $url_amigavel = $url_amigavel . "-" . $i;
                                $check = false;
                            }
                            $i++;
                        }
                    }

                    $dados["NOME"] = utf8_decode($nome);
                    $dados["URL_AMIGAVEL"] = utf8_decode($url_amigavel);
                    $dados["CATEGORIA"] = utf8_decode($categoria);
                    $dados["PRECO"] = utf8_decode($preco);
                    $dados["DE"] = utf8_decode($de);
                    $dados["REFERENCIA"] = utf8_decode($referencia);
                    $dados["PESO"] = utf8_decode($peso);
                    $dados["LINHA_1"] = utf8_decode($linha_1);
                    $dados["LINHA_2"] = utf8_decode($linha_2);
                    $dados["LINHA_3"] = utf8_decode($linha_3);
                    $dados["ANO"] = utf8_decode($ano);
                    $dados["KM"] = utf8_decode($km);
                    $dados["COR"] = utf8_decode($cor);
                    $dados["COMBUSTIVEL"] = utf8_decode($combustivel);
                    $dados["PORTAS"] = utf8_decode($portas);
                    $dados["FINAL_PLACA"] = utf8_decode($final_placa);
                    $dados["CARROCERIA"] = utf8_decode($carroceria);
                    $dados["DESCRICAO"] = trim(stripslashes($descricao));
                    $dados["ESPECIFICACOES"] = trim(stripslashes($especificacoes));
                    $dados["QUANTIDADE"] = ( $quantidade == null || $quantidade == "") ? $quantidade = 0 : $quantidade;

                    if ($model->update_produto($dados, $produto->CODPRODUTO)) {
                        echo "<script>window.location='" . MEU_SITE . "produtos/produtos_lista'</script>";
                        exit();
                    }
                }
            }

            $this->assign("erro", $erro);
            $this->assign("sucesso", $sucesso);
            $this->assign("language", LANGUAGE);
            $this->assign("email", $email);
            $this->assign("page", "produtos_lista");
            $this->assign("dados", $_SESSION);
            $this->assign("title", TITLE . "Editar Produto");
            $this->view_tpl("admin/editar");
        }
    }

    public function editar_textarea() {
        if ($this->permitir_acesso($_SESSION["EMAIL"], $_SESSION["SENHA"], "ADMINISTRADOR")) {

            $erro = "";
            $sucesso = FALSE;
            $model = new Produtos_Model();

            $arr = $this->array_url();
            $key = $arr[0];

            echo $descricao = $_POST["descricao"];
            $especificacoes = $_POST["especificacoes"];

            $dados["DESCRICAO"] = trim(stripslashes($descricao));
            $dados["ESPECIFICACOES"] = trim(stripslashes($especificacoes));

            $model->update_produto($dados, $key);
            exit();



            if ($_POST) {

                $preco = $_POST["preco"];
                $de = $_POST["de"];
                $nome = $_POST["nome"];
                $nome = preg_replace("/\s{2,}/", " ", $nome);

                $categoria = $_POST["categoria"];
                $linha_1 = $_POST["linha_1"];
                $linha_2 = $_POST["linha_2"];
                $linha_3 = $_POST["linha_3"];

                $ano = $_POST["ano"];
                $km = $_POST["quilometragem"];
                $cor = $_POST["cor"];
                $combustivel = $_POST["combustivel"];
                $portas = $_POST["portas"];
                $final_placa = $_POST["placa"];
                $carroceria = $_POST["carroceria"];
                $descricao = $_POST["descricao"];
                $especificacoes = $_POST["especificacoes"];
                $quantidade = $_POST["quantidade"];

                $referencia = strtoupper($_POST["referencia"]);
                $referencia = preg_replace("/\s{2,}/", " ", $referencia);
                $referencia = str_replace(" ", "-", $referencia);

                $peso = strtoupper($_POST["peso"]);

                if ($de == "") {
                    $erro = 'Valor "de" requerido!';
                } else if ($preco == "") {
                    $erro = "Preço requerido!";
                } else if ($nome == "") {
                    $erro = "Nome requerido!";
                } else if ((int) $preco > (int) $de) {
                    $erro = "Preço sujerido é maior que o desconto!";
                } else if ($model->existe_referencia($referencia) > 1) {
                    $erro = "Referência já cadastrada!";
                } else {

                    $url_amigavel = $this->url_amigavel($nome);
                    $preco = str_replace(",", "", $preco);
                    $preco = str_replace(".", "", $preco);
                    $de = str_replace(",", "", $de);
                    $de = str_replace(".", "", $de);
                    $km = str_replace(",", "", $km);
                    $km = str_replace(".", "", $km);

                    if ($model->existe_url_amigavel($url_amigavel)) {
                        $check = true;
                        $i = 1;
                        while ($check) {
                            if ($model->existe_url_amigavel($url_amigavel . "-" . $i)) {
                                $check = true;
                            } else {
                                $url_amigavel = $url_amigavel . "-" . $i;
                                $check = false;
                            }
                            $i++;
                        }
                    }

                    $dados["NOME"] = utf8_decode($nome);
                    $dados["URL_AMIGAVEL"] = utf8_decode($url_amigavel);
                    $dados["CATEGORIA"] = utf8_decode($categoria);
                    $dados["PRECO"] = utf8_decode($preco);
                    $dados["DE"] = utf8_decode($de);
                    $dados["REFERENCIA"] = utf8_decode($referencia);
                    $dados["PESO"] = utf8_decode($peso);
                    $dados["LINHA_1"] = utf8_decode($linha_1);
                    $dados["LINHA_2"] = utf8_decode($linha_2);
                    $dados["LINHA_3"] = utf8_decode($linha_3);
                    $dados["ANO"] = utf8_decode($ano);
                    $dados["KM"] = utf8_decode($km);
                    $dados["COR"] = utf8_decode($cor);
                    $dados["COMBUSTIVEL"] = utf8_decode($combustivel);
                    $dados["PORTAS"] = utf8_decode($portas);
                    $dados["FINAL_PLACA"] = utf8_decode($final_placa);
                    $dados["CARROCERIA"] = utf8_decode($carroceria);
                    $dados["DESCRICAO"] = trim(stripslashes($descricao));
                    $dados["ESPECIFICACOES"] = trim(stripslashes($especificacoes));
                    $dados["QUANTIDADE"] = ( $quantidade == null || $quantidade == "") ? $quantidade = 0 : $quantidade;

                    if ($model->update_produto($dados, $produto->CODPRODUTO)) {
                        echo "<script>window.location='" . MEU_SITE . "produtos/produtos_lista'</script>";
                        exit();
                    }
                }
            }

            $this->assign("erro", $erro);
            $this->assign("sucesso", $sucesso);
            $this->assign("language", LANGUAGE);
            $this->assign("email", $email);
            $this->assign("page", "produtos_lista");
            $this->assign("dados", $_SESSION);
            $this->assign("title", TITLE . "Editar Produto");
            $this->view_tpl("admin/editar");
        }
    }

    public function fotos() {
        if ($this->permitir_acesso($_SESSION["EMAIL"], $_SESSION["SENHA"], "ADMINISTRADOR")) {

            $erro = "";
            $sucesso = "FALSE";

            $arr = $this->array_url();
            $key = $arr[0];

            $model = new Produtos_Model();
            $produto = $model->get_produto($key);

            if ($produto) {

                $produto->PRECO = $this->formataReais($produto->PRECO);
                $produto->NOME = utf8_decode($produto->NOME);
                $produto->LINHA_1 = utf8_decode($produto->LINHA_1);
                $produto->LINHA_2 = utf8_decode($produto->LINHA_2);
                $produto->LINHA_3 = utf8_decode($produto->LINHA_3);

                $this->assign("produto", $produto);
                $this->assign("url_amigavel", $key);
            }

            $fotos = $model->get_fotos_all($key);

            if ($fotos) {
                $this->assign("fotos", $fotos);
            }

            $foto_destaque = $model->get_foto_destaque($key);
            $this->assign("foto_destaque", $foto_destaque->IMG);

            $this->assign("url_amigavel", $key);
            $this->assign("language", LANGUAGE);
            $this->assign("email", $email);
            $this->assign("page", "veiculos_lista");
            $this->assign("dados", $_SESSION);
            $this->assign("title", TITLE . "Lista de fotos");
            $this->view_tpl("admin/fotos");
        }
    }

    public function delete_foto() {
        if ($this->permitir_acesso($_SESSION["EMAIL"], $_SESSION["SENHA"], "ADMINISTRADOR")) {

            $arr = $this->array_url();
            $url_amigavel = $arr[1];
            $codfoto = $arr[3];

//            $codfoto = strtoupper($this->getParameters("codfoto"));
//            $url_amigavel = $this->getParameters("url");
//            
            $model = new Produtos_Model();
            $foto = $model->get_foto($codfoto);

            if ($foto) {

                $rootdir = getcwd();
                $_filename1 = $rootdir . $foto->ORIGINAL;
                $_filename2 = $rootdir . $foto->CROP;
                $_diretorio = $rootdir . $foto->RAIZ;

                if (file_exists($_filename1)) {
                    @unlink($_filename1);
                }

                if (file_exists($_filename2)) {
                    @unlink($_filename2);
                }

                if (is_dir($_diretorio)) {
                    @rmdir($dir);
                }

                $model->del_rel_foto($codfoto);
                $model->del_foto($codfoto);
                echo "<script>window.location='" . MEU_SITE . "produtos/fotos/" . $url_amigavel . "'</script>";
            }
        }
    }

    public function foto_status() {
        if ($this->permitir_acesso($_SESSION["EMAIL"], $_SESSION["SENHA"], "ADMINISTRADOR")) {

            $arr = $this->array_url();

            $stt = $arr[1];
            $url_amigavel = $arr[3];
            $codfoto = $arr[5];

            $model = new Produtos_Model();
            $model->update_status_foto($codfoto, $stt);

            echo "<script>window.location='" . MEU_SITE . "produtos/fotos/" . $url_amigavel . "'</script>";
        }
    }

    public function foto_destaque() {
        if ($this->permitir_acesso($_SESSION["EMAIL"], $_SESSION["SENHA"], "ADMINISTRADOR")) {

            $arr = $this->array_url();
            $url_amigavel = $arr[1];
            $codfoto = $arr[3];

            $model = new Produtos_Model();
            $model->update_destaque_foto($codfoto, $url_amigavel);

            echo "<script>window.location='" . MEU_SITE . "produtos/fotos/" . $url_amigavel . "'</script>";
        }
    }

//    public function destaque() {
//        if ($this->permitir_acesso($_SESSION["EMAIL"], $_SESSION["SENHA"], "ADMINISTRADOR")) {
//
//            $arr = $this->array_url();
//            $indice = $arr[0];
//            $url_amigavel = $arr[1];
//
//            $model = new Produtos_Model();
//
//            ((int) $indice ) ? $dados["DESTAQUE"] = 1 : $dados["DESTAQUE"] = 0;
//            if ($model->update_destaque_produto($dados, $url_amigavel)) {
//                echo "<script>window.location='" . MEU_SITE . "produtos/produtos_lista/" . $url_amigavel . "'</script>";
//            }
//            exit();
//        }
//    }
//    
    public function destaque() {
        if ($this->permitir_acesso($_SESSION["EMAIL"], $_SESSION["SENHA"], "ADMINISTRADOR")) {

            $arr = $this->array_url();
            $indice = $arr[0];
            $url_amigavel = $arr[1];

            $model = new Produtos_Model();

            ((int) $indice ) ? $dados["DESTAQUE"] = 1 : $dados["DESTAQUE"] = 0;
            if ($model->update_destaque_produto($dados, $url_amigavel)) {
                // echo "<script>window.location='" . MEU_SITE . "produtos/produtos_lista/" . $url_amigavel . "'</script>";
            }
            echo $dados["DESTAQUE"];
            exit();
        }
    }

    public function checkout_bkp20141002() {

        $model = new Produtos_Model();

        $this->assign("language", LANGUAGE);
        $this->assign("dados", $_SESSION);

        $url_checkout = "CLIENT_HIDDEN=" . CLIENT_HIDDEN . "&CODPRODUTO=";

        $this->assign("url_checkout", $url_checkout);
        $this->assign("cep_remetente", CEP_REMETENTE);
        $this->assign("title", TITLE . "Checkout | Resumo");
        $this->assign("page", "resumo");
        $this->view_tpl("checkout");
    }

    public function cielo() {

        if ($this->permitir_acesso_comprador()) {


            foreach ($_POST as $name => $value) {
                $_POST[$name] = trim($value);
            }

            $client_hidden = $_POST['CLIENT_HIDDEN'];
            $codcadastro = $_POST['CODCADASTRO'];
            $codendereco = $_POST['CODENDERECO'];
            $_POST['CARTAONUMERO'] = str_replace(" ", "", $_POST['CARTAONUMERO']);

            $id = rand(1, 1000000);
            $valor_total = $_POST['PRODUTO'];

            ####################################################
            #A Cielo tem problemas com arredondamento de numeros            
            ####################################################

            /*
              $arredondar = $this->formataReais($valor_total);
              $arredondar = explode(",", $arredondar);

              if ($arredondar[1] == "00") {
              $valor_total = str_replace(",", "", $valor_total);
              } else {
              $valor_total = $arredondar[0] . "00";
              }
             */

            $valor_total = str_replace(".", "", $valor_total);
            $valor_total = str_replace(",", "", $valor_total);

            //comentar assim que a cielo homologar
            #$valor_total = "100";
            ####################################################

            $bandeira = $_POST['CODIGOBANDEIRA'];
            $agora = date('Y-m-d\TH:i:s');
            $cartao_nome_titular = trim($_POST["NOMETITULO"]);
            $numero_cartao = $_POST["CARTAONUMERO"];
            $cartao_codigo = $_POST["CARTAOCODIGOSEGURANCA"];

            $indicador = ($cartao_codigo != '') ? '1' : '0';
            $data_vencimento = $_POST["CARTAOVALIDADE"];

            $fp = explode("/", trim($data_vencimento));
            $data_vencimento = trim($fp[1] . $fp[0]);
            $numero_cartao = str_replace(" ", "", $numero_cartao);

            $qtd_parcelas = $_POST["FORMAPAGAMENTO"];

            if ($qtd_parcelas == "A") {
                $produto = "A";
            } else {
                $produto = ($qtd_parcelas == '1') ? '1' : '2';
            }

            ( $qtd_parcelas == "A" || $qtd_parcelas == 1 ) ? $qtd_parcelas = 1 : $qtd_parcelas;


            $autorizar = $_POST["INDICADORAUTORIZACAO"];
            $captura = $_POST["CAPTURARAUTOMATICAMENTE"];

            $cielo_numero = CIELO_N;
            $chave_cielo = CIELO_KEY;
            $url = CIELO_URL;

            $string = <<<XML
<?xml version='1.0' encoding='ISO-8859-1'?>
<requisicao-transacao id='{$id}' versao='1.2.1'>
	<dados-ec>
		<numero>{$cielo_numero}</numero>
		<chave>{$chave_cielo}</chave>
	</dados-ec>
	<dados-portador>
		<numero>{$numero_cartao}</numero>
		<validade>{$data_vencimento}</validade>
		<indicador>{$indicador}</indicador>
		<codigo-seguranca>{$cartao_codigo}</codigo-seguranca>
	</dados-portador>
	<dados-pedido>
		<numero>{$id}</numero>
		<valor>{$valor_total}</valor>
		<moeda>986</moeda>
		<data-hora>{$agora}</data-hora>
		<descricao>MARIA DE BARRO</descricao>
		<idioma>PT</idioma>
	</dados-pedido>
	<forma-pagamento>
		<bandeira>{$bandeira}</bandeira>
		<produto>{$produto}</produto>
		<parcelas>{$qtd_parcelas}</parcelas>
	</forma-pagamento>
	<autorizar>{$autorizar}</autorizar>
	<capturar>{$captura}</capturar>
</requisicao-transacao>
XML;

            $ch = curl_init();
            flush();
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, 'mensagem=' . $string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_FAILONERROR, true);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
            curl_setopt($ch, CURLOPT_TIMEOUT, 40);
            $string = curl_exec($ch);
            curl_close($ch);
            $xml = simplexml_load_string($string);


            $erro = "";
            if ($xml->tid) {

                if ($xml->captura->codigo == '6' AND $xml->autorizacao->codigo == '6') {
                    //$erro .= 'TID da transação: '.$xml->tid.'<br/>';  

                    $_SERVER["TID"] = $xml->tid;
                    $erro .= 'TRANSACAO_AUTORIZADA';
                } else {
                    //$erro .= utf8_encode(getLabel("CARTAO_05", $_SESSION["LANGUAGE"])).':<br/>'.$xml->autorizacao->mensagem.'.';
                    $erro .= 'Transação não autorizada: <br/>' . $xml->autorizacao->mensagem . '.';
                    //$erro .= $xml->autorizacao->mensagem.'.';
                }
            } else {
                //$erro .= utf8_encode(getLabel("CARTAO_05", $_SESSION["LANGUAGE"])).':<br/>'.$xml->mensagem;
                //$erro .= 'Requisição inválida: <br/>' . $xml->mensagem . '.';
                $erro .= $xml->mensagem . '.';
                //$erro .= "Por favor, verifique se seus dados então preenchidos corretamente!";
            }
        }
    }

    public function boleto() {

        if ($this->permitir_acesso_comprador()) {

            $arr = $this->array_url();
            $codpedido = strtoupper($arr[1]);
            $codboleto = $this->getPrimarykey();

            $model = new Pedido_Model();
            $model2 = new Cadastro_Model();

            $compra = $model->get_pedido($codpedido, $_SESSION["CODCADASTRO"]);
            $pessoa = $model2->get_cadastro_with_codcadastro($_SESSION["CODCADASTRO"]);
            $endereco = $model->get_endereco_entrega_uniq($codpedido);

//            print_r($pessoa);
//            exit();
//            $compra->CODPEDIDO] => 07adb31f2fd3903dd4642170c6f2cb0c 
//            $compra->CODCADASTRO] => f45e361f7d774ab0b4cbcacc2c69d8bd 
//            $compra->N_PEDIDO] => 0000000020 
//            $compra->DTA] => 2014-10-10 12:39:31 
//            $compra->FORMA_ENVIO] => PAC 
//            $compra->FORMA_PGTO] => boleto 
//            $compra->TAXA_ENTREGA] => 
//            $compra->TOTAL_GERAL] => 190,00 
//            $compra->DESCONTO] => 
//            $compra->CUPOM] => 
//            $compra->IMPOSTOS] => 16,52 
//            $compra->TOTAL_PARCIAL] => 173,48 
//            $compra->FRETE_GRATIS] => 1 
//            $compra->EMBALAR_PRESENTE] => 0 
//            $compra->STATUS] => 0 
//            $compra->TOTAL_MOIP] => 19000 
//            $compra->TOTAL_PAYPAL] => 190.00 )
//            $endereco->CODENDERECO] => 6F9CD23A6579FD4E64078981F7565272 
//                    $endereco->DTA] => 2014-10-10 12:39:31 
//                $endereco->CEP] => 72450-050 
//                    $endereco->LOGRADOURO] => Quadra 5 
//                    $endereco->NUMERO] => 104 
//                    $endereco->COMPLEMENTO] => 
//                    $endereco->UF] => DF 
//                    $endereco->CIDADE] => BrasÃ­lia 
//                    $endereco->BAIRRO] => Setor Leste (Gama) 
//                    $endereco->STATUS] => 1 ) )
//            $pessoa->CODCADASTRO] => F45E361F7D774AB0B4CBCACC2C69D8BD 
//            $pessoa->DTA] => 2014-09-16 10:43:26 
//            $pessoa->NOME] => Rogerio de Almeida Pontes 
//            $pessoa->EMAIL] => rogerio@designlab.com.br 
//            $pessoa->NASCIMENTO] => 1977-10-30 
//            $pessoa->SEXO] => M 
//            $pessoa->DDD] => 61 
//            $pessoa->TELEFONE] => 39678750 
//            $pessoa->RAMAL] => 
//            $pessoa->PASSWORD] => E10ADC3949BA59ABBE56E057F20F883E 
//            $pessoa->LEMBRETE] => apenas teste 
//            $pessoa->STATUS] => 1 )

            $dias_de_prazo_para_pagamento = 3;
            $taxa_boleto = 0.00;
            $data_venc = date("d/m/Y", time() + ($dias_de_prazo_para_pagamento * 86400));  // Prazo de X dias OU informe data: "13/04/2006";
            $valor_cobrado = $compra->TOTAL_GERAL; // Valor - REGRA: Sem pontos na milhar e tanto faz com "." ou "," ou com 1 ou 2 ou sem casa decimal
            $valor_cobrado = str_replace(",", ".", $valor_cobrado);
            // $valor_cobrado = 1;
            $valor_boleto = number_format($valor_cobrado + $taxa_boleto, 2, ',', '');

            // Composição Nosso Numero - CEF SIGCB
            $dadosboleto["nosso_numero1"] = "000"; // tamanho 3
            $dadosboleto["nosso_numero_const1"] = "2"; //constanto 1 , 1=registrada , 2=sem registro
            $dadosboleto["nosso_numero2"] = "000"; // tamanho 3
            $dadosboleto["nosso_numero_const2"] = "4"; //constanto 2 , 4=emitido pelo proprio cliente
            // $dadosboleto["nosso_numero3"] = "000000019"; // tamanho 9
            $dadosboleto["nosso_numero3"] = (float) $compra->N_PEDIDO; // tamanho 9

            $dadosboleto["numero_documento"] = $compra->N_PEDIDO; // Num do pedido ou do documento
            $dadosboleto["data_vencimento"] = $data_venc; // Data de Vencimento do Boleto - REGRA: Formato DD/MM/AAAA
            $dadosboleto["data_documento"] = date("d/m/Y"); // Data de emissão do Boleto
            $dadosboleto["data_processamento"] = date("d/m/Y"); // Data de processamento do boleto (opcional)
            $dadosboleto["valor_boleto"] = $valor_boleto;  // Valor do Boleto - REGRA: Com vírgula e sempre com duas casas depois da virgula
            // DADOS DO SEU CLIENTE
            $dadosboleto["sacado"] = "{$pessoa->NOME} - {$pessoa->EMAIL}";
            if ($endereco->COMPLEMENTO != '')
                $complemento = $endereco->COMPLEMENTO;
            $dadosboleto["endereco1"] = "{$endereco->LOGRADOURO}, {$endereco->NUMERO} {$complemento} - {$endereco->BAIRRO}";
            $dadosboleto["endereco2"] = "{$endereco->CIDADE} - {$endereco->UF} -  CEP: {$endereco->CEP}";

            // INFORMACOES PARA O CLIENTE
            $dadosboleto["demonstrativo1"] = "Pagamento de Compra E-Commerce";
            $dadosboleto["demonstrativo2"] = "Taxa bancária - R$ " . number_format($taxa_boleto, 2, ',', '');
            $dadosboleto["demonstrativo3"] = "Maria de Barro - https://www.mariadebarro.com.br";

            // INSTRUÇÕES PARA O CAIXA
            $dadosboleto["instrucoes1"] = "- Sr. Caixa, cobrar multa de 2% após o vencimento;";
            $dadosboleto["instrucoes2"] = "- Receber até 10 dias após o vencimento;";
            $dadosboleto["instrucoes3"] = "- Em caso de dúvidas entre em contato conosco: maria@mariadebarro.com.br;";
            $dadosboleto["instrucoes4"] = "- Pagável preferêncialmente nas Casas Lotéricas, Internet Bank ou Agências Caixa;";

            // DADOS OPCIONAIS DE ACORDO COM O BANCO OU CLIENTE
            $dadosboleto["quantidade"] = "";
            $dadosboleto["valor_unitario"] = "";
            $dadosboleto["aceite"] = "";
            $dadosboleto["especie"] = "R$";
            $dadosboleto["especie_doc"] = "";


            // ---------------------- DADOS FIXOS DE CONFIGURAÇÃO DO SEU BOLETO --------------- //
            // DADOS DA SUA CONTA - CEF
            $dadosboleto["agencia"] = "4749"; // Num da agencia, sem digito
            $dadosboleto["conta"] = "269";  // Num da conta, sem digito
            $dadosboleto["conta_dv"] = "9";  // Digito do Num da conta
            // DADOS PERSONALIZADOS - CEF
            $dadosboleto["conta_cedente"] = "542845"; // Código Cedente do Cliente, com 6 digitos (Somente Números)
            $dadosboleto["carteira"] = "SR";  // Código da Carteira: pode ser SR (Sem Registro) ou CR (Com Registro) - (Confirmar com gerente qual usar)
            // SEUS DADOS
            $dadosboleto["identificacao"] = "www.mariadebarro.com.br";
            $dadosboleto["cpf_cnpj"] = "18.611.490/0001-28";
            $dadosboleto["endereco"] = "Estrada dos Bandeirantes, 7000";
            $dadosboleto["cidade_uf"] = "Rio de Janeiro / RJ";
            $dadosboleto["cedente"] = "Maria de Barro Acessórios Femininos LTDA";

            // NÃO ALTERAR!
            include("boletophp-master/include/funcoes_cef_sigcb.php");

            if (sizeof($grava_boleto) > 0) {
                $model->insert_boletos($grava_boleto);
                $dnm["NOSSO_NUMERO"] = $dadosboleto["nosso_numero"];
                $model->update_nosso_numero($dnm, $codpedido);
            }

            include("boletophp-master/include/layout_cef.php");
        }
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

                $dados['CODENDERECO'] = $this->getPrimarykey();
                $dados['CEP'] = utf8_decode($_POST["cep"]);
                $dados['LOGRADOURO'] = utf8_decode($_POST["logradouro"]);
                $dados['NUMERO'] = utf8_decode($_POST["numero"]);
                $dados['COMPLEMENTO'] = utf8_decode($_POST["complemento"]);
                $dados['BAIRRO'] = utf8_decode($_POST["bairro"]);
                $dados['CIDADE'] = utf8_decode($_POST["cidade"]);
                $dados['UF'] = utf8_decode($_POST["estado"]);

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
            $this->assign("title", TITLE . "Cadastro de Endereços");
            $this->assign("page", "endereco");
            $this->view_tpl("endereco");
        }
    }
    
    public function endereco_conta() {

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

                $dados['CODENDERECO'] = $this->getPrimarykey();
                $dados['CEP'] = utf8_decode($_POST["cep"]);
                $dados['LOGRADOURO'] = utf8_decode($_POST["logradouro"]);
                $dados['NUMERO'] = utf8_decode($_POST["numero"]);
                $dados['COMPLEMENTO'] = utf8_decode($_POST["complemento"]);
                $dados['BAIRRO'] = utf8_decode($_POST["bairro"]);
                $dados['CIDADE'] = utf8_decode($_POST["cidade"]);
                $dados['UF'] = utf8_decode($_POST["estado"]);

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
            $this->assign("title", TITLE . "Cadastro de Endereços");
            $this->assign("page", "endereco");
            $this->view_tpl("endereco_conta");
        }
    }

    public function forma_pgto() {

        if ($this->permitir_acesso_comprador()) {

            $model = new Cadastro_Model();

            $this->assign("language", LANGUAGE);
            $this->assign("dados", $_SESSION);

            $url_checkout = "CLIENT_HIDDEN=" . CLIENT_HIDDEN . "&CODPRODUTO=";

            $this->assign("url_checkout", $url_checkout);
            $this->assign("cep_remetente", CEP_REMETENTE);
            $this->assign("title", TITLE . "Forma de Pagamento");
            $this->assign("page", "pagamento");
            $this->assign("CLIENT_HIDDEN", CLIENT_HIDDEN);
            $this->assign("CODCADASTRO", $_SESSION['CODCADASTRO']);

            $this->assign("endereco_list", $model->get_enderecos($_SESSION['CODCADASTRO']));
            $this->view_tpl("forma_pgto");
        }
    }

    public function autenticacao() {

//        var_dump($_POST);
//        
//        exit();

        $model = new Cadastro_Model();

        if (strlen($_SESSION["CODCADASTRO"]) == 32) {
            $this->assign("controle", TRUE);
            $this->assign("nome", $_SESSION["NOME"]);
            $this->assign("email", $_SESSION["EMAIL"]);
            $this->assign("saudacao", $this->saudacao());
        }

        if ($_POST["actionType"] == "criar_conta") {

            $email = $_POST["email"];
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

                header('Content-Type: application/json');
                $data["url"] = "https://www.mariadebarro.com.br/pt/conta/criar-conta/email/" . $_SERVER['EMAIL_CRIACAO'];
                echo json_encode($data);

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

                //mail($emaildesitnatario, $assunto, $mensagemHTML, $headers, "-f" . $emailsender);
                mail($emaildesitnatario, $assunto, $mensagemHTML, $headers, "-f" . $emailsender);

                $this->assign("msg_erro", "Uma mensagem foi encaminhada para seu e-mail!");
            }
        } else if ($_POST["actionType"] == "login") {

            $email = $_POST["email"];
            $this->assign("email_login", $email);
            $password = $_POST["senha"];

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
                        echo "/produtos/endereco/";
                        exit();
                        //if($model->qtdd_enderecos($_SESSION['CODCADASTRO'])){
                        //echo "<script>window.location='/" . LANGUAGE . "/produtos/pagamento/'</script>";
                        //exit();
                        //} else {
                        //echo "<script>window.location='/" . LANGUAGE . "/produtos/endereco/'</script>";
                        //exit();
                        //}                          
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
        $this->assign("title", TITLE . "Login | Autenticação");
        $this->assign("page", "login");
        $return["pagina"] = $this->view_tpl("autenticacao");
        //echo json_encode($return);
    }

    public function minha_conta() {

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
                ;
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

                $codcadastro = $this->getPrimarykey();
                $nome = $this->trata_nome($_POST["nome"]);
                $email = strtolower($_POST["email"]);
                $nascimento = $_POST["ano"] . "-" . $_POST["mes"] . "-" . $_POST["dia"];
                $sexo = $_POST["sexo"];
                $ddd = $_POST["ddd"];
                $tel = $_POST["tel"];
                $ramal = $_POST["ramal"];
                $passwd = $_POST["passwd"];
                $passwd2 = $_POST["passwd2"];
                $lembrete = $_POST["lembrete"];
                $updatePassword = $_POST["updatePassword"];

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
//                        $link = "https://" . SITE;
//
//                        $mensagemHTML = $this->view_email('emails/newsletter_footer');
//
//                        $headers = "MIME-Version: 1.1{$quebra_linha}";
//                        $headers .= "Content-type: text/html; charset=UTF-8{$quebra_linha}";
//                        $headers .= "From: \"{$nomeremetente}\"<{$emailsender}>{$quebra_linha}";
//                        $headers .= "Return-Path: {$emailsender}{$quebra_linha}";
//                        $headers .= "Cc: {$comcopia}{$quebra_linha}";
//                        $headers .= "Reply-To: {$emaildesitnatario}{$quebra_linha}";
//                        $headers .= "X-Mailer: PHP/" . phpversion();
//                        mail($emaildesitnatario, $assunto, $mensagemHTML, $headers, "-f" . $emailsender);

                        foreach ($dados as $n => $v) {
                            $_SESSION[$n] = $v;
                        }
                        echo "<script>window.location='" . MEU_SITE . "produtos/endereco/'</script>";
                        exit();
                    }
                    //}
                }
            } else {
                $this->assign("nome", $_SESSION["NOME"]);
                $this->assign("sexo", $_SESSION["SEXO"]);
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
            $this->assign("title", TITLE . "Minha conta");
            $this->assign("page", "login");
            $this->view_tpl("minha_conta");
        }
    }

    public function sair() {

        session_destroy();

        echo "<script>window.location='" . MEU_SITE . "produtos/checkout/'</script>";
        exit();
    }

    public function pagamento() {

        if ($this->permitir_acesso_comprador()) {

            $model = new Cadastro_Model();

            $this->assign("language", LANGUAGE);
            $this->assign("dados", $_SESSION);

            $url_checkout = "CLIENT_HIDDEN=" . CLIENT_HIDDEN . "&CODPRODUTO=";

            $this->assign("url_checkout", $url_checkout);
            $this->assign("cep_remetente", CEP_REMETENTE);
            $this->assign("title", TITLE . "Pagamento");
            $this->assign("page", "pagamento");
            $this->assign("CLIENT_HIDDEN", CLIENT_HIDDEN);
            $this->assign("CODCADASTRO", $_SESSION['CODCADASTRO']);

            if (!$model->qtdd_enderecos($_SESSION['CODCADASTRO'])) {
                echo "<script>window.location='" . MEU_SITE . "produtos/endereco/'</script>";
                exit();
            } else if (!$model->qntdd_produtos_carrinho(CLIENT_HIDDEN)) {
                echo "<script>window.location='" . MEU_SITE . "produtos/checkout/'</script>";
                exit();
            }

            $this->assign("endereco_list", $model->get_enderecos($_SESSION['CODCADASTRO']));
            $this->view_tpl("pagamento");
        }
    }

    public function confirmacao() {

        if ($this->permitir_acesso_comprador()) {

            $model = new Pedido_Model();

            $this->assign("language", LANGUAGE);
            $this->assign("dados", $_SESSION);

            $this->assign("title", TITLE . "Confirmação");
            $this->assign("page", "confirmacao");
            $this->assign("email_paypal", EMAIL_PAYPAL);
            $this->assign("email_moip", EMAIL_MOIP);

            $this->assign("url_retorno", URL_RETORNO);
            $this->assign("url_cancelamento", URL_CANCELAMENTO);
            $this->assign("url_notificacao", URL_NOTIFICACAO);

            $this->assign("CLIENT_HIDDEN", CLIENT_HIDDEN);

            $arr = $this->array_url();
            $codpedido = $arr[1];
            $codcadastro = $_SESSION["CODCADASTRO"];

            if ($model->pedido_finalizado($codpedido, $codcadastro)) {
                //caso o pedido já esteja pago ele tira o usuário da tela de cobrança
                echo "<script>window.location='" . MEU_SITE . "produtos/autenticacao/'</script>";
            } else {

                $forma_pgto = $model->get_forma_pgto_pedido($codpedido, $codcadastro);
                $this->assign("CODPEDIDO", $arr[1]);
                $this->assign("forma_pgto", $forma_pgto);
                $this->assign("pedido", $model->get_pedido($codpedido, $codcadastro));

                $this->view_tpl("confirmacao");
            }
        }
    }

    public function pgto_paypal() {

        if ($this->permitir_acesso_comprador()) {

            $model = new Pedido_Model();

            $this->assign("language", LANGUAGE);
            $this->assign("dados", $_SESSION);

            $this->assign("title", TITLE . "Confirmação");
            $this->assign("page", "confirmacao");
            $this->assign("email_paypal", EMAIL_PAYPAL);
            $this->assign("email_moip", EMAIL_MOIP);

            $arr = $this->array_url();
            $codpedido = $arr[1];
            $codcadastro = $_SESSION["CODCADASTRO"];

            $this->assign("url_retorno", PROTOCOLO . SITE . LANGUAGE . "/conta/paypal-confirmado/pedido/{$codpedido}");
            $this->assign("url_cancelamento", PROTOCOLO . SITE . LANGUAGE . "/conta/paypal-cancelamento/pedido/{$codpedido}");
            $this->assign("url_notificacao", PROTOCOLO . SITE . LANGUAGE . "/conta/paypal-notificacao/pedido/{$codpedido}");

            $this->assign("CLIENT_HIDDEN", CLIENT_HIDDEN);



            if ($model->pedido_finalizado($codpedido, $codcadastro)) {
                //caso o pedido já esteja pago ele tira o usuário da tela de cobrança
                echo "<script>window.location='" . MEU_SITE . "produtos/autenticacao/'</script>";
            } else {

                $forma_pgto = $model->get_forma_pgto_pedido($codpedido, $codcadastro);
                $this->assign("forma_pgto", $forma_pgto);
                $this->assign("pedido", $model->get_pedido($codpedido, $codcadastro));

                $this->view_tpl("pgto_paypal");
            }
        }
    }

    /*
     * ESTE METODO BUSCA OS PARAMETROS NECESSARIOS PARA O CHECKOUT 
     *      
     */

    public function checkout() {

        /*
         * CHAMA A CLASSE QUE GERENCIA OS PRODUTOS      
         */
        $model = new Produtos_Model();

        /*
         * SETA PARAMETRO PARA O MODELO SMARTY COM A LINGUAGEM
         */
        $this->assign("language", LANGUAGE);

        /*
         * SETA UM OBJETO CHAMADO DADOS COM O USUARIO DA SESSAO PARA O MODELO SMARTY
         */
        $this->assign("dados", $_SESSION);

        /*
         * SETA URL UTILIZADO NO AJAX PARA O MODELO SMARTY
         */
        $url_checkout = "CLIENT_HIDDEN=" . CLIENT_HIDDEN . "&CODPRODUTO=";
        $this->assign("url_checkout", $url_checkout);

        /*
         * CAPTURA O CEP DO USUÁRIO PARA O MODELO SMARTY
         */
        $this->assign("cep_remetente", CEP_REMETENTE);

        /*
         * SETA O TITULO DA PAGINA PARA O MODELO SMARTY
         */
        $this->assign("title", TITLE . "Checkout | Resumo");

        /*
         * DEFINA UM CONTROLE PARA A PAGINA
         */
        $this->assign("page", "resumo");

        /*
         * VERIFICA SE O CLIENTE QUER QUE EMBALE PRA PRESENTE E PASSA PARA O MODELO SMARTY
         */
        $this->assign("embalar_presente", $model->embalar_presente(CLIENT_HIDDEN));

        /*
         * LINK O FLUSH DE SAIDA E RENDERIZA A VIEW COM O HTML
         */
        $this->view_tpl("checkout");
    }

    /*
     * ESTE MÉTODO E UTILIZADO PELO AJAX DENTRO DE 
     * /WEB-FILES/JS/DEFAULT.JS 
     * ATUALIZA A LISTA COM O PLUS OU LESS DO CHECKOUT     
     */

    public function checkout_update() {

        /*
         * CHAMA A CLASSE QUE GERENCIA OS PRODUTOS      
         */
        $model = new Produtos_Model();

        /*
         * SETA PARAMETRO PARA O MODELO SMARTY COM A LINGUAGEM
         */
        $this->assign("language", LANGUAGE);

        /*
         * SETA UM OBJETO CHAMADO DADOS COM O USUARIO DA SESSAO PARA O MODELO SMARTY
         */
        $this->assign("dados", $_SESSION);

        /*
         * SETA URL UTILIZADO NO AJAX PARA O MODELO SMARTY
         */
        $url_checkout = "CLIENT_HIDDEN=" . CLIENT_HIDDEN . "&CODPRODUTO=";
        $this->assign("url_checkout", $url_checkout);

        /*
         * CAPTURA O CEP DO USUÁRIO PARA O MODELO SMARTY
         */
        $this->assign("cep_remetente", CEP_REMETENTE);

        /*
         * SETA O TITULO DA PAGINA PARA O MODELO SMARTY
         */
        $this->assign("title", TITLE . "Checkout | Resumo");

        /*
         * DEFINA UM CONTROLE PARA A PAGINA
         */
        $this->assign("page", "resumo");

        /*
         * VERIFICA SE O CLIENTE QUER QUE EMBALE PRA PRESENTE E PASSA PARA O MODELO SMARTY
         */
        $this->assign("embalar_presente", $model->embalar_presente(CLIENT_HIDDEN));

        /*
         * LINK O FLUSH DE SAIDA E RENDERIZA A VIEW COM O HTML
         */
        $this->view_tpl("checkout_update");
    }

    /*
     * ESTE MÉTODO E UTILIZADO PELO AJAX DENTRO DE 
     * /WEB-FILES/JS/DEFAULT.JS 
     * ATUALIZA QUADRO DE CUPOM DE DESCONTO     
     */

    public function checkout_cupom_desconto() {

        /*
         * CHAMA A CLASSE QUE GERENCIA OS PRODUTOS      
         */
        $model = new Produtos_Model();

        /*
         * SETA PARAMETRO PARA O MODELO SMARTY COM A LINGUAGEM
         */
        $this->assign("language", LANGUAGE);

        /*
         * SETA UM OBJETO CHAMADO DADOS COM O USUARIO DA SESSAO PARA O MODELO SMARTY
         */
        $this->assign("dados", $_SESSION);

        /*
         * SETA URL UTILIZADO NO AJAX PARA O MODELO SMARTY
         */
        $url_checkout = "CLIENT_HIDDEN=" . CLIENT_HIDDEN . "&CODPRODUTO=";
        $this->assign("url_checkout", $url_checkout);

        /*
         * CAPTURA O CEP DO USUÁRIO PARA O MODELO SMARTY
         */
        $this->assign("cep_remetente", CEP_REMETENTE);

        /*
         * SETA O TITULO DA PAGINA PARA O MODELO SMARTY
         */
        $this->assign("title", TITLE . "Checkout | Resumo");

        /*
         * DEFINA UM CONTROLE PARA A PAGINA
         */
        $this->assign("page", "resumo");

        /*
         * VERIFICA SE O CLIENTE QUER QUE EMBALE PRA PRESENTE E PASSA PARA O MODELO SMARTY
         */
        $this->assign("embalar_presente", $model->embalar_presente(CLIENT_HIDDEN));

        /*
         * LINK O FLUSH DE SAIDA E RENDERIZA A VIEW COM O HTML
         */
        $this->view_tpl("checkout_cupom_desconto");
    }

    public function checar_desconto() {

        //if ($this->permitir_acesso_comprador()) {

        header('Content-Type: application/json');

        $model = new Pedido_Model();
        $cupom = $_POST["CUPOM"];
        $bonus = $model->get_bonus($cupom);
        if ($bonus) {
            if ($bonus->TIPO == "aniversario") {
                $dados["success"] = "<strong>* Este cupom lhe dá o desconto de <span style='display: block; font-size: 23px; margin: 4px 0;'>10%</span> nesta compra pelo seu aniversário!</strong>";
            } if ($bonus->TIPO == "desconto") {
                $dados["success"] = "<strong>* Este cupom lhe dá o desconto de <span style='display: block; font-size: 23px; margin: 4px 0;'>10%</span> na sua próxima compra!</strong>";
            } else {
                $dados["success"] = "<strong>* Este cupom lhe dá o desconto de<br/> R$ {$bonus->VALOR} para esta comprar!</strong>";
            }

            $dados["erro_msg"] = "";
        } else {
            $dados["success"] = "";
            $dados["erro_msg"] = "<strong>* Número de cupom inexistente!</strong>";
        }

        echo json_encode($dados);
        //}
    }

    public function embalar_presente() {

        $model = new Produtos_Model();

        $stt = (int) $model->embalar_presente(CLIENT_HIDDEN);
        $status = ( $stt == 1 ) ? 0 : 1;

        $dados["EMBALAR_PRESENTE"] = $status;
        $model->update_embalar_presente($dados, CLIENT_HIDDEN);

        echo (int) $model->embalar_presente(CLIENT_HIDDEN);
    }

    public function calcula_bonus() {

        $model = new Produtos_Model();

        $total_geral = $model->get_total_geral_lista_desejos(CLIENT_HIDDEN);
        $sobre_valor = str_replace(",", "", $total_geral->TOTAL_GERAL);
        $sobre_valor = str_replace(".", "", $sobre_valor);

        echo $this->formataReais(round($sobre_valor / BONUS) - $sobre_valor);
        exit();
    }

    public function update_precode() {

        $model = new Produtos_Model();

        $codproduto = $_POST["codproduto"];
        $dados["DE"] = $_POST["valor"];

        $model->update_produto($dados, $codproduto);

        exit();
    }

    public function update_precopara() {

        $model = new Produtos_Model();

        $codproduto = $_POST["codproduto"];
        $dados["PRECO"] = $_POST["valor"];

        $model->update_produto($dados, $codproduto);
        exit();
    }

    public function update_referencia() {

        $model = new Produtos_Model();

        $codproduto = $_POST["codproduto"];
        $dados["REFERENCIA"] = strtoupper($_POST["valor"]);

        $model->update_produto($dados, $codproduto);
        exit();
    }

    public function update_precodecompra() {


        ( (int) $_POST["qntdd"] > 0 ) ? $valor = ((int) $_POST["valor"] * (int) $_POST["qntdd"]) : $valor = 0;

        $model = new Produtos_Model();

        $codproduto = $_POST["codproduto"];
        $dados["PRECO_COMPRA"] = $valor;

        $model->update_produto($dados, $codproduto);

        echo $this->formataReais($valor);
        exit();
    }

    public function update_precounitario() {

        $model = new Produtos_Model();

        $codproduto = $_POST["codproduto"];
        $dados["PRECO_UNITARIO"] = $_POST["valor"];

        $model->update_produto($dados, $codproduto);
        exit();
    }

    public function update_peso() {

        $model = new Produtos_Model();

        $codproduto = $_POST["codproduto"];
        $dados["PESO"] = $_POST["valor"];

        $model->update_produto($dados, $codproduto);
        exit();
    }

    public function update_qntdd_estoque() {

        $model = new Produtos_Model();

        $codproduto = $_POST["codproduto"];
        $dados["QUANTIDADE"] = $_POST["quantidade"];

        $model->update_produto($dados, $codproduto);
        exit();
    }

    public function sugestao() {

        $model = new Produtos_Model();

        //header('Content-Type: application/json');

        $search = $_POST["search"];
        $sugestao = $model->search_sugestao(utf8_decode($search));
        $str = "";
        if ($sugestao) {
            $str .= "<div style='padding: 4.5%;'>";
            $str .= "Sugestões para <b>{$search}</b><hr>";
            foreach ($sugestao as $obj) {
                $obj->NOME = str_replace($search, "<b>{$search}</b>", $obj->NOME);
                $str .= "<div><a href='" . MEU_SITE . "{$obj->CATEGORIA}/{$obj->URL_AMIGAVEL}'>{$obj->NOME}</a></div>";
            }
            $str .= "</div>";
        }

        echo $str;

        exit();
    }

}
