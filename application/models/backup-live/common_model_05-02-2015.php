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

     public function add_fi_table($type,$ref_id,$product,$quantity,$unit_cost)
   {
    $data = array(
       'fi_type_id'  => $type,
       'fi_ref_id'   => $ref_id,
       'fi_item_id'  => $product,
       'fi_qty'      => $quantity,
       'fi_cost'     => $unit_cost
    );

    if($this->db->insert('fi_table', $data)){
      return $this->db->insert_id();
    }else{
      return false;
    }

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


   //User Activitie
   public function add_user_activitie($details)
   {
    $data = array(
       'details'   => $details,
	    'page'  => base_url(uri_string()),
       'user_id'  =>  $this->session->userdata('ss_user_id'),
       'warehouse_id'  => $this->session->userdata('ss_warehouse_id'),
       'datetime'     => date("Y-m-d H:i:s"),
	   'ip'     => $this->input->ip_address()
    );

    if($this->db->insert('logs', $data)){
      return $this->db->insert_id();
    }else{
      return false;
    }

   }
}