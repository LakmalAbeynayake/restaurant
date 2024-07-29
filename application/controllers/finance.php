<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Finance extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Salary_model');
        $this->load->model('Salary_type_model');
        $this->load->model('User_model');
        $this->load->model('Common_Model');
		$this->load->model('Warehouse_Model');
		 $this->load->model('Salary_payment_model');
		 $this->load->model('Transactions_Model');
		 $this->load->model('Sales_Model');
		  $this->load->model('finance_model');
		    $this->load->model('Issue_Cards_Model');
			 $this->load->model('category_models');
			  $this->load->model('purchases_model');
			   $this->load->model('Report_Model');
		 
		
		
    }

    var $main_menu_name = 'finance';
    var $sub_menu_name = 'finance';

    public function index_del() {
        $data['main_menu_name'] = $this->main_menu_name;
        $data['sub_menu_name'] = $this->sub_menu_name;
		 $data['warehouse_list'] = $this->Warehouse_Model->get_all_warehouse();
        $this->load->view("salary", $data);
    }
	
	public function cash_book()
	{
		$data['main_menu_name'] = $this->main_menu_name;
    	$data['sub_menu_name'] = 'cash_book';
		$data['fixed_assets_master_list']=array();//$this->Transactions_Model->get_fixed_assets_master_list();	
		$data['warehouse_list'] = $this->Warehouse_Model->get_all_warehouse();
		$data['srh_from_date'] = $this->input->post('srh_from_date');
		$data['srh_to_date'] =$this->input->post('srh_to_date');
		$data['srh_warehouse_id'] =$this->input->post('srh_warehouse_id');
		
		//echo "srh_warehouse_id :".$data['srh_warehouse_id'];
		$this->load->view('cash_book',$data);
	}
	
	
		public function cash_book_02()
	{
		$data['main_menu_name'] = $this->main_menu_name;
    	$data['sub_menu_name'] = 'cash_book_02';
		$data['fixed_assets_master_list']=array();//$this->Transactions_Model->get_fixed_assets_master_list();	
		$data['warehouse_list'] = $this->Warehouse_Model->get_all_warehouse();
		$data['srh_from_date'] = $this->input->post('srh_from_date');
		$data['srh_to_date'] =$this->input->post('srh_to_date');
		$data['srh_warehouse_id'] =$this->input->post('srh_warehouse_id');
		$data['mstr_expences_type_list'] = $this->finance_model->get_mstr_expences_type_list();
		$data['main_category_list'] 	= $this->category_models->getCategory();
		$data['supplier_list'] = $this->purchases_model->get_supplier();
		
		
		//echo "srh_warehouse_id :".$data['srh_warehouse_id'];
		$this->load->view('cash_book_02',$data);
	}
	
	public function cashier_summary()
	{
		$data['main_menu_name'] = $this->main_menu_name;
    	$data['sub_menu_name'] = 'cashier_summary';
		$data['fixed_assets_master_list']=array();//$this->Transactions_Model->get_fixed_assets_master_list();	
		$data['warehouse_list'] = $this->Warehouse_Model->get_all_warehouse();
		$data['srh_from_date'] = $this->input->post('srh_from_date');
		$data['srh_to_date'] =$this->input->post('srh_to_date');
		$data['srh_warehouse_id'] =$this->input->post('srh_warehouse_id');
		$data['mstr_expences_type_list'] = $this->finance_model->get_mstr_expences_type_list();
		$data['main_category_list'] 	= $this->category_models->getCategory();
		$data['supplier_list'] = $this->purchases_model->get_supplier();
		$data['user_list'] = $this->User_model->getUsers();
		
		
		//echo "srh_warehouse_id :".$data['srh_warehouse_id'];
	//	$this->load->view('cashier_summary',$data);
		
			$this->load->view('cashier_sum',$data);
	}
	
	
	
	
	 public function cash_book_get_grn_payments() {
		 $error=0;
		 $disMsg=0;
		 $grn_payment_val=0;
		 $srh_from_date = $this->input->get('srh_from_date');
		$srh_to_date =$this->input->get('srh_to_date');
		$srh_warehouse_id = $this->input->get('srh_warehouse_id');
		$supp_id=$this->input->get('supp_id');
		 $grn_payment_val= floatval($this->finance_model->get_grn_payments_by_date_range($srh_from_date,$srh_to_date,$srh_warehouse_id,$supp_id));
		 
         echo json_encode(array('error'=>"$error",'disMsg'=>$disMsg,'grn_payment_val'=>$grn_payment_val));
    }
	
	 public function cash_book_get_cash_sale_payments() {
		 $error=0;
		 $disMsg=0;
		 $grn_payment_val=0;
		 $srh_from_date = $this->input->get('srh_from_date');
		$srh_to_date =$this->input->get('srh_to_date');
		$cat_id =$this->input->get('cat_id');
		$srh_warehouse_id = $this->input->get('srh_warehouse_id');
		 $cash_sales_payment= $this->finance_model->get_cash_sales_payment_by_date_range($srh_from_date,$srh_to_date,$srh_warehouse_id,$cat_id);
		 
         echo json_encode(array('error'=>"$error",'disMsg'=>$disMsg,'cash_sales_payment'=>$cash_sales_payment));
    }
	
	 public function cash_book_get_cash_user_payments() {
		 $error=0;
		 $disMsg=0;
		 $grn_payment_val=0;
		 $srh_from_date = $this->input->get('srh_from_date');
		$srh_to_date =$this->input->get('srh_to_date');
		$user_id =$this->input->get('user_id');
		$srh_warehouse_id = $this->input->get('srh_warehouse_id');
		 $cash_sales_payment= $this->finance_model->get_cash_sales_payment_by_date_range_cash($srh_from_date,$srh_to_date,$srh_warehouse_id,$user_id);
		 
         echo json_encode(array('error'=>"$error",'disMsg'=>$disMsg,'cash_sales_payment'=>$cash_sales_payment));
    }
	
	public function cash_book_get_cash_advance_payment() {
		 $error=0;
		 $disMsg=0;
		 $grn_payment_val=0;
		 $srh_from_date = $this->input->get('srh_from_date');
		$srh_to_date =$this->input->get('srh_to_date');
		$srh_warehouse_id = $this->input->get('srh_warehouse_id');
		 $advance_payment= $this->finance_model->get_advance_payment_by_date_range($srh_from_date,$srh_to_date,$srh_warehouse_id);
		 
         echo json_encode(array('error'=>"$error",'disMsg'=>$disMsg,'advance_payment'=>$advance_payment));
    }
	
	public function cash_book_get_downpayments_payment() {
		 $error=0;
		 $disMsg=0;
		 $grn_payment_val=0;
		 $srh_from_date = $this->input->get('srh_from_date');
		$srh_to_date =$this->input->get('srh_to_date');
		$srh_warehouse_id = $this->input->get('srh_warehouse_id');
		 $downpayments_payment= $this->finance_model->get_downpayments_payment_by_date_range($srh_from_date,$srh_to_date,$srh_warehouse_id);
		 
         echo json_encode(array('error'=>"$error",'disMsg'=>$disMsg,'downpayments_payment'=>$downpayments_payment));
    }
    
    
    public function cash_book_get_cash_sale_payments_cost() {
		 $error=0;
		 $disMsg=0;
		 $grn_payment_val=0;
		 $srh_from_date = $this->input->get('srh_from_date');
		$srh_to_date =$this->input->get('srh_to_date');
		$cat_id =$this->input->get('cat_id');
		$srh_warehouse_id = $this->input->get('srh_warehouse_id');
		 $item_des= $this->finance_model->get_cash_sales_payment_by_date_range_cost($srh_from_date,$srh_to_date,$srh_warehouse_id,$cat_id);
		 
		 
		 
		 $tot_cost=0;
		  $qty=0;
		 $unit_cost=0;
		
		 	foreach ($item_des as $row)
		{
		     $qty=$row->quantity;
		     $unit_cost=$row->item_cost;
		     $tot_cost=$tot_cost+($qty*$unit_cost);
		}
		 
		 
		 
		 
         echo json_encode(array('error'=>"$error",'disMsg'=>$disMsg,'cash_sales_payment'=>$tot_cost));
    }
	

	
	
	
	public function cash_book_get_installments_payment() {
		 $error=0;
		 $disMsg=0;
		 $grn_payment_val=0;
		 $srh_from_date = $this->input->get('srh_from_date');
		$srh_to_date =$this->input->get('srh_to_date');
		$srh_warehouse_id = $this->input->get('srh_warehouse_id');
		 $installments_payment= $this->finance_model->cash_book_get_installments_payment($srh_from_date,$srh_to_date,$srh_warehouse_id);
		 
         echo json_encode(array('error'=>"$error",'disMsg'=>$disMsg,'installments_payment'=>$installments_payment));
    }
	
	public function cash_book_get_visiting_charges_payment() {
		 $error=0;
		 $disMsg=0;
		 $grn_payment_val=0;
		 $srh_from_date = $this->input->get('srh_from_date');
		$srh_to_date =$this->input->get('srh_to_date');
		$srh_warehouse_id = $this->input->get('srh_warehouse_id');
		 $visiting_charges_payment= $this->finance_model->cash_book_get_visiting_charges_payment($srh_from_date,$srh_to_date,$srh_warehouse_id);
		 
         echo json_encode(array('error'=>"$error",'disMsg'=>$disMsg,'visiting_charges_payment'=>$visiting_charges_payment));
    }
	
	public function cash_book_get_rep_expences_payments() {
		 $error=0;
		 $disMsg=0;
		 $grn_payment_val=0;
		 $srh_from_date = $this->input->get('srh_from_date');
		$srh_to_date =$this->input->get('srh_to_date');
		$srh_warehouse_id = $this->input->get('srh_warehouse_id');
		 $rep_expences_payments= $this->finance_model->cash_book_get_rep_expences_payments($srh_from_date,$srh_to_date,$srh_warehouse_id);
		// echo "rep_expences_payments:$rep_expences_payments";
		//  $rep_expences_payments=0;
         echo json_encode(array('error'=>"$error",'disMsg'=>$disMsg,'rep_expences_payments'=>$rep_expences_payments));
    }
	
	public function cash_book_get_cash_expences_payments() {
		 $error=0;
		 $disMsg=0;
		 $grn_payment_val=0;
		 $srh_from_date = $this->input->get('srh_from_date');
		$srh_to_date =$this->input->get('srh_to_date');
		$srh_warehouse_id = $this->input->get('srh_warehouse_id');
		 $cash_expences_payments= $this->finance_model->cash_book_get_cash_expences_payments($srh_from_date,$srh_to_date,$srh_warehouse_id);
		// echo "rep_expences_payments:$rep_expences_payments";
		//  $rep_expences_payments=0;
         echo json_encode(array('error'=>"$error",'disMsg'=>$disMsg,'cash_expences_payments'=>$cash_expences_payments));
    }
	
	
		public function cash_book_get_owner_withdrawls_payments() {
		 $error=0;
		 $disMsg=0;
		 $grn_payment_val=0;
		 $srh_from_date = $this->input->get('srh_from_date');
		$srh_to_date =$this->input->get('srh_to_date');
		$srh_warehouse_id = $this->input->get('srh_warehouse_id');
		$fxd_ass_id=$this->input->get('fxd_ass_id');
		$etp_id=$this->input->get('etp_id');
		//number_format($product_price, 2, '.', ',')
		 $owner_withdrawls_payments= number_format($this->finance_model->cash_book_get_owner_withdrawls_payments($srh_from_date,$srh_to_date,$srh_warehouse_id,$fxd_ass_id,$etp_id), 2, '.', '');
		 
		//echo $this->db->last_query();
		 
         echo json_encode(array('error'=>"$error",'disMsg'=>$disMsg,'owner_withdrawls_payments'=>$owner_withdrawls_payments));
    }
	
	public function cash_book_get_sales_related_expences_payments() {
		 $error=0;
		 $disMsg=0;
		 $grn_payment_val=0;
		 $srh_from_date = $this->input->get('srh_from_date');
		$srh_to_date =$this->input->get('srh_to_date');
		$srh_warehouse_id = $this->input->get('srh_warehouse_id');
		 $sales_related_expences_payments= $this->finance_model->cash_book_get_sales_related_expences_payments($srh_from_date,$srh_to_date,$srh_warehouse_id);
		 
         echo json_encode(array('error'=>"$error",'disMsg'=>$disMsg,'sales_related_expences_payments'=>$sales_related_expences_payments));
    }
	
	 public function cash_book_get_salary_advance_payments() {
		 $error=0;
		 $disMsg=0;
		 $grn_payment_val=0;
		 $srh_from_date = $this->input->get('srh_from_date');
		$srh_to_date =$this->input->get('srh_to_date');
		$srh_warehouse_id = $this->input->get('srh_warehouse_id');
		 $salary_advance_payments= $this->finance_model->get_salary_advance_payments_by_date_range($srh_from_date,$srh_to_date,$srh_warehouse_id);
		 
         echo json_encode(array('error'=>"$error",'disMsg'=>$disMsg,'salary_advance_payments'=>$salary_advance_payments));
    }
	
	 public function get_empty_qty_by_id() {
		 $error=0;
		 $disMsg=0;
		 $bear_empties_q=0;
		 $bear_empties_q_2=0;//408
		 $es_q=0;//27
		  $es_p=0;//28
		  $es_q_2=0;//407
		  $es_p_2=0;//406
		  $arrack_plastic_crates=0;
		  
		 $srh_from_date = '';//$this->input->get('srh_from_date');
		$srh_to_date =$this->input->get('srh_to_date');
		$srh_warehouse_id = $this->input->get('srh_warehouse_id');
		// $salary_advance_payments= $this->finance_model->get_salary_advance_payments_by_date_range($srh_from_date,$srh_to_date,$srh_warehouse_id);
		$location_id='';
		$product_id=26;// bear bottle q
		 $bear_empties_q=$this->Report_Model->get_location_sale_by_location_id_and_date($location_id,$product_id,$srh_from_date,$srh_to_date,'');
		 $product_id=408;// bear bottle q
		  $bear_empties_q_2=$this->Report_Model->get_location_sale_by_location_id_and_date($location_id,$product_id,$srh_from_date,$srh_to_date,'');
		  
		  $product_id=27;// bear bottle q
		  $es_q=$this->Report_Model->get_location_sale_by_location_id_and_date($location_id,$product_id,$srh_from_date,$srh_to_date,'');
		  $product_id=407;// bear bottle q
		  $es_q_2=$this->Report_Model->get_location_sale_by_location_id_and_date($location_id,$product_id,$srh_from_date,$srh_to_date,'');
		  
		  $product_id=28;// bear bottle q
		  $es_p=$this->Report_Model->get_location_sale_by_location_id_and_date($location_id,$product_id,$srh_from_date,$srh_to_date,'');
		  $product_id=406;// bear bottle q
		  $es_p_2=$this->Report_Model->get_location_sale_by_location_id_and_date($location_id,$product_id,$srh_from_date,$srh_to_date,'');
		  
		  $product_id=425;// bear bottle q
		  $arrack_plastic_crates=$this->Report_Model->get_location_sale_by_location_id_and_date($location_id,$product_id,$srh_from_date,$srh_to_date,'');
		  $product_id=426;// bear bottle q
		  $beer_plastic_crates=$this->Report_Model->get_location_sale_by_location_id_and_date($location_id,$product_id,$srh_from_date,$srh_to_date,'');
		  
		  
		  
		 
         echo json_encode(array('error'=>"$error",'disMsg'=>$disMsg,'bear_empties_q'=>($bear_empties_q+$bear_empties_q_2),'es_q'=>$es_q+$es_q_2,'es_p'=>$es_p+$es_p_2,'arrack_plastic_crates'=>$arrack_plastic_crates,'beer_plastic_crates'=>$beer_plastic_crates));
    }
	
	/*
	public function cash_book_get_salary_advance_payments() {
		 $error=0;
		 $disMsg=0;
		 $grn_payment_val=0;
		 $srh_from_date = $this->input->get('srh_from_date');
		$srh_to_date =$this->input->get('srh_to_date');
		$srh_warehouse_id = $this->input->get('srh_warehouse_id');
		 $salary_advance_payments= $this->finance_model->get_salary_advance_payments_by_date_range($srh_from_date,$srh_to_date,$srh_warehouse_id);
		 
         echo json_encode(array('error'=>"$error",'disMsg'=>$disMsg,'salary_advance_payments'=>$salary_advance_payments));
    }
	*/
	public function cash_book_get_salary_payments() {
		 $error=0;
		 $disMsg=0;
		 $grn_payment_val=0;
		 $srh_from_date = $this->input->get('srh_from_date');
		$srh_to_date =$this->input->get('srh_to_date');
		$srh_warehouse_id = $this->input->get('srh_warehouse_id');
		 $salary_payments= $this->finance_model->get_salary_payments_by_date_range($srh_from_date,$srh_to_date,$srh_warehouse_id);
		 
         echo json_encode(array('error'=>"$error",'disMsg'=>$disMsg,'salary_payments'=>$salary_payments));
    }
	
	public function get_cash_collector_short_by_date_range() {
		 $error=0;
		 $disMsg=0;
		 $grn_payment_val=0;
		 $cash_collector_short=0;
		 $cash_collector_ex=0;
		 $srh_from_date = $this->input->get('srh_from_date');
		$srh_to_date =$this->input->get('srh_to_date');
		$srh_warehouse_id = $this->input->get('srh_warehouse_id');
		
		// echo $this->db->last_query();
		 //print_r($cash_collector_short_arry);
		 $excess_short=0;
		 $tot_amount=0;
		 $tot_vist_charge=0;
		 
		 /* cal total amount */
		 $issue_card_list=array();
		// echo "Test 1 ,";
		 $issue_card_list= $this->finance_model->get_list_issue_card_by_date_range($srh_from_date,$srh_to_date,$srh_warehouse_id);
		// echo "Test 2 ,";
		 foreach ($issue_card_list as $ici_row)
 {
	// echo "Test 3 ,";
	// print_r($ici_row);
	 $issue_card_id=$ici_row->issue_card_id;//$ici_row->issue_card_id;
	 
	 //get issue card item paid amount
	 $payment_des=$this->finance_model->get_payment_des_by_issue_card_id($issue_card_id);
	// echo "<br/><br/>";
	// echo $this->db->last_query();
	// print_r($payment_des);
	 //echo "<br/>";
	 $tot_amount=$payment_des[0]->sale_pymnt_amount;
	 $tot_vist_charge=$payment_des[0]->tot_vist_charge;
	 
		
		$cash_collector_short_arry= $this->finance_model->get_cash_collector_short_by_date_range($srh_from_date,$srh_to_date,$srh_warehouse_id,$issue_card_id);
		foreach ($cash_collector_short_arry as $row)
		{
		$cr_amount_tot=$row->cr_amount_tot;
		$cr_expenses_tot=$row->cr_expenses_tot;
		$cr_no_of_code_tot=$row->cr_no_of_code_tot;
		$excess_short_1=($cr_amount_tot+$cr_expenses_tot)-($tot_amount+$tot_vist_charge);
		//echo "  excess_short_1:$excess_short_1, issue_card_id:$issue_card_id , cr_amount_tot:$cr_amount_tot , cr_expenses_tot:$cr_expenses_tot , tot_amount:$tot_amount , tot_vist_charge:$tot_vist_charge";
		if($excess_short_1>0)
		{
			$cash_collector_short=$cash_collector_short+$excess_short_1;
		}else{
			$cash_collector_ex=$cash_collector_ex+$excess_short_1;
		}
		}
	 
 }
		 /* end cal total amount */
		 
		 
		 $cash_collector_ex=abs($cash_collector_ex);
		
		
		// $cash_collector_short=$cash_collector_short;
		 
         echo json_encode(array('error'=>"$error",'disMsg'=>$disMsg,'cash_collector_short'=>$cash_collector_short,'cash_collector_ex'=>$cash_collector_ex));
    }
	
	 public function day_end() {
        $data['main_menu_name'] = $this->main_menu_name;
        $data['sub_menu_name'] = 'day_end';
		 $data['warehouse_list'] = $this->Warehouse_Model->get_all_warehouse();
        $this->load->view("day_end", $data);
    }
	
	public function day_end_submit()
	{
		$warehouse_id=$this->input->post('warehouse_id');
		$status=$this->input->post('status');
		$data=array(
			'status'=>$status
		);
		
		$this->Warehouse_Model->save_warehouse($data,$warehouse_id);
		
		$this->Common_Model->add_user_activitie("Day End, warehouse_id:$warehouse_id , status:$status");
		//echo $this->db->last_query();
		echo json_encode(array('status' => 'done'));
		//  echo json_encode($json_data);
		//$lastid=$this->db->insert_id();
	}
	
   

}
