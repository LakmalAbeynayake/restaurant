<?php
 
class User_Model extends CI_Model {
  
  
  function __construct() 
  {
    /* Call the Model constructor */
    parent::__construct();
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

}