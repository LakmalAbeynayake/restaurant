<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Notifications extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('User_Model');
		$this->load->model('Common_Model');
		$this->load->model('User_Group_Model');
		
	}



    var $main_menu_name = "notifications";

	var $sub_menu_name = "notifications";



	public function index()

	{

		$data['main_menu_name'] = $this->main_menu_name;

		$data['sub_menu_name'] = $this->sub_menu_name;

        $this->load->view('notifications',$data);

	}







}