<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Expenses_Model extends CI_Model {
  
  private $tableName = 'expenses';
  
  function __construct() 
  {
    /* Call the Model constructor */
    parent::__construct();
  }
  
  public function get_purchese_order_data_by_id($exp_id='')
  {
     $this->db->select('*');
     $this->db->from('expenses_items i');
     $this->db->where('i.exp_id',$exp_id);
     $query = $this->db->get();
     if($query->num_rows() >0)
     {
       return $query->result();
     }
     else
     {
       return false;
     }
  }
  
  
  
   //Sales get for report
	function get_all_expenses_items_for_report($srh_warehouse_id='',$srh_to_date='',$srh_from_date='',$srh_type='',$srh_payment_term='',$ss_user_id='')
   {
	   $sel='i.*,un.*,e.*,s.supp_company_name';
	   if($ss_user_id) $sel.=',u.*';
	   $this->db->select($sel);
       $this->db->from('expenses_items i');
	   $this->db->join('expenses e', 'e.exp_id = i.exp_id', 'left');
	   $this->db->join('warehouses w', 'w.id = e.warehouse_id', 'left');
	   $this->db->join('mstr_unit un', 'un.unit_id = i.product_unit', 'left');
	   $this->db->join('supplier s', 's.supp_id = e.supp_id', 'left');
	    if($ss_user_id) $this->db->join('user u', 'u.user_id = e.user_id', 'left');
	
		
	   if($srh_type){
	   
	   //$this->db->where("p.sale_payment_type",$srh_type);//
	   }
	   if($srh_payment_term){
	   
	   //$this->db->where("p.sale_pymnt_paying_by",$srh_payment_term);//
	   }
	   if($srh_warehouse_id){
	   
	  // $this->db->where("e.warehouse_id",$srh_warehouse_id);//
	   }
	     if($ss_user_id){
	   
	   $this->db->where("e.user_id",$ss_user_id);//
	   }
	   if($srh_to_date){
			$this->db->where("e.exp_datetime <=",$srh_to_date);//("id !=",$id);
		}
		if($srh_from_date){
			$this->db->where("e.exp_datetime >=",$srh_from_date);//("id !=",$id);
		}
	   //$this->db->order_by("b.sale_id", "desc");
	  
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

  //Sales get for report
	function get_all_petty_cash_for_report($srh_warehouse_id='',$srh_to_date='',$srh_from_date='',$supp_id='') {
		$this->db->select('e.*');
		$this->db->from('expenses e');
		//$this->db->join('customer c', 's.customer_id = c.cus_id', 'left');
		//$this->db->join('sale_payments p', 's.sale_id = p.sale_id', 'left');
		//$this->db->join('sales_return sr', 'sr.sale_id = p.sale_id', 'left');
		$this->db->order_by("e.exp_id", "desc");
		//$this->db->group_by('s.sale_id');
		if($srh_warehouse_id){
			$this->db->where("e.warehouse_id",$srh_warehouse_id);//("id !=",$id);
		}
		if($srh_to_date){
			$this->db->where("e.exp_datetime <=",$srh_to_date);//("id !=",$id);
		}
		if($srh_from_date){
			$this->db->where("e.exp_datetime >=",$srh_from_date);//("id !=",$id);
		}
		if($supp_id){
			$this->db->where("s.supp_id =",$supp_id);//("id !=",$id);
		}
		
		$query = $this->db->get();
		return $query->result_array();
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
	  $this->db->select_max('exp_id');
	  return $this->db->get('expenses');
  }
 
  //Sales get avalable product qty
  function get_avalable_product_qty($product_id,$warehouse_id){
		$this->db->select_sum('fi_qty');
		$query = $this->db->get('fi_table');
		return $query->row()->fi_qty;
  }
  

  
    //Sales get information
	public function get_po_info($id)
	 {
		$this->db->select('r.*,w.*');
		$this->db->from('expenses r');
		$this->db->join('warehouses w', 'w.id = r.warehouse_id', 'left');
		$this->db->where("r.exp_id", $id);
		$this->db->order_by("r.exp_id", "desc");
		$query = $this->db->get();
		echo $this->db->last_query();
		return $query->result(); 
	 }

    //Sales get information
	public function get_expenses_items_by_id($exp_id)
	 {
		$this->db->select('ri.*, u.unit_name');
		$this->db->from('expenses_items ri');
		 $this->db->join('mstr_unit u','ri.product_unit = u.unit_id','left');
		$this->db->where("ri.exp_id", $exp_id);
		$this->db->order_by("ri.exp_id", "desc");
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result(); 
	 }
	 
	     //Sales get information
	public function get_expenses_details_by_id($exp_id)
	 {
		$this->db->select('r.*,w.*');
		$this->db->from('expenses r');
		$this->db->join('warehouses w', 'w.id = r.warehouse_id', 'left');
		$this->db->where("r.exp_id", $exp_id);
		$this->db->order_by("r.exp_id", "desc");
		$query = $this->db->get();  
		//echo $this->db->last_query();
		return $query->row();
	 }
	 	 
	 
	 
	//Sales item list get by id 
	public function get_po_item_list_by_exp_id($exp_id)
	 {
		$this->db->select('expenses_items.product_id, product.product_name, product.product_code, expenses_items.quantity, expenses_items.discount, expenses_items.discount_val, expenses_items.unit_price, expenses_items.gross_total,product.product_part_no,product.product_oem_part_number');
		$this->db->from('expenses_items');
		$this->db->join('product', 'expenses_items.product_id = product.product_id', 'left');
		$this->db->order_by("expenses_items.id", "desc");
		$this->db->where("expenses_items.exp_id", $exp_id);//("id !=",$id);
		$query = $this->db->get();
		return $query->result_array();
		
	 }

	//Sales save
	function save_expenses(&$supplier_data,$exp_id=false)
	{
		if (!$exp_id)
		{
			$this->db->insert($this->tableName,$supplier_data);
		}else {
			$this->db->where('exp_id', $exp_id);
			return $this->db->update($this->tableName,$supplier_data);
		}
	}	
	
	//Sales item save
	function save_expenses_item(&$data_item)
	{
			$this->db->insert('expenses_items',$data_item);
	}	

	//Sales get for report
	function get_all_expenses_for_report($srh_warehouse_id='',$srh_to_date='',$srh_from_date='',$exp_id='',$from='',$to='') {
		$this->db->select('s.* , c.cus_name');
		$this->db->from('expenses s');
		$this->db->join('customer c', 's.customer_id = c.cus_id', 'left');
		
		$this->db->order_by("s.exp_id", "desc");
		$this->db->group_by('s.exp_id');
		if($srh_warehouse_id){
			$this->db->where("s.warehouse_id",$srh_warehouse_id);//("id !=",$id);
		}
		if($srh_to_date){
			$this->db->where("s.po_datetime <=",$srh_to_date);//("id !=",$id);
		}
		if($srh_from_date){
			$this->db->where("s.po_datetime >=",$srh_from_date);//("id !=",$id);
		}
		if($exp_id){
			$this->db->where("s.exp_id =",$exp_id);//("id !=",$id);
		}
		if($to){
		$this->db->limit($to,$from);
		}
		$query = $this->db->get();
		return $query->result_array();
	}	
	
	//Sales all get
	function get_all_expenses() {
		$this->db->select('o.*,w.*,c.cat_name,s.supp_company_name');
		$this->db->from('expenses o');
		$this->db->join('warehouses w', 'w.id = o.warehouse_id', 'left');
		$this->db->join('product_category c', 'c.cat_id = o.cat_id', 'left');
		$this->db->join('supplier s', 's.supp_id = o.supp_id', 'left');
		
		$this->db->order_by("o.exp_id", "desc");
		$this->db->where("o.exp_id IS NOT NULL");//("id !=",$id);
		$query = $this->db->get();
		return $query->result_array();
	}
	
	//Sales get for print
	function get_all_expenses_for_print_expenses() {
		$this->db->select('s.* , c.cus_name ');
		$this->db->from('expenses s');
		$this->db->join('customer c', 's.customer_id = c.cus_id', 'left');
	
		$this->db->order_by("s.exp_id", "desc");
		$this->db->group_by('s.exp_id');
		$this->db->where("s.exp_id IS NOT NULL");//("id !=",$id);
		$query = $this->db->get();
		return $query->result_array();
	}
	
	public function delete_old_expenses_items($exp_id)
	{
		$this->db->where('exp_id', $exp_id);
		$this->db->delete('expenses_items');
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
	
	
}