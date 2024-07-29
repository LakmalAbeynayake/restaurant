<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class salary_model extends CI_Model{
    
    var $tableName = 'salary';
    
    function __construct() {
        parent::__construct();
    }
 

	public function check_is_added_for_selected_month($user_id,$mstr_sal_type_id,$month_id)
	{
		$this->db->select('s.*');
		$this->db->from('salary s');
		$this->db->where('s.user_id',$user_id);
		$this->db->where('s.mstr_sal_type_id',$mstr_sal_type_id);
		//if($srh_from_date)
		{
			$this->db->where("YEAR(s.sl_date)",date("Y"));//("id !=",$id);
			$this->db->where("MONTH(s.sl_date)",$month_id);//("id !=",$id);
		}
		$query=$this->db->get();
		//return 
		if($query->num_rows() >0)
     	{
			$des=$query->result();
			return $des[0]->reference_number;
		}else{
			return 0;
		}
		//$des=$query->result();
		//echo "count:".count($des);
		//print_r($des);
		
		//return $des[0]->reference_number;

	}
	
	public function get_salary_addtion($user_id,$srh_from_date,$srh_to_date,$mstr_sal_type_did_add)
	{
		$this->db->select_sum('s.sl_amount');
		$this->db->from('salary s');
		$this->db->where('s.user_id',$user_id);
		$this->db->where('s.mstr_sal_type_did_add',$mstr_sal_type_did_add);
		if($srh_to_date){
			$srh_to_date=date('Y-m-d',strtotime($srh_to_date));
			$this->db->where("s.sl_date <=",$srh_to_date);//("id !=",$id);
		}
		if($srh_from_date){
			$this->db->where("s.sl_date >=",$srh_from_date);//("id !=",$id);
		}
		$query=$this->db->get();
		return $data['sl_amount']=$query->row()->sl_amount;

	}
	
	
	public function get_salary_by_type_id($user_id,$srh_from_date,$srh_to_date,$mstr_sal_type_id)
	{
		$this->db->select_sum('s.sl_amount');
		$this->db->from('salary s');
		$this->db->where('s.user_id',$user_id);
		$this->db->where('s.mstr_sal_type_id',$mstr_sal_type_id);
		if($srh_to_date){
			$srh_to_date=date('Y-m-d',strtotime($srh_to_date));
			$this->db->where("s.sl_date <=",$srh_to_date);//("id !=",$id);
		}
		if($srh_from_date){
			$this->db->where("s.sl_date >=",$srh_from_date);//("id !=",$id);
		}
		$query=$this->db->get();
		return $data['sl_amount']=$query->row()->sl_amount;

	}
	
	public function get_salary_paid_amount($user_id,$srh_from_date,$srh_to_date)
	{
		$this->db->select_sum('sp.sp_amount');
		$this->db->from('salary_payment sp');
		$this->db->where('sp.user_id',$user_id);
		//$this->db->where('s.mstr_sal_type_did_add',$mstr_sal_type_did_add);
		if($srh_to_date){
			$srh_to_date=date('Y-m-d',strtotime($srh_to_date));
			$this->db->where("sp.sp_date <=",$srh_to_date);//("id !=",$id);
		}
		if($srh_from_date){
			$this->db->where("sp.sp_date >=",$srh_from_date);//("id !=",$id);
		}
		$query=$this->db->get();
		return $data['sp_amount']=$query->row()->sp_amount;

	}
	 
 function getUsersEmpSummary($start='',$length='',$search_key_val='',$srh_user_id='',$num_rows='',$group_id='')
   {
	   $this->db->select('u.* , ug.user_group_name');
       $this->db->from('user u');
	   $this->db->join('user_group ug', 'u.group_id = ug.user_group_id', 'left');   
	   $this->db->order_by("u.group_id", "desc");
	   $this->db->order_by("u.user_first_name", "asc");
	  // $this->db->group_by("u.group_id");
	   if($search_key_val){		
            $this->db->where("u.user_first_name LIKE '%$search_key_val%'");	
       	}
		if($srh_user_id){
			$this->db->where("u.user_id","$srh_user_id");
		}
		if($group_id){
			$this->db->where("u.group_id","$group_id");
		}
		$this->db->where("u.user_status",1);
		if($start!='' && $length!=''){
            if($length>0) $this->db->limit($length,$start);
        }
		
	   $query = $this->db->get();
	   
	   //echo $this->db->last_query();
	   
     if($query->num_rows() >0)
     {
		
		if($num_rows){
			return $query->num_rows();
		}else{
       		return $query->result();
		}
     }
     else
     {
       return false;
     }

   }
   
      
    public function get_salary_list($start='',$length='',$search_key_val='',$srh_user_id='',$warehouse_id='',$srh_from_date='',$srh_to_date=''){
		//echo "warehouse_id:$warehouse_id";
        $this->db->select('salary.*,user.user_last_name,user.user_first_name,mstr_sal_type.mstr_sal_type_name');
        $this->db->join('user', 'salary.user_id = user.user_id');
        $this->db->join('mstr_sal_type', 'salary.mstr_sal_type_id = mstr_sal_type.mstr_sal_type_id');
		
		if($search_key_val){		
            $this->db->where("salary.warehouse_id = $warehouse_id AND (salary.reference_number LIKE '%$search_key_val%')");	
       	}
		if($srh_user_id){
			$this->db->where("user.user_id","$srh_user_id");
		}
		if($warehouse_id){
			$this->db->where("salary.warehouse_id","$warehouse_id");
		}
		if($srh_to_date){
			$srh_to_date=date('Y-m-d',strtotime($srh_to_date));
			$this->db->where("salary.sl_date <=",$srh_to_date);//("id !=",$id);
		}
		if($srh_from_date){
			$srh_from_date=date('Y-m-d',strtotime($srh_from_date));
			$this->db->where("salary.sl_date >=",$srh_from_date);//("id !=",$id);
		}
		if($start!='' && $length!=''){
            if($length>0) $this->db->limit($length,$start);
        }
		 $this->db->order_by('salary.sl_date','desc');
		 $this->db->order_by('salary.sl_id','desc');
        $query = $this->db->get($this->tableName);
		//echo $this->db->last_query();
        return $query->result_array();
    }
	
	public function get_salary_list_by_issue_card_id($issue_card_id){
		$this->db->select('salary.issue_card_id');
		if($issue_card_id){
			$this->db->where("salary.issue_card_id","$issue_card_id");
		}
		$query = $this->db->get($this->tableName);
		//echo $this->db->last_query();
		return $query->result_array();
	}
    
    public function get_salary_details($sal_id){
        $this->db->select('salary.*,mstr_sal_type.mstr_sal_type_name,mstr_sal_type.mstr_sal_type_did_add,user.user_first_name,ug.user_group_name');
        $this->db->join('user', 'salary.user_id = user.user_id');
        $this->db->join('user_group ug', 'user.group_id = ug.user_group_id', 'left');
        $this->db->join('mstr_sal_type', 'salary.mstr_sal_type_id = mstr_sal_type.mstr_sal_type_id');
        $this->db->where('sl_id', $sal_id);
        $query = $this->db->get($this->tableName);
        return $query->row_array();
    }
    
    public function save_salary($salary_id, $data){
        if (!$salary_id) {
//            echo 'addmodel';
            $this->db->insert($this->tableName, $data);
        } else {
//            echo 'edit_model';
            $this->db->where('sl_id', $salary_id);
            return $this->db->update($this->tableName, $data);
        }
    }
	
	public function save_salary_by_issue_card_id($issue_card_id, $data){
            $this->db->where('issue_card_id', $issue_card_id);
            return $this->db->update($this->tableName, $data);
    }
    
    public function delete_salary($id){
        $this->db->where('sl_id', $id);

        $this->db->delete($this->tableName);
    }
    
    public function get_max_reference(){
        
        $SQL = "SELECT reference_number FROM salary WHERE sl_id = (SELECT MAX(sl_id) FROM salary)";

        $query = $this->db->query($SQL);
        return $query->first_row('array');
        
        
    }
     public function get_salary_details_by_user($user_id='',$srh_from_date='',$srh_to_date=''){
        $this->db->select('salary.*,mstr_sal_type.mstr_sal_type_name,mstr_sal_type.mstr_sal_type_did_add,user.user_first_name,ug.user_group_name');
        $this->db->join('user', 'salary.user_id = user.user_id');
        $this->db->join('user_group ug', 'user.group_id = ug.user_group_id', 'left');
        $this->db->join('mstr_sal_type', 'salary.mstr_sal_type_id = mstr_sal_type.mstr_sal_type_id');
		if($srh_to_date){
			$srh_to_date=date('Y-m-d',strtotime($srh_to_date . "+1 days"));
			$this->db->where("salary.sal_date <=",$srh_to_date);//("id !=",$id);
		}
		if($srh_from_date){
			$srh_from_date=date('Y-m-d',strtotime($srh_from_date));
			$this->db->where("salary.sal_date >=",$srh_from_date);//("id !=",$id);
		}
        $this->db->where('user.user_id', $user_id);
        $query = $this->db->get($this->tableName);
        return $query->result('array');
    } 
	
		 public function get_salary_details_by_user_2($user_id,$srh_from_date='',$srh_to_date='') {
        $this->db->select('salary.*,SUM(salary.sl_amount) AS s_amount,mstr_sal_type.mstr_sal_type_name,mstr_sal_type.mstr_sal_type_did_add,user.user_first_name,ug.user_group_name');
        $this->db->join('user', 'salary.user_id = user.user_id');
        $this->db->join('user_group ug', 'user.group_id = ug.user_group_id', 'left');
        $this->db->join('mstr_sal_type', 'salary.mstr_sal_type_id = mstr_sal_type.mstr_sal_type_id');
        $this->db->group_by('mstr_sal_type.mstr_sal_type_id');
		if($srh_to_date){
			$srh_to_date=date('Y-m-d',strtotime($srh_to_date));
			$this->db->where("salary.sl_date <=",$srh_to_date);//("id !=",$id);
		}
		if($srh_from_date){
			$srh_from_date=date('Y-m-d',strtotime($srh_from_date));
			$this->db->where("salary.sl_date >=",$srh_from_date);//("id !=",$id);
		}
        $this->db->where('user.user_id', $user_id);
        $query = $this->db->get($this->tableName);
        return $query->result('array');
    } 
	
	public function get_salary_payment_details_by_user_id($user_id,$srh_from_date='',$srh_to_date='') {
        $this->db->select('sp.*,SUM(sp.sp_amount) AS tot_sp_amount');
		$this->db->from('salary_payment sp');
        $this->db->join('user u', 'sp.user_id = u.user_id');
       // $this->db->join('user_group ug', 'u.group_id = ug.user_group_id', 'left');
       // $this->db->group_by('mstr_sal_type.mstr_sal_type_id');
	   
	    $this->db->where('sp.sp_is_sal_advance',1);
        $this->db->where('u.user_id', $user_id);
		if($srh_to_date){
			$srh_to_date=date('Y-m-d',strtotime($srh_to_date));
			$this->db->where("sp.sp_date <=",$srh_to_date);//("id !=",$id);
		}
		if($srh_from_date){
			$srh_from_date=date('Y-m-d',strtotime($srh_from_date));
			$this->db->where("sp.sp_date >=",$srh_from_date);//("id !=",$id);
		}
        $query = $this->db->get();
		//echo $this->db->last_query();
        return $query->result('array');
    } 
	
	 public function get_salary_details_by_user_for_paysheet($user_id='',$srh_from_date='',$srh_to_date=''){
        $this->db->select('salary.reference_number,sum(salary.sl_amount) as sl_amount_sum,mstr_sal_type.mstr_sal_type_name,mstr_sal_type.mstr_sal_type_did_add,user.user_first_name,ug.user_group_name');
        $this->db->join('user', 'salary.user_id = user.user_id');
        $this->db->join('user_group ug', 'user.group_id = ug.user_group_id', 'left');
        $this->db->join('mstr_sal_type', 'salary.mstr_sal_type_id = mstr_sal_type.mstr_sal_type_id');
		if($srh_to_date){
			$srh_to_date=date('Y-m-d',strtotime($srh_to_date . "+1 days"));
			$this->db->where("salary.sal_date <=",$srh_to_date);//("id !=",$id);
		}
		if($srh_from_date){
			$srh_from_date=date('Y-m-d',strtotime($srh_from_date));
			$this->db->where("salary.sal_date >=",$srh_from_date);//("id !=",$id);
		}
        $this->db->where('user.user_id', $user_id);
		 $this->db->group_by('salary.mstr_sal_type_id', $user_id);
		
        $query = $this->db->get($this->tableName);
        return $query->result('array');
    }  
    
}