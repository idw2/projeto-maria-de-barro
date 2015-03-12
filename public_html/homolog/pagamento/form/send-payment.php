<?php

define("CIELO_N", "1056840215");
define("CIELO_KEY", "c6409f497ff3bcfeb3f802ac6719fdba34cdb54ec36fe4bcd568bd5ddebd9bb9");
define("CIELO_URL", "https://ecommerce.cielo.com.br/servicos/ecommwsec.do");

foreach ($_POST as $name => $value) {
    $name = strtoupper($name);
    $_POST[$name] = trim($value);
}

$_POST['CARTAONUMERO'] = str_replace(" ", "", $_POST["CARTAONUMERO"]);
$_POST["CARTAOVALIDADE"] = $_POST["CARTAO_DTA_MES"] . "/" . $_POST["CARTAO_DTA_ANO"];

$id = rand(1, 1000000);
$valor_total = $_POST['PRODUTO'];

####################################################
#A Cielo tem problemas com arredondamento de numeros            
####################################################

function formataReais($valorReal) {
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
/*
$arredondar = formataReais($valor_total);
$arredondar = explode(",", $arredondar);

if ($arredondar[1] == "00") {
    $valor_total = str_replace(",", "", $valor_total);
} else {
    $valor_total = $arredondar[0] . "00";
}
*/
$valor_total = str_replace(".", "", $valor_total);
$valor_total = str_replace(",", "", $valor_total);

//comentar assim que a cielo homologar
#$valor_total = "100";
####################################################

$bandeira = $_POST['CODIGOBANDEIRA'];
$agora = date('Y-m-d\TH:i:s');
$cartao_nome_titular = trim($_POST["NOMETITULO"]);
$numero_cartao = $_POST["CARTAONUMERO"];
$cartao_codigo = $_POST["CARTAOCODIGOSEGURANCA"];

$indicador = ($cartao_codigo != '') ? '1' : '0';
$data_vencimento = $_POST["CARTAOVALIDADE"];

$fp = explode("/", trim($data_vencimento));
$data_vencimento = trim($fp[1] . $fp[0]);
$numero_cartao = str_replace(" ", "", $numero_cartao);

$qtd_parcelas = $_POST["FORMAPAGAMENTO"];

if ($qtd_parcelas == "A") {
    $produto = "A";
} else {
    $produto = ($qtd_parcelas == '1') ? '1' : '2';
}

( $qtd_parcelas == "A" || $qtd_parcelas == 1 ) ? $qtd_parcelas = 1 : $qtd_parcelas;


$autorizar = $_POST["INDICADORAUTORIZACAO"];
$captura = $_POST["CAPTURARAUTOMATICAMENTE"];

$cielo_numero = CIELO_N;
$chave_cielo = CIELO_KEY;
$url = CIELO_URL;

$string = <<<XML
<?xml version='1.0' encoding='ISO-8859-1'?>
<requisicao-transacao id='{$id}' versao='1.2.1'>
	<dados-ec>
		<numero>{$cielo_numero}</numero>
		<chave>{$chave_cielo}</chave>
	</dados-ec>
	<dados-portador>
		<numero>{$numero_cartao}</numero>
		<validade>{$data_vencimento}</validade>
		<indicador>{$indicador}</indicador>
		<codigo-seguranca>{$cartao_codigo}</codigo-seguranca>
	</dados-portador>
	<dados-pedido>
		<numero>{$id}</numero>
		<valor>{$valor_total}</valor>
		<moeda>986</moeda>
		<data-hora>{$agora}</data-hora>
		<descricao>MARIA DE BARRO</descricao>
		<idioma>PT</idioma>
	</dados-pedido>
	<forma-pagamento>
		<bandeira>{$bandeira}</bandeira>
		<produto>{$produto}</produto>
		<parcelas>{$qtd_parcelas}</parcelas>
	</forma-pagamento>
	<autorizar>{$autorizar}</autorizar>
	<capturar>{$captura}</capturar>
</requisicao-transacao>
XML;

$ch = curl_init();
flush();
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, 'mensagem=' . $string);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_FAILONERROR, true);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
curl_setopt($ch, CURLOPT_TIMEOUT, 40);
$string = curl_exec($ch);
curl_close($ch);
$xml = simplexml_load_string($string);


$erro = "";
if ($xml->tid) {

    if ($xml->captura->codigo == '6' AND $xml->autorizacao->codigo == '6') {
        $erro .= 'TID da transação: ' . $xml->tid . '<br/>';
        $response['status'] = 'success';
        $response['content'] = $erro;
        print_r(json_encode($response));
        die;
    } else {
        $erro .= 'Transação não autorizada: <br/>' . $xml->autorizacao->mensagem . '.';
        $response['status'] = 'error';
        $response['content'] = $erro;
        print_r(json_encode($response));
        die;
    }
} else {

    $erro .= 'Requisição inválida: <br/>' . $xml->mensagem . '.';
    $response['status'] = 'error_conexao';
    $response['content'] = $erro;
    print_r(json_encode($response));
    die;
}