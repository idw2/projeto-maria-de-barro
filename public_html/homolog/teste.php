
<!-- Início do código Total Express - Tracking Público de Encomendas - v.1.0 -->
<a href="#" onclick="window.open('http://tracking.totalexpress.com.br/tracking/3359', 'tracking_totalexpress', 'width=580, height=400, location=0, scrollbars=1');"><img src="http://tracking.totalexpress.com.br/images/trackingpub.gif" border="0" /></a>
<!-- Fim do código Total Express - Tracking Público de Encomendas -->


<?php
die();

$text = '<p>Test paragraph.</p><!-- Comment --> <a href="#fragment">Other text</a>';
#echo htmlspecialchars($text);
echo htmlspecialchars($text, ENT_QUOTES);
echo "\n";

echo AntiXSS::setEncoding($text, "UTF-8");

// Allow <p> and <a>
echo strip_tags($text, '<p><a>');
exit();

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


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
                <CepDestino xsi:type = "xsd:nonNegativeInteger">72450050</CepDestino>
                <Peso xsi:type = "xsd:decimal">0.3</Peso>
                <ValorDeclarado xsi:type = "xsd:decimal">34.30</ValorDeclarado>
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
    print "Error: " . curl_error($ch);
} else {

    $data = curl_exec($ch);

$string = <<<XML
$data
XML;

//echo "<script>alert('{$data}')</script>";

    $soap = simplexml_load_string($string);
    
    $soap->children('SOAP-ENV', true)->Body->children('ns1', true)->calcularFreteResponse->children()->calcularFreteResponse->DadosFrete;
    
    foreach ( $soap->children('SOAP-ENV', true)->Body->children('ns1', true)->calcularFreteResponse->children()->calcularFreteResponse->DadosFrete as $obj) {
        $prazo_entrega = $obj->Prazo;
        $valor_servico = $obj->ValorServico;
    }

    echo $valor_servico;
    curl_close($ch);
}
