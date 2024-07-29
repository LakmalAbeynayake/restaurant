<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Transfer_Model extends CI_Model {
  
  private $tableName = 'transfer';
  
  function __construct() 
  {
    /* Call the Model constructor */
    parent::__construct();
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
  
  function getwarehousename($wid){
	$this->db->select('warehouses.name');
	$this->db->from('warehouses');
	$this->db->where("id", $wid);
	$this->db->order_by("id", "desc");
	$query = $this->db->get();
	//echo $this->db->last_query();
	return $query->row_array(); 
  }
  
  //Sales genarate referance number
  function get_next_ref_no(){
	  $this->db->select_max('trnsfr_id');
	  return $this->db->get('transfer');
  }
 
  //Sales get avalable product qty
  function get_avalable_product_qty($product_id,$warehouse_id){
		$this->db->select_sum('fi_qty');
		$query = $this->db->get('fi_table');
		return $query->row()->fi_qty;
  }
  

  
    //Sales get information
	public function get_trnsfr_info($id)
	 {
		$this->db->select('*');
		$this->db->from('transfer');
		$this->db->where("trnsfr_id", $id);
		$this->db->order_by("trnsfr_id", "desc");
		$query = $this->db->get();
		return $query->row_array(); 
	 }
	 
	//Sales item list get by id 
	public function get_trnsfr_item_list_by_trnsfr_id($trnsfr_id)
	 {
		$this->db->select('transfer_item.trnsfr_itm_unit_price,transfer_item.product_id, product.product_name, product.product_code, transfer_item.trnsfr_itm_quantity, product.product_part_no,product.product_oem_part_number');
		$this->db->from('transfer_item');
		$this->db->join('product', 'transfer_item.product_id = product.product_id', 'left');
		$this->db->order_by("transfer_item.trnsfr_itm_id", "desc");
		$this->db->where("transfer_item.trnsfr_id", $trnsfr_id);//("id !=",$id);
		$query = $this->db->get();
		return $query->result_array();
		
	 }

	//Sales save
	function save_transfer(&$supplier_data,$trnsfr_id=false)
	{
		if (!$trnsfr_id)
		{
			$this->db->insert($this->tableName,$supplier_data);
		}else {
			$this->db->where('trnsfr_id', $trnsfr_id);
			return $this->db->update($this->tableName,$supplier_data);
		}
	}	
	
	//Sales item save
	function save_transfer_item(&$data_item)
	{
			$this->db->insert('transfer_item',$data_item);
	}	

	//Sales get for report
	function get_all_transfer_for_report($srh_warehouse_id='',$srh_to_date='',$srh_from_date='',$trnsfr_id='',$from='',$to='') {
		$this->db->select('s.* , c.cus_name');
		$this->db->from('transfer s');
		$this->db->join('customer c', 's.customer_id = c.cus_id', 'left');
		
		$this->db->order_by("s.trnsfr_id", "desc");
		$this->db->group_by('s.trnsfr_id');
		if($srh_warehouse_id){
			$this->db->where("s.warehouse_id",$srh_warehouse_id);//("id !=",$id);
		}
		if($srh_to_date){
			$this->db->where("s.trnsfr_datetime <=",$srh_to_date);//("id !=",$id);
		}
		if($srh_from_date){
			$this->db->where("s.trnsfr_datetime >=",$srh_from_date);//("id !=",$id);
		}
		if($trnsfr_id){
			$this->db->where("s.trnsfr_id =",$trnsfr_id);//("id !=",$id);
		}
		if($to){
		$this->db->limit($to,$from);
		}
		$query = $this->db->get();
		return $query->result_array();
	}	
	
	//Sales all get
	function get_all_transfer() {
		$this->db->select('t.*, w.name');
		$this->db->from('transfer t');
		$this->db->join('warehouses w', 't.trnsfr_from_warehouse_id = w.id', 'left');
		$this->db->order_by("t.trnsfr_id", "desc");
		$this->db->where("t.trnsfr_id IS NOT NULL");//("id !=",$id);
		$query = $this->db->get();
		return $query->result_array();
	}
	
	//Sales get for print
	function get_all_transfer_for_print_transfer() {
		$this->db->select('s.* , c.cus_name ');
		$this->db->from('transfer s');
		$this->db->join('customer c', 's.customer_id = c.cus_id', 'left');
	
		$this->db->order_by("s.trnsfr_id", "desc");
		$this->db->group_by('s.trnsfr_id');
		$this->db->where("s.trnsfr_id IS NOT NULL");//("id !=",$id);
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