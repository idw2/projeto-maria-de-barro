<?php

	header('Content-Type: application/json');
	require("../../system/phpQuery-onefile.php");
		
	function getEndereco($cep)
	{
		$cep = str_replace("-","",$cep);
		define('POSTURL', 'http://m.correios.com.br/movel/buscaCepConfirma.do');
		define('POSTVARS', 'cepEntrada=' . $cep . '&metodo=buscarCep');  // POST VARIABLES TO BE SENT

		$ch = curl_init( POSTURL) ;
		curl_setopt($ch, CURLOPT_POST      ,1);
		curl_setopt($ch, CURLOPT_POSTFIELDS    ,POSTVARS);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1 );
		curl_setopt($ch, CURLOPT_HEADER, 0 );  // DO NOT RETURN HTTP HEADERS
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );  // RETURN THE CONTENTS OF THE CALL
		$html = curl_exec($ch);

		phpQuery::newDocumentHTML($html, $charset = 'utf-8');

		$dados = 
		array(
		'Logradouro'=> trim(pq('.caixacampobranco .resposta:contains("Logradouro: ") + .respostadestaque:eq(0)')->html()),
		'Bairro'=> trim(pq('.caixacampobranco .resposta:contains("Bairro: ") + .respostadestaque:eq(0)')->html()),
		'Cidade/uf'=> trim(pq('.caixacampobranco .resposta:contains("Localidade / UF: ") + .respostadestaque:eq(0)')->html()),
		'Cep'=> trim(pq('.caixacampobranco .resposta:contains("CEP: ") + .respostadestaque:eq(0)')->html())
		);

		$dados['Cidade/uf'] = explode('/',$dados['Cidade/uf']);
		$dados['Cidade'] = trim($dados['Cidade/uf'][0]);
		$dados['UF'] = trim($dados['Cidade/uf'][1]);
		unset($dados['Cidade/uf']);
		
		curl_close($ch); 
		return $dados;
		
	}
	
	echo json_encode(getEndereco($_POST["cep"]));

?>