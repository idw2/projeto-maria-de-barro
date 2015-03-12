<?php

define('SITE', 'https://www.mariadebarro.com.br/pagamento');
define('CORE', ROOT . DS . 'core');
define('PAGINAS', ROOT . DS . 'pages');
define('PARTIALS', ROOT . DS . 'partials');

require CORE . DS . 'functions.php';
require CORE . DS . 'seo.php';
require CORE . DS . 'router.php';

$route = new Router();
$route->load();