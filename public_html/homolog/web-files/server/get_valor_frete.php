<?php

header('Content-Type: application/json');
require("../../system/helpers/RsCorreios.php");
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

    public function get_total_geral($client_hidden) {

        $query = $this->db->query("SELECT 
            produtos.PRECO*SUM(lista_desejos.QUANTIDADE) as TOTAL  
        FROM produtos
        INNER JOIN lista_desejos ON lista_desejos.CODPRODUTO=produtos.CODPRODUTO
        WHERE lista_desejos.CLIENT_HIDDEN='{$client_hidden}'");

        $query->execute();

        if ($query->rowCount()) {
            while ($rows = $query->fetch(PDO::FETCH_OBJ)) {
                return $rows->TOTAL = $this->formataReais($rows->TOTAL);
            }
        } else {
            return false;
        }
    }

    public function calcula_imposto($percentual, $sobre_valor) {
        $query = $this->db->query("SELECT SUM(ROUND({$sobre_valor}/{$percentual})-{$sobre_valor}) AS IMPOSTO;");
        $query->execute();

        if ($query->rowCount()) {
            $c = new Controller();
            while ($rows = $query->fetch(PDO::FETCH_OBJ)) {
                $rows->IMPOSTO = $c->formataReais($rows->IMPOSTO);
                return $rows;
            }
        } else {
            return false;
        }
    }

}

$model = new QuerysReload();


if ($_POST["forma_envio"] == "total_express") {

    $cep_destinatario = str_replace("-", "", $_POST["cep_destinatario"]);

    $tg = str_replace(".", "", $_POST["total_geral"]);
    $tg = str_replace(",", ".", $tg);

    $ti = str_replace(".", "", $_POST["total_impostos"]);
    $ti = str_replace(",", ".", $ti);

    $tg_ti = ( (double) $tg + (double) $ti );

    ( (double) $_POST["total_peso"] == 0 ) ? $p = "0.3" : $p = $_POST["total_peso"];

    $string = <<<XML
<SOAP-ENV:Envelope xmlns:SOAP-ENV = "http://schemas.xmlsoap.org/soap/envelope/" 
                   xmlns:ns1 = "urn:calcularFrete" 
                   xmlns:xsd = "http://www.w3.org/2001/XMLSchema" 
                   xmlns:xsi = "http://www.w3.org/2001/XMLSchema-instance" 
                   xmlns:ns2 = "http://edi.totalexpress.com.br/soap/webservice_v24.total" 
                   xmlns:SOAP-ENC = "http://schemas.xmlsoap.org/soap/encoding/" 
                   SOAP-ENV:encodingStyle = "http://schemas.xmlsoap.org/soap/encoding/">
    <SOAP-ENV:Body>
        <ns1:calcularFrete>
            <calcularFreteRequest xsi:type = "ns2:calcularFreteRequest">
                <TipoServico xsi:type = "xsd:string">EXP</TipoServico>
                <CepDestino xsi:type = "xsd:nonNegativeInteger">{$cep_destinatario}</CepDestino>
                <Peso xsi:type = "xsd:decimal">{$p}</Peso>
                <ValorDeclarado xsi:type = "xsd:decimal">{$tg_ti}</ValorDeclarado>
		<TipoEntrega xsi:type = "xsd:nonNegativeInteger">0</TipoEntrega>
            </calcularFreteRequest>
        </ns1:calcularFrete>
    </SOAP-ENV:Body>
</SOAP-ENV:Envelope>
XML;

    $username = "mariadebarro-qa";
    $password = "4NyYrjgT";
    $credentials = "{$username}:{$password}";

    $url = "http://edi.totalexpress.com.br/webservice_calculo_frete.php?wsdl";

    $headers = array(
        "POST /StockQuote HTTP/1.1",
        "Content-type: text/xml; charset=\"utf-8\"",
        "Accept: text/xml",
        "Cache-Control: no-cache",
        "Pragma: no-cache",
        "SOAPAction: \"run\"",
        "Content-length: " . strlen($string),
        "Authorization: Basic " . base64_encode($credentials)
    );


    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_USERAGENT, $defined_vars['HTTP_USER_AGENT']);

// Apply the XML to our curl call 
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $string);



    if (curl_errno($ch)) {
        //print "Error: " . curl_error($ch);
        //$resultadoFrete = $result['msg_erro'];
        $total_geral = $_POST["total_geral"];
        $total_geral = str_replace(".", "", $total_geral);
        $total_geral = str_replace(",", "", $total_geral);

        $total_impostos = trim($_POST["total_impostos"]);
        $total_impostos = str_replace(".", "", $total_impostos);
        $total_impostos = str_replace(",", "", $total_impostos);

        $valor = 0;
        $valor = str_replace(".", "", $valor);
        $valor = str_replace(",", "", $valor);

        $soma = ((int) $total_geral + (int) $valor + (int) $total_impostos);

        $dados["soma"] = $model->formataReais($soma);
        $dados["frete"] = "0,00";
        $dados["msg_erro"] = "Serviço indisponível para esta Localidade!";
        echo json_encode($dados);
        
    } else {

        $data = curl_exec($ch);

        $string = <<<XML
$data
XML;

        $soap = simplexml_load_string($string);

        $soap->children('SOAP-ENV', true)->Body->children('ns1', true)->calcularFreteResponse->children()->calcularFreteResponse->DadosFrete;

        foreach ($soap->children('SOAP-ENV', true)->Body->children('ns1', true)->calcularFreteResponse->children()->calcularFreteResponse->DadosFrete as $obj) {
            
            $prazo_entrega = (string)$obj->Prazo;
            $valor_servico = (string)$obj->ValorServico;
        }

        ($prazo_entrega === null) ?  $prazo_entrega = 0 : $prazo_entrega;
        
        #$prazo_entrega;
        
        
        $total_geral = trim($_POST["total_geral"]);
        $total_geral = str_replace(".", "", $total_geral);
        $total_geral = str_replace(",", "", $total_geral);

        $total_impostos = trim($_POST["total_impostos"]);
        $total_impostos = str_replace(".", "", $total_impostos);
        $total_impostos = str_replace(",", "", $total_impostos);

        $valor = $valor_servico;
        $valor = str_replace(".", "", $valor);
        $valor = str_replace(",", "", $valor);

        if ((int) $total_geral >= 9000) {
            $soma = ((int) $total_geral + (int) $total_impostos);
        } else {
            $soma = ((int) $total_geral + (int) $valor + (int) $total_impostos);
        }

        $dados["total_geral"] = $total_geral;
        $dados["valor_servico"] = $valor_servico;
        $dados["total_impostos"] = $total_impostos;
        $dados["valor"] = $valor;
        $dados["prazo_entrega"] = $prazo_entrega;
        $dados["soma"] = $model->formataReais($soma);
        $dados["frete"] = ((int) $total_geral >= 9000) ? "Gratis" : $model->formataReais($valor);
        $dados["msg_erro"] = ((int) $total_geral >= 9000) ? "Para esta compra o frete é Gratis" : "";
        echo json_encode($dados);


        // echo json_encode($valor_servico);
        curl_close($ch);
    }
} else if ($_POST["forma_envio"] == "Retirada na Loja") {

    $total_geral = $_POST["total_geral"];
    $total_geral = str_replace(".", "", $total_geral);
    $total_geral = str_replace(",", "", $total_geral);

    $total_impostos = trim($_POST["total_impostos"]);
    $total_impostos = str_replace(".", "", $total_impostos);
    $total_impostos = str_replace(",", "", $total_impostos);

    $valor = 0;
    $valor = str_replace(".", "", $valor);
    $valor = str_replace(",", "", $valor);

    $soma = ((int) $total_geral + (int) $valor + (int) $total_impostos);

    $dados["soma"] = $model->formataReais($soma);
    $dados["frete"] =  "Retirar na Loja";
    $dados["msg_erro"] = "Para esta compra o frete é Gratis";
    echo json_encode($dados);
    
} else {

    $frete = new RsCorreios();

    $frete->setValue('sCepOrigem', $_POST["cep_remetente"]);
    $frete->setValue('sCepDestino', $_POST["cep_destinatario"]);
    $frete->setValue('nVlPeso', $_POST["total_peso"]);
    $frete->setValue('nVlComprimento', '16');
    $frete->setValue('nVlAltura', '2');
    $frete->setValue('nVlLargura', '11');
    $frete->setValue('nCdServico', $_POST["forma_envio"]);

    $frete->getDiametro();
    $result = $frete->getFrete();

    //Retornamos a mensagem de erro caso haja alguma falha
    if ($result['erro'] != 0) {

        //$resultadoFrete = $result['msg_erro'];
        $total_geral = $_POST["total_geral"];
        $total_geral = str_replace(".", "", $total_geral);
        $total_geral = str_replace(",", "", $total_geral);

        $total_impostos = trim($_POST["total_impostos"]);
        $total_impostos = str_replace(".", "", $total_impostos);
        $total_impostos = str_replace(",", "", $total_impostos);

        $valor = 0;
        $valor = str_replace(".", "", $valor);
        $valor = str_replace(",", "", $valor);

        $soma = ((int) $total_geral + (int) $valor + (int) $total_impostos);

        $dados["soma"] = $model->formataReais($soma);
        $dados["frete"] = "0,00";
        $dados["msg_erro"] = "Serviço indisponível para esta Localidade!";
        echo json_encode($dados);
        
    } else {

        $resultadoFrete = "Código do Serviço: " . $result['servico_codigo'] . "\n";
        $resultadoFrete .= "Valor do Frete: R$ " . $result['valor'] . "\n";
        $resultadoFrete .= "Prazo de Entrega: " . $result['prazo_entrega'] . " dias\n";
        $resultadoFrete .= "Valor p/ Mão Própria: R$ " . $result['mao_propria'] . "\n";
        $resultadoFrete .= "Valor Aviso de Recebimento: R$ " . $result['aviso_recebimento'] . "\n";
        $resultadoFrete .= "Valor Declarado: R$ " . $result['valor_declarado'] . "\n";
        $resultadoFrete .= "Entrega Domiciliar: " . $result['en_domiciliar'] . "\n";
        $resultadoFrete .= "Entrega Sábado: " . $result['en_sabado'] . "\n";


        $total_geral = trim($_POST["total_geral"]);
        $total_geral = str_replace(".", "", $total_geral);
        $total_geral = str_replace(",", "", $total_geral);

        $total_impostos = trim($_POST["total_impostos"]);
        $total_impostos = str_replace(".", "", $total_impostos);
        $total_impostos = str_replace(",", "", $total_impostos);

        $valor = $result['valor'];
        $valor = str_replace(".", "", $valor);
        $valor = str_replace(",", "", $valor);

        if ((int) $total_geral >= 9000) {
            $soma = ((int) $total_geral + (int) $total_impostos);
        } else {
            $soma = ((int) $total_geral + (int) $valor + (int) $total_impostos);
        }

        
        $dados["prazo_entrega"] = (string) $result['prazo_entrega'];
        $dados["soma"] = $model->formataReais($soma);
        $dados["frete"] = ((int) $total_geral >= 9000) ? "Gratis" : $model->formataReais($valor);
        $dados["msg_erro"] = ((int) $total_geral >= 9000) ? "Para esta compra o frete é Gratis" : "";
        echo json_encode($dados);
    }
}







//echo $resultadoFrete;


die();

/*
  function calcula_frete($servico, $CEPorigem, $CEPdestino, $peso, $altura = '2', $largura = '11', $comprimento = '16', $valor = '0') {
  ////////////////////////////////////////////////
  // Código dos Serviços dos Correios
  // 41106 PAC
  // 40010 SEDEX
  // 40045 SEDEX a Cobrar
  // 40215 SEDEX 10
  ////////////////////////////////////////////////
  // URL do WebService
  $correios = "http://ws.correios.com.br/calculador/CalcPrecoPrazo.aspx?nCdEmpresa=&sDsSenha=&sCepOrigem=" . $CEPorigem . "&sCepDestino=" . $CEPdestino . "&nVlPeso=" . $peso . "&nCdFormato=1&nVlComprimento=" . $comprimento . "&nVlAltura=" . $altura . "&nVlLargura=" . $largura . "&sCdMaoPropria=n&nVlValorDeclarado=" . $valor . "&sCdAvisoRecebimento=n&nCdServico=" . $servico . "&nVlDiametro=0&StrRetorno=xml";
  // Carrega o XML de Retorno
  $xml = simplexml_load_file($correios);
  // Verifica se não há erros


  var_dump($xml);

  if ($xml->cServico->Erro == '0') {
  return $xml->cServico->Valor;
  } else {
  return false;
  }
  }

  echo calcula_frete($_POST["forma_envio"],$_POST["cep_remetente"],$_POST["cep_destinatario"],$_POST["total_peso"]);
 */
?>