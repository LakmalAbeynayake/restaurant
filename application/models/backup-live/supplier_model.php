<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Supplier_Model extends CI_Model {
  
  private $tableName = 'supplier';
  
  function __construct() 
  {
    /* Call the Model constructor */
    parent::__construct();
  }

	function save_supplier(&$supplier_data,$supp_id=false)
	{
		if (!$supp_id)
		{
			$this->db->insert($this->tableName,$supplier_data);
		}else {
			$this->db->where('supp_id', $supp_id);
			return $this->db->update($this->tableName,$supplier_data);
		}
	}	
	
	function get_all_supplier() {
		$this->db->select('s.*, c.country_short_name, t.cname');
		$this->db->from('supplier s');
		$this->db->join('mstr_country c', 's.country_id = c.country_id', 'left');
		$this->db->join('mstr_city t', 's.supp_city = t.cid', 'left');
		$this->db->order_by("s.supp_id", "desc");
		$this->db->where("s.supp_status IS NOT NULL");//("id !=",$id);
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result_array();
	}
	
    /*	
	function get_all_supplier() {
		$this->db->select('supplier.*, mstr_country.country_short_name');
		$this->db->from('mstr_country');
		$this->db->join('supplier', 'supplier.country_id = mstr_country.country_id', 'left');
		$this->db->order_by("supplier.supp_id", "desc");
		$this->db->where("supplier.supp_status IS NOT NULL");
		$query = $this->db->get();
		return $query->result_array();
	}
	*/
	
	public function get_supplier_info($id)
	 {
		$this->db->select('*');
		$this->db->from('supplier');
		$this->db->where("supp_id", $id);
		$this->db->order_by("supp_id", "desc");
		$query = $this->db->get();
		
		return $query->row_array(); 
	 }
	
	public function delete_supplier($supp_id)
	{
		$this->db->where('supp_id', $supp_id);
		$this->db->delete('supplier');
	
	}

	public function disable_supplier($supp_id)
	{
		$data = array(
			'supp_status' => 0
		);	
		$this->db->where('supp_id', $supp_id);
		$this->db->update('supplier', $data);
	}
	
	public function enable_supplier($supp_id)
	{
		$data = array(
			'supp_status' => 1
		);	
		$this->db->where('supp_id', $supp_id);
		$this->db->update('supplier', $data);
	}
}