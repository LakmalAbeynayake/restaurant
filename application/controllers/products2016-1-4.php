<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Products extends CI_Controller {

    var $main_menu_name = "products";
	var $sub_menu_name = "products";

    public function __construct()
     {
            parent::__construct();
            $this->load->model('category_models');
            $this->load->model('product_models');
			$this->load->model('common_model');

     }

    public function index()
	{
		$data['main_menu_name'] = $this->main_menu_name;
		$data['sub_menu_name'] = $this->sub_menu_name;
		$this->load->view('products',$data);
	}

	public function add_product()
	{
		$data['main_menu_name'] = $this->main_menu_name;
		$data['sub_menu_name'] 	= 'add_products';
		$data['main_category'] 	= $this->category_models->getCategory();
		$data['unit_type'] 		= $this->product_models->getUnit();
		$data['tax'] 		    = $this->product_models->getTax();
		$this->load->view('add_product',$data);
	}

	public function get_sub_category_by_id()
	{
		$parent_category =  $this->input->get('category_id');

		if ( $parent_category ) {
			$val = $this->category_models->get_sub_category( $this->input->get('category_id') );
			if (!empty($val)) {
				echo '<select name="subcategory" id="subcategory" class="form-control search-select">';
				echo "<option value=''></option>";
				foreach ($val as $key => $lst) {
				echo "<option value='$lst->sub_cat_id'>$lst->sub_cat_name</option>";
				}
				echo '</select>';
			}
			
		} else {
			echo NULL;
		}
		
	}

	public function save_product()
	{
        $this->load->library('form_validation'); //form validation lib
        $this->form_validation->set_rules('product_name', 'Product Name', 'required');
        $this->form_validation->set_rules('product_code', 'Product Code', 'required|is_unique[product.product_code]');
        $this->form_validation->set_rules('product_cost', 'product cost', 'required');
        $this->form_validation->set_rules('product_price', 'product price', 'required');
        $this->form_validation->set_rules('wholesale_price', 'wholesale price', 'required');
        $this->form_validation->set_rules('credit_salling_price', 'credit salling price', 'required');
        $this->form_validation->set_rules('alert_quty', 'alert quty', 'required');



        if ($this->form_validation->run() == FALSE)
        {
           $st = array('status' =>0,'validation' => validation_errors());
           echo json_encode($st);
        }
        else
        {
        	$product_name 			= $this->input->post('product_name');
        	$product_code 			= $this->input->post('product_code');
        	$category 	  			= $this->input->post('category');
        	$subcategory  			= $this->input->post('subcategory');
        	$unit 		  			= $this->input->post('unit');
        	$product_cost 			= $this->price_filter($this->input->post('product_cost'));
        	$product_price 			= $this->price_filter($this->input->post('product_price'));
        	$wholesale_price 		= $this->price_filter($this->input->post('wholesale_price'));
        	$credit_salling_price 	= $this->price_filter($this->input->post('credit_salling_price'));
        	$tax 					= $this->input->post('tax');
        	$alert_quty 			= $this->input->post('alert_quty');
        	//$image_name 			= $this->input->post('product_image');
        	$product_details 		= $this->input->post('product_details');
			$product_part_no 		= $this->input->post('product_part_no');
			$product_oem_part_number=$this->input->post('product_oem_part_number');
			$product_id=$this->input->post('product_id');

        	if (!empty($_FILES["userfile"]['name'])) {

                $image_name_enc = "PRODUCT_".time().$_FILES["userfile"]['name'];
                $this->load->library('upload',$this->image_manipulation->image_config($image_name_enc));

                if ( ! $this->upload->do_upload()){

                   $st = array('status' =>0,'validation' => $this->upload->display_errors());
                   echo json_encode($st);
                }
                else{

                    $this->load->library('image_lib',$this->image_manipulation->image_thumb($image_name_enc,100,100));
                    if ( ! $this->image_lib->resize())
                    {
                        echo $this->image_lib->display_errors();
                    }
                    else
                    {
                        $imgName    = $this->upload->data();
                        $imageThumb = $imgName['raw_name']."_thumb".$imgName['file_ext'];

                       if ($this->product_models->save_product($product_name,$product_code,$category,$subcategory,$unit,$product_cost,$product_price,$wholesale_price,$credit_salling_price,$tax,$alert_quty,$imgName['file_name'],$imageThumb,$product_details,$product_part_no,$product_oem_part_number,$product_id)) {

                               $st = array('status' =>1,'validation' =>'Done!');
                               echo json_encode($st);

                       } else {

                               $st = array('status' =>0,'validation' =>'error occurred please contact your system administrator');
                               echo json_encode($st);
                       }
                       $this->image_lib->clear();
                    }                  

                }

        	} else {
                       if ($this->product_models->save_product($product_name,$product_code,$category,$subcategory,$unit,$product_cost,$product_price,$wholesale_price,$credit_salling_price,$tax,$alert_quty,NULL,NULL,$product_details,$product_part_no,$product_oem_part_number,$product_id)) {

                               $st = array('status' =>1,'validation' =>'Done!');
                               echo json_encode($st);

                       } else {

                               $st = array('status' =>0,'validation' =>'error occurred please contact your system administrator');
                               echo json_encode($st);
                       }
        	}
        	
        }

	}

	function price_filter($amount='')
	{
		$s = explode("Rs.",$amount);
		return str_replace(',', '', $s[1]);
	}

	public function get_list_product($value='')
	{
	        $values = $this->product_models->getProducts();
	        $data = array();

	        if (!empty($values)) {
	            foreach ($values as $products) {

	            if ($products->product_status == 0) {$k = "btn-warning";$m = "fa-minus-circle";} else {$k = "btn-green";$m = "fa-check";}
              $retVal = (empty($products->sub_cat_name)) ? "--:--" : $products->sub_cat_name ;
              $qty = $this->product_models->get_item_qty($products->product_id);
              $qty = (empty($qty[0]->qty)) ? "--:--" : $qty[0]->qty ;
	            $row = array();
                  $row[] = '<div style="margin-bottom: 0px; width: 50px; height: 50px;" class="fileupload-new thumbnail"><img alt="" src="'.asset_url()."uploads/thumbs/".$products->product_thumb.'"></div>';
                  $row[] = $products->product_code;
                  $row[] = $products->product_oem_part_number;
                  $row[] = $products->product_part_no;
	                $row[] = $products->product_name;
	                $row[] = $products->cat_name;
	                $row[] = $retVal;
	                $row[] = $products->product_cost;
	                $row[] = $products->product_price;
	                $row[] = $qty;
	                $row[] = $products->unit_name;
	                $row[] = $products->product_alert_qty;
	                $row[] = '<div class="btn-group text-left">
                            <button data-toggle="dropdown" class="btn btn-default btn-xs btn-primary dropdown-toggle" type="button">Actions <span class="caret"></span></button>
                            <ul role="menu" class="dropdown-menu pull-right">
                            <li><a href="'.base_url('products/view').'/'.$products->product_id.'"><i class="fa fa-file-text-o"></i> Product Details</a></li>
                            <li><a href="'.base_url('products/edit').'/'.$products->product_id.'"><i class="fa fa-edit"></i> Edit Product</a></li>
                            <li><a onclick=" print_barcode('.$products->product_id.'); return false;" href="#"><i class="fa fa-print"></i> Print Barcode</a></li>
                            <li class="divider"></li><li><a onclick="product_delete('.$products->product_id.'); return false;" href="#"><i class="fa fa-trash-o"></i> Delete Product</a></li>
                            </ul></div>';
	                $data[] = $row;
	            }

	            $output = array('data' =>$data);
	            echo json_encode($output);
	        }else{
	            $output = array('data' =>'');
	            echo json_encode($output);

	        }
	   }

  public function view($product_id = "")
  { 

    $sd = $this->product_models->get_product_by_id($product_id);

    if(!empty($sd)){

          $data['product_details'] = $this->product_models->get_product_by_id($product_id);
          $data['warehouses'] = $this->product_models->get_warehouse_product($product_id);
          $data['main_menu_name'] = $this->main_menu_name;
          $data['sub_menu_name'] = $this->sub_menu_name;
          $this->load->view('view_product',$data);

    }else{

          show_404();

    }

  }

  public function edit($product_id='')
  {
          $data['main_menu_name'] = $this->main_menu_name;
          $data['sub_menu_name']  = $this->sub_menu_name;
          $data['main_category']  = $this->category_models->getCategory();
          $data['unit_type']      = $this->product_models->getUnit();
          $data['tax']            = $this->product_models->getTax();
          $data['product_details'] = $this->product_models->get_product_by_id($product_id);
          $data['sub_category']   = $this->category_models->getSubCategory($data['product_details']->cat_id);
          $this->load->view('edit_product',$data);
  }

  public function single_barcode($product_id='')
  {
    $data['product_details'] = $this->product_models->get_product_by_id($product_id);
    $this->load->view('barcode/product_barcode',$data);
  }

    function gen_barcode($product_code = NULL, $height = 80)
    {
      if($this->input->get('code')){ $product_code = $this->input->get('code'); }
      if($this->input->get('height')){ $height = $this->input->get('height'); }
    
    //load library
    $this->load->library('zend');
    //load in folder Zend
    $this->zend->load('Zend/Barcode');
    //'drawText' => FALSE
    $barcodeOptions = array('text' => $product_code, 'barHeight' => $height, 'stretchText' => TRUE );
    $rendererOptions = array('imageType'=>'png', 'horizontalPosition' => 'center', 'verticalPosition' => 'middle');
    $imageResource = Zend_Barcode::render('code128', 'image', $barcodeOptions, $rendererOptions);
    return $imageResource;
     
    }

  function delete_product($product_id='')
  {
    $d = $this->product_models->delete_product($this->input->post('product_id'));
    if ($d) {
      $e = array('status' =>1);
      echo json_encode($e);
    } else {
      $e = array('status' =>0,'validation'=>'This product is already linked. You cannot delete it.');
      echo json_encode($e);
    }
    
  }
  public function edit_product()
  {
     
          $product_name           = $this->input->post('product_name');
          $product_code           = $this->input->post('product_code');
          $category               = $this->input->post('category');
          $subcategory            = $this->input->post('subcategory');
          $unit                   = $this->input->post('unit');
          $product_cost           = $this->price_filter($this->input->post('product_cost'));
          $product_price          = $this->price_filter($this->input->post('product_price'));
          $wholesale_price        = $this->price_filter($this->input->post('wholesale_price'));
          $credit_salling_price   = $this->price_filter($this->input->post('credit_salling_price'));
          $tax                    = $this->input->post('tax');
          $alert_quty             = $this->input->post('alert_quty');
          $product_details        = $this->input->post('product_details');
		  $product_part_no 		= $this->input->post('product_part_no');
		  $product_oem_part_number= $this->input->post('product_oem_part_number');

          if (!empty($_FILES["userfile"]['name'])) {

                $image_name_enc = "PRODUCT_".time().$_FILES["userfile"]['name'];
                $this->load->library('upload',$this->image_manipulation->image_config($image_name_enc));

                if ( ! $this->upload->do_upload()){

                   $st = array('status' =>0,'validation' => $this->upload->display_errors());
                   echo json_encode($st);
                }
                else{

                    $this->load->library('image_lib',$this->image_manipulation->image_thumb($image_name_enc,100,100));
                    if ( ! $this->image_lib->resize())
                    {
                        echo $this->image_lib->display_errors();
                    }
                    else
                    {
                        $imgName    = $this->upload->data();
                        $imageThumb = $imgName['raw_name']."_thumb".$imgName['file_ext'];

                       if ($this->product_models->update_product($this->input->post('product_id'), $product_name,$product_code,$category,$subcategory,$unit,$product_cost,$product_price,$wholesale_price,$credit_salling_price,$tax,$alert_quty,$imgName['file_name'],$imageThumb,$product_details,$product_part_no,$product_oem_part_number)) {

                               $st = array('status' =>1,'validation' =>'Done!');
                               echo json_encode($st);

                       } else {

                               $st = array('status' =>0,'validation' =>'error occurred please contact your system administrator');
                               echo json_encode($st);
                       }
                       $this->image_lib->clear();
                    }                  

                }

          } else {

                       if ($this->product_models->update_product($this->input->post('product_id'), $product_name,$product_code,$category,$subcategory,$unit,$product_cost,$product_price,$wholesale_price,$credit_salling_price,$tax,$alert_quty,0,0,$product_details,$product_part_no,$product_oem_part_number)) {

                               $st = array('status' =>1,'validation' =>'Done!');
                               echo json_encode($st);

                       } else {

                               $st = array('status' =>0,'validation' =>'error occurred please contact your system administrator');
                               echo json_encode($st);
                       }

          }
          


  }


}