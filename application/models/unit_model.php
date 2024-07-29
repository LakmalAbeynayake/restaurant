<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Unit_Model extends CI_Model {
  
  private $tableName = 'mstr_unit';
  
  function __construct() 
  {
    /* Call the Model constructor */
    parent::__construct();
  }

	function save_unit(&$unit_data,$unit_id=false)
	{
		if (!$unit_id)
		{
			$this->db->insert($this->tableName,$unit_data);
		}else {
			$this->db->where('unit_id', $unit_id);
			return $this->db->update($this->tableName,$unit_data);
		}
	}	
	
	function get_all_unit() {
		$this->db->select($this->tableName.'.*');
		$this->db->order_by("unit_id", "desc");
		$this->db->where("unit_id IS NOT NULL");//("id !=",$id);
		$query = $this->db->get($this->tableName);
		return $query->result_array();
	}
	
	public function get_unit_info($id)
	 {
		$this->db->select('*');
		$this->db->from($this->tableName);
		$this->db->where("unit_id", $id);
		$this->db->order_by("unit_id", "desc");
		$query = $this->db->get();
		
		return $query->row_array(); 
	 }
	
	public function delete_unit($unit_id)
	{
		$this->db->where('unit_id', $unit_id);
		$this->db->delete($this->tableName);
	
	}

	public function disable_unit($unit_id)
	{
		$data = array(
			'unit_status' => 0
		);	
		$this->db->where('unit_id', $unit_id);
		$this->db->update($this->tableName, $data);
	}
	
	public function enable_unit($unit_id)
	{
		$data = array(
			'unit_status' => 1
		);	
		$this->db->where('unit_id', $unit_id);
		$this->db->update($this->tableName, $data);
	}
}