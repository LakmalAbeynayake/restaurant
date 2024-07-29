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
	function get_search_customer($str) {
        $this->db->select('cus_id,cus_warehouse_id,country_id,cus_code,city_id,city_name,cus_name,cus_email,cus_phone,cus_address,cus_state,cus_postal_code,cus_status');
        $this->db->from('customer c');
        $this->db->order_by("c.cus_name", "asc");
        $this->db->or_like('c.cus_name',$str);
		$this->db->or_like('c.cus_phone',$str);
		$this->db->or_like('c.cus_address',$str);
		
		//$this->db->or_like('c.cus_code',$str);
		//$this->db->or_like('c.cus_m_phone',$str);
		//$this->db->or_like('c.cus_phone',$str);
        //$this->db->or_like('c.cus_nic',$str);
       // $this->db->or_like('user_group_name',$str);
	    if($str)
	        $this->db->LIMIT(10);
	    
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
	
	
	function get_cus_phone() {
		$this->db->select('cus_phone');
		$this->db->order_by("cus_phone", "asc");
		$this->db->where("cus_status",1);//("id !=",$id);
		//$this->db->where("cus_id", $id);
		$query = $this->db->get($this->tableName);
		return $query->result_array();
	}
	
	
	function get_all_customer($cus_type=0) {
		$this->db->select('customer.*, mstr_country.country_short_name');
		$this->db->from('mstr_country');
		$this->db->join('customer', 'customer.country_id = mstr_country.country_id', 'left');
		$this->db->order_by("customer.cus_id", "desc");
		$this->db->where("customer.cus_status IS NOT NULL");//("id !=",$id);
		if($cus_type)
		    $this->db->where("customer.cus_type_id",$cus_type);//("id !=",$id);
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
	 public function get_customer_info_by_phone($cus_phone)
	 {
		$this->db->select('*');
		$this->db->from('customer');
		$this->db->where("cus_phone", $cus_phone);
		$this->db->order_by("cus_phone", "desc");
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
	function login($user_username, $user_password)
	{
		//echo $user_password;
		//echo $user_username;
				
		$paa = hash('sha512', $user_password);
		//echo $paa;
		$this->db->select('*');
		$this->db->from('customer');
		$this->db->where("cus_phone",$user_username);
		$this->db->where("cus_password",$paa);
		$query = $this->db->get();
		//echo $this->db->last_query();
		if ($query->num_rows()==1)
		{
			$row=$query->row();
			$newdata = array(
			'cus_id'  => $row->cus_id
			);
			return $row->cus_id;
		}
		return false;
	}	
	
	function create_cus_sessions($sesdata)
    {
		//print_r($sesdata);
        $this->session->set_userdata($sesdata);
    }
    function search_customer_by_phone($id)
	 {
		$this->db->select('*');
		$this->db->from('customer');
		$this->db->where("cus_status",1);
        $this->db->like('cus_phone',$id);
		$this->db->order_by("cus_phone", "asc");
		
	    $this->db->LIMIT(5);
		$query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
	 }
	 function validate_customer_by_phone($phone,$name=""){
	     $cus_id = 1;
	     $phone = $this->format_phone($phone);
	     if($phone){
	        $this->db->select('*');
    		 $this->db->from('customer');
    		 $this->db->where("cus_phone",$phone);
    		 $query = $this->db->get();
    		 if ($query->num_rows() > 0) {
    		     $result = $query->row();
    		     $cus_id = $result->cus_id;
    		     $cus_name = $result->cus_name;
    		     if($cus_name == ""){
                    if($name != ""){
                        $cus_data = array(
                            'cus_phone'=>$phone,
                            //'cus_code'=> $phone,
                            'cus_name'=>$name,
                            'cus_type_id'   => 1
                        );
                        $this->save_customer($cus_data,$cus_id);
                    }
    		     }
             }else{
                $cus_data = array(
                    'cus_phone'=>$phone,
                    'cus_code'=> $phone,
                    'cus_name'=>$name,
                    'cus_type_id'   => 1
                );
                $this->save_customer($cus_data);
                $cus_id=$this->db->insert_id();
             }
	     }
	     return $cus_id;
	 }
	 function format_phone($phone)
    {
        $rv = "";
        $filtered_phone_number = filter_var($phone, FILTER_SANITIZE_NUMBER_INT);
        $phone_to_check = str_replace("-", "", $filtered_phone_number);
        $phone_to_check = intval($phone_to_check);
        if(strlen($phone_to_check) < 9 || strlen($phone_to_check) > 12){
            $rv = "";
        }else{
            $rv = substr($phone_to_check, -9);
        }
        return $rv;
    }
    
    
    	function get_all_cus_type() {
		$this->db->select('*');
		$query = $this->db->get('master_customer_type');
		return $query->result_array();
	}
}