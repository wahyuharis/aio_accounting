<?php
class Data_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function Get_all($table)
    {
        return $this->db->get($table)->result();
    }

    function Get_limit($number, $table)
    {
        return $this->db->get($table, $number)->result();
    }

    function Get_limit_offset($number, $offset, $table)
    {
        return $this->db->get($table, $number, $offset)->result();
    }

    function Pagination_all($number, $offset, $table)
    {
        return $this->db->get($table, $number, $offset)->result();
    }

    function jenis_Usaha($business_type)
    {
        $jenis_usaha = "<option value='0'>--pilih--</pilih>";
        $this->db->order_by('nama_usaha', 'ASC');
        $kab = $this->db->get_where('m_jenis_usaha', array('id_business_type' => $business_type));
        foreach ($kab->result_array() as $data) {
            $jenis_usaha .= "<option value='$data[id_jenis_usaha]'>$data[nama_usaha]</option>";
        }
        return $jenis_usaha;
    }
}
