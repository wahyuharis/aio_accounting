<?php

class Auth_super_user_model extends CI_Model {

    private $userdata = array();

    public function __construct() {
        parent::__construct();
        $this->userdata = $this->get_db_user()->row_array();
    }

    private function get_db_user() {
        $where = "(username like " . $this->db->escape($this->session->userdata('username')) . " "
                . " or "
                . "email like " . $this->db->escape($this->session->userdata('username')) . " )"
                . " and "
                . "password like " . $this->db->escape($this->session->userdata('password')) . ""
                . " and status=1";
        $this->db->where($where);
        $db = $this->db->get('_user_super');

        return $db;
    }

    public function get_userdata($key = null) {

        if (!empty($key)) {
            return $this->userdata[$key];
        } else {
            return $this->userdata;
        }
    }

    public function is_logged_in() {
        $result = $this->get_db_user();

        if ($result->num_rows() < 1) {
            $this->session->set_flashdata('login_error', "Maaf, Silakan Login Lagi. Session Anda Mungkin Telah Berakhir atau Anda Mengakses Halaman Tanpa Login");
            redirect('auth/login');
        }
    }
}
