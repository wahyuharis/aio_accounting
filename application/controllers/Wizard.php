<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Wizard extends CI_Controller
{

    private $title = "Wizard Bisnis";
    private $url_controller = 'Wizard_bisnis';

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');

        $this->load->model('auth/Auth_super_user_model');
        $auth_sa = new Auth_super_user_model();
        $auth_sa->is_logged_in();
    }

    public function index()
    {
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
        // $data_contents['bs_type'] = $this->data_model->get_all('m_business_type');
        $content = $this->load->view('wizard/wizard_bisnis', $data_contents, true);

        $css_files = array();
        $js_files = array();

        $template = array(
            // 'url_controller' => $this->url_controller,
            'content' => $content,
            'page_title' => $this->title,
            'content_title' => $this->title,
            'css_files' => $css_files,
            'js_files' => $js_files
        );
        $this->load->view('template_owner_dashboard', $template);
    }

    function ambil_data()
    {
        $modul = $this->input->post('modul');
        $id_jenis_usaha = $this->input->post('id_jenis_usaha');
        if ($modul == "jenis_usaha") {
            echo $this->data_model->jenis_usaha($id_jenis_usaha);
        }
    }

    function tambah_bisnis()
    { }
}
