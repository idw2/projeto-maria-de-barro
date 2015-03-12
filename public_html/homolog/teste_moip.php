<?php


echo number_format("1000000",2);
die();

ob_start();
$token = "DFNH0PFD7R9XYPYREWSY76XDFS8B5T9Z";
$key = "9MSJ9GDN9B8HROTYJZ8HE162JMJB1QPJLBA4F0P2";


$base = $token . ":" . $key;
$auth = base64_encode($base);
$header[] = "Authorization: Basic " . $auth;
$param = "
<EnviarInstrucao>
<InstrucaoUnica> <!-- Identificador do tipo de instrução --> 
<!-- *********** DADOS OBRIGAT?~SRIOS *********** -->
<Razao>Pagamento direto com boleto</Razao>
<Valores>
<Valor moeda=\"BRL\">150.25</Valor>
</Valores>
<IdProprio>". rand(1,1000) ."</IdProprio>
<PagamentoDireto>
<Forma>BoletoBancario</Forma>
</PagamentoDireto>
<Pagador>
<Nome>Luiz Inácio Lula da Silva</Nome>
<LoginMoIP>maria@mariadebarro.com.br</LoginMoIP>
<Email>presidente@planalto.gov.br</Email>
<TelefoneCelular>(61)9999-9999</TelefoneCelular>
<Apelido>Lula</Apelido>
<Identidade>111.111.111-11</Identidade>
<EnderecoCobranca>
<Logradouro>Praça dos Três Poderes</Logradouro>
<Numero>0</Numero>
<Complemento>Palácio do Planalto</Complemento>
<Bairro>Zona Cívico-Administrativa</Bairro>
<Cidade>Brasília</Cidade>
<Estado>DF</Estado>
<Pais>BRA</Pais>
<CEP>70100-000</CEP>
<TelefoneFixo>(61)3211-1221</TelefoneFixo>
</EnderecoCobranca>
</Pagador>
<!-- *********** DADOS RECOMENDADOS *********** -->
<Boleto>
<DiasExpiracao Tipo=\"Corridos\">5</DiasExpiracao>
</Boleto>
</InstrucaoUnica>
</EnviarInstrucao>";

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, "https://desenvolvedor.moip.com.br/sandbox/ws/alpha/EnviarInstrucao/Unica");
curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
curl_setopt($curl, CURLOPT_USERPWD, $user . ":" . $passwd);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/4.0");
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $param);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$ret = curl_exec($curl);
$err = curl_error($curl);
curl_close($curl);
$xml = new SimpleXMLElement($ret);
echo "<pre>";
$token = $xml->Resposta->Token[0];
$url = 'Location: https://desenvolvedor.moip.com.br/sandbox/Instrucao.do?token='.$token;
header($url);

die();


$seu_token = "ZO32XH17VEGS3WVD73PP6KM9AZCOBBNL";
$sua_key = "BZGVSWCXLX4ADGTMSYIKNWJ7YH4NGVZV8JH1Y6NS";

$auth = $seu_token.':'.$sua_key;

$xml = "<EnviarInstrucao>
    <InstrucaoUnica> 
        <Razao>Pagamento direto com boleto</Razao>
        <Valores>
             <Valor moeda='BRL'>160.25</Valor>
        </Valores>
        <IdProprio>dir_bol_5</IdProprio>
        <PagamentoDireto>
             <Forma>BoletoBancario</Forma>
        </PagamentoDireto>
        <Pagador>
        	<Nome>Luiz Inácio Lula da Silva</Nome>
        	<LoginMoIP>maria@mariadebarro.com.br</LoginMoIP>
        	<Email>presidente@planalto.gov.br</Email>
        	<TelefoneCelular>(61)9999-9999</TelefoneCelular>
        	<Apelido>Lula</Apelido>
        	<Identidade>111.111.111-11</Identidade>
        	<EnderecoCobranca>
        		<Logradouro>Praça dos Três Poderes</Logradouro>
        		<Numero>0</Numero>
        		<Complemento>Palácio do Planalto</Complemento>
        		<Bairro>Zona Cívico-Administrativa</Bairro>
        		<Cidade>Brasília</Cidade>
        		<Estado>DF</Estado>
        		<Pais>BRA</Pais>
        		<CEP>70100-000</CEP>
        		<TelefoneFixo>(61)3211-1221</TelefoneFixo>
        	</EnderecoCobranca>
        </Pagador>
        <Boleto>
             <DiasExpiracao Tipo='Corridos'>5</DiasExpiracao>
        </Boleto>
    </InstrucaoUnica>
</EnviarInstrucao>";

//$xml = "<EnviarInstrucao>
//    <InstrucaoUnica TipoValidacao='Transparente'>
// 
//        <Razao>Pagamento para loja X</Razao>
//         
//        <Valores>
//            <Valor Moeda='BRL'>100.00</Valor>
//            <Acrescimo Moeda='BRL'>30.00</Acrescimo>
//            <Deducao Moeda='BRL'>10.00</Deducao>
//        </Valores>        
//         
//        <IdProprio>ABC123456789</IdProprio>
//         
//        <Parcelamentos>
//            <Parcelamento>
//                <MinimoParcelas>2</MinimoParcelas>
//                <MaximoParcelas>12</MaximoParcelas>
//                <Juros>1.99</Juros>
//            </Parcelamento>
//        </Parcelamentos>
// 
//        <Comissoes>
//            <Comissionamento>
//                <Comissionado>
//                    <LoginMoIP>recebedor_secundario</LoginMoIP>
//                </Comissionado>
//                <Razao>Motivo da comissão</Razao>
//                <ValorFixo>10.00</ValorFixo>
//                <ValorPercentual>12.00</ValorPercentual>
//            </Comissionamento>
//        </Comissoes>
// 
//        <Recebedor>
//            <LoginMoIP>recebedor_primario</LoginMoIP>
//            <Apelido>Nome Fantasia</Apelido>
//        </Recebedor>
// 
//         <Pagador>
//            <Nome>Cliente Sobrenome</Nome>
//            <Email>login@meudominio.com.br</Email>
//            <IdPagador>login@meudominio.com.br</IdPagador>
//            <EnderecoCobranca>
//                <Logradouro>Av. Brigadeiro Faria Lima</Logradouro>
//                <Numero>2927</Numero>
//                <Complemento>8° Andar</Complemento>
//                <Bairro>Jardim Paulistao</Bairro>
//                <Cidade>Sao Paulo</Cidade>
//                <Estado>SP</Estado>
//                <Pais>BRA</Pais>
//                <CEP>01452-000</CEP>
//                <TelefoneFixo>(11)3165-4020</TelefoneFixo>
//            </EnderecoCobranca>
//        </Pagador>
//                
//        <FormasPagamento>
//            <FormaPagamento>CartaoCredito</FormaPagamento>
//            <FormaPagamento>CartaoDebito</FormaPagamento>
//            <FormaPagamento>DebitoBancario</FormaPagamento>
//            <FormaPagamento>FinanciamentoBancario</FormaPagamento>
//            <FormaPagamento>BoletoBancario</FormaPagamento>
//        </FormasPagamento>      
//         
//        <Entrega>
//            <Destino>MesmoCobranca</Destino>
//            <CalculoFrete>
//                <Tipo>Correios</Tipo>
//                <Correios>
//                    <PesoTotal>1000</PesoTotal>
//                    <FormaEntrega>Sedex</FormaEntrega>
//                    <ValorDeclarado>Sim</ValorDeclarado>
//                    <CepOrigem>01230000</CepOrigem>
//                </Correios>
//            </CalculoFrete>
//        </Entrega>
// 
//        <Mensagens>
//            <Mensagem>Mensagem adicional</Mensagem>
//        </Mensagens>        
//         
//        <Boleto>
//            <DataVencimento>2000-12-31T12:00:00.000-03:00</DataVencimento>
//            <Instrucao1>Primeira linha de mensagem adicional</Instrucao1>
//            <Instrucao2>Segunda linha</Instrucao2>
//            <Instrucao3>Terceira linha</Instrucao3>
//            <URLLogo>http://meusite.com.br/meulogo.jpg</URLLogo>
//        </Boleto>
// 
//        <URLNotificacao>http://meusite.com.br/notificacao/</URLNotificacao>
//         
//        <URLRetorno>http://meusite.com.br/</URLRetorno>
// 
//    </InstrucaoUnica>
//</EnviarInstrucao>";

//O HTTP Basic Auth é utilizado para autenticação
$header[] = "Authorization: Basic " . base64_encode($auth);

//URL do SandBox - Nosso ambiente de testes
//$url = "https://desenvolvedor.moip.com.br/sandbox/ws/alpha/EnviarInstrucao/Unica";
//$url = "https://www.moip.com.br/ws/EnviarInstrucao/Unica";
$url = "https://www.moip.com.br/ws/alpha/EnviarInstrucao/Unica";

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL,$url);

//header que diz que queremos autenticar utilizando o HTTP Basic Auth
curl_setopt($curl, CURLOPT_HTTPHEADER, $header);

//informa nossas credenciais
curl_setopt($curl, CURLOPT_USERPWD, $auth);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/4.0");
curl_setopt($curl, CURLOPT_POST, true);

//Informa nosso XML de instrução
curl_setopt($curl, CURLOPT_POSTFIELDS, $xml);

curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

//efetua a requisição e coloca a resposta do servidor do MoIP em $ret
$ret = curl_exec($curl);
$err = curl_error($curl);
curl_close($curl);

echo $ret;
//https://desenvolvedor.moip.com.br/sandbox/Instrucao.do?token=V230S1M4G1O0P0O8M2T1E0I3O5Z644N9S3F080D0B0P0N0R662S285W0X4I1     
//https://www.moip.com.br/Instrucao.do?token=E2Y0D1D4R1I0X0Y8B2D1F0B6G0Y4X8R6D250P0V0Y0F0Z0R6T2R2E550W464     