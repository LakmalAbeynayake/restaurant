<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Issue_Cards_Model extends CI_Model {
  
  private $tableName = 'issue_card';
  
  function __construct() 
  {
    /* Call the Model constructor */
    parent::__construct();
  }
  
  
  /*function get_last_payment_details_by_sales_id($sale_id)
	{
		
		
		$this->db->select('sale_payments.*,sales.sale_reference_no,customer.cus_name,user.user_first_name');
		$this->db->from('sale_payments');
		$this->db->join('sales','sale_payments.sale_id = sales.sale_id ','left');
		$this->db->join('customer','sales.customer_id = customer.cus_id','left');
		$this->db->join('user','sale_payments.user_id = user.user_id','left');
		
		$this->db->where('sale_payments.sale_id',$sale_id);
		$this->db->order_by("sale_pymnt_id", "desc");
		$this->db->limit(1,0);
		$query=$this->db->get();
	 	  return $query->row_array();
		
	}*/
  
  
  
 	public function delete_old_items_by_issue_card_id($issue_card_id)
	{
		$this->db->where('issue_card_id', $issue_card_id);
		$this->db->delete('issue_card_details');
	
	} 
  
 	public function delete_issue_card_item_by_issue_card_id_and_sale_id($issue_card_id,$sale_id)
	{
		$this->db->where('issue_card_id', $issue_card_id);
		$this->db->where('sale_id', $sale_id);
		$this->db->delete('issue_card_details');
	
	}   
  
  
  
  /*function get_all_sales_by_route_id($route_id)
	{
		$this->db->select('*');
		$this->db->from('sales');
		$this->db->where("route_id", $route_id);
		$query = $this->db->get();
		$data=array();
 
//$data[0] = 'SELECT'; 
foreach ($query->result() as $row)
{
$data[$row->sale_id] = $row->sale_total ; 
}
return ($data);
}*/
  
  
  
  function get_all_routes() {
		$this->db->select('*');
		$this->db->order_by("route_name", "desc");
		$this->db->where("route_id IS NOT NULL");//("id !=",$id);
		$query = $this->db->get('routes');
		return $query->result();
  }
  
  
  public function get_next_ref_no()
	{
	$this->db->select_max('issue_card_id');
	return $this->db->get('issue_card');	
	}
	
	public function get_sales_suggestion($term,$route_id='')
	{
	$this->db->select('sales.*');
	$this->db->where("sales.sale_manual_setlmnt_status","0");
	$this->db->where('sales.card_ref_number',$term);
	if($route_id){
		//$this->db->where('sales.route_id',$route_id);
	}
	$this->db->order_by('sale_reference_no','asc');
	
	$this->db->limit(10,0);
	$query=$this->db->get('sales');
	//echo $this->db->last_query();
	return $query->result_array();	
	
	//
	}
	
	
	public function get_return_sales_count_by_sales_id($sale_id)
	{
		$this->db->where('sale_id',$sale_id);
		$query = $this->db->get('sales_return');	
		return $query->num_rows();

		
	}
	
	
	
	
	
	
	
	public function get_all_sales_by_route_id($route_id)
	{
	$this->db->select('sales.sale_id,sales.sale_reference_no,sales.sale_total,SUM(sale_payments.sale_pymnt_amount) sale_pymnt_amount ');
	$this->db->from('sales');
	$this->db->join('sale_payments','sale_payments.sale_id = sales.sale_id ','left');	
	//$this->db->where('sales.sale_total > sale_pymnt_amount');
	$this->db->where('sales.route_id',$route_id);
	$this->db->group_by('sales.sale_id'); 
	$query = $this->db->get();
	return $query->result_array();  
	
	
	
	
	}
	
	
  
  

  
   public function get_all_issue_cards_for_report($start='',$length='',$search_key_val='',$location_id='',$route_id='',$srh_from_date='',$srh_to_date='',$collector_id='',$srh_invoice_date='')
  {
	  $this->db->select('s.sale_id,ic.*,u.user_first_name,r.route_name,s.card_ref_number,c.cus_name,s.rental_amount');
	  $this->db->from('issue_card_details icd');
	  $this->db->join('issue_card ic', 'ic.issue_card_id = icd.issue_card_id', 'left');
	  $this->db->join('sales s', 's.sale_id = icd.sale_id', 'left');
	  $this->db->join('user u','u.user_id=ic.collector_id','left');
	  $this->db->join('routes r','r.route_id=ic.route_id','left');
	  $this->db->join('customer c', 's.customer_id = c.cus_id', 'left');
	  if ($location_id){
		  $this->db->where('s.location_id', $location_id);
	  }
	  if ($route_id){
		  $this->db->where('ic.route_id', $route_id);
	  }
	  if ($collector_id){
		  $this->db->where('ic.collector_id', $collector_id);
	  }
	   if ($search_key_val){
		  $this->db->where('s.card_ref_number', $search_key_val);
	  }
	  
	if($srh_to_date){
	$srh_to_date = date('Y-m-d',strtotime($srh_to_date));
	$this->db->where("ic.issue_card_date <=",$srh_to_date);
	
	}
	if($srh_from_date){
	$srh_from_date = date('Y-m-d',strtotime($srh_from_date));
	$this->db->where("ic.issue_card_date >=",$srh_from_date);//("id !=",$id);
	}
	if($srh_invoice_date){
	$srh_from_date = date('Y-m-d',strtotime($srh_from_date));
	$this->db->where("date(s.sale_datetime) <=",$srh_from_date);//("id !=",$id);
	}
	
	
	
	
	
	  $this->db->order_by('ic.issue_card_id','desc');
	  
	  
	  if($start!='' && $length!=''){
            $this->db->limit($length,$start);
       }
		//$this->db->limit(5);
		$query=$this->db->get();
	  //echo $this->db->last_query();
	  return $query->result();	    
  }
  
  
    public function get_all_issue_cards_for_report_not_issued($start='',$length='',$search_key_val='',$location_id='',$route_id='',$srh_from_date='',$srh_to_date='',$collector_id='',$srh_invoice_date='')
  {
	
	
	$srh_invoice_date_q='';
	if($srh_invoice_date){
		$srh_invoice_date = date("Y-m-d", strtotime($srh_invoice_date));
		$srh_invoice_date_q=" AND (s.sale_datetime) <='$srh_invoice_date'";
	}
	//$srh_invoice_date_q='';
	
	$srh_from_date_q='';
	if($srh_from_date){
		$srh_from_date = date("Y-m-d", strtotime($srh_from_date));
		$srh_from_date_q=" AND (ic.issue_card_date) >='$srh_from_date'";
	}
	$srh_from_date_q='';
	
	$srh_to_date_q='';
	if($srh_to_date){
		$srh_to_date = date("Y-m-d", strtotime($srh_to_date));
		$srh_to_date_q=" AND ic.issue_card_date BETWEEN '$srh_from_date' AND '$srh_to_date'";
	}
	//$srh_to_date_q='';
	
	$route_id_q='';
	if($route_id){
		$route_id_q=" AND (s.route_id) ='$route_id'";
	}
	
	$search_key_val_q='';
	if($search_key_val){
		$route_id_q=" AND (s.card_ref_number) ='$search_key_val'";
	}
	
	 
	
	$limit='';
	
	//echo "start:$start , length:$length";
	if($start==0 && $length==-1){
		 // $limit="limit 10 , 0"; 
	   }
	else if($start!='' && $length!='')
	{
		$limit="limit $start , $length ";
           // $this->db->limit( $length , $start);
       }
	   
	  // $limit="limit 5";
	  
	//  echo "limit: $limit";
	
	 $query =$this->db->query("SELECT s.sale_id,s.issue_card_id,s.card_ref_number,c.cus_name,r.route_name,s.sale_total,SUM(p.sale_pymnt_amount) AS total_paid_amount
			 FROM   sales s
			 INNER JOIN customer c ON s.customer_id = c.cus_id
			 INNER JOIN routes r ON r.route_id=s.route_id
			INNER JOIN sale_payments p ON p.sale_id=s.sale_id
			 WHERE  NOT EXISTS
			 (SELECT icd.sale_id FROM issue_card_details icd 
			 INNER JOIN issue_card ic ON ic.issue_card_id = icd.issue_card_id
			  WHERE (s.sale_id = icd.sale_id $srh_from_date_q  $srh_to_date_q )) 
			  $srh_invoice_date_q  $route_id_q $search_key_val_q AND s.sale_manual_setlmnt_status=0
			 
			 GROUP BY (s.sale_id) $limit");
	
	//$this->db->where("s.sale_manual_setlmnt_status",0);
	//echo $this->db->last_query();
	
	 // $this->db->order_by('ic.issue_card_id','desc');
	  
	  
	  if($start!='' && $length!=''){
           // $this->db->limit($length,$start);
       }
		//$this->db->limit(5);
		//$query=$this->db->get();
	  //echo $this->db->last_query();
	  return $query->result();	    
  }
  
   public function get_all_issue_cards_item_for_report($start='',$length='',$search_key_val='',$srh_invoice_date='',$route_id='',$srh_from_date='',$srh_to_date='',$collector_id='')
  {
	  $this->db->select('s.sale_id,ic.*,u.user_first_name,r.route_name,s.card_ref_number,c.cus_name,s.rental_amount');
	  $this->db->from('issue_card_details icd');
	  $this->db->join('issue_card ic', 'ic.issue_card_id = icd.issue_card_id', 'left');
	  $this->db->join('sales s', 's.sale_id = icd.sale_id', 'left');
	  $this->db->join('user u','u.user_id=ic.collector_id','left');
	  $this->db->join('routes r','r.route_id=ic.route_id','left');
	  $this->db->join('customer c', 's.customer_id = c.cus_id', 'left');
	 
	  if ($route_id){
		  $this->db->where('ic.route_id', $route_id);
	  }
	  
	   if ($search_key_val){
		  $this->db->where('s.card_ref_number', $search_key_val);
	  }
	  
	if($srh_to_date){
	$srh_to_date = date('Y-m-d',strtotime($srh_to_date));
	$this->db->where("ic.issue_card_date <=",$srh_to_date);
	
	}
	if($srh_from_date){
	$srh_from_date = date('Y-m-d',strtotime($srh_from_date));
	$this->db->where("ic.issue_card_date >=",$srh_from_date);//("id !=",$id);
	}
	if($srh_invoice_date){
	$srh_from_date = date('Y-m-d',strtotime($srh_from_date));
	$this->db->where("date(s.sale_datetime) <=",$srh_from_date);//("id !=",$id);
	}
	  $this->db->order_by('ic.issue_card_id','desc');
	  
	  
	  if($start!='' && $length!=''){
            $this->db->limit($length,$start);
       }
		//$this->db->limit(5);
		$query=$this->db->get();
	  //echo $this->db->last_query();
	  return $query->result();	    
  }
  
  function save_issue_card($data,$issue_card_id=false)
	{
		if (!$issue_card_id)
		{
			$this->db->insert($this->tableName,$data);
		}else {
			$this->db->where('issue_card_id', $issue_card_id);
			return $this->db->update($this->tableName,$data);
		}
	}	
	
	//Sales item save
	function save_issue_card_item($data_item)
	{
			$this->db->insert('issue_card_details',$data_item);
	}	

	function get_issue_card_details_by_issue_card_id($issue_card_id)
	{	
		
		$this->db->select('issue_card.*,routes.route_name,routes.route_code,user.user_first_name');
		$this->db->from('issue_card');
		$this->db->join('routes','routes.route_id=issue_card.route_id','left');
		 $this->db->join('user','user.user_id=issue_card.collector_id','left');
		$this->db->where('issue_card_id',$issue_card_id);
		$query=$this->db->get();
		return $query->row_array();		
	}


	function get_issue_card_details_by_issue_card_id_for_cash_collect($issue_card_id)
	{	
		
		$this->db->select('issue_card.*,routes.route_name,user.user_first_name');
		$this->db->from('issue_card');
		$this->db->join('routes','routes.route_id=issue_card.route_id','left');
		 $this->db->join('user','user.user_id=issue_card.collector_id','left');
		//  $this->db->join('issue_card_details','issue_card_details.issue_card_id=issue_card.issue_card_id','left');
		$this->db->where('issue_card_id',$issue_card_id);
		$query=$this->db->get();
		return $query->row_array();		
	}	
	
	  public function get_all_issue_cards($start='',$length='',$search_key_val='',$warehouse_id='')
  {
	  $this->db->select('issue_card.*,user.user_first_name,routes.route_name');
	  $this->db->from('issue_card');
	  $this->db->join('user','user.user_id=issue_card.collector_id','left');
	  $this->db->join('routes','routes.route_id=issue_card.route_id','left');
	  if($warehouse_id){
			$this->db->where("issue_card.wharehouse_id",$warehouse_id);
		}
		 if($search_key_val){
            $this->db->where("issue_card.issue_card_ref_no LIKE '%$search_key_val%' OR routes.route_name LIKE '%$search_key_val%' OR user.user_first_name LIKE '%$search_key_val%'");
       	}
	  $this->db->order_by('issue_card.issue_card_id','desc');
	  if($start!='' && $length!=''){
		  
            if($length>0) $this->db->limit($length,$start);
        }
	  $query=$this->db->get();
	 // echo $this->db->last_query();
	  return $query->result_array();	    
  
  }
  
  	  public function get_all_issue_cards_details_by_id($issue_card_id='')
  {
	  $this->db->select('icd.*');
	  $this->db->from('issue_card_details icd');
	  $this->db->where('issue_card_id',$issue_card_id);
	//  $this->db->order_by('icd.issue_card_id','desc');
	  
	  $query=$this->db->get();
	 // echo $this->db->last_query();
	  return $query->result_array();	    
  
  }
	


	function get_issue_card_item_list_by_issue_card_id($issue_card_id)
	{
		$query=$this->db->query("SELECT c.cus_name,s.sale_total,s.sale_total,s.issue_card_status,s.term_amount,c.cus_name, s.card_ref_number,icd.*,SUM(sp.sale_pymnt_amount) sale_pymnt_amount FROM issue_card_details icd LEFT JOIN sales s ON s.sale_id = icd.sale_id 
		LEFT JOIN sale_payments sp ON icd.sale_id = sp.sale_id 
		LEFT JOIN customer c ON c.cus_id = s.customer_id
		WHERE icd.issue_card_id=$issue_card_id

	 GROUP BY s.sale_id   ORDER BY CAST(s.card_ref_number as unsigned)");
		//$query = $this->db->get();
		return $query->result_array();                                                                  
	}
	
	
	/*	
	function get_issue_card_item_list_by_issue_card_id($issue_card_id)
	{
		$this->db->select('s.sale_total,s.sale_total,s.issue_card_status,s.term_amount,s.card_ref_number,icd.* ,SUM(sp.sale_pymnt_amount) sale_pymnt_amount');
	 	$this->db->select('s.sale_reference_no ,s.card_ref_number');
		$this->db->from('issue_card_details icd');
		$this->db->join('sale_payments sp','icd.sale_id = sp.sale_id ','left');	
		$this->db->join('sales s','icd.sale_id = s.sale_id ','left');	
		//$this->db->join('customer c','c.cus_id = s.customer_id ','left');
		//$this->db->where('sp.sale_id = icd.sale_id');
		$this->db->where('icd.issue_card_id',$issue_card_id);
		//$this->db->order_by("icd.issue_card_detail_id", "desc");
		
		$this->db->group_by('s.sale_id');
		$this->db->order_by("s.card_ref_number", "desc");
		$query = $this->db->get();
		//ORDER BY CAST(`sales`.`card_ref_number` as unsigned)
		//error_reporting(0);
		//echo $this->db->last_query();
		return $query->result_array();                                                                  
	}
	
	*/
	
	
	
	function get_invoice_item_list_by_route_id($route_id)
	{
		$this->db->select('sales.sale_id,sales.sale_reference_no,sales.sale_total,sum(sale_payments.sale_pymnt_amount)');
		$this->db->from('sale_payments');
		$this->db->join('sales','sales.sale_id = sale_payments.sale_id ','left');	
		$this->db->where('route_id',$route_id);
		$this->db->group_by('sales.sale_id'); 
		$query = $this->db->get();
		return $query->result_array();                                                                  
	}
  
   public function get_all_issue_cards_summary_for_report($start='',$length='',$search_key_val='',$location_id='',$route_id='',$srh_from_date='',$srh_to_date='',$collector_id='',$rtn_count='',$srh_return_status_val='')
  {
	  $this->db->select('s.issue_card_status,ic.*,u.user_first_name,r.route_name');
	  $this->db->from('issue_card ic');
	  //$this->db->join('issue_card ic', 'ic.issue_card_id = icd.issue_card_id', 'left');
	  $this->db->join('sales s', 's.issue_card_id = ic.issue_card_id', 'left');
	  $this->db->join('user u','u.user_id=ic.collector_id','left');
	  $this->db->join('routes r','r.route_id=ic.route_id','left');
	  //$this->db->join('customer c', 's.customer_id = c.cus_id', 'left');
	 
	 if($srh_return_status_val){
	 $this->db->where('s.issue_card_status',$srh_return_status_val);
	 }
	  if ($route_id){
		  $this->db->where('ic.route_id', $route_id);
	  }
	  if ($collector_id){
		  $this->db->where('ic.collector_id', $collector_id);
	  }
	   if ($search_key_val){
		//  $this->db->where('s.card_ref_number', $search_key_val);
	  }
	  
	if($srh_to_date){
	$srh_to_date = date('Y-m-d',strtotime($srh_to_date));
	$this->db->where("ic.issue_card_date <=",$srh_to_date);
	
	}
	if($srh_from_date){
	$srh_from_date = date('Y-m-d',strtotime($srh_from_date));
	$this->db->where("ic.issue_card_date >=",$srh_from_date);//("id !=",$id);
	}
	$this->db->group_by('ic.issue_card_id'); 
	  $this->db->order_by('ic.issue_card_date','desc');
	  
	  

	   
	    if( $start!='' && $length!=''){
            if($length > 0)$this->db->limit($length,$start);
		}
		//$this->db->limit(5);
		$query=$this->db->get();
	 // echo $this->db->last_query();
	  if($rtn_count){
		  return  $query->num_rows();
	  }else{
	  	return $query->result();	 
	  }
  }
  
  
      public function get_not_paid_cards_summary($start='',$length='',$search_key_val='',$location_id='',$route_id='',$srh_from_date='',$srh_to_date='',$collector_id='',$srh_invoice_date='')
  {
	
	
	$srh_invoice_date_q='';
	if($srh_invoice_date){
		$srh_invoice_date = date("Y-m-d", strtotime($srh_invoice_date));
		$srh_invoice_date_q=" AND date(s.sale_datetime) <='$srh_invoice_date'";
	}
	//$srh_invoice_date_q='';
	
	$srh_from_date_q='';
	if($srh_from_date){
		$srh_from_date = date("Y-m-d", strtotime($srh_from_date));
		$srh_from_date_q=" AND date(sp.sale_pymnt_date_time) >='$srh_from_date'";
	}
	$srh_from_date_q='';
	
	$srh_to_date_q='';
	if($srh_to_date){
		$srh_to_date = date("Y-m-d", strtotime($srh_to_date));
		$srh_to_date_q=" AND date(sp.sale_pymnt_date_time) BETWEEN '$srh_from_date' AND '$srh_to_date'";
	}
	//$srh_to_date_q='';
	
	$route_id_q='';
	if($route_id){
		$route_id_q=" AND (s.route_id) ='$route_id'";
	}
	
	$search_key_val_q='';
	if($search_key_val){
		$route_id_q=" AND (s.card_ref_number) ='$search_key_val'";
	}
	
	 
	
	$limit='';
	
	//echo "start:$start , length:$length";
	if($start==0 && $length==-1){
		 // $limit="limit 10 , 0"; 
	   }
	else if($start!='' && $length!='')
	{
		$limit="limit $start , $length ";
           // $this->db->limit( $length , $start);
       }
	   
	  // $limit="limit 5";
	  
	//  echo "limit: $limit";
	
	
	
	 $query =$this->db->query("SELECT s.sale_id,s.issue_card_id,s.card_ref_number,c.cus_name,r.route_name,s.sale_total,SUM(p.sale_pymnt_amount) AS total_paid_amount
			 FROM   sales s
			 INNER JOIN customer c ON s.customer_id = c.cus_id
			 INNER JOIN routes r ON r.route_id=s.route_id
			  INNER JOIN sale_payments p ON p.sale_id=s.sale_id
			 WHERE  NOT EXISTS
			 (SELECT sp.sale_id FROM sale_payments sp 
			 WHERE (s.sale_id = sp.sale_id $srh_from_date_q  $srh_to_date_q )) 
			  $srh_invoice_date_q  $route_id_q $search_key_val_q AND s.sale_manual_setlmnt_status=0
			 
			 GROUP BY (s.sale_id) ORDER BY (s.card_ref_number) $limit");
	

/*
	 $query =$this->db->query("SELECT sp.sale_id FROM sale_payments sp 
	  INNER JOIN sales s ON s.sale_id=sp.sale_id 
			 WHERE (s.sale_id = sp.sale_id $srh_from_date_q  $srh_to_date_q ) 
			  $srh_invoice_date_q  $route_id_q $search_key_val_q AND s.sale_manual_setlmnt_status=0
			 
			");

	*/
	
	
	
	
	
	//$this->db->where("s.sale_manual_setlmnt_status",0);
	//echo $this->db->last_query();
	
	 // $this->db->order_by('ic.issue_card_id','desc');
	  
	  
	  if($start!='' && $length!=''){
           // $this->db->limit($length,$start);
       }
		//$this->db->limit(5);
		//$query=$this->db->get();
	 // echo $this->db->last_query();
	 // print_r($query->result());
	  foreach ($query->result() as $row){
		  if($row->sale_id=='12831'){
		 // echo "Sale id: $row->sale_id <br/>";
		  }
	  }
	  return $query->result();	    
  }

  public function check_payment_reserved_this_date_range ($srh_from_date,$srh_to_date,$sale_id){
	    $this->db->select('sp.*');
	    $this->db->from('sale_payments sp');
		$this->db->join('sales s','s.sale_id=sp.sale_id','left');
		$this->db->where("sp.sale_id", $sale_id);
		if($srh_to_date){
			$srh_to_date=date('Y-m-d',strtotime($srh_to_date));
			$this->db->where("date(sp.sale_pymnt_date_time)<=",$srh_to_date);//("id !=",$id);
		}
		if($srh_from_date){
			$srh_from_date=date('Y-m-d',strtotime($srh_from_date));
			$this->db->where("date(sp.sale_pymnt_date_time)>=",$srh_from_date);//("id !=",$id);
		}
		
		//$this->db->group_by("cr.issue_card_id");
		$query = $this->db->get();
		echo $this->db->last_query();
		return $query->result();
	  
  }  
  
  public function get_cash_reseving_des_by_issue_card_id($issue_card_id){
	    $this->db->select('SUM(cr.cr_amount) AS cr_amount_tot,SUM(cr.cr_expenses) AS cr_expenses_tot,SUM(cr.cr_no_of_code) AS cr_no_of_code_tot');
	    $this->db->from('cash_receiving cr');
		$this->db->join('issue_card ic','ic.issue_card_id=cr.issue_card_id','left');
		$this->db->where("cr.issue_card_id", $issue_card_id);
		$this->db->group_by("cr.issue_card_id");
		$query = $this->db->get();
		return $query->result();
	  
  }
}