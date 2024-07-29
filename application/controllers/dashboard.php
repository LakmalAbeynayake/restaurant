<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Dashboard extends CI_Controller {

	var $main_menu_name = "dashboard";

	var $sub_menu_name = "dashboard";

 	function __construct() 

  	{

   		 /* Call the Model constructor */

   		parent::__construct();

		$this->load->model('Sales_Model');

		$this->load->model('Common_Model');

 	}

  



	

	public function index()

	{				

		$data['main_menu_name'] = $this->main_menu_name;

		$data['sub_menu_name'] = $this->sub_menu_name;

		

		$this->load->model('Purchases_Model');

		

		$data['current_month_best_sales']= array();//$this->Sales_Model->getBestSales(date("Y"),date("m"),0,5);

		$data['last_month_best_sales']= array();//$this->Sales_Model->getBestSales(date("Y",strtotime("-1 month")),date("m",strtotime("-1 month")),0,10);

		$data['last_2_month_best_sales']= array();//$this->Sales_Model->getBestSales(date("Y",strtotime("-2 month")),date("m",strtotime("-2 month")),0,10);

		

		

		//$data['last_5_sales_list'] = $this->Sales_Model->get_all_sales_for_report('','','','','0','5');

		//$data['last_5_grn_list'] = $this->Purchases_Model->get_all_grn_for_report('','','','','0','5');

		

		

		$this->load->view('dashboard',$data);

	}



}