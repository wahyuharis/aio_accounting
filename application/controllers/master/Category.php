<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Category extends CI_Controller
{

    private $title = "Category Item";
    private $url_controller = "master/category/";
    private $id_business = "";

    public function __construct()
    {
        parent::__construct();
        $auth = new Auth_model();
        $this->id_business = $auth->get_userdata('id_business');
    }

    public function index()
    {
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
            $crud->where('m_category.status', 1);
            $crud->where('m_category.id_business', $this->id_business);
            $crud->set_table('m_category');
            $crud->set_subject($this->title);
            $crud->columns('name', 'keterangan');
            $crud->field_type('id_business', 'hidden', $this->id_business);
            $crud->fields('id_business', "name", 'keterangan');
            $crud->required_fields("name", "keterangan");
            $crud->unset_read();

            $crud->callback_delete(array($this, '_callback_delete'));
            $crud->callback_before_update(array($this, '_callback_before_update'));
            $crud->callback_before_insert(array($this, '_callback_before_insert'));
            $crud->callback_after_insert(array($this, '_callback_after_insert'));
            $crud->callback_after_update(array($this, '_callback_after_update'));

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

    function _delete_multiple()
    {
        $ids = $this->input->post('ids');
        if (is_array($ids)) {
            foreach ($ids as $row) {
                $this->db->where('id_category', $row);
                $this->db->update('m_category', array('status' => 0));
            }
        }
    }

    function _callback_before_update($post_array, $primary_key)
    {

        return $post_array;
    }

    function _callback_before_insert($post_array)
    {
        return $post_array;
    }

    function _callback_after_update($post_array, $primary)
    {
        return $post_array;
    }

    function _callback_after_insert($post_array, $primary)
    {
        return $post_array;
    }

    public function _callback_delete($primary_key)
    {
        return $this->db->update('m_category', array('status' => '0'), array('id_category' => $primary_key));
    }

    private function last_uri()
    {
        $last_uri = '';
        foreach ($this->uri->segment_array() as $row) {
            $last_uri = $row;
        }
        return $last_uri;
    }
}
