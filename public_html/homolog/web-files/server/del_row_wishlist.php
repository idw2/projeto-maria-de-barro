<?php

set_time_limit(0);
require("../../system/model.php");

Class Querys extends Model {

    public function del_row_wishlist($codproduto, $client_hidden) {
        $this->_tabela = "lista_desejos";
        $where = "CLIENT_HIDDEN='{$client_hidden}' AND CODPRODUTO='{$codproduto}'";
        return $this->delete($where);
    }

}

$model = new Querys();

$codproduto = $_POST["CODPRODUTO"];
$client_hidden = $_POST["CLIENT_HIDDEN"];

$model->del_row_wishlist($codproduto, $client_hidden);
echo "OK";