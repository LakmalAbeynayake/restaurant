<?php
 
class Country_Model extends CI_Model {
  
  
  function __construct() 
  {
    /* Call the Model constructor */
    parent::__construct();
  }

	public function get_all_country()
	{
		$query = $this->db->query('SELECT  country_id, country_long_name FROM mstr_country');
        return $this->db->query($query)->result();
	}

}