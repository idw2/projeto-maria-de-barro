<?php

set_time_limit(0);
//header('Content-Type: application/json');
require("../../system/model.php");

//require("../../system/controller.php");

Class Querys extends Model {

    public function limpaValorReal($valor) {
        $valor = str_replace(",", "", $valor);
        $valor = str_replace(".", "", $valor);
        return $valor;
    }

    public function get_num_pedidos() {
        $query = $this->db->query("SELECT `N_PEDIDO` FROM `pedidos` ORDER BY `N_PEDIDO` DESC LIMIT 1");
        $query->execute();
        if ($query->rowCount()) {
            while ($rows = $query->fetch(PDO::FETCH_OBJ)) {
                return (int)$rows->N_PEDIDO;
            }
        } else {
            return false;
        }
    }

    public function insert_pedido(Array $dados) {
        $this->_tabela = "pedidos";
        $this->insert($dados);
    }

    public function getPrimarykey() {
        return strtoupper(md5(uniqid(rand(), true)));
    }

    public function existe_codigo_bonus($codigo) {
        $query = $this->db->query("SELECT * FROM bonus WHERE CODIGO='{$codigo}'");
        $query->execute();
        return $query->rowCount();
    }

    public function insert_bonus(Array $dados) {
        $this->_tabela = "bonus";
        $this->insert($dados);
    }

    public function get_enderecos($codendereco) {
        $this->_tabela = "enderecos";
        $where = "CODENDERECO='{$codendereco}'";
        return $this->read($where);
    }

    public function insert_endereco(Array $dados) {
        $this->_tabela = "enderecos";
        $this->insert($dados);
    }

    public function insert_pedidos_rel_enderecos(Array $dados) {
        $this->_tabela = "pedidos_rel_enderecos";
        $this->insert($dados);
    }

    public function insert_compras(Array $dados) {
        $this->_tabela = "compras";
        $this->insert($dados);
    }

    public function del_lista_desejos($client_hidden) {
        $this->_tabela = "lista_desejos";
        $where = "CLIENT_HIDDEN='{$client_hidden}'";
        $this->delete($where);
    }

    public function get_lista_desejos($client_hidden) {
        $query = $this->db->query("SELECT 
                        produtos.CODPRODUTO, 
                        produtos.NOME, 
                        produtos.PESO, 
                        produtos.URL_AMIGAVEL, 
                        produtos.CATEGORIA as CATEG, 
                        (produtos.PESO*SUM(lista_desejos.QUANTIDADE)) as PESO_TOTAL, 
                        fotos.CROP80 as FOTO, 
                        CASE produtos.CATEGORIA 
                        WHEN 'aneis' THEN 'Anéis'
                        WHEN 'brincos' THEN 'Brinco'
                        WHEN 'colares' THEN 'Colares'
                        ELSE 'Pulseiras' 
                        END AS CATEGORIA, 
                        produtos.PRECO, 
                        produtos.REFERENCIA, 
                        (produtos.PRECO*SUM(lista_desejos.QUANTIDADE)) as TOTAL, 
                        SUM(lista_desejos.QUANTIDADE) as QUANTIDADE 
                    FROM produtos
                    INNER JOIN lista_desejos ON lista_desejos.CODPRODUTO=produtos.CODPRODUTO
                    INNER JOIN fotos_rel_produtos ON fotos_rel_produtos.CODPRODUTO=produtos.CODPRODUTO
                    INNER JOIN fotos ON fotos_rel_produtos.CODFOTO=fotos.CODFOTO
                    WHERE lista_desejos.CLIENT_HIDDEN='{$client_hidden}' 
                    AND fotos.DESTAQUE=1
                    GROUP BY produtos.CODPRODUTO
                    ORDER BY (produtos.NOME) ASC");

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

    public function embalar_presente($client_hidden) {
        $query = $this->db->query("SELECT 
                        DISTINCT lista_desejos.EMBALAR_PRESENTE 
                    FROM produtos
                    INNER JOIN lista_desejos ON lista_desejos.CODPRODUTO=produtos.CODPRODUTO
                    INNER JOIN fotos_rel_produtos ON fotos_rel_produtos.CODPRODUTO=produtos.CODPRODUTO
                    INNER JOIN fotos ON fotos_rel_produtos.CODFOTO=fotos.CODFOTO
                    WHERE lista_desejos.CLIENT_HIDDEN='{$client_hidden}' 
                    AND fotos.DESTAQUE=1
                    GROUP BY produtos.CODPRODUTO
                    ORDER BY (produtos.NOME) ASC");

        $query->execute();

        if ($query->rowCount()) {
            while ($rows = $query->fetch(PDO::FETCH_OBJ)) {
                return $rows->EMBALAR_PRESENTE;
            }
        } else {
            return false;
        }
    }

    public function get_compras($codpedido) {
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

    public function get_cadastro($codcadastro) {
        $query = $this->db->query("SELECT * FROM cadastro WHERE CODCADASTRO='{$codcadastro}'");
        $query->execute();

        if ($query->rowCount()) {
            while ($rows = $query->fetch(PDO::FETCH_OBJ)) {
                return $rows;
            }
        } else {
            return false;
        }
    }

    public function update_produtos($codproduto, $quantidade) {
        $query = $this->db->query("UPDATE produtos SET QUANTIDADE = (QUANTIDADE - {$quantidade}) WHERE CODPRODUTO='{$codproduto}'");
        return true;
    }

    public function pedido_finalizado($codpedido, $codcadastro) {
        $query = $this->db->prepare("SELECT * FROM `pedidos` WHERE CODPEDIDO=:CODPEDIDO AND CODCADASTRO=:CODCADASTRO AND STATUS=1");
        $query->bindParam(":CODPEDIDO", $codpedido, PDO::PARAM_STR, 32);
        $query->bindParam(":CODCADASTRO", $codcadastro, PDO::PARAM_STR, 32);
        $query->execute();
        return $query->rowCount();
    }

    public function get_forma_pgto_pedido($codpedido, $codcadastro) {
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
        $query = $this->db->prepare("SELECT * FROM `pedidos` WHERE CODPEDIDO=:CODPEDIDO AND CODCADASTRO=:CODCADASTRO");
        $query->bindParam(":CODPEDIDO", $codpedido, PDO::PARAM_STR, 32);
        $query->bindParam(":CODCADASTRO", $codcadastro, PDO::PARAM_STR, 32);
        $query->execute();
        if ($query->rowCount()) {
            #$c = new Controller();
            while ($rows = $query->fetch(PDO::FETCH_OBJ)) {
                $rows->CODPEDIDO = strtolower($rows->CODPEDIDO);
                $rows->CODCADASTRO = strtolower($rows->CODCADASTRO);
                $rows->N_PEDIDO = $this->formataCodigopedido($rows->N_PEDIDO);
                $rows->TAXA_ENTREGA = $this->formataReais($rows->TAXA_ENTREGA);
                $rows->TOTAL_PARCIAL = $this->formataReais($rows->TOTAL_PARCIAL);
                $rows->TOTAL_MOIP = $rows->TOTAL_GERAL;
                $rows->TOTAL_PAYPAL = str_replace(".", "", $this->formataReais($rows->TOTAL_GERAL));
                $rows->TOTAL_PAYPAL = str_replace(",", ".", $rows->TOTAL_PAYPAL);
                $rows->TOTAL_GERAL = $this->formataReais($rows->TOTAL_GERAL);
                return $rows;
            }
        } else {
            return false;
        }
    }

    public function get_pedido2($codpedido, $codcadastro) {

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

            while ($rows = $query->fetch(PDO::FETCH_OBJ)) {
                $rows->CODPEDIDO = strtolower($rows->CODPEDIDO);
                $rows->CODCADASTRO = strtolower($rows->CODCADASTRO);
                $rows->N_PEDIDO = $this->formataCodigopedido($rows->N_PEDIDO);
                $rows->TAXA_ENTREGA = $this->formataReais($rows->TAXA_ENTREGA);
                $rows->IMPOSTOS = $this->formataReais($rows->IMPOSTOS);
                $rows->TOTAL_PARCIAL = $this->formataReais($rows->TOTAL_PARCIAL);
                $rows->TOTAL_COMPRA = $this->formataReais($rows->TOTAL_COMPRA);
                $rows->IMPOSTOS = $this->formataReais($rows->IMPOSTOS);
                $rows->DESCONTO = $this->formataReais($rows->DESCONTO);
                $rows->TOTAL_MOIP = $rows->TOTAL_GERAL;
                $rows->TOTAL_PAYPAL = str_replace(".", "", $this->formataReais($rows->TOTAL_GERAL));
                $rows->TOTAL_PAYPAL = str_replace(",", ".", $rows->TOTAL_PAYPAL);
                $rows->TOTAL_GERAL = $this->formataReais($rows->TOTAL_GERAL);
                return $rows;
            }
        } else {
            return false;
        }
    }

    public function formataCodigopedido($codigo) {
        switch (strlen($codigo)) {
            case 1: $codigo = "000000000{$codigo}";
                break;
            case 2: $codigo = "00000000{$codigo}";
                break;
            case 3: $codigo = "0000000{$codigo}";
                break;
            case 4: $codigo = "000000{$codigo}";
                break;
            case 5: $codigo = "00000{$codigo}";
                break;
            case 6: $codigo = "0000{$codigo}";
                break;
            case 7: $codigo = "000{$codigo}";
                break;
            case 8: $codigo = "00{$codigo}";
                break;
            case 9: $codigo = "0{$codigo}";
                break;
        }
        return $codigo;
    }

    public function saudacao() {
        $hora = (int) date("H");
        if ($hora >= 0 && $hora < 12) {
            return "Bom dia,";
        } else if ($hora >= 12 && $hora < 18) {
            return "Bom tarde,";
        } else {
            return "Bom noite,";
        }
    }

    public function get_bonus($cupom) {
        $query = $this->db->query("SELECT * FROM bonus WHERE CODIGO='{$cupom}'");
        $query->execute();
        if ($query->rowCount()) {
            while ($rows = $query->fetch(PDO::FETCH_OBJ)) {
                return $rows;
            }
        } else {
            return false;
        }
    }

    public function del_bonus($cupom) {
        $this->_tabela = "bonus";
        $where = "CODIGO='{$cupom}'";
        $this->delete($where);
    }

    public function get_compras2($codpedido) {

        $codpedido = addslashes($codpedido);

        $query = $this->db->query("SELECT * FROM compras WHERE CODPEDIDO='{$codpedido}' ORDER BY DTA ASC");
        $query->execute();
        if ($query->rowCount()) {
            while ($rows = $query->fetch(PDO::FETCH_OBJ)) {
                $rows->CODPEDIDO = strtolower($rows->CODPEDIDO);
                $rows->PRECO = $this->formataReais($rows->PRECO);
                $rows->TOTAL = $this->formataReais($rows->TOTAL);
                $rows->NOME = utf8_encode($rows->NOME);
                $rows->CATEGORIA = utf8_encode($rows->CATEGORIA);

                $rows->FOTO = "/homolog" . $rows->FOTO;
                $obj[] = $rows;
            }
            return $obj;
        } else {
            return false;
        }
    }

    public function get_cadastro_for_pedido($codpedido) {

        $codpedido = addslashes($codpedido);

        $query = $this->db->query("SELECT cadastro.* FROM cadastro
	INNER JOIN pedidos ON pedidos.CODCADASTRO=cadastro.CODCADASTRO
	WHERE pedidos.CODPEDIDO='{$codpedido}'");
        $query->execute();
        if ($query->rowCount()) {

            while ($rows = $query->fetch(PDO::FETCH_OBJ)) {
                $rows->NOME = utf8_encode($rows->NOME);
                #$rows->NASCIMENTO = $c->formataDataForBrazil($rows->NASCIMENTO);
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
            #       $c = new Controller();
            while ($rows = $query->fetch(PDO::FETCH_OBJ)) {
                $rows->LOGRADOURO = utf8_encode($rows->LOGRADOURO);
                $rows->CIDADE = utf8_encode($rows->CIDADE);
                $rows->BAIRRO = utf8_encode($rows->BAIRRO);
                $rows->LOGRADOURO = utf8_encode($rows->LOGRADOURO);
                $obj[] = $rows;
            }
            return $obj;
        } else {
            return false;
        }
    }

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

}

if ($_POST) {
    foreach ($_POST as $key => $value) {
        $_POST[$key] = trim($value);
    }
}

$model = new Querys();

$client_hidden = trim($_POST['CLIENT_HIDDEN']);
$codendereco = trim($_POST['CODENDERECO']);

$bonus = trim($_POST["BONUS"]);

$dados['CODPEDIDO'] = strtoupper(md5(uniqid(rand(), true)));
$dados['CODCADASTRO'] = trim($_POST['CODCADASTRO']);

$cliente = $model->get_cadastro($dados['CODCADASTRO']);

$dados['FORMA_PGTO'] = trim($_POST['FORMA_PGTO']);
$dados['N_PEDIDO'] = ((int) $model->get_num_pedidos() + 1);
$dados['FORMA_ENVIO'] = trim($_POST['FORMA_ENVIO']);

switch ($dados['FORMA_ENVIO']) {
    case '41106': $dados['FORMA_ENVIO'] = "PAC";
        break;
    case '40010': $dados['FORMA_ENVIO'] = "SEDEX";
        break;
    case '40215': $dados['FORMA_ENVIO'] = "SEDEX 10";
        break;
    case '40290': $dados['FORMA_ENVIO'] = "SEDEX hoje";
        break;
    case '81019': $dados['FORMA_ENVIO'] = "e-SEDEX";
        break;
    case 'total_express': $dados['FORMA_ENVIO'] = "Total Express";
        break;
}

if (trim($_POST['TAXA_ENTREGA']) == "Gratis") {
    $dados['TAXA_ENTREGA'] = 0;
    $dados['FRETE_GRATIS'] = 1;
} else {
    $dados['TAXA_ENTREGA'] = $model->limpaValorReal(trim($_POST['TAXA_ENTREGA']));
    $dados['FRETE_GRATIS'] = 0;
}

( strlen($_POST['TICKET_DESCONTO']) == 6 ) ? $ticket = $model->get_bonus($_POST['TICKET_DESCONTO']) : $ticket = 0;
if ($ticket != 0) {
    if ($ticket->TIPO == "aniversario" || $ticket->TIPO == "desconto") {
        #$t = $model->limpaValorReal(trim($_POST['TOTAL_PARCIAL']));
        $t = 0;
       
        $sem_desejos = $model->get_lista_desejos($client_hidden);
        if ($sem_desejos) {
            foreach ($model->get_lista_desejos($client_hidden) as $compraObj) {
                $t = ($t + $compraObj->TOTAL);
            }
        }
        
        $ump = ($t / 100);
        $dados['DESCONTO'] = ($ump * 10);
        
    } else {
        $dados['DESCONTO'] = $ticket->VALOR;
    }
    $dados['CUPOM'] = strtoupper($_POST['TICKET_DESCONTO']);
    $model->del_bonus($_POST['TICKET_DESCONTO']);
}


$dados['TOTAL_GERAL'] = $model->limpaValorReal(trim($_POST['TOTAL_GERAL']));
$dados['TOTAL_PARCIAL'] = $model->limpaValorReal(trim($_POST['TOTAL_PARCIAL']));
$dados['IMPOSTOS'] = $model->limpaValorReal(trim($_POST['IMPOSTOS']));
$dados['EMBALAR_PRESENTE'] = (int) $model->embalar_presente($client_hidden);

$model->insert_pedido($dados);

$bonus_array["CODBONUS"] = $model->getPrimarykey();
$bonus_array["CODCADASTRO"] = $dados['CODCADASTRO'];
$bonus_array["CODIGO"] = substr($bonus_array["CODBONUS"], 0, 6);

$existe = ($model->existe_codigo_bonus($bonus["CODIGO"])) ? true : false;

while ($existe) {
    $codigo = $model->getPrimarykey();
    $codigo2 = $codigo{5};
    $existe = ($model->existe_codigo_bonus($codigo2)) ? true : false;
}

$bonus_array["VALOR"] = $model->limpaValorReal($bonus);
$model->insert_bonus($bonus_array);

$persiste_endereco = array();
foreach ($model->get_enderecos($codendereco) as $name => $valor) {
    if ($name != "CODENDERECO" && $name != "DTA") {
        $persiste_endereco[$name] = $valor;
    }
}

$persiste_endereco['CODENDERECO'] = strtoupper(md5(uniqid(rand(), true)));

$model->insert_endereco($persiste_endereco);

$pedidos_rel_enderecos['CODENDERECO'] = $persiste_endereco['CODENDERECO'];
$pedidos_rel_enderecos['CODPEDIDO'] = $dados['CODPEDIDO'];

$model->insert_pedidos_rel_enderecos($pedidos_rel_enderecos);

$compra = array();



$i = 0;

$sem_desejos = $model->get_lista_desejos($client_hidden);
if ($sem_desejos) {
    foreach ($model->get_lista_desejos($client_hidden) as $compraObj) {

        foreach ($compraObj as $name => $value) {

            ($name == "CATEGORIA") ? $compra[$name] = utf8_decode($value) : $compra[$name] = $value;
        }

        $compra['CODCOMPRA'] = strtoupper(md5(uniqid(rand(), true)));
        $compra['CODPEDIDO'] = $dados['CODPEDIDO'];

        $model->insert_compras($compra);
        $i++;
    }
}

$sem_compras = $model->get_compras($dados['CODPEDIDO']);
if ($sem_compras) {
    foreach ($sem_compras as $compra) {

        $model->update_produtos($compra->CODPRODUTO, $compra->QUANTIDADE);
    }
}




$model->del_lista_desejos($client_hidden);

echo $dados['CODPEDIDO'] = trim(strtolower($dados['CODPEDIDO']));


//echo json_encode($dados);


$quebra_linha = "\n";
$emailsender = "maria@mariadebarro.com.br";
$nomeremetente = "Maria de Barro";
$emaildesitnatario = $cliente->EMAIL;
$assunto_texto = "Cupom de desconto Maria de Barro";
$assunto = "=?UTF-8?B?" . base64_encode($assunto_texto) . "?=";

$link = "http://novo.mariadebarro.com.br/";

$mensagemHTML = "<pre><div style='font-size: 14px;'>
    <h3>Parabéns {$cliente->NOME},</h3>
    <div>Você tem um desconto de <strong>R$ {$_POST['BONUS']}</strong> para a sua próxima compra!<div><br/>
    <div>Para solicitar o desconto forneça o seguinte número de cupom:<div><br/>
    <div style='boder: 1px solid #000; padding: 3%'><h1>{$bonus_array['CODIGO']}</h1><div><br/>
    <div><a href='{$link}'><img src='{$link}web-files/img/logo.png' alt='Maria de Barro' title='Maria de Barro' border='0'/></a></div><br/>
    <div><strong>* Não responder a este e-mail</strong></div><br/>
    </div></pre>";

$headers = "MIME-Version: 1.1{$quebra_linha}";
$headers .= "Content-type: text/html; charset=UTF-8{$quebra_linha}";
$headers .= "From: \"{$nomeremetente}\"<{$emailsender}>{$quebra_linha}";
$headers .= "Return-Path: {$emailsender}{$quebra_linha}";
$headers .= "Cc: {$comcopia}{$quebra_linha}";
$headers .= "Reply-To: {$emaildesitnatario}{$quebra_linha}";
$headers .= "X-Mailer: PHP/" . phpversion();

//mail($emaildesitnatario, $assunto, $mensagemHTML, $headers, "-f" . $emailsender);
//$quebra_linha = "\n";
//$emailsender = "maria@mariadebarro.com.br";
//$nomeremetente = "Maria de Barro";
//$emaildesitnatario = "maria@mariadebarro.com.br";
//$comcopia = "fabiano@mariadebarro.com.br";
//$assunto_texto = "Compra";
//$assunto = "=?UTF-8?B?" . base64_encode($assunto_texto) . "?=";
//
//$link = "http://novo.mariadebarro.com.br/";
//
//$mensagemHTML = "<pre><div style='font-size: 14px;'>
//    <h3>Visualizar a administração do site</h3></pre>";
//
//$headers = "MIME-Version: 1.1{$quebra_linha}";
//$headers .= "Content-type: text/html; charset=UTF-8{$quebra_linha}";
//$headers .= "From: \"{$nomeremetente}\"<{$emailsender}>{$quebra_linha}";
//$headers .= "Return-Path: {$emailsender}{$quebra_linha}";
//$headers .= "Cc: {$comcopia}{$quebra_linha}";
//$headers .= "Reply-To: {$emaildesitnatario}{$quebra_linha}";
//$headers .= "X-Mailer: PHP/" . phpversion();
//
//mail($emaildesitnatario, $assunto, $mensagemHTML, $headers, "-f" . $emailsender);
//$forma_pgto = $model->get_forma_pgto_pedido($codpedido, $codcadastro);
//$this->assign("forma_pgto", $forma_pgto);
//$this->assign("pedido", $model->get_pedido($codpedido, $codcadastro));
//$this->view_tpl("confirmacao");
//
//$quebra_linha = "\n";
//$emailsender = "maria@mariadebarro.com.br";
//$nomeremetente = "Maria de Barro";
//$emaildesitnatario = $cliente->EMAIL;
//$assunto_texto = "Compra aguardando confirmação de Pagamento";
//$assunto = "=?UTF-8?B?" . base64_encode($assunto_texto) . "?=";
//
//$link = "http://novo.mariadebarro.com.br/";
//
//$mensagemHTML = "<pre><div style='font-size: 14px;'>
//    <h3>{$model->saudacao()} {$cliente->NOME},</h3>
//    <div>Recentemente voc~e realizou compras <strong>R$ {$_POST['BONUS']}</strong> para a sua próxima compra!<div><br/>
//    <div>Para solicitar o desconto forneça o seguinte número de cupom:<div><br/>
//    <div style='boder: 1px solid #000; padding: 3%'><h1>{$bonus_array['CODIGO']}</h1><div><br/>
//    <div><a href='{$link}'><img src='{$link}web-files/img/logo.png' alt='Maria de Barro' title='Maria de Barro' border='0'/></a></div><br/>
//    <div><strong>* Não responder a este e-mail</strong></div><br/>
//    </div></pre>";
//
//$headers = "MIME-Version: 1.1{$quebra_linha}";
//$headers .= "Content-type: text/html; charset=UTF-8{$quebra_linha}";
//$headers .= "From: \"{$nomeremetente}\"<{$emailsender}>{$quebra_linha}";
//$headers .= "Return-Path: {$emailsender}{$quebra_linha}";
//$headers .= "Cc: {$comcopia}{$quebra_linha}";
//$headers .= "Reply-To: {$emaildesitnatario}{$quebra_linha}";
//$headers .= "X-Mailer: PHP/" . phpversion();
//
//mail($emaildesitnatario, $assunto, $mensagemHTML, $headers, "-f" . $emailsender);
//
//



/*
  ob_start();
  require_once( VIEWS . $nome . ".phtml");
  $html = ob_get_clean();
  return $html;
 *  */


$quebra_linha = "\n";
$emailsender = "maria@mariadebarro.com.br";
$nomeremetente = "Maria de Barro";
$comcopia = $email;

$view_compras = $model->get_compras2($dados['CODPEDIDO']);

$cadastro = $model->get_cadastro_for_pedido($dados['CODPEDIDO']);

foreach ($cadastro as $obj) {
    $cad = $obj;
    $view_cadastro = $obj;
}

$view_pedido = $model->get_pedido2($dados['CODPEDIDO'], $cad->CODCADASTRO);

$assunto_texto = "Alerta de Venda pelo Site Pedido Nº - {$pedido->N_PEDIDO}";

$assunto = "=?UTF-8?B?" . base64_encode($assunto_texto) . "?=";

$endereco_entrega = $model->get_endereco_entrega($dados['CODPEDIDO']);

foreach ($endereco_entrega as $obj) {
    $view_endereco = $obj;
}

$mensagemHTML = "";

$mensagemHTML .= "<h3>1. Dados do comprador</h3>";
$mensagemHTML .= "<div>";
$mensagemHTML .= "<div>";
$mensagemHTML .= "<div> ";
$mensagemHTML .= "<table>";

$mensagemHTML .= "<tr>";
$mensagemHTML .= "<td>Nome:</td>";
$mensagemHTML .= "<td>$view_cadastro->NOME</td>";
$mensagemHTML .= "</tr>";
$mensagemHTML .= "<tr>";
$mensagemHTML .= "<td>E-mail:</td>";
$mensagemHTML .= "<td>$view_cadastro->EMAIL</td>";
$mensagemHTML .= "</tr>";
$mensagemHTML .= "<tr>";
$mensagemHTML .= "<td>Data de nascimento:</td>";
$mensagemHTML .= "<td>$view_cadastro->NASCIMENTO</td>";
$mensagemHTML .= "</tr>";
$mensagemHTML .= "<tr>";
$mensagemHTML .= "<td>Sexo:</td>";
$mensagemHTML .= "<td>$view_cadastro->SEXO</td>";
$mensagemHTML .= "</tr>";
$mensagemHTML .= "<tr>";
$mensagemHTML .= "<td>Telefone:</td>";
$mensagemHTML .= "<td>($view_cadastro->DDD) $view_cadastro->TELEFONE , Ramal: $view_cadastro->RAMAL </td>";
$mensagemHTML .= "</tr>";

$mensagemHTML .= "</table>";
$mensagemHTML .= "</div>";
$mensagemHTML .= "</div>";
$mensagemHTML .= "</div>";

$mensagemHTML .= "<h3>2. Endereço de Entrega</h3>";
$mensagemHTML .= "<div>";
$mensagemHTML .= "<div>";
$mensagemHTML .= "<div> ";
$mensagemHTML .= "<table> ";
$mensagemHTML .= "<tr>";

$mensagemHTML .= "<td>CEP:</td>";
$mensagemHTML .= "<td>$view_endereco->CEP</td> ";

$mensagemHTML .= "</tr>";
$mensagemHTML .= "<tr> <td>Endereço:</td><td>$view_endereco->LOGRADOURO, nº $view_endereco->NUMERO $view_endereco->COMPLEMENTO</td> </tr>";
$mensagemHTML .= "<tr> <td>Bairro:</td><td>$view_endereco->BAIRRO</td> </tr>";
$mensagemHTML .= "<tr> <td>Cidade/UF:</td><td>$view_endereco->CIDADE/$view_endereco->UF</td> </tr>";

$mensagemHTML .= "</table>";
$mensagemHTML .= "</div>";
$mensagemHTML .= "</div>";
$mensagemHTML .= "</div>";

$mensagemHTML .= "<h3>3. Produtos escolhidos</h3>";
$mensagemHTML .= "<div>";
$mensagemHTML .= "<div>";
$mensagemHTML .= "<div> ";
$mensagemHTML .= "<table>";
$mensagemHTML .= "<thead>";
$mensagemHTML .= "<tr>";
$mensagemHTML .= "<th>#</th>";
$mensagemHTML .= "<th>Nome do Produto</th>";
$mensagemHTML .= "<th>Categoria</th>";
$mensagemHTML .= "<th>Referência</th>";
$mensagemHTML .= "<th>Preço Unitário</th>";
$mensagemHTML .= "<th>Peso Unitário</th>";
$mensagemHTML .= "<th>Peso Total</th>";
$mensagemHTML .= "<th>Quantidade</th>";
$mensagemHTML .= "<th>Total</th>";
$mensagemHTML .= "</tr>";
$mensagemHTML .= "</thead>";

$mensagemHTML .= "<tbody>";

if ($nenhum_produto == true) {
    $mensagemHTML .= "<tr>";
    $mensagemHTML .= "<th>Nenhum produto na sua Lista de Desejos!</th>";
    $mensagemHTML .= "</tr>";
} else {
    foreach ($view_compras as $lista_desejo) {

        $mensagemHTML .= "<tr>";
        $mensagemHTML .= "<td><a href='https://www.mariadebarro.com.br/pt/descricao/categoria/$lista_desejo->CATEG/$lista_desejo->URL_AMIGAVEL'><img src='https://www.mariadebarro.com.br/{$lista_desejo->FOTO}' alt='$lista_desejo->NOME' title='$lista_desejo->NOME' border='0'/></a><br/></td>";
        $mensagemHTML .= "<td>$lista_desejo->NOME</td>";
        $mensagemHTML .= "<td>$lista_desejo->CATEGORIA</td>";
        $mensagemHTML .= "<td>$lista_desejo->REFERENCIA</td>";
        $mensagemHTML .= "<td>$lista_desejo->PRECO</td>";
        $mensagemHTML .= "<td>$lista_desejo->PESO</td>";
        $mensagemHTML .= "<td id='peso_total_produto_$lista_desejo->CODLISTADESEJOS'>$lista_desejo->PESO_TOTAL</td>";
        $mensagemHTML .= "<td id='n_input align='center'>$lista_desejo->QUANTIDADE</td>";
        $mensagemHTML .= "<td  id='preco_total_produto_$lista_desejo->CODLISTADESEJOS'>";
        if ($lista_desejo->TOTAL == "") {
            $mensagemHTML .= "0,00";
        } else {
            $mensagemHTML .= $lista_desejo->TOTAL;
        } $mensagemHTML .= "</td>";
        $mensagemHTML .= "</tr>";
    }
}

$mensagemHTML .= "</tbody>";
$mensagemHTML .= "</table>";
$mensagemHTML .= "</div>";
$mensagemHTML .= "</div>";
$mensagemHTML .= "</div>";

$mensagemHTML .= "<h3>4. Dados da Transação</h3>";
$mensagemHTML .= "<div>";
$mensagemHTML .= "<div>";
$mensagemHTML .= "<div> ";


$mensagemHTML .= "<table>";
$mensagemHTML .= "<tr>";
$mensagemHTML .= "<td>Código da transação:</td>";
$mensagemHTML .= "<td>$view_pedido->CODPEDIDO</td>";
$mensagemHTML .= "</tr>";
$mensagemHTML .= "<tr>";
$mensagemHTML .= "<td>Código do cliente:</td>";
$mensagemHTML .= "<td>$view_pedido->CODCADASTRO</td>";
$mensagemHTML .= "</tr>";
$mensagemHTML .= "<tr>";
$mensagemHTML .= "<td>Número do Pedido:</td>";
$mensagemHTML .= "<td>$view_pedido->N_PEDIDO</td>";
$mensagemHTML .= "</tr>";
$mensagemHTML .= "<tr>";
$mensagemHTML .= "<td>Data e hora da transação:</td>";
$mensagemHTML .= "<td>$view_pedido->DTA</td>";
$mensagemHTML .= "</tr>";
$mensagemHTML .= "<tr>";
$mensagemHTML .= "<td>Forma de envio:</td>";
$mensagemHTML .= "<td>$view_pedido->FORMA_ENVIO</td>";
$mensagemHTML .= "</tr>";
$mensagemHTML .= "<tr>";
$mensagemHTML .= "<td>Forma de pagamento:</td>";
$mensagemHTML .= "<td>$view_pedido->FORMA_PGTO</td>";
$mensagemHTML .= "</tr>";
if ($view_pedido->FORMA_PGTO == "boleto") {
    $mensagemHTML .= "<tr>";
    $mensagemHTML .= "<td>Nosso Número:</td>";
    $mensagemHTML .= "<td>$view_pedido->NOSSO_NUMERO</td>";
    $mensagemHTML .= "</tr>    ";
}

if ($view_pedido->TAXA_ENTREGA != "" || $view_pedido->FORMA_ENVIO != "Retirada na Loja") {
    $mensagemHTML .= "<tr>";
    $mensagemHTML .= "<td>Total da compra:</td>";
    $mensagemHTML .= "<td>$view_pedido->TOTAL_PARCIAL</td>";
    $mensagemHTML .= "</tr>";
}
$mensagemHTML .= "<tr>";
$mensagemHTML .= "<td>Taxa de entrega:</td>";
$mensagemHTML .= "<td>";

if ($view_pedido->TAXA_ENTREGA == "" && $view_pedido->FORMA_ENVIO == "Retirada na Loja") {
    $mensagemHTML .= "--";
} else {
    if ($view_pedido->TAXA_ENTREGA == "") {
        $mensagemHTML .= "Grátis";
    } else {
        $mensagemHTML .= " $view_pedido->TAXA_ENTREGA";
    }
}



$mensagemHTML .= "</td>";
$mensagemHTML .= "</tr>";
$mensagemHTML .= "<tr>";
$mensagemHTML .= "<td>Imposto:</td>";
$mensagemHTML .= "<td>{$view_pedido->IMPOSTOS}</td>";
$mensagemHTML .= "</tr>";
$mensagemHTML .= "<tr>";
$mensagemHTML .= "<td>Total à pagar:</td>";
$mensagemHTML .= "<td>$view_pedido->TOTAL_GERAL</td>";
$mensagemHTML .= "</tr>";
$mensagemHTML .= "</table>   ";


$mensagemHTML .= "</div>";
$mensagemHTML .= "</div>      ";
$mensagemHTML .= "</div>";



$headers = "MIME-Version: 1.1{$quebra_linha}";
$headers .= "Content-type: text/html; charset=UTF-8{$quebra_linha}";
$headers .= "From: \"{$nomeremetente}\"<{$emailsender}>{$quebra_linha}";
$headers .= "Return-Path: {$emailsender}{$quebra_linha}";
$headers .= "Cc: {$comcopia}{$quebra_linha}";
$headers .= "Reply-To: {$emaildesitnatario}{$quebra_linha}";
$headers .= "X-Mailer: PHP/" . phpversion();

$emaildesitnatario = "maria@mariadebarro.com.br";
mail($emaildesitnatario, $assunto, $mensagemHTML, $headers, "-f" . $emailsender);

$emaildesitnatario = "fabiano@mariadebarro.com.br";
mail($emaildesitnatario, $assunto, $mensagemHTML, $headers, "-f" . $emailsender);

$emaildesitnatario = "thais@mariadebarro.com.br";
mail($emaildesitnatario, $assunto, $mensagemHTML, $headers, "-f" . $emailsender);
