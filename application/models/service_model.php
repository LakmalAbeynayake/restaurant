<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Service_Model extends CI_Model {
  
  private $tableName = 'service';
  
  function __construct() 
  {
    /* Call the Model constructor */
    parent::__construct();
  }
  
  public function get_purchese_order_data_by_id($service_id='')
  {
     $this->db->select('*');
     $this->db->from('service_items i');
     $this->db->where('i.service_id',$service_id);
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
	  $this->db->select_max('service_id');
	  return $this->db->get('service');
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
		$this->db->from('service r');
		$this->db->join('warehouses w', 'w.id = r.warehouse_id', 'left');
		$this->db->where("r.service_id", $id);
		$this->db->order_by("r.service_id", "desc");
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result(); 
	 }

    //Sales get information
	public function get_service_items_by_id($service_id)
	 {
		$this->db->select('ri.*, u.unit_name');
		$this->db->from('service_items ri');
		 $this->db->join('mstr_unit u','ri.product_unit = u.unit_id','left');
		$this->db->where("ri.service_id", $service_id);
		$this->db->order_by("ri.service_id", "desc");
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result(); 
	 }
	 
	     //Sales get information
	public function get_service_details_by_id($service_id)
	 {
		$this->db->select('r.*,w.*');
		$this->db->from('service r');
		$this->db->join('warehouses w', 'w.id = r.warehouse_id', 'left');
		$this->db->where("r.service_id", $service_id);
		$this->db->order_by("r.service_id", "desc");
		$query = $this->db->get();  
		//echo $this->db->last_query();
		return $query->row();
	 }
	 	 
	 
	 
	//Sales item list get by id 
	public function get_po_item_list_by_service_id($service_id)
	 {
		$this->db->select('service_items.product_id, product.product_name, product.product_code, service_items.quantity, service_items.discount, service_items.discount_val, service_items.unit_price, service_items.gross_total,product.product_part_no,product.product_oem_part_number');
		$this->db->from('service_items');
		$this->db->join('product', 'service_items.product_id = product.product_id', 'left');
		$this->db->order_by("service_items.id", "desc");
		$this->db->where("service_items.service_id", $service_id);//("id !=",$id);
		$query = $this->db->get();
		return $query->result_array();
		
	 }

	//Sales save
	function save_service(&$supplier_data,$service_id=false)
	{
		if (!$service_id)
		{
			$this->db->insert($this->tableName,$supplier_data);
		}else {
			$this->db->where('service_id', $service_id);
			return $this->db->update($this->tableName,$supplier_data);
		}
	}	
	
	//Sales item save
	function save_service_item(&$data_item)
	{
			$this->db->insert('service_items',$data_item);
	}	

	//Sales get for report
	function get_all_service_for_report($srh_warehouse_id='',$srh_to_date='',$srh_from_date='',$service_id='',$from='',$to='') {
		$this->db->select('s.* , c.cus_name');
		$this->db->from('service s');
		$this->db->join('customer c', 's.customer_id = c.cus_id', 'left');
		
		$this->db->order_by("s.service_id", "desc");
		$this->db->group_by('s.service_id');
		if($srh_warehouse_id){
			$this->db->where("s.warehouse_id",$srh_warehouse_id);//("id !=",$id);
		}
		if($srh_to_date){
			$this->db->where("s.po_datetime <=",$srh_to_date);//("id !=",$id);
		}
		if($srh_from_date){
			$this->db->where("s.po_datetime >=",$srh_from_date);//("id !=",$id);
		}
		if($service_id){
			$this->db->where("s.service_id =",$service_id);//("id !=",$id);
		}
		if($to){
		$this->db->limit($to,$from);
		}
		$query = $this->db->get();
		return $query->result_array();
	}	
	
	//Sales all get
/*	function get_all_service() {
		$this->db->select('o.*,w.*,r.service_reference_no');
		$this->db->from('service o');
		$this->db->join('warehouses w', 'w.id = o.warehouse_id', 'left');
		$this->db->join('service r', 'r.service_id = o.service_id', 'left');
		$this->db->order_by("o.service_id", "desc");
		$this->db->where("o.service_id IS NOT NULL");//("id !=",$id);
		$query = $this->db->get();
		return $query->result_array();
	}*/
	
	  	function get_all_service() {
		$this->db->select('o.*,w.*,s.supp_company_name');
		$this->db->from('service o');
		$this->db->join('warehouses w', 'w.id = o.warehouse_id', 'left');
		$this->db->join('supplier s', 's.supp_id = o.service_customer_id', 'left');
		$this->db->order_by("o.service_id", "desc");
		$this->db->where("o.service_id IS NOT NULL");//("id !=",$id);
		$query = $this->db->get();
		return $query->result_array();
	}
	
	function get_all_services_for_grn() {
		$this->db->select('o.*,w.*,r.service_reference_no');
		$this->db->from('service o');
		$this->db->join('warehouses w', 'w.id = o.warehouse_id', 'left');
		$this->db->join('service r', 'r.service_id = o.service_id', 'left');
		$this->db->order_by("o.service_id", "desc");
		$this->db->where("o.service_id IS NOT NULL");//("id !=",$id);
		$query = $this->db->get();
		return $query->result();
	}
	
	//Sales get for print
	function get_all_service_for_print_service() {
		$this->db->select('s.* , c.cus_name ');
		$this->db->from('service s');
		$this->db->join('customer c', 's.customer_id = c.cus_id', 'left');
	
		$this->db->order_by("s.service_id", "desc");
		$this->db->group_by('s.service_id');
		$this->db->where("s.service_id IS NOT NULL");//("id !=",$id);
		$query = $this->db->get();
		return $query->result_array();
	}
	
	public function delete_old_service_items($service_id)
	{
		$this->db->where('service_id', $service_id);
		$this->db->delete('service_items');
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