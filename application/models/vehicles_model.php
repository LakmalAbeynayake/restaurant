<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Vehicles_Model extends CI_Model {
  
  private $tableName = 'vehicles';
  
  function __construct() 
  {
    /* Call the Model constructor */
    parent::__construct();
  }
 
 	function save_vehicle(&$vehicle_data,$vh_id=false)
	{
		if (!$vh_id)
		{
			$this->db->insert($this->tableName,$vehicle_data);
		}else {
			$this->db->where('veh_id', $vh_id);
			return $this->db->update($this->tableName,$vehicle_data);
		}
	}
	
	function get_all_vehicles() {
		$this->db->select($this->tableName.'.*');
		$this->db->order_by("veh_id", "asc");
		$this->db->where("veh_status",1);//("id !=",$id);
		//$this->db->where("vh_id", $id);
		$query = $this->db->get($this->tableName);
		return $query->result_array();
	}
	
	public function get_vehicle_info($id)
	 {
		$this->db->select('*');
		$this->db->from('vehicle');
		$this->db->where("vh_id", $id);
		$this->db->order_by("vh_id", "desc");
		$query = $this->db->get();
		
		return $query->row_array(); 
	 }
	
	public function delete_vehicle($vh_id)
	{
		$this->db->where('vh_id', $vh_id);
		$this->db->delete('vehicle');
	
	}

	public function disable_vehicle($vh_id)
	{
		$data = array(
			'cus_status' => 0
		);	
		$this->db->where('vh_id', $vh_id);
		$this->db->update('vehicle', $data);
	}
	
	public function enable_vehicle($vh_id)
	{
		$data = array(
			'cus_status' => 1
		);	
		$this->db->where('vh_id', $vh_id);
		$this->db->update('vehicle', $data);
	}	
	
}