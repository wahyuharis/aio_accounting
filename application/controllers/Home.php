<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    private $title = "Dashboard";
    private $url_controller = 'home/index';

    public function __construct() {
        parent::__construct();
    }

    public function index() {        
        $app_model = new Application_model();
        $app = $app_model->get_all_data();

        $this->load->helper('haris_helper');
        $data_contents = array();
        $data_contents['panel_title'] = $this->title . "";

        $content = $this->load->view('content/home', $data_contents, true);

        $css_files = array(
            'gentelella/vendors/select2/dist/css/select2.min.css'
        );
        $js_files = array(
            'gentelella/vendors/select2/dist/js/select2.min.js'
        );

        $template = array(
            'url_controller' => 'home/index/',
            'content' => $content,
            'page_title' => $this->title,
            'content_title' => $this->title,
            'css_files' => $css_files,
            'js_files' => $js_files
        );
        $this->load->view('template', $template);
//        $this->load->view('template2', $template);
    }
}
