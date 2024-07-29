<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Location_Model extends CI_Model {
  
  private $tableName = 'mstr_location';
  
  function __construct() 
  {
    /* Call the Model constructor */
    parent::__construct();
  }

	function save_location(&$location_data,$location_id=false)
	{
		if (!$location_id)
		{
			$this->db->insert($this->tableName,$location_data);
		}else {
			$this->db->where('location_id', $location_id);
			return $this->db->update($this->tableName,$location_data);
		}
	}	
	
	function get_all_location() {
		$this->db->select($this->tableName.'.*');
		$this->db->order_by("location_id", "desc");
		$this->db->where("location_id IS NOT NULL");//("id !=",$id);
		$query = $this->db->get($this->tableName);
		return $query->result_array();
	}
	
	public function get_location_info($id)
	 {
		$this->db->select('*');
		$this->db->from($this->tableName);
		$this->db->where("location_id", $id);
		$this->db->order_by("location_id", "desc");
		$query = $this->db->get();
		
		return $query->row_array(); 
	 }
	
	public function delete_location($location_id)
	{
		$this->db->where('location_id', $location_id);
		$this->db->delete($this->tableName);
	
	}

	public function disable_location($location_id)
	{
		$data = array(
			'location_status' => 0
		);	
		$this->db->where('location_id', $location_id);
		$this->db->update($this->tableName, $data);
	}
	
	public function enable_location($location_id)
	{
		$data = array(
			'location_status' => 1
		);	
		$this->db->where('location_id', $location_id);
		$this->db->update($this->tableName, $data);
	}
}