<?php

class Atendimento_Model extends Model {

    public function existe_atendimento() {
        $query = $this->db->prepare("SELECT * FROM `conta` WHERE ON_LINE=1");
        $query->execute();
        return $query->rowCount();
    }

    public function insert_atendimento(Array $dados) {
        if (sizeof($dados) != 0) {
            $campos = "`" . implode("`,`", array_keys($dados)) . "`";
            $keys = ":" . implode(",:", array_keys($dados));

            $query = $this->db->prepare("INSERT INTO `atendimento` ({$campos}) VALUES ({$keys});");

            foreach ($dados as $n => $v) {
                $dados[$n] = addslashes($v);
            }

            $query->bindParam(":CODATENDIMENTO", $dados["CODATENDIMENTO"], PDO::PARAM_STR, 32);
            $query->bindParam(":NOME", $dados["NOME"], PDO::PARAM_STR, 70);
            $query->bindParam(":EMAIL", $dados["EMAIL"], PDO::PARAM_STR, 70);
            $query->bindParam(":ENVIAR_EMAIL", $dados["ENVIAR_EMAIL"], PDO::PARAM_STR, 1);
            $query->bindParam(":STATUS", $dados["STATUS"], PDO::PARAM_STR, 1);

            $query->execute();

            return true;
        } else {
            return false;
        }
    }

    public function insert_chat(Array $dados) {
        if (sizeof($dados) != 0) {
            $campos = "`" . implode("`,`", array_keys($dados)) . "`";
            $keys = ":" . implode(",:", array_keys($dados));

            $query = $this->db->prepare("INSERT INTO `chat` ({$campos}) VALUES ({$keys});");

            foreach ($dados as $n => $v) {
                $dados[$n] = addslashes($v);
            }

            $query->bindParam(":CODCHAT", $dados["CODCHAT"], PDO::PARAM_STR, 32);
            $query->bindParam(":CODATENDIMENTO", $dados["CODATENDIMENTO"], PDO::PARAM_STR, 32);
            $query->bindParam(":MENSAGEM", $dados["MENSAGEM"], PDO::PARAM_INT | PDO::PARAM_INPUT_OUTPUT);
            $query->bindParam(":ENVIADO_POR", $dados["ENVIADO_POR"], PDO::PARAM_STR, 20);
            $query->bindParam(":VIEW_POR", $dados["VIEW_POR"], PDO::PARAM_STR, 20);

            $query->execute();

            return true;
        } else {
            return false;
        }
    }

    public function get_atendimentos_aberto() {

        $query = $this->db->query("SELECT atendimento.*, DATE_FORMAT( atendimento.DTA,  '%d/%m/%Y - %Hh%i' ) AS DTA FROM atendimento WHERE atendimento.CODATENDENTE='' AND atendimento.STATUS=1 ORDER BY atendimento.DTA ASC;");
        $query->execute();

        if ($query->rowCount()) {
            while ($rows = $query->fetch(PDO::FETCH_OBJ)) {
                $rows->CODATENDIMENTO = strtolower($rows->CODATENDIMENTO);
                $dados[] = $rows;
            }
            return $dados;
        } else {
            return false;
        }
    }

    public function insert_atendente(Array $dados, $codatendimento) {

        foreach ($dados as $n => $v) {
            $dados[$n] = addslashes($v);
        }

        $this->_tabela = "atendimento";
        $where = "CODATENDIMENTO='{$codatendimento}'";
        return $this->update($dados, $where);
    }

    public function get_chat($codatendimento, Array $enviado_por) {

        if (is_array($enviado_por)) {
            $evp = "'" . implode("','", $enviado_por) . "'";
            $and = "AND chat.ENVIADO_POR IN({$evp})";
        }

        #echo "SELECT chat.MENSAGEM FROM chat WHERE chat.CODATENDIMENTO='{$codatendimento}' {$and} AND chat.STATUS=1;";
        #exit();

        $query = $this->db->query("SELECT chat.MENSAGEM FROM chat WHERE chat.CODATENDIMENTO='{$codatendimento}' {$and} AND chat.STATUS=1;");
        $query->execute();

        if ($query->rowCount()) {
            while ($rows = $query->fetch(PDO::FETCH_OBJ)) {
                $rows->CODATENDIMENTO = strtolower($rows->CODATENDIMENTO);
                $dados[] = $rows;
            }
            return $dados;
        } else {
            return false;
        }
    }

}
