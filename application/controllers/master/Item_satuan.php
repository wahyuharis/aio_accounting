<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Item_satuan extends CI_Controller {

    private $title = "Item Satuan";
    private $url_controller = "master/Item_satuan/";
    private $id_business = "";

    public function __construct() {
        parent::__construct();
        $auth = new Auth_model();
        $this->id_business = $auth->get_userdata('id_business');
    }

    public function sql() {
        $sql = "select 
         '' as `action`,
        m_satuan.id,
        m_satuan.nama,
        '' as same_as,
        m_satuan.id_child,
        m_satuan.qty_child
        from m_satuan
        where
        m_satuan.`status`=1
        and id_business=" . $this->id_business . "";

        $data = $this->db->query($sql)->result_array();
        return $data;
    }

    private function css() {
        $css = array(
            "AdminLTE-2.4.2/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css",
        );
        $this->load->helper('haris_helper');
        $css = base_url_from_array($css);
        return $css;
    }

    private function js() {
        $js = array(
            "AdminLTE-2.4.2/bower_components/datatables.net/js/jquery.dataTables.min.js",
            "AdminLTE-2.4.2/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js",
        );
        $this->load->helper('haris_helper');
        $js = base_url_from_array($js);
        return $js;
    }

    public function index() {
        $this->load->helper('haris_helper');
        $data_contents = array();
        $data_contents['url_controller'] = $this->url_controller;
        $data_contents['panel_title'] = $this->title . " List";
        $data_contents['table_header'] = array(
            '#',
            'No',
            'Nama',
            'Sebanding',
        );

        $content = $this->load->view('content/master/item_satuan/item_satuan_list', $data_contents, true);

        $css_files = $this->css();
        $js_files = $this->js();

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

    private function callback_column($key, $col, $row) {

        if ($key == 'action') {
            $id_row = $row['id'];
            $col = "";
            $col .= '<a href="' . base_url() . $this->url_controller . 'edit/' . $id_row
                    . '" class="btn btn-warning btn-xs" ><i class="fa fa-pencil"></i> Edit</a>';
            $col .= '<a href="#" '
                    . 'onclick="delete_row(' . $id_row . ')" '
                    . 'class="btn btn-danger btn-xs" ><i class="fa fa-trash"></i> Delete</a>';
        }


        if ($key == 'same_as') {
            $col = "-";
            $this->db->where('id', $row['id_child']);
            $exc = $this->db->get('m_satuan');
            if ($exc->num_rows() > 0) {
                $res = $exc->row_array();
                $col = $row['qty_child'] . " " . $res['nama'];
            }
        }

        return $col;
    }

    public function datatables() {
        $result = $this->sql();

        $datatables_format = array(
            'data' => array(),
        );

        foreach ($result as $row) {
            $buffer = array();
            foreach ($row as $key => $col) {
                $col = $this->callback_column($key, $col, $row);
                array_push($buffer, $col);
            }
            array_push($datatables_format['data'], $buffer);
        }
        header('Content-Type: application/json');
        echo json_encode($datatables_format);
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

        $data_contents['id'] = '';
        $data_contents['id_business'] = $this->id_business;
        $data_contents['nama'] = '';
        $data_contents['is_package'] = '';
        $data_contents['id_child'] = '';
        $data_contents['qty_child'] = '';
        $data_contents['status'] = '1';

        if (!empty($id)) {
            $this->db->where('id!=', $id);
        }
        $result = $this->db->where('is_package', 0)->get('m_satuan')->result_array();
        $opt_child = dropdown_array($result, 'id', 'nama', 'Pilih Satuan Ecer');
        $data_contents['opt_child'] = $opt_child;


        if (!empty($id)) {
            $this->db->where('id', $id);
            $this->db->where('id_business', $this->id_business);
            $row = $this->db->get('m_satuan')->row_array();

            $data_contents['id'] = $row['id'];
            $data_contents['id_business'] = $this->id_business;
            $data_contents['nama'] = $row['nama'];
            $data_contents['is_package'] = $row['is_package'];
            $data_contents['id_child'] = $row['id_child'];
            $data_contents['qty_child'] = $row['qty_child'];
            $data_contents['opt_child'] = $opt_child;
            $data_contents['status'] = $row['status'];
        }

        $content = $this->load->view('content/master/item_satuan/item_satuan_edit', $data_contents, true);

        $css_files = $this->css_edit();
        $js_files = $this->js_edit();

        $template = array(
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
        $this->db->where('id', $id);
        $this->db->update('m_satuan', array('status' => 0));

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

        if ($this->form_validation->run() == FALSE) {
            $status = false;
            $message .= validation_errors();
        } else {
            $status = true;
            $db_data = array();
            if (!empty($submit_data['id'])) {
                $db_data['nama'] = $this->input->post('nama');
                $db_data['id_business'] = $this->id_business;
                $db_data['is_package'] = intval($this->input->post('is_package'));
                $db_data['id_child'] = $this->input->post('id_child');
                $db_data['qty_child'] = $this->input->post('qty_child');
                $db_data['status'] = 1;

                $this->db->where('id', $submit_data['id']);
                $this->db->where('id_business', $this->id_business);

                $this->db->update('m_satuan', $db_data);
            } else {
                $db_data['nama'] = $this->input->post('nama');
                $db_data['id_business'] = $this->id_business;
                $db_data['is_package'] = intval($this->input->post('is_package'));
                $db_data['id_child'] = $this->input->post('id_child');
                $db_data['qty_child'] = $this->input->post('qty_child');
                $db_data['status'] = 1;

                $this->db->insert('m_satuan', $db_data);
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
