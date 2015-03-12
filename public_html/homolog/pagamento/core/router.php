<?php

class Router {

    private $url;
    private $view;

    public function __construct() {
        
    }

    public function load() {
        $get = $_GET;

        if (isset($get['url'])) {
            $params = explode('/', $get['url']);

            $this->url = $params[0];
            if (isset($params[1]))
                $this->view = $params[1];
        }

        if ($this->url == '')
            $this->url = 'home';


        $this->url = str_replace('-', '_', $this->url);

        if ($this->view == "") {
            $pagina = PAGINAS . DS . $this->url . '.php';
        } else {
            $pagina = PAGINAS . DS . $this->url . DS . $this->view . '.php';
        }

        if (is_file($pagina)) {
            require $pagina;
        } else {
            require ROOT . DS . '404.php';
        }
    }

    public function get_view() {
        return $this->view;
    }

}
