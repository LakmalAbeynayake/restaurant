<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Pos_Model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
    function get_next_ref_no_2()
    {
        //return  "return";
       // $this->db->select_max("sale_id");
       // $this->db->where("DATE(`sale_datetime`)", date("Y-m-d"));
        
        $this->db->select("sale_id");
        $this->db->from("sales");
        $this->db->limit(1);
        $this->db->order_by('sale_id',"DESC");
        $query = $this->db->get();
        $result = $query->result();
        
        //echo $this->db->last_query();
      //  print_r($result);
		
		if ($query->num_rows() > 0) {
            return $result[0]->sale_id;
        } else {
            return false;
        }
		
        
    }
    
    public function get_product_by_cat_id($category_id = '')
    {
        $this->db->select('product_id,product_name,product_code,product_price,product_thumb,cat_id,sub_cat_id');
        $this->db->from('product');
        $this->db->where('cat_id', $category_id);
        $this->db->where('product_status', 1);
		$this->db->order_by("product_name", "asc");
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function get_product_by_cat_id_c($category_id = '')
    {
        $this->db->select('COUNT(product_id) as count');
        $this->db->from('product');
        $this->db->where('cat_id', $category_id);
        $this->db->where('product_status', 1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function get_all_category($id = '')
    {
        $this->db->select('*');
        $this->db->from('product_category');
        $this->db->where('cat_status', 1);
		if($id)$this->db->where('cat_id !=', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    function get_sub_category_by_cat_id($category_id = '')
    {
        $this->db->select('*');
        $this->db->from('product_sub_category');
        $this->db->where('cat_id', $category_id);
        $this->db->where('sub_cat_status', 1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    function get_product_by_cat_sub_id($category_id = '', $sub_category_id = '')
    {
        $this->db->select('product_id,product_name,product_code,product_price,product_thumb,cat_id,sub_cat_id');
        $this->db->from('product');
        $this->db->where('cat_id', $category_id);
        $this->db->where('sub_cat_id', $sub_category_id);
        $this->db->where('product_status', 1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    function get_product_by_code($product_code = '', $customer_id = '', $warehouse_id = '')
    {
        $this->db->select('p.product_id,p.product_code,p.product_name,p.product_price');
        $this->db->from('product p');
        if ($product_code) {
            $this->db->like('p.product_name', $product_code);
            $this->db->or_like('p.product_code', $product_code);
            $this->db->limit('5');
        }
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    function get_customer()
    {
        $this->db->select('*');
        $this->db->from('customer');
        $this->db->where('cus_status', 1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    function get_warehouse()
    {
        $this->db->select('*');
        $this->db->from('warehouses');
        $this->db->where('status', 1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    function get_next_ref_no()
    {
        $this->db->select_max("sale_id");
        //$this->db->where("DATE(`sale_datetime`)", date("Y-m-d"));
        return $this->db->get("`sales`");
    }
    function save_sale_header(&$sales_data, $sale_id = false)
    { 
        if(!$sale_id){
            $this->db->insert('sales', $sales_data);
        } else{
			$this->db->where("sale_id", $sale_id);
		    $this->db->update('sales', $sales_data);
        }
		return $this->db->affected_rows();
    }
	
	function save_kot_header($kot_data)
    {
        if ($kot_data) {
            if ($this->db->insert('kitchen_orders', $kot_data)) {
                return $this->db->insert_id();
            } else {
                return false;
            }
        }
    }
	
	function kot_items_in($kot_item_data,$kot_id)
    {
        
        if ($this->db->insert('kot_items', $kot_item_data)) {
            return true;
        } else {
            return false;
        }
    }

	 function update_sale_header($data_arr,$sale_id)
    {
		if($sale_id){
			 $this->db->where("sale_id", $sale_id);
		 $this->db->update('sales', $data_arr);
		}
	}
	
	
    function save_all_sale_items($data)
    {
        if ($this->db->insert_batch('sale_items', $data)) {
            return array(
                'success' => true,
                'num_rows' => $this->db->affected_rows()
            );
        } else {
            return array(
                'success' => false,
                'num_rows' => $this->db->affected_rows()
            );
        }
    }
    function save_sale_items($data)
    {
        if ($this->db->insert('sale_items', $data)) {
            return true;
        } else {
            return false;
        }
    }
    function sale_items_in_all($data){
        if($this->db->insert_batch('sale_items', $data));
            return true;
        return false;
    }
    function sale_items_in($sale_id, $pr_id, $product_code, $product_name, $quantity, $net_price, $ssubtotal,$print_status,$product_cost,$sale_date,$kot_id='',$sepr_status='')
    {
        $is_kot_enable=0;
        if($kot_id>0){
            $is_kot_enable=$this->check_is_product_kot_enable($pr_id);
        }
        if($is_kot_enable==0){
            $kot_id=null;
        }
        $data = array(
            'sale_id' => $sale_id,
            'product_id' => $pr_id,
            'product_code' => $product_code,
            'product_name' => $product_name,
            'quantity' => $quantity,
            'unit_price' => $net_price,
            'gross_total' => $ssubtotal,
			'print_status' => $print_status,
			'item_cost'=>$product_cost,
			'sale_datetime' => $sale_date,
			'user'=>$this->session->userdata('ss_user_id'),
			'kot_id'=>$kot_id,
			'cost_total'=>$quantity*$product_cost,
			'separate_status'=>$sepr_status,
			'float_id'	=> $this->session->userdata('ss_cashier_float_id'),
        );
        if ($this->db->insert('sale_items', $data)) {
            return true;
        } else {
            return false;
        }
    }
    
    function check_is_product_array_kot_enable($pr_id){
        $this->db->from('product');
        $this->db->where("ott > ", 0);
        $this->db->where_in("product_id", $pr_id);
        $query = $this->db->get();
        return $query->num_rows();
    }
    
    function check_is_product_kot_enable($product_id){
        $this->db->from('product');
         $this->db->where("ott", 1);
        $this->db->where("product_id", $product_id);
        $query = $this->db->get();
        return $query->num_rows();
    }
    
    function sales_payment($sale_id = "", $paid_by = "", $pay_amount = "", $sale_date = "", $payment_note = "", $cc_no = "", $pcc_holder = "", $pcc_type = "", $type = "", $sale_pymnt_given_amount = "", $sale_pymnt_balance_amount = "")
    {
        
        
        if($sale_pymnt_balance_amount>0){}else{$sale_pymnt_balance_amount=0;}
        $data = array(
            'sale_id' => $sale_id,
            'sale_pymnt_paying_by' => $paid_by,
            'sale_pymnt_amount' => $pay_amount,
            'sale_pymnt_date_time' => $sale_date,
            'sale_pymnt_added_date_time' => $sale_date,
            'sale_pymnt_crdt_card_no' => $cc_no,
            'sale_pymnt_crdt_card_holder_name' => $pcc_holder,
            'sale_pymnt_crdt_card_type' => $pcc_type,
            'sale_payment_type' => $type,
            'sale_pymnt_given_amount' => $sale_pymnt_given_amount,
            'sale_pymnt_balance_amount' => $sale_pymnt_balance_amount,
            'user_id' => $this->session->userdata('ss_user_id'),
             'float_id'	=> $this->session->userdata('ss_cashier_float_id'),
        );
        if ($this->db->insert('sale_payments', $data)) {
            return true;
        } else {
            return false;
        }
    }
    function complete_sale($sale_id)
    {
        if($this->db->query('UPDATE `sales` SET `sale_status`= 2 WHERE `sale_id` = ' . $sale_id)){
			return true;
		}else return false;
    }
    function get_all_sales($start = '', $length = '', $search_key_val = '', $dine_type = '', $sale_status = '', $sale_id = '')
    {
        $warehouse_id = '';
        $this->db->select('sales.*, customer.cus_name');
        $this->db->from('customer');
        $this->db->join('sales', 'sales.customer_id = customer.cus_id', 'left');
        if ($dine_type)
            $this->db->where("sales.dine_type", $dine_type);
        if ($sale_status)
            $this->db->where("sales.sale_status", $sale_status);
        if ($sale_id)
            $this->db->where("sales.sale_id", $sale_id);
        if ($this->session->userdata('ss_group_id') != 1) {
            $warehouse_id = $this->session->userdata('ss_warehouse_id');
            $this->db->where("sales.warehouse_id", $warehouse_id);
        }
        if ($search_key_val) {
            $this->db->where("customer.cus_name LIKE '%$search_key_val%' OR sales.sale_id LIKE '%$search_key_val%' OR sales.sale_reference_no LIKE '%$search_key_val%' OR sales.sale_datetime LIKE '%$search_key_val%'");
        }
        if ($start != '' && $length != '') {
            $this->db->limit($length, $start);
        }
        $this->db->order_by("sales.sale_id", "desc");
        $query = $this->db->get();
		echo $this->db->last_query();
        return $query->result_array();
    }
    function get_all_sales_c($start = '', $length = '', $search_key_val = '', $dine_type = '', $sale_status = '')
    {
        $warehouse_id = '';
        $this->db->select('COUNT(sales.sale_id) AS count_s');
        $this->db->from('customer');
        $this->db->join('sales', 'sales.customer_id = customer.cus_id', 'left');
        if ($dine_type)
            $this->db->where("sales.dine_type", $dine_type);
        if ($sale_status)
            $this->db->where("sales.sale_status", $sale_status);
        $this->db->order_by("sales.sale_id", "desc");
        if ($this->session->userdata('ss_group_id') != 1) {
            $warehouse_id = $this->session->userdata('ss_warehouse_id');
            $this->db->where("sales.warehouse_id", $warehouse_id);
        }
        if ($search_key_val) {
            $this->db->where("customer.cus_name LIKE '%$search_key_val%' OR sales.sale_id LIKE '%$search_key_val%' OR sales.sale_reference_no LIKE '%$search_key_val%' OR sales.sale_datetime LIKE '%$search_key_val%'");
        }
        if ($start != '' && $length != '') {
            $this->db->limit($length, $start);
        }
        $query = $this->db->get();
        return $query->result_array();
    }
    function get_total_paid_by_sale_id($sale_id)
    {
        $this->db->select_sum('sale_pymnt_amount');
        $this->db->from('sale_payments');
        $this->db->where("sale_id", $sale_id)->where("(sale_payment_type='sale' OR sale_payment_type='pos_sale')");
        $this->db->where("sale_pymnt_paying_by !=", "Cheque_Return");
        $query = $this->db->get();
        if ($query->row()->sale_pymnt_amount) {
            return $query->row()->sale_pymnt_amount;
        } else {
            return 0;
        }
    }
    function get_sale_info_row($sale_id)
    {
        $warehouse_id = '';
        $this->db->select('*');
        $this->db->from('sales');
        $this->db->where("sale_id", $sale_id);
        $query = $this->db->get();
        return $query->row();
    }
    function get_sale_info($sale_id)
    {
        $warehouse_id = '';
        $this->db->select('*');
        $this->db->from('sales');
        $this->db->where("sale_id", $sale_id);
        $query = $this->db->get();
        return $query->result_array();
    }
    function get_sale_items_by_sale_id($sale_id)
    {
        $this->db->select('product_name,quantity');
        $this->db->from('sale_items');
        $this->db->where("sale_items.sale_id", $sale_id);
        $query = $this->db->get();
        return $query->result_array();
    }
    public function get_sale_item_list_by_sale_id($sale_id)
    {
        $this->db->select('sale_items.product_id,sale_items.print_status, product.product_name, product.product_code, sale_items.quantity, sale_items.discount, sale_items.discount_val, sale_items.unit_price, sale_items.gross_total');
        $this->db->from('sale_items');
        $this->db->join('product', 'sale_items.product_id = product.product_id', 'left');
        $this->db->order_by("sale_items.id", "asc");
        $this->db->where("sale_items.sale_id", $sale_id);
        $query = $this->db->get();
        return $query->result_array();
    }
    function get_customers($id = '')
    {
        $this->db->select('customer.*');
        $this->db->order_by("cus_name", "asc");
        $this->db->where("cus_status", 1);
        if ($id)
            $this->db->where("cus_id", $id);
        else
            $this->db->where("cus_id !=", 1);
        $query = $this->db->get('customer');
        return $query->result_array();
    }
    public function check1()
    {
        $this->db->select('*');
        $this->db->from('sale_items');
        $query = $this->db->get();
        return $query->result_array();
    }
    function save_product($data)
    {
        if ($this->db->insert('product', $data)) {
            $lst = $this->db->insert_id();
            $dta = $this->update_product_code($lst);
            return $dta;
        } else {
            return false;
        }
    }
    function update_product_code($product_id = '')
    {
        $data = array(
            'product_code' => "PD" . sprintf("%04d", $product_id)
        );
        $this->db->where('product_id', $product_id);
        $this->db->update('product', $data);
        return $product_id;
    }
    
    function save_kot_master($data)
    {
        if ($this->db->insert('kot_master', $data)) {
            return $this->db->insert_id();
        } else {
            return 0;
        }
    }
    function check_no_of_kot_in_sale($sale_id){
        $this->db->from('kot_master');
        $this->db->where("sale_id", $sale_id);
        $query = $this->db->get();
        return $query->num_rows();
    }
    
     function check_no_of_kot_in_date($date){
        $this->db->select('count(*) as count');
        $this->db->from('kot_master');
        $this->db->where("date(system_date_time)", $date);
        $query = $this->db->get();
        return $query->row()->count;
    }
     function get_sale_item_totals($sale_id)
    {
        $this->db->select_sum('gross_total');
        $this->db->select_sum('cost_total');
        
        $this->db->from('sale_items');
        $this->db->where("sale_id", $sale_id);
        $this->db->where("valid_status", 1);
        $query = $this->db->get();
        return $query->row_array();
       
    }
    /*
    function get_sale_info_($sale_id)
    {
        $this->db->select('sales.*, customer.cus_name,customer.cus_phone');
        $this->db->from('sales');
        $this->db->where("sale_id", $sale_id);
        $this->db->join('customer', 'sales.customer_id = customer.cus_id', 'left');
        $query = $this->db->get();
        return $query->row();
    }*/
}