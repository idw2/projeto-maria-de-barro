<?php

class Avaliacao_Model extends Model {

    
    public function existe_avaliacao($codcadastro, $codproduto) {
        $query = $this->db->prepare("SELECT * FROM `avaliacao` WHERE CODCADASTRO=:CODCADASTRO AND CODPRODUTO=:CODPRODUTO;");
        $query->bindParam(":CODCADASTRO", $codcadastro, PDO::PARAM_STR, 32);
        $query->bindParam(":CODPRODUTO", $codproduto, PDO::PARAM_STR, 32);
        $query->execute();
        return $query->rowCount();
    }
    
    public function get_avaliacao($codproduto, $avaliacao = NULL) {
        
        if( $avaliacao != NULL){
            $and = "AVALIACAO=:AVALIACAO AND";
        }
        $query = $this->db->prepare("SELECT * FROM `avaliacao` WHERE {$and} CODPRODUTO=:CODPRODUTO;");
        if( $avaliacao != NULL){
            $query->bindParam(":AVALIACAO", $avaliacao, PDO::PARAM_STR, 40);
        }        
        $query->bindParam(":CODPRODUTO", $codproduto, PDO::PARAM_STR, 32);
        $query->execute();
        return $query->rowCount();
    }
    
    public function insert_avaliacao(Array $dados) {
        
        foreach ($dados as $n => $v) {
            $dados[$n] = addslashes($v);
        }
        
        if (sizeof($dados) != 0) {
            $campos = "`" . implode("`,`", array_keys($dados)) . "`";
            $keys = ":" . implode(",:", array_keys($dados));

            $query = $this->db->prepare("INSERT INTO `avaliacao` ({$campos}) VALUES ({$keys});");

            $query->bindParam(":CODAVALIACAO", $dados["CODAVALIACAO"], PDO::PARAM_STR, 32);
            $query->bindParam(":CODCADASTRO", $dados["CODCADASTRO"], PDO::PARAM_STR, 32);
            $query->bindParam(":CODPRODUTO", $dados["CODPRODUTO"], PDO::PARAM_STR, 32);
            $query->bindParam(":AVALIACAO", $dados["AVALIACAO"], PDO::PARAM_STR, 40);
            
            $query->execute();

            return true;
        } else {
            return false;
        }
    }
//    
//    public function insert_conta(Array $dados) {
//        if (sizeof($dados) != 0) {
//            
//            $campos = "`" . implode("`,`", array_keys($dados)) . "`";
//            $keys = ":" . implode(",:", array_keys($dados));
//
//            $query = $this->db->prepare("INSERT INTO `conta` ({$campos}) VALUES ({$keys});");
//
//            $query->bindParam(":CODCONTA", addslashes($dados["CODCONTA"]), PDO::PARAM_STR, 32);
//            $query->bindParam(":NOME", addslashes($dados["NOME"]), PDO::PARAM_STR, 70);
//            $query->bindParam(":EMAIL", addslashes($dados["EMAIL"]), PDO::PARAM_STR, 70);
//            $query->bindParam(":SEXO", addslashes($dados["SEXO"]), PDO::PARAM_STR, 1);
//            $query->bindParam(":STATUS", addslashes($dados["STATUS"]), PDO::PARAM_STR);
//            $query->bindParam(":PAPEL", addslashes($dados["PAPEL"]), PDO::PARAM_STR, 255);
//            $query->bindParam(":SENHA", addslashes($dados["SENHA"]), PDO::PARAM_STR, 32);
//                        
//            $query->execute();
//
//            return true;
//        } else {
//            return false;
//        }
//    }
//    
//     public function get_atendentes( $email = null ){
//         
//        if($email != null){
//            $email = addslashes($email);
//            $and = "AND EMAIL='{$email}'";
//        } 
//        
//        $query = $this->db->query("SELECT conta.*, DATE_FORMAT( conta.DTA,  '%d/%m/%Y - %Hh%i' ) AS DTA FROM conta WHERE conta.PAPEL NOT IN('ADMINISTRADOR') {$and};");
//        $query->execute(); 
//        
//        if( $query->rowCount() ){
//            while ($rows = $query->fetch(PDO::FETCH_OBJ)) {
//                $rows->NOME = utf8_decode($rows->NOME);
//                $dados[] = $rows;
//            }
//            return $dados;
//        } else {
//            return false;
//        }
//    }
//    
//    public function update_status_conta($email, $status){
//        
//        $mail = addslashes($email);
//        $status = addslashes($status);
//        
//        $this->_tabela = "conta";
//        $where = "EMAIL='{$email}'";
//        $dados["STATUS"] = $status; 
//        return $this->update($dados, $where);
//    }
//    
//    public function update_status_online($email, $status){
//        
//        $mail = addslashes($email);
//        $status = addslashes($status);
//        
//        $this->_tabela = "conta";
//        $where = "EMAIL='{$email}'";
//        $dados["ON_LINE"] = $status; 
//        return $this->update($dados, $where);
//    }
//    
//    public function del_conta($email) {
//        
//        $mail = addslashes($email);
//                
//        $this->_tabela = "conta";
//        $where = "EMAIL='{$email}'";
//        return $this->delete($where);
//    }
//    
//    public function get_conta($email) {
//        
//        $mail = addslashes($email);
//        
//        $q = $this->db->query("SELECT * FROM conta WHERE EMAIL='{$email}'");
//        if ($q->rowCount()) {
//            while ($row = $q->fetch(PDO::FETCH_OBJ)) {
//                foreach ($row as $name => $value) {
//                    $row->$name = utf8_decode($value);
//                    return $row;
//                }
//            }            
//        } else {
//            return false;
//        }
//    }
//    
//    public function update_conta(Array $dados, $email) {
//        
//        $mail = addslashes($email);
//        
//        foreach ( $dados as $n => $v ){
//            $dados[$n] = addslashes($v);
//        }
//        
//        $this->_tabela = "conta";
//        $where = "EMAIL='{$email}'";
//        return $this->update($dados, $where);
//        
//        
//    }
    
}
