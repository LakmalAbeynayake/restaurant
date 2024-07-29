<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class salary_payment_model extends CI_Model{
    
    var $tableName = 'salary_payment';
    
    function __construct() {
        parent::__construct();
    }
    
    public function get_salary_payment_list($start='',$length='',$search_key_val='',$srh_user_id='',$warehouse_id='',$srh_from_date='',$srh_to_date=''){
        $this->db->select('salary_payment.*,user.user_last_name,user.user_first_name');
//        $this->db->select('salary_payment.*');
        $this->db->join('user', 'salary_payment.user_id = user.user_id');
//        $this->db->join('mstr_sal_type', 'salary_payment.mstr_sal_type_id = mstr_sal_type.mstr_sal_type_id');
		if($search_key_val){		
            $this->db->where("salary_payment.warehouse_id = $warehouse_id AND (user.user_first_name LIKE '%$search_key_val%')");	
       	}
		if($srh_user_id){
			$this->db->where("user.user_id","$srh_user_id");
		}
		if($warehouse_id){
			$this->db->where("salary_payment.warehouse_id","$warehouse_id");
		}
		if($srh_to_date){
			$srh_to_date=date('Y-m-d',strtotime($srh_to_date));
			$this->db->where("salary_payment.sp_date <=",$srh_to_date);//("id !=",$id);
		}
		if($srh_from_date){
			$srh_from_date=date('Y-m-d',strtotime($srh_from_date));
			$this->db->where("salary_payment.sp_date >=",$srh_from_date);//("id !=",$id);
		}
		if($start!='' && $length!=''){
            if($length>0) $this->db->limit($length,$start);
        }
		 $this->db->order_by('salary_payment.sp_date','desc');
		 $this->db->order_by('salary_payment.sp_id','desc');
        $query = $this->db->get($this->tableName);
		//echo $this->db->last_query();
        return $query->result_array();
    }
    
    public function get_salary_pay_details($sal_pay_id){
        $this->db->select('salary_payment.*,user.user_first_name,ug.user_group_name');
        $this->db->join('user', 'salary_payment.user_id = user.user_id');
        $this->db->join('user_group ug', 'user.group_id = ug.user_group_id', 'left');
        $this->db->where('sp_id', $sal_pay_id);
        $query = $this->db->get($this->tableName);
        return $query->row_array();
    }
    
    public function save_salary_payment($salary_pay_id, $data){
        if (!$salary_pay_id) {
//            echo 'addmodel';
            $this->db->insert($this->tableName, $data);
        } else {
//            echo 'edit_model';
            $this->db->where('sp_id', $salary_pay_id);
            return $this->db->update($this->tableName, $data);
        }
    }
    
    public function delete_salary_payment($id){
        $this->db->where('sp_id', $id);

        $this->db->delete($this->tableName);
    }
}