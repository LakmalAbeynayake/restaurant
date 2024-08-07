<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sales_Model extends CI_Model {
  
  private $tableName = 'sales';
  
  function __construct() 
  {
    /* Call the Model constructor */
    parent::__construct();
  }
 
  function get_next_ref_no(){
	  //return $this->db->count_all('sales');
	  $this->db->select_max('sale_id');
	  return $this->db->get('sales');
  }
 
  function get_avalable_product_qty($product_id,$warehouse_id){
		$this->db->select_sum('fi_qty');
		$query = $this->db->get('fi_table');
		return $query->row()->fi_qty;
  }
  
  function get_total_paid_by_sale_id($sale_id){
	$this->db->select_sum('sale_pymnt_amount');
	$this->db->from('sale_payments');
	$this->db->where('sale_id',$sale_id);
	$this->db->where('sale_payment_type','sale');
	$query=$this->db->get();
	if($query->row()->sale_pymnt_amount){
		return $query->row()->sale_pymnt_amount;
	}else {
		return 0;
	}
  }
  
	public function get_sale_info($id)
	 {
		$this->db->select('*');
		$this->db->from('sales');
		$this->db->where("sale_id", $id);
		$this->db->order_by("sale_id", "desc");
		$query = $this->db->get();
		return $query->row_array(); 
	 }
	 
	public function get_sale_item_list_by_sale_id($sale_id)
	 {
		$this->db->select('sale_items.product_id, product.product_name, product.product_code, sale_items.quantity, sale_items.discount, sale_items.discount_val, sale_items.unit_price, sale_items.gross_total,product.product_part_no,product.product_oem_part_number');
		$this->db->from('sale_items');
		$this->db->join('product', 'sale_items.product_id = product.product_id', 'left');
		$this->db->order_by("sale_items.id", "desc");
		$this->db->where("sale_items.sale_id", $sale_id);//("id !=",$id);
		$query = $this->db->get();
		return $query->result_array();
		
	 }

	function save_sales(&$supplier_data,$sale_id=false)
	{
		if (!$sale_id)
		{
			$this->db->insert($this->tableName,$supplier_data);
		}else {
			$this->db->where('sale_id', $sale_id);
			return $this->db->update($this->tableName,$supplier_data);
		}
	}	
	
	function save_sales_item(&$data_item)
	{
			$this->db->insert('sale_items',$data_item);
	}	

	function get_all_sales_for_report($srh_warehouse_id='',$srh_to_date='',$srh_from_date='',$sale_id='') {
		$this->db->select('s.* , c.cus_name ,SUM(p.sale_pymnt_amount) AS total_paid_amount');
		$this->db->from('sales s');
		$this->db->join('customer c', 's.customer_id = c.cus_id', 'left');
		$this->db->join('sale_payments p', 's.sale_id = p.sale_id', 'left');
		$this->db->order_by("s.sale_id", "desc");
		$this->db->group_by('s.sale_id');
		if($srh_warehouse_id){
			$this->db->where("s.warehouse_id",$srh_warehouse_id);//("id !=",$id);
		}
		if($srh_to_date){
			$this->db->where("s.sale_datetime <=",$srh_to_date);//("id !=",$id);
		}
		if($srh_from_date){
			$this->db->where("s.sale_datetime >=",$srh_from_date);//("id !=",$id);
		}
		if($sale_id){
			$this->db->where("s.sale_id =",$sale_id);//("id !=",$id);
		}
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result_array();
	}	
	
	function get_all_sales() {
		$this->db->select('sales.*, customer.cus_name');
		$this->db->from('customer');
		$this->db->join('sales', 'sales.customer_id = customer.cus_id', 'left');
		$this->db->order_by("sales.sale_id", "desc");
		$this->db->where("sales.sale_id IS NOT NULL");//("id !=",$id);
		$query = $this->db->get();
		return $query->result_array();
	}
	
	function get_all_sales_for_print_sales() {
		$this->db->select('s.* , c.cus_name ,SUM(p.sale_pymnt_amount) AS total_paid_amount');
		$this->db->from('sales s');
		$this->db->join('customer c', 's.customer_id = c.cus_id', 'left');
		$this->db->join('sale_payments p', "s.sale_id = p.sale_id AND sp.sale_payment_type ='sale'", 'left');
		$this->db->order_by("s.sale_id", "desc");
		$this->db->group_by('s.sale_id');
		$this->db->where("s.sale_id IS NOT NULL");//("id !=",$id);
		$query = $this->db->get();
		return $query->result_array();
	}
	
	function get_sale_payments_by_sale_id($sale_id) {
		$this->db->select('sale_payments.*,user.user_first_name,user_group.user_group_name');
		$this->db->from('sale_payments');
		$this->db->join('user', 'sale_payments.user_id = user.user_id', 'left');
		$this->db->join('user_group', 'user.group_id = user_group.user_group_id', 'left');
		$this->db->order_by("sale_payments.sale_pymnt_id", "desc");
		$this->db->where("sale_payments.sale_id",$sale_id);//("id !=",$id);
		$query = $this->db->get();
		return $query->result();
	}
	
	
	
	function get_products_suggestions($term) {
		$this->db->select('product'.'.*');
		$this->db->order_by("product_name", "asc");
		//$this->db->where("product_name LIKE '%$term%'");
		$this->db->where("product_name LIKE '%$term%' OR product_code LIKE '%$term%' OR product_oem_part_number LIKE '%$term%' OR product_part_no LIKE '%$term%'");
		 $this->db->limit(10, 0);
		$query = $this->db->get('product');
		//echo $this->db->last_query();
		return $query->result_array();
	}
	
	function get_all_products() {
		$this->db->select('product'.'.*');
		$this->db->order_by("product_name", "asc");
		$this->db->where("product_id IS NOT NULL");//("id !=",$id);
		$query = $this->db->get('product');
		return $query->result_array();
	}
	
	
	function save_sale_payments(&$data,$sale_pymnt_id=false)
	{
		if (!$sale_pymnt_id)
		{
			return $this->db->insert('sale_payments',$data);
		}else {
			$this->db->where('supp_id', $sale_pymnt_id);
			return $this->db->update('sale_payments',$data);
		}
	}	
}