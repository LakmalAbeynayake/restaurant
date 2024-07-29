<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fixed_Assets_Model extends CI_Model {
	 function __construct(){
		 parent::__construct();
		 }
    function fixed_assets_type_list(){
	$this->db->select('*');	
	$this->db->from('fixed_assets_type');
	$this->db->where('fa_type_status',1);
	$query=$this->db->get();
	return $query->result_array();
		}		 
	function save_fixed_assets(&$data,$fxd_ass_id=false)
	{
		if (!$fxd_ass_id)
		{
			$this->db->insert('fixed_asset',$data);
		}else {
			$this->db->where('fxd_ass_id', $fxd_ass_id);
			return $this->db->update('fixed_asset',$data);
		}
	}
	function get_fixed_asset_list()
	{
		$this->db->select('fixed_asset.*');
		$this->db->select('fixed_assets_type.*');
		$this->db->from('fixed_asset');
		$this->db->join('fixed_assets_type','fixed_asset.fa_type_id=fixed_assets_type.fa_type_id','left');
		$query=$this->db->get();
		return $query->result_array();
	}
	function get_fixed_asset_details($fxd_ass_id)
	{
    	$this->db->select('*');
    	$this->db->from('fixed_asset');	
    	$this->db->where('fxd_ass_id',$fxd_ass_id);
    	$query=$this->db->get();
    	return $query->row_array();
	}
	
	function get_fixed_asset_location(){
		$this->db->select('fixed_asset.fxd_ass_id,fixed_asset.fxd_ass_name');
		$this->db->from('fixed_asset');
		$this->db->join('fixed_assets_type','fixed_assets_type.fa_type_id=fixed_asset.fa_type_id','left');
		$this->db->where('fixed_asset.fxd_ass_status',1);
		$this->db->where('fixed_assets_type.fa_type_id',6);
		$this->db->where('fixed_assets_type.fa_type_status',1);
		$query=$this->db->get();
		return $query->result_array();
	}
	
	public function get_sum_acctrnss_amount($float_id, $fxd_ass_id) {
        $this->db->select_sum('acctrnss_amount');
        $this->db->where('float_id', $float_id);
        $this->db->where('fxd_ass_id', $fxd_ass_id);
        $query = $this->db->get('acc_transactions');
        
        if($query->num_rows() > 0) {
            $result = $query->row();
            return $result->acctrnss_amount;
        } else {
            return 0; // Return 0 if no rows found
        }
    }
}