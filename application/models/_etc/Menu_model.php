<?php

class Menu_model extends CI_Model {

    private $menu_list = array();
    private $is_jasa = 0;
    private $is_manufaktur = 0;
    private $is_retail = 0;

    public function __construct() {
        parent::__construct();
        $this->type_business_set();
    }

    private function type_business_set() {
        $sql = "SELECT 
            m_business_type.is_jasa,
            m_business_type.is_manufaktur,
            m_business_type.is_retail
            from m_business
            join m_business_type
            on m_business.id_business_type=m_business_type.id_business_type
            where m_business.id_business=(
                    select _user.id_business from _user
                    where _user.username=" . $this->db->escape($this->session->userdata('username')) . "
                    and _user.`password`= (" . $this->db->escape($this->session->userdata('password')) . ")
                    limit 1
            )";
        $exc = $this->db->query($sql);
        if ($exc->num_rows() > 0) {
            $this->is_jasa = $exc->row_array()['is_jasa'];
            $this->is_manufaktur = $exc->row_array()['is_manufaktur'];
            $this->is_retail = $exc->row_array()['is_retail'];
        }
    }

    public function get_menu($level = 0, $parent = '') {
        $auth = new Auth_model();
        $userdata = $auth->get_userdata();


        $this->db->where('level', $level);
        if (!empty($parent)) {
            $this->db->where('parent', $parent);
        }

        if ($this->is_jasa > 0) {
            $this->db->where('is_jasa', intval($this->is_jasa));
        }
        if ($this->is_manufaktur > 0) {
            $this->db->where('is_manufaktur', intval($this->is_manufaktur));
        }
        if ($this->is_retail > 0) {
            $this->db->where('is_retail', ($this->is_retail));
        }


        $where_sql = " _menu.id_menu in ( 
            select _menu_jabatan.id_menu from _user
            left join _menu_jabatan on _menu_jabatan.id_jabatan=_user._jabatan
            where 
            _user.username like " . $this->db->escape($this->session->userdata('username')) . "
            and
            _user.`password` like (" . $this->db->escape($this->session->userdata('password')) . ") "
                . " )";

        if ($userdata['is_owner'] < 1) {
            $this->db->where($where_sql);
        }

        $this->db->order_by('urutan', 'asc');
        $data = $this->db->get('_menu')->result_array();
//        echo $this->db->last_query();
//        die();

        $this->menu_list = $data;

        return $this->menu_list;
    }

}
