<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Backups extends CI_Controller {

    var $main_menu_name = "settings";
	var $sub_menu_name = "backups";

	public function index()
	{
		$data['main_menu_name'] = $this->main_menu_name;
		$data['sub_menu_name'] = $this->sub_menu_name;
		$this->load->view('backups',$data);
	}

}