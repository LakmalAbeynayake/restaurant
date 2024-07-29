<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class pos_plus_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        //$this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));");
    }
    
        // Helper method for common search conditions
    private function applySearchConditions($search_key_val)
    {
        if ($search_key_val) {
            $this->db->group_start()
                ->like('customer.cus_name', $search_key_val)
                ->or_like('sales.sale_id', $search_key_val)
                ->or_like('sales.sale_reference_no', $search_key_val)
                ->or_like('sales.sale_datetime', $search_key_val)
                ->group_end();
        }
    }
    
    function get_sales_data($start = '', $length = '', $search_key_val = '', $dine_type = '', $sale_status = '', $sale_id = '', $get_count = false)
    {
        $warehouse_id = '';
        if ($get_count) {
            $this->db->select('COUNT(sales.sale_id) AS count_s');
        } else {
            $this->db->select('sales.*, customer.cus_name,customer.cus_phone');
            $this->db->select('u.user_first_name as waitername');
            $this->db->select('ca.user_first_name as cashier');
        }
    
        $this->db->from('sales');
        $this->db->join('customer', 'sales.customer_id = customer.cus_id', 'inner');
        $this->db->join('user u', 'u.user_id = sales.waiter_id', 'left');
        $this->db->join('user ca', 'ca.user_id = sales.user', 'inner');
    
        // Common conditions
        if ($dine_type) {
            $this->db->where("sales.dine_type", $dine_type);
            // Limit data to only within a day
            $this->db->where("DATE(sales.sale_datetime)", date("Y-m-d"));
        }
        $this->db->where("sales.sale_status != 3 AND sales.sale_status != 99");
        if ($sale_id) {
            $this->db->where("sales.sale_id", $sale_id);
        }
        if ($this->session->userdata('ss_group_id') != 1) {
            $warehouse_id = $this->session->userdata('ss_warehouse_id');
            $this->db->where("sales.warehouse_id", $warehouse_id);
        }
    
        // Apply search conditions
        $this->applySearchConditions($search_key_val);
    
        // Additional conditions for get_all_sales
        if (!$get_count) {
            $this->db->where("sales.float_id", $this->session->userdata('ss_cashier_float_id'));
        }
        $this->db->where("sales.qts_id",null);
    
        // Pagination conditions
        if ($start != '' && $length != '') {
            $this->db->limit($length, $start);
            $this->db->order_by("sales.sale_id", "desc");
        }
    
        $query = $this->db->get();
        return $get_count ? $query->row->count_s : $query->result_array();
    }


}