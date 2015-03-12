<?php

set_time_limit(0);
require("../../system/model.php");

Class Querys extends Model {
    public function get_page($pagina) {
        $this->_tabela = "html";
        $where = "PAGINA='{$pagina}'";
        return $this->read($where);
    }
}

$model = new Querys();
$pagina = "quem_somos";
$html = $model->get_page($pagina);

$conteudo = explode(". ", $html->CONTEUDO);
echo $conteudo[0].".</span>";