<?php

set_time_limit(0);
require("../../system/model.php");

Class Querys extends Model {

    public function update_ordem(Array $dados, $key) {
        $this->_tabela = "produtos";
        $where = "CODPRODUTO='{$key}'";
        return $this->update($dados, $where);
    }

}

$keys = $_POST["keys"];
$_keys = explode(";", $keys);
$model = new Querys();


$i=1;
foreach($_keys as $value){
    if($value != "" || $value != null){
        $codproduto = strtoupper($value);
        $dados["ORDEM"] = $i; 
        $model->update_ordem($dados, $codproduto);
    }
    $i++;
}
