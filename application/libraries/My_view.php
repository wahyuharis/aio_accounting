<?php

class My_view {

    private $view_location = "";

    public function __construct() {
        
    }

    function set_view_location($view_location) {
        $this->view_location = $view_location;
        return $this;
    }

    function load($view_name, $data) {
        $this->view_location = rtrim($this->view_location, '/');

        $buff = explode(".", $view_name);
        if ($buff[count($buff) - 1] == "php") {
            $view_name = str_replace(".php", "", $view_name);
        }

        extract($data);
        ob_start();
        include APPPATH . 'controllers/' . $this->view_location . "/" . $view_name . '.php';
        return ob_get_clean();
    }

}
