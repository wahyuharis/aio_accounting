<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Coa_jenis extends CI_Controller {

    private $title = "Jenis Akun";
    private $url_controller = "master/coa_jenis/";
    private $id_business = "";

    public function __construct() {
        parent::__construct();
        $auth = new Auth_model();
        $this->id_business = $auth->get_userdata('id_business');
    }

    public function index() {
        $app_model = new Application_model();
        $app = $app_model->get_all_data();

        $this->load->helper('haris_helper');
        $data_contents = array();
        $data_contents['url_controller'] = $this->url_controller;
        $data_contents['panel_title'] = $this->title;
        $data_contents['content'] = '';

        $this->load->library('grocery_CRUD');
        try {
            $crud = new grocery_CRUD();
            $crud->unset_jquery();
            $crud->unset_bootstrap();
            $crud->set_theme('bootstrap');

            $crud->where('status', 1);
            $crud->where('id_business', $this->id_business);

            $crud->set_table('m_coa_jenis');
            $crud->set_subject($this->title);
            $crud->columns('id_m_coa_jenis', 'nama', 'keterangan');
            $crud->fields('nama', 'keterangan', 'id_business');
            $crud->required_fields('nama', 'id_business');
            $crud->display_as('id_m_coa_jenis','ID');
            
            $crud->unset_read();

            $crud->field_type('id_business', 'hidden', $this->id_business);


            $crud->callback_delete(array($this, '_callback_delete'));
            $crud->callback_before_update(array($this, '_callback_before_update'));
            $crud->callback_before_insert(array($this, '_callback_before_insert'));
            $crud->callback_after_insert(array($this, '_callback_after_insert'));
            $crud->callback_after_update(array($this, '_callback_after_update'));

            $state = $crud->getState();
            $state_info = $crud->getStateInfo();


            if ($state == 'edit') {
                $primary_key = $state_info->primary_key;
                $where_edit = array(
                    'id_business' => $this->id_business,
                    'id_m_coa_jenis' => $primary_key
                );
                $total_row = $this->db->where($where_edit)->get('m_coa_jenis')->num_rows();
                if ($total_row < 1) {
                    show_error("Maaf, Anda Tidak Dapat Mengakses Halaman Ini");
                    die();
                }
            }

            if ($this->last_uri() == 'delete_multiple') {
                $this->_delete_multiple();
            }

            $output = $crud->render();
            $css_files = $output->css_files;
            $js_files = $output->js_files;
            $data_contents['content'] = $output->output;
        } catch (Exception $e) {
            show_error($e->getMessage() . ' --- ' . $e->getTraceAsString());
        }

        $content = $this->load->view('content/general_grocery', $data_contents, true);

        $template = array(
            'url_controller' => $this->url_controller,
            'content' => $content,
            'page_title' => $this->title,
            'content_title' => $this->title,
            'company_name' => $app['company_name'],
            'app_name' => $app['application_name'],
            'css_files' => $css_files,
            'js_files' => $js_files
        );
        $this->load->view('template', $template);
    }

    function _delete_multiple() {
        $ids = $this->input->post('ids');

        $ids = $this->input->post('ids');
        if (is_array($ids)) {
            foreach ($ids as $row) {
                $this->db->where('id_m_coa_jenis', $row);
                $this->db->update('m_coa_jenis', array('status' => 0));
            }
        }
    }

    function _callback_before_update($post_array, $primary_key) {

        return $post_array;
    }

    function _callback_before_insert($post_array, $primary) {
        return $post_array;
    }

    function _callback_after_update($post_array, $primary) {


        return $post_array;
    }

    function _callback_after_insert($post_array, $primary) {

        return $post_array;
    }

    public function _callback_delete($primary_key) {

        $this->db->where('id_m_coa_jenis', $primary_key);
        $this->db->update('m_coa_jenis', array('status' => 0));

        return true;
    }

    private function last_uri() {
        $last_uri = '';
        foreach ($this->uri->segment_array() as $row) {
            $last_uri = $row;
        }
        return $last_uri;
    }

}
