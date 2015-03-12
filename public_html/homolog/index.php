<?php

error_reporting(0);
session_start();

define("DIR", getcwd());
define("PROTOCOLO", "https://");
#define("SOURCE", "homolog");
define("SOURCE", "");

if (strlen(SOURCE) > 0) {
    define("LANGUAGE", SOURCE . "/" . substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2));
    define("WEB_FILES", "/" . SOURCE . "/web-files");
    define("LOGO", SOURCE . "/web-files/img/logo.png");
} else {
    define("LANGUAGE", substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2));
    define("WEB_FILES", "/web-files");
    define("LOGO", "web-files/img/logo.png");
}



define("SITE", "www.mariadebarro.com.br/");
define("DOMINIO_COOKIES", "www.mariadebarro.com.br");
define("MEU_SITE", PROTOCOLO . SITE . LANGUAGE . "/");
define("CONTROLLERS", "application/controllers/");
define("VIEWS", "application/views/");
define("MODELS", "application/models/");
define("LIBRARIES", "libraries/");
define("SYSTEM", "system/");
define("HELPERS", "system/helpers/");
define("TITLE", "Maria de Barro | Acessórios femininos, anéis, brincos, colares, pulseiras, conjuntos, semijoias");
define("TITLE_LOJA", "Maria de Barro");
define("CEP_REMETENTE", "22780-084");
define("EMAIL_PAYPAL", "maria@mariadebarro.com.br");
define("EMAIL_MOIP", "maria@mariadebarro.com.br");
define("ALIAS_EMAIL", "-f");

define("URL_RETORNO", PROTOCOLO . SITE . LANGUAGE . "/mensagem/retorno");
define("URL_CANCELAMENTO", PROTOCOLO . SITE . LANGUAGE . "/mensagem/cancelamento");
define("URL_NOTIFICACAO", PROTOCOLO . SITE . LANGUAGE . "/mensagem/notificacao");

define("FACEBOOK", "https://www.facebook.com/mariadebarroacessorios");
define("INSTAGRAM", "http://instagram.com/mariadebarro");
define("TWITTER", "https://twitter.com/Maria_de_barro");
define("GOOGLE_PLUS", "https://plus.google.com/u/0/113176039094986209102/posts");


define("OG_TITLE", "Loja - mariadebarro.com");
define("OG_TYPE", "product");
define("OG_SITE_NAME", "mariadebarro.com");
define("OG_DESCRIPITION", "");
define("OG_EMAIL", "maria@mariadebarro.com.br");
define("OG_PHONE_NUMBER", "21 32835265");
define("OG_STREET_ADDRESS", "Edifício Global 7000 Offices, Estrada dos Bandeirantes, 7000 - Rio de Janeiro/RJ - CEP: 22780-084, Bloco C Sala 290");
define("OG_LOCALITY", "Rio de Janeiro");
define("OG_REGION", "Rio de Janeiro — Capital");
define("OG_COUNTRY_NAME", "Brasil");
define("OG_POSTAL_CODE", "22780-084");

define("IMPOSTO", "0.92");
define("BONUS", "0.95");


#Ambiente final da loja Cielo
define("CIELO_N", "1056840215");
define("CIELO_KEY", "c6409f497ff3bcfeb3f802ac6719fdba34cdb54ec36fe4bcd568bd5ddebd9bb9");
define("CIELO_URL", "https://ecommerce.cielo.com.br/servicos/ecommwsec.do");

#Ambiente de testes da loja Cielo
#define("CIELO_N", "1006993069");
#define("CIELO_KEY", "25fbb99741c739dd84d7b06ec78c9bac718838630f30b112d033ce2e621b34f3 ");
#define("CIELO_URL", "https://qasecommerce.cielo.com.br/servicos/ecommwsec.do");

if ($_SESSION) {
    foreach ($_SESSION as $name => $valor) {
        define($name, $valor);
    }
}

$_SERVER['EMAIL_IMG_FOLDER'] = "https://www.mariadebarro.com.br/homolog/emails/images";
define("REMOTE_ADDR", $_SERVER["REMOTE_ADDR"]);
define("SERVER_ADDR", $_SERVER["SERVER_ADDR"]);
define("HOSTNAME_LOCAL", gethostbyaddr($_SERVER["REMOTE_ADDR"]));
define("HOSTNAME_SERVER", gethostbyaddr($_SERVER["SERVER_ADDR"]));

if (!isset($_COOKIE["CLIENT_HIDDEN"])) {
    setcookie("CLIENT_HIDDEN", strtoupper(md5(uniqid(rand(), true))), time() + 60 * 60 * 24 * 365, "/", DOMINIO_COOKIES, 0, TRUE);
    echo "<script>window.location='" . PROTOCOLO . SITE . LANGUAGE . "/'</script>";
}

define("CLIENT_HIDDEN", $_COOKIE["CLIENT_HIDDEN"]);

( strlen(SOURCE) > 0) ? $_GET["url"] = str_replace(SOURCE . "/", "", $_GET["url"]) : $_GET["url"];

if ($_GET["url"] == "") {
    $_GET["url"] = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2) . "/";
}

if (!isset($_GET["url"])) {
    echo "<script>window.location='" . PROTOCOLO . SITE . LANGUAGE . "/'</script>";
} else if (strlen($_GET["url"]) == 2) {
    echo "<script>window.location='" . PROTOCOLO . SITE . LANGUAGE . "/'</script>";
} else if (strtolower($_GET["url"]) == "admin") {
    echo "<script>window.location='" . PROTOCOLO . SITE . LANGUAGE . "/admin/'</script>";
}

require_once( SYSTEM . "system.php");
$start = new System();
$controller = $start->controller;
$action = $start->action;

$app = new $controller();

if (method_exists($controller, $action)) {
    $app->$action();
} else {
    echo "<script>window.location='" . PROTOCOLO . SITE . SOURCE . "404/'</script>";
    exit();
}
