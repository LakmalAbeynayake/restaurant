<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class finance_model extends CI_Model{
    
    var $tableName = 'salary';
    
    function __construct() {
        parent::__construct();
    }
 

		public function get_grn_payments_by_date_range($srh_from_date,$srh_to_date,$srh_warehouse_id,$supp_id=''){
		$this->db->select_sum('sp.sale_pymnt_amount');    
		$this->db->from('sale_payments sp');
		$this->db->join('purchases p','sp.sale_id=p.id','left');
		
		if($srh_to_date){
		$srh_to_date=date('Y-m-d',strtotime($srh_to_date));
		$this->db->where("date(sp.sale_pymnt_date_time) <=",$srh_to_date);
		}
		
		if($srh_from_date){
		$srh_from_date=date('Y-m-d',strtotime($srh_from_date));
		$this->db->where("date(sp.sale_pymnt_date_time) >=",$srh_from_date);
		}
		
		
		if($srh_warehouse_id){
		$this->db->where('p.warehouse_id',$srh_warehouse_id);	
		}
		if($supp_id){
		$this->db->where('p.supplier_id',$supp_id);	
		}
		
		$this->db->where('sp.sale_pymnt_amount != ' ,'0.00');	
		$this->db->where('sp.sale_payment_type ' ,'grn');	
		$query=$this->db->get();
		//echo $this->db->last_query();
		$return_des=$query->result();
		return ($return_des[0]->sale_pymnt_amount);
		//return $query->result();
	}	
	
	
	public function get_cash_sales_payment_by_date_range($srh_from_date,$srh_to_date,$srh_warehouse_id,$cat_id=''){
		//$this->db->select_sum('sp.sale_pymnt_amount');    
		$this->db->select_sum('si.gross_total');  
		$this->db->from('sale_items si');
		//$this->db->from('sale_payments sp');
		$this->db->join('sales s','si.sale_id=s.sale_id','left');
		//$this->db->join('sale_items si','s.sale_id=si.sale_id','left');
		$this->db->join('product p','si.product_id=p.product_id','left');
		
		if($srh_to_date){
		$srh_to_date=date('Y-m-d',strtotime($srh_to_date));
		$this->db->where("date(s.sale_datetime) <=",$srh_to_date);
		}
		
		if($srh_from_date){
		$srh_from_date=date('Y-m-d',strtotime($srh_from_date));
		$this->db->where("date(s.sale_datetime) >=",$srh_from_date);
		}
		
		
		if($srh_warehouse_id){
		$this->db->where('s.warehouse_id',$srh_warehouse_id);	
		}
		if($cat_id){
		$this->db->where('p.cat_id',$cat_id);	
		}
		
		//$this->db->where('sp.sale_pymnt_amount != ' ,'0.00');	
		//$this->db->where('sp.sale_payment_type' ,'sale');	
		//$this->db->where('s.in_type' ,'Cash');	
		$query=$this->db->get();
		//echo $this->db->last_query();
		$return_des=$query->result();
		return ($return_des[0]->gross_total);
		//return $query->result();
	}	
	
	
	public function get_cash_sales_payment_by_date_range_cash($srh_from_date,$srh_to_date,$srh_warehouse_id,$user_id=''){
		//$this->db->select_sum('sp.sale_pymnt_amount');    
		$this->db->select_sum('si.gross_total');  
		$this->db->from('sale_items si');
		//$this->db->from('sale_payments sp');
		$this->db->join('sales s','si.sale_id=s.sale_id','left');
		//$this->db->join('sale_items si','s.sale_id=si.sale_id','left');
		$this->db->join('product p','si.product_id=p.product_id','left');
		
		if($srh_to_date){
		$srh_to_date=date('Y-m-d',strtotime($srh_to_date));
		$this->db->where("date(s.sale_datetime) <=",$srh_to_date);
		}
		
		if($srh_from_date){
		$srh_from_date=date('Y-m-d',strtotime($srh_from_date));
		$this->db->where("date(s.sale_datetime) >=",$srh_from_date);
		}
		
		
		if($srh_warehouse_id){
		$this->db->where('s.warehouse_id',$srh_warehouse_id);	
		}
		if($user_id){
		$this->db->where('s.user',$user_id);	
		}
		
		//$this->db->where('sp.sale_pymnt_amount != ' ,'0.00');	
		//$this->db->where('sp.sale_payment_type' ,'sale');	
		//$this->db->where('s.in_type' ,'Cash');	
		$query=$this->db->get();
		echo $this->db->last_query();
		$return_des=$query->result();
		return ($return_des[0]->gross_total);
		//return $query->result();
	}	
	
	
		public function get_cash_sales_payment_by_date_range_cost($srh_from_date,$srh_to_date,$srh_warehouse_id,$cat_id=''){
		//$this->db->select_sum('sp.sale_pymnt_amount');    
		$this->db->select('si.quantity,si.item_cost');  
		$this->db->from('sale_items si');
		//$this->db->from('sale_payments sp');
		$this->db->join('sales s','si.sale_id=s.sale_id','left');
		//$this->db->join('sale_items si','s.sale_id=si.sale_id','left');
		$this->db->join('product p','si.product_id=p.product_id','left');
		
		if($srh_to_date){
		$srh_to_date=date('Y-m-d',strtotime($srh_to_date));
		$this->db->where("date(s.sale_datetime) <=",$srh_to_date);
		}
		
		if($srh_from_date){
		$srh_from_date=date('Y-m-d',strtotime($srh_from_date));
		$this->db->where("date(s.sale_datetime) >=",$srh_from_date);
		}
		
		
		if($srh_warehouse_id){
		$this->db->where('s.warehouse_id',$srh_warehouse_id);	
		}
		if($cat_id){
		$this->db->where('p.cat_id',$cat_id);	
		}
		
		//$this->db->where('sp.sale_pymnt_amount != ' ,'0.00');	
		//$this->db->where('sp.sale_payment_type' ,'sale');	
		//$this->db->where('s.in_type' ,'Cash');	
		$query=$this->db->get();
		//echo $this->db->last_query();
	//	$return_des=$query->result();
		//return ($return_des[0]->gross_total);
		return $query->result();
	}
	
	public function get_advance_payment_by_date_range($srh_from_date,$srh_to_date,$srh_warehouse_id){
		$this->db->select_sum('sp.sale_pymnt_amount');    
		$this->db->from('sale_payments sp');
		$this->db->join('sales s','s.sale_id=sp.sale_id','left');
		
		if($srh_to_date){
		$srh_to_date=date('Y-m-d',strtotime($srh_to_date));
		$this->db->where("date(sp.sale_pymnt_date_time) <=",$srh_to_date);
		}
		
		if($srh_from_date){
		$srh_from_date=date('Y-m-d',strtotime($srh_from_date));
		$this->db->where("date(sp.sale_pymnt_date_time) >=",$srh_from_date);
		}
		
		if($srh_warehouse_id){
		$this->db->where('p.warehouse_id',$srh_warehouse_id);	
		}
		$this->db->where('sp.sale_pymnt_amount != ' ,'0.00');	
		$this->db->where('sp.sale_payment_type' ,'quotations');	
		$this->db->where('s.in_type','Hire');	
		//$this->db->where('sp.sale_pymnt_note','Down Payment');	
		$query=$this->db->get();
		//echo $this->db->last_query();
		$return_des=$query->result();
		return ($return_des[0]->sale_pymnt_amount);
		//return $query->result();
	}
	
	
	public function get_downpayments_payment_by_date_range($srh_from_date,$srh_to_date,$srh_warehouse_id){
		$this->db->select_sum('sp.sale_pymnt_amount');    
		$this->db->from('sale_payments sp');
		$this->db->join('sales s','s.sale_id=sp.sale_id','left');
		
		if($srh_to_date){
		$srh_to_date=date('Y-m-d',strtotime($srh_to_date));
		$this->db->where("date(sp.sale_pymnt_date_time) <=",$srh_to_date);
		}
		
		if($srh_from_date){
		$srh_from_date=date('Y-m-d',strtotime($srh_from_date));
		$this->db->where("date(sp.sale_pymnt_date_time) >=",$srh_from_date);
		}
		
		if($srh_warehouse_id){
		$this->db->where('p.warehouse_id',$srh_warehouse_id);	
		}
		$this->db->where('sp.sale_pymnt_amount != ' ,'0.00');	
		$this->db->where('sp.sale_payment_type' ,'sale');	
		$this->db->where('s.in_type','Hire');	
		$this->db->where('sp.sale_pymnt_note','Down Payment');	
		$query=$this->db->get();
		//echo $this->db->last_query();
		$return_des=$query->result();
		return ($return_des[0]->sale_pymnt_amount);
		//return $query->result();
	}
	
	
	public function cash_book_get_owner_withdrawls_payments($srh_from_date,$srh_to_date,$srh_warehouse_id,$fxd_ass_id,$etp_id=''){
		$this->db->select_sum('at.acctrnss_amount');    
		$this->db->from('acc_transactions at');
		//$this->db->join('sales s','s.sale_id=sp.sale_id','left');
		
		if($srh_to_date){
		$srh_to_date=date('Y-m-d',strtotime($srh_to_date));
		$this->db->where("date(at.acctrnss_date) <=",$srh_to_date);
		}
		
		if($srh_from_date){
		$srh_from_date=date('Y-m-d',strtotime($srh_from_date));
		$this->db->where("date(at.acctrnss_date) >=",$srh_from_date);
		}
		
		if($srh_warehouse_id){
		//$this->db->where('p.warehouse_id',$srh_warehouse_id);	
		}
		
		if($etp_id){
			$this->db->where('at.etp_id',$etp_id);	
		}
		
		$this->db->where('at.fxd_ass_id',$fxd_ass_id);	
			
		$query=$this->db->get();
		//echo $this->db->last_query();
		$return_des=$query->result();
		return ($return_des[0]->acctrnss_amount);
		//return $query->result();
	}
	
		public function cash_book_get_installments_payment($srh_from_date,$srh_to_date,$srh_warehouse_id){
		$this->db->select_sum('sp.sale_pymnt_amount');    
		$this->db->from('sale_payments sp');
		$this->db->join('sales s','s.sale_id=sp.sale_id','left');
		
		if($srh_to_date){
		$srh_to_date=date('Y-m-d',strtotime($srh_to_date));
		$this->db->where("date(sp.sale_pymnt_date_time) <=",$srh_to_date);
		}
		
		if($srh_from_date){
		$srh_from_date=date('Y-m-d',strtotime($srh_from_date));
		$this->db->where("date(sp.sale_pymnt_date_time) >=",$srh_from_date);
		}
		
		if($srh_warehouse_id){
		$this->db->where('p.warehouse_id',$srh_warehouse_id);	
		}
		$this->db->where('sp.sale_pymnt_amount != ' ,'0.00');	
		$this->db->where('sp.sale_payment_type' ,'sale');	
		$this->db->where('s.in_type','Hire');	
		$this->db->where('sp.sale_pymnt_note','');	
		$query=$this->db->get();
		//echo $this->db->last_query();
		$return_des=$query->result();
		return ($return_des[0]->sale_pymnt_amount);
		//return $query->result();
	}
	
	public function cash_book_get_visiting_charges_payment($srh_from_date,$srh_to_date,$srh_warehouse_id){
		$this->db->select_sum('sp.sale_pymnt_visiting_charge');    
		$this->db->from('sale_payments sp');
		$this->db->join('sales s','s.sale_id=sp.sale_id','left');
		
		if($srh_to_date){
		$srh_to_date=date('Y-m-d',strtotime($srh_to_date));
		$this->db->where("date(sp.sale_pymnt_date_time) <=",$srh_to_date);
		}
		
		if($srh_from_date){
		$srh_from_date=date('Y-m-d',strtotime($srh_from_date));
		$this->db->where("date(sp.sale_pymnt_date_time) >=",$srh_from_date);
		}
		
		if($srh_warehouse_id){
		$this->db->where('p.warehouse_id',$srh_warehouse_id);	
		}
		
		$this->db->where('sp.sale_pymnt_visit_status' ,'Visited');	
		$this->db->where('sp.sale_payment_type' ,'sale');
		$this->db->where('s.in_type','Hire');	
		$this->db->where('sp.sale_pymnt_note','');	
		$query=$this->db->get();
		//echo $this->db->last_query();
		$return_des=$query->result();
		return ($return_des[0]->sale_pymnt_visiting_charge);
		//return $query->result();
	}
	

	public function cash_book_get_sales_related_expences_payments($srh_from_date,$srh_to_date,$srh_warehouse_id){
		$this->db->select('SUM(cr.cr_sr_expenses) AS cr_sr_expenses');    
		$this->db->from('cash_receiving cr');
		//$this->db->join('sales s','s.sale_id=sp.sale_id','left');
		
		if($srh_to_date){
		$srh_to_date=date('Y-m-d',strtotime($srh_to_date));
		$this->db->where("date(cr.cr_date) <=",$srh_to_date);
		}
		
		if($srh_from_date){
		$srh_from_date=date('Y-m-d',strtotime($srh_from_date));
		$this->db->where("date(cr.cr_date) >=",$srh_from_date);
		}
		
		if($srh_warehouse_id){
		//$this->db->where('p.warehouse_id',$srh_warehouse_id);	
		}
		
		//$this->db->where('sp.sale_pymnt_visit_status' ,'Visited');	
		//$this->db->where('sp.sale_payment_type' ,'sale');
		//$this->db->where('s.in_type','Hire');	
		//$this->db->where('sp.sale_pymnt_note','');	
		$query=$this->db->get();
		//echo $this->db->last_query();
		$return_des=$query->result();
		$cr_sr_expenses=$return_des[0]->cr_sr_expenses;
		//echo "cr_expenses_tot:$cr_expenses_tot";
		
		//print_r($return_des);
		//return ($return_des[0]->sale_pymnt_visiting_charge);
		//$rep_expences_payments=$cr_expenses_tot;
		return $cr_sr_expenses;
	}
		
		public function cash_book_get_rep_expences_payments($srh_from_date,$srh_to_date,$srh_warehouse_id){
		$this->db->select('SUM(cr.cr_expenses) AS cr_expenses_tot,SUM(cr.cr_sl_rep_exp) AS cr_sl_rep_exp,SUM(cr.cr_sec_sl_rep_exp) AS cr_sec_sl_rep_exp');    
		$this->db->from('cash_receiving cr');
		//$this->db->join('sales s','s.sale_id=sp.sale_id','left');
		
		if($srh_to_date){
		$srh_to_date=date('Y-m-d',strtotime($srh_to_date));
		$this->db->where("date(cr.cr_date) <=",$srh_to_date);
		}
		
		if($srh_from_date){
		$srh_from_date=date('Y-m-d',strtotime($srh_from_date));
		$this->db->where("date(cr.cr_date) >=",$srh_from_date);
		}
		
		if($srh_warehouse_id){
		//$this->db->where('p.warehouse_id',$srh_warehouse_id);	
		}
		
		//$this->db->where('sp.sale_pymnt_visit_status' ,'Visited');	
		//$this->db->where('sp.sale_payment_type' ,'sale');
		//$this->db->where('s.in_type','Hire');	
		//$this->db->where('sp.sale_pymnt_note','');	
		$query=$this->db->get();
		//echo $this->db->last_query();
		$return_des=$query->result();
		$cr_expenses_tot=0;//$return_des[0]->cr_expenses_tot;
		$cr_sl_rep_exp=$return_des[0]->cr_sl_rep_exp;
		$cr_sec_sl_rep_exp=$return_des[0]->cr_sec_sl_rep_exp;
		//echo "cr_expenses_tot:$cr_expenses_tot";
		
		//print_r($return_des);
		//return ($return_des[0]->sale_pymnt_visiting_charge);
		//echo "cr_expenses_tot:$cr_expenses_tot , cr_sl_rep_exp:$cr_sl_rep_exp , cr_sec_sl_rep_exp:$cr_sec_sl_rep_exp";
		
		$rep_expences_payments=$cr_expenses_tot+$cr_sl_rep_exp+$cr_sec_sl_rep_exp;
		return $rep_expences_payments;
	}
	
	public function cash_book_get_cash_expences_payments($srh_from_date,$srh_to_date,$srh_warehouse_id){
		$this->db->select('SUM(cr.cr_expenses) AS cr_expenses_tot,SUM(cr.cr_sl_rep_exp) AS cr_sl_rep_exp,SUM(cr.cr_sec_sl_rep_exp) AS cr_sec_sl_rep_exp');    
		$this->db->from('cash_receiving cr');
		//$this->db->join('sales s','s.sale_id=sp.sale_id','left');
		
		if($srh_to_date){
		$srh_to_date=date('Y-m-d',strtotime($srh_to_date));
		$this->db->where("date(cr.cr_date) <=",$srh_to_date);
		}
		
		if($srh_from_date){
		$srh_from_date=date('Y-m-d',strtotime($srh_from_date));
		$this->db->where("date(cr.cr_date) >=",$srh_from_date);
		}
		
		if($srh_warehouse_id){
		//$this->db->where('p.warehouse_id',$srh_warehouse_id);	
		}
		
		//$this->db->where('sp.sale_pymnt_visit_status' ,'Visited');	
		//$this->db->where('sp.sale_payment_type' ,'sale');
		//$this->db->where('s.in_type','Hire');	
		//$this->db->where('sp.sale_pymnt_note','');	
		$query=$this->db->get();
		//echo $this->db->last_query();
		$return_des=$query->result();
		$cr_expenses_tot=$return_des[0]->cr_expenses_tot;
		$cr_sl_rep_exp=0;//$return_des[0]->cr_sl_rep_exp;
		$cr_sec_sl_rep_exp=0;//$return_des[0]->cr_sec_sl_rep_exp;
		//echo "cr_expenses_tot:$cr_expenses_tot";
		
		//print_r($return_des);
		//return ($return_des[0]->sale_pymnt_visiting_charge);
		//echo "cr_expenses_tot:$cr_expenses_tot , cr_sl_rep_exp:$cr_sl_rep_exp , cr_sec_sl_rep_exp:$cr_sec_sl_rep_exp";
		
		$rep_expences_payments=$cr_expenses_tot+$cr_sl_rep_exp+$cr_sec_sl_rep_exp;
		return $rep_expences_payments;
	}
	
	public function get_salary_advance_payments_by_date_range($srh_from_date,$srh_to_date,$srh_warehouse_id){
		$this->db->select_sum('sp.sp_amount');    
		$this->db->from('salary_payment sp');
		
		
		if($srh_to_date){
		$srh_to_date=date('Y-m-d',strtotime($srh_to_date));
		$this->db->where("date(sp.sp_date) <=",$srh_to_date);
		}
		
		if($srh_from_date){
		$srh_from_date=date('Y-m-d',strtotime($srh_from_date));
		$this->db->where("date(sp.sp_date) >=",$srh_from_date);
		}
		
		
		if($srh_warehouse_id){
		$this->db->where('sp.warehouse_id',$srh_warehouse_id);	
		}
		$this->db->where('sp.sp_amount != ' ,'0.00');	
		$this->db->where('sp.sp_is_sal_advance ' ,'1');	
		$query=$this->db->get();
		//echo $this->db->last_query();
		$return_des=$query->result();
		return ($return_des[0]->sp_amount);
		//return $query->result();
	}
	
		public function get_salary_payments_by_date_range($srh_from_date,$srh_to_date,$srh_warehouse_id){
		$this->db->select_sum('sp.sp_amount');    
		$this->db->from('salary_payment sp');
		
		
		if($srh_to_date){
		$srh_to_date=date('Y-m-d',strtotime($srh_to_date));
		$this->db->where("date(sp.sp_date) <=",$srh_to_date);
		}
		
		if($srh_from_date){
		$srh_from_date=date('Y-m-d',strtotime($srh_from_date));
		$this->db->where("date(sp.sp_date) >=",$srh_from_date);
		}
		
		
		if($srh_warehouse_id){
		$this->db->where('sp.warehouse_id',$srh_warehouse_id);	
		}
		$this->db->where('sp.sp_amount != ' ,'0.00');	
		$this->db->where('sp.sp_is_sal_advance ' ,'0');	
		$query=$this->db->get();
		//echo $this->db->last_query();
		$return_des=$query->result();
		return ($return_des[0]->sp_amount);
		//return $query->result();
	}	
	
	public function get_cash_collector_short_by_date_range($srh_from_date,$srh_to_date,$srh_warehouse_id,$issue_card_id){
		$this->db->select('SUM(cr.cr_amount) AS cr_amount_tot,SUM(cr.cr_expenses) AS cr_expenses_tot,SUM(cr.cr_no_of_code) AS cr_no_of_code_tot');    
		$this->db->from('cash_receiving cr');
		
		
		if($srh_to_date){
		$srh_to_date=date('Y-m-d',strtotime($srh_to_date));
		$this->db->where("date(cr.cr_date) <=",$srh_to_date);
		}
		
		if($srh_from_date){
		$srh_from_date=date('Y-m-d',strtotime($srh_from_date));
		$this->db->where("date(cr.cr_date) >=",$srh_from_date);
		}
		
		
		if($srh_warehouse_id){
		$this->db->where('cr.cr_warehouse_id',$srh_warehouse_id);	
		}
		//$this->db->where('s.sl_amount != ' ,'0.00');	
		$this->db->where('cr.issue_card_id' ,$issue_card_id);	
		$query=$this->db->get();
		return $query->result();
		//echo $this->db->last_query();
		//$return_des=$query->result();
		//return ($return_des[0]->sl_amount);
		//return $query->result();
	}	
	
	
	 function get_payment_des_by_issue_card_id($issue_card_id){

	$this->db->select('SUM(sp.sale_pymnt_amount) as sale_pymnt_amount, SUM(sp.sale_pymnt_visiting_charge) as tot_vist_charge, ');

	$this->db->from('sale_payments sp');

	//$this->db->where("sale_id",$sale_id);//->where("(sale_payment_type='sale' OR sale_payment_type='pos_sale')");
	$this->db->where("sp.issue_card_id",$issue_card_id);

	//$query=$this->db->get();
	$query=$this->db->get();
	return $return_des=$query->result();
	//return ($return_des[0]->sale_pymnt_amount);
	//echo $this->db->last_query();

	//return $query->row();

  }
	
	public function get_list_issue_card_by_date_range($srh_from_date,$srh_to_date,$srh_warehouse_id){
		$this->db->select('ic.*');    
		$this->db->from('issue_card ic');
		
		
		if($srh_to_date){
		$srh_to_date=date('Y-m-d',strtotime($srh_to_date));
		$this->db->where("date(ic.issue_card_date) <=",$srh_to_date);
		}
		
		if($srh_from_date){
		$srh_from_date=date('Y-m-d',strtotime($srh_from_date));
		$this->db->where("date(ic.issue_card_date) >=",$srh_from_date);
		}
		
		
		if($srh_warehouse_id){
		$this->db->where('ic.wharehouse_id',$srh_warehouse_id);	
		}
		//$this->db->where('s.sl_amount != ' ,'0.00');	
		//$this->db->where('s.mstr_sal_type_id' ,16);	
		$query=$this->db->get();
		return $query->result();

	}
	
	/*
	  function get_payment_des_by_date($sale_id,$issue_card_id){

	$this->db->select('*');

	$this->db->from('sale_payments sp');

	$this->db->where("sale_id",$sale_id);//->where("(sale_payment_type='sale' OR sale_payment_type='pos_sale')");
	//$this->db->where("issue_card_id",$issue_card_id);
	if($srh_to_date){
		$srh_to_date=date('Y-m-d',strtotime($srh_to_date));
		$this->db->where("date(cr.sale_pymnt_date_time) <=",$srh_to_date);
		}
		
		if($srh_from_date){
		$srh_from_date=date('Y-m-d',strtotime($srh_from_date));
		$this->db->where("date(cr.sale_pymnt_date_time) >=",$srh_from_date);
		}

	$query=$this->db->get();

	//echo $this->db->last_query();

	return $query->row();

  }
	*/
	function get_mstr_expences_type_list()
	{
		$this->db->select('mstr_expences_type.*');
		$this->db->from('mstr_expences_type');
		//$this->db->join('fixed_assets_type','fixed_asset.fa_type_id=fixed_assets_type.fa_type_id','left');
		$query=$this->db->get();
		return $query->result_array();
	}
	}