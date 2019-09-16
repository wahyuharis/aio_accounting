<?php

class Grocery_filter_ids {

    //put your code here

    private $column_name = "";
    private $ids = array();
    private $sql = "";

    public function __construct() {
        
    }

    function set_sql($sql) {
        $this->sql = $sql;
        return $this;
    }

    public function get_filter($filter_name) {
        $this->column_name=$filter_name;
        
        $ci = &get_instance();
        $ci->load->helper('form');
        $ci->load->helper('url');

        $filter = "";
        if (is_array($ci->input->post('search_field'))) {
            foreach ($ci->input->post('search_field') as $key => $row) {
                if ($row == $this->column_name) {
                    $filter = ($ci->input->post('search_text')[$key]);
                    if (count($_POST['search_field']) < 2) {
                        unset($_POST['search_field']);
                        unset($_POST['search_text']);
                    } else {
                        unset($_POST['search_field'][$key]);
                        unset($_POST['search_text'][$key]);
                    }
                }
            }
        }

        return $filter;
    }

    public function get_ids() {
        $ci = &get_instance();
        $ci->load->database('database');
        $data = $ci->db->query($this->sql)->result_array();

        $buff = array();

        if (count($data) > 0) {
            $key = array_keys($data[0])[0];
            foreach ($data as $row) {
                array_push($buff, $ci->db->escape($row[$key]));
            }
        }

        $output = implode(',', $buff);
        return $output;
    }

}
