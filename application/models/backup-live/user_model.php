<?php
class User_Model extends CI_Model {
	 private $tableName = 'user';
  
  
  function __construct() 
  {
   		/* Call the Model constructor */
    	parent::__construct();
        $this->load->database();
        $this->load->helper('url');
        $this->load->library(array('email'));
  }
  
	/*
	Attempts to login employee and set session. Returns boolean based on outcome.
	*/
	function login($user_username, $user_password)
	{
		$paa = hash('sha512', $user_password); 
		$this->db->select('user.*');
		$this->db->from('user');
		$this->db->where("user_username",$user_username);
		$this->db->where("user_password",$paa);
		$query = $this->db->get();
		//echo $this->db->last_query();
		if ($query->num_rows()==1)
		{
			$row=$query->row();
			$newdata = array(
			'user_id'  => $row->user_id
			);
			return $row->user_id;
		}
		return false;
	}
	
  public function get_all_user_activitie_for_report($srh_warehouse_id,$srh_to_date,$srh_from_date,$from='',$to='')
  {
     $this->db->select("l.*,u.*");
     $this->db->from("logs l");
     $this->db->join("user u", "u.user_id = l.user_id", "left"); 
	 $this->db->join("warehouses w", "w.id = l.warehouse_id", "left");
	if($srh_warehouse_id){
			$this->db->where("l.warehouse_id",$srh_warehouse_id);//("id !=",$id);
	}
	if($srh_to_date){
		$this->db->where("l.datetime <=",$srh_to_date);//("id !=",$id);
	}
	if($srh_from_date){
		$this->db->where("l.datetime >=",$srh_from_date);//("id !=",$id);
	}
	if($to){
		$this->db->limit($to,$from);
		}	
     $this->db->group_by("l.id");
     $this->db->order_by("l.id", "desc");
     $query = $this->db->get();  
    // echo $this->db->last_query();
     return $query->result_array();
  }

	public function add_user()
	{
		$data=array(
			'user_first_name'=>$this->input->post('user_first_name'),
			'user_last_name'=>$this->input->post('user_last_name'),
			'user_username'=>$this->input->post('user_username')
			);
		$this->db->insert('user',$data);
	}
	
   function create_user_sessions($sesdata){
		 $this->session->set_userdata($sesdata);
			   
   }
   
   function delete_user_sessions($sesdata){
	   //$array_items = array('username', 'email');
		 $this->session->unset_userdata($sesdata);
			   
   }
	
   function getUsers()
   {
	   $this->db->select('u.* , ug.user_group_name');
       $this->db->from('user u');
	   $this->db->join('user_group ug', 'u.group_id = ug.user_group_id', 'left');   
	   $this->db->order_by("u.user_id", "desc");
	   $query = $this->db->get();
	   
     if($query->num_rows() >0)
     {
       return $query->result();
     }
     else
     {
       return false;
     }

   }
	
	function save_user(&$user_data,$user_id=false)
	{
		if (!$user_id)
		{
			$val=$this->db->insert($this->tableName,$user_data);
			if($val) return TRUE;
			else return FALSE;
		}else {
			$this->db->where('user_id', $user_id);
			return $this->db->update($this->tableName,$user_data);
			echo $this->db->last_query();
			exit();
			//return TRUE;
		}
	}
	
	public function get_user_info($id)
	 {
	   $this->db->select('u.* , g.user_group_name');
       $this->db->from('user u');
	   $this->db->join('user_group g', 'u.group_id = g.user_group_id', 'left');  
	   $this->db->where('u.user_id', $id); 
	   $this->db->order_by("u.user_id", "desc");
	   $query = $this->db->get();
	   return $query->row_array();
		 
		 /*
		$this->db->select('*');
		$this->db->from($this->tableName);
		$this->db->where("user_id", $id);
		$this->db->order_by("user_id", "desc");
		$query = $this->db->get();
		
		return $query->row_array(); */
	 }
	 

	public function delete_user($user_id)
	{
		$this->db->where('user_id', $user_id);
		$this->db->delete('user');
	
	}

	public function disable_user($user_id)
	{
		$data = array(
			'user_status' => 0
		);	
		$this->db->where('user_id', $user_id);
		$this->db->update('user', $data);
	}
	
	public function enable_user($user_id)
	{
		$data = array(
			'user_status' => 1
		);	
		$this->db->where('user_id', $user_id);
		$this->db->update('user', $data);
	}
}