
<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Restaurants extends CI_Controller
{
    
    var $main_menu_name = "dashboard";
    var $sub_menu_name = "dashboard";
        
    public function __construct()
    {
        parent::__construct();
        $this->load->model('pos_model');
        $this->load->model('Common_Model');
        date_default_timezone_set("Asia/Colombo");
    }
    public function index()
    {
        $data['main_menu_name'] = $this->main_menu_name;
	$data['sub_menu_name'] = $this->sub_menu_name;
        
        $this->load->view('restaurant/dashboard' , $data);
    }
    public function setting(){
        $data['main_menu_name'] = 'setting';
	$data['sub_menu_name'] = 'setting';
        
        $this->load->view('restaurant/setting' , $data);
    }
    
}
