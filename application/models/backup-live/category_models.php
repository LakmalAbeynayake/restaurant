<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class category_models extends CI_Model {



public function __construct()

   {

      parent::__construct();



   }



function category_save($category_code='', $category_name='', $category_image='', $imageThumb='')

{

 

    $data1 = array(

       'cat_name'         => $category_name,

       'cat_code'         => $category_code,

       'cat_image'        => $category_image,

       'cat_image_thumb'  => $imageThumb



    );



    $data2 = array(

       'cat_name'         => $category_name,

       'cat_code'         => $category_code,

       'cat_image_thumb'  => "no_image.png"

    );



      if (!empty($category_image) && !empty($imageThumb)) {

        $data = $data1;

      }else{

        $data = $data2;

      }



     if($this->db->insert('product_category', $data))

     {

       return true;

     }

     else

     {

       return false;

     }

}



public function getCategory()

{

     $this->db->select('*');

     $this->db->from('product_category');

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

function getSubCategory($value='')
{

     $this->db->select('*');
     $this->db->from('product_sub_category');
     $this->db->where('cat_id',$value);
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



function getCategory_by_id($category_id='')

{

  $this->db->select('*');

  $this->db->from('product_category');

  $this->db->where('cat_id',$category_id);

  $cat = $this->db->get();

  $ret = ( $cat->num_rows > 0 ) ? $cat->result() :false ;

  return $ret;

  

}



function category_update($category_tbl_id='',$cat_id='', $cat_name='', $imgName='', $imageThumb='',$sts='')

{

  $data1 = array(

                 'cat_code'         => $cat_id,

                 'cat_name'         => $cat_name,

                 'cat_image'        => $imgName,

                 'cat_image_thumb'  => $imageThumb

              );



  $data2 = array(

                 'cat_code'         => $cat_id,

                 'cat_name'         => $cat_name

              );



  if ($sts ==1) {

    $data3 = $data1;

  }else{

    $data3 = $data2;

  }



  $this->db->where('cat_id', $category_tbl_id);

   if($this->db->update('product_category', $data3))

   {

     return true;

   }

   else

   {

     return false;

   }



}



function category_change_status($category_tbl_id='',$status='')

{

  $cat_id = ($status ==0) ? 1 : 0 ;

  $data  = array(

                 'cat_status'  => $cat_id

              );



  $this->db->where('cat_id', $category_tbl_id);

   if($this->db->update('product_category', $data))

   {

     return true;

   }

   else

   {

     return false;

   }

}



function category_permanent_delete($category_id='')

{



  if ($this->get_sub_category($category_id) == true) {



      echo false;



  } else {

    

     $this->db->where('cat_id', $category_id);

     if($this->db->delete('product_category'))

     {

       return true;

     }

     else

     {

       return false;

     }

  }

  

}



//sub category module begin



function category_sub_save($parent_category='', $cat_code='', $cat_name ='')

{

     

    $data = array(

      'cat_id'        => $parent_category,

      'sub_cat_name'  => $cat_name,

      'sub_cat_code'  => $cat_code

                );



     if($this->db->insert('product_sub_category', $data))

     {

       return true;

     }

     else

     {

       return false;

     }



}



function get_sub_category($parent_cat_id='')

{

     $this->db->select('p.cat_name , s.*');

     $this->db->from('product_category p, product_sub_category s');

     $this->db->where('s.cat_id',$parent_cat_id);

     $this->db->where('p.cat_id = s.cat_id');

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



function get_sub_Category_by_id($sub_cat_id='')

{

     $this->db->select('*');

     $this->db->from('product_sub_category');

     $this->db->where('sub_cat_id',$sub_cat_id);

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



function sub_category_permanent_delete( $sub_category_id='' )

{



     $this->db->where('sub_cat_id', $sub_category_id );

     if($this->db->delete( 'product_sub_category' ))

     {

       return true;

     }

     else

     {

       return false;

     }

  

}



function sub_category_update($parent_category,$sub_category_tbl_id, $cat_code,$sub_cat_name)

{

  $data = array(

                 'cat_id'         => $parent_category,

                 'sub_cat_name'   => $sub_cat_name,

                 'sub_cat_code'   => $cat_code

              );



  $this->db->where('sub_cat_id', $sub_category_tbl_id);

   if($this->db->update('product_sub_category', $data))

   {

     return true;

   }

   else

   {

     return false;

   }

}



// sub category module end



}

