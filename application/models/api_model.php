<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class api_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
    function get_product_sizes_by_product_id($product_id){
        $this->db->select('sid as size_id,size_name,size_price');
        $this->db->where('product_id', $product_id);
        $this->db->where('size_status', 1);
        $query = $this->db->get("product_sizes");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }
    public function get_product_by_product_id($product_id){
        $this->db->select('product_id,product_name,product_code,product_price,product_thumb,product_image,cat_id,sub_cat_id,product_weight,product_details,min_order_qty');
		$this->db->from('product');
        $this->db->where('product_id', $product_id);
        $this->db->where('product_status', 1);
		$this->db->where('show_on_app', 1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }
    public function get_product_by_cat_id($category_id = ''){
        $this->db->select('product_id,product_name,product_code,product_price,cat_id,sub_cat_id,product_details');
		$this->db->from('product');
		if($category_id)
            $this->db->where('cat_id', $category_id);
        $this->db->where('product_status', 1);
		$query = $this->db->get();
        return $query->result();
        /*if ($query->num_rows() > 0) {
        } else {
            return false;
        }*/
    }
    public function add_session($details){
        $data = array(
           'details'   => "",
    	   'page'  => "POs-Android",
           'user_id'  =>  $this->session->userdata('ss_user_id'),
           'warehouse_id'  => $this->session->userdata('ss_warehouse_id'),
           'session_id'  => $this->session->userdata('session_id'),
           'datetime'     => date("Y-m-d H:i:s"),
    	   'ip'     => $this->input->ip_address()
        );

        if($this->db->insert('session_logs', $data)){
            return $this->db->insert_id();
        }else
    	{
          return false;
        }
   }
   function get_session($ss_session_id){
       if($ss_session_id){
            $this->db->select('*');
            $this->db->from('session_logs');
            $this->db->where('session_id', $ss_session_id);
            $query = $this->db->get();
            if ($query->num_rows() > 0) {
                return $query->row();
            } else {
                return false;
            }   
       }else{
           return false;
       }
   }
   
    
    
    function get_next_ref_no()
    {
        $this->db->select("COUNT(`sale_id`) AS sale_id");
        //$this->db->where("DATE(`sale_datetime`)", date("Y-m-d"));
        $this->db->where("sale_type", "android_pos_sale");
        return $this->db->get("`sales`");
    }
    function save_sale_header(&$sales_data, $sale_id = false)
    {
        if (!$sale_id) {
            if ($this->db->insert('sales', $sales_data)) {
                return $this->db->insert_id();
            } else {
                return false;
            }
        }else {
            $this->db->query('DELETE FROM `sale_items` WHERE `sale_id` = ' . $sale_id . '');
            $this->db->query('DELETE FROM `sales` WHERE `sale_id` = ' . $sale_id . '');
            if ($this->db->insert('sales', $sales_data)) {
                return $this->db->insert_id();
            } else {
                return false;
            }
        }
    }
    function sale_items_in($sale_details)
    {
        if ($this->db->insert('sale_items', $sale_details)) {
            return true;
        } else {
            return false;
        }
    }
    function sales_payment($data)
    {
        if ($this->db->insert('sale_payments', $data)) {
            return true;
        } else {
            return false;
        }
    }
    function complete_sale($sale_id)
    {
        return $this->db->query('UPDATE `sales` SET `sale_status`= 2 WHERE `sale_id` = ' . $sale_id);
    }
    //---------------------------------------------------------------------------- end shit
    public function get_all_category()
    {
        $this->db->select('*');
        $this->db->from('product_category');
        $this->db->where('cat_status', 1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    function get_customer_info($id)
	 {
		$this->db->select('*');
		$this->db->from('customer');
		$this->db->where("cus_id", $id);
		$this->db->order_by("cus_id", "desc");
		$query = $this->db->get();
		
		return $query->row_array(); 
	 }
    function get_next_ref_no_by_customer_id($customer_id)
    {
        $this->db->select("COUNT(`sale_id`) AS sales_count");
        $this->db->where("customer_id", $customer_id);
        $result   = $this->db->get("`sales`");
        $result   = $result->row();
        $sale_ref = sprintf("%03d", $result->sales_count + 1);
        $sale_ref = date('Ymdhis') . $customer_id . $sale_ref;
        return $sale_ref;
    }
    function update_sale($sale_data)
    {
        if ($sale_data['sale_id']) {
            $this->db->query('UPDATE `sales` SET `sale_total` = 2 WHERE `sale_id` = ' . $sale_id);
		}
    }
    function get_product_details_by_id($id)
    {
        $this->db->select('*');
        /*product_cost , product_price , credit_salling_price , wholesale_price*/
        $this->db->from('product p');
        $this->db->where("p.product_id", $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            //print_r($result);
            return $result;
        } else {
            return false;
        }
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
        $this->db->select('product_id,product_name,sale_items.print_status,unit_price as product_price ,quantity');
        $this->db->from('sale_items');
        $this->db->where("sale_items.sale_id", $sale_id);
        $query = $this->db->get();
        return $query->result_array();
    }
    function get_sale_items_by_sale_id_n_cat($sale_id,$cat_id)
    {
        $this->db->select('sale_items.product_id,sale_items.print_status,product.product_name,unit_price as product_price ,quantity');
        $this->db->from('sale_items');
        $this->db->join('product', 'product.product_id = sale_items.product_id');
        $this->db->where("sale_items.sale_id", $sale_id);
        $this->db->where('sale_items.print_status',0);
        $this->db->where('product.cat_id',$cat_id);
        $query = $this->db->get();
        return $query->result();
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
    
    /*not but required for fuck sake*/
    public function get_product_by_cat_id_app($category_id = ''){
        $this->db->select('product_id,product_name,product_code,product_price,product_thumb,product_image,cat_id,sub_cat_id,product_weight,product_details,min_order_qty');
		$this->db->from('product');
        $this->db->where('app_cat_id', $category_id);
        $this->db->where('product_status', 1);
		$this->db->where('show_on_app', 1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    /*end*/
	/*Sure functioning*/
	
    function get_price_by_size_id($sid){
        $this->db->select('size_price,size_name');
        $this->db->where('sid', $sid);
        $this->db->where('size_status', 1);
        $query = $this->db->get("product_sizes");
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return 0;
        }
    }
	function get_all_order($start='',$length='',$search_key_val='',$params="") {
		$this->db->select('orders.*, customer.cus_name,customer.cus_phone,sales.sale_id,sales.sale_reference_no,sales.sale_datetime');
		$this->db->from('orders');
		$this->db->join('customer', 'orders.customer_id = customer.cus_id', 'left');
		$this->db->join('sales', 'sales.order_id = orders.order_id', 'left');
		if($search_key_val){
			$this->db->where("orders.order_reference_no LIKE '%$search_key_val%' OR customer.cus_name LIKE '%$search_key_val%'");
		}
		if(isset($params[0]))if($params[0] != '')
		$this->db->where("orders.area_id",$params[0]);
		
		if(isset($params[1]))if($params[1] != '')
		$this->db->where("orders.customer_id",$params[1]);
		
		if(isset($params[2]))if($params[2] != '')
		$this->db->where("orders.order_datetime >=",$params[2]);
		
		if(isset($params[3]))if($params[3] != '')
		$this->db->where("orders.order_datetime <=",$params[3]);
		
		if(isset($params[4]))if($params[4] != '')
			if($params[4] == 98){
				$this->db->where("orders.status != 99");
				$this->db->where("orders.status != 5");
			}else
				$this->db->where("orders.status",$params[4]);
		
		if(isset($params[5]))if($params[5] != '')
		$this->db->where("orders.driver_id",$params[5]);
		
		if(isset($params[6]))if($params[6] != '')
		$this->db->where("orders.order_id",$params[6]);
		
		$this->db->order_by("orders.order_id", "desc");
		$query = $this->db->get();
		return $query->result_array();
		
	}
	function get_all_sales($dine_type = '')
    {
        $warehouse_id = '';
        $this->db->select('sales.*, customer.cus_name,customer.cus_phone');
        $this->db->from('sales');
        $this->db->join('customer', 'sales.customer_id = customer.cus_id', 'left');
        if ($dine_type){
            $this->db->where("sales.dine_type", $dine_type);
			$this->db->where("DATE(sales.sale_datetime)", date("Y-m-d"));
		}
        
        $this->db->where("sales.sale_status != 3 AND sales.sale_status != 99");
        
        /*if ($this->session->userdata('ss_group_id') != 1) {
            $warehouse_id = $this->session->userdata('ss_warehouse_id');
            $this->db->where("sales.warehouse_id", $warehouse_id);
        }*/
        $this->db->order_by("sales.sale_id", "desc");
        $query = $this->db->get();
	    return $query->result();
    }
    function check_juices($cat_id=""){
        $this->db->select('sales.*');
        $this->db->from('sales');
        $this->db->join('sale_items', 'sales.sale_id = sale_items.sale_id');
        $this->db->join('product', 'product.product_id = sale_items.product_id');
        $this->db->where('sale_items.print_status',0);
        if($cat_id){
            $this->db->where('product.cat_id',$cat_id);
        }
        $this->db->order_by("sales.sale_id", "asc");
        $this->db->group_by("sales.sale_id");
        $this->db->where("DATE(sales.sale_datetime)", date("Y-m-d"));
        $query = $this->db->get();
        return $query->result();
    }
	/*end sure functioning*/
	
	
	// Added By namal
	function save_grn_master($data){
		 $this->db->insert('purchases',$data);
		 return $this->db->insert_id();
	}
	
	
	function save_grn_items($data){
		 $this->db->insert('purchase_items',$data);
		 return $this->db->insert_id();
	}
	
	function save_m_grn_master($data){
		 $this->db->insert('ingredian_grn',$data);
		 return $this->db->insert_id();
	}
	
	function save_m_grn_items($data){
		 $this->db->insert('ingredian_grn_items',$data);
		 return $this->db->insert_id();
	}
	
	//added by namal 
	public function update_transfer_master($id,$data){
	    if($id>0){
	   	    $this->db->where('stm_id', $id);
		    return $this->db->update('stock_transfer_master',$data);
	     }else{
	        return false;
	    }
	}
	
}