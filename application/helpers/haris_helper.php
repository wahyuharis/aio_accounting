<?php

function intval2($str) {
    $int = str_replace(',', '', $str);
    $int = intval($int);
    return $int;
}

function floatval2($str) {
    $int = str_replace(',', '', $str);
    $int = floatval($int);
    return $int;
}

function dropdown_array($result_array, $index, $label, $placeholder = "") {
    $output = array();

    $output[''] = $placeholder;

    foreach ($result_array as $row) {
        $output[$row[$index]] = $row[$label];
    }
    return $output;
}

function base_url_from_array($arr_url) {
    $ci = &get_instance();
    $ci->load->helper('url');
    $output = array();
    foreach ($arr_url as $row) {
        array_push($output, base_url() . $row);
    }
    return $output;
}

function gen_sku($primary_val, $suffix = "") {
    $sku = "";
    $sku = $suffix . "" . sprintf('%08d', ($primary_val));

    return $sku;
}

function mask_uriformat($var) {
    $output = urlencode(base64_encode($var));
    return $output;
}

function unmask_uriformat($var) {
    $output = base64_decode(urldecode($var));
    return $output;
}
