<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Transactions_Model extends CI_Model {
	 function __construct(){
		 parent::__construct();
		 }
    function transactions_type_list(){
	$this->db->select('*');	
	$this->db->from('fixed_assets_type');
	$this->db->where('fa_type_status',1);
	$query=$this->db->get();
	return $query->result_array();
		}		 
	function save_transactions(&$data,$acctrnss_id=false)
	{
		if (!$acctrnss_id)
		{
			$this->db->insert('acc_transactions',$data);
		}else {
			$this->db->where('acctrnss_id', $acctrnss_id);
			return $this->db->update('acc_transactions',$data);
			
		}
	}
	function get_transactions_list($start='',$length='',$search_key_val='',$fxd_ass_id='',$warehouse_id='',$srh_from_date='',$srh_to_date='')
	{
		$this->db->select('acc_transactions.*,mstr_expences_type.*');
		$this->db->select('fixed_asset.*');
		//$this->db->select('fixed_assets_type.*');
		//$this->db->select('fixed_assets_master.*');
		$this->db->from('acc_transactions');
		$this->db->join('fixed_asset','acc_transactions.fxd_ass_id=fixed_asset.fxd_ass_id','left');
		$this->db->join('mstr_expences_type','acc_transactions.etp_id=mstr_expences_type.etp_id','left');
	//	$this->db->join('fixed_assets_master','fixed_assets_master.fam_id=fixed_assets_type.fam_id','left');
	
		if($fxd_ass_id){
			$this->db->where("acc_transactions.fxd_ass_id",$fxd_ass_id);
		}
		
		if($srh_to_date){
			$srh_to_date=date('Y-m-d',strtotime($srh_to_date));
			$this->db->where("acc_transactions.acctrnss_date <=",$srh_to_date);//("id !=",$id);
		}
		if($srh_from_date){
			$srh_from_date=date('Y-m-d',strtotime($srh_from_date));
			$this->db->where("acc_transactions.acctrnss_date >=",$srh_from_date);//("id !=",$id);
		}
		if ($start != '' && $length != '') {
            $this->db->limit($length, $start);
        }
		$this->db->order_by("acctrnss_id", "desc");
		
		$query=$this->db->get();
		
		//echo $this->db->last_query();
		return $query->result_array();
	}
	
	function get_fixed_assets_master_list()
	{
		$this->db->select('fixed_assets_master.*');
		$this->db->from('fixed_assets_master');
		$this->db->order_by("fam_id", "asc");
		$query=$this->db->get();
		return $query->result();
	}	

	function get_fixed_assets_type_list($fam_id='')
	{
		$this->db->select('fixed_assets_type.*');
		$this->db->from('fixed_assets_type');
		$this->db->where('fam_id',$fam_id);
		$this->db->order_by("fa_type_id", "asc");
		$query=$this->db->get();
		return $query->result();
	}

	function get_fixed_assets_list($fa_type_id='')
	{
		$this->db->select('fa.*');
		$this->db->from('fixed_asset fa');
		$this->db->where('fa.fa_type_id',$fa_type_id);
		$this->db->order_by("fa.fxd_ass_id", "asc");
		$query=$this->db->get();
		return $query->result();
	}

	function get_acc_transactions_list($fa_type_id='',$srh_from_date='',$srh_to_date='',$srh_warehouse_id='')
	{
		//echo "srh_from_date:$srh_from_date , srh_to_date:$srh_to_date";
		$this->db->select('fa.*,at.*');
		$this->db->from('acc_transactions at');
		$this->db->join('fixed_asset fa','fa.fxd_ass_id=at.fxd_ass_id','left');
		if($fa_type_id){
		$this->db->where('fa.fa_type_id',$fa_type_id);
		}
		if($srh_to_date)
		{
			$srh_to_date=date('Y-m-d',strtotime($srh_to_date));
          //  $this->db->where("s.sale_datetime <=",$srh_to_date);
		  $this->db->where("date(at.acctrnss_date) <=",$srh_to_date);
			}
		if($srh_from_date)
		{
			$srh_from_date=date('Y-m-d',strtotime($srh_from_date));
			$this->db->where("date(at.acctrnss_date) >=",$srh_from_date);
		}
		$this->db->order_by("at.acctrnss_id", "asc");
		$query=$this->db->get();
		return $query->result();
	}
				
	function get_transactions_details($acctrnss_id)
	{
	$this->db->select('*');
	$this->db->from('acc_transactions');	
	$this->db->where('acctrnss_id',$acctrnss_id);
	$query=$this->db->get();
	return $query->row_array();
	}
	
	function get_fixed_asset_vehical(){
		$this->db->select('fixed_asset.fxd_ass_id,fixed_asset.fxd_ass_name');
		$this->db->from('fixed_asset');
		$this->db->join('fixed_assets_type','fixed_assets_type.fa_type_id=fixed_asset.fa_type_id','left');
		$this->db->where('fixed_asset.fxd_ass_status',1);
		$this->db->where('fixed_assets_type.fa_type_id',1);
		$this->db->where('fixed_assets_type.fa_type_status',1);
		$query=$this->db->get();
		return $query->result_array();
		}
		
		function transaction_details_print($id){
		$this->db->select('a.*,met.etp_name');
		$this->db->select('fa.fxd_ass_name,u.user_first_name,u.user_last_name,cfm.ref_no');
		$this->db->from('acc_transactions a');
		$this->db->join('user u','u.user_id=a.user_id','inner');
		$this->db->join('fixed_asset fa','a.fxd_ass_id=fa.fxd_ass_id','left');
		$this->db->join('mstr_expences_type met','a.etp_id=met.etp_id','left');
		$this->db->join('cashier_float_master cfm','a.float_id=cfm.c_float_mstr_id','left');
        $this->db->where("a.acctrnss_id",$id);
		$query=$this->db->get();
		return $query->row_array();
		}
}