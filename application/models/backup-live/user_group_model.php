<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_Group_Model extends CI_Model {
  
  private $tableName = 'user_group';
  
  function __construct() 
  {
    /* Call the Model constructor */
    parent::__construct();
  }

	
	
	function get_all_user_group() {
		$this->db->select($this->tableName.'.*');
		$this->db->order_by("user_group_id", "desc");
		$this->db->where("user_group_status", 1);//("id !=",$id);
		$query = $this->db->get($this->tableName);
		return $query->result_array();
	}
	
	public function get_user_group_info_by_id($id)
	 {
		$this->db->select('*');
		$this->db->from('user_group');
		$this->db->where("user_group_id", $id);
		$this->db->order_by("user_group_id", "desc");
		$query = $this->db->get();
		
		return $query->row_array(); 
	 }
	 
	public function is_avalable_for_use_this_link_for_user($group_id ,$page)
	 {
		$this->db->select('user_group_permission.usrgp_permission_view');
		$this->db->from('user_group_permission');
		$array = array('user_group_id' => $group_id, 'usrgp_permission_page' => $page);
		$this->db->where($array); 
		$this->db->order_by("user_group_id", "desc");
		$query = $this->db->get();
		return $query->row_array(); 
	 }
	
	function get_all_user_group_list() {
		$this->db->select($this->tableName.'.*');
		$this->db->order_by("user_group_id", "desc");
		$this->db->where("user_group_status", 1);//("id !=",$id);
		$query = $this->db->get($this->tableName);
		return $query->result();
	}	
	
	function get_all_user_group_permission_page_list() {
	   $this->db->select('upp.* , ugp.usrgp_permission_view , ugp.usrgp_permission_add , ugp.usrgp_permission_edit , ugp.usrgp_permission_delete');
       $this->db->from('user_group_permission_page upp');
	   $this->db->join('user_group_permission ugp', 'upp.user_group_permission_page_name = ugp.usrgp_permission_page', 'left'); 
	   // $this->db->join('user_group ug', 'ugp.user_group_id = ug.user_group_id', 'left');  
	   $this->db->order_by("upp.user_group_permission_page_name", "asc");
	   $query = $this->db->get();
       if($query->num_rows() >0){
           return $query->result_array();
       } else {
       		return false;
       }
	}
	
	function get_all_user_group_permission_list_by_group_id($group_id) {
		$this->db->select('*');
		$this->db->order_by("user_group_id", "desc");
		$this->db->where("user_group_id", $group_id);//("id !=",$id);
		$query = $this->db->get('user_group_permission');
		return $query->result_array();
	   
	}
	
	function get_user_group_permission_page_list_by_group_id($group_id) {
	   $this->db->select('upp.* , ugp.usrgp_permission_view , ugp.usrgp_permission_add , ugp.usrgp_permission_edit , ugp.usrgp_permission_delete');
       $this->db->from('user_group_permission_page upp');
	   $this->db->join('user_group_permission ugp', 'upp.user_group_permission_page_name = ugp.usrgp_permission_page', 'left');
	   $this->db->where('ugp.user_group_id', $group_id);   
	   $this->db->order_by("upp.user_group_permission_page_name", "asc");
	   $query = $this->db->get();
       if($query->num_rows() >0){
           return $query->result_array();
       } else {
       		return false;
       }
	}
	
	
	
	function change_user_group_permission_details_view_by_page(&$per_data,$page=false,$user_group_id){
		$array = array('usrgp_permission_page' => $page, 'user_group_id' => $user_group_id);
		$this->db->where($array); 
		//$this->db->where('usrgp_permission_page', $page);
		$this->db->update('user_group_permission',$per_data);
		//echo $this->db->last_query();
	}
}