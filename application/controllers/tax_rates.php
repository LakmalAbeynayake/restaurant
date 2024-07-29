<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tax_Rates extends CI_Controller {

    var $main_menu_name = "settings";
	var $sub_menu_name = "tax_rates";

	public function index()
	{
		$data['main_menu_name'] = $this->main_menu_name;
		$data['sub_menu_name'] = $this->sub_menu_name;
        $this->load->view('tax_rates',$data);
	}

	public function add_tax_rates()
	{
        $data['id'] = 1;
        $this->load->view('models/create_tax_rates',$data);
	}


}