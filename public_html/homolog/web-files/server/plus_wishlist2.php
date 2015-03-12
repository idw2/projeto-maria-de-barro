<?php

require("../../system/model.php");

Class QuerysReload extends Model {

    public function formataReais($valorReal) {
        $size = strlen($valorReal);
        $result = null;
        if ($size >= 9) {
            //9.999.999,99                                                                         
            if ($size == 9) {
                $p1 = substr($valorReal, -2);
                $p2 = substr($valorReal, -5, 3);
                $p3 = substr($valorReal, -8, 3);
                $p4 = substr($valorReal, -9, 1);
                $result = $p4 . "." . $p3 . "." . $p2 . "," . $p1;
            } elseif ($size == 10) {
                $p1 = substr($valorReal, -2);
                $p2 = substr($valorReal, -5, 3);
                $p3 = substr($valorReal, -8, 3);
                $p4 = substr($valorReal, -10, 2);
                $result = $p4 . "." . $p3 . "." . $p2 . "," . $p1;
            } elseif ($size == 11) {
                $p1 = substr($valorReal, -2);
                $p2 = substr($valorReal, -5, 3);
                $p3 = substr($valorReal, -8, 3);
                $p4 = substr($valorReal, -11, 3);
                $result = $p4 . "." . $p3 . "." . $p2 . "," . $p1;
            }
            return $result;
        } elseif ($size == 8) {
            //999.999,99                                                                           
            $p1 = substr($valorReal, -2);
            $p2 = substr($valorReal, -5, 3);
            $p3 = substr($valorReal, -8, 3);
            $result = $p3 . "." . $p2 . "," . $p1;
            return $result;
        } elseif ($size == 7) {
            //99.999,99                                                                            
            $p1 = substr($valorReal, -2);
            $p2 = substr($valorReal, -5, 3);
            $p3 = substr($valorReal, -7, 2);
            $result = $p3 . "." . $p2 . "," . $p1;
            return $result;
        } elseif ($size == 6) {
            //9.999,99                                                                             
            $p1 = substr($valorReal, -2);
            $p2 = substr($valorReal, -5, 3);
            $p3 = substr($valorReal, -6, 1);
            $result = $p3 . "." . $p2 . "," . $p1;
            return $result;
        } elseif ($size == 5) {
            //999,99                                                                               
            $p1 = substr($valorReal, -2);
            $p2 = substr($valorReal, -5, 3);
            $result = $p2 . "," . $p1;
            return $result;
        } elseif ($size == 4) {
            //99,99                                                                                
            $p1 = substr($valorReal, -2);
            $p2 = substr($valorReal, -4, 2);
            $result = $p2 . "," . $p1;
            return $result;
        } elseif ($size == 3) {
            //9,99                                                                                 
            $p1 = substr($valorReal, -2);
            $p2 = substr($valorReal, -3, 1);
            $result = $p2 . "," . $p1;
            return $result;
        } elseif ($size == 2) {
            //0,99                                                                                 
            $p1 = substr($valorReal, -2);
            $result = "0," . $p1;
            return $result;
        }

        return false;
    }
    
    public function qnts_de_produtos($client_hidden, $codproduto) {
        $query = $this->db->prepare("SELECT SUM(QUANTIDADE) as QUANTIDADE  FROM `lista_desejos` WHERE CODPRODUTO='{$codproduto}' AND CLIENT_HIDDEN='{$client_hidden}'");
        $query->execute();
        if( $query->rowCount() ){
            while ($rows = $query->fetch(PDO::FETCH_OBJ)) {
                return $rows->QUANTIDADE;
            }            
        } else {
            return 0;
        }
    }
    
    public function del_row_wishlist($codproduto, $client_hidden) {
        $this->_tabela = "lista_desejos";
        $where = "CLIENT_HIDDEN='{$client_hidden}' AND CODPRODUTO='{$codproduto}'";
        return $this->delete($where);
    }
    
    public function add_lista_desejos($dados) {
        $this->_tabela = "lista_desejos";
        return $this->insert($dados);
    }
    
    public function get_peso($codproduto, $client_hidden) {
        
        $query = $this->db->query("SELECT 
            produtos.PESO*SUM(lista_desejos.QUANTIDADE) as PESO_TOTAL 
        FROM produtos
        INNER JOIN lista_desejos ON lista_desejos.CODPRODUTO=produtos.CODPRODUTO
        WHERE lista_desejos.CLIENT_HIDDEN='{$client_hidden}' 
        AND lista_desejos.CODPRODUTO='{$codproduto}'");
      
        $query->execute(); 
        
        if( $query->rowCount() ){
            while ($rows = $query->fetch(PDO::FETCH_OBJ)) {
                return $rows->PESO_TOTAL;
            }
        } else {
            return false;
        }
    }
    
    public function get_peso_total($client_hidden) {
        
        $query = $this->db->query("SELECT 
            produtos.PESO*SUM(lista_desejos.QUANTIDADE) as PESO_TOTAL 
        FROM produtos
        INNER JOIN lista_desejos ON lista_desejos.CODPRODUTO=produtos.CODPRODUTO
        WHERE lista_desejos.CLIENT_HIDDEN='{$client_hidden}'");
      
        $query->execute(); 
        
        if( $query->rowCount() ){
            while ($rows = $query->fetch(PDO::FETCH_OBJ)) {
                return $rows->PESO_TOTAL;
            }
        } else {
            return false;
        }
    }
    
    public function get_total($codproduto, $client_hidden) {
        
        $query = $this->db->query("SELECT 
            produtos.PRECO*SUM(lista_desejos.QUANTIDADE) as TOTAL 
        FROM produtos
        INNER JOIN lista_desejos ON lista_desejos.CODPRODUTO=produtos.CODPRODUTO
        WHERE lista_desejos.CLIENT_HIDDEN='{$client_hidden}' 
        AND lista_desejos.CODPRODUTO='{$codproduto}'");
        $query->execute(); 
        
        if( $query->rowCount() ){
            while ($rows = $query->fetch(PDO::FETCH_OBJ)) {
                return $rows->TOTAL = $this->formataReais($rows->TOTAL);
            }
        } else {
            return false;
        }
    }
    
    public function get_total_geral($client_hidden) {
        
        $query = $this->db->query("SELECT SUM(produtos.PRECO*lista_desejos.QUANTIDADE) as TOTAL FROM lista_desejos
INNER JOIN produtos ON produtos.CODPRODUTO=lista_desejos.CODPRODUTO
WHERE lista_desejos.CLIENT_HIDDEN='{$client_hidden}'");
        
        $query->execute(); 
        
        if( $query->rowCount() ){
            while ($rows = $query->fetch(PDO::FETCH_OBJ)) {
                return $rows->TOTAL = $this->formataReais($rows->TOTAL);
            }
        } else {
            return false;
        }
    }
    
     public function get_itens($client_hidden) {
        
        $query = $this->db->query("SELECT SUM(QUANTIDADE) as QUANTIDADE FROM lista_desejos
        WHERE CLIENT_HIDDEN='{$client_hidden}'");
        $query->execute();         
        if( $query->rowCount() ){
            while ($rows = $query->fetch(PDO::FETCH_OBJ)) {
                return $rows->QUANTIDADE;
            }
        } else {
            return false;
        }
    }
    
    public function calcula_imposto($percentual, $sobre_valor) {
        $query = $this->db->query("SELECT SUM(ROUND({$sobre_valor}/{$percentual})-{$sobre_valor}) AS IMPOSTO;");
        $query->execute(); 
        if( $query->rowCount() ){
            while ($rows = $query->fetch(PDO::FETCH_OBJ)) {
                $rows->IMPOSTO = $this->formataReais($rows->IMPOSTO);
                return $rows->IMPOSTO;
            }            
        } else {
            return false;
        }
        
    }
    
    public function get_drop_lista_desejos($codproduto, $client_hidden) {
        
        $query = $this->db->query("SELECT 
	produtos.CODPRODUTO, 
	produtos.NOME, 
	produtos.PESO, 
	produtos.CATEGORIA as CATEG, 
	(produtos.PESO*SUM(lista_desejos.QUANTIDADE)) as PESO_TOTAL, 
	CASE produtos.CATEGORIA 
	WHEN 'aneis' THEN 'Anéis'
	WHEN 'brincos' THEN 'Brinco'
	WHEN 'colares' THEN 'Colares'
	ELSE 'Pulseiras' 
	END AS CATEGORIA, 
	produtos.PRECO, 
	produtos.REFERENCIA, 
	lista_desejos.CODLISTADESEJOS, 
	(produtos.PRECO*SUM(lista_desejos.QUANTIDADE)) as TOTAL, 
	SUM(lista_desejos.QUANTIDADE) as QUANTIDADE 
FROM produtos
INNER JOIN lista_desejos ON lista_desejos.CODPRODUTO=produtos.CODPRODUTO
WHERE lista_desejos.CODPRODUTO='{$codproduto}' 
AND lista_desejos.CLIENT_HIDDEN='{$client_hidden}' 
GROUP BY produtos.CODPRODUTO
ORDER BY (produtos.NOME) ASC");
        
        $query->execute(); 
        
        if( $query->rowCount() ){
            while ($rows = $query->fetch(PDO::FETCH_OBJ)) {
                $rows->NOME = strtoupper(utf8_decode($rows->NOME));
                $rows->PRECO_UNITARIO = $rows->PRECO;
                $rows->PRECO = $this->formataReais($rows->PRECO);
                $rows->TOTAL = $this->formataReais($rows->TOTAL);
                return $rows;
            }
            //return $dados;
        } else {
            return false;
        }
    }

}

$model = new QuerysReload();
  
$client_hidden = $_POST["CLIENT_HIDDEN"];
$codproduto = $_POST["CODPRODUTO"];
$comando = $_POST["COMANDO"];
$codlistaprodutos = $_POST["CODLISTADESEJOS"];

$qntdd = $model->qnts_de_produtos($client_hidden, $codproduto);

if( $comando == "mais" ){
    (int)$qntdd = ((int)$qntdd+1);
} else if( (int)$qntdd > 0 && $comando == "menos" ){
    (int)$qntdd = ((int)$qntdd-1);
} 

$model->del_row_wishlist($codproduto, $client_hidden);

( $qntdd > 0 ) ? $qntdd : $qntdd = 1;

$dados["CODLISTADESEJOS"] = strtoupper(md5(uniqid(rand(), true)));
$dados["CLIENT_HIDDEN"] = $client_hidden;
$dados["CODPRODUTO"] = $codproduto;
$dados["QUANTIDADE"] = $qntdd;

$model->add_lista_desejos($dados);    

echo $return["itens"] = $model->get_itens($client_hidden);    
die();


