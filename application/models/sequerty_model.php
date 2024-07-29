<?php
 
class Sequerty_Model extends CI_Model {
  
  
  function __construct() 
  {
    /* Call the Model constructor */
    parent::__construct();
	
	/*if(!($this->session->userdata('ss_user_id'))){
			redirect(base_url(),'refresh');		
			exit();
	}*/
  }
 
}