<?php

Class Index extends Controller {

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
        
        if (isset($_COOKIE['float_banner'])) {
            setcookie('float_banner', 'is_set', time()+3600);
            $this->assign("float_banner", true);
        } else {
            $this->assign("float_banner", false);
        }
        
        
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
        }*/
        
    }
    
    function index() {
        return false;             
    }

    function index_action() {

        $this->assign("language", LANGUAGE);
        $this->assign("page", "index");
        $this->assign("abas", "novidades");

        $model = new Produtos_Model();
        
        if($this->getParameters("mais_produtos") != ""){
            $limit = "LIMIT {$this->getParameters("mais_produtos")}";   
            $this->assign("compara_paginacao", $this->getParameters("mais_produtos"));
        } else {
            $limit = "LIMIT 0,4";    
             $this->assign("compara_paginacao", "0,4");
        }
        
        
        $arr = $model->get_lista_produtos_index_rand(null, $limit);
        
        $paginacao = array();
        $qntdd_produtos = (int)$model->qnts_produtos();
        
        $resto = ( $qntdd_produtos % 16 );
        if( $qntdd_produtos > 16 ){
            $exato = (( $qntdd_produtos - $resto ) / 16);
            for($i=0; $i<$exato; $i++){
                $padrao = ($i*16); 
                $paginacao[] = "{$padrao},16";
            }
            if( $resto != 0){
                $padrao = ( $qntdd_produtos - $resto );
                $paginacao[] = "{$padrao},$resto";
            }            
        }
        
        $this->assign("acao", "geral");
        $this->assign("paginacao", $paginacao);
        
        $lista_desejos = "CLIENT_HIDDEN=" . CLIENT_HIDDEN . "&CODPRODUTO=";
        $this->assign("lista_desejos", $lista_desejos);
        
        $this->assign("arr", $arr);
        $this->assign("language", LANGUAGE);
        $this->assign("title", TITLE . "Página Inicial");
        
        
        //mais vendidos        
        $limit_mais_vendidos = "LIMIT 0,4";        
        $arr_mais_vendidos = $model->get_lista_produtos_mais_vendidos($limit_mais_vendidos);
        $this->assign("arr_mais_vendidos", $arr_mais_vendidos);
        
        //promocoes
        $limit_promocoes = "LIMIT 0,4";        
        $arr_promocoes = $model->get_lista_produtos_promocao($limit_promocoes);
        $this->assign("arr_promocoes", $arr_promocoes);
        
        //novos
        $limit_is_novo = "LIMIT 0,4";        
        $arr_is_novo = $model->get_lista_produtos_novos($limit_is_novo);
        $this->assign("arr_is_novo", $arr_is_novo);
        
        
        $this->view_tpl("index");
    }
    
    function top() {

        $this->assign("language", LANGUAGE);
        $this->assign("page", "index");
        $this->assign("abas", "novidades");
        
        $this->view_tpl("top");
    }
        
    
}
