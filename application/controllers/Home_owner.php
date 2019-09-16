<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home_owner extends CI_Controller {

    private $title = "Dashboard";
    private $url_controller='Home_owner';

    public function __construct() {
        parent::__construct();
//        $auth = new Auth_model();
//        $auth->is_owner();
    }

    public function index() {
        $app_model = new Application_model();
        $app = $app_model->get_all_data();

        $this->load->helper('haris_helper');
        $data_contents = array();
        $data_contents['panel_title'] = $this->title . "";

        $content = $this->load->view('content/home', $data_contents, true);

        $css_files = array();
        $js_files = array();

        $template = array(
            'url_controller'=> $this->url_controller,
            'content' => $content,
            'page_title' => $this->title,
            'content_title' => $this->title,
            'company_name' => $app['company_name'],
            'app_name' => $app['application_name'],
            'css_files' => $css_files,
            'js_files' => $js_files
        );
        $this->load->view('template_owner_dashboard', $template);
    }

}
