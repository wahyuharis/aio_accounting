<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Supplier_list extends CI_Controller {

    private $title = "Supplier";
    private $url_controller = "pembelian/supplier_list/";
    private $id_business = "";

    public function __construct() {
        parent::__construct();
        $auth = new Auth_model();
        $this->id_business = $auth->get_userdata('id_business');
    }

    public function index() {

        $this->load->helper('haris_helper');
        $data_contents = array();
        $data_contents['url_controller'] = $this->url_controller;
        $data_contents['panel_title'] = $this->title . " List";
        $data_contents['content'] = '';

        $this->load->library('grocery_filter_ids');
        $gci_filter = new Grocery_filter_ids();
        $filter = $gci_filter->get_filter('regencies_id');
        $gci_filter->set_sql("select tb_regencies.id as kota
        from tb_regencies
        left JOIN tb_provinces on tb_provinces.id=tb_regencies.province_id
        where concat(tb_regencies.name,'-',tb_provinces.name) "
                . "LIKE '%" . $this->db->escape_str($filter) . "%'");


        $this->load->library('grocery_CRUD');
        try {
            $crud = new grocery_CRUD();
            $crud->unset_jquery();
            $crud->unset_bootstrap();
            $crud->set_theme('bootstrap');

            $crud->where('m_supplier.status', 1);
            $crud->where('m_supplier.id_business', $this->id_business);
            if (!empty($filter)) {
                $crud->where("regencies_id in (" . $gci_filter->get_ids() . ") ");
            }

            $crud->set_table('m_supplier');
            $crud->set_subject($this->title);
            $crud->columns("nama", "email", "phone", "phone_kantor", "alamat", "regencies_id");
            $crud->unset_read();
            $state = $crud->getState();
            if ($state == 'add') {
                redirect($this->url_controller . "add");
            }
            $crud->unset_edit();
            $crud->add_action('edit', '', $this->url_controller . 'edit', 'fa-pencil');


            $crud->callback_delete(array($this, '_callback_delete'));
            $crud->callback_column('regencies_id', array($this, '_callback_column_kota'));
            if ($this->last_uri() == 'delete_multiple') {
                $this->_delete_multiple();
            }
            $crud->display_as('regencies_id', 'Kota');


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
            'css_files' => $css_files,
            'js_files' => $js_files
        );
        $this->load->view('template', $template);
    }

    function _callback_column_kota($value, $row) {
        $sql = "select concat(tb_regencies.name,' - ',tb_provinces.name) as kota
        from tb_regencies
        left JOIN tb_provinces on tb_provinces.id=tb_regencies.province_id
        where tb_regencies.id=" . $this->db->escape($value) . " ";
        $str = $this->db->query($sql)->row_array()['kota'];
        return $str;
    }

    public function _callback_delete($primary_key) {
        $this->db->update('m_supplier', array('status' => '0'), array('id_supplier' => $primary_key));
        return true;
    }

    private function last_uri() {
        $last_uri = '';
        foreach ($this->uri->segment_array() as $row) {
            $last_uri = $row;
        }
        return $last_uri;
    }

    function _delete_multiple() {
        $ids = $this->input->post('ids');
        if (is_array($ids)) {
            foreach ($ids as $row) {
                $this->db->where('id_supplier', $row);
                $this->db->update('m_supplier', array('status' => 0));
            }
        }
    }

    public function add() {
        $this->edit();
    }

    private function css_edit() {
        $css = array(
            'AdminLTE-2.4.2/bower_components/select2/dist/css/select2.min.css',
        );

        $this->load->helper('haris_helper');
        $css = base_url_from_array($css);
        return $css;
    }

    private function js_edit() {
        $js = array(
            'AdminLTE-2.4.2/bower_components/select2/dist/js/select2.full.min.js',
        );

        $this->load->helper('haris_helper');
        $js = base_url_from_array($js);

        return $js;
    }

    public function edit($id = null) {

        $this->load->helper('haris_helper');
        $data_contents = array();
        $data_contents['url_controller'] = $this->url_controller;
        $data_contents['panel_title'] = $this->title . " Add";
        if (!empty($id)) {
            $data_contents['panel_title'] = $this->title . " Edit";
        }

        $data_contents['id_supplier'] = '';
        $data_contents['id_business'] = $this->id_business;
        $data_contents['nama'] = '';
        $data_contents['email'] = '';
        $data_contents['phone'] = '';
        $data_contents['phone_kantor'] = '';
        $data_contents['alamat'] = '';
        $data_contents['province_id'] = '';
        $data_contents['regencies_id'] = '';
        $data_contents['regencies_selected'] = array();

        if (!empty($id)) {
            $this->db->where('id_supplier', $id);
            $this->db->where('id_business', $this->id_business);
            $row = $this->db->get('m_supplier')->row_array();

            $this->db->where('id', $row['regencies_id']);
            $result = $this->db->get('tb_regencies');
            $regencies_selected = array();

            if ($result->num_rows() > 0) {
                $regencies_selected[$result->row_array()['id']] = $result->row_array()['name'];
            }

            $data_contents['id_supplier'] = $row['id_supplier'];
            $data_contents['id_business'] = $this->id_business;
            $data_contents['nama'] = $row['nama'];
            $data_contents['email'] = $row['email'];
            $data_contents['phone'] = $row['phone'];
            $data_contents['phone_kantor'] = $row['phone_kantor'];
            $data_contents['alamat'] = $row['alamat'];
            $data_contents['province_id'] = $row['province_id'];
            $data_contents['regencies_id'] = $row['regencies_id'];
            $data_contents['regencies_selected'] = $regencies_selected;
            $data_contents['district_id'] = $row['district_id'];
        }


        $content = $this->load->view('content/supplier/supplier_edit', $data_contents, true);

        $css_files = $this->css_edit();
        $js_files = $this->js_edit();

        $template = array(
            'url_controller' => $this->url_controller,
            'content' => $content,
            'page_title' => $this->title,
            'content_title' => $this->title,
            'css_files' => $css_files,
            'js_files' => $js_files
        );
        $this->load->view('template', $template);
    }

    public function kota_ajax() {
        $filter = $this->input->get('q');
        $page = intval($this->input->get('page'));
        $limit = 10;
        $start = $limit * $page;


        $sql = "SELECT 
        tb_regencies.id,
        concat(tb_provinces.name,' - ',tb_regencies.name) as `text`
        from tb_regencies
        join tb_provinces on tb_provinces.id=tb_regencies.province_id

        where tb_provinces.name like '%" . $this->db->escape_str($filter) . "%'
        or
        tb_regencies.name like '%" . $this->db->escape_str($filter) . "%'"
                . "limit  " . $start . "," . $limit . " ";
        $data = $this->db->query($sql)->result_array();
        $results = array();
        foreach ($data as $row) {
            $buff = array();
            $buff['id'] = $row['id'];
            $buff['text'] = $row['text'];
            array_push($results, $buff);
        }
        $output = array(
            'results' => $results,
            'pagination' => array(
                'more' => true
            )
        );
        header('Content-Type: application/json');
        echo json_encode($output);
    }

    public function delete($id) {
        $this->db->where('id_business', $this->id_business);
        $this->db->where('id_supplier', $id);
        $this->db->update('m_supplier', array('status' => 0));
        redirect($this->url_controller);
    }

    public function submit() {
        $status = true;
        $message = "";
        $data = array();

        $this->load->library('form_validation');

        $submit_data = $this->input->post();

        $this->form_validation->set_data($submit_data);
        $this->form_validation->set_rules('nama', 'Nama', 'trim|required');
        $this->form_validation->set_rules('email', 'Emai', 'trim|required');
        $this->form_validation->set_rules('phone', 'Telp', 'trim|required');
        $this->form_validation->set_rules('regencies_id', 'Kota', 'trim|required');
        $this->form_validation->set_rules('alamat', 'Alamat', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            $status = false;
            $message .= validation_errors();
        } else {
            $status = true;
            $db_data = array();
            if (!empty($submit_data['id_supplier'])) {
                $db_data['nama'] = $submit_data['nama'];
                $db_data['email'] = $submit_data['email'];
                $db_data['phone'] = $submit_data['phone'];
                $db_data['phone_kantor'] = $submit_data['phone_kantor'];
                $db_data['regencies_id'] = $submit_data['regencies_id'];
                $db_data['alamat'] = $submit_data['alamat'];
                $db_data['id_business'] = $this->id_business;
                $db_data['status'] = 1;

                $this->db->where('id_supplier', $submit_data['id_supplier']);
                $this->db->update('m_supplier', $db_data);
            } else {
                $db_data['nama'] = $submit_data['nama'];
                $db_data['email'] = $submit_data['email'];
                $db_data['phone'] = $submit_data['phone'];
                $db_data['phone_kantor'] = $submit_data['phone_kantor'];
                $db_data['regencies_id'] = $submit_data['regencies_id'];
                $db_data['alamat'] = $submit_data['alamat'];
                $db_data['id_business'] = $this->id_business;
                $db_data['status'] = 1;

                $this->db->insert('m_supplier', $db_data);
            }
        }

        $output = array(
            'status' => $status,
            'message' => $message,
            'data' => $data,
        );
        header('Content-Type: application/json');
        echo json_encode($output);
    }

}
