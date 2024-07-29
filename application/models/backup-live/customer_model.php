<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Customer_Model extends CI_Model {
  
  private $tableName = 'customer';
  
  function __construct() 
  {
    /* Call the Model constructor */
    parent::__construct();
  }
 
 	function save_customer(&$customer_data,$cus_id=false)
	{
		if (!$cus_id)
		{
			$this->db->insert($this->tableName,$customer_data);
		}else {
			$this->db->where('cus_id', $cus_id);
			return $this->db->update($this->tableName,$customer_data);
		}
	}
	
	function get_all_customers() {
		$this->db->select($this->tableName.'.*');
		$this->db->order_by("cus_id", "asc");
		$this->db->where("cus_status",1);//("id !=",$id);
		//$this->db->where("cus_id", $id);
		$query = $this->db->get($this->tableName);
		return $query->result_array();
	}
	
	
	function get_all_customer() {
		$this->db->select('customer.*, mstr_country.country_short_name');
		$this->db->from('mstr_country');
		$this->db->join('customer', 'customer.country_id = mstr_country.country_id', 'left');
		$this->db->order_by("customer.cus_id", "desc");
		$this->db->where("customer.cus_status IS NOT NULL");//("id !=",$id);
		$query = $this->db->get();
		return $query->result_array();
	}
	
	public function get_customer_info($id)
	 {
		$this->db->select('*');
		$this->db->from('customer');
		$this->db->where("cus_id", $id);
		$this->db->order_by("cus_id", "desc");
		$query = $this->db->get();
		
		return $query->row_array(); 
	 }
	
	public function delete_customer($cus_id)
	{
		$this->db->where('cus_id', $cus_id);
		$this->db->delete('customer');
	
	}

	public function disable_customer($cus_id)
	{
		$data = array(
			'cus_status' => 0
		);	
		$this->db->where('cus_id', $cus_id);
		$this->db->update('customer', $data);
	}
	
	public function enable_customer($cus_id)
	{
		$data = array(
			'cus_status' => 1
		);	
		$this->db->where('cus_id', $cus_id);
		$this->db->update('customer', $data);
	}	

}