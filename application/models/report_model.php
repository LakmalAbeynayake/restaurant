<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Report_Model extends CI_Model {
  
  private $tableName = 'sales';
  
  function __construct() 
  {
    /* Call the Model constructor */
    parent::__construct();
  }
  
  
  
  
 	//get Sold Qty By WarehouseId
	public function getSoldQtyByWarehouseId($warehouse_id,$product_id,$srh_from_date='',$srh_to_date='')
	{
		$this->db->select_sum('si.quantity');
		$this->db->from('sale_items si');
		$this->db->join('sales s', 's.sale_id = si.sale_id', 'left');
		$this->db->where('s.warehouse_id',$warehouse_id);
		$this->db->where('si.product_id',$product_id);
		if($srh_to_date){
			$srh_to_date=date('Y-m-d',strtotime($srh_to_date . "+1 days"));
			$this->db->where("s.sale_datetime <=",$srh_to_date);//("id !=",$id);
		}
		if($srh_from_date){
			$this->db->where("s.sale_datetime >=",$srh_from_date);//("id !=",$id);
		}
		$query=$this->db->get();
		//echo $this->db->last_query();
		return $data['quantity']=$query->row()->quantity;
	}
	
	
	public 
	function get_location_sale_exchange_by_location_id_and_date($location_id='',$product_id='',$srh_from_date='',$srh_to_date='',$type='',$srh_warehouse_id=''){
		$this->db->select_sum('sis.item_exchanged');
		$this->db->from('sale_items_serial sis');
		$this->db->join('sales s', 's.sale_id = sis.sale_id', 'left');
		if($srh_warehouse_id)
		{
		$this->db->where('s.warehouse_id',$srh_warehouse_id);
		}
		//if($location_id)
		{
			$this->db->where('s.location_id',$location_id);
		}
		if($product_id){
		$this->db->where('sis.product_id',$product_id);
		}
		$this->db->where('sis.item_exchanged',1);
		if($srh_to_date){
			$srh_to_date=date('Y-m-d',strtotime($srh_to_date));
			$this->db->where("date(sis.item_exchanged_date) <=",$srh_to_date);//("id !=",$id);
		}
		if($srh_from_date){
			$srh_from_date=date('Y-m-d',strtotime($srh_from_date));
			$this->db->where("date(sis.item_exchanged_date) >=",$srh_from_date);//("id !=",$id);
		}
		$query=$this->db->get();
		//echo $this->db->last_query();
		return $data['item_exchanged']=$query->row()->item_exchanged;
	}
	
	
	function get_all_sales_for_sales_report($srh_warehouse_id,$srh_to_date,$srh_from_date,$srh_customer_id,$srh_payment_status)
	{
		$this->db->select('s.* , c.cus_name ,SUM(p.sale_pymnt_amount) AS total_paid_amount');
		$this->db->from('sales s');
		$this->db->join('customer c', 's.customer_id = c.cus_id', 'left');
		$this->db->join('sale_payments p', 's.sale_id = p.sale_id', 'left');
		$this->db->order_by("s.sale_id", "desc");
		$this->db->group_by('s.sale_id');
		//$this->db->where("p.sale_payment_type",'sale');

		if($srh_warehouse_id){	
			$this->db->where("s.warehouse_id",$srh_warehouse_id);
		}
		if($srh_to_date){
			$srh_to_date=date('Y-m-d',strtotime($srh_to_date . "+1 days"));
			$this->db->where("s.sale_datetime <=",$srh_to_date);
			
		}
		if($srh_from_date){
			$this->db->where("s.sale_datetime >=",$srh_from_date);
		}
		/*if($sale_id){
			$this->db->where("s.sale_id =",$sale_id);
		}*/
		if($srh_customer_id){
			$this->db->where("s.customer_id",$srh_customer_id);
	}
		if($srh_from_date){
		//$this->db->limit($srh_from_date,$srh_to_date);
		}
		$query = $this->db->get();
		
		//echo $this->db->last_query();
		return $query->result_array();
		
		
	}
	
	function get_all_sales_return_for_sales_report($srh_warehouse_id,$srh_to_date,$srh_from_date,$srh_customer_id,$srh_payment_status)
	{
		$this->db->select('s.* , c.cus_name ,SUM(p.sale_pymnt_amount) AS total_paid_amount');
		$this->db->from('sales_return s');
		$this->db->join('customer c', 's.customer_id = c.cus_id', 'left');
		$this->db->join('sale_payments p', 's.sale_id = p.sale_id', 'left');
		$this->db->order_by("s.sale_id", "desc");
		$this->db->group_by('s.sale_id');
		//$this->db->where("p.sale_payment_type",'sale');

		if($srh_warehouse_id){	
			$this->db->where("s.warehouse_id",$srh_warehouse_id);
		}
		if($srh_to_date){
			$srh_to_date=date('Y-m-d',strtotime($srh_to_date . "+1 days"));
			$this->db->where("s.sl_rtn_datetime <=",$srh_to_date);
			
		}
		if($srh_from_date){
			$this->db->where("s.sl_rtn_datetime >=",$srh_from_date);
		}
		/*if($sale_id){
			$this->db->where("s.sale_id =",$sale_id);
		}*/
		if($srh_customer_id){
			$this->db->where("s.customer_id",$srh_customer_id);
	}
		if($srh_from_date){
		$this->db->limit($srh_from_date,$srh_to_date);
		}
		$query = $this->db->get();
		
		//echo $this->db->last_query();
		return $query->result_array();
		
		
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
			$srh_to_date=date('Y-m-d',strtotime($srh_to_date . "+1 days"));
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

	function get_all_sales_bu_cus_id($cus_id) {
		$this->db->select('sales.*, customer.cus_name');
		$this->db->from('customer');
		$this->db->join('sales', 'sales.customer_id = customer.cus_id', 'left');
		$this->db->order_by("sales.sale_id", "desc");
		$this->db->where("sales.customer_id",$cus_id);//("id !=",$id);
		$query = $this->db->get();
		return $query->result();
	}	 


	function get_issued_card_status_by_card_id($sale_id,$issue_card_id) {
		$this->db->select('sp.*');
		$this->db->from('sale_payments sp');
		$this->db->where("sp.issue_card_id",$issue_card_id);
		$this->db->where("sp.sale_id",$sale_id);
		$query = $this->db->get();
		return $query->num_rows();
	}
	
		 
 function getPaymentsForPrint($srh_warehouse_id='',$srh_to_date='',$srh_from_date='',$srh_type='',$srh_payment_term='',$ss_user_id='')
   {
	    $sel='p.*,c.cus_name,b.*';
	   if($ss_user_id) $sel.=',u.user_first_name';
	   $this->db->select($sel);
       $this->db->from('sale_payments p');
	   $this->db->join('sales b', 'b.sale_id = p.sale_id', 'left');
	   $this->db->join('warehouses w', 'w.id = b.warehouse_id', 'left');
	   $this->db->join('customer c', 'c.cus_id = b.customer_id', 'left');
	    if($ss_user_id) $this->db->join('user u', 'u.user_id = p.user_id', 'left');
	
		
	   if($srh_type){
	   
	   $this->db->where("p.sale_payment_type",$srh_type);//
	   }
	   if($srh_payment_term){
	   
	   $this->db->where("p.sale_pymnt_paying_by",$srh_payment_term);//
	   }
	    if($ss_user_id){
	   
	   $this->db->where("p.user_id",$ss_user_id);//
	   }
	   if($srh_warehouse_id){
	   
	 //  $this->db->where("b.warehouse_id",$srh_warehouse_id);//
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
   
   function getChequeForPrint($srh_warehouse_id='',$srh_to_date='',$srh_from_date='',$srh_type='',$srh_payment_term='',$ss_user_id='')
   {
	    $sel='p.*,c.cus_name,b.*';
	   if($ss_user_id) $sel.=',u.user_first_name';
	   $this->db->select($sel);
       $this->db->from('sale_payments p');
	   $this->db->join('sales b', 'b.sale_id = p.sale_id', 'left');
	   $this->db->join('warehouses w', 'w.id = b.warehouse_id', 'left');
	   $this->db->join('customer c', 'c.cus_id = b.customer_id', 'left');
	   $this->db->where("p.sale_pymnt_paying_by",'Cheque');
	   
	   
	    if($ss_user_id) $this->db->join('user u', 'u.user_id = p.user_id', 'left');
	
		
	   if($srh_type){
	   
	   $this->db->where("p.sale_payment_type",$srh_type);//
	   }
	   if($srh_payment_term){
	   
	  // $this->db->where("p.sale_pymnt_paying_by",$srh_payment_term);//
	   }
	    if($ss_user_id){
	   
	   $this->db->where("p.user_id",$ss_user_id);//
	   }
	   if($srh_warehouse_id){
	   
	 //  $this->db->where("b.warehouse_id",$srh_warehouse_id);//
	   }
	   if($srh_to_date){
			$this->db->where("p.sale_pymnt_added_date_time <=",$srh_to_date);//("id !=",$id);
		}
		if($srh_from_date){
			$this->db->where("p.sale_pymnt_added_date_time >=",$srh_from_date);//("id !=",$id);
		}
	   $this->db->order_by("b.sale_id", "desc");
	  
	   $query = $this->db->get();
	  //  echo $this->db->last_query();
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
			$srh_to_date=date('Y-m-d',strtotime($srh_to_date . "+1 days"));
			$this->db->where("s.sale_datetime <=",$srh_to_date);
			
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
	
	
	function get_products_suggestions_get_by_sales_rep_id($term,$Sales_rep_id,$werehouse_id)
 {
	 $this->db->distinct();
	$this->db->select('product.*');
	$this->db->from('product');
	
	$this->db->join('sales_rep_issue_items','product.product_id = sales_rep_issue_items.product_id ','left');
	$this->db->join('sales_rep_issues','sales_rep_issue_items.sales_rep_issue_id = sales_rep_issues.sales_rep_issue_id ','left');
	
	
	$this->db->where("sales_rep_issues.wharehouse_id",$werehouse_id );
	$this->db->where("sales_rep_issues.sales_rep_id",$Sales_rep_id );
	$this->db->where("product.product_name LIKE '%$term%'");
	$this->db->or_where("sales_rep_issues.sales_rep_id",$Sales_rep_id );
	$this->db->where("sales_rep_issues.wharehouse_id",$werehouse_id );
	$this->db->where("product.product_code LIKE '%$term%'");
	$this->db->or_where("sales_rep_issues.sales_rep_id",$Sales_rep_id );
	$this->db->where("sales_rep_issues.wharehouse_id",$werehouse_id );
	$this->db->where("product.product_oem_part_number LIKE '%$term%'");
	$this->db->or_where("sales_rep_issues.sales_rep_id",$Sales_rep_id );
	$this->db->where("product.product_part_no LIKE '%$term%'");
	$this->db->where("sales_rep_issues.wharehouse_id",$werehouse_id );
	$this->db->distinct();
		
	$this->db->limit(10, 0);
		$query = $this->db->get();
	//echo $this->db->last_query();
	return $query->result_array();
	}
	
	function get_products_suggestions_get_by_sales_id_for_return($term,$sales_id)
 {
	 //$this->db->distinct();
	$this->db->select('product.product_name,product.product_code,product.product_oem_part_number 
,product.product_part_no,sale_items.*');
	$this->db->from('sale_items');
	
	$this->db->join('product','sale_items.product_id = product.product_id ','left');
	
	
	
	$this->db->where("sale_items.sale_id",$sales_id);
	$this->db->where("product.product_name LIKE '%$term%'");
	
	$this->db->or_where("sale_items.sale_id",$sales_id );
	$this->db->where("product.product_code LIKE '%$term%'");

	$this->db->or_where("sale_items.sale_id",$sales_id );
	$this->db->where("product.product_oem_part_number LIKE '%$term%'");
	
	$this->db->or_where("sale_items.sale_id",$sales_id );
	$this->db->where("product.product_part_no LIKE '%$term%'");
	
	//$this->db->distinct();
		
	$this->db->limit(10, 0);
		$query = $this->db->get();
	//echo $this->db->last_query();
	return $query->result_array();
	}
	
	
	function get_sum_of_received_item_qty($product_id,$Sales_rep_id,$werehouse_id)
	{
		$this->db->select_sum('salse_rep_issue_qty');
		$this->db->from('sales_rep_issue_items ');
		$this->db->join('sales_rep_issues','sales_rep_issue_items.sales_rep_issue_id = sales_rep_issues.sales_rep_issue_id ','left');
		$this->db->where("sales_rep_issues.wharehouse_id",$werehouse_id );
		$this->db->where("sales_rep_issues.sales_rep_id",$Sales_rep_id );
		$this->db->where("sales_rep_issue_items.product_id",$product_id );
		
		
		$query = $this->db->get();
		return $query->result_array();
	}
	
	
	function get_sum_of_invoiced_item_qty($product_id,$Sales_rep_id,$werehouse_id)
	
{
	
		$this->db->select_sum('quantity');
		$this->db->from('sale_items');
		$this->db->join('sales','sale_items.sale_id = sales.sale_id ','left');
		$this->db->where("sales.warehouse_id",$werehouse_id );
		$this->db->where("sales.sales_rep_id",$Sales_rep_id );
		$this->db->where("sale_items.product_id",$product_id );
	
		$query = $this->db->get();
		return $query->result_array();
			
}
	
	function get_sum_of_invoiced_item_qty_by_sale_id($product_id,$sale_id)
	
{
	
		$this->db->select_sum('quantity');
		$this->db->from('sale_items');
		$this->db->join('sales','sale_items.sale_id = sales.sale_id ','left');
		$this->db->where("sales.sales_rep_id",$sale_id );
		$this->db->where("sale_items.product_id",$product_id );
	
		$query = $this->db->get();
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
	
	
	public function get_all_item_list_by_sale_rep_id_and_warehouse($srh_warehouse_id,$srh_to_date,$srh_from_date,$location_id)
	{
	
	
		$this->db->select('p.product_id ,p.product_name ,p.product_code,SUM(srit.salse_rep_issue_qty) AS total_salse_rep_issue_qty');
		$this->db->from('sales_rep_issue_items srit');
		$this->db->join('product p', 'srit.product_id  = p.product_id', 'left');
		$this->db->join('sales_rep_issues sri', 'srit.location_id = sri.location_id', 'left');
		$this->db->join('sales s','sri.location_id = s.location_id', 'left');
		$this->db->order_by("p.product_name", "desc");
		$this->db->group_by('p.product_id');
		$this->db->where("sri.location_id",$location_id);
		$this->db->where("sri.wharehouse_id",$srh_warehouse_id);
		$query = $this->db->get();
		return $query->result_array();
	
	}
public function collection_summary($srh_collector_id,$srh_route_id,$srh_from_date,$srh_to_date){
		$this->db->select('sum(sp.sale_pymnt_amount) as collection , sum(sp.sale_pymnt_visiting_charge) as sale_pymnt_visiting_charge,s.sale_datetime,s.card_ref_number,s.sale_reference_no,c.cus_name,c.cus_m_phone,sp.sale_pymnt_date_time');
		$this->db->from('sales s');
		$this->db->join('sale_payments sp','s.sale_id=sp.sale_id','left');
		$this->db->join('customer c','c.cus_id=s.customer_id','left');
		if($srh_to_date){
			//$srh_to_date=date('Y-m-d',strtotime($srh_to_date . "+1 days"));
            $this->db->where("sp.sale_pymnt_date_time <=",$srh_to_date);
			}
		if($srh_from_date){
			$this->db->where("sp.sale_pymnt_date_time >=",$srh_from_date);
		}
		if($srh_collector_id){
			$this->db->where("sp.cash_collector_id",$srh_collector_id);
		}
		if($srh_route_id){
			$this->db->where("s.route_id",$srh_route_id);
		}
		if($srh_collector_id){
			$this->db->where("sp.cash_collector_id",$srh_collector_id);
		}
		$this->db->where('sp.sale_pymnt_collection_status','collected');
		$this->db->where('s.in_type','Hire');
		$this->db->group_by('sp.sale_id');	
		$query=$this->db->get();
		return $query->result_array();
		}
	public function closing_balance_summary($srh_location_id,$srh_route_id,$srh_from_date,$srh_to_date){
		
		$this->db->select('s.sale_datetime,s.card_ref_number,s.sale_reference_no,c.cus_name,c.cus_m_phone,s.sale_total,(s.sale_total-sum(sp.sale_pymnt_amount)) as balance');    
		$this->db->from('sale_payments sp');
		$this->db->join('sales s','s.sale_id=sp.sale_id','left');
		$this->db->join('customer c','c.cus_id=s.customer_id','left');
		if($srh_to_date){
			$srh_to_date=date('Y-m-d',strtotime($srh_to_date . "+1 days"));
            $this->db->where("s.sale_datetime <=",$srh_to_date);
			}
		if($srh_from_date){
			$this->db->where("s.sale_datetime >=",$srh_from_date);
		}
		if($srh_location_id){
			$this->db->where("s.location_id",$srh_location_id);
		}
		if($srh_route_id){
			$this->db->where("s.route_id",$srh_route_id);
			}
			$this->db->where("s.sale_manual_setlmnt_status",0);
			//sale_manual_setlmnt_status
		$this->db->where('s.in_type','Hire');	
		$this->db->group_by('s.sale_id');	
		$query=$this->db->get();
		return $query->result_array();
		}	
	public function count_active_accounts(){
		$data=array();
		for($i=1;$i<=50;$i++){
		$nestedData=array(); 
		$amount='(select sum(sale_pymnt_amount) from sale_payments where sale_id in (select sale_id from sales where no_of_days = '.$i.'))';
		$this->db->select('count(no_of_days) as count,(sum(sale_total)-'.$amount.') as closing_amount');
		$this->db->from('sales');
		$this->db->where('no_of_days',$i);
		$query=$this->db->get();
		$query = $query->result_array();
		$nestedData['count'] = $query[0]['count'];
		$nestedData['closing_amount'] = $query[0]['closing_amount'];
		$data[$i]=$nestedData;
		}
		return $data;
		}
	public function active_accounts_list($srh_location_id,$srh_route_id,$srh_from_date,$srh_to_date){
		$data=array();
		for($i=1;$i<=50;$i++){
		$nestedData=array();
		 $and1='';
		 $and2='';
		 $and3='';
		 $and4='';
		 $and5='';
		if($srh_route_id){
			$and1=" and route_id='".$srh_route_id."'";
			}
		if($srh_to_date){
			//$srh_to_date=date('Y-m-d',strtotime($srh_to_date . "+1 days"));
           // $this->db->where("sale_datetime <=",$srh_to_date);
			$and2=" and sale_datetime <='".$srh_to_date."'";
			}
		if($srh_from_date){
			//$this->db->where("sale_datetime >=",$srh_from_date);
			$and3=" and sale_datetime >='".$srh_from_date."'";
		}
		if($srh_location_id){
			//$this->db->where("location_id",$srh_location_id);
			$and4=" and location_id='".$srh_location_id."'";
		}
		
			//$this->db->where("location_id",$srh_location_id);
			$and5=" and in_type='Hire'";
				
		$amount='(select sum(sale_pymnt_amount) from sale_payments where sale_id in (select sale_id from sales where no_of_days = '.$i.''.$and1.''.$and2.''.$and3.''.$and4.''.$and5.'))';
		$this->db->select('count(no_of_days) as count,(sum(sale_total)-'.$amount.') as closing_amount');
		$this->db->from('sales');
		$this->db->where('no_of_days',$i);
		
		if($srh_route_id){
			$this->db->where("route_id",$srh_route_id);
			}
		if($srh_to_date){
			//$srh_to_date=date('Y-m-d',strtotime($srh_to_date . "+1 days"));
            $this->db->where("sale_datetime <=",$srh_to_date);
			//$and2=" and sale_datetime <='".$srh_to_date."'";
			}
		if($srh_from_date){
			$this->db->where("sale_datetime >=",$srh_from_date);
			//$and3=" and sale_datetime >='".$srh_from_date."'";
		}
		if($srh_location_id){
			$this->db->where("location_id",$srh_location_id);
			//$and4=" and location_id='".$srh_location_id."'";
		}		
		$this->db->where('in_type','Hire');	
		$query=$this->db->get();
		$query = $query->result_array();
		if($query[0]['closing_amount']!=0 && $query[0]['count']){
		$nestedData['sales_term']=$i;	
		$nestedData['count'] = $query[0]['count'];
		$nestedData['closing_amount'] = $query[0]['closing_amount'];
		$data[$i]=$nestedData;
		}
		}
		return $data;
				
		}		
function customer_payments_details($srh_location_id,$srh_route_id,$in_type){
		$this->db->select('s.card_ref_number,s.sale_total,s.totat_down_payment,s.sale_id,s.sale_datetime,c.cus_name,c.cus_m_phone,c.cus_address');       
	    $this->db->from('sales s');
		$this->db->join('customer c','s.customer_id=c.cus_id','left');
		$this->db->where('s.in_type',$in_type);
		if($srh_location_id){
		$this->db->where('s.location_id',$srh_location_id);
		}
		if($srh_route_id){
		$this->db->where('s.route_id',$srh_route_id);
		}
		$query=$this->db->get();
		$query=$query->result_array();	
		//print_r($query);
		return $query;
		}	
function get_payement_details($sale_id,$srh_to_date){
	$this->db->select('sale_pymnt_date_time,CASE WHEN sale_pymnt_amount = "0.00" THEN sale_pymnt_visiting_charge 
                         ELSE sale_pymnt_amount
                         END AS sale_pymnt_amount,CASE WHEN sale_pymnt_amount = "0.00" THEN "charge" 
                         ELSE "payment"
                         END AS sale_pymnt_status',FALSE);
	$this->db->from('sale_payments');
	$this->db->where('sale_id',$sale_id);
	 if($srh_to_date){
            $this->db->where("sale_pymnt_date_time <=",$srh_to_date);
	}
	$this->db->order_by("sale_pymnt_added_date_time","asc");
	$query=$this->db->get();
	$query=$query->result_array();
	$total_payment=0;
	$data=array();
	$row_details=array();
	$i=0;
	$row_details[]="<table  style=\"height:100%; border-spacing: 10px; border-collapse: separate;\"><tr>";
	foreach ($query as $row){
		if($row['sale_pymnt_status']=="charge"){	
		$bgcolor='bgcolor=\"#CC3333\"';
		}
		if($row['sale_pymnt_status']=="payment"){	
		$bgcolor='bgcolor=\"#FFCCCC\"';
		}
		//if($row['sale_pymnt_amount']!=0.00){
		if($i==0){
		//$row_details[]="<td align=\"center\" bgcolor=\"#00FF99\">$row[sale_pymnt_amount]<br><b>D/P</b></td> ";
		}
		else if($i % 6==0){
		$row_details[]="<td align=\"center\" $bgcolor>($row[sale_pymnt_date_time])</br>$row[sale_pymnt_amount]</td></tr><tr>";	
			}
	    else {
		$row_details[]="<td align=\"center\" $bgcolor>($row[sale_pymnt_date_time])</br>$row[sale_pymnt_amount]</td>";	
			}
		if($row['sale_pymnt_status']=="payment"){	
		$total_payment=$total_payment+$row['sale_pymnt_amount'];
		}
		$i=$i+1;
	   // }
		} 
		
	$row_details[]="</tr></table>";
	$data['row_details']=$row_details;
	$data['tot_payment']=$total_payment;
	return	$data;
	}
	public function in_type_sales_summary($srh_location_id,$srh_route_id,$srh_rep_id,$srh_from_date,$srh_to_date,$in_type,$srh_warehouse_id){
	//print_r($in_type);
	  $this->db->select('s.sale_datetime,s.sale_reference_no,s.card_ref_number,s.sale_total,c.cus_name,c.cus_m_phone,s.sale_id');
	  $this->db->from('sales s');
	  $this->db->join('customer c','c.cus_id=s.customer_id','left');
	  if($in_type){
	  $this->db->where("s.in_type",$in_type);
	  }
	  if($srh_warehouse_id){
	  $this->db->where("s.warehouse_id",$srh_warehouse_id);
	  }
	  if($srh_to_date){
			$srh_to_date=date('Y-m-d',strtotime($srh_to_date));
            $this->db->where("date(s.sale_datetime) <=",$srh_to_date);
			}
		if($srh_from_date){
			$this->db->where("date(s.sale_datetime) >=",$srh_from_date);
		}
		if($srh_location_id){
			if($srh_location_id=='All'){
				$this->db->where('s.location_id != ',0,FALSE);
			}else{
				$this->db->where("s.location_id",$srh_location_id);
			}
			
		}
		if($srh_route_id){
			$this->db->where("s.route_id",$srh_route_id);
			}
		if($srh_rep_id){
			$this->db->where("s.sales_rep_id",$srh_rep_id);
			}	
	  $query=$this->db->get();
	  return $query->result_array();
	}
	function get_group_product_details_for_report_sale_type($sale_id){
	$this->db->select('product_id,product_name,product_code,product_oem_part_number,product_part_no');
	$this->db->from('product');
	$this->db->where('`product_id` IN (SELECT `product_id` FROM `sale_items` WHERE `sale_id`='.$sale_id.')');
	$query=$this->db->get();
	$query=$query->result_array();
	$row_details=array();
	$i=0;
	foreach ($query as $row){
		$i=$i+1;
		$qty=0;	
		$product_id=$row['product_id'];
		$this->db->select_sum('si.quantity');
		$this->db->from('sale_items si');
		$this->db->where('si.product_id',$product_id);
		$this->db->where('si.sale_id',$sale_id);
		$query=$this->db->get();
		$qty=intval($query->row()->quantity);
		
        $row_details[]="<table  cellpadding=\"5\" cellspacing=\"0\" border=\"0\" style=\"padding-left:50px;\"><tr><td>($i).$row[product_name] <span style=\"background-color:#B6E029\">($row[product_code])</span> X $qty</td>
            </tr></table>";
		} 
	return	$row_details;
	}
function get_serial_no_using_product_id($product_id,$srh_location_id){
	$this->db->select('pis_number,product_status');
	$this->db->from('purchase_items_serial');
	$this->db->where('pis_sold',0);
	$this->db->where('product_id',$product_id);
	if($srh_location_id){
	if($srh_location_id==1){
	$this->db->where('issue_location_id',0);	
		}else{
	$this->db->where('issue_location_id',$srh_location_id);
	}
	}
	$query=$this->db->get();
	$query=$query->result_array();
	$nestedArray=array();
	foreach($query as $row){
	$nestedArray[]=$row['pis_number'].'('.$row['product_status'].')<br>';
	}
	return $nestedArray;
	}
	
	
function get_product_status_with_quantity($srh_location_id,$product_id){
	$status=array('Good','DMG','Defect','RVT','AGED');
	$count=count($status);
	$data=array();
	$nestedArray=array();
	for($i=0;$i<$count;$i++){
		$this->db->select('count(pis.piser_id) as count');
		$this->db->from('purchase_items_serial pis');
	if($srh_location_id){		
			if($srh_location_id==1){
					$this->db->where('pis.issue_location_id',0);	
									}else{
										$this->db->where('pis.issue_location_id',$srh_location_id);
										}
					    } 
		$this->db->where('pis.pis_sold',0);
		$this->db->where('pis.product_status',$status[$i]);
		$this->db->where('pis.product_id',$product_id);
		$query1=$this->db->get();
		$query1=$query1->result_array();
				           if($query1){
								if($status[$i]=='Good'){
											$nestedArray['good']=$query1[0]['count'];
														}
								else if($status[$i]=='DMG'){
											$nestedArray['DMG']=$query1[0]['count'];
															}
								else if($status[$i]=='Defect'){
											$nestedArray['Defect']=$query1[0]['count'];
															}
								else if($status[$i]=='RVT'){
											$nestedArray['RVT']=$query1[0]['count'];
															}
								else if($status[$i]=='AGED'){
											$nestedArray['AGED']=$query1[0]['count'];
															}	
									}
							}
		return $nestedArray;					
	}	
function total_product_quantity_list($product_id){
	$this->db->select('(select count(piser_id) from purchase_items_serial where product_id=p.product_id AND pis_sold="0" AND pis_issue="1") as location_count,(select count(piser_id) from purchase_items_serial where product_id=p.product_id AND pis_sold="0" AND pis_issue="0") as warehouse_count,p.product_name,p.product_oem_part_number,p.product_id');
	$this->db->from('product p');
	$this->db->join('purchase_items_serial pis','pis.product_id=p.product_id','left');
	if($product_id){
	$this->db->where('p.product_id',$product_id);
	}
	$this->db->group_by('p.product_id');
	$this->db->limit('p.product_id');
	$query=$this->db->get();
	$query=$query->result_array();
	
	
	return $query;
	}
function get_all_sale_details($srh_location_id,$srh_route_id){
$this->db->select('*');    
$this->db->from('sales');
if($srh_location_id){
$this->db->where('location_id',$srh_location_id);	
	}
if($srh_route_id){
$this->db->where('route_id',$srh_route_id);	
	}
$query=$this->db->get();
$query=$query->result_array();	
return $query;	
}	
function tot_arries_details($sale_id,$srh_to_date,$sale_datetime){
	                $amount=0;	
					$nestedData=array();	
					$interval='';
					if($srh_to_date){
							$inc_date=date('Y-m-d',strtotime($sale_datetime."+1 days"));	
							$srh_to_date=date('Y-m-d',strtotime($srh_to_date));	
							$datetime1 = date_create($inc_date);
        					$datetime2 = date_create($srh_to_date);
        					$interval = date_diff($datetime1,$datetime2);
       						$interval=$interval->format('%m');
       								}			
					$this->db->select('sum(sale_pymnt_amount) as amount');
					$this->db->from('sale_payments');
					$this->db->where('sale_id',$sale_id);
					$this->db->where('sale_pymnt_collection_status','collected');
					$this->db->where('sale_pymnt_date_time <=',$srh_to_date);
					$q=$this->db->get();
					$q=$q->result_array();
					$amount=$q[0]['amount'];
					if(!$amount){$amount=0;}	
							$this->db->select('(('.$interval.'*s.term_amount)-'.$amount.') as arries,s.sale_id,s.sale_reference_no,s.card_ref_number,s.term_amount,c.cus_name');
							$this->db->from('sales s');
							$this->db->join('customer c','c.cus_id=s.customer_id','left');
							$this->db->where('sale_id',$sale_id);
							$this->db->where('s.in_type','Hire');	
							$query=$this->db->get();
							$query=$query->result_array();	
							$nestedData['sale_id']='1';//$query[0]['sale_id'];
							$nestedData['invoice_no']='1';//$query[0]['card_ref_number'];
							$nestedData['customer'] = '1';//$query[0]['cus_name'];
							$nestedData['arries'] ='1';// $query[0]['arries'];
							$nestedData['term_amount'] = '1';//$query[0]['term_amount'];
							$nestedData['tot_payment'] = '1';//$amount;
							$data[]=$nestedData;
			
	  return $data;		
	}
function get_issue_cards_sale_details($srh_from_date,$srh_to_date,$card_ref_number){
$this->db->select('icd.sale_id');
$this->db->from('issue_card ic');
$this->db->join('issue_card_details icd','icd.issue_card_id=ic.issue_card_id','left');
if($srh_to_date){
			$srh_to_date=date('Y-m-d',strtotime($srh_to_date));
            $this->db->where("ic.issue_card_date <=",$srh_to_date);
			}
if($srh_from_date){
	        $srh_from_date=date('Y-m-d',strtotime($srh_from_date));
			$this->db->where("ic.issue_card_date >=",$srh_from_date);
		}
if($card_ref_number){
	//$this->db->where("icd.sale_id",$card_ref_number);
}
//$this->db->limit(1); 
$query=$this->db->get();
$query=$query->result_array();
//echo $this->db->last_query();

$issue_card_sale_ids=array();
foreach($query as $row){
	    $issue_card_sale_ids[]=$row['sale_id'];
		}
		//exit();
return $issue_card_sale_ids;	

	
}
function get_sale_details_for_issue_cards($issue_cards_sale_ids,$issue_status,$srh_location_id,$srh_route_id,$card_ref_number,$collector_id){
$this->db->select('icd.issue_card_detail_id,s.sale_id,s.card_ref_number,s.sale_datetime,r.route_name,ic.issue_card_date,ic.issue_card_ref_no,u.user_first_name'); $this->db->from('issue_card_details icd');   
//$this->db->from('issue_card ic');
$this->db->join('issue_card ic','ic.issue_card_id=icd.issue_card_id','left');
//$this->db->join('issue_card_details icd','icd.issue_card_id=ic.issue_card_id','left');
$this->db->join('sales s','s.sale_id=icd.sale_id','left');
$this->db->join('routes r','r.route_id=ic.route_id','left');
$this->db->join('user u','u.user_id=ic.collector_id','left');
if($issue_cards_sale_ids){
	if($issue_status=='Issued'){
		$this->db->where_in('s.sale_id',$issue_cards_sale_ids);
	}else if($issue_status=='Not_Issued'){	
		$this->db->where_not_in('s.sale_id',$issue_cards_sale_ids);
	}
}
if($card_ref_number){
	$this->db->where("s.card_ref_number",$card_ref_number);
}
if($srh_location_id){
$this->db->where('s.location_id',$srh_location_id);	
}
if($srh_route_id){
$this->db->where('ic.route_id',$srh_route_id);	
}
if($collector_id){
$this->db->where('ic.collector_id',$collector_id);	
}
//$this->db->limit(2);
$q=$this->db->get();
//echo $this->db->last_query();
$q=$q->result_array();	
return $q;
}		


	function get_sale_details_for_card_enquiry_reports($issue_status,$srh_location_id,$srh_route_id,$card_ref_number){
		$this->db->select('icd.*,s.*,ic.*,c.cus_name,u.user_first_name');    
		$this->db->from('issue_card_details icd');
		
		$this->db->join('issue_card ic','ic.issue_card_id=icd.issue_card_id','left');
		$this->db->join('sales s','s.sale_id=icd.sale_id','left');
		$this->db->join('customer c','c.cus_id=s.customer_id','left');
		$this->db->join('user u','u.user_id=ic.collector_id','left');
		
		if($card_ref_number){
			$this->db->where("s.card_ref_number",$card_ref_number);
		}
		if($srh_location_id){
			//$this->db->where('s.location_id',$srh_location_id);	
		}
		if($srh_route_id){
			//$this->db->where('s.route_id',$srh_route_id);	
		}
		//$this->db->limit(10);
		$q=$this->db->get();
		$q=$q->result_array();	
		//echo $this->db->last_query();
		return $q;
	}	
	
   public function get_grn_details_by_serail_no($pis_number)
  {
	 $this->db->select('pis.*,p.*,pr.*');
     $this->db->from('purchase_items_serial pis');
	 $this->db->join('purchases p', 'p.id = pis.purchase_id', 'left');
	 $this->db->join('purchase_items pi', 'pi.id = pis.purchase_item_id', 'left');
	 $this->db->join('product pr', 'pr.product_id = pis.product_id', 'left');
	 $this->db->where('pis.pis_number',$pis_number);
     $query = $this->db->get();
	 //echo $this->db->last_query();
     return $query->result();
  }
  
    public function get_service_details_by_serail_no($pis_number)
  {
	 $this->db->select('s.*,pr.*');
     $this->db->from('service s');
	 $this->db->join('product pr', 'pr.product_id = s.product_id', 'left');
	 $this->db->where('s.product_sn',$pis_number);
     $query = $this->db->get();
	 //echo $this->db->last_query();
     return $query->result();
  }

   public function get_issue_details_by_serail_no($pis_number)
  {
	 $this->db->select('iis.*,i.*,pr.*');
     $this->db->from('sales_rep_issue_item_serial iis');
	 $this->db->join('sales_rep_issues i', 'i.sales_rep_issue_id = iis.sales_rep_issue_id', 'left');
	 $this->db->join('sales_rep_issue_items ii', 'ii.sales_rep_issue_item_id = iis.sales_rep_issue_item_id', 'left');
	 $this->db->join('product pr', 'pr.product_id = iis.product_id', 'left');

	 $this->db->where('iis.sris_number',$pis_number);
	  $this->db->GROUP_BY('i.sales_rep_issue_id');
     $query = $this->db->get();
	 //echo $this->db->last_query();
     return $query->result();
  }	
 
 
 
   public function get_issue_return_details_by_serail_no($pis_number)
  {
	 $this->db->select('liris.*,ir.*,pr.*');
     $this->db->from('location_issue_return_item_serail liris');
	 $this->db->join('location_issue_return ir', 'ir.lir_id = liris.lir_id', 'left');
	 $this->db->join('location_issue_return_items iri', 'iri.liri_id = liris.liri_id', 'left');
	 $this->db->join('product pr', 'pr.product_id = liris.product_id', 'left');
	 $this->db->where('liris.liris_snumber',$pis_number);
     $query = $this->db->get();
	 //echo $this->db->last_query();
     return $query->result();
  }	
  
   
  public function get_sale_details_by_serail_no($pis_number)
  {
	 $this->db->select('sis.sis_number,s.sale_datetime,sis.item_exchanged_date,s.sale_id,s.card_ref_number,pr.product_name,pr.product_code,sis.item_exchanged');
     $this->db->from('sale_items_serial sis');
	 $this->db->join('sales s', 's.sale_id = sis.sale_id', 'left');
	 $this->db->join('sale_items si', 'si.id = sis.sale_item_id', 'left');
	 $this->db->join('product pr', 'pr.product_id = sis.product_id', 'left');
	 $this->db->where('sis.sis_number',$pis_number);
     $query = $this->db->get();
	 //echo $this->db->last_query();
     return $query->result();
  }	
  
  
	function get_all_sales_rep($start='',$length='',$search_key_val='',$cus_code,$customer_id,$phone_no,$cus_bill_no,$search_by_card_no='',$typ) {
		
		//echo "<br/>search_by_card_no:$search_by_card_no";

		$this->db->select('sales.*, customer.cus_name');

		$this->db->from('customer');

		$this->db->join('sales', 'sales.customer_id = customer.cus_id', 'left');
		$this->db->join('mstr_location', 'mstr_location.location_id = sales.location_id', 'left');
		$this->db->join('routes', 'routes.route_id = sales.route_id', 'left');

		$this->db->order_by("sales.sale_id", "desc");
		//$this->db->where("sales.sale_manual_setlmnt_status",0);
		if($search_key_val){
			
            $this->db->where("sales.sale_id LIKE '%$search_key_val%' OR sales.sale_reference_no LIKE '%$search_key_val%' OR customer.cus_name LIKE '%$search_key_val%' OR sales.card_ref_number LIKE '%$search_key_val%' OR mstr_location.location_name LIKE '%$search_key_val%' OR routes.route_name LIKE '%$search_key_val%'");	
       	}
		
		
		if($search_by_card_no){
			$this->db->where("sales.card_ref_number LIKE '$search_by_card_no%'");
		}
		if($cus_code){
			$this->db->where("customer.cus_code LIKE '$cus_code%'");
		}
		if($customer_id){
			$this->db->where("customer.cus_name LIKE '$customer_id%'");
		}
		if($cus_bill_no){
			$this->db->where("sales.cus_bill_no",$cus_bill_no);
		}
		if($phone_no){
			$this->db->where("customer.cus_m_phone LIKE '$phone_no%' OR customer.cus_h_phone LIKE '$phone_no%' OR customer.cus_o_phone LIKE '$phone_no%'");
		}
		
		$this->db->where("sales.sale_id IS NOT NULL");//("id !=",$id);
		
		if($start!='' && $length!=''){
            $this->db->limit($length,$start);
        }
		$query = $this->db->get();
//echo $this->db->last_query();
if($typ=='no') return $query->num_rows();
if($typ=='des') return $query->result_array();
		

	}


public function get_location_issue_by_location_id_and_date($location_id='',$product_id='',$srh_from_date='',$srh_to_date='')
	{
		
		
		$this->db->select_sum('srii.salse_rep_issue_qty');
		$this->db->from('sales_rep_issue_items srii');
		$this->db->join('sales_rep_issues sri', 'sri.sales_rep_issue_id = srii.sales_rep_issue_id', 'left');
		
		$this->db->where('srii.product_id',$product_id);
		if($location_id){
		$this->db->where('sri.location_id',$location_id);
		}
		
		//if(!$srh_from_date) $srh_from_date=
		//
		if($srh_to_date){
			$srh_to_date=date('Y-m-d',strtotime($srh_to_date));
			$this->db->where("sri.sales_rep_issue_date <=",$srh_to_date);//("id !=",$id);
		}
		//echo "srh_from_date 111:".$srh_from_date;
		if($srh_from_date){
			$srh_from_date=date('Y-m-d',strtotime($srh_from_date));
			$this->db->where("sri.sales_rep_issue_date >=",$srh_from_date);//("id !=",$id);
		}
		//echo "srh_from_date 222:".$srh_from_date;
		$query=$this->db->get();
		//echo $this->db->last_query();
		return $data['salse_rep_issue_qty']=$query->row()->salse_rep_issue_qty;
	}
	
public function get_location_issue_return_by_location_id_and_date($location_id='',$product_id='',$srh_from_date='',$srh_to_date='')
	{
		$this->db->select_sum('liri.liri_qty');
		$this->db->from('location_issue_return_items liri');
		$this->db->join('location_issue_return lir', 'lir.lir_id = liri.lir_id', 'left');
		
		$this->db->where('liri.product_id',$product_id);
		if($location_id){
		$this->db->where('lir.location_id',$location_id);
		}
		
		if($srh_to_date){
			$srh_to_date=date('Y-m-d',strtotime($srh_to_date));
			$this->db->where("lir.lir_date <=",$srh_to_date);//("id !=",$id);
		}
		if($srh_from_date){
			$srh_from_date=date('Y-m-d',strtotime($srh_from_date));
			$this->db->where("lir.lir_date >=",$srh_from_date);//("id !=",$id);
		}
		$query=$this->db->get();
		//echo $this->db->last_query();
		return $data['liri_qty']=$query->row()->liri_qty;
	}	

public function get_location_sale_by_location_id_and_date($location_id='',$product_id='',$srh_from_date='',$srh_to_date='',$in_type='',$warehouse_id='')
	{
		$this->db->select_sum('si.quantity');
		$this->db->from('sale_items si');
		$this->db->join('sales s', 's.sale_id = si.sale_id', 'left');
		
		$this->db->where('si.product_id',$product_id);
		//if($location_id)
		{
		//$this->db->where('s.location_id',$location_id);
		}
		if($warehouse_id){
		$this->db->where('s.warehouse_id',$warehouse_id);
		}
		if($in_type){
		$this->db->where('s.in_type',$in_type);
		}
		
		
		if($srh_to_date){
			$srh_to_date=date('Y-m-d H:i:s',strtotime($srh_to_date));
			
		//	echo "srh_to_date:$srh_to_date";
			$this->db->where("(s.sale_datetime) <=",$srh_to_date);//("id !=",$id);
		}
		if($srh_from_date){
			$srh_from_date=date('Y-m-d H:i:s',strtotime($srh_from_date));
			$this->db->where("(s.sale_datetime) >=",$srh_from_date);
		}
		$query=$this->db->get();
	//	echo $this->db->last_query();
		return $data['quantity']=$query->row()->quantity;
	}
	



public function get_location_sale_by_location_id_and_date_stock_movement_report($location_id='',$product_id='',$srh_from_date='',$srh_to_date='',$in_type='',$warehouse_id='')
	{
		$this->db->select('sis.sis_number');
		$this->db->from('sale_items_serial sis');
		//$this->db->from('sale_items si');
		
		$this->db->join('sale_items si', 'si.product_id = sis.product_id', 'left');
		$this->db->join('sales s', 'sis.sale_id = s.sale_id', 'left');
		
		$this->db->where('sis.product_id',$product_id);
		$this->db->where('sis.excahnge_out_status','0');
		//if($location_id)
		{
		$this->db->where('s.location_id',$location_id);
		}
		if($warehouse_id){
		$this->db->where('s.warehouse_id',$warehouse_id);
		}
		if($in_type){
		$this->db->where('s.in_type',$in_type);
		}
		
		
		if($srh_to_date){
			$srh_to_date=date('Y-m-d',strtotime($srh_to_date));
			$this->db->where("date(s.sale_datetime) <=",$srh_to_date);//("id !=",$id);
		}
		if($srh_from_date){
			$srh_from_date=date('Y-m-d',strtotime($srh_from_date));
			$this->db->where("date(s.sale_datetime) >=",$srh_from_date);
		}
		$this->db->group_by('sis.sis_id');
		$query=$this->db->get();
		//echo $this->db->last_query();
		
		//echo "row:".$query->num_rows();
		//return $data['quantity']=$query->row()->quantity;
		return $query->num_rows();
	}



public function get_location_sale_by_location_id_and_date_stock_movement_report_lst($location_id='',$product_id='',$srh_from_date='',$srh_to_date='',$in_type='',$warehouse_id='')
	{
		$this->db->select('sis.sis_number');
		$this->db->from('sale_items_serial sis');
		//$this->db->from('sale_items si');
		
		$this->db->join('sale_items si', 'si.product_id = sis.product_id', 'left');
		$this->db->join('sales s', 'sis.sale_id = s.sale_id', 'left');
		
		$this->db->where('sis.product_id',$product_id);
		$this->db->where('sis.excahnge_out_status','0');
		//if($location_id)
		{
		$this->db->where('s.location_id',$location_id);
		}
		if($warehouse_id){
		$this->db->where('s.warehouse_id',$warehouse_id);
		}
		if($in_type){
		$this->db->where('s.in_type',$in_type);
		}
		
		
		if($srh_to_date){
			$srh_to_date=date('Y-m-d',strtotime($srh_to_date));
			$this->db->where("date(s.sale_datetime) <=",$srh_to_date);//("id !=",$id);
		}
		if($srh_from_date){
			$srh_from_date=date('Y-m-d',strtotime($srh_from_date));
			$this->db->where("date(s.sale_datetime) >=",$srh_from_date);
		}
		$this->db->group_by('sis.sis_id');
		$query=$this->db->get();
		//echo $this->db->last_query();
		
		//echo "row:".$query->num_rows();
		//return $data['quantity']=$query->row()->quantity;
		return $query->num_rows();
	}


public function get_location_opening_stock($product_id,$location_id)
	{
		$this->db->select_sum('los.los_qty');
		$this->db->from('location_opening_stock los');
		$this->db->where('los.product_id',$product_id);
		$this->db->where('los.location_id',$location_id);

		$query=$this->db->get();
		//echo $this->db->last_query();
		return $data['los_qty']=$query->row()->los_qty;
	}
	
	
	

	function save_location_opening_stock(&$location_data)
	{
		$this->db->insert('location_opening_stock',$location_data);
	}	
		
	
	public function get_location_exchange_item_in_items($location_id='',$product_id='',$srh_from_date='',$srh_to_date='',$item_exchanged='')
	{
		$this->db->select('sis.*');
		$this->db->from('sale_items_serial sis');
		//$this->db->from('sale_items si');
		$this->db->join('sales s', 's.sale_id = sis.sale_id', 'left');
		$this->db->join('sale_items si', 'sis.sale_id = si.sale_id', 'left');
		
		$this->db->where('sis.product_id',$product_id);
		//if($location_id)
		{
		$this->db->where('sis.item_exchanged_location_id',$location_id);
		}		
		//if($item_exchanged)
		{
			$this->db->where('sis.item_exchanged',1);
		}

		
		if($srh_to_date){
			$srh_to_date=date('Y-m-d',strtotime($srh_to_date));
			$this->db->where("date(sis.item_exchanged_date) <=",$srh_to_date);//("id !=",$id);
		}
		if($srh_from_date){
			$srh_from_date=date('Y-m-d',strtotime($srh_from_date));
			$this->db->where("date(sis.item_exchanged_date) >=",$srh_from_date);
		}
		$this->db->group_by('sis.sis_id'); 
		//$this->db->GROUP_BY('sis'.'sis_id');
		
		$query=$this->db->get();
		//print_r($query);
		//echo $this->db->last_query();
		return $query->num_rows();;//$data['quantity']=$query->row()->quantity;
	}
	
	
		public function get_location_exchange_item_out_items($location_id='',$product_id='',$srh_from_date='',$srh_to_date='',$excahnge_out_status='')
	{
		$this->db->select('sis.*');
		$this->db->from('sale_items_serial sis');
		//$this->db->from('sale_items si');
		$this->db->join('sales s', 's.sale_id = sis.sale_id', 'left');
		$this->db->join('sale_items si', 'sis.sale_id = si.sale_id', 'left');
		
		$this->db->where('sis.product_id',$product_id);
		//if($location_id)
		{
		//$this->db->where('sis.item_exchanged_location_id',$location_id);
		$this->db->where('s.location_id',$location_id);
		}		
		//if($item_exchanged)
		{
			$this->db->where('sis.excahnge_out_status',1);
		}

		
		if($srh_to_date){
			$srh_to_date=date('Y-m-d',strtotime($srh_to_date));
			$this->db->where("date(sis.excahnge_out_date) <=",$srh_to_date);//("id !=",$id);
		}
		if($srh_from_date){
			$srh_from_date=date('Y-m-d',strtotime($srh_from_date));
			$this->db->where("date(sis.excahnge_out_date) >=",$srh_from_date);
		}
		$this->db->group_by('sis.sis_id'); 
		//$this->db->GROUP_BY('sis'.'sis_id');
		
		$query=$this->db->get();
		//print_r($query);
		//echo $this->db->last_query();
		return $query->num_rows();;//$data['quantity']=$query->row()->quantity;
	}
	
	
			public function get_location_exchange_item_out_items_2($location_id='',$product_id='',$srh_from_date='',$srh_to_date='',$excahnge_out_status='')
	{
		$this->db->select('sis.*');
		$this->db->from('sale_items_serial sis');
		//$this->db->from('sale_items si');
		$this->db->join('sales s', 's.sale_id = sis.sale_id', 'left');
		$this->db->join('sale_items si', 'sis.sale_id = si.sale_id', 'left');
		
		$this->db->where('sis.product_id',$product_id);
		//if($location_id)
		{
		//$this->db->where('sis.item_exchanged_location_id',$location_id);
		$this->db->where('sis.item_exchanged_out_location_id',$location_id);
		}		
		//if($item_exchanged)
		{
			$this->db->where('sis.excahnge_out_status',1);
		}

		
		if($srh_to_date){
			$srh_to_date=date('Y-m-d',strtotime($srh_to_date));
			$this->db->where("date(sis.excahnge_out_date) <=",$srh_to_date);//("id !=",$id);
		}
		if($srh_from_date){
			$srh_from_date=date('Y-m-d',strtotime($srh_from_date));
			$this->db->where("date(sis.excahnge_out_date) >=",$srh_from_date);
		}
		$this->db->group_by('sis.sis_id'); 
		//$this->db->GROUP_BY('sis'.'sis_id');
		
		$query=$this->db->get();
		//print_r($query);
		//echo $this->db->last_query();
		return $query->num_rows();;//$data['quantity']=$query->row()->quantity;
	}
	
	function getDamageQtyByWarehouseId($warehouse_id, $product_id, $srh_from_date = '', $srh_to_date = '',$type=''){
	    $this->db->select_sum('si.pdmgitm_quantity');
        $this->db->from('product_damage_item si');
        $this->db->join('product_damage s', 's.pdmg_id = si.pdmg_id', 'inner');
        if ($product_id)
            $this->db->where('si.product_id', $product_id);
        if ($srh_to_date) {
            $this->db->where("date(s.pdmg_datetime) <=", $srh_to_date); 
        }
        if ($srh_from_date) {
            $this->db->where("date(s.pdmg_datetime) >=", $srh_from_date); 
        }
        if ($type) {
            $this->db->where('s.dmg_type_id', $type);
        }
        $query = $this->db->get();
        return $query->row()->pdmgitm_quantity;
	}
	
	
	 public function getPurchasedRWQtyByWarehouseId($warehouse_id, $product_id, $srh_from_date = '', $srh_to_date = '')
    {
        $this->db->select_sum('pi.quantity');
        $this->db->from('ingredian_grn_items pi');
        $this->db->join('ingredian_grn p', 'p.id = pi.purchase_id', 'inner');
        if($warehouse_id){
         $this->db->where('p.warehouse_id', $warehouse_id);   
        }
        
        $this->db->where('pi.product_id', $product_id);
        if ($srh_to_date) {
            $this->db->where("date(p.date) <=", $srh_to_date);
        }
        if ($srh_from_date) {
            $this->db->where("date(p.date) >=", $srh_from_date);
        }
        $query = $this->db->get();
        //echo $this->db->last_query();
        //die;
        return $data['quantity'] = $query->row()->quantity;
    }	
    
    public function getStockAdjRWQtyByWarehouseId($warehouse_id, $product_id, $srh_from_date = '', $srh_to_date = '')
    {
        $this->db->select_sum('pi.quantity');
        $this->db->from('ingredian_stock_adj_items pi');
        $this->db->join('ingredian_stock_adj p', 'p.id = pi.purchase_id', 'inner');
        if($warehouse_id){
         $this->db->where('p.warehouse_id', $warehouse_id);   
        }
        $this->db->where('pi.product_id', $product_id);
        if ($srh_to_date) {
            $this->db->where("date(p.date) <=", $srh_to_date);
        }
        if ($srh_from_date) {
            $this->db->where("date(p.date) >=", $srh_from_date);
        }
        $query = $this->db->get();
        //echo $this->db->last_query();
        //die;
        return $data['quantity'] = $query->row()->quantity;
    }	
    
    	
}

