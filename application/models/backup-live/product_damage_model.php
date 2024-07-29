<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Product_Damage_Model extends CI_Model {
  
  private $tableName = 'product_damage';
  
  function __construct() 
  {
    /* Call the Model constructor */
    parent::__construct();
  }
  
   //Product_Damage best for dashboard
   function getBestProduct_Damage($year=null,$month=0,$from=0,$to=0){
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
  
  function getwarehousename($wid){
	$this->db->select('warehouses.name');
	$this->db->from('warehouses');
	$this->db->where("id", $wid);
	$this->db->order_by("id", "desc");
	$query = $this->db->get();
	//echo $this->db->last_query();
	return $query->row_array(); 
  }
  
  //Product_Damage genarate referance number
  function get_next_ref_no(){
	  $this->db->select_max('pdmg_id');
	  return $this->db->get('product_damage');
  }
 
  //Product_Damage get avalable product qty
  function get_avalable_product_qty($product_id,$warehouse_id){
		$this->db->select_sum('fi_qty');
		$query = $this->db->get('fi_table');
		return $query->row()->fi_qty;
  }
  

  
    //Product_Damage get information
	public function get_product_damage_info($id)
	 {
		$this->db->select('*');
		$this->db->from('product_damage');
		$this->db->where("pdmg_id", $id);
		$this->db->order_by("pdmg_id", "desc");
		$query = $this->db->get();
		return $query->row_array(); 
	 }
	 
	//Product_Damage item list get by id 
	public function get_product_damage_item_list_by_product_damage_id($pdmg_id)
	 {
		$this->db->select('product_damage_item.pdmgitm_unit_cost,product_damage_item.product_id, product.product_name, product.product_code, product_damage_item.pdmgitm_quantity, product.product_part_no,product.product_oem_part_number');
		$this->db->from('product_damage_item');
		$this->db->join('product', 'product_damage_item.product_id = product.product_id', 'left');
		$this->db->order_by("product_damage_item.pdmgitm_id", "desc");
		$this->db->where("product_damage_item.pdmg_id", $pdmg_id);//("id !=",$id);
		$query = $this->db->get();
		return $query->result_array();
		
	 }

	//Product_Damage save
	function save_product_damage(&$supplier_data,$pdmg_id=false)
	{
		if (!$pdmg_id)
		{
			$this->db->insert($this->tableName,$supplier_data);
		}else {
			$this->db->where('pdmg_id', $pdmg_id);
			return $this->db->update($this->tableName,$supplier_data);
		}
	}	
	
	//Product_Damage item save
	function save_product_damage_item(&$data_item)
	{
			$this->db->insert('product_damage_item',$data_item);
	}	

	//Product_Damage get for report
	function get_all_product_damage_for_report($srh_warehouse_id='',$srh_to_date='',$srh_from_date='',$pdmg_id='',$from='',$to='') {
		$this->db->select('s.* , c.cus_name');
		$this->db->from('product_damage s');
		$this->db->join('customer c', 's.customer_id = c.cus_id', 'left');
		
		$this->db->order_by("s.pdmg_id", "desc");
		$this->db->group_by('s.pdmg_id');
		if($srh_warehouse_id){
			$this->db->where("s.warehouse_id",$srh_warehouse_id);//("id !=",$id);
		}
		if($srh_to_date){
			$this->db->where("s.pdmg_datetime <=",$srh_to_date);//("id !=",$id);
		}
		if($srh_from_date){
			$this->db->where("s.pdmg_datetime >=",$srh_from_date);//("id !=",$id);
		}
		if($pdmg_id){
			$this->db->where("s.pdmg_id =",$pdmg_id);//("id !=",$id);
		}
		if($to){
		$this->db->limit($to,$from);
		}
		$query = $this->db->get();
		return $query->result_array();
	}	
	
	//Product_Damage all get
	function get_all_product_damage() {
		$this->db->select('t.*, w.name');
		$this->db->from('product_damage t');
		$this->db->join('warehouses w', 't.warehouse_id = w.id', 'left');
		$this->db->order_by("t.pdmg_id", "desc");
		$this->db->where("t.pdmg_id IS NOT NULL");//("id !=",$id);
		$query = $this->db->get();
		return $query->result_array();
	}
	
	//Product_Damage get for print
	function get_all_product_damage_for_print_product_damage() {
		$this->db->select('s.* , c.cus_name ');
		$this->db->from('product_damage s');
		$this->db->join('customer c', 's.customer_id = c.cus_id', 'left');
	
		$this->db->order_by("s.pdmg_id", "desc");
		$this->db->group_by('s.pdmg_id');
		$this->db->where("s.pdmg_id IS NOT NULL");//("id !=",$id);
		$query = $this->db->get();
		return $query->result_array();
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