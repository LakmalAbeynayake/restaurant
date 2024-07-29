<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class summary_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
    /* Function for mapping sales data
        -- This function grabs raw sales for a day
    */
    function get_sales_data_for_summary_report($date = '', $warehouse_id = '', $get_count = false)
    {
        $date = $date ? $date : date("Y-m-d");
        $warehouse_id = $warehouse_id ? $warehouse_id : $this->session->userdata('ss_warehouse_id');
        
        if ($get_count) {
            $this->db->select('COUNT(sales.sale_id) AS count_s');
        } else {
            $this->db->select('sale_id,warehouse_id,customer_id,cost_total,sale_total,dine_type,sale_status,waiter_id,float_id,user');
        }
    
        $this->db->from('sales');
        $this->db->where("DATE(sales.sale_datetime)", $date);
        if ($warehouse_id) {
            $this->db->where("sales.warehouse_id", $warehouse_id);
        }
        $query = $this->db->get();
        return $get_count ? $query->row->count_s : $query->result();
    }
    
    public function saveData($data) {
        // Insert data into the rep_daily_summary table
        $this->db->insert('rep_daily_summary', $data);
        return $this->db->insert_id();
    }
    
    function check_report_availability($date){
        //SELECT COUNT(*) as count FROM `rep_daily_summary` WHERE rep_for_date = "2023-11-01";
        $this->db->select('COUNT(*) as count');
        $this->db->from('rep_daily_summary');
        $this->db->where('DATE(rep_for_date ) = ', $date);
        $query = $this->db->get();
        $result = $query->row()->count ? $query->row()->count : 0;
        //echo $this->db->last_query();
        return $result;
    }
    
    function get_report($date,$date_to = ""){
        $this->db->select('*');
        $this->db->from('rep_daily_summary');
        if($date_to){
            $this->db->where('DATE(rep_for_date ) >= ', $date);
            $this->db->where('DATE(rep_for_date ) <= ', $date_to);
        }else
            $this->db->where('DATE(rep_for_date ) = ', $date);
        
        $query = $this->db->get();
        if($date_to){
            return $query->result();
        }else
            return $query->row();
    }
    
    /*Fetching quaries*/
    function get_sum_of_purchases($date){
        $this->db->select_sum('grand_total', 'grand_total');
        $this->db->from('purchases');
        $this->db->where('DATE(date)', $date);
        $query = $this->db->get();
        $result = $query->row()->grand_total ? $query->row()->grand_total : 0;
        return $result;
    }
    
    function get_sum_of_grn_payments($date){
        $this->db->select_sum('sale_pymnt_amount', 'sale_pymnt_amount');
        $this->db->from('sale_payments');
        $this->db->where('DATE(sale_pymnt_date_time)', $date);
        $this->db->where('sale_payment_type', 'grn');
        $query = $this->db->get();
        $result = $query->row()->sale_pymnt_amount ? $query->row()->sale_pymnt_amount : 0;
        return $result;
    }
    
    /*--Depricated*/
    function get_sum_of_sales($date){
        $this->db->select_sum('sale_total', 'sale_total');
        $this->db->from('sales');
        $this->db->where('DATE(sale_datetime)', $date);
        $query = $this->db->get();
        $result = $query->row()->sale_total ? $query->row()->sale_total : 0;
        return $result;
    }
    
    /*--Depricated*/
    function get_sum_of_sales_cost($date){
        $this->db->select_sum('cost_total', 'cost_total');
        $this->db->from('sales');
        $this->db->where('DATE(sale_datetime)', $date);
        $query = $this->db->get();
        $result = $query->row()->cost_total ? $query->row()->cost_total : 0;
        return $result;
    }
    /*--Depricated*/
    function get_sum_of_sales_by_order_type($date,$ot){
        $this->db->select_sum('sale_total', 'sale_total');
        $this->db->from('sales');
        $this->db->where('DATE(sale_datetime)', $date);
        $this->db->where('', $ot);
        $query = $this->db->get();
        $result = $query->row()->sale_total ? $query->row()->sale_total : 0;
        return $result;
    }
    
    function get_sum_of_sale_payments($date){
        $this->db->select_sum('sale_pymnt_amount', 'sale_pymnt_amount');
        $this->db->from('sale_payments');
        $this->db->where('DATE(sale_pymnt_date_time)', $date);
        $this->db->where('sale_payment_type', 'sale');
        $query = $this->db->get();
        $result = $query->row()->sale_pymnt_amount ? $query->row()->sale_pymnt_amount : 0;
        return $result;
    }
    
    function get_sum_of_customer_returns($date){
        $this->db->select_sum('sl_rtn_total	', 'sl_rtn_total');
        $this->db->from('sales_return');
        $this->db->where('DATE(sl_rtn_datetime)', $date);
        $query = $this->db->get();
        $result = $query->row()->sl_rtn_total ? $query->row()->sl_rtn_total : 0;
        return $result;
    }
    
    /*PAYMENTS*/
    function check_in_mop_report_availability($date){
        $this->db->select('COUNT(*) as count');
        $this->db->from('rep_daily_in_mop_summary');
        $this->db->where('DATE(rep_for_date) = ', $date);
        $query = $this->db->get();
        $result = $query->row()->count ? $query->row()->count : 0;
        return $result;
    }
    function get_pymnt_summary($date,$paid_for,$paid_by){
        $this->db->select_sum('sale_pymnt_amount','sale_pymnt_amount');
        $this->db->from('sale_payments');
        $this->db->where('DATE(sale_pymnt_date_time)', $date);
        $this->db->where('sale_payment_type',$paid_for);
        $this->db->where('sale_pymnt_paying_by',$paid_by);
        $query = $this->db->get();
        $result = $query->row()->sale_pymnt_amount ? $query->row()->sale_pymnt_amount : 0;
        return $result;
    }
    
    function saveMopSummaryData($data){
        $this->db->insert('rep_daily_in_mop_summary', $data);
        return $this->db->insert_id();
    }
    /*For Gon report*/
    function get_gon_data($date, $get_count = false,$sc = 'false',$location_id){
        if ($get_count) {
            $this->db->select('COUNT(sale_id) AS count_s');
        } else {
            $this->db->select('*');
        }
        $this->db->from('rep_daily_sales_list');
        
        $this->db->where('DATE(date)', $date);
        if($location_id)
            $this->db->where('location_id', $location_id);
        
        if($sc === 'true')
            $this->db->where('sale_status', '99');
        else
            $this->db->where('sale_status !=', '99');
        
        $query = $this->db->get();
        return $get_count ? $query->row->count_s : $query->result();
    }
    function get_all_products(){
        $this->db->select('product_id,product_code,product_name');
        $this->db->from('product');
        $query = $this->db->get();
        return $query->result();
    }
    function get_sale_items_for_gon_report($date = '', $warehouse_id = '', $get_count = false)
    {
        $date = $date ? $date : date("Y-m-d");
        $warehouse_id = $warehouse_id ? $warehouse_id : $this->session->userdata('ss_warehouse_id');
        
        if ($get_count) {
            $this->db->select('COUNT(sale_id) AS count_s');
        } else {
            $this->db->select('sale_items.sale_id as sale_id,product_id,quantity,unit_price');
        }
    
        $this->db->from('sale_items');
        $this->db->join('sales','sales.sale_id = sale_items.sale_id','left');
        $this->db->where("DATE(sale_items.sale_datetime)", $date);
        $this->db->where("warehouse_id", $warehouse_id);
        //$this->db->where("user IS NOT NULL");
        $query = $this->db->get();
        return $get_count ? $query->row->count_s : $query->result();
    }
    function get_users(){
        $this->db->select('user_id,user_first_name,user_last_name');
        $this->db->from('user');
        $query = $this->db->get();
        return $query->result();
    }
    
    // daily stock
    function get_stock_movements($where){
        $this->db->where($where);
        $query = $this->db->get('stock_movements');
        return $query->result();
    }
    public function get_moved_products_by_date($date) {
        // Convert the date to MySQL date format (YYYY-MM-DD)
        $dateFormatted = date('Y-m-d', strtotime($date));

        // Select distinct product_id where movement_date matches the given date
        $this->db->distinct();
        $this->db->select('product_id');
        $this->db->from('stock_movements');
        $this->db->where('DATE(movement_date)', $dateFormatted);
        $query = $this->db->get();

        // Fetch the results and return as an array of product_ids
        $productIds = array();
        foreach ($query->result_array() as $row) {
            $productIds[] = $row['product_id'];
        }
        return $productIds;
    }
}