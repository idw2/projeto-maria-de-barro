<?php

class Cadastro_Model extends Model {

    public function existe_cadastro($email) {

        $email = addslashes($email);

        $query = $this->db->prepare("SELECT * FROM `cadastro` WHERE EMAIL=:EMAIL");
        $query->bindParam(":EMAIL", $email, PDO::PARAM_STR, 70);
        $query->execute();
        return $query->rowCount();
    }

    public function insert_cadastro(Array $dados) {
        if (sizeof($dados) != 0) {
            $campos = "`" . implode("`,`", array_keys($dados)) . "`";
            $keys = ":" . implode(",:", array_keys($dados));

            $query = $this->db->prepare("INSERT INTO `cadastro` ({$campos}) VALUES ({$keys});");

            foreach ($dados as $n => $v) {
                $dados[$n] = addslashes($v);
            }

            $query->bindParam(":CODCADASTRO", $dados["CODCADASTRO"], PDO::PARAM_STR, 32);
            $query->bindParam(":NOME", $dados["NOME"], PDO::PARAM_STR, 70);
            $query->bindParam(":EMAIL", $dados["EMAIL"], PDO::PARAM_STR, 70);
            $query->bindParam(":SEXO", $dados["SEXO"], PDO::PARAM_STR);
            $query->bindParam(":NASCIMENTO", $dados["NASCIMENTO"], PDO::PARAM_STR);
            $query->bindParam(":CPF", $dados["CPF"], PDO::PARAM_STR, 11);
            $query->bindParam(":DDD", $dados["DDD"], PDO::PARAM_STR, 4);
            $query->bindParam(":TELEFONE", $dados["TELEFONE"], PDO::PARAM_STR, 10);
            $query->bindParam(":RAMAL", $dados["RAMAL"], PDO::PARAM_STR, 8);
            $query->bindParam(":PASSWORD", $dados["PASSWORD"], PDO::PARAM_STR, 32);
            $query->bindParam(":LEMBRETE", $dados["LEMBRETE"], PDO::PARAM_STR, 255);
            $query->bindParam(":STATUS", $dados["STATUS"], PDO::PARAM_STR);

            $query->execute();

            return true;
        } else {
            return false;
        }
    }

    public function update_cadastro(Array $dados, $email) {

        $email = addslashes($email);

        foreach ($dados as $n => $v) {
            $dados[$n] = addslashes($v);
        }

        if (sizeof($dados) != 0) {
            $this->_tabela = "cadastro";
            $where = "EMAIL='{$email}'";
            $this->update($dados, $where);
            return true;
        } else {
            return false;
        }
    }

    public function valida_cadastro($email, $password) {

        $email = addslashes($email);
        $password = addslashes($password);

        $query = $this->db->prepare("SELECT * FROM cadastro WHERE EMAIL=:EMAIL AND PASSWORD=:PASSWORD");
        $query->bindParam(":EMAIL", $email, PDO::PARAM_STR, 20);
        $query->bindParam(":PASSWORD", $password, PDO::PARAM_STR, 32);
        $query->execute();
        return $query->rowCount();
    }

    public function get_dados_cadastro($email) {

        $email = addslashes($email);

        $this->_tabela = "cadastro";
        $where = "EMAIL='{$email}'";
        return $this->read($where);
    }

    public function insert_endereco(Array $dados) {
        if (sizeof($dados) != 0) {
            $campos = "`" . implode("`,`", array_keys($dados)) . "`";
            $keys = ":" . implode(",:", array_keys($dados));

            $query = $this->db->prepare("INSERT INTO `enderecos` ({$campos}) VALUES ({$keys});");

            foreach ($dados as $n => $v) {
                $dados[$n] = addslashes($v);
            }

            $query->bindParam(":CODENDERECO", $dados["CODENDERECO"], PDO::PARAM_STR, 32);
            $query->bindParam(":CEP", $dados["CEP"], PDO::PARAM_STR, 9);
            $query->bindParam(":LOGRADOURO", $dados["LOGRADOURO"], PDO::PARAM_STR, 255);
            $query->bindParam(":NUMERO", $dados["NUMERO"], PDO::PARAM_STR, 255);
            $query->bindParam(":COMPLEMENTO", $dados["COMPLEMENTO"], PDO::PARAM_STR, 255);
            $query->bindParam(":UF", $dados["UF"], PDO::PARAM_STR, 2);
            $query->bindParam(":CIDADE", $dados["CIDADE"], PDO::PARAM_STR, 255);
            $query->bindParam(":BAIRRO", $dados["BAIRRO"], PDO::PARAM_STR, 255);
            $query->bindParam(":STATUS", $dados["STATUS"], PDO::PARAM_STR);

            $query->execute();

            return true;
        } else {
            return false;
        }
    }

    public function insert_cadastro_rel_endereco(Array $dados) {
        if (sizeof($dados) != 0) {
            $campos = "`" . implode("`,`", array_keys($dados)) . "`";
            $keys = ":" . implode(",:", array_keys($dados));

            $query = $this->db->prepare("INSERT INTO `cadastro_rel_enderecos` ({$campos}) VALUES ({$keys});");
            
            foreach ($dados as $n => $v) {
                $dados[$n] = addslashes($v);
            }

            $query->bindParam(":CODENDERECO", $dados["CODENDERECO"], PDO::PARAM_STR, 32);
            $query->bindParam(":CODCADASTRO", $dados["CODCADASTRO"], PDO::PARAM_STR, 9);

            $query->execute();

            return true;
        } else {
            return false;
        }
    }

    public function existe_enderecos($codcadastro) {
        
        $codcadastro = addslashes($codcadastro);
            
        $query = $this->db->prepare("SELECT enderecos.* FROM `enderecos` "
                . "INNER JOIN `cadastro_rel_enderecos` ON cadastro_rel_enderecos.CODENDERECO=enderecos.CODENDERECO "
                . "WHERE cadastro_rel_enderecos.CODCADASTRO='{$codcadastro}'"
                . "GROUP BY cadastro_rel_enderecos.CODCADASTRO");
        $query->execute();
        return $query->rowCount();
    }

    public function get_enderecos($codcadastro) {
        
        $codcadastro = addslashes($codcadastro);

        $query = $this->db->query("SELECT enderecos.* FROM `enderecos` "
                . "INNER JOIN `cadastro_rel_enderecos` ON cadastro_rel_enderecos.CODENDERECO=enderecos.CODENDERECO "
                . "WHERE cadastro_rel_enderecos.CODCADASTRO='{$codcadastro}'"
                . "GROUP BY enderecos.CODENDERECO"
                . " ORDER BY enderecos.DTA DESC");
        $query->execute();
        if ($query->rowCount()) {
            while ($rows = $query->fetch(PDO::FETCH_OBJ)) {
                $rows->BAIRRO = utf8_encode($rows->BAIRRO);
                $rows->CIDADE = utf8_encode($rows->CIDADE);
                $rows->COMPLEMENTO = utf8_encode($rows->COMPLEMENTO);
                $rows->NUMERO = utf8_encode($rows->NUMERO);
                $rows->LOGRADOURO = utf8_encode($rows->LOGRADOURO);
                $dados[] = $rows;
            }
            return $dados;
        } else {
            return false;
        }
    }

    public function qtdd_enderecos($codcadastro) {
        
        $codcadastro = addslashes($codcadastro);
        
        $query = $this->db->query("SELECT enderecos.* FROM enderecos
        INNER JOIN cadastro_rel_enderecos ON cadastro_rel_enderecos.CODENDERECO=enderecos.CODENDERECO
        WHERE cadastro_rel_enderecos.CODCADASTRO='{$codcadastro}'");
        $query->execute();
        return $query->rowCount();
    }

    public function existe_email($email) {
        
        $email = addslashes($email);
        
        $query = $this->db->prepare("SELECT * FROM cadastro WHERE EMAIL=:EMAIL");
        $query->bindParam(":EMAIL", $email, PDO::PARAM_STR, 20);
        $query->execute();
        return $query->rowCount();
    }

    public function get_email($email) {
        
        $email = addslashes($email);
        
        $query = $this->db->prepare("SELECT * FROM cadastro WHERE EMAIL=:EMAIL");
        $query->bindParam(":EMAIL", $email, PDO::PARAM_STR, 70);
        $query->execute();
        return $query->fetch(PDO::FETCH_OBJ);
    }

    public function update_senha($codconta, $senha, $lembrete) {
        
        $codconta = addslashes($codconta);
        $senha = addslashes($senha);
        $lembrete = addslashes($lembrete);
        
        $query = $this->db->prepare("UPDATE `cadastro` SET PASSWORD=:PASSWORD, LEMBRETE=:LEMBRETE WHERE CODCADASTRO=:CODCADASTRO");
        $query->bindParam(":PASSWORD", $senha, PDO::PARAM_STR, 32);
        $query->bindParam(":CODCADASTRO", $codconta, PDO::PARAM_STR, 32);
        $query->bindParam(":LEMBRETE", $lembrete, PDO::PARAM_STR, 255);
        $query->execute();
        return true;
    }

    public function get_cadastro_with_codcadastro($codcadastro) {
        
        $codcadastro = addslashes($codcadastro);
        
        $query = $this->db->prepare("SELECT * FROM `cadastro` WHERE CODCADASTRO=:CODCADASTRO");
        $query->bindParam(":CODCADASTRO", strtoupper($codcadastro), PDO::PARAM_STR, 32);
        $query->execute();
        if ($query->rowCount()) {
            while ($rows = $query->fetch(PDO::FETCH_OBJ)) {
                $rows->NOME = utf8_encode($rows->NOME);
                return $rows;
            }
        } else {
            return false;
        }
    }

    public function qntdd_produtos_carrinho($client_hidden) {
        
        $client_hidden = addslashes($client_hidden);
        
        $query = $this->db->prepare("SELECT * FROM lista_desejos WHERE CLIENT_HIDDEN=:CLIENT_HIDDEN");
        $query->bindParam(":CLIENT_HIDDEN", $client_hidden, PDO::PARAM_STR, 32);
        $query->execute();
        return $query->rowCount();
    }

    public function existe_cpf($cpf) {
        
        $cpf = addslashes($cpf);
        
        $query = $this->db->prepare("SELECT * FROM cadastro WHERE CPF=:CPF");
        $query->bindParam(":CPF", $cpf, PDO::PARAM_STR, 11);
        $query->execute();
        return $query->rowCount();
    }

}
