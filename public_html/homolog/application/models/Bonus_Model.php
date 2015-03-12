<?php

class Bonus_Model extends Model {

    public function existe_codigo_bonus($codigo_or_email) {
        $query = $this->db->query("SELECT * FROM bonus WHERE CODIGO='{$codigo}' OR EMAIL='{$codigo_or_email}'");
        $query->execute();
        return $query->rowCount();
    }

    public function insert_bonus(Array $dados) {
        $this->_tabela = "bonus";
        $this->insert($dados);
    }

}
