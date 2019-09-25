<?php

class Register extends CI_Controller {

    //put your code here
    public function __construct() {
        parent::__construct();
    }

    public function index() {
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
        $this->form_validation->set_rules('email', 'Email', 'trim|required|is_unique[_user_owner.email]', array('is_unique' => 'Email ' . $set['email'] . ' sudah ada'));
        $this->form_validation->set_rules('username', 'Username', 'trim|required|is_unique[_user_owner.username]', array('is_unique' => 'Username ' . $set['username'] . ' sudah ada'));
        $this->form_validation->set_rules('password', 'Password', 'trim|required');

        if ($this->form_validation->run() == false) {
            $status = false;
            $message .= validation_errors();
        }

        if ($set['password'] != $set['password2']) {
            $status = false;
            $message .= "<p>Password dan Retype Password tidak sama</p>";
        }

        if ($status) {
            $data = array();

            $data['fullname'] = $set['fullname'];
            $data['email'] = $set['email'];
            $data['username'] = $set['username'];
            $data['password'] = md5($set['password']);

            $this->db->insert('_user_owner', $data);
        }

        $output = array(
            'status' => $status,
            'message' => $message,
            'data' => $data,
        );
        header('Content-Type: application/json');
        echo json_encode($output);
    }

    public function register_succes() {
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
