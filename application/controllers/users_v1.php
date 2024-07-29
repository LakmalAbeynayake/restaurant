<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('user_model');
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
		//$this->load->view('create_user',$data);
		
		//create user
		$this->load->library('form_validation');
		// field name, error message, validation rules
		$this->form_validation->set_rules('user_first_name', 'First Name', 'trim|required|min_length[4]|xss_clean');
		$this->form_validation->set_rules('user_last_name', 'Last Name', 'trim|required|min_length[2]|xss_clean');
		//$this->form_validation->set_rules('user_last_name', 'Second Name', 'trim|required|valid_email');
		//$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[4]|max_length[32]');
		//$this->form_validation->set_rules('con_password', 'Password Confirmation', 'trim|required|matches[password]');

		if($this->form_validation->run() == FALSE)
		{
			$this->load->view('create_user',$data);
		}
		else
		{
			$this->user_model->add_user();
			$this->load->view('users',$data);
			//$this->load->view('users/create_user',$data);
			
		}
	}
	
	

}