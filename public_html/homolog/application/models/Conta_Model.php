<?php

class Conta_Model extends Model {

    public function existe_conta($email) {

        $query = $this->db->prepare("SELECT * FROM conta WHERE EMAIL=:EMAIL");
        $query->bindParam(":EMAIL", addslashes($email), PDO::PARAM_STR, 70);
        $query->execute();
        return $query->rowCount();
    }
    
    public function existe_aniversariantes() {
         
        if( $search != null){
            
            $nome = $search;
            $email = $search;
            $nascimento = $c->formataDataForUSA($search);
            $sexo = $search;
            $ddd = $search;
            $tel = $search;
            $ramal = $search;
            $cpf = $c->limpaCpf($search);
            
            $where = "WHERE cadastro.NASCIMENTO LIKE CONCAT('%', DATE_FORMAT( DATE_ADD(CURRENT_DATE, INTERVAL 2 DAY), '%m-%d' ), '%') AND cadastro.NOME LIKE '%{$nome}%'
            OR cadastro.EMAIL LIKE '%{$email}%'
            OR cadastro.NASCIMENTO LIKE '%{$nascimento}%'
            OR cadastro.SEXO LIKE '%{$sexo}%'
            OR cadastro.DDD LIKE '%{$ddd}%'
            OR cadastro.TELEFONE LIKE '%{$tel}%'
            OR cadastro.RAMAL LIKE '%{$ramal}%'
            OR cadastro.CPF LIKE '%{$cpf}%'";
            
        } else if ($codcadastro != null) {
            $codcadastro = addslashes($codcadastro);
            $where = "WHERE cadastro.NASCIMENTO LIKE CONCAT('%', DATE_FORMAT( DATE_ADD(CURRENT_DATE, INTERVAL 2 DAY), '%m-%d' ), '%') AND cadastro.CODCADASTRO='{$codcadastro}'";
        } else {
            $where = "WHERE cadastro.NASCIMENTO LIKE CONCAT('%', DATE_FORMAT( DATE_ADD(CURRENT_DATE, INTERVAL 2 DAY), '%m-%d' ), '%')";
        }
        
        $query = $this->db->query("SELECT cadastro.*, DATE_FORMAT( cadastro.DTA, '%d/%m/%Y - %Hh%i' ) as DTA FROM cadastro
        {$where}
        ORDER BY cadastro.DTA DESC");
        
        $query->execute();
        return $query->rowCount();
    }
    
    public function existe_bonus_aniversario($codcadastro, $ano) {

        $query = $this->db->prepare("SELECT * FROM bonus WHERE DTA LIKE '%{$ano}%' AND TIPO = 'aniversario' AND CODCADASTRO = :CODCADASTRO");
        $query->bindParam(":CODCADASTRO", addslashes($codcadastro), PDO::PARAM_STR, 32);
        $query->execute();
        return $query->rowCount();
    }
    
    public function get_bonus_aniversario($codcadastro, $ano) {        
        $query = $this->db->prepare("SELECT * FROM bonus WHERE DTA LIKE '%{$ano}%' AND TIPO = 'aniversario' AND CODCADASTRO = :CODCADASTRO");
        $query->bindParam(":CODCADASTRO", addslashes($codcadastro), PDO::PARAM_STR, 32);
        
        $query->execute();
        if ( $query->rowCount() ) {
            while ($rows = $query->fetch(PDO::FETCH_OBJ)) {
                return $rows;
            }
        } else {
            return false;
        }        
    }

    public function confere_senha($email, $senha, $papel = null) {

        if ($papel != null) {
            $and = "AND PAPEL=:PAPEL";
        }

        $query = $this->db->prepare("SELECT * FROM conta WHERE EMAIL=:EMAIL AND SENHA=:SENHA {$and}");
        $query->bindParam(":EMAIL", addslashes($email), PDO::PARAM_STR, 70);
        $query->bindParam(":SENHA", addslashes($senha), PDO::PARAM_STR, 32);
        if ($papel != null) {
            $query->bindParam(":PAPEL", $papel, PDO::PARAM_STR, 255);
        }
        $query->execute();
        return $query->rowCount();
    }

    public function testa_status($email, $senha) {
        $query = $this->db->prepare("SELECT * FROM conta WHERE EMAIL=:EMAIL AND SENHA=:SENHA AND STATUS=1");
        $query->bindParam(":EMAIL", addslashes($email), PDO::PARAM_STR, 70);
        $query->bindParam(":SENHA", addslashes($senha), PDO::PARAM_STR, 32);
        $query->execute();
        return $query->rowCount();
    }

    public function get_dados_conta($email) {
        
        $email = addslashes($email);
        $this->_tabela = "conta";
        $where = "EMAIL='{$email}'";
        return $this->read($where);
    }
    
//    public function get_clientes($codcadastro = NULL) {
//        
//        $codcadastro = addslashes($codcadastro);
//        
//        $this->_tabela = "cadastro";
//        if($codcadastro != NULL){
//            $where = "CODCADASTRO='{$codcadastro}'";
//            return $this->read($codcadastro);
//        } else {
//            return $this->read();
//        }
//        
//    }
    
     public function get_clientes($codcadastro = NULL, $search = NULL) {

        $c = new Controller(); 
         
        if( $search != null){
            
            $nome = $search;
            $email = $search;
            $nascimento = $c->formataDataForUSA($search);
            $sexo = $search;
            $ddd = $search;
            $tel = $search;
            $ramal = $search;
            $cpf = $c->limpaCpf($search);
            
            $where = "WHERE cadastro.NOME LIKE '%{$nome}%'
            OR cadastro.EMAIL LIKE '%{$email}%'
            OR cadastro.NASCIMENTO LIKE '%{$nascimento}%'
            OR cadastro.SEXO LIKE '%{$sexo}%'
            OR cadastro.DDD LIKE '%{$ddd}%'
            OR cadastro.TELEFONE LIKE '%{$tel}%'
            OR cadastro.RAMAL LIKE '%{$ramal}%'
            OR cadastro.CPF LIKE '%{$cpf}%'";
            
        } else if ($codcadastro != null) {
            $codcadastro = addslashes($codcadastro);
            $where = "WHERE cadastro.CODCADASTRO='{$codcadastro}'";
        }

        $query = $this->db->query("SELECT cadastro.*, DATE_FORMAT( cadastro.DTA, '%d/%m/%Y - %Hh%i' ) as DTA FROM cadastro
        {$where}
        ORDER BY cadastro.DTA DESC");
        
        $query->execute();
        if ($query->rowCount()) {
            while ($rows = $query->fetch(PDO::FETCH_OBJ)) {
                $rows->CODCADASTRO = strtolower($rows->CODCADASTRO);
                ($rows->NASCIMENTO != "0000-00-00") ? $rows->NASCIMENTO = $c->formataDataForBrazil($rows->NASCIMENTO) : $rows->NASCIMENTO = "";
                ($rows->CPF != "") ? $rows->CPF = $c->formataCpf($rows->CPF) : $rows->CPF;
                
                $obj[] = $rows;
            }
            
            return $obj;
        } else {
            return false;
        }
    }
    
    public function insert_bonus(Array $dados){
        $this->_tabela = "bonus";
        $this->insert($dados);
    }
    
    public function get_aniversariantes($codcadastro = NULL, $search = NULL) {

        $c = new Controller(); 
         
        if( $search != null){
            
            $nome = $search;
            $email = $search;
            $nascimento = $c->formataDataForUSA($search);
            $sexo = $search;
            $ddd = $search;
            $tel = $search;
            $ramal = $search;
            $cpf = $c->limpaCpf($search);
            
            $where = "WHERE cadastro.NASCIMENTO LIKE CONCAT('%', DATE_FORMAT( DATE_ADD(CURRENT_DATE, INTERVAL 2 DAY), '%m-%d' ), '%') AND cadastro.NOME LIKE '%{$nome}%'
            OR cadastro.EMAIL LIKE '%{$email}%'
            OR cadastro.NASCIMENTO LIKE '%{$nascimento}%'
            OR cadastro.SEXO LIKE '%{$sexo}%'
            OR cadastro.DDD LIKE '%{$ddd}%'
            OR cadastro.TELEFONE LIKE '%{$tel}%'
            OR cadastro.RAMAL LIKE '%{$ramal}%'
            OR cadastro.CPF LIKE '%{$cpf}%'";
            
        } else if ($codcadastro != null) {
            $codcadastro = addslashes($codcadastro);
            $where = "WHERE cadastro.NASCIMENTO LIKE CONCAT('%', DATE_FORMAT( DATE_ADD(CURRENT_DATE, INTERVAL 2 DAY), '%m-%d' ), '%') AND cadastro.CODCADASTRO='{$codcadastro}'";
        } else {
            $where = "WHERE cadastro.NASCIMENTO LIKE CONCAT('%', DATE_FORMAT( DATE_ADD(CURRENT_DATE, INTERVAL 2 DAY), '%m-%d' ), '%')";
        }
        
        $query = $this->db->query("SELECT cadastro.*, DATE_FORMAT( cadastro.DTA, '%d/%m/%Y - %Hh%i' ) as DTA FROM cadastro
        {$where}
        ORDER BY cadastro.DTA DESC");
        
        $query->execute();
        if ($query->rowCount()) {
            while ($rows = $query->fetch(PDO::FETCH_OBJ)) {
                $rows->CODCADASTRO = strtolower($rows->CODCADASTRO);
                ($rows->NASCIMENTO != "0000-00-00") ? $rows->NASCIMENTO = $c->formataDataForBrazil($rows->NASCIMENTO) : $rows->NASCIMENTO = "";
                ($rows->CPF != "") ? $rows->CPF = $c->formataCpf($rows->CPF) : $rows->CPF;
                
                $obj[] = $rows;
            }
            
            return $obj;
        } else {
            return false;
        }
    }

    
    public function update_status($key, $status) {
        
        $key = addslashes($key);
        $status = addslashes($status);
        
        $this->_tabela = "cadastro";
        $dados["STATUS"] = $status;
        $where = "CODCADASTRO='{$key}'";
        return $this->update($dados, $where);
    }
    

    public function update_senha($codconta, $senha_nova) {
        
        $codconta = addslashes($codconta);
        $senha_nova = addslashes($senha_nova);
        
        $query = $this->db->prepare("UPDATE conta SET SENHA=:SENHA WHERE CODCONTA=:CODCONTA");
        $query->bindParam(":CODCONTA", $codconta, PDO::PARAM_STR, 32);
        $query->bindParam(":SENHA", $senha_nova, PDO::PARAM_STR, 32);
        $query->execute();
        return true;
    }
  
    /*
      public function existe_iniciais($iniciais) {
      $query = $this->db->prepare("SELECT * FROM conta WHERE ID=:ID");
      $query->bindParam(":ID", $iniciais, PDO::PARAM_STR, 20);
      $query->execute();
      return $query->rowCount();
      }

      public function ja_verificada($codconta) {
      $query = $this->db->prepare("SELECT * FROM conta WHERE CODCONTA=:CODCONTA AND STATUS=1");
      $query->bindParam(":CODCONTA", $codconta, PDO::PARAM_STR, 32);
      $query->execute();
      return $query->rowCount();
      }

      public function verificar_conta($codconta) {
      $query = $this->db->prepare("UPDATE conta SET STATUS=1 WHERE CODCONTA=:CODCONTA");
      $query->bindParam(":CODCONTA", $codconta, PDO::PARAM_STR, 32);
      $query->execute();
      return true;
      }

      public function existe_id($id) {
      $query = $this->db->prepare("SELECT * FROM conta WHERE ID=:ID");
      $query->bindParam(":ID", $id, PDO::PARAM_STR, 20);
      $query->execute();
      return $query->rowCount();
      }

      public function valida_id($id, $password) {
      $query = $this->db->prepare("SELECT * FROM conta WHERE ID=:ID AND PASSWORD=:PASSWORD");
      $query->bindParam(":ID", $id, PDO::PARAM_STR, 20);
      $query->bindParam(":PASSWORD", $password, PDO::PARAM_STR, 32);
      $query->execute();
      return $query->rowCount();
      }

      public function insert_conta(Array $dados) {
      if (sizeof($dados) != 0) {
      $campos = "`" . implode("`,`", array_keys($dados)) . "`";
      $keys = ":" . implode(",:", array_keys($dados));

      $query = $this->db->prepare("INSERT INTO `conta` ({$campos}) VALUES ({$keys});");

      $query->bindParam(":CODCONTA", $dados["CODCONTA"], PDO::PARAM_STR, 32);
      $query->bindParam(":ID", $dados["ID"], PDO::PARAM_STR, 20);
      $query->bindParam(":NOME", $dados["NOME"], PDO::PARAM_STR, 70);
      $query->bindParam(":EMAIL", $dados["EMAIL"], PDO::PARAM_STR, 70);
      $query->bindParam(":CEP", $dados["CEP"], PDO::PARAM_STR, 9);
      $query->bindParam(":LOGRADOURO", $dados["LOGRADOURO"], PDO::PARAM_STR, 20);
      $query->bindParam(":NUMERO", $dados["NUMERO"], PDO::PARAM_STR, 6);
      $query->bindParam(":COMPLEMENTO", $dados["COMPLEMENTO"], PDO::PARAM_STR, 255);
      $query->bindParam(":BAIRRO", $dados["BAIRRO"], PDO::PARAM_STR, 255);
      $query->bindParam(":CIDADE", $dados["CIDADE"], PDO::PARAM_STR, 255);
      $query->bindParam(":UF", $dados["UF"], PDO::PARAM_STR, 2);
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

      public function existe_email($email) {
      $query = $this->db->prepare("SELECT * FROM conta WHERE EMAIL=:EMAIL");
      $query->bindParam(":EMAIL", $email, PDO::PARAM_STR, 20);
      $query->execute();
      return $query->rowCount();
      }

      public function get_email($email) {
      $query = $this->db->prepare("SELECT * FROM conta WHERE EMAIL=:EMAIL");
      $query->bindParam(":EMAIL", $email, PDO::PARAM_STR, 70);
      $query->execute();
      return $query->fetch(PDO::FETCH_OBJ);
      }

      public function get_usuario($codconta) {
      $query = $this->db->prepare("SELECT * FROM conta WHERE CODCONTA=:CODCONTA");
      $query->bindParam(":CODCONTA", $codconta, PDO::PARAM_STR, 32);
      $query->execute();
      return $query->fetch(PDO::FETCH_OBJ);
      }

      public function get_dados_usuario($id){
      $this->_tabela = "conta";
      $where = "ID='{$id}'";
      return $this->read($where);
      }

      public function update_senha($codconta, $senha, $lembrete) {
      $query = $this->db->prepare("UPDATE `conta` SET PASSWORD=:PASSWORD, LEMBRETE=:LEMBRETE WHERE CODCONTA=:CODCONTA");
      $query->bindParam(":PASSWORD", $senha, PDO::PARAM_STR, 32);
      $query->bindParam(":CODCONTA", $codconta, PDO::PARAM_STR, 32);
      $query->bindParam(":LEMBRETE", $lembrete, PDO::PARAM_STR, 255);
      $query->execute();
      return true;
      }
     */
}
