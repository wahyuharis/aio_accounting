<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Jurnal_umum extends CI_Controller {

    private $title = "Jurnal";
    private $url_controller = "jurnal/Jurnal_umum/";
    private $id_business = "";

    public function __construct() {
        parent::__construct();
        $auth = new Auth_model();
        $this->id_business = $auth->get_userdata('id_business');
    }

    private function status_approvement($status_approvement) {
        $status_arr = array(
            0 => '<span class="label label-warning">Draft</span>',
            1 => '<span class="label label-success">Approved</span>',
            2 => '<span class="label label-danger">Canceled</span>',
        );

        return $status_arr[intval($status_approvement)];
    }

    public function index() {
        $this->load->helper('haris_helper');
        $data_contents = array();
        $data_contents['url_controller'] = $this->url_controller;
        $data_contents['panel_title'] = $this->title . " List";
        $data_contents['content'] = '';

        $this->load->library('grocery_CRUD');
        try {
            $crud = new grocery_CRUD();
            $crud->unset_jquery();
            $crud->unset_bootstrap();
            $crud->set_theme('bootstrap');

            $crud->order_by('journal.tanggal', 'desc');
            $crud->where('journal.status', 1);
            $crud->where('journal.id_business', $this->id_business);

            $crud->set_table('journal');
            $crud->set_subject($this->title);

            $columns_list = array('kode', 'tanggal', 'status_approvement');

            $crud->columns($columns_list);

            $crud->unset_read();
            $crud->unset_edit();
//            $crud->unset_delete();

            $display_as = array(
                'journal_status' => 'Status',
            );

            $crud->display_as($display_as);

            $state = $crud->getState();
            $state_info = $crud->getStateInfo();
            if ($state == 'add') {
                redirect($this->url_controller . "add");
            }

            $crud->add_action('edit', '', $this->url_controller . 'edit', 'fa-pencil');


            $crud->callback_delete(array($this, '_callback_delete'));
            if ($this->last_uri() == 'delete_multiple') {
                $this->_delete_multiple();
            }

            $crud->callback_column('debit', function($value, $row) {
                $value = number_format($value, 2);
                return $value;
            });

            $crud->callback_column('kredit', function($value, $row) {
                $value = number_format($value, 2);
                return $value;
            });


            $crud->callback_column('status_approvement', function($value, $row) {
                return $this->status_approvement($value);
            });

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

    public function _callback_delete($primary_key) {
        $this->db->update('journal', array('status' => '0'), array('id_journal' => $primary_key));
        return true;
    }

    function _delete_multiple() {
        $ids = $this->input->post('ids');
        if (is_array($ids)) {
            foreach ($ids as $row) {
                $this->db->where('id_journal', $row);
                $this->db->update('journal', array('status' => 0));
            }
        }
    }

    private function last_uri() {
        $last_uri = '';
        foreach ($this->uri->segment_array() as $row) {
            $last_uri = $row;
        }
        return $last_uri;
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
            'assets/knockout/knockout-3.5.0.js',
        );

        $this->load->helper('haris_helper');
        $js = base_url_from_array($js);

        return $js;
    }

    public function add() {
        $this->edit();
    }

    public function edit($id = null) {
        $this->load->helper('haris_helper');
        $data_contents = array();
        $data_contents['url_controller'] = $this->url_controller;
        $data_contents['panel_title'] = $this->title . " Add";
        if (!empty($id)) {
            $data_contents['panel_title'] = $this->title . " Edit";
        }


        $content = $this->load->view('content/jurnal/jurnal_edit', $data_contents, true);

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
