<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Proceed_Order_Model extends CI_Model {
  
  private $tableName = 'orders';
  private $tableName1 = 'proceed_order';
  private $tableName2 = 'proceed_order_item';
  function __construct() 
  {
    /* Call the Model constructor */
    parent::__construct();
  }
  
 	//get Sold Qty By WarehouseId
	public function getSoldQtyByWarehouseId($warehouse_id,$product_id)
	{
		$this->db->select_sum('si.quantity');
		$this->db->from('sale_items si');
		$this->db->join('sales s', 's.sale_id = si.sale_id', 'left');
		$this->db->where('s.warehouse_id',$warehouse_id);
		$this->db->where('si.product_id',$product_id);
		$query=$this->db->get();
		return $data['quantity']=$query->row()->quantity;
	}
function get_all_sales_return_for_report($srh_warehouse_id='',$srh_to_date='',$srh_from_date='',$sale_id='',$from='',$to='') {
		$this->db->select('sr.* , c.cus_name ,SUM(p.sale_pymnt_amount) AS total_paid_amount');
		$this->db->from('sales_return sr');
		$this->db->join('customer c', 'sr.customer_id = c.cus_id', 'left');
		$this->db->join('sale_payments p', 'sr.sl_rtn_id = p.sale_id', 'left');
		$this->db->where("p.sale_payment_type",'sales_return');
		//$this->db->join('sales_return sr', 'sr.sale_id = p.sale_id', 'left');
		$this->db->order_by("sr.sl_rtn_id", "desc");
		$this->db->group_by('sr.sl_rtn_id');
		if($srh_warehouse_id){
			$this->db->where("sr.warehouse_id",$srh_warehouse_id);//("id !=",$id);
		}
		if($srh_to_date){
			$this->db->where("sr.sl_rtn_datetime <=",$srh_to_date);//("id !=",$id);
		}
		if($srh_from_date){
			$this->db->where("sr.sl_rtn_datetime >=",$srh_from_date);//("id !=",$id);
		}
		//if($sl_rtn_id){
			//$this->db->where("sr.sl_rtn_id =",$sl_rtn_id);//("id !=",$id);
	//	}
		if($to){
		$this->db->limit($to,$from);
		}
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result_array();
	}	
	
	
		     //Sales get information
	public function get_sale_info_by_customer_id($id)
	 {
		$this->db->select('*');
		$this->db->from('orders');
		$this->db->where("customer_id", $id);
		$this->db->order_by("sale_id", "desc");
		$query = $this->db->get();
		return $query->result(); 
	 }
	 
	 

	  
 
  function get_next_ref_no(){
	  $this->db->select_max('order_id');
	  return $this->db->get('orders');
  }
 
  //Sales get avalable product qty
  function get_avalable_product_qty($product_id,$warehouse_id){
		$this->db->select_sum('fi_qty');
		$query = $this->db->get('fi_table');
		return $query->row()->fi_qty;
  }
  

	 
	//Sales item list get by id 
	public function get_order_item_list_by_order_id($sale_id)
	 {
		$this->db->select('order_items.product_id, product.product_name, product.product_code, order_items.quantity, order_items.discount, order_items.discount_val, order_items.unit_price, order_items.gross_total,product.product_part_no,product.product_oem_part_number');
		$this->db->from('order_items');
		$this->db->join('product', 'order_items.product_id = product.product_id', 'left');
		$this->db->order_by("order_items.id", "desc");
		$this->db->where("order_items.order_id", $sale_id);//("id !=",$id);
		$query = $this->db->get();
		return $query->result_array();
		
	 }


	function get_all_order($start='',$length='',$search_key_val='') {

		
		$this->db->select('*');
		$this->db->from('proceed_order');
		$this->db->join('user','proceed_order.user_id = user.user_id');
		if($search_key_val){
			$this->db->where("proceed_order.proceed_ref_no LIKE '%$search_key_val%'");
		}
		if($start!='' && $length!=''){
			$this->db->limit($length,$start);
		}
		$this->db->order_by("proceed_order.proceed_id", "desc");
		
		$query = $this->db->get();
		
		
		return $query->result_array();
	}
	
	//Sales get for print
	
	//Sales payment get 
	
	
	//Get product sujetions
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
	
	//Get all products
	function get_all_products() {
		$this->db->select('product'.'.*');
		$this->db->order_by("product_name", "asc");
		$this->db->where("product_id IS NOT NULL");//("id !=",$id);
		$query = $this->db->get('product');
		return $query->result_array();
	}
	
	//Sales payment save
	
	function get_all_pending_order($start='',$length='',$search_key_val='') {
		
		
		$this->db->select('orders.*, customer.cus_name');
		$this->db->from('customer');
		$this->db->join('orders', 'orders.customer_id = customer.cus_id', 'left');
		$this->db->order_by("orders.order_id", "desc");
		$this->db->where("orders.status",0);//("id !=",$id);
	
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result_array();
	}
	
	public function proceed($order_list)
	{ 
	
	//print_r($order_list);
	
		$data = array(
			'status' => 1
		);	
		$this->db->where_in('order_id',$order_list);
		
		$this->db->update('orders', $data);
		
		//print_r($this->db->last_query());
		
	}
	
	 function get_proceeded_items($list){

	$data = array();
$proceed_list = array();
foreach($list as $row){
		  
		$this->db->select('*');
		$this->db->where('order_id',$row);
	    $query = $this->db->get('order_items');
		$result = $query->result_array();
			//print_r($query->result());
			foreach($result as $row){
				$nestedData=array();
				//echo $row['product_id'] ;
				//$this->db->distinct();
				$this->db->select('SUM(quantity) as quantity , product_id');
				$this->db->where('order_id',$row['order_id']);
				$this->db->where('product_id',$row['product_id']);
				$query = $this->db->get('order_items');
				$query = $query->result_array();
				//print_r($query[0]['quantity']);
				//echo "|";
				$nestedData['quantity'] = $query[0]['quantity'];
				$nestedData['product_id'] = $query[0]['product_id'];
					//return $query->result_array();
				$data[] = $nestedData;
				}
				
	}
//print_r($data);
return $data;
}

		public function save_proceed_items($data)
		{
			
			
			//print_r($data);
			
			$this->db->insert('proceed_order_item',$data);  
		
			
			
		}
		public function save_proceed($orderz)
		{
			
			
			//print_r($orderz);
			
			$this->db->insert('proceed_order',$orderz);  
			  
			//$this->db->last
			
			
		}  
	
	public function cancel($order_id)
	{
		
		
		
		
		$data = array(
			'status' =>3
		);	
		$this->db->where_in('order_id',$order_id);
		
		$this->db->update('orders',$data);
		}
	
	

	
	function save_proceed_order(&$supplier_data,$sale_id=false)
	{
		
		//$this->db->insert($this->tableName,$supplier_data);
		if (!$sale_id)
		{
			$this->db->insert($this->tableName1,$supplier_data);
		}else {
			$this->db->where('order_id', $sale_id);
			return $this->db->update($this->tableName1,$supplier_data);
		}
	}	
		
	function proceed_order($list)
	{
		
		$this->db->select('*');
		$this->db->from('order_items');
		$this->db->where('order_id',$list);
		$query = $this->db->get();
		
		return $query->result_array();
		
	}	
	
function get_order($list)
{
	foreach($list as $row){
        $this->db->select('*');
		$this->db->from('orders');
		$this->db->where('order_id',$row);
		$query = $this->db->get();
		
		return $query->result_array();
	}
}	
 function get_proceed_ref_no(){
	  $this->db->select_max('proceed_ref_no');
	  return $this->db->get('proceed_order');
  }	
	
	public function get_proceed_item_list($proceed_id)
	 {
		$this->db->select('proceed_order_item.*');
		$this->db->select('proceed_order.*');
		$this->db->select('product.*');
		$this->db->join('product','product.product_id=proceed_order_item.po_item_id');
   		$this->db->join('proceed_order','proceed_order_item.proceed_id=proceed_order.proceed_id','left');
		$this->db->where('proceed_order_item.proceed_id',$proceed_id);
		$query=$this->db->get('proceed_order_item');
		//echo $this->db->last_query();
		return $query->result_array();
	}
	public function get_proceed_ref($proceed_id)
	{
		$this->db->select('*');
		$this->db->from('proceed_order');
		$this->db->where('proceed_id',$proceed_id);
		$query=$this->db->get();
		return $query->result_array();
		
		
	}
	
}