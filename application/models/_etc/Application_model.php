<?php

class Application_model extends CI_Model {

    private $all_data = array();

    public function __construct() {
        parent::__construct();
        $all_data = $this->db->get('_app_values')->result_array();
        foreach ($all_data as $row) {
            $this->all_data[$row['variable']] = $row['value'];
        }
    }

    function get_all_data() {
        return $this->all_data;
    }

    function get_some_data($key) {
        return $this->all_data[$key];
    }

}
