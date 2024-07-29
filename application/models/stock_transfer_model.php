<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Stock_Transfer_Model extends CI_Model {
 
 
  
  function __construct() 
  {
    /* Call the Model constructor */
    parent::__construct();
     $this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));");
  }

	function save_trasfer_master($data)
	{
		 $this->db->insert('stock_transfer_master',$data);
		 return $this->db->insert_id();
	}
	function save_trasfer_item($data)
	{
		 $this->db->insert('stock_transfer_item',$data);
		 return $this->db->insert_id();
	}
	function get_list_trasfer() {
	    $this->db->select("s.*");
        $this->db->from('stock_transfer_master s');
        $this->db->order_by('s.stm_id','desc');
        $query = $this->db->get();
        return $query->result_array();
	}
	public function get_outlet_list()
	{
		$this->db->select("o.*");
        $this->db->from('outlet o');
        $this->db->where('o.outlet_status',1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
	}
		public function get_transfer_info($id)
	{
		$this->db->select("o.*,u.user_first_name,u.user_last_name,w.name,w.code");
        $this->db->from('stock_transfer_master o');
        $this->db->join("user u", "u.user_id = o.stm_by", "inner");
        $this->db->join("warehouses w", "w.id = o.stm_warehouse_id", "inner");
        $this->db->where('o.stm_id',$id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
	}
	function get_product_dynamic($search_key_val){
	    $this->db->select("p.*");
        $this->db->from('product p');
        $this->db->where("p.product_status = 1 AND  p.product_name LIKE '$search_key_val%'");
        $this->db->or_where("p.product_status = 1 AND  p.product_code LIKE '$search_key_val%'");
        $this->db->order_by('p.product_name','desc');
        $this->db->limit(10);
        $query = $this->db->get();
        return $query->result_array();
	}
	
		public function get_product_price_cost($id)
	{
		$this->db->select("p.*");
        $this->db->from('product p');
        $this->db->where('p.product_id',$id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
	}
	
		function get_trasfer_product_list($id){
	     $this->db->select("o.*,p.product_name,p.product_code,u.unit_code");
        $this->db->from('stock_transfer_item o');
        $this->db->join("product p", "p.product_id = o.product_id", "inner");
        $this->db->join("mstr_unit u", "u.unit_id = p.product_unit", "inner");
        $this->db->where('o.stm_id',$id);
        $query = $this->db->get();
        return $query->result_array();
	}
	 public function delete_trasfer_item($id){
	    if($id>0){
	       $this->db->where('sti_id', $id);
		return $this->db->delete('stock_transfer_item'); 
	    }else{
	        return false;
	    }
	}
	
	public function update_transfer_master($id,$data){
	     if($id>0){
	   	$this->db->where('stm_id', $id);
		return $this->db->update('stock_transfer_master',$data);
	     }else{
	        return false;
	    }
	}
		function get_transfer_list($start, $length, $search_key_val){
       	$this->db->select("o.*,u.user_first_name,u.user_last_name,w.name,w.code");
        $this->db->from('stock_transfer_master o');
        $this->db->join("user u", "u.user_id = o.stm_by", "inner");
        $this->db->join("warehouses w", "w.id = o.stm_warehouse_id", "inner");
        if ($search_key_val) {
             $this->db->where("o.stm_no LIKE '$search_key_val%'");
             $this->db->or_where("o.stm_ref_no LIKE '$search_key_val%'");
        }else{
    
        }
		$this->db->order_by("o.stm_id", "desc");
        if ($start != '' && $length != '') {
            $this->db->limit($length, $start);
            $query = $this->db->get();
            if ($query->num_rows() > 0) {
                return $query->result();
            } else {
                return false;
            }
        } else {
            $query = $this->db->get();
            if ($query->num_rows() > 0) {
                return $query->num_rows();
            } else {
                return false;
            }
        }
    }
	
	
	function get_transfer_list_with_code($code,$start, $length, $search_key_val){
       	$this->db->select("o.*,u.user_first_name,u.user_last_name,w.name,w.code");
        $this->db->from('stock_transfer_master o');
        $this->db->join("user u", "u.user_id = o.stm_by", "inner");
        $this->db->join("warehouses w", "w.id = o.stm_warehouse_id", "inner");
        if ($search_key_val) {
             $this->db->where("o.stm_to_id ='$code' AND o.stm_receved_status = 0 AND o.stm_no LIKE '$search_key_val%'");
             $this->db->or_where("o.stm_to_id ='$code' AND o.stm_receved_status = 0 AND  o.stm_ref_no LIKE '$search_key_val%'");
        }else{
            $this->db->where("o.stm_to_id ='$code' AND o.stm_receved_status = 0 ");
        }
		$this->db->order_by("o.stm_id", "desc");
        if ($start != '' && $length != '') {
            $this->db->limit($length, $start);
            $query = $this->db->get();
            if ($query->num_rows() > 0) {
                return $query->result();
            } else {
                return false;
            }
        } else {
            $query = $this->db->get();
            if ($query->num_rows() > 0) {
                return $query->num_rows();
            } else {
                return false;
            }
        }
    }
	
	function get_trasfer_product_list_api($id){
	    $this->db->select("o.*,p.product_name,p.product_code,u.unit_code,stm.stm_no,stm.stm_receved_status");
        $this->db->from('stock_transfer_item o');
        $this->db->join("stock_transfer_master stm", "stm.stm_id = o.stm_id", "inner");
        $this->db->join("product p", "p.product_id = o.product_id", "inner");
        $this->db->join("mstr_unit u", "u.unit_id = p.product_unit", "inner");
        $this->db->where('o.stm_id',$id);
        $query = $this->db->get();
        return $query->result();
	}
	
	
	
	
	function get_transfer_list_items($id){
	    $this->db->select("o.*,s.stm_warehouse_id");
        $this->db->from('stock_transfer_item o');
        $this->db->join("stock_transfer_master s", "s.stm_id = o.stm_id", "inner");
        $this->db->where('o.stm_id',$id);
        $query = $this->db->get();
        return $query->result_array();
	}
	
		function save_stock_lodge($data)
	{
		if ($data)
		{
			return $this->db->insert('stock_ledger',$data);
			//$id = $this->db->insert_id();
		//	return $id;
		}else{
		    return false;
		}
	}
	
	
	
	
	
	
	
	
	
	
	
	
	


	

	
	

	
	function get_order_item_price_cost($id)
	{
		$this->db->select("p.*");
        $this->db->from('order_items p');
        $this->db->where('p.odri_id',$id);
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
	}
	
	function get_order_total_values($id)
	{
		$this->db->select_sum("p.total_price");
		$this->db->select_sum("p.total_cost");
        $this->db->from('order_items p');
        $this->db->where('p.odr_id',$id);
        $query = $this->db->get();
        $result = $query->row_array();
        if(isset($result['total_cost'])){
            $return_data=array(
                'total_cost'=>$result['total_cost'],
                'total_price'=>$result['total_price']
                );
                return $return_data;
        }else{
            $return_data=array(
                'total_cost'=>0,
                'total_price'=>0
                );
                return $return_data;
        }
	}
	
	
	
	
	function get_order_product_list($id){
	     $this->db->select("o.*,p.product_name,p.product_code,u.unit_code");
        $this->db->from('order_items o');
        $this->db->join("product p", "p.product_id = o.product_id", "inner");
        $this->db->join("mstr_unit u", "u.unit_id = p.product_unit", "inner");
        $this->db->where('o.odr_id',$id);
        $this->db->order_by('o.odr_id','desc');
        $query = $this->db->get();
        return $query->result_array();
	}
	
	
		public function get_order_list_pp($id)
	{
		 $this->db->select("o.*,c.cus_code,c.cus_name,u.user_first_name,u.user_last_name,w.name,w.code");
        $this->db->from('order_master o');
        $this->db->join("customer c", "c.cus_id = o.odr_customer_id", "inner");
        $this->db->join("user u", "u.user_id = o.odr_sale_rep_id", "inner");
        $this->db->join("warehouses w", "w.id = o.odr_warehouse_id", "inner");
        $this->db->join('user ua', 'ua.user_id = p.approval_by', 'left'); 
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
	}

	function get_order_approval_pending_list($start, $length, $search_key_val){
       	$this->db->select("o.*,c.cus_code,c.cus_name,u.user_first_name,u.user_last_name,w.name,w.code,m.mas_name");
       	$this->db->select('ua.user_first_name AS approval_user_first_name ,ua.user_last_name AS approval_user_last_name');
        $this->db->from('order_master o');
        $this->db->join("customer c", "c.cus_id = o.odr_customer_id", "inner");
        $this->db->join("user u", "u.user_id = o.odr_sale_rep_id", "inner");
        $this->db->join("warehouses w", "w.id = o.odr_warehouse_id", "inner");
        $this->db->join('master_approval_status m', 'm.approval_status_id = o.odr_approval_status', 'inner');
        $this->db->join('user ua', 'ua.user_id = o.approval_by', 'left'); 
        if ($search_key_val) {
             $this->db->where("o.odr_approval_status = 0 AND o.odr_status = 1 AND o.odr_ref_no LIKE '$search_key_val%'");
             $this->db->or_where("o.odr_approval_status = 0 AND o.odr_status = 1 AND c.cus_name LIKE '$search_key_val%'");
        }else{
                $this->db->where("o.odr_approval_status = 0 AND o.odr_status = 1");
        }
		$this->db->order_by("o.odr_id", "desc");
        if ($start != '' && $length != '') {
            $this->db->limit($length, $start);
            $query = $this->db->get();
            if ($query->num_rows() > 0) {
                return $query->result();
            } else {
                return false;
            }
        } else {
            $query = $this->db->get();
            if ($query->num_rows() > 0) {
                return $query->num_rows();
            } else {
                return false;
            }
        }
    }
    function get_order_approved_pending_pickup_list()
    {
       	$this->db->select("o.*,c.cus_code,c.cus_name,u.user_first_name,u.user_last_name,w.name,w.code,m.mas_name");
       	$this->db->select('ua.user_first_name AS approval_user_first_name ,ua.user_last_name AS approval_user_last_name');
        $this->db->from('order_master o');
        $this->db->join("customer c", "c.cus_id = o.odr_customer_id", "inner");
        $this->db->join("user u", "u.user_id = o.odr_sale_rep_id", "inner");
        $this->db->join("warehouses w", "w.id = o.odr_warehouse_id", "inner");
        $this->db->join('master_approval_status m', 'm.approval_status_id = o.odr_approval_status', 'inner');
        $this->db->join('user ua', 'ua.user_id = o.approval_by', 'left'); 
        $this->db->where("o.odr_approval_status = 1 AND o.odr_status = 1 AND o.pickup_status = 0 ");
        $this->db->order_by("o.odr_priority", "asc");
		$this->db->order_by("o.odr_id", "asc");
        $query = $this->db->get();
        return $query->result();
    }
    function get_order_approved_pending_pickup_item_list(){
       $this->db->select("oi.*,p.product_name,p.product_code,u.unit_code");
        $this->db->from('order_items oi');
        $this->db->join("order_master o", "o.odr_id = oi.odr_id", "inner");
        $this->db->join("product p", "p.product_id = oi.product_id", "inner");
        $this->db->join("mstr_unit u", "u.unit_id = p.product_unit", "inner");
        $this->db->where("o.odr_approval_status = 1 AND o.odr_status = 1 AND o.pickup_status = 0 ");
        $this->db->order_by('o.odr_id','asc');
        $query = $this->db->get();
        return $query->result_array();
    }
     function get_order_approved_pending_pickup_products(){
       $this->db->select("oi.product_id");
        $this->db->from('order_items oi');
        $this->db->join("order_master o", "o.odr_id = oi.odr_id", "inner");
        $this->db->where("o.odr_approval_status = 1 AND o.odr_status = 1 AND o.pickup_status = 0 ");
        $this->db->group_by('oi.product_id');
        $query = $this->db->get();
        return $query->result_array();
    }
    function save_order_plan($data){
		 $this->db->insert('order_plan_master',$data);
		 return $this->db->insert_id();
	}
	function save_order_plan_item($data){
		 $this->db->insert('order_plan_item',$data);
		 return $this->db->insert_id();
	}
	 function get_order_plan_list($start, $length, $search_key_val){
        $this->db->select('p.*,m.mas_name');
        $this->db->select('u.user_first_name AS added_user_first_name ,u.user_last_name AS added_user_last_name');
        $this->db->select('ua.user_first_name AS approval_user_first_name ,ua.user_last_name AS approval_user_last_name');
        $this->db->from('order_plan_master p');
        $this->db->join('master_approval_status m', 'm.approval_status_id = p.opm_approval_status', 'inner');
        $this->db->join('user u', 'u.user_id = p.added_user_id', 'inner');
        $this->db->join('user ua', 'ua.user_id = p.approval_by', 'left'); 
        if ($search_key_val) {
             $this->db->where(" p.prm_ref_no LIKE '$search_key_val%'");
        }else{
    
        }
		$this->db->order_by("p.opm_id", "desc");
        if ($start != '' && $length != '') {
            $this->db->limit($length, $start);
            $query = $this->db->get();
            if ($query->num_rows() > 0) {
                return $query->result();
            } else {
                return false;
            }
        } else {
            $query = $this->db->get();
            if ($query->num_rows() > 0) {
                return $query->num_rows();
            } else {
                return false;
            }
        }
    }
     function get_order_approved_completed_pickup_list($id){
       	$this->db->select("o.*,c.cus_code,c.cus_name,u.user_first_name,u.user_last_name,w.name,w.code,m.mas_name,opm.opm_approval_status");
       	$this->db->select('ua.user_first_name AS approval_user_first_name ,ua.user_last_name AS approval_user_last_name');
        $this->db->from('order_plan_item opi');
        $this->db->join("order_plan_master opm", "opm.opm_id = opi.opm_id", "inner");
        $this->db->join("order_master o", "o.odr_id = opi.order_id", "inner");
        $this->db->join("customer c", "c.cus_id = o.odr_customer_id", "inner");
        $this->db->join("user u", "u.user_id = o.odr_sale_rep_id", "inner");
        $this->db->join("warehouses w", "w.id = o.odr_warehouse_id", "inner");
        $this->db->join('master_approval_status m', 'm.approval_status_id = o.odr_approval_status', 'inner');
        $this->db->join('user ua', 'ua.user_id = o.approval_by', 'left'); 
        $this->db->where("opi.opm_id",$id);
        $this->db->order_by("o.odr_priority", "asc");
		$this->db->order_by("o.odr_id", "asc");
        $query = $this->db->get();
        return $query->result();
    }
     public function get_order_approved_completed_pickup_item_list($id){
       $this->db->select("oi.*,p.product_name,p.product_code,u.unit_code");
        $this->db->from('order_items oi');
        $this->db->join("order_plan_item o", "o.order_id = oi.odr_id", "inner");
        $this->db->join("product p", "p.product_id = oi.product_id", "inner");
        $this->db->join("mstr_unit u", "u.unit_id = p.product_unit", "inner");
        $this->db->where("o.opm_id",$id);
        $this->db->order_by('o.order_id','asc');
        $query = $this->db->get();
        return $query->result_array();
    }
   
	 
	public function get_planned_order_list($id){
	    $this->db->select("o.*");
        $this->db->from('order_plan_item opi');
        $this->db->join("order_master o", "o.odr_id = opi.order_id", "inner");
        $this->db->where("opi.opm_id",$id);
       $this->db->group_by("o.odr_id");
        $query = $this->db->get();
        return $query->result_array();
	}
	 function get_planned_order_item_list($id){
       $this->db->select("oi.*,p.product_price,p.wholesale_price,p.credit_salling_price,p.product_weight,,p.product_cost,o.price_type_id");
        $this->db->from('order_items oi');
        $this->db->join("order_master o", "o.odr_id = oi.odr_id", "inner");
        $this->db->join("product p", "p.product_id = oi.product_id", "inner");
        $this->db->where("oi.odr_id",$id);
        $this->db->order_by('o.odr_id','asc');
        $query = $this->db->get();
        return $query->result_array();
    }
	 function save_dispach_note($data){
		 $this->db->insert('dispatch_note_master',$data);
		 return $this->db->insert_id();
	}
	function save_dispach_note_item($data){
		 $this->db->insert('dispatch_note_item',$data);
		 return $this->db->insert_id();
	}
	function get_order_plan_details($id){
        $this->db->select('p.*,m.mas_name');
        $this->db->select('u.user_first_name AS added_user_first_name ,u.user_last_name AS added_user_last_name');
        $this->db->select('ua.user_first_name AS approval_user_first_name ,ua.user_last_name AS approval_user_last_name');
        $this->db->from('order_plan_master p');
        $this->db->join('master_approval_status m', 'm.approval_status_id = p.opm_approval_status', 'inner');
        $this->db->join('user u', 'u.user_id = p.added_user_id', 'inner');
        $this->db->join('user ua', 'ua.user_id = p.approval_by', 'left'); 
        $this->db->where("p.opm_id",$id);
        $query = $this->db->get();
        return $query->row_array();
    }
    public function check_already_added($product_id,$odr_id){
        $this->db->from('order_items o');
        $this->db->where('o.product_id',$product_id);
        $this->db->where('o.odr_id',$odr_id);
        $query = $this->db->get();
        return $query->num_rows() ;
	}
    public function update_dispatch_note($id,$data){
	     if($id>0){
	   	$this->db->where('dpn_id', $id);
		return $this->db->update('dispatch_note_master',$data);
	     }else{
	        return false;
	    }
	}
	function get_loading_unloading_charge(){
	    $this->db->select("o.*");
        $this->db->from('loading_and_unloading_chagers o');
        $this->db->where('o.id',1);
        $query = $this->db->get();
        $result = $query->row_array();
        if(isset($result['unit_qty'])&&isset($result['charge'])){
           return $return_data=array('unit_qty'=>$result['unit_qty'],'charge'=>$result['charge']);
        }else{
            return $return_data=array('unit_qty'=>0,'charge'=>0);
        }
	}
	function check_product_batch_validation($id){
	    $this->db->from('product o');
        $this->db->where('o.product_id',$id);
        $this->db->where('o.is_batch_validate',1);
        $query = $this->db->get();
        return $query->num_rows() ;
	}
    function get_active_batch_list($product_id){
        $this->db->select("o.*");
        $this->db->from('batch_product o');
        $this->db->where('o.product_id',$product_id);
        $this->db->where('o.batch_status',1);
        $query = $this->db->get();
        return $query->result_array() ; 
    }
    function get_batch_details($id){
        $this->db->select("o.*");
        $this->db->from('batch_product o');
        $this->db->where('o.batch_id',$id);
        $query = $this->db->get();
        return $query->row_array() ; 
    }
    function check_batch_validation($id)
	{
		$this->db->from('order_items o');
        $this->db->where('o.odri_id',$id);
        $this->db->where('o.is_batch_validate',1);
        $query = $this->db->get();
        return $query->num_rows() ;
	}
	 function get_order_approved_qty($id)
	{
	    $this->db->select("o.approved_qty");
		$this->db->from('order_items o');
        $this->db->where('o.odri_id',$id);
        $query = $this->db->get();
        $result = $query->row_array() ;
        if(isset($result['approved_qty'])){
            return $result['approved_qty'];
        }else{
            return  0;
        }
	}
	
	function get_product_id($product_code){
        $this->db->select("p.product_id");
        $this->db->from('product p');
        $this->db->where('p.product_code',$product_code);
        $query = $this->db->get();
        $result= $query->row_array() ; 
        if(isset($result['product_id'])){
            return $result['product_id'];
        }
         else{
           return 0;
        }
    }
    
    
    //Added by namal
	function get_transfer_all_list_finish_goods($code,$start, $length){
	    
       	$this->db->select("o.*,u.user_first_name,u.user_last_name,w.name,w.code");
        $this->db->from('stock_transfer_master o');
        $this->db->join("user u", "u.user_id = o.stm_by", "inner");
        $this->db->join("warehouses w", "w.id = o.stm_warehouse_id", "inner");
        /*
        if ($search_key_val) {
             $this->db->where("o.stm_to_id ='$code' AND o.stm_receved_status = 0 AND o.stm_no LIKE '$search_key_val%'");
             $this->db->or_where("o.stm_to_id ='$code' AND o.stm_receved_status = 0 AND  o.stm_ref_no LIKE '$search_key_val%'");
        }else{
            $this->db->where("o.stm_to_id ='$code' AND o.stm_receved_status = 0 ");
        }
        */
        $this->db->where("o.stm_to_id ='$code' AND o.stm_receved_status = 0 ");
		$this->db->order_by("o.stm_id", "desc");
        if ($start != '' && $length != '') {
            $this->db->limit($length, $start);
            $query = $this->db->get();
            if ($query->num_rows() > 0) {
                return $query->result();
            } else {
                return false;
            }
        } else {
            $query = $this->db->get();
            if ($query->num_rows() > 0) {
                return $query->num_rows();
            } else {
                return false;
            }
        }
    }
	
	
	//Added by namal
	function get_transfer_all_list_row_meterial($code,$start, $length){

       	$this->db->select("o.*,u.user_first_name,u.user_last_name,w.name,w.code");
        $this->db->from('stock_m_transfer_master o');
        $this->db->join("user u", "u.user_id = o.stm_by", "inner");
        $this->db->join("warehouses w", "w.id = o.stm_warehouse_id", "inner");
        $this->db->where("o.stm_to_id ='$code' AND o.stm_receved_status = 0 AND o.stm_status = 1  ");
		$this->db->order_by("o.stm_id", "desc");
        if ($start != '' && $length != '') {
            $this->db->limit($length, $start);
            $query = $this->db->get();
            if ($query->num_rows() > 0) {
                return $query->result();
            } else {
                return false;
            }
        } else {
            $query = $this->db->get();
            if ($query->num_rows() > 0) {
                return $query->num_rows();
            } else {
                return false;
            }
        }
        
    }
	
	
}