<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('User_Model');
		$this->load->model('Common_Model');
	}

    var $main_menu_name = "people";
	var $sub_menu_name = "users";
	private $table = 'user';

	public function index()
	{
		$data['main_menu_name'] = $this->main_menu_name;
		$data['sub_menu_name'] = $this->sub_menu_name;
		$this->load->view('users',$data);
		
		
	}

	public function create_user()
	{
		$data['main_menu_name'] = $this->main_menu_name;
		$data['sub_menu_name'] = 'create_user';
		
        if (isset($_GET['cus_id'])) {
			$cus_id=$_GET['cus_id'];
		}
		else {
			$cus_id='';
		}
		if($cus_id){
			$data['cus_id']=$cus_id;
			$data['type']='E';
			$data['pageName']='UPDATE USER';
			$data['btnText']='Update User';
			$data['user']= $this->Customer_Model->get_user_info($cus_id);	
		}
		else {
			$data['cus_id']='';
			$data['type']='A';
			$data['pageName']='ADD USER';
			$data['btnText']='Add User';
			$data['user']=array();
		}
		$data['country_list'] = $this->Common_Model->get_all_country();
        $this->load->view('models/create_user',$data);
	}
}