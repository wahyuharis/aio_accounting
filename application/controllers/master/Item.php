<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Item extends CI_Controller {

    private $title = "Item";
    private $url_controller = "master/Item/";
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
        $data_contents['panel_title'] = $this->title;
        $data_contents['content'] = '';

        $this->load->library('grocery_CRUD');
        try {
            $crud = new grocery_CRUD();
            $crud->unset_jquery();
            $crud->unset_bootstrap();
            $crud->set_theme('bootstrap');
            $crud->where('m_item.status', 1);
            $crud->where('m_item.id_business', $this->id_business);
            $crud->set_table('m_item');
            $crud->set_subject($this->title);
            $crud->columns('nama_item', 'code', 'satuan', 'is_have_stock');
            $crud->set_relation('satuan', 'm_satuan', 'nama', array('status' => 1, 'id_business' => $this->id_business));

            $crud->set_field_upload('foto', 'assets/uploads/files');

            $crud->field_type('id_business', 'hidden', $this->id_business);

            $crud->display_as('is_have_stock', 'Pakai Stok');
            $crud->fields('id_business', "nama_item", 'code', "satuan", "is_have_stock", "foto");
            $crud->required_fields("nama_item", "satuan", "is_have_stock");
            $crud->unset_read();

            $crud->callback_delete(array($this, '_callback_delete'));
            $crud->callback_before_update(array($this, '_callback_before_update'));
            $crud->callback_before_insert(array($this, '_callback_before_insert'));
            $crud->callback_after_insert(array($this, '_callback_after_insert'));
            $crud->callback_after_update(array($this, '_callback_after_update'));
            $crud->callback_field('code', function($value = '', $primary_key = null) {
                $html = '<input id="field-code" class="form-control" name="code" type="text" value="' . $value . '" maxlength="50">';
                $html .= '<i>Barcode item dapat di isikan di sini. Jika item tidak memiliki code dapat anda kosongkan dan sistem akan menggenerate otomatis</i>';
                return $html;
            });

            $crud->callback_field('is_have_stock', function($value = '', $primary_key = null) {
                $html = "";
                $checked = "";
                if ($value > 0) {
                    $checked = " checked ";
                }

                $html .= '<label for="is_have_stock" class="container-cb" >';
                $html .= '<input type="checkbox" name="is_have_stock" id="is_have_stock" class="big-size" value="1" ' . $checked . ' >';
                $html .= '<span class="checkmark"></span>';
                $html .= '</label>';

                return $html;
            });


            $crud->callback_column('code', function($value, $row) {
                $html = "";
                $html .= '<a href="' . base_url() . 'barcode-master/barcode.php?f=png&s=code-128&d=' . $value . '" target="_blank" >';
                $html .= '<img src="' . base_url() . 'barcode-master/barcode.php?f=png&s=code-128&d=' . $value . '" '
                        . 'width="100" height="50" >';
                $html .= '<p>' . $value . '</p>';
                $html .= "</a>";
                return $html;
            });

            $crud->callback_column('is_have_stock', function($value, $row) {
                $html = "";

                if (intval($value) == 1) {
                    $html = '<span class="label label-success">Ya</span>';
                } else {
                    $html = '<span class="label label-warning">Tidak</span>';
                }

                return $html;
            });


            $state = $crud->getState();


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
            'css_files' => $css_files,
            'js_files' => $js_files
        );
        $this->load->view('template', $template);
    }

    function _delete_multiple() {
        $ids = $this->input->post('ids');
        if (is_array($ids)) {
            foreach ($ids as $row) {
                $this->db->where('id_item', $row);
                $this->db->update('m_item', array('status' => 0));
            }
        }
    }

    function _callback_before_update($post_array, $primary_key) {

        if (!isset($post_array['is_have_stock'])) {
            $post_array['is_have_stock'] = 0;
        }

        return $post_array;
    }

    function _callback_before_insert($post_array, $primary) {

        if (!isset($post_array['is_have_stock'])) {
            $post_array['is_have_stock'] = 0;
        }

        return $post_array;
    }

    function _callback_after_update($post_array, $primary) {

        if (empty($post_array['code'])) {
            $this->load->helper('haris_helper');
            $code = gen_sku($primary, "ITEM");
            $this->db->where('id_item', $primary);
            $this->db->set('code', $code);
            $this->db->update('m_item');
        }

        return $post_array;
    }

    function _callback_after_insert($post_array, $primary) {
        if (empty($post_array['code'])) {
            $this->load->helper('haris_helper');
            $code = gen_sku($primary, "ITEM");
            $this->db->where('id_item', $primary);
            $this->db->set('code', $code);
            $this->db->update('m_item');
        }

        return $post_array;
    }

    public function _callback_delete($primary_key) {
        return $this->db->update('m_item', array('status' => '1'), array('id_item' => $primary_key));
    }

    private function last_uri() {
        $last_uri = '';
        foreach ($this->uri->segment_array() as $row) {
            $last_uri = $row;
        }
        return $last_uri;
    }

}
