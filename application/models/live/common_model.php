<?php

 

class Common_Model extends CI_Model {

  

  

  function __construct() 

  {

    /* Call the Model constructor */

    parent::__construct();

  }

  

  function get_all_country() {

		$this->db->select('country_id, country_short_name');

		$this->db->order_by("country_short_name", "asc");

		$this->db->where("country_status", "1");

		$query = $this->db->get('mstr_country');

		return $query->result_array();

  }

  

  function get_all_status() {

		$this->db->select('mstr_status.*');

		$this->db->order_by("status_order", "desc");

		$this->db->where("status_staus", "1");

		$query = $this->db->get('mstr_status');

		return $query->result_array();

  }

  

  function get_all_cr_limit() {

		$this->db->select('cr_limit_id, cr_limit_name');

		$this->db->order_by("cr_limit_status", "asc");

		$this->db->where("cr_limit_status", "1");

		$query = $this->db->get('mstr_cr_limit');

		return $query->result();

  }

  

  public function get_country_name_by_id($country_id) {

		$this->db->select('country_short_name');

		$this->db->order_by("country_short_name", "asc");

		$this->db->where("country_id", $country_id);

		$query = $this->db->get('mstr_country');

		return $query->result_array();

   }

   public function gen_ref_number($column_name,$table_name,$type_code)
   {
	$this->db->select_max($column_name);
	$query = $this->db->get($table_name);
     if($query->num_rows() >0)
     {
       $g = $query->result();
       $u = $this->set_ref_no($g[0]->id,$type_code);
       return $u;
     }
     else
     {
       return false;
     }
   }

   function set_ref_no($f,$t)
   {
   	 $d = date('Y/m/');
   	 $w = $t.'/'.$d.sprintf("%05d",$f+1);
   	 return $w;
   }



}