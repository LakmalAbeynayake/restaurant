<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Products extends CI_Controller
{
    var $main_menu_name = "products";
    var $sub_menu_name = "products";
    public function __construct()
    {
        parent::__construct();
        $this->load->model('category_models');
        $this->load->model('common_model');
        $this->load->model('Unit_Model');
        $this->load->model('products_model');
        $this->load->model('locations_model');
    }
    public function index()
    {
        $data['main_menu_name'] = $this->main_menu_name;
        $data['sub_menu_name']  = $this->sub_menu_name;
        
        $data['types']  = $this->products_model->get_types();
        $data['ot_types']  = $this->products_model->get_order_token_types();
        $data['main_category']  = $this->category_models->getCategory();
        /*$mapped_prices = array();
        
        //echo "<pre>";
        foreach($product_prices as $prc){
            $mapped_prices[$prc->pt_id] = $prc;
        }*/
        
        $this->load->view('products/product_list', $data);
    }
    public function suggestions($value = '')
    {
        $cost          = $this->input->post('cost') ? $this->input->post('cost') : "0";
        $term          = $this->input->post('term');
        $this_id          = $this->input->post('this_id');
        $warehouse_id  = $this->input->get('w');
        $data['items'] = $this->products_model->get_products_suggestions($term,$this_id);
        $json          = array();
        foreach ($data['items'] as $row) {
            $unit_code  = 'g|ml';//$unit_dtls['unit_code'];
            $item_code  = $row['product_code'];
            $product_name  = $row['product_name'];
            $product_cost = $row['product_cost'];
                /*if($cost){
                    $product_cost = $this->get_latest_unit_value($row['product_id']);
                }*/
            $json_itm   = array(
                'id' => $row['product_id'],
                'product_id' => $row['product_id'],
                'product_id' => $row['product_id'],
                'product_code' => $row['product_code'],
                'product_name' => $row['product_name'],
                'product_price' => $row['product_price'],
                'product_cost' => $product_cost,
                'unit_code' => $unit_code,
                'value' => $row['product_code'] . " " . $row['product_code'] . "",
                'label' => $row['product_name'] . " (" . $row['product_code'] . ")"
            );
            array_push($json, $json_itm);
        }
        echo json_encode($json);
    }
    public function save_recipe_items()
    {
        // Get POST data
        $location_id = $this->input->post('location_id');
        $product_id = $this->input->post('product_id');
        
        // Extract and process row_e data
        $row_data = $this->input->post('row_e');
        
        if(!empty($row_data) && $product_id){
             $this->products_model->delete_recipe_items($location_id,$product_id);
        }
        
        $total_cost = 0;
        
        // Loop through each row_e entry
        foreach ($row_data as $row) {
            // Extract item_id, bkng_itm_note, and itm_qty from each row
            $item_id = $row['item_id'];
            $bkng_itm_note = $row['bkng_itm_note'];
            $itm_qty = $row['itm_qty'];
            
            $cost_per_item = $row['itm_cst'];
            $itm_stt = $row['itm_stt'];

            // Create the data array
            $data = array(
                'product_id' => $product_id,
                'location_id'   => $location_id,
                'ingredient_id' => $item_id,
                'cost_per_item' => $cost_per_item,
                'quantity' => $itm_qty,
                'subtotal' => $itm_stt,
                'notes' => $bkng_itm_note,
                );
            // Save the data to the database using your model
            $this->products_model->save_recipe_items($data);
            
            $total_cost += $itm_stt;
        }
        
        $this->db->where('product_id', $product_id);
        $this->db->update('product', array('product_cost' => $total_cost));
        
        $this->common_model->add_user_activitie("Recipe Updated for product_id:$product_id location_id:$location_id ");
        
        echo json_encode(array(
            'status' => '1',
            'error' => '',
            'disMsg' => ''
        ));
    }
    function get_cost() {
        $product_id = $this->input->post('product_id');
        
        $this->db->select('product_cost');
        $this->db->from('product');
        $this->db->where('product_id', $product_id);
        $query = $this->db->get();
    
        if ($query->num_rows() > 0) {
            $row = $query->row();
            echo json_encode(array('product_cost' => $row->product_cost));
        } else {
            echo json_encode(array('product_cost' => 0));
        }
    }

    public function add_product()
    {
        $sub = $this->input->get('sub');
        $data['sub'] = $sub;
        if($sub){
            $data['pd']         = $this->products_model->get_product_by_id($sub);
        }
        $data['main_menu_name'] = $this->main_menu_name;
        $data['sub_menu_name']  = 'add_products';
        $data['main_category']  = $this->category_models->getCategory();
        $data['unit_type']      = $this->products_model->getUnit();
        $data['tax']            = $this->products_model->getTax();
        $data['ot_types']       = $this->products_model->get_order_token_types();
        $data['product_types']  = $this->products_model->get_types();
        $data['price_types']    = $this->products_model->get_price_types();
        $this->load->view('products/product_add', $data);
    }
    public function get_sub_category_by_id()
    {
        $parent_category = $this->input->get('category_id');
        if ($parent_category) {
            $val = $this->category_models->get_sub_category($this->input->get('category_id'));
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
    function unformat($formattedNumber) {
        // Remove any non-numeric characters except for a decimal point
        $numericString = preg_replace("/[^0-9.]/", "", $formattedNumber);
        
        // Replace any commas that might be used as thousand separators
        $numericString = str_replace(',', '', $numericString);
    
        // Convert the string to a float
        $unformattedValue = (float) $numericString;
    
        return $unformattedValue;
    }
    public function save_product()
    {
        $prices_column = array();
        /*
        $prices_column['lo'.$this->session->userdata('ss_warehouse_id')] = array();
        $prices = $this->input->post('prices');
        $price_types_array = array();
        if(!empty($prices)){
            foreach($prices as $id=>$price){
                $price_types_array[] = $id;
                
                $location_price = array(
                    'pt_id' => $id,
                    'amount' => $price
                );
                $prices_column['lo'.$this->session->userdata('ss_warehouse_id')][] = $location_price;
            }
        }
        //check availability of price types
        $this->db->select('*');
        $this->db->from('price_type');
        $this->db->where_in('pt_id', $price_types_array);
        $query = $this->db->get();
        $result = $query->result();
        if (empty($result)) {
            echo json_encode(
                array(
                    'status' => 0,
                    'validation' => 'Product types undefined!'
                    )
            );
            
            return;
        }*/
        $this->load->library('form_validation'); //form validation lib
        $this->form_validation->set_rules('product_name', 'Product Name', 'required');
        $this->form_validation->set_rules('product_code', 'Product Code', 'required|is_unique[product.product_code]');
        $this->form_validation->set_rules('product_type', 'Product Type', 'required');
        if ($this->form_validation->run() == FALSE) {
            $st = array(
                'status' => 0,
                'validation' => validation_errors()
            );
            echo json_encode($st);
        } else {
            $product_name       = $this->input->post('product_name');
            $product_code       = $this->input->post('product_code');
            $product_size       = $this->input->post('product_size');
            $category           = $this->input->post('category');
            $subcategory        = $this->input->post('subcategory');
            $unit               = $this->input->post('unit');
            $product_cost       = $this->input->post('product_cost') ?: null;
            $product_price      = $this->input->post('product_price');
            $tax                = $this->input->post('tax');
            $alert_qty          = $this->input->post('alert_qty');
            $product_image      = $this->input->post('product_image');
            $product_thumb      = $this->input->post('product_thumb');
            $product_details    = $this->input->post('product_details');
            $product_id         = $this->input->post('product_id');
            $store_position     = $this->input->post('store_position');
            $product_type       = $this->input->post('product_type');
            $ott              = floatval($this->input->post('ott'));

            $product_data = array(
                'cat_id'            => $category,
                'sub_cat_id'        => $subcategory,
                'product_name'      => $product_name,
                'product_code'      => $product_code,
                'product_size'      => $product_size,
                'product_type_id'   => $product_type,
                'product_image'     => $product_image,
                'product_thumb'     => $product_thumb,
                'product_alert_qty' => floatval($alert_qty),
                'product_unit'      => $unit,
                'product_cost'      => floatval($this->unformat($product_cost)),
                'product_price'     => floatval($this->unformat($product_price)),
                'product_prices'    => json_encode($prices_column),
                'tax'               => $tax,
                'product_details'   => $product_details,
                'ott'             => $ott
            );

            $last_id = $this->products_model->save_product($product_data, $product_code == "" ? true : false);
            
            $this->common_model->add_user_activitie("Product added. product id ?? $last_id ");
            
            if ($last_id) {
                $st = array(
                    'status' => 1,
                    'validation' => 'Done!',
                    'last_id' => "PD" . sprintf("%04d", $last_id + 1)
                );
                echo json_encode($st);
            }
        }
    }
    function price_filter($amount = '')
    {
        $s = explode("Rs.", $amount);
        return str_replace(',', '', $s[1]);
    }
    public function get_list_product($value = '')
    {
        /*$search_key     = $this->input->get('search');
        $search_key_val = $search_key['value'];
        $start          = $this->input->get('start');
        $length         = $this->input->get('length');
        $order          = $this->input->get('order');
        $columns        = $this->input->get('columns');*/
        
        $pt_id          = $this->input->post('pt_id');
        $cat_id          = $this->input->post('cat_id');
        $sub_cat_id          = $this->input->post('sub_cat_id');
        $ot_types       = $this->products_model->get_order_token_types();
        $mapped_ot_types = array();
        foreach($ot_types as $ott){
            $mapped_ot_types[$ott->ott_id] = $ott;
        }

        $product_prices = $this->products_model->get_price_types();
        $mapped_prices  = array();
        foreach($product_prices as $prc){
            $mapped_prices[$prc->pt_id] = $prc;
        }

        $values = $this->products_model->getProducts($pt_id,$cat_id,$sub_cat_id);
        $data   = array();
        if (!empty($values)) {
            foreach ($values as $products) {
                if ($products->product_status == 0) {
                    $k = "btn-warning";
                    $m = "fa-minus-circle";
                } else {
                    $k = "btn-green";
                    $m = "fa-check";
                }
                $retVal                 = (empty($products->sub_cat_name)) ? "--:--" : $products->sub_cat_name;
                $qty                    = $this->products_model->get_item_qty($products->product_id);
                $qty                    = (empty($qty[0]->qty)) ? "--:--" : $qty[0]->qty;
                $row                    = array();
                //get transferd qty
                $transferd_qty          = 0;
                $transfer_reseve_qty    = 0;
                $row[]                  = '<center><div style="margin-bottom: 0px; width: 50px; height: 50px;" class="fileupload-new thumbnail"><img alt="" src="' . asset_url() . "uploads/thumbs/" . $products->product_thumb . '"></div></center>';
                $row[]  = $products->product_code;
                $row[]  = $products->product_name;
                $row[]  = $products->cat_name;
                $row[]  = $retVal;
                
                /*price elem*/
                $prices = $products->product_prices;
                $prices = json_decode($prices);
                $location_key = 'lo'.$this->session->userdata('ss_warehouse_id');
                if(!empty($prices)){
                    if(isset($prices->$location_key))
                        $prices = $prices->$location_key;
                    else
                        $prices = array();
                }
                else
                    $prices = array();
                
                $prices_list = ''  ;
                if(!empty($prices)){
                    /*<br>
                    <div class="btn-group text-left">
                    <button data-toggle="dropdown" class="btn btn-default btn-xs btn-success dropdown-toggle" type="button"> <i class="fa fa-eye"></i> <span class="caret"></span></button></div>*/
                    $prices_list =   '
                    
                    <ul class="pricelist">';/*role="menu" class="dropdown-menu pull-right"*/
                    foreach($prices as $prc_row){
                        $nme = $mapped_prices[$prc_row->pt_id]->pt_name;
                        foreach($prc_row->amount as $amt){
                            $prices_list.= "<li>".$nme.' : '.$amt."</li>";
                        }
                    }
                    $prices_list .=   '</ul>';
                }

                $row[]  = $products->product_price.$prices_list;
                $row[]  = $products->product_cost; //$each_product_cost;
                $row[]  = "n/a";
                $row[]  = $products->ott > 0 ? $mapped_ot_types[$products->ott]->ott_name :'<i class="fa fa-times"></i>';
                
                $col = $this->session->userdata('ss_group_id') == 4 ? 'collapse' : '';
                
                $actdes = '';
                $action_class="btn-primary";
                if($products->product_status==0){
                    $action_class="btn-danger";
                    $edbutton='<li class="divider"></li><li><a onclick="product_enable(' . $products->product_id . '); return false;" href="#"><i class="fa fa-check"></i> Enable Product</a></li>';
                }else{
                    $edbutton='<li class="divider"></li><li><a onclick="product_delete(' . $products->product_id . '); return false;" href="#"><i class="fa fa-trash-o"></i> Disable Product</a></li>';
                }
                $actdes = $actdes . '
                                        <a class="btn btn-sm" href="' . base_url('products/view') . '/' . $products->product_id . '"><i class="fa fa-file-text-o"></i> Product Details</a>
                                        <a class="btn btn-sm '.$col.'" target="_edit_product" href="' . base_url('products/edit') . '/' . $products->product_id . '"><i class="fa fa-edit"></i> Edit Product</a>
                                        <div class="btn-group text-left">
                                        <button data-toggle="dropdown" class="btn btn-default btn-xs '.$action_class.' dropdown-toggle" type="button">Other Actions <span class="caret"></span></button>
                                        <ul role="menu" class="dropdown-menu pull-right">';
                if ($this->session->userdata('ss_group_id') == 1 || $this->session->userdata('ss_group_id') == 2  ) {
                    $actdes = $actdes . '
                            '.$edbutton.'
                            ';
                }
                $actdes = $actdes . '    
                            <li class="collapse"><a onclick=" print_barcode(' . $products->product_id . '); return false;" href="#"><i class="fa fa-print"></i> Print Barcode</a></li>
                            
                            </ul></div>';
                $row[]  = $actdes;
                $data[] = $row;
            }
            $output = array(
                'data' => $data
            );
            echo json_encode($output);
        } else {
            $output = array(
                'data' => ''
            );
            echo json_encode($output);
        }
    }
    public function view($product_id = "")
    {
        $sd = $this->products_model->get_product_by_id($product_id);
        if (!empty($sd)) {
            $data['product_details']          = $this->products_model->get_product_by_id($product_id);
            $data['price_types']              = $this->products_model->get_price_types();
            $data['warehouses']               = array();//$this->products_model->get_warehouse_product($product_id);
            $data['locations']                = $this->locations_model->get_locations();
            $data['main_menu_name']           = $this->main_menu_name;
            $data['sub_menu_name']            = $this->sub_menu_name;
            /*$data['selected_extra_menu_list'] = $this->products_model->get_recipe($product_id);*/
            $this->load->view('products/product_view', $data);
        } else {
            show_404();
        }
    }
    public function edit($product_id = '')
    {
        $data['product_details'] = $this->products_model->get_product_by_id($product_id);
        if ($data['product_details']) {
            $data['product_types']            = $this->products_model->get_types();
            $data['main_menu_name']           = $this->main_menu_name;
            $data['sub_menu_name']            = $this->sub_menu_name;
            $data['ot_types']                 = $this->products_model->get_order_token_types();
            $data['main_category']            = $this->category_models->getCategory();
            $data['unit_type']                = $this->products_model->getUnit();
            $data['tax']                      = $this->products_model->getTax();
            $data['sub_category']             = $this->category_models->getSubCategory($data['product_details']->cat_id);
            /*$data['selected_extra_menu_list'] = $this->products_model->get_recipe($product_id);*/
            $this->load->view('products/product_edit', $data);
        } else
            show_404();
    }
    public function single_barcode($product_id = '')
    {
        $data['product_details'] = $this->products_model->get_product_by_id($product_id);
        $this->load->view('products/product_barcode', $data);
    }
    function gen_barcode($product_code = NULL, $height = 80)
    {
        if ($this->input->get('code')) {
            $product_code = $this->input->get('code');
        }
        if ($this->input->get('height')) {
            $height = $this->input->get('height');
        }
        //load library
        $this->load->library('zend');
        //load in folder Zend
        $this->zend->load('Zend/Barcode');
        //'drawText' => FALSE
        $barcodeOptions  = array(
            'text' => $product_code,
            'barHeight' => $height,
            'stretchText' => TRUE
        );
        $rendererOptions = array(
            'imageType' => 'png',
            'horizontalPosition' => 'center',
            'verticalPosition' => 'middle'
        );
        $imageResource   = Zend_Barcode::render('code128', 'image', $barcodeOptions, $rendererOptions);
        return $imageResource;
    }
    function delete_product($product_id = '')
    {
        $d = $this->products_model->delete_product($this->input->post('product_id'));
        if ($d) {
            $e = array(
                'status' => 1
            );
            echo json_encode($e);
        } else {
            $e = array(
                'status' => 0,
                'validation' => 'This product is already linked. You cannot delete it.'
            );
            echo json_encode($e);
        }
    }
    public function edit_product()
    {
        $product_id            = $this->input->post('product_id');
        $product_name            = $this->input->post('product_name');
        $product_code            = $this->input->post('product_code');
        $category                = $this->input->post('category');
        $subcategory             = $this->input->post('subcategory');
        $product_cost            = $this->input->post('product_cost');
        $product_type            = $this->input->post('product_type');
        $unit                    = $this->input->post('unit');
        $product_cost            = floatval($this->input->post('product_cost')); //$this->price_filter($this->input->post('product_cost'));
        $product_price           = floatval($this->input->post('product_price'));
        $wholesale_price         = floatval($this->input->post('wholesale_price'));
        $credit_salling_price    = floatval($this->input->post('credit_salling_price'));
        $product_commision       = floatval($this->input->post('product_commision'));
        $tax                     = floatval($this->input->post('tax'));
        $ott                     = floatval($this->input->post('ott'));
        $alert_qty               = $this->input->post('alert_qty');
        $product_details         = $this->input->post('product_details');
        $product_part_no         = $this->input->post('product_part_no');
        $product_oem_part_number = $this->input->post('product_oem_part_number');
        $store_position          = $this->input->post('store_position');
        $product_max_qty         = $this->input->post('product_max_qty');
        $product_size            = $this->input->post('product_size');
        
        $is_saleable             = $this->input->post('is_saleable') ? $this->input->post('is_saleable') : 0;
        $is_purchasable          = $this->input->post('is_purchasable') ? $this->input->post('is_purchasable') : 0;
        $is_stockable            = $this->input->post('is_stockable') ? $this->input->post('is_stockable') : 0;
        $is_transferable         = $this->input->post('is_transferable') ? $this->input->post('is_transferable') : 0;
        
        
        $product_data = array(
            'cat_id'            => $category,
            'sub_cat_id'        => $subcategory,
            'product_name'      => $product_name,
            'product_code'      => $product_code,
            'product_size'      => $product_size,
            'product_type_id'   => $product_type,
            'product_image'     => '',
            'product_thumb'     => '',
            'product_alert_qty' => 0,
            'product_unit'      => $unit,
            'product_cost'      => floatval($this->unformat($product_cost)),
            'product_price'     => floatval($this->unformat($product_price)),
            'tax'               => $tax,
            'product_details'   => $product_details,
            'ott'               => $ott,
            'is_saleable'       => $is_saleable,
            'is_purchasable'    => $is_purchasable,
            'is_stockable'      => $is_stockable, 
            'is_transferable'   => $is_transferable
        );

        if ($this->products_model->update_product(array('product_id' => $product_id),$product_data)) {
            $this->common_model->add_user_activitie("Product updated. product id: $product_id ");
            $st = array(
                'status' => 1,
                'validation' => 'Done!'
            );
            echo json_encode($st);
        } else {
            $st = array(
                'status' => 0,
                'validation' => 'No saved changes!',
                'qry' => $this->db->last_query()
            );
            echo json_encode($st);
        }
        
    }
    
    
     function enable_product($product_id = '')
    {
        $d = $this->products_model->enable_product($this->input->post('product_id'));
        if ($d) {
            $e = array(
                'status' => 1
            );
            echo json_encode($e);
        } else {
            $e = array(
                'status' => 0,
                'validation' => 'This product is already linked. You cannot delete it.'
            );
            echo json_encode($e);
        }
    }
    
    /*Recipe*/
    function get_recipe(){
        $product_id = $this->input->post('product_id');
        $location_id = $this->input->post('location_id');
        $result = $this->products_model->get_recipe($location_id,$product_id);
        echo json_encode($result);
    }
    function toggle_recipe_item(){
        $location_id = $this->input->post('location_id');
        $product_id = $this->input->post('product_id');
        $ingredient_id = $this->input->post('ingredient_id');
        $prop = $this->input->post('prop');
        $where = array(
            'location_id' => $location_id,'product_id' => $product_id, 'ingredient_id' => $ingredient_id
        );
        $result = $this->products_model->toggle_recipe_item($where,$prop);
        if($result)
            http_response_code(200);
        else
            http_response_code(500);
    }
    /*Price Management*/
    function get_product_prices(){
        $product_id = $this->input->post('product_id');
        $location_id = $this->input->post('location_id');
        $result = $this->products_model->get_product_prices($product_id);
        $prices = json_decode($result);
        $location_name = 'lo'.$location_id;
        if(isset($prices->$location_name))
            echo json_encode($prices->$location_name);
        else
            http_response_code(400);
    }
    
    function update_prices(){
        $location_id = $this->input->post('location_id');
        $product_id = $this->input->post('product_id');

        if(!$location_id && !$product_id){
            http_response_code(400);
            return;
        }
        /* get current prices from DB*/
        $current_prices = $this->products_model->get_product_prices($product_id);
        if($current_prices != ""){
            $current_prices = json_decode($current_prices,true);
        }else{
            $current_prices = array();
        }
        
        /* Map new prices*/
        $prices_column = array();
        $prices_column['lo'.$location_id] = array();
        $prices = $this->input->post('prices');
        $price_types_array = array();
        /*http_response_code(500);
        print_r($prices);
        exit;*/
        if(!empty($prices)){
            foreach($prices as $id=>$price){
                $price_types_array[] = $id;
                $location_price = array(
                    'pt_id' => $id,
                    'amount' => array()
                );
                foreach($price as $key=>$pr){
                    $keyname = 'p'.(++$key);
                    $location_price['amount'][$keyname] = $pr;
                }
                $prices_column['lo'.$location_id][] = $location_price;
            }
            //check availability of price types
            $this->db->select('*');
            $this->db->from('price_type');
            $this->db->where_in('pt_id', $price_types_array);
            $query = $this->db->get();
            $result = $query->result();
            if (empty($result)) {
                echo json_encode(
                    array(
                        'status' => 0,
                        'validation' => 'Product types undefined!'
                        )
                );
                return;
            }
            
            /*merge prices*/
            if(isset($current_prices['lo'.$location_id])){
                $current_prices['lo'.$location_id] = $prices_column['lo'.$location_id];
            }else{
                $current_prices['lo'.$location_id] = array();
                $current_prices['lo'.$location_id] = $prices_column['lo'.$location_id];
            }
            
            /*end merging*/
        }else{
            $prices = array();
        }
        /*print_r($prices_column);
        exit;*/
        
        $where = array('product_id'=> $product_id);
        $data = array(
            'product_prices' => json_encode($current_prices)
            );
        if($this->products_model->update_product($where,$data))
            http_response_code(200);
        else
            http_response_code(500);
            
        $this->common_model->add_user_activitie("Price updated for product_id:$product_id location_id:$location_id");
    }
    
    /**/
    function get_list(){
        $this->db->select('*');
        $this->db->from('product_upload');
        $query = $this->db->get();
        return $query->result();
    }
    function get_product_list(){
        $this->db->select('product_id,product_code');
        $this->db->from('product');
        $query = $this->db->get();
        return $query->result();
    }
    private function getPriceTypeId($type,$location_id)
      {
        $query = $this->db->get_where('price_type', array(
          'pt_name    ' => $type,
          'location_id' => $location_id
        ));
        if ($query->num_rows() > 0) {
          $row = $query->row();
          return $row->pt_id;
        } else {
          // If category not found, insert into database and return new cat_id
          $this->db->insert('price_type', array(
            'pt_name    ' => $type,
            'location_id' => $location_id
          ));
          return $this->db->insert_id();
        }
      }
    private function getProductTypeId($type)
      {
        $query = $this->db->get_where('product_type', array(
          'product_type_name    ' => $type
        ));
        if ($query->num_rows() > 0) {
          $row = $query->row();
          return $row->product_type_id;
        } else {
          // If category not found, insert into database and return new cat_id
          $this->db->insert('price_type', array(
            'product_type_name    ' => $type
          ));
          return $this->db->insert_id();
        }
      }
    private function getProductId($ProductId)
      {
        $query = $this->db->get_where('product', array(
          'product_code    ' => $ProductId
        ));
        if ($query->num_rows() > 0) {
          $row = $query->row();
          return $row->cat_id;
        } else {
          // If category not found, insert into database and return new cat_id
          $this->db->insert('product_category', array(
            'cat_name    ' => $ProductId
          ));
          return $this->db->insert_id();
        }
      }
    private function getCategoryId($category)
      {
        $query = $this->db->get_where('product_category', array(
          'cat_name    ' => $category
        ));
        if ($query->num_rows() > 0) {
          $row = $query->row();
          return $row->cat_id;
        } else {
          // If category not found, insert into database and return new cat_id
          $this->db->insert('product_category', array(
            'cat_name    ' => $category
          ));
          return $this->db->insert_id();
        }
      }
      private function getSubCategoryId($sub_category, $cat_id)
      {
        $query = $this->db->get_where('product_sub_category', array(
          'sub_cat_name' => $sub_category,
          'cat_id' => $cat_id
        ));
        if ($query->num_rows() > 0) {
          $row = $query->row();
          return $row->sub_cat_id;
        } else {
          // If sub_category not found, insert into database and return new sub_cat_id
          $this->db->insert('product_sub_category', array(
            'sub_cat_name' => $sub_category,
            'cat_id' => $cat_id
          ));
          return $this->db->insert_id();
        }
      }
      
    // upload | import | products | items 
    function upload(){
        $categories = array();
        $sub_categories = array();
        $price_types = array();
        $error_list = array();

        $item_list = $this->get_list();
        $product_list       = $this->get_product_list();
        $pl_mapped = array();
        foreach($product_list as $pd){
            $pl_mapped[$pd->product_code] = $pd;
        }
        
        echo "<pre>";
        // start
        $this->db->trans_start();
        $succ = array();
        $products = array();
        foreach($item_list as $itm){
            
            if(isset($pl_mapped[$itm->itm_code]))
                continue;
        
            $cat_id       = $this->getCategoryId($itm->itm_cat_name);
            $sub_cat_id   = $this->getSubCategoryId($itm->itm_subcat_name, $cat_id);
            $itm_type_id  = $this->getProductTypeId($itm->itm_type);
            
            if(!$itm_type_id > 0){
                $error_list[] = $itm;
                continue;
            }
            
            $product_data = array(
                //'product_id'        => $itm->itm_id,
                'cat_id'            => $cat_id,
                'sub_cat_id'        => $sub_cat_id,
                'product_name'      => $itm->itm_name,
                'product_code'      => $itm->itm_code,
                'product_type_id'   => $itm_type_id,
                'product_image'     => '',
                'product_thumb'     => '',
                'product_alert_qty' => 0,
                'product_unit'      => 6,
                'product_cost'      => 0,
                'product_price'     => 0,
                'product_prices'    => json_encode(array()),
                //'tax'               => '',
                //'product_details'   => '',
                'ott'               => 0
            );
            
            if($this->db->insert('product',$product_data)){
                $succ[] = $product_data;
            }else{
                $products[] = $product_data;
                echo $this->db->last_query();
                break;
            }
        }
        
        /*print_r($error_list);
        exit;*/
        
        //$this->db->insert_batch('product',$products);
        $this->db->trans_complete();
        
        if ($this->db->trans_status() === FALSE)
        {
            
            echo "<pre>";
            echo $this->db->last_query();
            print_r($products);
            echo "</pre>";
        }
        else
        {
            echo "added successfully";
            echo "<pre>";
            print_r($succ);
            echo "</pre>";
        }
    }
    
    // update prices | manage 
    function update(){
        echo "Processing...";
        // fetch item list
        $item_list  = $this->get_list();
        // fetch location prices
        $price_list = $this->get_prices();
        
        // collect locations
        $locations  = array();
        
        // mapping data
        $map = array();
        
        foreach($price_list as $price){
            //print_r($price);
            if(!in_array($price->location_id, $locations)){
                $locations[] = $price->location_id;
            }
            
            if(!isset($map[$price->location_id]))
                $map[$price->location_id] = array();
            
            if(!isset($map[$price->location_id][$price->product_code]))
                $map[$price->location_id][$price->product_code] = array();
            
            if(!isset($map[$price->location_id][$price->product_code][$price->price_type]))
                $map[$price->location_id][$price->product_code][$price->price_type] = array();
            
            $map[$price->location_id][$price->product_code][$price->price_type][] = $price->price;
        }
        $this->db->trans_start();
        foreach($map as $location_id => $products){
            /*echo "<pre>";
            print_r($products);
            echo "</pre><hr>";*/
            foreach($products as $product_code => $price_types){
                
                echo "<pre>";
                $dp = $price_types[1][0];
                
                if($this->isNumberOrFloat($dp)){
                    if(isset($price_types[1][0]))
                    $this->update_dp(array('product_code' => $product_code),array(
                            'product_price' => $dp
                    ));
                }else{
                    
                }
                
                
                /*echo "location: ".$location_id." - product:".$product_code." DP:".$dp." prices:";
                print_r($price_types);
                
                echo "</pre><hr>";*/
                $this->manage_prices($location_id,$product_code,$price_types);
                
                // left this just for better understanding
                /*foreach($price_types as $pt_id => $price){
                    echo "<pre>";
                    print_r($price);
                    echo "</pre><hr>";
                }*/
            }
        }
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE)
        {
                echo "<br><br>Failed. No changes";
        }
        else
        {
                echo "<br><br>Successfully applied";
        }
    }
    
    function isNumberOrFloat($input) {
        return is_numeric($input) && (strpos($input, '.') !== false || ctype_digit($input));
    }
    function get_products(){
        $this->db->select('*');
        $this->db->from('product');
        $query = $this->db->get();
        return $query->result();
    }
    function get_prices(){
        $this->db->select('*');
        $this->db->from('location_prices');
        $query = $this->db->get();
        return $query->result();
        /*$query = $this->db->get_where('location_prices', array(
          'pt_name    ' => $type,
          'location_id' => $location_id
        ));
        $row = $query->row();*/
    }
    function update_dp($where,$data){   
        $this->db->where($where);
        $this->db->update('product', $data);
        return $this->db->affected_rows();
    }
    function manage_prices($location_id,$product_code,$prices){
        // prices[' + selectedPriceType.pt_id + '][]
        
        /*$location_id = $this->input->post('location_id');
        $product_id = $this->input->post('product_id');*/
        
        if(!$location_id && !$product_code){
            http_response_code(400);
            return;
        }
        /* get current prices from DB*/
        $current_prices = $this->get_product_prices_by_code($product_code);
        if($current_prices != ""){
            $current_prices = json_decode($current_prices,true);
        }else{
            $current_prices = array();
        }
        
        /* Map new prices*/
        $prices_column = array();
        $prices_column['lo'.$location_id] = array();
        /*$prices = $this->input->post('prices');*/
        $price_types_array = array();
        
        if(!empty($prices)){
            foreach($prices as $id=>$price){
                $price_types_array[] = $id;
                $location_price = array(
                    'pt_id' => $id,
                    'amount' => array()
                );
                foreach($price as $key=>$pr){
                    $keyname = 'p'.(++$key);
                    $location_price['amount'][$keyname] = $pr;
                }
                $prices_column['lo'.$location_id][] = $location_price;
            }
        }
        /*print_r($prices_column);
        exit;*/
        //check availability of price types
        $this->db->select('*');
        $this->db->from('price_type');
        $this->db->where_in('pt_id', $price_types_array);
        $query = $this->db->get();
        $result = $query->result();
        if (empty($result)) {
            echo json_encode(
                array(
                    'status' => 0,
                    'validation' => 'Product types undefined!'
                    )
            );
            return;
        }
        
        /*merge prices*/
        if(isset($current_prices['lo'.$location_id])){
            $current_prices['lo'.$location_id] = $prices_column['lo'.$location_id];
        }else{
            $current_prices['lo'.$location_id] = array();
            $current_prices['lo'.$location_id] = $prices_column['lo'.$location_id];
        }
        
        /*end merging*/
        $where = array('product_code'=> $product_code);
        $data = array(
            'product_prices' => json_encode($current_prices)
            );
        $this->products_model->update_product($where,$data);
    }
     function get_product_prices_by_code($product_code){
        $this->db->select('product_prices')
                  ->from('product')
                  ->where('product_code',$product_code);
        $query =  $this->db->get();
        if($query->num_rows() > 0)
            return $query->row()->product_prices;
        return json_encode(array());
        //echo $this->db->last_query();
    }
    function get_movements(){
        
        $location_id    =   $this->input->post('location_id');
        $product_id     =   $this->input->post('product_id');
        
        $date     =   $this->input->post('date');
        $date_to     =   $this->input->post('date_to');
        
        if(!$location_id && $product_id && !$date){
            echo json_encode(array(
                'success' => false,
                'data'  => array()
            ));
            return;
        }
        
        $this->db->select('*');
        $this->db->from('stock_movements');
        $this->db->where('location_id',$location_id);
        $this->db->where('product_id',$product_id);
        if($date_to){
            $this->db->where('date(movement_date) >=',$date);
            $this->db->where('date(movement_date) <=',$date_to);
        }else{
            $this->db->where('date(movement_date)',$date);
        }
        
        $query = $this->db->get();
        $result = $query -> result();
        
        echo json_encode(array(
            'success' => true,
            'data'  => $result
        ));
    }
    
    /**/
    
    function prices(){
        
        $this->db->select('*');
        $this->db->from('product');
        $query = $this->db->get();
        $product = $query->result();
        
        // fetch item list
        //$product  = $this->get_list();
        $item_list_mapped = array();
        foreach($product as $p)
            $item_list_mapped[$p->product_code] = $p;

        // fetch location prices
        $price_list = $this->get_prices();
        /*echo "<pre>";
        print_r($price_list);
        echo "</pre>";
        exit;*/
        foreach($price_list as $key=>$price){
            if(isset($item_list_mapped[$price->product_code])){
                $price_list[$key]->product_name = $item_list_mapped[$price->product_code]->product_name;
            }else {
                echo $price->product_code . "<br>";
            }
        }
        
        /*print_r($price_list);
        echo "</pre>";*/
        $data['main_category']            = $this->category_models->getCategory();
        $data['price_list'] = $price_list;
        $this->load->view('products/prices',$data);
    }
    function update_lp(){
        $lp_id = $this->input->post('lp_id');
        $price = $this->input->post('currentValue');
        
        if($lp_id > 0){
            $data = array(
                'price' => $price
            );
            $this->db->where('lp_id',$lp_id);
            $this->db->update('location_prices',$data);
        }
        echo json_encode(array(
            'success' => $this->db->affected_rows() ? true: false
        ));
    }
}