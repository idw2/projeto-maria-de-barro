<?php

set_time_limit(0);
require("../../system/model.php");

Class Querys extends Model {
/*
    public function get_foto($key) {
        $this->_tabela = "fotos";
        $where = "CODFOTO='{$key}'";
        return $this->read($where);
    }*/

    public function update_qntdd(Array $dados, $key) {
        $this->_tabela = "produtos";
        $where = "CODPRODUTO='{$key}'";
        return $this->update($dados, $where);
    }

}

$keys = $_POST["keys"];
$_keys = explode(";", $keys);
$model = new Querys();
$dados["QUANTIDADE"] = ($_POST["quantidade"] == "") ? 0 : $_POST["quantidade"]; 
$model->update_qntdd($dados, $_POST["codproduto"]);
var_dump($_POST);