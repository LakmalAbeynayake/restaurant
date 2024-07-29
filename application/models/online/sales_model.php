<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sales_Model extends CI_Model {
  
  private $tableName = 'sales';
  
  function __construct() 
  {
    /* Call the Model constructor */
    parent::__construct();
  }
 
 
  public function gen_ref_number_booking($column_name,$table_name,$type_code,$whecol='',$wheval='')
   {
	   
	$this->db->select_max($table_name.'.'.$column_name);
	if($whecol){
		$this->db->where($whecol, $wheval);
	}
	if($type_code == "Credit")
		  {
		$this->db->where('in_type', 'Credit');
	}else if($type_code == "Contract"){
		$this->db->where('in_type', 'Contract');
	}else {
		$this->db->where("in_type != 'Credit'");
		$this->db->where("in_type != 'Contract'");
	}
	$query = $this->db->get($table_name);
    if($query->num_rows() >0)
     {
       $g = $query->result();
	   
	  
       $u = $this->set_ref_no($g[0]->$column_name,'');
       return $u;
     }
     else
     {
       return false;
     }
   }

   function set_ref_no($f,$t)
   {
	  $w='';
   	 $d = date('Y/m/');
	 if($t){
		$w=$t;
	 }
   	 $w =$w.sprintf("%03d",$f+1);
   	 return $w;
   } 
    
 	//get Sold Qty By WarehouseId
	public function getSoldQtyByWarehouseId($warehouse_id,$product_id,$srh_from_date='',$srh_to_date='',$search_key_val='',$cat_srh='')
	{
		$this->db->select_sum('si.quantity');
		$this->db->from('sale_items si');
		$this->db->join('sales s', 's.sale_id = si.sale_id', 'left');
		$this->db->join('product p','si.product_id = p.product_id');
//		$this->db->where('s.warehouse_id',$warehouse_id);
		$this->db->join("product_category pc", "p.cat_id = pc.cat_id", "left");
	  if($cat_srh){
	  $this->db->where("pc.cat_name",$cat_srh);
	  }
		
		if($product_id)
		$this->db->where('si.product_id',$product_id);
		
		if($search_key_val){
			 $this->db->where("p.product_code LIKE '%$search_key_val%'","left");
		}
		
		if($srh_to_date){
			$srh_to_date=date('Y-m-d 23:59:59',strtotime($srh_to_date . ""));
			$this->db->where("s.sale_datetime <=",$srh_to_date);//("id !=",$id);
		}
		if($srh_from_date){
			$this->db->where("s.sale_datetime >=",$srh_from_date);//("id !=",$id);
		}
		$query=$this->db->get();
		//echo $this->db->last_query();
		//print_r($query->result());
		if($query->num_rows() >0)
     {
       return $data['quantity']=$query->row()->quantity;
     }
     else
     {
       return 0;
     }
	 
		
	}

	public function getSoldQtyByWarehouseId_sum($warehouse_id,$product_id,$srh_from_date='',$srh_to_date='')
	{
		$this->db->select_sum('si.quantity');
		$this->db->from('sale_items si');
		$this->db->join('sales s', 's.sale_id = si.sale_id', 'left');
//		$this->db->where('s.warehouse_id',$warehouse_id);
		if($product_id)
		$this->db->where('si.product_code like "%$product_code%"');		
		if($search_key_val){
			 $this->db->where("si.product_code LIKE '%$search_key_val%'","left");
		}
		
		if($srh_to_date){
			$srh_to_date=date('Y-m-d 23:59:59',strtotime($srh_to_date . ""));
			$this->db->where("s.sale_datetime <=",$srh_to_date);//("id !=",$id);
		}
		if($srh_from_date){
			$this->db->where("s.sale_datetime >=",$srh_from_date);//("id !=",$id);
		}
		$query=$this->db->get();
		//echo $this->db->last_query();
		return $data['quantity']=$query->row()->quantity;
	}

	public function getSoldPriceByWarehouseId($warehouse_id,$product_id,$srh_from_date='',$srh_to_date='',$search_key_val='',$cat_srh='')
	{
		$this->db->select_sum('si.unit_price');
		$this->db->from('sale_items si');
		$this->db->join('sales s', 's.sale_id = si.sale_id', 'left');
		
		$this->db->join('product pr','si.product_id = pr.product_id');
		$this->db->join("product_category pc", "pr.cat_id = pc.cat_id", "left");
	  if($cat_srh){
	  $this->db->where("pc.cat_name",$cat_srh);
	  }
		
		if($search_key_val){
			 $this->db->where("pr.product_code LIKE '%$search_key_val%'","left");
		}
		
		if($srh_to_date){
			$srh_to_date=date('Y-m-d 23:59:59',strtotime($srh_to_date . ""));
			$this->db->where("s.sale_datetime <=",$srh_to_date);//("id !=",$id);
		}
		if($srh_from_date){
			$this->db->where("s.sale_datetime >=",$srh_from_date);//("id !=",$id);
		}
		$query=$this->db->get();
		//echo $this->db->last_query();
		return $data['quantity']=$query->row()->unit_price;
	}

public function getCostPriceByWarehouseId($warehouse_id,$product_id,$srh_from_date='',$srh_to_date='',$search_key_val='',$cat_srh='')
	{
		$this->db->select_sum('si.item_cost * si.quantity');
		$this->db->from('sale_items si');
		$this->db->join('sales s', 's.sale_id = si.sale_id', 'left');
//		$this->db->where('s.warehouse_id',$warehouse_id);
		$this->db->join('product pr','si.product_id = pr.product_id','left');
		$this->db->join("product_category pc", "pr.cat_id = pc.cat_id", "left");

		if($cat_srh){
		$this->db->where("pc.cat_name",$cat_srh);
		}
	  	
		if($search_key_val){
			 $this->db->where("pr.product_code LIKE '%$search_key_val%'");
		}
		if($product_id)
		$this->db->where('si.product_id',$product_id);
		
		if($srh_to_date){
			$srh_to_date=date('Y-m-d 23:59:59',strtotime($srh_to_date . ""));
			$this->db->where("s.sale_datetime <=",$srh_to_date);//("id !=",$id);
		}
		if($srh_from_date){
			$this->db->where("s.sale_datetime >=",$srh_from_date);//("id !=",$id);
		}
		$query=$this->db->get();
//		echo $this->db->last_query();
//		print_r($query);
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
			$srh_to_date=date('Y-m-d 23:59:59',strtotime($srh_to_date . ""));
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
	
	
	function get_all_sales_return_for_report_2($srh_warehouse_id='',$srh_to_date='',$srh_from_date='',$srh_customer_id='') {
		$this->db->select('sr.* , c.cus_name ,SUM(p.sale_pymnt_amount) AS total_paid_amount');
		$this->db->from('sales_return sr');
		$this->db->join('customer c', 'sr.customer_id = c.cus_id', 'left');
		$this->db->join('sale_payments p', 'sr.sl_rtn_id = p.sale_id', 'left');
		$this->db->where("p.sale_payment_type",'sales_return');
		//$this->db->join('sales_return sr', 'sr.sale_id = p.sale_id', 'left');
		$this->db->order_by("sr.sl_rtn_id", "desc");
		$this->db->group_by('sr.sl_rtn_id');
		if($srh_customer_id){
			$this->db->where("sr.customer_id",$srh_customer_id);//("id !=",$id);
		}
		if($srh_warehouse_id){
			$this->db->where("sr.warehouse_id",$srh_warehouse_id);//("id !=",$id);
		}
		if($srh_to_date){
			$srh_to_date=date('Y-m-d 23:59:59',strtotime($srh_to_date . ""));
			$this->db->where("sr.sl_rtn_datetime <=",$srh_to_date);//("id !=",$id);
		}
		if($srh_from_date){
			$this->db->where("sr.sl_rtn_datetime >=",$srh_from_date);//("id !=",$id);
		}
		//if($sl_rtn_id){
			//$this->db->where("sr.sl_rtn_id =",$sl_rtn_id);//("id !=",$id);
	//	}
		//if($to){
		//$this->db->limit($to,$from);
		//}
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
	
	function get_all_sales_by_cus_id($cus_id,$warehouse_id) {
		$this->db->select('sales.*, customer.cus_name');
		$this->db->from('customer');
		$this->db->join('sales', 'sales.customer_id = customer.cus_id', 'left');
		$this->db->order_by("sales.sale_id", "desc");
//		$this->db->where("sales.customer_id",$cus_id);
		$where = 'sales.customer_id = '.$cus_id.' AND sales.warehouse_id = '.$warehouse_id.'';
		$this->db->where($where);//("id !=",$id);
		$query = $this->db->get();
//		print_r($query);
		return $query->result();
	}	 
	 
 function getPaymentsForPrint($srh_warehouse_id='',$srh_to_date='',$srh_from_date='',$srh_type='',$srh_payment_term='',$ss_user_id='')
   {
	   $warehouse_id='';
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
	   
	   $this->db->where("b.warehouse_id",$srh_warehouse_id);//
	   
	   }else{
	 	$this->session->userdata('ss_warehouse_id');
		$warehouse_id =	$this->session->userdata('ss_warehouse_id');
		
//		echo $warehouse_id;
		$this->db->where("b.warehouse_id",$warehouse_id);
		//		echo "INN";
		}
		   
		  // $srh_to_date=date('Y-m-d 23:59:59',strtotime($srh_to_date . ""));
	   
	   if($srh_to_date){
			$this->db->where("p.sale_pymnt_added_date_time <=",$srh_to_date);//("id !=",$id);
		}
		if($srh_from_date){
			$this->db->where("p.sale_pymnt_added_date_time >=",$srh_from_date);//("id !=",$id);
		}
		
		
		//$this->db->where('sell_date BETWEEN "'. date('Y-m-d', strtotime($srh_from_date)). '" and "'. date('Y-m-d', strtotime($end_date)).'"');
		
		$this->db->where("p.sale_payment_type",'sale');
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
   
   
    function getPaymentsForPrint_rtn($srh_warehouse_id='',$srh_to_date='',$srh_from_date='',$srh_type='',$srh_payment_term='',$ss_user_id='')
   {
	   $warehouse_id='';
	    $sel='p.*,c.cus_name,sr.*';
	   if($ss_user_id) $sel.=',u.user_first_name';
	   $this->db->select($sel);
       $this->db->from('sale_payments p');
	   $this->db->join('sales_return sr', 'sr.sl_rtn_id = p.sale_id', 'left');
	   $this->db->join('warehouses w', 'w.id = sr.warehouse_id', 'left');
	   $this->db->join('customer c', 'c.cus_id = sr.customer_id', 'left');
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
	   
	   $this->db->where("sr.warehouse_id",$srh_warehouse_id);//
	   
	   }else{
	 	$this->session->userdata('ss_warehouse_id');
		$warehouse_id =	$this->session->userdata('ss_warehouse_id');
		
//		echo $warehouse_id;
		$this->db->where("sr.warehouse_id",$warehouse_id);
		
		
		
		//		echo "INN";
		}


		$this->db->where("p.sale_payment_type",'sales_return');
		   
		   
	   
	   if($srh_to_date){
			$this->db->where("p.sale_pymnt_date_time <=",$srh_to_date);//("id !=",$id);
		}
		if($srh_from_date){
			$this->db->where("p.sale_pymnt_date_time >=",$srh_from_date);//("id !=",$id);
		}
	   $this->db->order_by("sr.sl_rtn_id", "desc");
	  
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
     function get_all_sales_return_for_view($srh_warehouse_id='',$srh_to_date='',$srh_from_date='',$srh_customer_id='') {
		
		//echo $srh_warehouse_id."*",$srh_to_date."*",$srh_from_date."*",$srh_customer_id."*"; 
		
	/*	$this->db->select('sum(sl_rtn_total) AS sl_rtn_total');
		$this->db->from('sales_return');
	
		if($srh_customer_id){
			$this->db->where("customer_id",$srh_customer_id);
		}
		
		if($srh_warehouse_id){
			$this->db->where("warehouse_id",$srh_warehouse_id);//("id !=",$id);
		}
		
		
		$this->db->order_by("sl_rtn_id", "desc");
		$this->db->group_by('sl_rtn_id');
		
		*/
	
		$query = $this->db->query('SELECT sum(sl_rtn_total) FROM sales_return WHERE customer_id = '.$srh_customer_id.' AND warehouse_id = '.$srh_warehouse_id.' ');

	//	echo $this->db->last_query();
		return $query->result_array();
	}
   
   function get_all_sales_return_for_balance_report($srh_warehouse_id='',$srh_to_date='',$srh_from_date='',$srh_customer_id='') {
		
		//echo $srh_warehouse_id."*",$srh_to_date."*",$srh_from_date."*",$srh_customer_id."*"; 
		
		$this->db->select('sr.* , c.cus_name,SUM(p.sale_pymnt_amount) AS total_paid_amount');
		$this->db->from('sales_return sr');
		$this->db->join('customer c', 'sr.customer_id = c.cus_id', 'left');
		
		$this->db->join('sale_payments p', 'sr.sl_rtn_id = p.sale_id', 'left');
		
		if($srh_customer_id){
			$this->db->where("sr.customer_id",$srh_customer_id);
		}
		$this->db->order_by("sr.sl_rtn_id", "desc");
		$this->db->group_by('sr.sl_rtn_id');
		if($srh_warehouse_id){
			$this->db->where("sr.warehouse_id",$srh_warehouse_id);//("id !=",$id);
		}
		
//		if($srh_to_date){
//			$srh_to_date=date('Y-m-d',strtotime($srh_to_date . ""));
//			$this->db->where("s.sale_datetime <=",$srh_to_date);
			
//		}
		
		if($srh_from_date){
			$this->db->where("sr.sl_rtn_datetime >=",$srh_from_date);//("id !=",$id);
		}
		
		if($srh_to_date){
			$this->db->where("sr.sl_rtn_datetime <=",$srh_to_date);//("id !=",$id);
		}
	/*	if($srh_from_date){
			$this->db->where("sr.sl_rtn_datetime >=",$srh_from_date);//("id !=",$id);
		}
	*/	
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result_array();
	}	
	
	function getPaymentsForView($srh_warehouse_id='',$srh_to_date='',$srh_from_date='',$srh_type='',$srh_payment_term='',$ss_user_id='',$srh_customer_id='')
   {
	   $warehouse_id='';
	   $this->db->select('sum(p.sale_pymnt_amount),b.*');
       $this->db->from('sale_payments p');
	   $this->db->join('sales b', 'b.sale_id = p.sale_id', 'left');
	   $this->db->join('warehouses w', 'w.id = b.warehouse_id', 'left');
	   $this->db->join('customer c', 'c.cus_id = b.customer_id', 'left');
		$this->db->where("p.sale_pymnt_paying_by != ","Cheque_Return");
	   	
	   if($srh_type){
	   
	   $this->db->where("p.sale_payment_type",$srh_type);//
	   }
	   if($srh_payment_term){
	   
	   $this->db->where("p.sale_pymnt_paying_by !=",$srh_payment_term);//
	   }
	if($srh_customer_id)
		{
		$this->db->where("b.warehouse_id =".$srh_warehouse_id." AND b.customer_id=".$srh_customer_id."" );//	   
		}
		else
		
		 if($srh_warehouse_id){
	   
	   $this->db->where("b.warehouse_id",$srh_warehouse_id);//
	   
	   }else{
	 	$this->session->userdata('ss_warehouse_id');
		$warehouse_id =	$this->session->userdata('ss_warehouse_id');
		
		$this->db->where("b.warehouse_id",$warehouse_id);

		}
		   
		   
	   $this->db->order_by("b.sale_id", "desc");
	  
	   $query = $this->db->get();
	   
     if($query->num_rows() >0)
     {
       return $query->result_array();
     }
     else
     {
       //return false;
     }

   }
	
	  function getPaymentsForBalance($srh_warehouse_id='',$srh_to_date='',$srh_from_date='',$srh_type='',$srh_payment_term='',$ss_user_id='',$srh_customer_id='')
   {
	   $warehouse_id='';
	    $sel='p.*,c.cus_name,b.*';
	   if($ss_user_id) $sel.=',u.user_first_name';
	   $this->db->select($sel);
       $this->db->from('sale_payments p');
	   $this->db->join('sales b', 'b.sale_id = p.sale_id', 'left');
	   $this->db->join('warehouses w', 'w.id = b.warehouse_id', 'left');
	   $this->db->join('customer c', 'c.cus_id = b.customer_id', 'left');
	   $this->db->where('sale_pymnt_paying_by !=','Cheque_Return');
	    if($ss_user_id) $this->db->join('user u', 'u.user_id = p.user_id', 'left');

		
		
		
		if($srh_from_date){

			$this->db->where("p.sale_pymnt_added_date_time >=",$srh_from_date);//("id !=",$id);
		}
		
		
		if($srh_to_date){
			
			$srh_to_date=date('Y-m-d 23:59:59',strtotime($srh_to_date));
			
			$this->db->where("p.sale_pymnt_added_date_time <=",$srh_to_date);//("id !=",$id);
		}
		
	   if($srh_type){
	   
	   $this->db->where("p.sale_payment_type",$srh_type);//
	   }
	   if($srh_payment_term){
	   
	   $this->db->where("p.sale_pymnt_paying_by",$srh_payment_term);//
	   }
	    if($ss_user_id){
	   
	   $this->db->where("p.user_id",$ss_user_id);//
	   }
	   
	if($srh_customer_id)
		{
		$this->db->where("b.warehouse_id =".$srh_warehouse_id." AND b.customer_id=".$srh_customer_id."" );//	   
		}
		else
		
		 if($srh_warehouse_id){
	   
	   $this->db->where("b.warehouse_id",$srh_warehouse_id);//
	   
	   }else{
	 	$this->session->userdata('ss_warehouse_id');
		$warehouse_id =	$this->session->userdata('ss_warehouse_id');
		
//		echo $warehouse_id;
		$this->db->where("b.warehouse_id",$warehouse_id);
		//		echo "INN";
		}
		   
		   
	   /*
	   if($srh_to_date){
			$this->db->where("p.sale_pymnt_added_date_time <=",$srh_to_date);//("id !=",$id);
		}
		if($srh_from_date){
			$this->db->where("p.sale_pymnt_added_date_time >=",$srh_from_date);//("id !=",$id);
		}*/
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
   
function getPurchasePaymentsForBalance($srh_warehouse_id='',$srh_to_date='',$srh_from_date='',$srh_type='',$srh_payment_term='',$ss_user_id='',$srh_supplier_id='',$start='',$length='',$search_key_val='')
{
	$warehouse_id='';
	$sel='p.*,c.supp_company_name,b.*';
	if($ss_user_id) $sel.=',u.user_first_name';
	$this->db->select($sel);
	$this->db->from('sale_payments p');
	if($srh_type == 'grn')
	$this->db->join('purchases b', 'b.id = p.sale_id', 'left');
	if($srh_type == 'grn_r')
	$this->db->join('purchases_return b', 'b.pr_id = p.sale_id', 'left');
	$this->db->join('warehouses w', 'w.id = b.warehouse_id', 'left');
	$this->db->join('supplier c', 'c.supp_id = b.supplier_id', 'left');
	if($ss_user_id)
		$this->db->join('user u', 'u.user_id = p.user_id', 'left');
	if($srh_from_date){
		$this->db->where("p.sale_pymnt_added_date_time >=",$srh_from_date);//("id !=",$id);
	}
	if($srh_to_date){
		$srh_to_date=date('Y-m-d 23:59:59',strtotime($srh_to_date));
		$this->db->where("p.sale_pymnt_added_date_time <=",$srh_to_date);//("id !=",$id);
	}
	if($srh_type){
		$this->db->where("p.sale_payment_type",$srh_type);//
	}
	//$this->db->where("p.sale_pymnt_paying_by != 'Return_cash' ");
	if($srh_payment_term){
		$this->db->where("p.sale_pymnt_paying_by",$srh_payment_term);//
	}
	//if($ss_user_id){
	//	$this->db->where("p.user_id",$ss_user_id);//
	//}
	if($search_key_val){
         $this->db->where("p.reference_no LIKE '%$search_key_val%' OR p.id LIKE '%$search_key_val%' OR p.sale_pymnt_paying_by LIKE '%$search_key_val%'");
	}
	if($start!='' && $length!=''){
		$this->db->limit($length,$start);
	}	
	
	if($srh_supplier_id)
	{
		$this->db->where("b.warehouse_id =".$srh_warehouse_id." AND b.supplier_id=".$srh_supplier_id."" );//	   
	}
	else if($srh_warehouse_id){
		$this->db->where("b.warehouse_id",$srh_warehouse_id);//
	}else{
		$this->session->userdata('ss_warehouse_id');
		$warehouse_id =	$this->session->userdata('ss_warehouse_id');
		$this->db->where("b.warehouse_id",$warehouse_id);
	}
	$this->db->order_by("b.id", "desc");
	$query = $this->db->get();
	// echo $this->db->last_query();
	if($query->num_rows() >0)
	{
		return $query->result();
	}
	else
	{
	//	return false;
	}
}
   
   function getSumPaymentsForBalanceRep($srh_warehouse_id='',$srh_to_date='',$srh_from_date='',$srh_type='',$srh_payment_term='',$ss_user_id='',$srh_customer_id='',$return_name='')
   {
	   $warehouse_id='';
	    $sel='SUM(p.sale_pymnt_amount) AS '.$return_name.'';
	   if($ss_user_id) $sel.=',u.user_first_name';
	   $this->db->select($sel);
       $this->db->from('sale_payments p');
	   $this->db->join('sales b', 'b.sale_id = p.sale_id', 'left');
//	   $this->db->join('warehouses w', 'w.id = b.warehouse_id', 'left');
//	   $this->db->join('customer c', 'c.cus_id = b.customer_id', 'left');
//	   $this->db->where('sale_pymnt_paying_by !=','Cheque_Return');
	    if($ss_user_id) $this->db->join('user u', 'u.user_id = p.user_id', 'left');

		
		
		
		
		if($srh_from_date){
			
			$this->db->where("p.sale_pymnt_added_date_time >=",$srh_from_date);//("id !=",$id);
		}
		
		if($return_name == 'tot_sp'){
				   $this->db->where('sale_pymnt_paying_by !=','Cheque_Return');
			}
		
		if($return_name == 'unrealized_chq'){
			$srh_to_date=date('Y-m-d 23:59:59',strtotime($srh_to_date. ""));
			$this->db->where("p.sale_pymnt_date_time >=",$srh_to_date);//("id !=",$id);
			
			}else
		if($srh_to_date){
			
			$srh_to_date=date('Y-m-d 23:59:59',strtotime($srh_to_date. ""));
			$this->db->where("p.sale_pymnt_added_date_time <=",$srh_to_date);//("id !=",$id);
		}
		
	   if($srh_type){
	   
	   $this->db->where("p.sale_payment_type",$srh_type);//
	   }
	   if($srh_payment_term){
	   
	   $this->db->where("p.sale_pymnt_paying_by",$srh_payment_term);//
	   }
	    if($ss_user_id){
	   
	   $this->db->where("p.user_id",$ss_user_id);//
	   }
	   
	if($srh_customer_id)
		{
		$this->db->where("b.warehouse_id =".$srh_warehouse_id." AND b.customer_id=".$srh_customer_id."" );//	   
		}
		else
		
		 if($srh_warehouse_id){
	   
	   $this->db->where("b.warehouse_id",$srh_warehouse_id);//
	   
	   }else{
	 	$this->session->userdata('ss_warehouse_id');
		$warehouse_id =	$this->session->userdata('ss_warehouse_id');
		
//		echo $warehouse_id;
		$this->db->where("b.warehouse_id",$warehouse_id);
		//		echo "INN";
		}
		   
		   
	   /*
	   if($srh_to_date){
			$this->db->where("p.sale_pymnt_added_date_time <=",$srh_to_date);//("id !=",$id);
		}
		if($srh_from_date){
			$this->db->where("p.sale_pymnt_added_date_time >=",$srh_from_date);//("id !=",$id);
		}*/
//	   $this->db->order_by("b.sale_id", "desc");
	  
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
   
   
    function getSumPurchasePaymentsForBalanceRep($srh_warehouse_id='',$srh_to_date='',$srh_from_date='',$srh_type='',$srh_payment_term='',$ss_user_id='',$srh_customer_id='',$return_name='',$some_id='')
   {
	   $warehouse_id='';
	    $sel='SUM(p.sale_pymnt_amount) AS '.$return_name.'';
	   if($ss_user_id) $sel.=',u.user_first_name';
	   $this->db->select($sel);
       $this->db->from('sale_payments p');
	   $this->db->join('sales b', 'b.sale_id = p.sale_id', 'left');
//	   $this->db->join('warehouses w', 'w.id = b.warehouse_id', 'left');
//	   $this->db->join('customer c', 'c.cus_id = b.customer_id', 'left');
//	   $this->db->where('sale_pymnt_paying_by !=','Cheque_Return');
	    if($ss_user_id) $this->db->join('user u', 'u.user_id = p.user_id', 'left');

		if($srh_from_date){
			
			$this->db->where("p.sale_pymnt_added_date_time >=",$srh_from_date);//("id !=",$id);
		}
		
		if($return_name == 'tot_sp'){
				   $this->db->where('sale_pymnt_paying_by !=','Cheque_Return');
			}
		
		if($return_name == 'unrealized_chq'){
			$srh_to_date=date('Y-m-d 23:59:59',strtotime($srh_to_date. ""));
			$this->db->where("p.sale_pymnt_date_time >=",$srh_to_date);//("id !=",$id);
			
			}else
		if($srh_to_date){
			
			$srh_to_date=date('Y-m-d 23:59:59',strtotime($srh_to_date. ""));
			$this->db->where("p.sale_pymnt_added_date_time <=",$srh_to_date);//("id !=",$id);
		}
		
	   if($srh_type){
	   
	   $this->db->where("p.sale_payment_type",$srh_type);//
	   }
	   if($srh_payment_term){
	   
	   $this->db->where("p.sale_pymnt_paying_by",$srh_payment_term);//
	   }
	    if($ss_user_id){
	   
	   $this->db->where("p.user_id",$ss_user_id);//
	   }
	   
	if($srh_customer_id)
		{
		$this->db->where("b.warehouse_id =".$srh_warehouse_id." AND b.customer_id=".$srh_customer_id."" );//	   
		}
		else
		
		 if($srh_warehouse_id){
	   
	   $this->db->where("b.warehouse_id",$srh_warehouse_id);//
	   
	   }else{
	 	$this->session->userdata('ss_warehouse_id');
		$warehouse_id =	$this->session->userdata('ss_warehouse_id');
		
//		echo $warehouse_id;
		$this->db->where("b.warehouse_id",$warehouse_id);
		//		echo "INN";
		}
		   
		   
	   /*
	   if($srh_to_date){
			$this->db->where("p.sale_pymnt_added_date_time <=",$srh_to_date);//("id !=",$id);
		}
		if($srh_from_date){
			$this->db->where("p.sale_pymnt_added_date_time >=",$srh_from_date);//("id !=",$id);
		}*/
//	   $this->db->order_by("b.sale_id", "desc");
	  
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
   //--
   function check_grn()
   {
	 //SELECT * FROM Table1 WHERE Table1.principal NOT IN (SELECT principal FROM table2)
	 
//	   $this->db->select('purchases.id');
//       $this->db->from('purchases');
//	   $this->db->join('purchase_items', 'purchases.id = purchase_items.purchase_id', 'left');
		//$this->db->where('purchases.id NOT IN (SELECT `purchase_id` FROM `purchase_items`)');
//	   $this->db->where('purchases.id != purchase_items.purchase_id ');
	   
	//  $query =$this->db->query('SELECT `id` FROM `purchases` WHERE `purchases`.`id` NOT IN (SELECT `purchase_id` FROM `purchase_items`)');
	  $query =$this->db->query('SELECT `purchase_id` FROM `purchase_items` WHERE `purchase_items`.`purchase_id` NOT IN (SELECT `id` FROM `purchases`)');
	
//$query = $this->db->query('SELECT id FROM purchases WHERE purchases.id NOT EXISTS IN ( purchase_items.purchase_id )');
	
//$query = $this->db->query('SELECT  l.* FROM  purchases l WHERE  l.id NOT IN( SELECT purchase_id FROM purchase_items r )');
	
	 // $query = $this->db->get();
	    echo $this->db->last_query();
     if($query->num_rows() >0)
     {
       return $query->result();
     }
     else
     {
       //return false;
     }

   }
   //--
   function getChequeForPrint($srh_warehouse_id='',$srh_to_date='',$srh_from_date='',$srh_type='',$srh_payment_term='',$ss_user_id='')
   {
	   if($srh_type =='grn'){
				$sel='p.*,b.reference_no as sale_reference_no,c.supp_company_name as cus_name';
				if($ss_user_id) $sel.=',u.user_first_name';
				$this->db->select($sel);
				$this->db->from('sale_payments p');
				$this->db->join('purchases b', 'b.id = p.sale_id', 'left');
				$this->db->join('warehouses w', 'w.id = b.warehouse_id', 'left');
				$this->db->join('supplier c', 'c.supp_id = b.supplier_id', 'left');
				$this->db->where("p.sale_pymnt_paying_by",'Cheque');
				if($ss_user_id) $this->db->join('user u', 'u.user_id = p.user_id', 'left');
				// if($srh_type){
				$this->db->where("p.sale_payment_type",$srh_type);//
				// }
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
				$this->db->order_by("p.sale_pymnt_id", "desc");
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
			else{
				$sel='p.*,c.cus_name,b.*';
				if($ss_user_id) $sel.=',u.user_first_name';
				$this->db->select($sel);
				$this->db->from('sale_payments p');
				$this->db->join('sales b', 'b.sale_id = p.sale_id', 'left');
				$this->db->join('warehouses w', 'w.id = b.warehouse_id', 'left');
				$this->db->join('customer c', 'c.cus_id = b.customer_id', 'left');
				$this->db->where("p.sale_pymnt_paying_by",'Cheque');
				if($ss_user_id) $this->db->join('user u', 'u.user_id = p.user_id', 'left');
				if($srh_type)	$this->db->where("p.sale_payment_type",$srh_type);//
				if($srh_payment_term){// $this->db->where("p.sale_pymnt_paying_by",$srh_payment_term);//
				}
				if($ss_user_id){$this->db->where("p.user_id",$ss_user_id);//
				}
				if($srh_warehouse_id){//  $this->db->where("b.warehouse_id",$srh_warehouse_id);//
				}
				if($srh_to_date){
				$this->db->where("p.sale_pymnt_added_date_time <=",$srh_to_date);//("id !=",$id);
				}
				if($srh_from_date){
				$this->db->where("p.sale_pymnt_added_date_time >=",$srh_from_date);//("id !=",$id);
				}
				$this->db->order_by("p.sale_pymnt_id", "desc");
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
}
   
    function getUnrealizedChequeForPrint($srh_warehouse_id='',$srh_to_date='',$srh_from_date='',$srh_type='',$srh_payment_term='',$ss_user_id='')
   {
	    

 if($srh_type =='grn'){
				$sel='p.*,b.reference_no as sale_reference_no,c.supp_company_name as cus_name';
				if($ss_user_id) $sel.=',u.user_first_name';
				$this->db->select($sel);
				$this->db->from('sale_payments p');
				$this->db->join('purchases b', 'b.id = p.sale_id', 'left');
				$this->db->join('warehouses w', 'w.id = b.warehouse_id', 'left');
				$this->db->join('supplier c', 'c.supp_id = b.supplier_id', 'left');
				$this->db->where("p.sale_pymnt_paying_by",'Cheque');
				if($ss_user_id) $this->db->join('user u', 'u.user_id = p.user_id', 'left');
				// if($srh_type){
				$this->db->where("p.sale_payment_type",$srh_type);//
				// }
				if($srh_payment_term){
				// $this->db->where("p.sale_pymnt_paying_by",$srh_payment_term);//
				}
				if($ss_user_id){
				$this->db->where("p.user_id",$ss_user_id);//
				}
				if($srh_from_date){
				$srh_from_date=date('Y-m-d 00:00:00',strtotime($srh_from_date. ""));
				$this->db->where("p.sale_pymnt_date_time >=",$srh_from_date);//("id !=",$id);
				}
				$this->db->order_by("p.sale_pymnt_id", "desc");
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
			else{
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
			//	   if($srh_to_date){
				//		
						//$this->db->where("p.sale_pymnt_date_time <=",$srh_to_date);//("id !=",$id);
					//}
					if($srh_from_date){
						$srh_from_date=date('Y-m-d 00:00:00',strtotime($srh_from_date. ""));
						$this->db->where("p.sale_pymnt_date_time >=",$srh_from_date);//("id !=",$id);
					}
				   $this->db->order_by("p.sale_pymnt_id", "desc");
				  
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


   }
 
    function getRetChequeForPrint($srh_warehouse_id='',$srh_to_date='',$srh_from_date='',$srh_type='',$srh_payment_term='',$ss_user_id='')
   {
	    $sel='p.*,c.cus_name,b.*';
	   if($ss_user_id) $sel.=',u.user_first_name';
	   $this->db->select($sel);
       $this->db->from('sale_payments p');
	   $this->db->join('sales b', 'b.sale_id = p.sale_id', 'left');
	   $this->db->join('warehouses w', 'w.id = b.warehouse_id', 'left');
	   $this->db->join('customer c', 'c.cus_id = b.customer_id', 'left');
	   $this->db->where("p.sale_pymnt_paying_by",'Cheque_Return');
	   
	   
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
		   	$srh_to_date=date('Y-m-d 23:59:59',strtotime($srh_to_date . ""));
			$this->db->where("p.sale_pymnt_added_date_time <=",$srh_to_date);//("id !=",$id);
		}
		if($srh_from_date){
			$this->db->where("p.sale_pymnt_added_date_time >=",$srh_from_date);//("id !=",$id);
		}
	   $this->db->order_by("p.sale_pymnt_id", "desc");
	  
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
	$this->db->where("sale_pymnt_paying_by !=","Cheque_Return");
	$query=$this->db->get();
	//echo $this->db->last_query();
	if($query->row()->sale_pymnt_amount){
		return $query->row()->sale_pymnt_amount;
	}else {
		return 0;
	}
  }
  
  public function get_purchase_info($id)
	 {
		$this->db->select('*');
		$this->db->from('purchases');
		$this->db->join('user','purchases.user = user.user_id', 'left');
		$this->db->join('user_group','user_group.user_group_id = user.group_id', 'left');
		$this->db->where("purchases.id", $id);
		$this->db->order_by("purchases.id", "desc");
		$query = $this->db->get();
		
		//print_r ($query-> result());
		return $query->row_array(); 
	 }
	 
	   public function get_purchase_info_r($id)
	 {
		
		$this->db->select('*');
		$this->db->from('purchases');
		$this->db->where("purchases.id", $id);
		$this->db->order_by("purchases.id", "desc");
		$query = $this->db->get();
		
		//print_r ($query-> result());
		return $query->row_array(); 
	 }
	 
    //Sales get information
	public function get_sale_info($id)
	 {
		$this->db->select('sales.*,user.user_first_name,user_group.user_group_name');
		$this->db->from('sales');
		$this->db->join('user','sales.user = user.user_id', 'left');
		$this->db->join('user_group','user_group.user_group_id = user.group_id', 'left');
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
		$this->db->order_by("sale_items.id", "asc");
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
	
	
	
	function get_cus_recieveble($cus_id) {
	
	$g[] ='';
	
	$column_name= '';
	$column_name= 'cus_recieveble';
	
	$this->db->select('cus_recieveble');		
	$this->db->where('cus_id',$cus_id);
    $query = $this->db->get('customer');   

	$g = $query->result();
    if($g){
	
	$u = $g[0]->$column_name;
	return $u;
	}
	else {
		return false;
		}
	}
	
	function save_cus_recieveble(&$sale_total,$cus_id)
	{
			$this->db->set('cus_recieveble',$sale_total);
			$this->db->where('cus_id', $cus_id);
			$this->db->update("customer");
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

		//$this->db->where("s.in_type != 'Contract'");

		if($srh_warehouse_id){	
			$this->db->where("s.warehouse_id",$srh_warehouse_id);//("id !=",$id);
		}
		if($srh_to_date){
			$srh_to_date=date('Y-m-d 23:59:59',strtotime($srh_to_date . ""));
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
	
	
		function get_all_sales_for_report_balance($srh_warehouse_id='',$srh_to_date='',$srh_from_date='',$sale_id='',$from='',$to='',$srh_customer_id='') {
		//echo "<br/>Test".$srh_customer_id;
		$this->db->select('s.* , c.cus_name ,SUM(p.sale_pymnt_amount) AS total_paid_amount');
		$this->db->from('sales s');
		$this->db->join('customer c', 's.customer_id = c.cus_id', 'left');
		$this->db->join('sale_payments p', 's.sale_id = p.sale_id', 'left');
		$this->db->order_by("s.sale_id", "desc");
		$this->db->group_by('s.sale_id');
		//$this->db->where("p.sale_payment_type",'sale');

		//$this->db->where("s.in_type != 'Contract'");

		if($srh_warehouse_id){	
			$this->db->where("s.warehouse_id",$srh_warehouse_id);//("id !=",$id);
		}
	/*	if($srh_to_date){
			$srh_to_date=date('Y-m-d 23:59:59',strtotime($srh_to_date . ""));
			$this->db->where("s.sale_datetime <=",$srh_to_date);
			
		}*/
		if($srh_from_date){
			$this->db->where("s.sale_datetime >=",$srh_from_date);//("id !=",$id);
		}
		
		if($srh_to_date){
			$this->db->where("s.sale_datetime <=",$srh_to_date);//("id !=",$id);
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
	
	
	function get_all_sales_for_view($srh_warehouse_id='',$srh_customer_id='') {

$query = $this->db->query('SELECT sum(sale_total) FROM sales WHERE customer_id = '.$srh_customer_id.' AND warehouse_id = '.$srh_warehouse_id.' ');


//		$query = $this->db->get();
	
	
	
		//echo $this->db->last_query();
		return $query->result_array();
	}	
	
	
	//Sales all get

	
	function get_all_sales($start='',$length='',$search_key_val='',$string='') {
		$warehouse_id ='';

		$this->db->select('sales.*, customer.cus_name');
		$this->db->from('sales');
		$this->db->join('customer', 'customer.cus_id = sales.customer_id', 'left');
		$this->db->order_by("sales.sale_id", "desc");
//		$this->db->where("sales.sale_id IS NOT NULL");

if(	$this->session->userdata('ss_group_id') != 1)
{
		$warehouse_id =	$this->session->userdata('ss_warehouse_id');
		$this->db->where("sales.warehouse_id",$warehouse_id);
//		echo "INN";
}
	//	if($search_key_val){
           // $this->db->where("customer.cus_name LIKE '%$search_key_val%' OR sales.sale_id LIKE '%$search_key_val%' OR sales.sale_reference_no LIKE '%$search_key_val%' OR sales.sale_datetime LIKE '%$search_key_val%'");
    //  	}
	
		//if($string != 'credit'){
			if($search_key_val){
            $this->db->where("sales.sale_id LIKE '%$search_key_val%' OR sales.sale_reference_no LIKE '%$search_key_val%' OR customer.cus_name LIKE '%$search_key_val%'");
       		}
		//	else
//			$this->db->where("sales.in_type != 'Credit'");
//		}
//		if($string == 'credit'){
//			if($search_key_val){
//				$this->db->where("sales.sale_id LIKE '%$search_key_val%' OR sales.sale_reference_no LIKE '%$search_key_val%' OR customer.cus_name LIKE '%$search_key_val%'");
//			}
//		}
		
		//$this->db->where("sales.in_type != 'Contract'");				
//		$this->db->where("sales.in_type","cash");		
//		$this->db->where("sales.in_type","wholesale");		
//		$this->db->where("sales.in_type","credit");	

		if($start!='' && $length!=''){
            $this->db->limit($length,$start);
        }			
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result_array();


	}

function get_all_sales_c($start='',$length='',$search_key_val='',$string='') {
		$warehouse_id ='';
		$this->db->select('COUNT(sales.sale_id) AS count_s');
		$this->db->from('customer');
		$this->db->join('sales', 'sales.customer_id = customer.cus_id', 'left');
		$this->db->order_by("sales.sale_id", "desc");
		if(	$this->session->userdata('ss_group_id') != 1)
		{
				$warehouse_id =	$this->session->userdata('ss_warehouse_id');
				$this->db->where("sales.warehouse_id",$warehouse_id);
		}
		/*if($string != 'credit'){
			if($search_key_val){
            $this->db->where("sales.in_type != 'Credit' AND sales.sale_id LIKE '%$search_key_val%' OR sales.sale_reference_no LIKE '%$search_key_val%' OR customer.cus_name LIKE '%$search_key_val%'");
       		}else
			$this->db->where("sales.in_type != 'Credit'");
		}
		if($string == 'credit'){*/
			if($search_key_val){//echo $search_key_val;
				$this->db->where("sales.sale_id LIKE '%$search_key_val%' OR sales.sale_reference_no LIKE '%$search_key_val%' OR customer.cus_name LIKE '%$search_key_val%'");
			}
		//}
		
		//$this->db->where("sales.in_type != 'Contract'");				
		if($start!='' && $length!=''){
            $this->db->limit($length,$start);
        }			
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
	function get_products_suggestions($term='') {
		
		$this->db->select('product_id,product_name,product_code,product_price,product_cost,wholesale_price,product_part_no,product_oem_part_number');
		$this->db->from('product');
	
		if($term){
			$this->db->where("product_status = '1' AND product_code LIKE '%$term%'");
			$this->db->or_where("product_status = '1' AND product_name LIKE '%$term%'");
		}
		$this->db->order_by("product_code", "asc");
		
		//$query = $this->db->query("SELECT * FROM `product` WHERE `product_status` = 1 AND `product_code` LIKE '%$term%' OR `product_name` LIKE '%$term%' LIMIT 15");
		$this->db->limit(15);
		//$query = $this->db->query("SELECT * FROM `purchase_items` WHERE `purchase_id` = $sale_id AND `product_code` LIKE '%$term%' OR `product_name` LIKE '%$term%'");
		
		//echo $this->db->last_query();
		//print_r($query->result_array());
		$query = $this->db->get();
		//print_r($this->db->last_query());
		return $query->result_array();
	}
		function get_products_suggestions_r($term,$sale_id) {
		/*
		$this->db->select('purchase_items.*,product.*');
		$this->db->from('product');
		$this->db->join('purchase_items', 'purchase_items.product_id = product.product_id', 'left');
		//$this->db->join('user_group', 'user.group_id = user_group.user_group_id', 'left');
		$this->db->order_by("sale_payments.sale_pymnt_id", "desc");
		$this->db->where("products.product_id like `%$term%`");
		$this->db->where("purchase_items.purchase_id",$sale_id);//("id !=",$id);
//		$this->db->where("sale_payments.sale_payment_type",'sale');
		$this->db->limit(0,10);
		$query = $this->db->get();	*/
		
		
//$query = $this->db->query("SELECT `purchase_id`,`product_id`,`product_code`,`product_name`,`quantity`,`unit_price` AS product_cost FROM `purchase_items` WHERE `purchase_id` = $sale_id AND `product_code` LIKE '%$term%' OR `purchase_id` = $sale_id AND `product_name` LIKE '%$term%' LIMIT 10");

$query = $this->db->query("SELECT * FROM `product` WHERE `product_code` LIKE '%$term%' OR `product_name` LIKE '%$term%' LIMIT 15");

//$query = $this->db->query("SELECT `id`,`purchase_id`,`product_id`,`product_code`,`product_name`,`quantity`,`unit_price` AS product_cost FROM `purchase_items` WHERE `purchase_id` = $sale_id AND `product_code` LIKE '%$term%' OR `purchase_id` = $sale_id AND `product_name` LIKE '%$term%' LIMIT 10");
		
		
		//$query = $this->db->query("SELECT * FROM `purchase_items` WHERE `purchase_id` = $sale_id AND `product_code` LIKE '%$term%' OR `product_name` LIKE '%$term%'");
		
		//echo $this->db->last_query();
		//print_r($query->result_array());
		//print_r($query->result());
		return $query->result();
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
	
	function get_all_sales_for_summery_report($srh_warehouse_id='',$srh_to_date='',$srh_from_date='',$sale_id='',$from='',$to='',$srh_customer_id='') {
		//echo "<br/>Test".$srh_customer_id;
		$data = array();		

		$customers ='';	
		$this->db->select('cus_id');
		$this->db->where('cus_type','normal');
		if($srh_customer_id)
		{
		$this->db->where('cus_id',$srh_customer_id);
		$customers = $this->db->get('customer');
		}else
		{
			$this->db->where('cus_id != 1');
		}
		$this->db->order_by("cus_name", "asc");
		$customers = $this->db->get('customer');
		$customers = $customers->result_array();
		
		//print_r( $customers[0]['cus_id']);
		
		$i = 0;
		foreach( $customers as $row){
			
					$nestedData=array(); 
					$this->db->select('SUM(`sale_total`) AS sale_total, customer.cus_id, customer.cus_name,customer.cus_code');
					$this->db->from('sales');
					$this->db->join('customer','customer.cus_id = sales.customer_id');
					$this->db->join('sales_return','customer.cus_id = sales_return.customer_id');
					$this->db->where('customer.cus_id',$customers[$i]['cus_id']);
					
				if($srh_warehouse_id){	
					$this->db->where("sales.warehouse_id",$srh_warehouse_id);//("id !=",$id);
				}
				
				if($srh_to_date){
					$srh_to_date = date('Y-m-d',strtotime($srh_to_date));
					$this->db->where("sales.sale_datetime <=",$srh_to_date);
			
				}
				if($srh_from_date){
					$srh_from_date = date('Y-m-d 00:00:00',strtotime($srh_from_date));
					$this->db->where("sales.sale_datetime >=",$srh_from_date);//("id !=",$id);
				}

					
					$query = $this->db->get();
		
			//		print_r($query->result_array());
					$query = $query->result_array();
					
					$nestedData['cus_id'] = $query[0]['cus_id'];
					$nestedData['sale_total'] = $query[0]['sale_total'];
					$nestedData['cus_name'] = $query[0]['cus_name'];
					$nestedData['cus_code'] = $query[0]['cus_code'];
					
					//print_r($query);
					
					$data[] = $nestedData;
			$i++;
//		return $query->result_array();
		}
		
		return $data;
	
	}	
	
	function get_all_sum_sales_for_summery_report($srh_warehouse_id='',$srh_to_date='',$srh_from_date='',$sale_id='',$from='',$to='',$srh_customer_id='') {
		
					$this->db->select('SUM(`sale_total`) AS sale_total');
					$this->db->from('sales');
//					$this->db->join('customer','customer.cus_id = sales.customer_id');
//					$this->db->join('sales_return','customer.cus_id = sales_return.customer_id');
					$this->db->where('sales.customer_id',$srh_customer_id);
					
				if($srh_warehouse_id){	
					$this->db->where("sales.warehouse_id",$srh_warehouse_id);//("id !=",$id);
				}
				
				if($srh_to_date){
					$srh_to_date = date('Y-m-d',strtotime($srh_to_date. ""));
					$this->db->where("sales.sale_datetime <=",$srh_to_date);
			
				}
				if($srh_from_date){
					$srh_from_date = date('Y-m-d 00:00:00',strtotime($srh_from_date));
					$this->db->where("sales.sale_datetime >=",$srh_from_date);//("id !=",$id);
				}

					
					$query = $this->db->get();
		
					//print_r($this->db->last_query());
					$result = $query->result_array();
					
		
		return $result;
	
	}	
	
	function test(){
		$this->db->select('supplier_id');
		$this->db->from('purchases');
		$this->db->join('supplier','supplier.supp_id = purchases.supplier_id');
		$this->db->where('SUM(total) > 0 AND supp_id = supplier_id');
$query  = $this->db->get();

		print_r($query->result_array());
		
		
		}
	
	function get_all_purchases_for_summery_report($srh_warehouse_id='',$srh_to_date='',$srh_from_date='',$sale_id='',$from='',$to='',$srh_supplier_id='') {
		
			
					$this->db->select('SUM(`grand_total`) as grand_total, supplier.supp_id, supplier.supp_company_name, supplier.supp_code ');
					$this->db->from('purchases');
					$this->db->join('supplier','supplier.supp_id = purchases.supplier_id');
					
				if($srh_warehouse_id){	
					$this->db->where("purchases.warehouse_id",$srh_warehouse_id);//("id !=",$id);
				}
				
				if($srh_to_date){
					$srh_to_date = date('Y-m-d',strtotime($srh_to_date));
					$this->db->where("purchases.date <=",$srh_to_date);
			
				}
				if($srh_from_date){
					$srh_from_date = date('Y-m-d 00:00:00',strtotime($srh_from_date));
					$this->db->where("purchases.date >=",$srh_from_date);//("id !=",$id);
				}

					
					$query = $this->db->get();
		
					//print_r($query->result_array());
					return $query->row_array();
				
			
	}	
	
	function get_all_sales_return_for_summery_report($srh_warehouse_id='',$srh_to_date='',$srh_from_date='',$sale_id='',$from='',$to='',$srh_customer_id='') {
		//echo "<br/>Test".$srh_customer_id;
		$data = array();		

	$customers ='';	
		$this->db->select('cus_id');
		$this->db->where('cus_type','normal');
		if($srh_customer_id)
		{
			$this->db->where('cus_id',$srh_customer_id);

		}
		
		$customers = $this->db->get('customer');
		
		$customers = $customers->result_array();
		
		//print_r( $customers[0]['cus_id']);
		
		$i = 0;
		foreach( $customers as $row){
			
			$nestedData=array(); 
					$this->db->select('SUM(`sl_rtn_total`) AS sale_return_total, customer.cus_id');
					$this->db->from('sales_return');
					$this->db->join('customer','customer.cus_id = sales_return.customer_id');
					$this->db->where('customer_id',$customers[$i]['cus_id']);
					
				if($srh_warehouse_id){	
					$this->db->where("sales_return.warehouse_id",$srh_warehouse_id);//("id !=",$id);
				}
				
				if($srh_to_date){
					$srh_to_date = date('Y-m-d',strtotime($srh_to_date));
					$this->db->where("sales_return.sl_rtn_datetime <=",$srh_to_date);
			
				}
				if($srh_from_date){
					$srh_from_date = date('Y-m-d 00:00:00',strtotime($srh_from_date));
					$this->db->where("sales_return.sl_rtn_datetime >=",$srh_from_date);//("id !=",$id);
				}

					
					$query = $this->db->get();
		
			//		print_r($query->result_array());
					$query = $query->result_array();
					
					$nestedData['sale_rtn_total'] = $query[0]['sale_return_total'];
					$nestedData['cus_id'] = $query[0]['cus_id'];
					
					//print_r($query);
					
					$data[] = $nestedData;
			$i++;
//		return $query->result_array();
		}
		
		return $data;
	
	}
	function get_sum_sales_return($srh_warehouse_id='',$srh_to_date='',$srh_from_date='',$sale_id='',$from='',$to='',$srh_customer_id='') {
		
				$this->db->select('SUM(`sl_rtn_total`) AS sale_return_total');
				$this->db->from('sales_return');
				$this->db->where('customer_id',$srh_customer_id);
					
				if($srh_warehouse_id){	
					$this->db->where("sales_return.warehouse_id",$srh_warehouse_id);//("id !=",$id);
				}
				
				if($srh_to_date){
					$srh_to_date=date('Y-m-d 23:59:59',strtotime($srh_to_date . ""));
					$this->db->where("sales_return.sl_rtn_datetime <=",$srh_to_date);
			
				}
				if($srh_from_date){
					$srh_from_date = date('Y-m-d 00:00:00',strtotime($srh_from_date));
					$this->db->where("sales_return.sl_rtn_datetime >=",$srh_from_date);//("id !=",$id);
				}

					
					$query = $this->db->get();
					$result= $query->row_array();
		
		return $result;
	
	}
	function get_all_purchases_return_for_summery_report($srh_warehouse_id='',$srh_to_date='',$srh_from_date='',$sale_id='',$from='',$to='',$srh_customer_id='') {
		//echo "<br/>Test".$srh_customer_id;
		$data = array();		

	$customers ='';	

		if($srh_customer_id)
		{
		$this->db->select('supp_id');
//		$this->db->where('cus_type','normal');
		$this->db->where('supp_id',$srh_customer_id);
		$customers = $this->db->get('supplier');
		}else
		{
		$this->db->select('supp_id');
//		$this->db->where('cus_type','normal');
		$customers = $this->db->get('supplier');
		}
		$customers = $customers->result_array();
		
		//print_r( $customers[0]['cus_id']);
		
		$i = 0;
		foreach( $customers as $row){
			
			$nestedData=array(); 
					$this->db->select('SUM(`grand_total`) AS sale_return_total, supplier.supp_id as cus_id');
					$this->db->from('purchases_return');
					$this->db->join('supplier','supplier.supp_id = purchases_return.supplier_id');
					$this->db->where('supplier_id',$customers[$i]['supp_id']);
					
				if($srh_warehouse_id){	
					$this->db->where("purchases_return.warehouse_id",$srh_warehouse_id);//("id !=",$id);
				}
				
				if($srh_to_date){
					$srh_to_date = date('Y-m-d',strtotime($srh_to_date));
					$this->db->where("purchases_return.date <=",$srh_to_date);
			
				}
				if($srh_from_date){
					$srh_from_date = date('Y-m-d 00:00:00',strtotime($srh_from_date));
					$this->db->where("purchases_return.date >=",$srh_from_date);//("id !=",$id);
				}

					
					$query = $this->db->get();
		
			//		print_r($query->result_array());
					$query = $query->result_array();
					
					$nestedData['sale_rtn_total'] = $query[0]['sale_return_total'];
//					$nestedData['cus_name'] = $query[0]['cus_name'];
//					$nestedData['cus_code'] = $query[0]['cus_code'];
					$nestedData['cus_id'] = $query[0]['cus_id'];
					
					//print_r($query);
					
					$data[] = $nestedData;
			$i++;
//		return $query->result_array();
		}
		
		return $data;
	
	}	

	
	function delete_sales($sale_id){
		
//		$sale_id = $this->input->get('sale_id');
		
	$query =	$this->db->query('DELETE FROM `sales` WHERE `sale_id` = '.$sale_id.'');
			//	print_r($query->result());
	$query =    $this->db->query('DELETE FROM `sale_items` WHERE `sale_id` = '.$sale_id.'');
				//print_r($query->result());
	$query =    $this->db->query('DELETE FROM `sale_payments` WHERE `sale_id` = '.$sale_id.' AND `sale_payment_type`= "sale" ');
				//print_r($query->result());
		//return $query->result_array();
		
		}
		
		function delete_sale_payments($sale_id,$in_type){
		
		$this->db->query('DELETE FROM `sale_payments` WHERE `sale_id` = '.$sale_id.' AND `sale_payment_type` = "'.$in_type.'" ');
	
		}
		
		
		function sale_pymnts_delete_by_sp_id($sp_id){
		
		$this->db->query('DELETE FROM `sale_payments` WHERE `sale_pymnt_id` = '.$sp_id.'');
	
		}
		
		function cheque_return_by_sp_id($sp_id){
		
		$this->db->query('UPDATE `sale_payments` SET `sale_pymnt_paying_by`= "Cheque_Return" WHERE `sale_pymnt_id` = '.$sp_id.'');
	
		}
		
	public function get_last_sale_date($cus_id){
		$this->db->select('MAX(sale_datetime) AS sdt');
		$this->db->where('customer_id',$cus_id);
		$query = $this->db->get('sales');
		$query = $query->row_array();
		$sdt   = $query['sdt'];
		$sdt = date('Y/m/d',strtotime($sdt));
		return $sdt;
		}
		
	function get_all_sale_items($start='',$length='',$search_key_val='') {
		$this->db->select('product.product_code,sales.sale_datetime,sales.sale_reference_no, customer.cus_name,sale_items.sale_id');
		$this->db->from('sale_items');
		$this->db->join('product','product.product_id = sale_items.product_id');
		$this->db->join('sales', 'sales.sale_id = sale_items.sale_id', 'left');
		$this->db->join('customer ','customer.cus_id = sales.customer_id');
		$this->db->order_by("sale_items.sale_id", "desc");
		//$this->db->where("sales.sale_id IS NOT NULL");//("id !=",$id);
		if($search_key_val){
			$this->db->where("sales.sale_reference_no LIKE '%$search_key_val%' OR product.product_code LIKE '%$search_key_val%' OR customer.cus_name LIKE '%$search_key_val%'");
			//$this->db->like('sales.sale_reference_no', $search_key_val);
			//$this->db->like('customer.cus_name', $search_key_val);
		}
		//$this->db->where("product_name LIKE '%$term%' OR product_code LIKE '%$term%' OR product_oem_part_number LIKE '%$term%' OR product_part_no LIKE '%$term%'");
		if($start!='' && $length!=''){
			$this->db->limit($length,$start);
		}
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result_array();
	}
	
	function get_all_sale_items_count($start='',$length='',$search_key_val='') {
		$this->db->select('COUNT(sale_items.id) AS count_s');
		$this->db->from('sale_items');
		$this->db->join('product','product.product_id = sale_items.product_id');
		$this->db->join('sales', 'sales.sale_id = sale_items.sale_id', 'left');
		$this->db->join('customer ','customer.cus_id = sales.customer_id');
		$this->db->order_by("sale_items.sale_id", "desc");
		//$this->db->where("sales.sale_id IS NOT NULL");//("id !=",$id);
		if($search_key_val){
			$this->db->where("sales.sale_reference_no LIKE '%$search_key_val%' OR product.product_code LIKE '%$search_key_val%' OR customer.cus_name LIKE '%$search_key_val%'");
			//$this->db->like('sales.sale_reference_no', $search_key_val);
			//$this->db->like('customer.cus_name', $search_key_val);
		}
		//$this->db->where("product_name LIKE '%$term%' OR product_code LIKE '%$term%' OR product_oem_part_number LIKE '%$term%' OR product_part_no LIKE '%$term%'");
		if($start!='' && $length!=''){
			$this->db->limit($length,$start);
		}
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result_array();
	}
}