<?php

class Pedido_Model extends Model {

    public function pedido_finalizado($codpedido, $codcadastro) {

        $codpedido = addslashes($codpedido);
        $codcadastro = addslashes($codcadastro);

        $query = $this->db->prepare("SELECT * FROM `pedidos` WHERE CODPEDIDO=:CODPEDIDO AND CODCADASTRO=:CODCADASTRO AND STATUS=1");
        $query->bindParam(":CODPEDIDO", $codpedido, PDO::PARAM_STR, 32);
        $query->bindParam(":CODCADASTRO", $codcadastro, PDO::PARAM_STR, 32);
        $query->execute();
        return $query->rowCount();
    }

    public function get_forma_pgto_pedido($codpedido, $codcadastro) {

        $codpedido = addslashes($codpedido);
        $codcadastro = addslashes($codcadastro);

        $query = $this->db->prepare("SELECT * FROM `pedidos` WHERE CODPEDIDO=:CODPEDIDO AND CODCADASTRO=:CODCADASTRO");
        $query->bindParam(":CODPEDIDO", $codpedido, PDO::PARAM_STR, 32);
        $query->bindParam(":CODCADASTRO", $codcadastro, PDO::PARAM_STR, 32);
        $query->execute();
        if ($query->rowCount()) {
            while ($rows = $query->fetch(PDO::FETCH_OBJ)) {
                return $rows->FORMA_PGTO;
            }
        } else {
            return false;
        }
    }

    public function get_pedido($codpedido, $codcadastro) {

        $codpedido = addslashes($codpedido);
        $codcadastro = addslashes($codcadastro);

        $query = $this->db->prepare("SELECT
            pedidos.CODPEDIDO,
            pedidos.CODCADASTRO,
            pedidos.N_PEDIDO,
            pedidos.DTA,
            pedidos.FORMA_ENVIO,
            pedidos.NOSSO_NUMERO,
            pedidos.FORMA_PGTO,
            pedidos.TAXA_ENTREGA,
            SUM( pedidos.TOTAL_GERAL - pedidos.DESCONTO) as TOTAL_GERAL,
            SUM( pedidos.TOTAL_GERAL - pedidos.TAXA_ENTREGA)  as TOTAL_COMPRA,
            pedidos.DESCONTO,
            pedidos.CUPOM,
            pedidos.IMPOSTOS,
            pedidos.TOTAL_PARCIAL,
            pedidos.FRETE_GRATIS,
            pedidos.EMBALAR_PRESENTE,
            pedidos.STATUS
            FROM `pedidos` WHERE CODPEDIDO=:CODPEDIDO AND CODCADASTRO=:CODCADASTRO");
        $query->bindParam(":CODPEDIDO", $codpedido, PDO::PARAM_STR, 32);
        $query->bindParam(":CODCADASTRO", $codcadastro, PDO::PARAM_STR, 32);
        $query->execute();
        if ($query->rowCount()) {
            $c = new Controller();
            while ($rows = $query->fetch(PDO::FETCH_OBJ)) {
                $rows->CODPEDIDO = strtolower($rows->CODPEDIDO);
                $rows->CODCADASTRO = strtolower($rows->CODCADASTRO);
                $rows->N_PEDIDO = $c->formataCodigopedido($rows->N_PEDIDO);
                $rows->TAXA_ENTREGA = $c->formataReais($rows->TAXA_ENTREGA);
                $rows->TOTAL_PARCIAL = $c->formataReais($rows->TOTAL_PARCIAL);
                $rows->TOTAL_COMPRA = $c->formataReais($rows->TOTAL_COMPRA);
                $rows->IMPOSTOS = $c->formataReais($rows->IMPOSTOS);
                $rows->DESCONTO = $c->formataReais($rows->DESCONTO);
                $rows->TOTAL_MOIP = $rows->TOTAL_GERAL;
                $rows->TOTAL_PAYPAL = str_replace(".", "", $c->formataReais($rows->TOTAL_GERAL));
                $rows->TOTAL_PAYPAL = str_replace(",", ".", $rows->TOTAL_PAYPAL);
                $rows->TOTAL_GERAL = $c->formataReais($rows->TOTAL_GERAL);
                return $rows;
            }
        } else {
            return false;
        }
    }

    public function get_lista_pedidos($codcadastro = NULL) {

        if ($codcadastro != null) {

            $codcadastro = addslashes($codcadastro);
            $where = "WHERE cadastro.CODCADASTRO='{$codcadastro}'";
        }

        $query = $this->db->query("SELECT pedidos.*, cadastro.NOME, DATE_FORMAT( pedidos.DTA, '%d/%m/%Y - %Hh%i' ) as DTA FROM pedidos
        INNER JOIN cadastro ON cadastro.CODCADASTRO=pedidos.CODCADASTRO
        {$where}
        ORDER BY pedidos.DTA DESC");
        $query->execute();
        if ($query->rowCount()) {
            $c = new Controller();
            while ($rows = $query->fetch(PDO::FETCH_OBJ)) {
                $rows->CODPEDIDO = strtolower($rows->CODPEDIDO);
                $rows->TAXA_ENTREGA = $c->formataReais($rows->TAXA_ENTREGA);
                $rows->TOTAL_GERAL = $c->formataReais($rows->TOTAL_GERAL);
                $rows->TOTAL_PARCIAL = $c->formataReais($rows->TOTAL_PARCIAL);
                $rows->IMPOSTOS = $c->formataReais($rows->IMPOSTOS);
                $rows->N_PEDIDO = $c->formataCodigopedido($rows->N_PEDIDO);
                $rows->NOME = utf8_encode($rows->NOME);
                $obj[] = $rows;
            }
            return $obj;
        } else {
            return false;
        }
    }

    public function update_status_pedido($codpedido, $status) {

        $codpedido = addslashes($codpedido);
        $status = addslashes($status);

        $this->_tabela = "pedidos";
        $dados["STATUS"] = $status;
        $where = "CODPEDIDO='{$codpedido}'";
        return $this->update($dados, $where);
    }
    
    public function update_produtos_return_qntdd($codproduto, $quantidade) {
        $query = $this->db->query("UPDATE produtos SET QUANTIDADE = (QUANTIDADE + {$quantidade}) WHERE CODPRODUTO='{$codproduto}'");
        return true;
    }
    
    public function get_compras_return_produtos($codpedido) {
        $query = $this->db->query("SELECT * FROM compras WHERE CODPEDIDO='{$codpedido}'");
        $query->execute();

        if ($query->rowCount()) {
            while ($rows = $query->fetch(PDO::FETCH_OBJ)) {
                $dados[] = $rows;
            }
            return $dados;
        } else {
            return false;
        }
    }

    public function get_lista_pedidos_search($search, $codcadastro = NULL) {

        $c = new Controller();


        $search = addslashes($search);

        $nome = $search;
        $dta = $c->formataDataForUSA($search);
        $n_pedido = $c->limpaCodigopedido($search);
        $forma_pgto = $search;
        $taxa_entrega = $c->limpaValorReal($search);
        $total_geral = $c->limpaValorReal($search);
        $total_parcial = $c->limpaValorReal($search);
        $nosso_numero = $search;

        if ($codcadastro != null) {

            $codcadastro = addslashes($codcadastro);
            $and = "cadastro.CODCADASTRO='{$codcadastro}' AND ";
        }

        $query = $this->db->query("SELECT pedidos.*, cadastro.NOME, DATE_FORMAT( pedidos.DTA, '%d/%m/%Y - %Hh%i' ) as DTA FROM pedidos
        INNER JOIN cadastro ON cadastro.CODCADASTRO=pedidos.CODCADASTRO
        WHERE {$and} cadastro.NOME LIKE '%{$nome}%'
        OR pedidos.DTA LIKE '%{$dta}%'
        OR pedidos.N_PEDIDO LIKE '%{$n_pedido}%'
        OR pedidos.FORMA_PGTO LIKE '%{$forma_pgto}%'
        OR pedidos.TAXA_ENTREGA LIKE '%{$taxa_entrega}%'
        OR pedidos.TOTAL_GERAL LIKE '%{$total_geral}%'
        OR pedidos.TOTAL_PARCIAL LIKE '%{$total_parcial}%'
        OR pedidos.NOSSO_NUMERO LIKE '%{$nosso_numero}%'
        ORDER BY pedidos.DTA DESC");
        $query->execute();

        if ($query->rowCount()) {
            $c = new Controller();
            while ($rows = $query->fetch(PDO::FETCH_OBJ)) {
                $rows->CODPEDIDO = strtolower($rows->CODPEDIDO);
                $rows->TAXA_ENTREGA = $c->formataReais($rows->TAXA_ENTREGA);
                $rows->TOTAL_GERAL = $c->formataReais($rows->TOTAL_GERAL);
                $rows->TOTAL_PARCIAL = $c->formataReais($rows->TOTAL_PARCIAL);
                $rows->N_PEDIDO = $c->formataCodigopedido($rows->N_PEDIDO);
                $obj[] = $rows;
            }
            return $obj;
        } else {
            return false;
        }
    }

    public function get_compras($codpedido) {
        
        $codpedido = addslashes($codpedido);
        
        $query = $this->db->query("SELECT * FROM compras WHERE CODPEDIDO='{$codpedido}' ORDER BY DTA ASC");
        $query->execute();
        if ($query->rowCount()) {
            $c = new Controller();
            while ($rows = $query->fetch(PDO::FETCH_OBJ)) {
                $rows->CODPEDIDO = strtolower($rows->CODPEDIDO);
                $rows->PRECO = $c->formataReais($rows->PRECO);
                $rows->TOTAL = $c->formataReais($rows->TOTAL);
                $rows->NOME = utf8_encode($rows->NOME);
                $rows->CATEGORIA = utf8_encode($rows->CATEGORIA);
                if (strlen(WEB_FILES) > 0) {
                    $rows->FOTO = WEB_FILES . str_replace("/web-files", "", $rows->FOTO);
                }
                $obj[] = $rows;
            }
            return $obj;
        } else {
            return false;
        }
    }
    
    
    public function get_compras_all() {
        $query = $this->db->query("SELECT * FROM compras ORDER BY DTA ASC");
        $query->execute();
        if ($query->rowCount()) {
            $c = new Controller();
            while ($rows = $query->fetch(PDO::FETCH_OBJ)) {
                $rows->CODPEDIDO = strtolower($rows->CODPEDIDO);
                $rows->PRECO = $c->formataReais($rows->PRECO);
                $rows->TOTAL = $c->formataReais($rows->TOTAL);
                $rows->NOME = utf8_encode($rows->NOME);
                $rows->CATEGORIA = utf8_encode($rows->CATEGORIA);
                if (strlen(WEB_FILES) > 0) {
                    $rows->FOTO = WEB_FILES . str_replace("/web-files", "", $rows->FOTO);
                }
                $obj[] = $rows;
            }
            return $obj;
        } else {
            return false;
        }
    }
    
    public function delete_pedido($codpedido) {
        $query = $this->db->query("DELETE pedidos, pedidos_rel_enderecos, compras FROM 
pedidos
INNER JOIN pedidos_rel_enderecos ON pedidos_rel_enderecos.CODPEDIDO=pedidos.CODPEDIDO
LEFT JOIN compras ON compras.CODPEDIDO=pedidos.CODPEDIDO
WHERE pedidos.CODPEDIDO='{$codpedido}'");
        $query->execute();
        return true;
    }

    public function get_cadastro_for_pedido($codpedido) {
        
        $codpedido = addslashes($codpedido);
        
        $query = $this->db->query("SELECT cadastro.* FROM cadastro
        INNER JOIN pedidos ON pedidos.CODCADASTRO=cadastro.CODCADASTRO
        WHERE pedidos.CODPEDIDO='{$codpedido}'");
        $query->execute();
        if ($query->rowCount()) {
            $c = new Controller();
            while ($rows = $query->fetch(PDO::FETCH_OBJ)) {
                $rows->NOME = utf8_encode($rows->NOME);
                $rows->NASCIMENTO = $c->formataDataForBrazil($rows->NASCIMENTO);
                $obj[] = $rows;
            }
            return $obj;
        } else {
            return false;
        }
    }

    public function get_endereco_entrega($codpedido) {
        
        $codpedido = addslashes($codpedido);
        
        $query = $this->db->query("SELECT enderecos.* FROM enderecos
        INNER JOIN pedidos_rel_enderecos ON pedidos_rel_enderecos.CODENDERECO=enderecos.CODENDERECO
        WHERE pedidos_rel_enderecos.CODPEDIDO='{$codpedido}'");
        $query->execute();
        if ($query->rowCount()) {
            $c = new Controller();
            while ($rows = $query->fetch(PDO::FETCH_OBJ)) {
                $rows->LOGRADOURO = utf8_encode($rows->LOGRADOURO);
                $rows->CIDADE = utf8_encode($rows->CIDADE);
                $rows->BAIRRO = utf8_encode($rows->BAIRRO);
                $rows->COMPLEMENTO = utf8_encode($rows->COMPLEMENTO);
                $obj[] = $rows;
            }
            return $obj;
        } else {
            return false;
        }
    }

    public function get_endereco_entrega_uniq($codpedido) {
        
        $codpedido = addslashes($codpedido);
        
        $query = $this->db->query("SELECT enderecos.* FROM enderecos
        INNER JOIN pedidos_rel_enderecos ON pedidos_rel_enderecos.CODENDERECO=enderecos.CODENDERECO
        WHERE pedidos_rel_enderecos.CODPEDIDO='{$codpedido}'");
        $query->execute();
        if ($query->rowCount()) {
            $c = new Controller();
            while ($rows = $query->fetch(PDO::FETCH_OBJ)) {
                $rows->LOGRADOURO = utf8_encode($rows->LOGRADOURO);
                $rows->CIDADE = utf8_encode($rows->CIDADE);
                $rows->BAIRRO = utf8_encode($rows->BAIRRO);
                $rows->LOGRADOURO = utf8_encode($rows->LOGRADOURO);
                return $rows;
            }
        } else {
            return false;
        }
    }

    public function insert_anotacao(Array $dados) {
        
        foreach ($dados as $n => $v) {
            $dados[$n] = addslashes($v);
        }
        
        $this->_tabela = "anotacoes";
        return $this->insert($dados);
    }

    public function insert_boletos(Array $dados) {
        
        foreach ($dados as $n => $v) {
            $dados[$n] = addslashes($v);
        }
        
        $this->_tabela = "boletos";
        if ($dados["CODPEDIDO"] != "IMAGENS") {
            return $this->insert($dados);
        }
    }

    public function update_nosso_numero(Array $dados, $codpedido) {
        
        foreach ($dados as $n => $v) {
            $dados[$n] = addslashes($v);
        }
        $codpedido = addslashes($codpedido);
        
        $this->_tabela = "pedidos";
        $where = "CODPEDIDO='{$codpedido}'";
        if ($dados["NOSSO_NUMERO"] != "IMAGENS") {
            return $this->update($dados, $where);
        }
    }

    public function update_tid(Array $dados, $codpedido) {
        
        foreach ($dados as $n => $v) {
            $dados[$n] = addslashes($v);
        }
        $codpedido = addslashes($codpedido);
        
        $this->_tabela = "pedidos";
        $where = "CODPEDIDO='{$codpedido}'";
        if ($dados["TID"] != "IMAGENS") {
            return $this->update($dados, $where);
        }
    }

    public function insert_pedidos_rel_anotacao(Array $dados) {
        
        foreach ($dados as $n => $v) {
            $dados[$n] = addslashes($v);
        }
        
        $this->_tabela = "pedidos_rel_anotacoes";
        return $this->insert($dados);
    }

    public function get_anotacao_pedido($codpedido) {
        
        $codpedido = addslashes($codpedido);
        
        $query = $this->db->query("SELECT anotacoes.* FROM anotacoes
        INNER JOIN pedidos_rel_anotacoes ON pedidos_rel_anotacoes.CODANOTACAO=anotacoes.CODANOTACAO
        WHERE pedidos_rel_anotacoes.CODPEDIDO='{$codpedido}'
        ORDER BY anotacoes.DTA DESC");

        $query->execute();
        if ($query->rowCount()) {
            $c = new Controller();
            while ($rows = $query->fetch(PDO::FETCH_OBJ)) {
                $rows->STATUS = utf8_encode($rows->STATUS);
                $rows->APONTAMENTO = utf8_encode($rows->APONTAMENTO);
                $obj[] = $rows;
            }
            return $obj;
        } else {
            return false;
        }
    }

    public function get_bonus($cupom) {
        
        $cupom = addslashes($cupom);
        
        $query = $this->db->query("SELECT * FROM bonus WHERE CODIGO='{$cupom}'");

        $query->execute();
        if ($query->rowCount()) {
            $c = new Controller();
            while ($rows = $query->fetch(PDO::FETCH_OBJ)) {
                $rows->VALOR = $c->formataReais($rows->VALOR);
                return $rows;
            }
        } else {
            return false;
        }
    }

    public function get_pedidos_endereco_entrega() {
        $query = $this->db->query("SELECT
            CASE LENGTH(pedidos.N_PEDIDO)  
                WHEN 1 THEN CONCAT( '000000000', pedidos.N_PEDIDO )
                WHEN 2 THEN CONCAT( '00000000', pedidos.N_PEDIDO )
                WHEN 3 THEN CONCAT( '0000000', pedidos.N_PEDIDO )
                WHEN 4 THEN CONCAT( '000000', pedidos.N_PEDIDO )
                WHEN 5 THEN CONCAT( '00000', pedidos.N_PEDIDO )
                WHEN 6 THEN CONCAT( '0000', pedidos.N_PEDIDO )
                WHEN 7 THEN CONCAT( '000', pedidos.N_PEDIDO )
                WHEN 8 THEN CONCAT( '00', pedidos.N_PEDIDO )
                WHEN 9 THEN CONCAT( '0', pedidos.N_PEDIDO )
            END as CODIGO,
	pedidos.CODPEDIDO,
	cadastro.NOME,
        enderecos.LOGRADOURO as ENDERECO,
        enderecos.NUMERO,
        enderecos.COMPLEMENTO,
        enderecos.BAIRRO,
        enderecos.CIDADE,
        enderecos.UF,
        enderecos.CEP
FROM 
	pedidos
INNER JOIN cadastro ON pedidos.CODCADASTRO=cadastro.CODCADASTRO
INNER JOIN pedidos_rel_enderecos ON pedidos_rel_enderecos.CODPEDIDO=pedidos.CODPEDIDO
INNER JOIN enderecos ON enderecos.CODENDERECO=pedidos_rel_enderecos.CODENDERECO
WHERE pedidos.WAS_EXPORTED='nao'
GROUP BY pedidos.CODPEDIDO ORDER BY pedidos.N_PEDIDO ASC");

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

    public function num_pedidos_endereco_entrega() {
        $query = $this->db->query("SELECT 
             CASE LENGTH(pedidos.N_PEDIDO)  
                WHEN 1 THEN CONCAT( '000000000', pedidos.N_PEDIDO )
                WHEN 2 THEN CONCAT( '00000000', pedidos.N_PEDIDO )
                WHEN 3 THEN CONCAT( '0000000', pedidos.N_PEDIDO )
                WHEN 4 THEN CONCAT( '000000', pedidos.N_PEDIDO )
                WHEN 5 THEN CONCAT( '00000', pedidos.N_PEDIDO )
                WHEN 6 THEN CONCAT( '0000', pedidos.N_PEDIDO )
                WHEN 7 THEN CONCAT( '000', pedidos.N_PEDIDO )
                WHEN 8 THEN CONCAT( '00', pedidos.N_PEDIDO )
                WHEN 9 THEN CONCAT( '0', pedidos.N_PEDIDO )
            END as CODIGO,
	pedidos.CODPEDIDO,
	cadastro.NOME,
        enderecos.LOGRADOURO as ENDERECO,
        enderecos.NUMERO,
        enderecos.COMPLEMENTO,
        enderecos.BAIRRO,
        enderecos.CIDADE,
        enderecos.UF,
        enderecos.CEP
FROM 
	pedidos
INNER JOIN cadastro ON pedidos.CODCADASTRO=cadastro.CODCADASTRO
INNER JOIN pedidos_rel_enderecos ON pedidos_rel_enderecos.CODPEDIDO=pedidos.CODPEDIDO
INNER JOIN enderecos ON enderecos.CODENDERECO=pedidos_rel_enderecos.CODENDERECO
WHERE pedidos.WAS_EXPORTED='nao'
GROUP BY pedidos.CODPEDIDO");

        $query->execute();
        return $query->rowCount();
    }

    public function insert_xls(Array $dados) {
        
        foreach ($dados as $n => $v) {
            $dados[$n] = addslashes($v);
        }
        
        $this->_tabela = "xls";
        return $this->insert($dados);
    }

    public function update_pedido_was_exportad_xls(Array $dados, $codpedido) {
        
        foreach ($dados as $n => $v) {
            $dados[$n] = addslashes($v);
        }
        $codpedido = addslashes($codpedido);
        
        $this->_tabela = "pedidos";
        $where = "CODPEDIDO='{$codpedido}'";
        return $this->update($dados, $where);
    }

    public function get_cliente_xls() {
        $query = $this->db->query("SELECT xls.*, DATE_FORMAT( xls.DTA,  '%d/%m/%Y - %Hh%i' ) AS DTA  FROM `xls` ORDER BY xls.DTA DESC");
        $query->execute();
        if ($query->rowCount()) {
            while ($rows = $query->fetch(PDO::FETCH_OBJ)) {
                if (strlen(WEB_FILES) > 0) {
                    $rows->LINK = PROTOCOLO . DOMINIO_COOKIES . WEB_FILES . str_replace("/web-files", "", $rows->LINK);
                    $rows->LINK2 = PROTOCOLO . DOMINIO_COOKIES . WEB_FILES . str_replace("/web-files", "", $rows->LINK2);
                }
                $obj[] = $rows;
            }
            return $obj;
        } else {
            return false;
        }
    }

}
