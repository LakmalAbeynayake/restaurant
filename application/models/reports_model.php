<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reports_Model extends CI_Model {
  
  private $tableName = 'sales';
  
  function __construct() 
  {
    /* Call the Model constructor */
    parent::__construct();
  }
  
  function svc_get_categories(){
        $this->db->select('cat_id');    
		$this->db->from('product_category');
		$this->db->where('cat_id != 46 and cat_id != 47');
		$query=$this->db->get();
		return $query->result();
  }
  function svc_get_cat_products($cat_id){
        $this->db->select('product_id');    
		$this->db->from('product');
		$this->db->where('cat_id != 46 and cat_id != 47');
		$query=$this->db->get();
		return $query->result();
  }
  function svc_sale_items($from,$to,$product_id=''){
        $this->db->select('product_id,gross_total');    
		$this->db->from('sale_items si');
		$this->db->join('sales s','si.sale_id=s.sale_id','left');
		if($from){
		    $from=date('Y-m-d',strtotime($from));
			$this->db->where("date(s.sale_datetime) >=",$from);
		}
		if($to){
		    $to=date('Y-m-d',strtotime($to));
		    $this->db->where("date(s.sale_datetime) <=",$to);
		}
		if($product_id)
		    $this->db->where('si.product_id',$product_id);
		$query=$this->db->get();
		//echo $this->db->last_query();echo "<br><br>";
		return $query->result();
  }
  function svc_get_product_by_id($product_id)
   {
     $this->db->select('cat_id');
     $this->db->from('product p');
     $this->db->where('p.product_id',$product_id);
     $query = $this->db->get();  
     return $query->row();
   }
   
   function get_all_cashier_summery_list($start,$length,$search) {
		
		$this->db->select('cs.*,u.user_first_name,u.user_last_name,w.name');
		$this->db->from('cashier_float_master cs');
		$this->db->join('user u', 'cs.user_id = u.user_id', 'inner');
		$this->db->join('locations w', 'cs.warehouse_id = w.id', 'inner');
		if(isset($search['value']))
		if($search['value']){		
				$this->db->like('u.user_first_name', $search['value']);
				$this->db->or_like('u.user_last_name', $search['value']);
			}
		if($start!='' && $length!=''){
            $this->db->limit($length,$start);
			}
		$this->db->order_by("cs.c_f_m_date_time", "desc");		
		if($start!='' && $length!=''){
			$query=$this->db->get();
			return $query->result_array();            
		}else{
			$query = $this->db->get();
			return $query->num_rows();
		}
	}
	
	
}