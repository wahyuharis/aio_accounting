<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

    private $title = "User";
    private $url_controller = "management_user/user/";
    private $id_business = '';

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
        $data_contents['panel_title'] = $this->title . "";

        $gci_css_files = array();
        $gci_js_files = array();

        if ($this->last_uri() == 'delete_multiple') {
            $this->_delete_multiple();
        }

        $this->load->library('grocery_CRUD');
        try {
            $crud = new grocery_CRUD();
            $crud->unset_jquery();
            $crud->unset_bootstrap();
            $crud->where('_user.status', 1);
            $crud->where('_user.id_business', $this->id_business);

            $crud->set_theme('bootstrap');
            $crud->set_table('_user');
            $crud->set_subject('User');
            $crud->columns('email', 'username', '_jabatan', 'phone');

            $crud->set_relation('_jabatan', '_jabatan', 'nama', array('id_business' => $this->id_business));
            $crud->unset_read();

            $crud->display_as('_jabatan', 'Jabatan');
            $crud->fields('id_business', 'email', 'username', 'password', '_jabatan', 'phone', 'alamat');
            $state = $crud->getState();
            $state_info = $crud->getStateInfo();


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

            $crud->field_type('id_business', 'hidden', $this->id_business);

            if ($state == 'add' || $state == 'insert_validation') {
                $crud->fields('id_business', 'email', 'username', 'password', '_jabatan', 'phone', 'alamat');
                $crud->required_fields('email', 'username', 'phone', 'password');
            } elseif ($state == 'edit' || $state == 'update_validation') {
                $crud->fields('id_business', 'email', 'username', 'password', '_jabatan', 'phone', 'alamat');
                $crud->required_fields('email', 'username', 'phone');
            }


            $crud->callback_delete(array($this, '_callback_delete'));
            $crud->callback_before_update(array($this, '_callback_before_update'));
            $crud->callback_before_insert(array($this, '_callback_before_insert'));

            $crud->callback_add_field('password', array($this, '_password_empty'));
            $crud->callback_edit_field('password', array($this, '_password_empty'));

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

    function _password_empty($value = '', $primary_key = null) {
        $input = '<input id="field-password" class="form-control" name="password" type="text" value="" maxlength="200">';

        return $input;
    }

    function _callback_before_update($post_array, $primary_key) {

        if (!empty($post_array['password'])) {
            $post_array['password'] = md5($post_array['password']);
        } else {
            $res = $this->db->get_where('_user', array('id_user' => $primary_key))->row_array();
            $post_array['password'] = $res['password'];
        }

        return $post_array;
    }

    function _callback_before_insert($post_array) {

        $post_array['password'] = md5($post_array['password']);

        return $post_array;
    }

    public function _callback_delete($primary_key) {
        return $this->db->update('_user', array('status' => '0'), array('id_user' => $primary_key));
    }

    function _delete_multiple() {
        $ids = $this->input->post('ids');
        if (is_array($ids)) {
            foreach ($ids as $row) {
                $this->db->where('id_user', $row);
                $this->db->where('id_business', $this->id_business);
                $this->db->update('_user', array('status' => 0));
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

}
