<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sales_Return_Model extends CI_Model {
  
    private $tableName = 'sales_return';
  
	function __construct() 
	{
		/* Call the Model constructor */
		parent::__construct();
	}
  
  
    //Sales get toatal paid 
  function get_total_return_by_sale_id($sale_id){
	$this->db->select_sum('sp.sale_pymnt_amount');
	$this->db->from('sale_payments sp');
	$this->db->join('sales_return sr', 'sr.sl_rtn_id = sp.sale_id', 'left');
	$this->db->where("sp.sale_payment_type",'sales_return');
	$this->db->where("sr.sale_id",$sale_id);
	$query=$this->db->get();
	//echo $this->db->last_query();
	if($query->row()->sale_pymnt_amount){
		return $query->row()->sale_pymnt_amount;
	}else {
		return 0;
	}
  }
    //Sales return get info by id
	public function get_sale_return_info($id)
	 {
		$this->db->select('sr.*, SUM(sp.sale_pymnt_amount) AS sls_rtn_total_paid');
		$this->db->from('sales_return sr');
		$this->db->join("sale_payments sp", "sr.sl_rtn_id = sp.sale_id AND sp.sale_payment_type ='sales_return'", "left");
		$this->db->where("sr.sl_rtn_id", $id);
		$this->db->order_by("sr.sl_rtn_id", "desc");
		$this->db->group_by("sr.sl_rtn_id");
		$query = $this->db->get();
		return $query->row_array(); 
	 } 
	 
	public function get_return_sale_info_sale_id($id)
	 {
		$this->db->select('*');
		$this->db->from('sales_return');
		$this->db->where("sale_id", $id);
		$this->db->order_by("sale_id", "desc");
		$query = $this->db->get();
		return $query->result(); 
	 }
	 
  	//getSalesReturnQtyByWarehouseId
	public function getSalesReturnQtyByWarehouseId($warehouse_id,$product_id)
	{
		$this->db->select_sum('sri.quantity');
		$this->db->from('sales_return_items sri');
		$this->db->join('sales_return sr', 'sr.sl_rtn_id = sri.sl_rtn_id', 'left');
		$this->db->where('sr.warehouse_id',$warehouse_id);
		$this->db->where('sri.product_id',$product_id);
		$query=$this->db->get();
		return $data['quantity']=$query->row()->quantity;
	}

	//Sales return get item list
	public function get_sale_return_item_list($sl_rtn_id)
	 {
		$this->db->select('s.*, p.product_name, p.product_code, s.quantity, ,p.product_part_no,p.product_oem_part_number');
		$this->db->from('sales_return_items s');
		$this->db->join('product p', 's.product_id = p.product_id', 'left');
		$this->db->order_by("s.id", "desc");
		$this->db->where("s.sl_rtn_id", $sl_rtn_id);//("id !=",$id);
		$query = $this->db->get();
		return $query->result_array();
	 }
	 
	//Sales return get avalable qty
	function get_avalable_product_qty_for_return($product_id,$warehouse_id,$sale_id){
		$this->db->select_sum('fi.fi_qty');
		$this->db->where("fi.fi_type_id", 'sale');
		$this->db->where("fi.fi_item_id", $product_id);
		$this->db->where("fi.fi_ref_id", $sale_id);
		$query = $this->db->get('fi_table fi');
		//echo $this->db->last_query();
		return $query->row()->fi_qty;
	}
	
	//Sales return get get product qty
	function get_sales_return_product_qty($product_id,$warehouse_id,$sale_id){
		$this->db->select_sum('i.quantity');
		$this->db->from('sales_return r');
		$this->db->join('sales_return_items i', "i.sl_rtn_id = r.sl_rtn_id AND i.product_id='$product_id'", 'left');
		$this->db->where("r.warehouse_id", $warehouse_id);
		$this->db->where("r.sale_id", $sale_id);
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->row()->quantity;
	}
  
    //Sales return get all sales
	function get_all_sales_return() {
		$this->db->select('sr.*, c.cus_name, s.sale_reference_no, SUM(sp.sale_pymnt_amount) AS sls_rtn_total_paid');
		$this->db->from('sales_return sr');
		$this->db->join('customer c', 'sr.customer_id = c.cus_id', 'left');
		$this->db->join('sales s', 's.sale_id = sr.sale_id', 'left');
		$this->db->join("sale_payments sp", "sr.sl_rtn_id = sp.sale_id AND sp.sale_payment_type ='sales_return'", "left");
		$this->db->group_by("sr.sl_rtn_id");		
		$this->db->order_by("sr.sl_rtn_id", "desc");
		$query = $this->db->get();
		return $query->result_array();
	}

	//Sales return save sales return
	function save_sales_return(&$sl_trn_data,$sl_trn_id=false)
	{
		if (!$sl_trn_id)
		{
			$this->db->insert($this->tableName,$sl_trn_data);
		}
	}	
	
	//Sales return save items
	function save_sales_return_item(&$data_item)
	{
			$this->db->insert('sales_return_items',$data_item);
	}	
	
}