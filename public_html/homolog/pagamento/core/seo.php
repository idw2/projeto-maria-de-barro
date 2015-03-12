<?php

class SEO {

    private $page_url;
    private $page_slug;
    private $page_title;
    private $page_description;

    const defaultTitle = "Cielo - Maria de Barro";
    const defaultDescription = "";
    const author = "DesignLab";

    public function __construct() {
        $get = $_GET;

        if (isset($get['url'])) {
            $params = explode('/', $get['url']);

            $this->page_slug = $params[0];
            if (isset($params[1]))
                $this->page_slug = $params[1];
        }

        if ($this->page_slug == '')
            $this->page_slug = 'home';
        
    }

    public function get_url() {
        return $this->page_url;
    }

    public function get_slug() {
        return $this->page_slug;
    }

    public function get_title() {
        switch ($this->page_slug) {
            case 'page-1':
                return 'Page 1 - ' . SEO::defaultTitle;
                break;

            default:
                return SEO::defaultTitle;
                break;
        }
    }

    public function get_description() {
        switch ($this->page_slug) {
            case 'home':
                return SEO::defaultDescription;
                break;

            default:
                return SEO::defaultDescription;
                break;
        }
    }

}
