<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Common extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		//$this->load->model('Common');
		$this->load->model('Common_Model');
	}
	
	public function index()
	{	
	
		$this->load->view('common_panel');

	}
	
	public function get_all_country(){
		$data['country_list'] = $this->Cupplier_Model->get_all_country();
	}

	public function get_all_status(){
		$data['status_list'] = $this->Common_Model->get_all_status();
	}	



}