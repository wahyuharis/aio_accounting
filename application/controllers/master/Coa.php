<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Coa extends CI_Controller {

    private $title = "Akun";
    private $url_controller = "master/coa/";
    private $id_business = "";
    private $panjang_kode = 9;

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

        $this->load->library('grocery_CRUD');
        try {
            $crud = new grocery_CRUD();
            $crud->unset_jquery();
            $crud->unset_bootstrap();
            $crud->set_theme('bootstrap');

            $crud->where('m_coa.status', 1);
            $crud->where('m_coa.id_business', $this->id_business);

            $crud->set_table('m_coa');
            $crud->set_subject($this->title);
            $crud->columns('kode', 'name', 'm_coa_jenis');
            $crud->fields('id_business', 'kode', 'name', 'm_coa_jenis', 'is_cash_bank', 'keterangan');
            $crud->display_as('m_coa_jenis', 'Jenis Akun');
            $crud->display_as('is_cash_bank', 'Cash/Bank');

            $crud->callback_field('is_cash_bank', function($value, $primary) {
                $html = "";

                $checked = "";
                if ($value > 0) {
                    $checked = " checked ";
                }

                $html .= '<label for="is_cash_bank" class="container-cb" >';
                $html .= '<input type="checkbox" name="is_cash_bank" id="is_cash_bank" class="big-size" value="1" ' . $checked . ' >';
                $html .= '<span class="checkmark"></span>';
                $html .= '</label>';
                return $html;
            });

            $crud->field_type('id_business', 'hidden', $this->id_business);
            $where_relation = array(
                'id_business' => $this->id_business,
            );
            $crud->set_relation('m_coa_jenis', 'm_coa_jenis', 'nama', $where_relation);

            $crud->required_fields('name', 'm_coa_jenis');
            $crud->set_rules('kode', 'Kode', 'trim|min_length[' . $this->panjang_kode . ']|numeric');

            $crud->unset_read();
            $crud->callback_delete(array($this, '_callback_delete'));
            $crud->callback_before_update(array($this, '_callback_before_update'));
            $crud->callback_before_insert(array($this, '_callback_before_insert'));
            $crud->callback_after_insert(array($this, '_callback_after_insert'));
            $crud->callback_after_update(array($this, '_callback_after_update'));

            $state = $crud->getState();
            $state_info = $crud->getStateInfo();


            if ($this->last_uri() == 'delete_multiple') {
                $this->_delete_multiple();
            }

            if ($state == 'edit') {
                $primary_key = $state_info->primary_key;
                $total_row = $this->db->where(array(
                            'id_business' => $this->id_business,
                            'id_m_coa' => $primary_key
                        ))->get('m_coa')->num_rows();

                if ($total_row < 1) {
                    show_error("Maaf, Anda Tidak Dapat Mengakses Halaman Ini");
                    die();
                }
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
                $this->db->where('id_m_coa', $row);
                $this->db->update('m_coa', array('status' => 0));
            }
        }
    }

    function _callback_before_update($post_array, $primary_key) {
        if (!isset($post_array['is_cash_bank'])) {
            $post_array['is_cash_bank'] = 0;
        }

        return $post_array;
    }

    function _callback_before_insert($post_array, $primary) {
        $where = array(
            'id_business' => $this->id_business,
        );
        $this->db->where($where);
        $this->db->order_by('kode', 'desc');
        $row = $this->db->get('m_coa')->row_array();

        $kode = intval($row['kode']) + 1;

        $kode_padded = str_pad($kode, $this->panjang_kode, "0", STR_PAD_LEFT);

        if (empty(trim($post_array['kode']))) {
            $post_array['kode'] = $kode_padded;
        }

        if (!isset($post_array['is_cash_bank'])) {
            $post_array['is_cash_bank'] = 0;
        }

        return $post_array;
    }

    function _callback_after_update($post_array, $primary) {


        return $post_array;
    }

    function _callback_after_insert($post_array, $primary) {

        return $post_array;
    }

    public function _callback_delete($primary_key) {
        return $this->db->update('m_coa', array('status' => '0'), array('id_m_coa' => $primary_key));

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
