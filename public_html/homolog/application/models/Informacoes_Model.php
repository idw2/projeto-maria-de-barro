<?php

class Informacoes_Model extends Model {

    public function insert_newsletter(Array $dados) {
        if (sizeof($dados) != 0) {

            $campos = "`" . implode("`,`", array_keys($dados)) . "`";
            $keys = ":" . implode(",:", array_keys($dados));

            $query = $this->db->prepare("INSERT INTO `newsletter` ({$campos}) VALUES ({$keys});");

            foreach ($dados as $n => $v) {
                $dados[$n] = addslashes($v);
            }

            $query->bindParam(":CODNEWSLETTER", $dados["CODNEWSLETTER"], PDO::PARAM_STR, 32);
            $query->bindParam(":NOME", $dados["NOME"], PDO::PARAM_STR, 70);
            $query->bindParam(":EMAIL", $dados["EMAIL"], PDO::PARAM_STR, 70);
            $query->bindParam(":SEXO", $dados["SEXO"], PDO::PARAM_STR, 1);
            $query->bindParam(":STATUS", $dados["STATUS"], PDO::PARAM_STR);

            $query->execute();

            return true;
        } else {
            return false;
        }
    }

    public function existe_email_newsletter($email) {
        
        $email = addslashes($email);
        
        $query = $this->db->prepare("SELECT * FROM `newsletter` WHERE EMAIL=:EMAIL");
        $query->bindParam(":EMAIL", $email, PDO::PARAM_STR, 70);
        $query->execute();
        return $query->rowCount();
    }

    public function get_inscrito_newsletter($email) {
        
        $email = addslashes($email);
        
        $this->_tabela = "newsletter";
        $where = "EMAIL='{$email}'";
        return $this->read($where);
    }

    public function update_status_newsletter($codnewsletter, $status) {
        
        $codnewsletter = addslashes($codnewsletter);
        $status = addslashes($status);
        
        $this->_tabela = "newsletter";
        $where = "CODNEWSLETTER='{$codnewsletter}'";
        $dados["STATUS"] = $status;
        return $this->update($dados, $where);
    }

    public function get_newsletter() {
        $query = $this->db->query("SELECT newsletter.*, DATE_FORMAT( newsletter.DTA,  '%d/%m/%Y - %Hh%i' ) AS DTA  FROM `newsletter`");
        $query->execute();
        if ($query->rowCount()) {
            while ($rows = $query->fetch(PDO::FETCH_OBJ)) {
                $rows->NOME = utf8_encode($rows->NOME);
                $obj[] = $rows;
            }
            return $obj;
        } else {
            return false;
        }
    }

    public function update_status($email, $status) {
        
        $email = addslashes($email);
        $status = addslashes($status);
        
        $this->_tabela = "newsletter";
        $dados["STATUS"] = $status;
        $where = "EMAIL='{$email}'";
        return $this->update($dados, $where);
    }
    
    public function insert_avise_me(Array $dados) {
        if (sizeof($dados) != 0) {

            $campos = "`" . implode("`,`", array_keys($dados)) . "`";
            $keys = ":" . implode(",:", array_keys($dados));

            $query = $this->db->prepare("INSERT INTO `avise_me` ({$campos}) VALUES ({$keys});");

            foreach ($dados as $n => $v) {
                $dados[$n] = addslashes($v);
            }

            $query->bindParam(":CODAVISEME", $dados["CODAVISEME"], PDO::PARAM_STR, 32);
            $query->bindParam(":EMAIL", $dados["EMAIL"], PDO::PARAM_STR, 70);
            $query->bindParam(":REFERENCIA", $dados["REFERENCIA"], PDO::PARAM_STR, 255);
            $query->bindParam(":STATUS", $dados["STATUS"], PDO::PARAM_STR);

            $query->execute();

            return true;
        } else {
            return false;
        }
    }
    
    public function existe_avise_me($email, $referencia) {
        
        $email = addslashes($email);
        $referencia = addslashes($referencia);
        
        $query = $this->db->prepare("SELECT * FROM `avise_me` WHERE EMAIL=:EMAIL AND REFERENCIA=:REFERENCIA");
        $query->bindParam(":EMAIL", $email, PDO::PARAM_STR, 70);
        $query->bindParam(":REFERENCIA", $referencia, PDO::PARAM_STR, 255);
        $query->execute();
        return $query->rowCount();
    }

}
