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
            'password' => $this->input->post('password'),
        );

        $error = "Maaf, ";


        $where_str = "";
        $where_str .= " (username=" . $this->db->escape($this->input->post('username')) . "  or ";
        $where_str .= " email=" . $this->db->escape($this->input->post('username')) . ") ";
        $where_str .= " and ";
        $where_str .= " status=1 ";

        $this->db->where($where_str);

        $result = $this->db->get('_user');

        if ($result->num_rows() > 0) {
            $data = $result->row_array();
            if ($data['password'] == md5($this->input->post('password'))) {
                $this->session->set_userdata($sess);
//                if (is_null($data['id_owner']) || $data['is_owner'] == 1) {
//                    redirect('Home_owner');
//                } else {
                    redirect('Home');
//                }
            } else {
                $error .= "Password Salah";
                $this->session->set_flashdata('login_error', $error);
            }
        } else {
            $error .= "Username atau Email tidak dikenali";
            $this->session->set_flashdata('login_error', $error);
        }

        redirect('auth/login');
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect('auth/login');
    }

    public function register() {
        $title = "Register";

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
        $this->load->view('register', $login);
    }

    public function register_submit() {
        $status = true;
        $message = "";
        $data = array();

        $set = array();
        $set['fullname'] = trim($this->input->post('fullname'));
        $set['email'] = trim($this->input->post('email'));
        $set['username'] = trim($this->input->post('username'));
        $set['password'] = trim($this->input->post('password'));
        $set['password2'] = trim($this->input->post('password2'));

        $this->load->library('form_validation');
        $this->form_validation->set_data($set);
        $this->form_validation->set_rules('fullname', 'Fullname', 'trim|required');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|is_unique[_user_owner.email]',array('is_unique' => 'Email '.$set['email'].' sudah ada'));
        $this->form_validation->set_rules('username', 'Username', 'trim|required|is_unique[_user_owner.username]',array('is_unique' => 'Username '.$set['username'].' sudah ada'));
        $this->form_validation->set_rules('password', 'Password', 'trim|required');

        if ($this->form_validation->run() == false) {
            $status = false;
            $message .= validation_errors();
        }

        if ($set['password'] != $set['password2']) {
            $status = false;
            $message .= "<p>Password dan Retype Password tidak sama</p>";
        }
        
        if($status){
            $data=array();
            
            $data['fullname']=$set['fullname'];
            $data['email']=$set['email'];
            $data['username']=$set['username'];
            $data['password']=$set['password'];
            
            $this->db->insert('_user_owner',$data);
        }

        $output = array(
            'status' => $status,
            'message' => $message,
            'data' => $data,
        );
        header('Content-Type: application/json');
        echo json_encode($output);
    }

    public function register_succes(){
         $title = "Register";

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
        $this->load->view('content/register_succes', $login);
    }
    
}
