<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Country extends CI_Controller {

    var $main_menu_name = "people";
	var $sub_menu_name = "suppliers";

    public function __construct()
    {
        parent::__construct();
        $this->load->model('country_model');
    }
	
	public function index()
	{
		$data['main_menu_name'] = $this->main_menu_name;
		$data['sub_menu_name'] = $this->sub_menu_name;
		$this->load->view('suppliers',$data);
	}

	public function get_all_country()
	{
        $data['id'] = 1;
		$data['main_menu_name'] = $this->main_menu_name;
		$data['sub_menu_name'] = 'create_supplier';
		
        $data['all_country'] = $this->country_model->get_all_country();
		
	}
	

}