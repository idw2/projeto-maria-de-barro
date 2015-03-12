<?php

class My_smarty extends Smarty {

    function get_smarty() {
        parent::__construct();

        $this->setCacheDir(DIR . "/application/views/cache");
        $this->setConfigDir(DIR . "/application/views/config");
        $this->setTemplateDir(DIR . "/application/views");
        $this->setCompileDir(DIR . "/application/views/compiled");

        $this->force_compile = 1;
        $this->caching = true;
        $this->cache_lifetime = 120;
    }

    function view_tpl($template_name) {
        if (strpos($template_name, '.') === FALSE && strpos($template_name, ':') === FALSE) {
            $template_name .= '.tpl';
        }

        $this->display($template_name);
    }
    
}
