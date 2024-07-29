<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Salary_type_model extends CI_Model {

    var $table_name = 'mstr_sal_type';

    function __construct() {
        parent::__construct();
    }

    public function salary_types_list_search($str) {
        $this->db->select('*');
        $this->db->like('mstr_sal_type_name',$str);
//        $this->db->where('mstr_sal_type_status', 1);
        $query = $this->db->get($this->table_name);
        return $query->result_array();
    }
    
    public function salary_types_list() {
        $this->db->select('*');
//        $this->db->where('mstr_sal_type_status', 1);
        $query = $this->db->get($this->table_name);
        return $query->result_array();
    }

    public function get_salary_type_details($salryType_id) {
        $this->db->select('*');
        $this->db->from($this->table_name);
        $this->db->where('mstr_sal_type_id', $salryType_id);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function save_salary_types($salary_type_id, $data) {
        if (!$salary_type_id) {
            $this->db->insert($this->table_name, $data);
        } else {
            $this->db->where('mstr_sal_type_id', $salary_type_id);
            return $this->db->update($this->table_name, $data);
        }
    }
    
    public function delete_salary_type($id){
        $this->db->where('mstr_sal_type_id', $id);

        $this->db->delete($this->table_name);
    }
    
    public function get_types(){
        $this->db->select("mstr_sal_type_name,mstr_sal_type_id");
        $query = $this->db->get($this->table_name);
        return $query->result_array();
    }

}
