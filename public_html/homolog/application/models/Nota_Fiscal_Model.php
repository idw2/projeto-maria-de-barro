<?php

class Nota_Fiscal_Model extends Model {

    public function get_cadastro() {
        $query = $this->db->query("SELECT 
	cadastro.CODCADASTRO,
	cadastro.NOME,
	cadastro.CPF,
	cadastro.EMAIL,
	REPLACE(enderecos.CEP, '-', '') as CEP,
	REPLACE(enderecos.UF, ',', ' ') as ESTADO,
	REPLACE(enderecos.CIDADE, ',', ' ') as CIDADE,
	REPLACE(enderecos.LOGRADOURO, ',', ' ') as ENDERECO,
	REPLACE(enderecos.BAIRRO, ',', ' ') as BAIRRO,
	enderecos.NUMERO,
	REPLACE(enderecos.COMPLEMENTO, ',', ' ') as COMPLEMENTO,
	CONCAT(  '(',cadastro.DDD,')',cadastro.TELEFONE, IF( cadastro.RAMAL != '', concat(' - Ramal: ', cadastro.RAMAL), cadastro.RAMAL) ) as TELEFONE,
	DATE_FORMAT( cadastro.NASCIMENTO ,  '%d/%m/%Y' ) as NASCIMENTO
FROM 
	cadastro
INNER JOIN cadastro_rel_enderecos ON cadastro_rel_enderecos.CODCADASTRO=cadastro.CODCADASTRO
INNER JOIN enderecos ON cadastro_rel_enderecos.CODENDERECO=enderecos.CODENDERECO
WHERE cadastro.STATUS=1
AND enderecos.STATUS=1
AND WAS_EXPORTED='nao'
GROUP BY cadastro.CODCADASTRO");
        $query->execute();
        if ($query->rowCount()) {
            $c = new Controller();
            while ($rows = $query->fetch(PDO::FETCH_OBJ)) {
                $obj[] = $rows;
            }
            return $obj;
        } else {
            return false;
        }
    }

    public function get_produto() {
        $query = $this->db->query("SELECT 
	produtos.CODPRODUTO,
	produtos.REFERENCIA as CODIGO,
	produtos.QUANTIDADE,
	REPLACE(produtos.NOME, ',', ' ') as DESCRICAO,
	produtos.PRECO_COMPRA,
	produtos.PRECO as PRECO_VENDA,
	CASE produtos.CATEGORIA 
	WHEN 'aneis' THEN 'Anéis'
	WHEN 'brincos' THEN 'Brinco'
	WHEN 'colares' THEN 'Colares'
	WHEN 'conjuntos' THEN 'Conjuntos'
	ELSE 'Pulseiras' END AS CATEGORIA,
	produtos.PESO
FROM produtos
WHERE produtos.WAS_EXPORTED='nao'
GROUP BY produtos.CODPRODUTO 
ORDER BY produtos.REFERENCIA ASC");
        $query->execute();
        if ($query->rowCount()) {
            $c = new Controller();
            while ($rows = $query->fetch(PDO::FETCH_OBJ)) {
                $obj[] = $rows;
            }
            $rows->DESCRICAO = utf8_decode($rows->DESCRICAO);
            $rows->CATEGORIA = utf8_decode($rows->CATEGORIA);
            return $obj;
        } else {
            return false;
        }
    }

    public function num_get_cadastro() {
        $query = $this->db->query("SELECT 
	cadastro.CODCADASTRO,
	cadastro.NOME,
	cadastro.CPF,
	cadastro.EMAIL,
	REPLACE(enderecos.CEP, '-', '') as CEP,
	REPLACE(enderecos.UF, ',', ' ') as ESTADO,
	REPLACE(enderecos.CIDADE, ',', ' ') as CIDADE,
	REPLACE(enderecos.LOGRADOURO, ',', ' ') as ENDERECO,
	REPLACE(enderecos.BAIRRO, ',', ' ') as BAIRRO,
	enderecos.NUMERO,
	REPLACE(enderecos.COMPLEMENTO, ',', ' ') as COMPLEMENTO,
	CONCAT(  '(',cadastro.DDD,')',cadastro.TELEFONE, IF( cadastro.RAMAL != '', concat(' - Ramal: ', cadastro.RAMAL), cadastro.RAMAL) ) as TELEFONE,
	DATE_FORMAT( cadastro.NASCIMENTO ,  '%d/%m/%Y' ) as NASCIMENTO
FROM 
	cadastro
INNER JOIN cadastro_rel_enderecos ON cadastro_rel_enderecos.CODCADASTRO=cadastro.CODCADASTRO
INNER JOIN enderecos ON cadastro_rel_enderecos.CODENDERECO=enderecos.CODENDERECO
WHERE cadastro.STATUS=1
AND enderecos.STATUS=1
AND WAS_EXPORTED='nao'
GROUP BY cadastro.CODCADASTRO");
        return $query->rowCount();
    }

    public function num_get_produto() {
        $query = $this->db->query("SELECT 
	produtos.CODPRODUTO,
	produtos.REFERENCIA as CODIGO,
	produtos.QUANTIDADE,
	REPLACE(produtos.NOME, ',', ' ') as DESCRICAO,
	produtos.PRECO_COMPRA,
	produtos.PRECO as PRECO_VENDA,
	CASE produtos.CATEGORIA 
	WHEN 'aneis' THEN 'Anéis'
	WHEN 'brincos' THEN 'Brinco'
	WHEN 'colares' THEN 'Colares'
	WHEN 'conjuntos' THEN 'Conjuntos'
	ELSE 'Pulseiras' END AS CATEGORIA,
	produtos.PESO
FROM produtos
WHERE produtos.WAS_EXPORTED='nao'
GROUP BY produtos.CODPRODUTO
ORDER BY produtos.REFERENCIA ASC");
        return $query->rowCount();
    }

    public function insert_csv(Array $dados) {

        foreach ($dados as $n => $v) {
            $dados[$n] = addslashes($v);
        }

        $this->_tabela = "csv";
        return $this->insert($dados);
    }

    public function get_cliente_csv() {
        $query = $this->db->query("SELECT csv.*, DATE_FORMAT( csv.DTA,  '%d/%m/%Y - %Hh%i' ) AS DTA  FROM `csv` ORDER BY csv.DTA DESC");
        $query->execute();
        if ($query->rowCount()) {
            while ($rows = $query->fetch(PDO::FETCH_OBJ)) {

                if (strlen(WEB_FILES) > 0) {
                    $rows->LINK = PROTOCOLO . DOMINIO_COOKIES . WEB_FILES . str_replace("/web-files", "", $rows->LINK);
                }
                $rows->DESCRICAO = utf8_decode($rows->DESCRICAO);
                $rows->CATEGORIA = utf8_decode($rows->CATEGORIA);
                $obj[] = $rows;
            }
            return $obj;
        } else {
            return false;
        }
    }

}
