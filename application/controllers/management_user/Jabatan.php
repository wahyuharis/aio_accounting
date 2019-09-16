<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Jabatan extends CI_Controller {

    private $title = "Jabatan";
    private $url_controller = "management_user/jabatan/";
    private $id_business = '';

    public function __construct() {
        parent::__construct();
        $auth = new Auth_model();
        $this->id_business = $auth->get_userdata('id_business');
    }

    public function index() {
        $this->load->helper('haris_helper');
        $data_contents = array();
        $data_contents['panel_title'] = $this->title . "";
        $css_files = array();
        $js_files = array();

        if ($this->last_uri() == 'delete_multiple') {
            $this->_delete_multiple();
        }

        $this->load->library('grocery_CRUD');
        try {
            $crud = new grocery_CRUD();
            $crud->unset_jquery();
            $crud->unset_bootstrap();
            $crud->where('status', 1);
            $crud->where('id_business', $this->id_business);

            $crud->columns('nama', 'hakakses');
            $crud->fields('id_business', 'nama', 'hakakses');

            $crud->callback_column('hakakses', array($this, '_callback_column'));

            $crud->set_theme('bootstrap');
            $crud->set_table('_jabatan');
            $crud->set_subject($this->title);
            $crud->required_fields('nama');
            $crud->field_type('id_business', 'hidden', $this->id_business);

            $crud->unset_read();
//            $crud->unset_add();
            $crud->unset_edit();
            $crud->add_action('Edit', '', $this->url_controller . "edit", 'fa fa-pencil');


            $state = $crud->getState();

            if ($state == 'add' || $state == 'insert_validation') {
                redirect($this->url_controller . "add");
                die();
            } elseif ($state == 'edit' || $state == 'update_validation') {
                
            }

            $crud->callback_delete(array($this, '_callback_delete'));
            $crud->callback_before_update(array($this, '_callback_before_update'));
            $crud->callback_before_insert(array($this, '_callback_before_insert'));

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

    function _callback_column($col, $row) {
//        $sql="se"

        return $col;
    }

    function _callback_before_update($post_array, $primary_key) {

        return $post_array;
    }

    function _callback_before_insert($post_array) {


        return $post_array;
    }

    public function _callback_delete($primary_key) {

        $this->db->where('id_jabatan', $primary_key);
        $this->db->set(array('status' => 0));
        $this->db->update('_jabatan');


        return true;
    }

    function _delete_multiple() {
        $ids = $this->input->post('ids');
        if (is_array($ids)) {
            foreach ($ids as $row) {
                $this->db->where('id_jabatan', $row);
                $this->db->where('id_business', $this->id_business);
                $this->db->update('_jabatan', array('status' => 0));
            }
        }
    }

    function add() {
        $this->edit(null);
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

    function edit($id = null) {

        $data_contents = array();
        $data_contents['url_controller'] = $this->url_controller;
        $data_contents['panel_title'] = $this->title . " Add";

        $data_contents['id_jabatan'] = $id;
        $data_contents['id_business'] = $this->id_business;
        $data_contents['nama'] = '';

        $jabatan_list = array();
        $exc = $this->db->where('id_business', $this->id_business)->get('_menu_jabatan');
        $jabatan_list = $exc->result_array();

        $menu_list = array();
        $exc = $this->db->get('_menu');
        $menu_list = $exc->result_array();

        $data_contents['menu_list'] = $menu_list;
        $data_contents['jabatan_list'] = $jabatan_list;

        if (!empty(trim($id))) {
            $where_secure = array(
                'id_jabatan' => $id,
                'id_business' => $this->id_business
            );
            $num_rows = $this->db->where($where_secure)->get('_jabatan')->num_rows();
            if ($num_rows < 1) {
                show_error("Maaf Halaman Ini Tidak dapat diakses");
                die();
            }

            $data_contents['panel_title'] = $this->title . " Edit";

            $where = array(
                'id_jabatan' => $id,
            );
            $result = $this->db->where($where)->get('_jabatan')->row_array();
            $data_contents['nama'] = $result['nama'];
        }

        $content = $this->load->view('content/jabatan/jabatan_edit', $data_contents, true);

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

    private function last_uri() {
        $last_uri = '';
        foreach ($this->uri->segment_array() as $row) {
            $last_uri = $row;
        }
        return $last_uri;
    }

    public function submit() {

        $status = true;
        $message = "";
        $data = array();
        $this->load->library('form_validation');


        $id_jabatan = $this->input->post('id_jabatan');

        $menu = "";

        $menu = $this->input->post('menu');
        $buff = array();
        if (is_array($menu)) {
            foreach ($menu as $row) {
                $buff0 = explode("_", $row);
                foreach ($buff0 as $row2) {
                    array_push($buff, $row2);
                }
            }
        }
        $output = array_unique($buff);
        sort($output);

        $data_form['nama'] = $this->input->post('nama');
        $data_form['menu'] = $output;

        $this->form_validation->set_data($data_form);
        $this->form_validation->set_rules('nama', 'Nama', 'trim|required');

        if ($this->form_validation->run() == false) {
            $status = false;
            $message .= validation_errors();
        }

        if (count($data_form['menu']) < 1) {
            $status = false;
            $message .= '<p>Menu belum di check satupun</p>';
        }



        if ($status) {
            if (empty(trim($id_jabatan))) {
                $jabatan_arr = array(
                    'nama' => $data_form['nama'],
                    'id_business' => $this->id_business,
                );
                $this->db->insert('_jabatan', $jabatan_arr);
                $id_jabatan = $this->db->insert_id();

                foreach ($data_form['menu'] as $row) {
                    $insert_row = array(
                        'id_business' => $this->id_business,
                        'id_jabatan' => $id_jabatan,
                        'id_menu' => $row,
                    );
                    $this->db->insert('_menu_jabatan', $insert_row);
                }
            } else {
                $jabatan_arr = array(
                    'nama' => $data_form['nama'],
                    'id_business' => $this->id_business,
                );
                $this->db->set($jabatan_arr);
                $this->db->where('id_jabatan', $id_jabatan);
                $this->db->update('_jabatan');

                $this->db->where('id_business', $this->id_business);
                $this->db->where('id_jabatan', $id_jabatan);
                $this->db->delete('_menu_jabatan');

                foreach ($data_form['menu'] as $row) {
                    $insert_row = array(
                        'id_business' => $this->id_business,
                        'id_jabatan' => $id_jabatan,
                        'id_menu' => $row,
                    );
                    $this->db->insert('_menu_jabatan', $insert_row);
                }
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
