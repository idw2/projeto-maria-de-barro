<?php

Class Avaliacao extends Controller {

    public function __construct() {
        
    }

    public function computar_avaliacao() {
        if ($this->permitir_acesso_comprador()) {

            $model = new Avaliacao_Model();

            if ($model->existe_avaliacao($_POST["codcadastro"], $_POST["codproduto"])) {
                echo "PRODUTO_AVALIADO";
            } else {

                $dados["CODAVALIACAO"] = $this->getPrimarykey();
                $dados["CODCADASTRO"] = $_POST["codcadastro"];
                $dados["CODPRODUTO"] = $_POST["codproduto"];
                $dados["AVALIACAO"] = $_POST["avaliacao"];

                $model->insert_avaliacao($dados);
                
                echo "OK";
            }
        }
    }

    public function timer_avalicacao() {

        if (strlen($_SESSION["CODCADASTRO"]) == 32) {
            echo $_SESSION["CODCADASTRO"];
        }
    }
    
    public function get_avaliacao() {

        $model = new Avaliacao_Model();
            
        $codproduto = $_POST["codproduto"];
        $avaliacao = "NAO_GOSTEI";
        $count_registros = $model->get_avaliacao($codproduto);
        $count1 = $model->get_avaliacao($codproduto, $avaliacao);

        $avaliacao = "RAZOAVEL";
        $count2 = $model->get_avaliacao($codproduto, $avaliacao);

        $avaliacao = "BOM";
        $count3 = $model->get_avaliacao($codproduto, $avaliacao);

        $avaliacao = "EXCELENTE";
        $count4 = $model->get_avaliacao($codproduto, $avaliacao);
        
        if( $count_registros > 0 ){            
            //$count_registros  = round($count/10);
            $count1 = round(($count_registros/100)*$count1);
            $count2 = round(($count_registros/100)*$count2);
            $count3 = round(($count_registros/100)*$count3);
            $count4 = round(($count_registros/100)*$count4);
        }
        
        echo "{$count_registros},{$count1},{$count2},{$count3},{$count4}";
    }

}
