<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class floor_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    function floor_update($floor_name = '', $description = '', $sts = '') {

        $data1 = array(
            'floor_name' => $floor_name,
            'floor_description' => $description,
            'floor_status' => $sts
        );

//        $data2 = array(
//            'cat_code' => $cat_id,
//            'cat_name' => $cat_name
//        );
//        if ($sts == 1) {
//
//            $data3 = $data1;
//        } else {
//            $data3 = $data2;
//        }
        $this->db->where('floor_id', $category_tbl_id);
        if ($this->db->update('floor', $data1)) {
            return true;
        } else {
            return false;
        }
    }

    function floor_save($floor_name = '', $description = '', $sts = '') {
        $data1 = array(
            'floor_name' => $floor_name,
            'floor_description' => $description,
            'floor_status' => $sts
        );




        if ($this->db->insert('floor', $data1)) {
            return true;
        } else {
            return false;
        }
    }

    function floor_permanent_delete($floor_id = '') {
//        if ($this->get_sub_category($floor_id) == true) {
            
//        } else {
            $this->db->where('floor_id', $floor_id);
            if ($this->db->delete('floor')) {
                return true;
            } else {
                return false;
            }
//        }
    }

}
