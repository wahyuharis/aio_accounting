<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->is_loggedin();
    }

    public function is_loggedin() {
        if (!empty($this->session->userdata('username')) && !empty($this->session->userdata('password'))) {
            redirect('home/index');
        } else {
            redirect('auth/login');
        }
    }

    public function login() {
        $title = "Login";

        $app_model = new Application_model();
        $app_data = $app_model->get_all_data();

        $company_credit = array(
            'company' => $app_data['company_name'],
            'year' => $app_data['year'],
            'caption' => $app_data['application_name'],
        );

        $login = array(
            'page_title' => $app_data['application_name'] . ' - ' . $title,
            'company_credit' => $company_credit
        );
        $this->load->view('login', $login);
    }

    public function login_submit() {
        $sess = array(
            'username' => $this->input->post('username'),
            'password' => md5($this->input->post('password')),
        );

        $error = "Maaf, ";
        $where_str = "";
        $where_str .= " (username=" . $this->db->escape($this->input->post('username')) . "  or ";
        $where_str .= " email=" . $this->db->escape($this->input->post('username')) . ") ";
        $where_str .= " and ";
        $where_str .= " status=1 ";
        

        ## { OWNER AUTH###
        $this->db->where($where_str);
        $exc0 = $this->db->get('_user_super');
        if ($exc0->num_rows() > 0) {
            $data0 = $exc0->row_array();
            if ($data0['password'] == md5($this->input->post('password'))) {
                $this->session->set_userdata($sess);
                redirect('home_super');
            } else {
                $error .= "Password Salah";
                $this->session->set_flashdata('login_error', $error);
            }
        } else {
            $error .= "Username atau Email tidak dikenali";
            $this->session->set_flashdata('login_error', $error);
        }
        ## }  OWNER AUTH###
        #
        #
        #
        #
        ## { USER AUTH ###
        $error = "Maaf, ";
        $this->db->where($where_str);
        $result = $this->db->get('_user');

        if ($result->num_rows() > 0) {
            $data = $result->row_array();
            if ($data['password'] == md5($this->input->post('password'))) {
                $this->session->set_userdata($sess);
                redirect('Home');
            } else {
                $error .= "Password Salah";
                $this->session->set_flashdata('login_error', $error);
            }
        } else {
            $error .= "Username atau Email tidak dikenali";
            $this->session->set_flashdata('login_error', $error);
        }
        ## } USER AUTH ###
        #
        #
        redirect('auth/login');
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect('auth/login');
    }

}
