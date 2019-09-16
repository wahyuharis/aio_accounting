<?php

class Datatables_library {

    //put your code here

    private $sql = "";
    private $user_obj = null;
    private $user_method = null;
    private $last_uri = "";

    public function __construct() {
        $ci = &get_instance();
        $ci->load->helper('url');

        foreach ($ci->uri->segment_array() as $row) {
            $this->last_uri = strtolower($row);
        }
    }

    function set_sql($sql) {
        $this->sql = $sql;
        return $this;
    }

//    public function callback_column($key, $col, $row){
    public function callback_column($obj, $method) {
        $this->user_obj = $obj;
        $this->user_method = $method;
        return $this;
    }

    public function run() {
        if ($this->last_uri == 'datatables') {
            $ci = &get_instance();
            $ci->load->database();
            $result = $ci->db->query($this->sql)->result_array();
            $datatables_format = array(
                'data' => array(),
            );

            foreach ($result as $row) {
                $buffer = array();
                foreach ($row as $key => $col) {
                    $col = call_user_func_array(array($this->user_obj, $this->user_method), array($key, $col, $row));
                    array_push($buffer, $col);
                }
                array_push($datatables_format['data'], $buffer);
            }
            header('Content-Type: application/json');
            echo json_encode($datatables_format);
            die();
        }
    }

}
