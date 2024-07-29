<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class restaurants_setting_model extends CI_Model {

    function __construct() {
        /* Call the Model constructor */
        parent::__construct();
    }

    function get_floors() {
        $this->db->select('*');
        $this->db->from('floor');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    
    function get_divisions() {
        $this->db->select('divisions.*,floor.floor_name');
        $this->db->from('divisions');
        $this->db->join('floor', 'divisions.floor_id=floor.floor_id');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    
    function get_tables(){
        
    }

}
