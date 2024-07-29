<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pos_Model extends CI_Model {

  function __construct() 
  {
    /* Call the Model constructor */
    parent::__construct();
  }

  public function get_product_by_cat_id($category_id='')
  {
     $this->db->select('product_id,product_name,product_code,product_thumb,cat_id,sub_cat_id');
     $this->db->from('product');
     $this->db->where('cat_id',$category_id);
     $this->db->where('product_status',1);
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

  public function get_all_category()
  {
     $this->db->select('*');
     $this->db->from('product_category');
     $this->db->where('cat_status',1);
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

   function get_sub_category_by_cat_id($category_id='')
   {
     $this->db->select('*');
     $this->db->from('product_sub_category');
     $this->db->where('cat_id',$category_id);
     $this->db->where('sub_cat_status',1);
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

   function get_product_by_cat_sub_id($category_id='',$sub_category_id ='')
   {
     $this->db->select('product_id,product_name,product_code,product_thumb,cat_id,sub_cat_id');
     $this->db->from('product');
     $this->db->where('cat_id',$category_id);
     $this->db->where('sub_cat_id',$sub_category_id);
     $this->db->where('product_status',1);
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

   function get_product_by_code($product_code,$customer_id,$warehouse_id)
   {
     $this->db->select('p.*');
     $this->db->from('product p');
     $this->db->like('p.product_name',$product_code); 
     $this->db->or_like('p.product_code',$product_code); 
     $this->db->or_like('p.product_part_no',$product_code); 
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

	function get_customer()
	{
	  $this->db->select('*');
	  $this->db->from('customer');
	  $this->db->where('cus_status',1);
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

	function get_warehouse()
	{
	  $this->db->select('*');
	  $this->db->from('warehouses');
	  $this->db->where('status',1);
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

	public function save_sale_header($sale_ref,$poswarehouse,$customer_id,$payment_note,$grand_total,$pos_discount_input,$discount,$paid_by)
	{
	    $data = array(
	       'sale_reference_no'   => $sale_ref,
	       'warehouse_id'   => $poswarehouse,
	       'customer_id'   => $customer_id,
	       'sale_note'   => $payment_note,
	       'sale_total'   => $grand_total,
	       'sale_inv_discount'   => $pos_discount_input,
	       'sale_inv_discount_amount'   => $discount,
	       'paid_by'   => $paid_by,
	    );

	    if($this->db->insert('sales', $data)){
	      return $this->db->insert_id();
	    }else{
	      return false;
	    }
	}
}