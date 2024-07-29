<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Product_Models extends CI_Model {

public function __construct()
   {
      parent::__construct();

   }

   function getUnit()
   {
     $this->db->select('*');
     $this->db->from('mstr_unit');
     $this->db->where('unit_status',1);
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

   function getTax()
   {
     $this->db->select('*');
     $this->db->from('tax_rates');
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

 function save_product($product_name,$product_code,$category,$subcategory,$unit,$product_cost,$product_price,$wholesale_price,$credit_salling_price,$tax,$alert_quty,$imgName,$imageThumb,$product_details,$product_part_no,$product_oem_part_number,$product_id)

   {

    

    $data1 = array(

       'cat_id'             	=> $category,

       'sub_cat_id'         	=> $subcategory,

       'product_name'        	=> $product_name,

      // 'product_code'			=> $product_code,

       'product_image'        	=> $imgName,

       'product_thumb' 			=> $imageThumb,

       'product_alert_qty'  	=> $alert_quty,

       'product_unit'  			=> $unit,

       'product_cost'  			=> $product_cost,

       'product_price'			=> $product_price,

       'wholesale_price'  		=> $wholesale_price,

       'credit_salling_price'  	=> $credit_salling_price,

       'tax'  					=> $tax,

       'product_details' 		=> $product_details,

		'product_part_no' => $product_part_no,
		'product_oem_part_number' => $product_oem_part_number
		//'product_id'=>$product_id

    );



    $data2 = array(

       'cat_id'         		=> $category,

       'sub_cat_id'         	=> $subcategory,

       'product_name'        	=> $product_name,

      // 'product_code'			=> $product_code,

       'product_alert_qty'  	=> $alert_quty,

       'product_unit'  			=> $unit,

       'product_cost'  			=> $product_cost,

       'product_price'			=> $product_price,

       'wholesale_price'  		=> $wholesale_price,

       'credit_salling_price'  	=> $credit_salling_price,

       'tax'  					=> $tax,

       'product_details' 		=> $product_details,
	   'product_part_no' => $product_part_no,
	   'product_oem_part_number' => $product_oem_part_number
	  // 'product_id'=>$product_id

    );



      if (!empty($imgName) && !empty($imageThumb)) {

        $data = $data1;

      }else{

        $data = $data2;

      }



     if($this->db->insert('product', $data))

     {
       $lst = $this->db->insert_id();
       $dta = $this->update_product_code($lst);
       return $dta;
     }

     else

     {

       return false;

     }

   }

   public function update_product_code($product_id='')
   {
      $data = array(
                     'product_code' => "PD".sprintf("%04d",$product_id)
                  );

      $this->db->where('product_id', $product_id);
      $this->db->update('product', $data); 
      return $product_id;
   }

   function getProducts()
   {
     $this->db->select('p.* , c.cat_name , s.sub_cat_name, u.unit_name');
     $this->db->from('product p');
	   $this->db->join('product_category c', 'c.cat_id = p.cat_id', 'left');   
	   $this->db->join('product_sub_category s', 's.sub_cat_id = p.sub_cat_id', 'left'); 
	   $this->db->join('mstr_unit u', 'u.unit_id = p.product_unit', 'left'); 
	   $this->db->order_by("p.added_time", "desc");
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

   function get_product_by_id($product_id='')
   {
     $this->db->select('p.*, c.cat_name, u.unit_name , t.*');
     $this->db->from('product p');
     $this->db->join('product_category c','p.cat_id = c.cat_id','left');
     $this->db->join('mstr_unit u','p.product_unit = u.unit_id','left');
     $this->db->join('tax_rates t','p.tax = t.id','left');
     $this->db->where('p.product_id',$product_id);
     $query = $this->db->get();  
     if($query->num_rows() >0)
     {
       return $query->row();
     }
     else
     {
       return false;
     }
   }

   function get_warehouse_product($product_id='')
   {
     $this->db->select("w.name ,w.code , wp.quantity");
     $this->db->from("warehouses_products wp");
     $this->db->join("warehouses w","wp.warehouse_id = w.id","left");
     $this->db->where("wp.product_id",$product_id);
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

   function get_subcategory()
   {
     $this->db->select('*');
     $this->db->from('product_sub_category');
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

    function update_product($prduct_id , $product_name,$product_code,$category,$subcategory,$unit,$product_cost,$product_price,$wholesale_price,$credit_salling_price,$tax,$alert_quty,$imgName,$imageThumb,$product_details,$product_part_no,$product_oem_part_number)

   {



    $data1 = array(

       'cat_id'             => $category,

       'sub_cat_id'           => $subcategory,

       'product_name'         => $product_name,

       'product_code'     => $product_code,

       'product_image'          => $imgName,

       'product_thumb'      => $imageThumb,

       'product_alert_qty'    => $alert_quty,

       'product_unit'       => $unit,

       'product_cost'       => $product_cost,

       'product_price'      => $product_price,

       'wholesale_price'      => $wholesale_price,

       'credit_salling_price'   => $credit_salling_price,

       'tax'            => $tax,

       'product_details'    => $product_details,
        'product_part_no' => $product_part_no,
		'product_oem_part_number' => $product_oem_part_number



    );



    $data2 = array(

       'cat_id'             => $category,

       'sub_cat_id'           => $subcategory,

       'product_name'         => $product_name,

       'product_code'     => $product_code,

       'product_alert_qty'    => $alert_quty,

       'product_unit'       => $unit,

       'product_cost'       => $product_cost,

       'product_price'      => $product_price,

       'wholesale_price'      => $wholesale_price,

       'credit_salling_price'   => $credit_salling_price,

       'tax'            => $tax,

       'product_details'    => $product_details,
	    'product_part_no' => $product_part_no,
		'product_oem_part_number' => $product_oem_part_number


    );



    ; 



      if (!empty($imgName) && !empty($imageThumb)) {

        $data = $data1;

      }else{

        $data = $data2;

      }



      $this->db->where('product_id', $prduct_id);

     if($this->db->update('product', $data))

     {

       return true;

     }

     else

     {

       return false;

     }


   }

public function delete_product($product_id='')
{
  if ($this->check_del($product_id)) {
       return false;
  } else {
      $this->db->delete('product', array('product_id' => $product_id));
      return true;
  }
  
}

function check_del($product_id='')
{
  $this->db->select('product_id');
  $this->db->from('purchase_items');
  $this->db->where('product_id',$product_id);
  $query = $this->db->get();
  if($query->num_rows() > 0)
  {
    return true;
  }
  else{

    return false;
  }

}

function get_item_qty($product_id='')
{
  $this->db->select('SUM(p.quantity) AS qty');
  $this->db->from('purchase_items p');
  $this->db->where('p.product_id',$product_id);
  $query = $this->db->get();
  if($query->result())
  {
    return $query->result();
  }
  else{

    return false;
  }
}

}
