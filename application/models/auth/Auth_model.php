<?php

class Auth_model extends CI_Model {

    private $userdata = array();
    private $url_controller = "";

    public function __construct() {
        parent::__construct();
        $this->url_controller = $this->router->directory . "" . $this->router->class;
        $this->url_controller = rtrim($this->url_controller, "/");
        $this->user_validation();
        $this->userdata = $this->get_db_user()->row_array();
    }

    private function user_validation() {
        $uri_segments = $this->uri->segment_array();

        if (strtolower($this->url_controller) == 'auth') {
            //pass
        } elseif (strtolower($this->url_controller) == 'register') {
            //pass
        } elseif (strtolower($this->url_controller) == 'home_super') {
            //pass
        } elseif (strtolower($this->url_controller) == 'home_super2') {
            //pass
        } elseif (strtolower($this->url_controller) == 'test') {
            //pass
        } elseif (strtolower($this->url_controller) == 'home') {
            $this->is_logged_in();
        } else {
            $this->is_logged_in();
            $this->cek_hak_akses();
        }
    }

    private function get_db_user() {
        $where = "(username like " . $this->db->escape($this->session->userdata('username')) . " "
                . " or "
                . "email like " . $this->db->escape($this->session->userdata('username')) . " )"
                . " and "
                . "password like " . $this->db->escape($this->session->userdata('password')) . ""
                . " and status=1";
        $this->db->where($where);
        $db = $this->db->get('_user');

        return $db;
    }

    public function get_userdata($key = null) {

        if (!empty($key)) {
            return $this->userdata[$key];
        } else {
            return $this->userdata;
        }
    }

    public function get_businessdata() {
        $sql = "SELECT 
        m_business_type.*,
        m_business.*
        from m_business
        join m_business_type
        on m_business.id_business_type=m_business_type.id_business_type
        where m_business.id_business=" . $this->db->escape($this->userdata['id_business']) . "
        limit 1";
        $exc = $this->db->query($sql);
        $data = $exc->row_array();
        return $data;
    }

    public function is_logged_in() {
        $result = $this->get_db_user();

        $result_row = $result->row_array();

        if (empty(trim($this->session->userdata('id_business')))) {
            $this->session->set_flashdata('general_error', "Maaf, Anda Belum Memilih Database Bisnis Yang ingin Anda Buka");
            redirect('home_super');
        }

        if ($result_row['id_business'] != $this->session->userdata('id_business')) {
            $this->session->set_flashdata('general_error', "Maaf, Anda Mungkin Telah Membuka Halaman Bisnis Lain");
            redirect('home_super');
        }

        if ($result->num_rows() < 1) {
            $this->session->set_flashdata('login_error', "Maaf, Silakan Login Lagi. Session Anda Mungkin Telah Berakhir atau Anda Mengakses Halaman Tanpa Login");
            redirect('auth/login');
        }
    }

//    public function is_owner() {
//        $this->get_userdata();
//
//        if (!is_null($this->userdata['id_owner'])) {
//            $this->session->set_flashdata('general_error', "Maaf, Halaman tersebut tidak termasuk dalam hak akses anda");
//            redirect('home');
//        }
//
//        if ($this->userdata['is_owner'] != 1) {
//            $this->session->set_flashdata('general_error', "Maaf, Halaman tersebut tidak termasuk dalam hak akses anda");
//            redirect('home');
//        }
//    }

    public function cek_hak_akses() {
        $sql = "SELECT _menu.url_controller
        FROM `_menu`
        WHERE 
        lower( trim( trailing '/' from  _menu.url_controller)) = lower(" . $this->db->escape($this->url_controller) . ")
        and
        _menu.id_menu in
        (select _menu_jabatan.id_menu from _user
                left join _menu_jabatan on _menu_jabatan.id_jabatan=_user._jabatan
                where 
                _user.username like " . $this->db->escape($this->session->userdata('username')) . "
                and
                `_user`.`password` like " . $this->db->escape($this->session->userdata('password')) . ")

        ORDER BY `urutan` ASC";

        $exc = $this->db->query($sql);
        if ($exc->num_rows() < 1) {
            $this->session->set_flashdata('general_error', "Maaf, Anda Tidak Memiliki Hak akses pada halaman tersebut.<br>Silakan hubungi administrator");
            redirect('home');
            die();
        }
    }

}
