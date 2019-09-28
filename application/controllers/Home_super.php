<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home_super extends CI_Controller {

    private $title = "Dashboard";
    private $url_controller = 'Home_owner';

    public function __construct() {
        parent::__construct();
        $this->load->library('session');

        $this->load->model('auth/Auth_super_user_model');
        $auth_sa = new Auth_super_user_model();
        $auth_sa->is_logged_in();
    }

    public function index() {
        $app_model = new Application_model();
        $app = $app_model->get_all_data();

        $this->load->helper('haris_helper');
        $data_contents = array();
        $data_contents['panel_title'] = $this->title . "";

        $user_super = new Auth_super_user_model();
        $user_data = $user_super->get_userdata();

        $this->db->where('id_owner', $user_data['id_user_owner']);
        $business_data = $this->db->get('m_business')->result_array();

        $data_contents['business_data'] = $business_data;


        $content = $this->load->view('home_super/dashboard_super', $data_contents, true);

        $css_files = array();
        $js_files = array();

        $template = array(
            'url_controller' => $this->url_controller,
            'content' => $content,
            'page_title' => $this->title,
            'content_title' => $this->title,
            'css_files' => $css_files,
            'js_files' => $js_files
        );
        $this->load->view('template_owner_dashboard', $template);
    }

}
