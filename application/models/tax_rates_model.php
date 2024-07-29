<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tax_Rates_Model extends CI_Model {
  
  private $tableName = 'tax_rates';
  
  function __construct() 
  {
    /* Call the Model constructor */
    parent::__construct();
  }

	
	function get_all_tax_rates() {
		$this->db->select($this->tableName.'.*');
		$this->db->order_by("id", "asc");
		$this->db->where("id IS NOT NULL");//("id !=",$id);
		$query = $this->db->get($this->tableName);
		return $query->result_array();
	}
	
}