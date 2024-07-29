<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sales_Model extends CI_Model {
  
  private $tableName = 'sales';
  
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
		$this->db->from('sales');
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
	  $this->db->select_max('sale_id');
	  return $this->db->get('sales');
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
		$this->db->from('sales');
		$this->db->where("sale_id", $id);
		$this->db->order_by("sale_id", "desc");
		$query = $this->db->get();
		return $query->row_array(); 
	 }
	 
	//Sales item list get by id 
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

	//Sales save
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
	
	//Sales item save
	function save_sales_item(&$data_item)
	{
			$this->db->insert('sale_items',$data_item);
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
	function get_all_sales() {
		$this->db->select('sales.*, customer.cus_name');
		$this->db->from('customer');
		$this->db->join('sales', 'sales.customer_id = customer.cus_id', 'left');
		$this->db->order_by("sales.sale_id", "desc");
		$this->db->where("sales.sale_id IS NOT NULL");//("id !=",$id);
		$query = $this->db->get();
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
}