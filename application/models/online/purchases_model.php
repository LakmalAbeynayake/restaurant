<?php
 
class Purchases_Model extends CI_Model {
  
  
  function __construct() 
  {
    parent::__construct();
  }


 function getPaymentsForPrint_grn($srh_warehouse_id='',$srh_to_date='',$srh_from_date='',$srh_type='',$srh_payment_term='',$ss_user_id='')
   {
	   $warehouse_id='';
	    $sel='p.*,pur.*,s.supp_company_name';
	   if($ss_user_id) $sel.=',u.user_first_name';
	   $this->db->select($sel);
       $this->db->from('sale_payments p');
	   $this->db->join('purchases pur', 'pur.id = p.sale_id', 'left');
	   $this->db->join('warehouses w', 'w.id = pur.warehouse_id', 'left');
	   $this->db->join('supplier s', 's.supp_id = pur.supplier_id', 'left');
	    if($ss_user_id) $this->db->join('user u', 'u.user_id = p.user_id', 'left');
	
		
	   if($srh_type){
	   
	   $this->db->where("p.sale_payment_type",$srh_type);//
	   }
	   if($srh_payment_term){
	   
	   $this->db->where("p.sale_pymnt_paying_by",$srh_payment_term);//
	   }
	    if($ss_user_id){
	   
	   $this->db->where("p.user_id",$ss_user_id);//
	   }
	   if($srh_warehouse_id){
	   
	   $this->db->where("pur.warehouse_id",$srh_warehouse_id);//
	   
	   }
		$this->db->where("p.sale_payment_type",'grn');
		
	   if($srh_to_date){
			$this->db->where("p.sale_pymnt_added_date_time <=",$srh_to_date);//("id !=",$id);
		}
		if($srh_from_date){
			$this->db->where("p.sale_pymnt_added_date_time >=",$srh_from_date);//("id !=",$id);
		}
	   $this->db->order_by("pur.id", "desc");
	  
	   $query = $this->db->get();
	   // echo $this->db->last_query();
     if($query->num_rows() >0)
     {
       return $query->result();
     }
     else
     {
       //return false;
     }

   }


 function getPaymentsForPrint_grn_return($srh_warehouse_id='',$srh_to_date='',$srh_from_date='',$srh_type='',$srh_payment_term='',$ss_user_id='')
   {
	   $warehouse_id='';
	    $sel='p.*,pur.*';
	   if($ss_user_id) $sel.=',u.user_first_name';
	   $this->db->select($sel);
       $this->db->from('sale_payments p');
	   $this->db->join('purchases pur', 'pur.id = p.sale_id', 'left');
	   $this->db->join('warehouses w', 'w.id = pur.warehouse_id', 'left');
	   //$this->db->join('customer c', 'c.cus_id = pur.customer_id', 'left');
	    if($ss_user_id) $this->db->join('user u', 'u.user_id = p.user_id', 'left');
	
		if($srh_type){
	   $this->db->where("p.sale_payment_type",$srh_type);//
	   }
	   if($srh_payment_term){
	   $this->db->where("p.sale_pymnt_paying_by",$srh_payment_term);//
	   }
	    if($ss_user_id){
	   $this->db->where("p.user_id",$ss_user_id);//
	   }
	   if($srh_warehouse_id){
	   	$this->db->where("pur.warehouse_id",$srh_warehouse_id);//
	   }


		$this->db->where("p.sale_payment_type",'grn_r');
		   
		   
	   
	   if($srh_to_date){
			$this->db->where("p.sale_pymnt_date_time <=",$srh_to_date);//("id !=",$id);
		}
		if($srh_from_date){
			$this->db->where("p.sale_pymnt_date_time >=",$srh_from_date);//("id !=",$id);
		}
	   $this->db->order_by("pur.id", "desc");
	  
	   $query = $this->db->get();
	   // echo $this->db->last_query();
     if($query->num_rows() >0)
     {
       return $query->result();
     }
     else
     {
       //return false;
     }

   }

  public function get_product_by_code($product_code = '')
  {
     $this->db->select('p.*');
     $this->db->from('product p');
     $this->db->like('p.product_name',$product_code); 
     $this->db->or_like('p.product_code',$product_code); 
     $this->db->limit('10');
     $query = $this->db->get();
   
     if($query->num_rows() >0)
     {
       return $query->result();
     }
     else
     {
       return false;
     }
  }
  
  	//get Purchased Qty By WarehouseId
	public function getPurchasedQtyByWarehouseId($warehouse_id,$product_id,$srh_from_date='',$srh_to_date='',$search_key_val='',$cat_srh='')
	{
		$this->db->select_sum('pi.quantity');
		$this->db->from('purchase_items pi');
		$this->db->join('purchases p', 'p.id = pi.purchase_id', 'left');
		$this->db->join("product pr", "pr.product_id = pi.product_id", "left");
		$this->db->join("product_category pc", "pr.cat_id = pc.cat_id", "left");
	  if($cat_srh){
	  $this->db->where("pc.cat_name",$cat_srh);
	  }
		
		if($search_key_val){
			 $this->db->where("pi.product_code LIKE '%$search_key_val%'","left");
		}
		
		//$this->db->where('p.warehouse_id',$warehouse_id);
		if($product_id)
		$this->db->where('pi.product_id',$product_id);
		
		
		if($srh_to_date){
			$srh_to_date=date('Y-m-d',strtotime($srh_to_date . ""));
		
		//echo $srh_to_date.'|';
			$this->db->where("p.date <=",$srh_to_date);//("id !=",$id);
		}
		if($srh_from_date){
			$this->db->where("p.date >=",$srh_from_date);//("id !=",$id);
		}
		$query=$this->db->get();
		//echo $this->db->last_query();
		//return $data['quantity']=$query->row()->quantity;
		
		if($query->num_rows() >0)
     {
       return $data['quantity']=$query->row()->quantity;
     }
     else
     {
       return 0;
     }
	}
	
		public function getReturnQtyByWarehouseId($warehouse_id,$product_id,$srh_from_date='',$srh_to_date='',$search_key_val='',$cat_srh='')
	{
		$this->db->select_sum('pi.quantity');
		$this->db->from('purchase_return_items pi');
		$this->db->join('purchases_return p', 'p.pr_id = pi.pr_id', 'left');
		$this->db->join('product pr','pi.product_id = pr.product_id');
		$this->db->join("product_category pc", "pr.cat_id = pc.cat_id", "left");
	  if($cat_srh){
	  $this->db->where("pc.cat_name",$cat_srh);
	  }
		if($search_key_val){
			 $this->db->where("pi.product_code LIKE '%$search_key_val%'","left");
		}
//		$this->db->where('p.warehouse_id',$warehouse_id);
		if($product_id)
		$this->db->where('pi.product_id',$product_id);
		if($srh_to_date){
//		$srh_to_date=date('Y-m-d',strtotime($srh_to_date . ""));	
			$this->db->where("p.date <=",$srh_to_date);//("id !=",$id);
		}
		if($srh_from_date){
			$this->db->where("p.date >=",$srh_from_date);//("id !=",$id);
		}
		$query=$this->db->get();
		//echo $this->db->last_query();
		//return $data['quantity']=$query->row()->quantity;
		if($query->num_rows() >0)
     {
       return $data['quantity']=$query->row()->quantity;
     }
     else
     {
       return 0;
     }
	}

  function get_tax_by_id($tax_id='')
  {
     $this->db->select('t.*');
     $this->db->from('tax_rates t');
     $this->db->where('t.id',$tax_id); 
     $query = $this->db->get();
   
     if($query->num_rows() >0)
     {
       return $query->result();
     }
     else
     {
       return false;
     }
  }

  public function get_warehouse()
  {
     $this->db->select('*');
     $this->db->from('warehouses');
     $query = $this->db->get();
     if($query->num_rows() >0)
     {
       return $query->result();
     }
     else
     {
       return false;
     }
  }

  public function get_supplier()
  {
     $this->db->select('*');
     $this->db->from('supplier');
     $query = $this->db->get();
     if($query->num_rows() >0)
     {
       return $query->result();
     }
     else
     {
       return false;
     }
  }

  public function add_grn_header($podate,$reference_no,$supplier,$discount,$powarehouse,$note,$grand_total,$total,$order_cal_des,$supp_invocie_no,$ref_id_nxt)
  {
    $data = array(
       'reference_no' => $reference_no ,
       'warehouse_id' => $powarehouse,
       'supplier_id'  => $supplier,
       'date'         => date('Y-m-d', strtotime($podate)),
       'note'         => $note,
       'total'        => $total,
       'grand_total'  => $grand_total,
       'discount'     => $discount,
       'discount_cal' => $order_cal_des,
	   'supp_invocie_no'=>$supp_invocie_no,
	   'warehouse_pur_id'=>$ref_id_nxt
    );

    if($this->db->insert('purchases', $data)){
      return $this->db->insert_id();
    }else{
      return false;
    }
  }
  
  
  public function add_grn_header_r($sale_id_r,$podate,$reference_no,$supplier,$discount,$powarehouse,$note,$grand_total,$total,$order_cal_des,$supp_invocie_no,$ref_id_nxt)
  {
    $data = array(
	   'purchase_id'  => $sale_id_r,
       'reference_no' => $reference_no,
       'warehouse_id' => $powarehouse,
       'supplier_id'  => $supplier,
       'date'         => date('Y-m-d', strtotime($podate)),
       'note'         => $note,
       'total'        => $total,
       'grand_total'  => $grand_total,
       'discount'     => $discount,
       'discount_cal' => $order_cal_des,
	   'supp_invocie_no'=>$supp_invocie_no,
	   'warehouse_pur_id'=>$ref_id_nxt
    );

    if($this->db->insert('purchases_return', $data)){
      return $this->db->insert_id();
    }else{
      return false;
    }
  }
  
  
  	//Sales item save
	function save_grn_item($data_item)
	{
			$this->db->insert('purchase_items',$data_item);
	}
	
	function save_grn($data_item,$grn_id=false)
	{
			
		if (!$grn_id)
		{
			$this->db->insert('purchases',$data_item);
		}else {
			$this->db->where('id', $grn_id);
			return $this->db->update('purchases',$data_item);
		}
	}

  public function add_grn_list_item( $product_id_array, $grn_header_id,$product_array, $product_name_array, $unit_cost_array, $quantity_array, $product_discount_array,$gross_total,$sub_total,$discount_cal)
  {
    $data = array(
       'purchase_id'  => $grn_header_id ,
       'product_id'   => $product_id_array,
       'product_code' => $product_array,
       'product_name' => $product_name_array,
       'quantity'     => $quantity_array,
       'unit_price'   => $unit_cost_array,
       'sub_total'    => $sub_total,
       'discount'     => $product_discount_array,
       'discount_cal' => $discount_cal
    );

    if($this->db->insert('purchase_items', $data)){
      return true;
    }else{
      return false;
    }
  }
  
  
  public function add_grn_list_item_r($sale_id_r, $product_id_array, $grn_header_id,$product_array, $product_name_array, $unit_cost_array, $quantity_array, $product_discount_array,$gross_total,$sub_total,$discount_cal)
  {
    $data = array(
       'purchase_id'  => $sale_id_r ,
	   'pr_id'  => $grn_header_id ,
       'product_id'   => $product_id_array,
       'product_code' => $product_array,
       'product_name' => $product_name_array,
       'quantity'     => $quantity_array,
       'unit_price'   => $unit_cost_array,
       'sub_total'    => $sub_total,
       'discount'     => $product_discount_array,
       'discount_cal' => $discount_cal
    );

    if($this->db->insert('purchase_return_items', $data)){
      return true;
    }else{
      return false;
    }
  }
  public function getpurchases($start,$length,$search_key_val)
  {
	$this->db->select("s.*,spl.*");//, sp.sale_pymnt_amount, SUM(sp.sale_pymnt_amount) AS grn_total_paid");
	$this->db->from("purchases s");
	$this->db->join("supplier spl", "spl.supp_id = s.supplier_id", "left");
//  if($search_key_val){
//		$this->db->join("sale_payments sp", "s.id = sp.sale_id AND sp.sale_payment_type ='grn'", "left");
//		}else
//	{
//	$this->db->join("sale_payments sp", "s.id = sp.sale_id", "left");
//	$this->db->where("sp.sale_payment_type","grn");
//	}
	if($search_key_val){
		$this->db->where("s.reference_no LIKE '%$search_key_val%' OR spl.supp_company_name LIKE '%$search_key_val%' OR s.supp_invocie_no LIKE '%$search_key_val%'");
	}

	if($start!='' && $length!=''){
		$this->db->limit($length,$start);
	}
	$this->db->group_by("s.id");
	$this->db->order_by("s.id","desc");
	$query = $this->db->get();
	
	$q = $this->db->last_query();
	
	//echo "{[".$q."]}";
//print_r($this->db->last_query());
//print_r($q->result_array());
	if($query->num_rows() >0)
	{
		return $query->result();
	}
	else
	{
	return false;
	}
  }
  
  
  public function getpurchasesforbalance($start='',$length='',$search_key_val='',$srh_supplier_id='',$srh_warehouse_id='',$srh_to_date='')
  {
	$this->db->select("s.*,spl.*");
	$this->db->from("purchases s");
	$this->db->join("supplier spl", "spl.supp_id = s.supplier_id", "left");
	//if($search_key_val){
//		$this->db->join("sale_payments sp", "s.id = sp.sale_id AND sp.sale_payment_type ='grn'", "left");
//		}else
	{
	//$this->db->join("sale_payments sp", "s.id = sp.sale_id", "left");
	//$this->db->where("sp.sale_payment_type","grn");
	}
	if($search_key_val){
		$this->db->where("s.reference_no LIKE '%$search_key_val%' OR spl.supp_company_name LIKE '%$search_key_val%'");
	}
	if($srh_warehouse_id){
		$this->db->where("s.warehouse_id",$srh_warehouse_id);//("id !=",$id);
	}
	if($srh_supplier_id){
		$this->db->where("s.supplier_id",$srh_supplier_id);//("id !=",$id);
	}
	if($srh_to_date){
		$this->db->where("s.date <=",$srh_to_date);//("id !=",$id);
	}
	if($start!='' && $length!=''){
		$this->db->limit($length,$start);
	}
	$this->db->group_by("s.id");
	$this->db->order_by("s.id","desc");
	$query = $this->db->get();
	
	$q = $this->db->last_query();
	
	//echo "{[".$q."]}";
	//print_r($this->db->last_query());
//print_r($q->result_array());

	if($query->num_rows() >0)
	{
		return $query->result();
	}
	else
	{
	return false;
	}
  }
  
public function get_no_of_return_purchases($id=''){
	
	$this->db->select("COUNT(purchase_id) AS count");
	$this->db->where("purchase_id",$id);
     //$this->db->group_by("s.id");
     //$this->db->order_by("s.reference_no", "desc");
	 
     $query = $this->db->get("purchases_return");  
	 
     if($query->num_rows() >0)
     {
       return $query->result();
     }
     else
     {

       return false;
     }
	}

    public function getpurchases_return($start,$length,$search_key_val,$srh_warehouse_id,$srh_to_date,$srh_supplier_id)
  {
     $this->db->select("s.*,spl.*, sp.sale_pymnt_amount, SUM(sp.sale_pymnt_amount) AS grn_total_paid");
     $this->db->from("purchases_return s");
     $this->db->join("sale_payments sp", "s.pr_id = sp.sale_id AND sp.sale_payment_type ='grn_r'", "left"); 
     $this->db->join("supplier spl", "spl.supp_id = s.supplier_id", "left");
	 
	if($srh_warehouse_id){
		$this->db->where("s.warehouse_id",$srh_warehouse_id);//("id !=",$id);
	}
	if($srh_supplier_id){
		$this->db->where("s.supplier_id",$srh_supplier_id);//("id !=",$id);
	}
	if($srh_to_date){
		$srh_to_date = date('Y-m-d',strtotime($srh_to_date));	
		$this->db->where("s.date <=",$srh_to_date);//("id !=",$id);
	}
	
	 if($search_key_val){
            $this->db->where("s.pr_id LIKE '%$search_key_val%' OR s.reference_no LIKE '%$search_key_val%' OR spl.supp_company_name LIKE '%$search_key_val%'");/*OR spl.supp_company_name LIKE '%$search_key_val%'*/
       	}
    /* $this->db->group_by("s.date");
     $this->db->order_by("s.date", "desc");
	 */
     $this->db->group_by("s.pr_id");
     $this->db->order_by("s.pr_id", "desc");
	 if($start!='' && $length!=''){
            $this->db->limit($length,$start);
        }
     $query = $this->db->get();  
	 
	 /*echo "{";
	 print_r($this->db->last_query());
	  echo "}";*/
	  
/*	  echo "{";
	 print_r($query->result());
	  echo "}";*/
	  
     if($query->num_rows() >0)
     {
       return $query->result();
     }
     else
     {

       //return false;
     }
  }

  public function getpurchases_by_id($po_id='')
  {
     $this->db->select("p.* , sp.*,wh.id as warehouse_id,wh.*");
     $this->db->from("purchases p");
     $this->db->join("supplier sp", " sp.supp_id = p.supplier_id", "left"); 
     $this->db->join("warehouses wh", " wh.id = p.warehouse_id", "left"); 
     $this->db->where("p.id",$po_id);
     $this->db->order_by("p.reference_no", "desc");
     $this->db->group_by("p.id");
     $query = $this->db->get();  
     if($query->num_rows() >0)
     {
       return $query->result();
     }
     else
     {
       return false;
     }
  }
  
   public function getpurchases_return_by_id($po_id='')
  {
     $this->db->select("p.* , sp.*,wh.id as warehouse_id,wh.*");
     $this->db->from("purchases_return p");
     $this->db->join("supplier sp", " sp.supp_id = p.supplier_id", "left"); 
     $this->db->join("warehouses wh", " wh.id = p.warehouse_id", "left"); 
     $this->db->where("p.pr_id",$po_id);
     $this->db->order_by("p.reference_no", "desc");
     $this->db->group_by("p.pr_id");
     $query = $this->db->get();  
     if($query->num_rows() >0)
     {
       return $query->result();
     }
     else
     {
       return false;
     }
  }

   public function get_purchases_return_quantity($po_id,$product_id)
  {
$query = $this->db->query('SELECT SUM(`quantity`) AS `quantity` FROM `purchase_return_items` WHERE `purchase_id` = '.$po_id.' AND `product_id` = '.$product_id.'');/*
     $this->db->select("SUM(quantity) as quantity");
     $this->db->from("purchase_return_items");
     $this->db->where("purchase_id = ".$po_id." AND product_id =".$product_id."");*/
     //$query = $this->db->get();
//
//	 print_r($this->db->last_query());
  
       return $query->result();
     
  }

  public function get_purchese_data_by_id($po_id='')
  {
     $this->db->select('*');
     $this->db->from('purchase_items');
     $this->db->where('purchase_items.purchase_id',$po_id);
     $query = $this->db->get();
     if($query->num_rows() >0)
     {
       return $query->result();
     }
     else
     {
       return false;
     }
  }
  
  
  public function get_purchese_return_data_by_id($po_id='')
  {
     $this->db->select('*');
     $this->db->from('purchase_return_items');
     $this->db->where('purchase_return_items.pr_id',$po_id);
     $query = $this->db->get();
	// print_r('<br><br><br><br><br>'.$this->db->last_query());
	 
     if($query->num_rows() >0)
     {
       return $query->result();
     }
     else
     {
       return false;
     }
  }

  public function get_payment_by_id($purchase_id='')
  {
     $this->db->select('sp.*,user.user_first_name,user_group.user_group_name');
     $this->db->from('sale_payments sp');
	 $this->db->join('user', 'sp.user_id = user.user_id', 'left');
	 $this->db->join('user_group', 'user.group_id = user_group.user_group_id', 'left');
     $this->db->where('sp.sale_id',$purchase_id);
     $this->db->where('sp.sale_payment_type','grn');
     $query = $this->db->get();
     return $query->result();

  }
  public function get_payment_by_id_r($purchase_id='')
  {
     $this->db->select('sp.*');
     $this->db->from('sale_payments sp');
     $this->db->where('sp.sale_id',$purchase_id);
     $this->db->where('sp.sale_payment_type','grn_r');
     $query = $this->db->get();
     return $query->result();

  }

  function grn_pay_total($purchase_id='')
  {
     $this->db->select('SUM(sp.sale_pymnt_amount) AS grn_paid_total');
     $this->db->from('sale_payments sp');
     $this->db->where('sp.sale_id',$purchase_id);
     $this->db->where('sp.sale_payment_type','grn');
     $query = $this->db->get();
     return $query->result();
  }
    function grn_pay_total_r($purchase_id='')
  {
     $this->db->select('SUM(sp.sale_pymnt_amount) AS grn_paid_total');
     $this->db->from('sale_payments sp');
     $this->db->where('sp.sale_id',$purchase_id);
     $this->db->where('sp.sale_payment_type','grn_r');
     $query = $this->db->get();
     return $query->result();
  }

/* sanath start*/
  public function get_all_grn_for_report($srh_warehouse_id,$srh_to_date,$srh_from_date,$from='',$to='',$srh_supplier_id)
  {
     $this->db->select("s.*,spl.*, sp.sale_pymnt_amount, SUM(sp.sale_pymnt_amount) AS grn_total_paid");
     $this->db->from("purchases s");
     $this->db->join("sale_payments sp", "s.id = sp.sale_id AND sp.sale_payment_type ='grn'", "left"); 
     $this->db->join("supplier spl", "spl.supp_id = s.supplier_id", "left");
	 $this->db->join("warehouses w", "w.id = s.warehouse_id", "left");
	if($srh_warehouse_id){
			$this->db->where("s.warehouse_id",$srh_warehouse_id);//("id !=",$id);
	}
	if($srh_supplier_id){
			$this->db->where("s.supplier_id",$srh_supplier_id);//("id !=",$id);
	}
	if($srh_to_date){
		$this->db->where("s.date <=",$srh_to_date);//("id !=",$id);
	}
	if($srh_from_date){
		$this->db->where("s.date >=",$srh_from_date);//("id !=",$id);
	}
	if($to){
		$this->db->limit($to,$from);
		}	
     $this->db->group_by("s.id");
     $this->db->order_by("s.id", "desc");
     $query = $this->db->get();  
    // echo $this->db->last_query();
     return $query->result_array();
  }

/* end sanath*/

/* begin lakmal */

//SELECT `quantity` FROM `purchase_items` WHERE `purchase_id` = 1 AND `product_id` = 4 

public function update_purchase_qty($purchase_id,$product_id,$quantity,$subtotal){
	$query =	$this->db->query('select `quantity`,`sub_total` FROM `purchase_items` where `purchase_id` = '.$purchase_id.' AND `product_id` = '.$product_id.'');

return $query->row_array();

	/*
	$q = $query->row_array();
	$g = $q['quantity'];
	$qty = $g-$q['sub_total'];
//	echo $g.'<br>'.$qty;
	$s = $q['sub_total'];
	$s = $s-$subtotal;
	$this->db->query('UPDATE `purchase_items` SET `quantity`='.$qty.',`sub_total` = '.$s.' WHERE `purchase_id`='.$purchase_id.' AND `product_id`= '.$product_id.'');
	*/
//	$query =	$this->db->query('select `quantity`,`sub_total` FROM `purchase_items` where `purchase_id` = '.$purchase_id.' AND `product_id` = '.$product_id.'');
	
	//$q = $query->row_array();
	
//	print_r($query->row_array());
	//echo $q['quantity'].'<br>'.$q['sub_total'];
//	print_r($q['quantity']);

	
	}
	
		public function get_return_amount($purchase_id){
		
	$query =	$this->db->query('select SUM(`grand_total`) AS sum FROM `purchases_return` where `purchase_id` =  '.$purchase_id.'');
	
	$total = $query->result_array();
	
	return $total;
/*	$total = $total['total'];
	$total = $total - $new_total;
	
	$this->db->query('update `purchases` SET `total` = '.$total.' , `grand_total` = '.$total.' where `id` = '.$purchase_id.'');
*/	
	}
	
	public function update_purchases_values($purchase_id,$new_total){
		
	$query =	$this->db->query('select `total`,`grand_total` FROM `purchases` where `id` =  '.$purchase_id.'');
	
	$total = $query->row_array();
	
	return $total;
/*	$total = $total['total'];
	$total = $total - $new_total;
	
	$this->db->query('update `purchases` SET `total` = '.$total.' , `grand_total` = '.$total.' where `id` = '.$purchase_id.'');
*/	
	}
	 public function getpurchases_for_balance($srh_warehouse_id,$srh_to_date,$srh_from_date,$srh_supplier_id,$start,$length)
	  {
		  
		/*if($search_key_val){
				$this->db->where("s.id LIKE '%$search_key_val%' OR s.reference_no LIKE '%$search_key_val%' OR spl.supp_company_name LIKE '%$search_key_val%'");
			}
		 if($start!='' && $length!=''){
				$this->db->limit($length,$start);
			}
		*/ 
	 $this->db->select("s.*,spl.*, sp.sale_pymnt_amount, SUM(sp.sale_pymnt_amount) AS grn_total_paid");
     $this->db->from("purchases s");
     $this->db->join("sale_payments sp", "s.id = sp.sale_id AND sp.sale_payment_type ='grn'", "left"); 
     $this->db->join("supplier spl", "spl.supp_id = s.supplier_id", "left");
	 $this->db->join("warehouses w", "w.id = s.warehouse_id", "left");
		if($srh_warehouse_id){
				$this->db->where("s.warehouse_id",$srh_warehouse_id);//("id !=",$id);
		}
		if($srh_supplier_id){
				$this->db->where("s.supplier_id",$srh_supplier_id);//("id !=",$id);
		}
		if($srh_to_date){
			$this->db->where("s.date <=",$srh_to_date);//("id !=",$id);
		}
		if($srh_from_date){
			$this->db->where("s.date >=",$srh_from_date);//("id !=",$id);
		}
		if($start!='' && $length!=''){
				$this->db->limit($length,$start);
			}
			
		 $this->db->group_by("s.id");
		 $this->db->order_by("s.reference_no", "desc");
		 $query = $this->db->get();  
    // echo $this->db->last_query();
     return $query->result_array();
	  }
	  
	  function get_all_sum_purchases_for_summery_report($srh_warehouse_id='',$srh_to_date='',$srh_from_date='',$sale_id='',$from='',$to='',$srh_supplier_id='') {
		
			
					$this->db->select('SUM(`grand_total`) as grand_total');
					$this->db->from('purchases');
					
				if($srh_warehouse_id){	
					$this->db->where("purchases.warehouse_id",$srh_warehouse_id);//("id !=",$id);
				}
				//echo $srh_supplier_id;
				if($srh_supplier_id){
						
					$this->db->where("purchases.supplier_id",$srh_supplier_id);//("id !=",$id);
				}
				
				if($srh_to_date){
					$srh_to_date = date('Y-m-d',strtotime($srh_to_date));
					$this->db->where("purchases.date <=",$srh_to_date);
			
				}
				if($srh_from_date){
					$srh_from_date = date('Y-m-d',strtotime($srh_from_date));
					$this->db->where("purchases.date >=",$srh_from_date);//("id !=",$id);
				}
					$query = $this->db->get();
					
					//print_r($this->db->last_query());
					//print_r($query->result_array());
					return $query->row_array();
				
	}	
	
	function get_all_sum_purchases_r_for_summery_report($srh_warehouse_id='',$srh_to_date='',$srh_from_date='',$sale_id='',$from='',$to='',$srh_supplier_id='') {
		
			
					$this->db->select('SUM(`grand_total`) as grand_total_r');
					$this->db->from('purchases_return');
					
				if($srh_warehouse_id){	
					$this->db->where("purchases_return.warehouse_id",$srh_warehouse_id);//("id !=",$id);
				}
				//echo $srh_supplier_id;
				if($srh_supplier_id){
						
					$this->db->where("purchases_return.supplier_id",$srh_supplier_id);//("id !=",$id);
				}
				
				if($srh_to_date){
					$srh_to_date = date('Y-m-d',strtotime($srh_to_date));
					$this->db->where("purchases_return.date <=",$srh_to_date);
			
				}
				if($srh_from_date){
					$srh_from_date = date('Y-m-d',strtotime($srh_from_date));
					$this->db->where("purchases_return.date >=",$srh_from_date);//("id !=",$id);
				}
					$query = $this->db->get();
					
					//print_r($this->db->last_query());
					//print_r($query->result_array());
					return $query->row_array();
				
	}	
	
	function getSumPaymentsForBalanceRep($srh_warehouse_id='',$srh_to_date='',$srh_from_date='',$srh_type='',$srh_payment_term='',$ss_user_id='',$srh_supplier_id='',$return_name='')
   {
		$warehouse_id='';
		$sel='SUM(p.sale_pymnt_amount) AS '.$return_name.'';
		if($ss_user_id) $sel.=',u.user_first_name';
			$this->db->select($sel);
			$this->db->from('sale_payments p');
			$this->db->join('purchases b', 'b.id = p.sale_id', 'left');
		if($ss_user_id) $this->db->join('user u', 'u.user_id = p.user_id', 'left');		
		if($srh_from_date){
			$this->db->where("p.sale_pymnt_added_date_time >=",$srh_from_date);//("id !=",$id);
		}
		if($srh_to_date){
			$srh_to_date=date('Y-m-d',strtotime($srh_to_date));
			$this->db->where("p.sale_pymnt_added_date_time <=",$srh_to_date);//("id !=",$id);
		}
		
		if($srh_type){
			$this->db->where("p.sale_payment_type",$srh_type);//
		}
		
		if($srh_payment_term){
			$this->db->where("p.sale_pymnt_paying_by",$srh_payment_term);//
		}
		
		//if($srh_type =='grn')$this->db->where("p.sale_pymnt_paying_by != 'Return_Cash'");
		
	   // if($ss_user_id){
	   
	   //$this->db->where("p.user_id",$ss_user_id);//
	   //}
	   
	if($srh_supplier_id)
		{
		$this->db->where("b.supplier_id",$srh_supplier_id);//	   
		}
		//else
		
		 if($srh_warehouse_id){
	   
	   $this->db->where("b.warehouse_id",$srh_warehouse_id);//
	   
	   }//else{
//	 	$this->session->userdata('ss_warehouse_id');
//		$warehouse_id =	$this->session->userdata('ss_warehouse_id');
//		
////		echo $warehouse_id;
//		$this->db->where("b.warehouse_id",$warehouse_id);
//		//		echo "INN";
//		}
		   
		   
	   /*
	   if($srh_to_date){
			$this->db->where("p.sale_pymnt_added_date_time <=",$srh_to_date);//("id !=",$id);
		}
		if($srh_from_date){
			$this->db->where("p.sale_pymnt_added_date_time >=",$srh_from_date);//("id !=",$id);
		}*/
//	   $this->db->order_by("b.sale_id", "desc");
	  
	   $query = $this->db->get();
	    //echo $this->db->last_query();
     if($query->num_rows() >0)
     {
       return $query->result();
     }
     else
     {
       //return false;
     }
  }
function getSumPurchasePaymentsForBalanceRep($srh_warehouse_id='',$srh_to_date='',$srh_from_date='',$srh_type='',$srh_payment_term='',$ss_user_id='',$srh_supplier_id='',$return_name='',$id='')
   {
	$warehouse_id='';
	$sel='SUM(p.sale_pymnt_amount) AS '.$return_name.' , MAX(DATE(sale_pymnt_added_date_time)) AS date_p';
	//	   if($ss_user_id) $sel.=',u.user_first_name';
	$this->db->select($sel);
	$this->db->from('sale_payments p');
	$this->db->join('purchases b', 'b.id = p.sale_id', 'left');
	if($ss_user_id) $this->db->join('user u', 'u.user_id = p.user_id', 'left');

	if($srh_from_date){
		$this->db->where("p.sale_pymnt_added_date_time >=",$srh_from_date);//("id !=",$id);
	}
	if($srh_to_date){
		$srh_to_date=date('Y-m-d',strtotime($srh_to_date));
		$this->db->where("p.sale_pymnt_added_date_time <=",$srh_to_date);//("id !=",$id);
	}
	
	if($srh_type){
		$this->db->where("p.sale_payment_type",$srh_type);//
	}
	
	//if($srh_type == 'grn'){
	//	$this->db->where("p.sale_pymnt_paying_by != 'Return_Cash'");//
	//}
	
	
	if($srh_payment_term){
		$this->db->where("p.sale_pymnt_paying_by",$srh_payment_term);//
	}
	   // if($ss_user_id){
	   //$this->db->where("p.user_id",$ss_user_id);//
	   //}
	   
	   if($id){
	   $this->db->where("b.id",$id);//
	   }
	   
	if($srh_supplier_id)
		{
		$this->db->where("b.supplier_id",$srh_supplier_id);//	   
		}
		else
		
		 if($srh_warehouse_id){
	   
	   $this->db->where("b.warehouse_id",$srh_warehouse_id);//
	   
	   }else{
	 	$this->session->userdata('ss_warehouse_id');
		$warehouse_id =	$this->session->userdata('ss_warehouse_id');
		
//		echo $warehouse_id;
		$this->db->where("b.warehouse_id",$warehouse_id);
		//		echo "INN";
		}
		   
		   
	   /*
	   if($srh_to_date){
			$this->db->where("p.sale_pymnt_added_date_time <=",$srh_to_date);//("id !=",$id);
		}
		if($srh_from_date){
			$this->db->where("p.sale_pymnt_added_date_time >=",$srh_from_date);//("id !=",$id);
		}*/
//	   $this->db->order_by("b.sale_id", "desc");
	  
	   $query = $this->db->get();
//	    echo $this->db->last_query();
     if($query->num_rows() >0)
     {
       return $query->result();
     }
     else
     {
       //return false;
     }

   }
   
   public function date_reset(){
	
	$this->db->select("sale_pymnt_id,sale_pymnt_added_date_time");
	$result = $this->db->get("sale_payments");	
	
	return $result->result_array();
	
	}
	
	public function update_date($id,$date){
		$date = date('Y-m-d 00:00:00',strtotime($date));
		print_r($date);
		echo "<br>";
		$this->db->query("UPDATE `sale_payments` SET `sale_pymnt_added_date_time` = '".$date."' WHERE `sale_pymnt_id` = ".$id);

	}

function delete_purchases($id){

$query =    $this->db->query('DELETE FROM `sale_payments` WHERE `sale_id` = '.$id.' AND `sale_payment_type`= "grn" ');
//		$sale_id = $this->input->get('sale_id');

$query =    $this->db->query('DELETE FROM `purchase_items` WHERE `purchase_id` = '.$id.'');

$query =	$this->db->query('DELETE FROM `purchases` WHERE `id` = '.$id.'');
	//	print_r($query->result());
		//print_r($query->result());

		//print_r($query->result());
//return $query->result_array();

}
		
function delete_payments($sale_id,$in_type){

	$this->db->query('DELETE FROM `sale_payments` WHERE `sale_id` = '.$sale_id.' AND `sale_payment_type` = "'.$in_type.'" ');

}


function purchases_pymnts_delete_by_id($sp_id){

	$this->db->query('DELETE FROM `sale_payments` WHERE `sale_pymnt_id` = '.$sp_id.'');

}

function delete_purchases_r($id){

	$this->db->trans_start();
	$this->db->query('DELETE FROM `sale_payments` WHERE `sale_id` = '.$id.' AND `sale_payment_type`= "grn_r" ');
	$this->db->query('DELETE FROM `purchase_return_items` WHERE `pr_id` = '.$id.'');
	$this->db->query('DELETE FROM `purchases_return` WHERE `pr_id` = '.$id.'');
	$this->db->trans_complete();
	
	if ($this->db->trans_status() === FALSE)
	{
		return 0;
			// generate an error... or use the log_message() function to log your error
	}
	else return 1;

}

public function getpurchasesitems($start='',$length='',$search_key_val='')
  {
     $this->db->select("p.id,p.date,p.reference_no,pi.product_name,pi.product_code,spl.supp_company_name");
     $this->db->from("purchase_items pi");
	 $this->db->join("purchases p","pi.purchase_id = p.id");
     $this->db->join("supplier spl", "spl.supp_id = p.supplier_id", "left");

	 if($search_key_val){
			$this->db->where("	      spl.supp_company_name LIKE '%$search_key_val%' 
								OR  	p.reference_no LIKE '%$search_key_val%' 
								OR  	pi.product_code LIKE '%$search_key_val%'
			");
		}
		if($start!='' && $length!=''){
			$this->db->limit($length,$start);
		}
	 
     $this->db->order_by("p.reference_no", "desc");
     $query = $this->db->get();  
     if($query->num_rows() >0)
     {
       return $query->result();
     }
     else
     {

       return false;
     }
  }
   
}
