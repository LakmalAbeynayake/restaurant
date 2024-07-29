<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Order_Model extends CI_Model {
  
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
	 
	 
 function getPaymentsForPrint($srh_warehouse_id='',$srh_to_date='',$srh_from_date='',$srh_type='',$srh_payment_term='')
   {
	   $this->db->select('p.*,c.cus_name,b.*,u.user_first_name');
       $this->db->from('sale_payments p');
	   $this->db->join('sales b', 'b.sale_id = p.sale_id', 'left');
	   $this->db->join('warehouses w', 'w.id = b.warehouse_id', 'left');
	   $this->db->join('customer c', 'c.cus_id = b.customer_id', 'left');
	    $this->db->join('user u', 'u.user_id = p.user_id', 'left');
	
		
	   if($srh_type){
	   
	   $this->db->where("p.sale_payment_type",$srh_type);//
	   }
	   if($srh_payment_term){
	   
	   $this->db->where("p.sale_pymnt_paying_by",$srh_payment_term);//
	   }
	   if($srh_warehouse_id){
	   
	   $this->db->where("b.warehouse_id",$srh_warehouse_id);//
	   }
	   if($srh_to_date){
			$this->db->where("p.sale_pymnt_date_time <=",$srh_to_date);//("id !=",$id);
		}
		if($srh_from_date){
			$this->db->where("p.sale_pymnt_date_time >=",$srh_from_date);//("id !=",$id);
		}
	   $this->db->order_by("b.sale_id", "desc");
	  
	   $query = $this->db->get();
	   // echo $this->db->last_query();
     if($query->num_rows() >0)
     {
       return $query->result();
     }
     else
     {
       //return false;
     }

   }	
	  
   //Sales best for dashboard
   function getBestSales($year=null,$month=0,$from=0,$to=0){
	$this->db->select('SUM(ft.fi_qty)AS fi_qty_tot,p.product_name,p.product_code,p.product_part_no,p.product_oem_part_number');
	$this->db->from('fi_table ft');
	$this->db->join('product p', 'ft.fi_item_id = p.product_id', 'left');
	$this->db->where('ft.fi_type_id', 'sale');
	if($month){
		$this->db->where('MONTH(ft.fi_date_time)', $month , FALSE);
	}
	if($year){
		$this->db->where('YEAR(ft.fi_date_time)', $year , FALSE);
	}
	if($to){
		$this->db->limit($to,$from);
	}
	$this->db->order_by("fi_qty_tot", "desc");
	$this->db->group_by('ft.fi_item_id');
	$query=$this->db->get();
	return $query->result();
  }  
  
  //Sales genarate referance number
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
  
  //Sales get toatal paid 
  function get_total_paid_by_sale_id($sale_id){
	$this->db->select_sum('sale_pymnt_amount');
	$this->db->from('sale_payments');
	$this->db->where("sale_id",$sale_id)->where("(sale_payment_type='sale' OR sale_payment_type='pos_sale')");
	$query=$this->db->get();
	//echo $this->db->last_query();
	if($query->row()->sale_pymnt_amount){
		return $query->row()->sale_pymnt_amount;
	}else {
		return 0;
	}
  }
  
    //Sales get information
	public function get_sale_info($id)
	 {
		$this->db->select('*');
		$this->db->from('orders');
		$this->db->where("order_id", $id);
		$this->db->order_by("order_id", "desc");
		$query = $this->db->get();
		return $query->row_array(); 
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

public function get_proceed_order_item_list_by_po_id($sale_id)
	 {
		$this->db->select('proceed_order_item.*,product.*');
		$this->db->from('proceed_order_item');
		$this->db->join('product', 'proceed_order_item.po_item_id = product.product_id', 'left');
		$this->db->where("proceed_order_item.proceed_id", $sale_id);//("id !=",$id);
		$this->db->order_by("proceed_order_item.proceed_id", "desc");
		
		$query = $this->db->get();
		return $query->result_array();
		
	 }
	//Sales save
	function save_sales(&$supplier_data,$sale_id=false)
	{
		
		//$this->db->insert($this->tableName,$supplier_data);
		if (!$sale_id)
		{
			$this->db->insert($this->tableName,$supplier_data);
		}else {
			$this->db->where('order_id', $sale_id);
			return $this->db->update($this->tableName,$supplier_data);
		}
	}	
	
	//Sales item save
	function save_sales_item(&$data_item)
	{
			$this->db->insert('order_items',$data_item);
	}	

	//Sales get for report
	function get_all_sales_for_report($srh_warehouse_id='',$srh_to_date='',$srh_from_date='',$sale_id='',$from='',$to='',$srh_customer_id='') {
		//echo "<br/>Test".$srh_customer_id;
		$this->db->select('s.* , c.cus_name ,SUM(p.sale_pymnt_amount) AS total_paid_amount');
		$this->db->from('sales s');
		$this->db->join('customer c', 's.customer_id = c.cus_id', 'left');
		$this->db->join('sale_payments p', 's.sale_id = p.sale_id', 'left');
		$this->db->order_by("s.sale_id", "desc");
		$this->db->group_by('s.sale_id');
		//$this->db->where("p.sale_payment_type",'sale');
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
		if($srh_customer_id){
			$this->db->where("s.customer_id",$srh_customer_id);//("id !=",$id);
	}
		if($to){
		$this->db->limit($to,$from);
		}
		$query = $this->db->get();
		
		//echo $this->db->last_query();
		return $query->result_array();
	}	
	
	//Sales all get
	function get_all_order($start='',$length='',$search_key_val='') {
		$this->db->select('orders.*, customer.cus_name');
		$this->db->from('orders');
		$this->db->join('customer', 'orders.customer_id = customer.cus_id', 'left');
		if($search_key_val){
			$this->db->where("orders.order_reference_no LIKE '%$search_key_val%' OR customer.cus_name LIKE '%$search_key_val%'");
		}
		if($start!='' && $length!=''){
			$this->db->limit($length,$start);
		}
		$this->db->order_by("orders.order_id", "desc");
		
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result_array();
	}
	
	//Sales get for print
	function get_all_sales_for_print_sales() {
		$this->db->select('s.* , c.cus_name ,SUM(p.sale_pymnt_amount) AS total_paid_amount');
		$this->db->from('sales s');
		$this->db->join('customer c', 's.customer_id = c.cus_id', 'left');
		$this->db->join('sale_payments p', 's.sale_id = p.sale_id', 'left');
		$this->db->order_by("s.sale_id", "desc");
		$this->db->group_by('s.sale_id');
		$this->db->where("s.sale_id IS NOT NULL");//("id !=",$id);
		$query = $this->db->get();
		return $query->result_array();
	}
	
	//Sales payment get 
	function get_sale_payments_by_sale_id($sale_id) {
		$this->db->select('sale_payments.*,user.user_first_name,user_group.user_group_name');
		$this->db->from('sale_payments');
		$this->db->join('user', 'sale_payments.user_id = user.user_id', 'left');
		$this->db->join('user_group', 'user.group_id = user_group.user_group_id', 'left');
		$this->db->order_by("sale_payments.sale_pymnt_id", "desc");
		$this->db->where("sale_payments.sale_id",$sale_id);//("id !=",$id);
		$this->db->where("sale_payments.sale_payment_type",'sale');
		$query = $this->db->get();
		return $query->result();
	}
	
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
	function get_all_pending_order($start='',$length='',$search_key_val='',$srh_from_date='',$srh_to_date='') {
		
		
		$this->db->select('orders.*, customer.cus_name');
		$this->db->from('customer');
		$this->db->join('orders', 'orders.customer_id = customer.cus_id', 'left');
		
		$this->db->order_by("orders.order_id", "desc");
		/*
		if($srh_to_date && $srh_from_date){
			$this->db->where("orders.order_datetime <=",$srh_from_date);	
			$this->db->where("orders.order_datetime >=",$srh_to_date);	
			}
			
			else
			*/
		if($srh_from_date){
			$this->db->where("orders.order_datetime >=",$srh_from_date);	
			}
			//else
		if($srh_to_date){
			$this->db->where("orders.order_datetime <=",$srh_to_date);	
			}
			
		$this->db->where("orders.status",0);//("id !=",$id);
		/*if($search_key_val){
			$this->db->where("orders.order_reference_no LIKE '%$search_key_val%' OR customer.cus_name LIKE '%$search_key_val%'");
			//$this->db->like('sales.sale_reference_no', $search_key_val);
			//$this->db->like('customer.cus_name', $search_key_val);
		}
		//$this->db->where("product_name LIKE '%$term%' OR product_code LIKE '%$term%' OR product_oem_part_number LIKE '%$term%' OR product_part_no LIKE '%$term%'");
		if($start!='' && $length!=''){
			$this->db->limit($length,$start);
		}*/
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
//		$this->db->select();
//print_r(count($list));
/*$c = count($list);
for($i = 0;$i < $c ;$i++){
	echo $list[$i]."|";
	$this->db->select('*');
		$this->db->where('order_id',$list[$i]);
	    $query = $this->db->get('order_items');
		$result = $query->result_array();
			//print_r($query->result());
			foreach($result as $row){
				//echo $row['product_id'] ;
				
				$this->db->select('SUM(quantity) as quantity , product_id');
				$this->db->where('order_id',$row['order_id']);
				$this->db->where('product_id',$row['product_id']);
				$query = $this->db->get('order_items');
				
				//print_r($query->result_array());
					//return $query->result_array();
				
			
				
				}
				
				
				
	
	}*/
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
			//check if value exist
			
			$this->db->select('*');
			$this->db->where('po_item_id',$data['po_item_id']);
			$this->db->where('proceed_id',$data['proceed_id']);
			$query = $this->db->get('proceed_order_item');

				if($query->num_rows() >0)
				{	
					$result = $query->row_array();
					$quantity = $result['po_item_quantity'];
					$quantity += $data['po_item_quantity'];
					$sendData = array('po_item_quantity' => $quantity);
					
					$this->db->where('po_item_id',$data['po_item_id']);
					$this->db->where('proceed_id',$data['proceed_id']);
					$this->db->update('proceed_order_item',$sendData);
					
				}
				else
				{
					$this->db->insert('proceed_order_item',$data);
				}
				
			//end check
			
			
		}
		public function save_proceed($orderz)
		{	//print_r($orderz);
			$this->db->insert('proceed_order',$orderz);  
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
		
}