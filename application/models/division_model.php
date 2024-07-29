<?php


if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class division_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }
    
    function division_update($division_id,$floor_id,$division_name = '', $description = '', $sts = '') {

        $data1 = array(
            'floor_id' => $floor_id,
            'div_name' => $division_name,
            'div_description' => $description,
            'div_status' => $sts
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
        $this->db->where('division_id', $division_id);
        if ($this->db->update('divisions', $data1)) {
            return true;
        } else {
            return false;
        }
    }

    function division_save($floor_id = '', $division_name = '', $description = '', $sts = '') {
        $data1 = array(
            'floor_id' => $floor_id,
            'div_name' => $division_name,
            'div_description' => $description,
            'div_status' => $sts
        );




        if ($this->db->insert('divisions', $data1)) {
            return true;
        } else {
            return false;
        }
    }

    function division_permanent_delete($division_id = '') {
//        if ($this->get_sub_category($floor_id) == true) {
            
//        } else {
            $this->db->where('division_id', $division_id);
            if ($this->db->delete('divisions')) {
                return true;
            } else {
                return false;
            }
//        }
    }
    
    public function getDivison_by_id($division_id){
        $this->db->select('*');
        $this->db->from('divisions');
        $this->db->where('division_id',$division_id);
        $query = $this->db->get();
        $ret = ( $query->num_rows > 0 ) ? $query->result() :false ;
        return $ret;
    }
    
    public function division_change_status($division_id = '',$status = ''){
        $nw_status = ($status =='ACT') ? 'DACT' : 'ACT' ;
        $data = array(
            'div_status' => $nw_status
        );
        
        $this->db->where('division_id', $division_id);
        if($this->db->update('divisions', $data)){
            return true;
        }else{
            return false;
        }
    }
    
    
}