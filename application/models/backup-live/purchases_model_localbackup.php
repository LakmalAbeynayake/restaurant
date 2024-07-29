<?php
 
class Purchases_Model extends CI_Model {
  
  
  function __construct() 
  {
    parent::__construct();
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

  public function add_grn_header($podate,$reference_no,$supplier,$discount,$powarehouse,$note,$grand_total,$total,$order_cal_des)
  {
    $data = array(
       'reference_no' => $reference_no ,
       'warehouse_id' => $powarehouse,
       'supplier_id'  => $supplier,
       'date'         => date('Y-m-d H:i', strtotime($podate)),
       'note'         => $note,
       'total'        => $total,
       'grand_total'  => $grand_total,
       'discount'     => $discount,
       'discount_cal' => $order_cal_des
    );

    if($this->db->insert('purchases', $data)){
      return $this->db->insert_id();
    }else{
      return false;
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
  public function getpurchases()
  {
     $this->db->select("s.*,spl.*, sp.sale_pymnt_amount, SUM(sp.sale_pymnt_amount) AS grn_total_paid");
     $this->db->from("purchases s");
     $this->db->join("sale_payments sp", "s.id = sp.sale_id AND sp.sale_payment_type ='grn'", "left"); 
     $this->db->join("supplier spl", "spl.supp_id = s.supplier_id", "left");
     $this->db->group_by("s.id");
     $this->db->order_by("s.reference_no", "desc");
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

  public function get_payment_by_id($purchase_id='')
  {
     $this->db->select('sp.*');
     $this->db->from('sale_payments sp');
     $this->db->where('sp.sale_id',$purchase_id);
     $this->db->where('sp.sale_payment_type','grn');
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

/* sanath start*/
  public function get_all_grn_for_report($srh_warehouse_id,$srh_to_date,$srh_from_date)
  {
     $this->db->select("s.*,spl.*, sp.sale_pymnt_amount, SUM(sp.sale_pymnt_amount) AS grn_total_paid");
     $this->db->from("purchases s");
     $this->db->join("sale_payments sp", "s.id = sp.sale_id AND sp.sale_payment_type ='grn'", "left"); 
     $this->db->join("supplier spl", "spl.supp_id = s.supplier_id", "left");
	 $this->db->join("warehouses w", "w.id = s.warehouse_id", "left");
	if($srh_warehouse_id){
			$this->db->where("s.warehouse_id",$srh_warehouse_id);//("id !=",$id);
	}
	if($srh_to_date){
		$this->db->where("s.date <=",$srh_to_date);//("id !=",$id);
	}
	if($srh_from_date){
		$this->db->where("s.date >=",$srh_from_date);//("id !=",$id);
	}	
     $this->db->group_by("s.id");
     $this->db->order_by("s.reference_no", "desc");
     $query = $this->db->get();  
     
     return $query->result_array();
  }

/* end sanath*/

}