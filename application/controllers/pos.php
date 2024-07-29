<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Pos extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('pos_model');
        $this->load->model('common_model');
        /*$this->load->model('Supplier_Model');*/
        /*$this->load->model('sms_model');*/
        date_default_timezone_set("Asia/Colombo");
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
    }
    public function index()
    {
        $this->load->model('category_models');
        $data['customer_id'] = 0;
        $data['sale_id']     = $this->uri->segment(3);
        $data['is_editable'] = '1';
        if ($data['sale_id']) {
            $data['sale_details'] = $this->pos_model->get_sale_info($data['sale_id']);
            if ($data['sale_details'][0]['sale_status'] != 2) {
                $data['sale_item_list'] = $this->pos_model->get_sale_item_list_by_sale_id($data['sale_id']);
                $data['customer_id']    = $data['sale_details'][0]['customer_id'];
            } else {
                $data['customer_id'] = $this->uri->segment(2);
                $data['sale_id']     = 0;
            }
            $data['is_editable'] = $data['sale_details'][0]['is_editable'];
        } else {
            $data['customer_id'] = $this->uri->segment(2);
            $data['sale_id']     = 0;
        }
        $data['category_by_id_1'] = $this->pos_model->get_product_by_cat_id(3);
        $data['category']         = $this->pos_model->get_all_category();
        $product_list_by_category = array();
        foreach ($data['category'] as $row) {
            $get_products_cat_by_cat = $this->pos_model->get_product_by_cat_id($row->cat_id);
            $products_of_cat         = array();
            if ($get_products_cat_by_cat)
                foreach ($get_products_cat_by_cat as $row_2) {
                    $productData                  = array();
                    $productData['product_id']    = $row_2->product_id;
                    $productData['product_name']  = $row_2->product_name;
                    $productData['product_code']  = $row_2->product_code;
                    $productData['product_price'] = $row_2->product_price;
                    $productData['product_thumb'] = $row_2->product_thumb;
                    $productData['cat_id']        = $row_2->cat_id;
                    $productData['sub_cat_id']    = $row_2->sub_cat_id;
                    $products_of_cat[]            = $productData;
                }
            $product_list_by_category[] = $products_of_cat;
        }
        $data['product_list_by_category'] = $product_list_by_category;
        $data['sub_category']             = $this->pos_model->get_sub_category_by_cat_id(1);
        $data['get_customer']             = $this->pos_model->get_customer();
        $data['get_warehouse']            = $this->pos_model->get_warehouse();
        $data['product_list']             = '';
        $data['main_category']            = $this->category_models->getCategory();
        $data['order_place']              = 'rest';
        $this->load->view('pos/pos', $data);
    }
    function bars()
    {
        $this->load->model('category_models');
        $data['customer_id'] = 0;
        $data['sale_id']     = $this->uri->segment(3);
        $data['is_editable'] = '1';
        if ($data['sale_id']) {
            $data['sale_details'] = $this->pos_model->get_sale_info($data['sale_id']);
            if ($data['sale_details'][0]['sale_status'] != 2) {
                $data['sale_item_list'] = $this->pos_model->get_sale_item_list_by_sale_id($data['sale_id']);
                $data['customer_id']    = $data['sale_details'][0]['customer_id'];
            } else {
                $data['customer_id'] = $this->uri->segment(2);
                $data['sale_id']     = 0;
            }
            $data['is_editable'] = $data['sale_details'][0]['is_editable'];
        } else {
            $data['customer_id'] = $this->uri->segment(2);
            $data['sale_id']     = 0;
        }
        $data['category_by_id_1'] = $this->pos_model->get_product_by_cat_id(3);
        $data['category']         = $this->pos_model->get_all_category();
        $product_list_by_category = array();
        foreach ($data['category'] as $row) {
            $get_products_cat_by_cat = $this->pos_model->get_product_by_cat_id($row->cat_id);
            $products_of_cat         = array();
            foreach ($get_products_cat_by_cat as $row_2) {
                $productData                  = array();
                $productData['product_id']    = $row_2->product_id;
                $productData['product_name']  = $row_2->product_name;
                $productData['product_code']  = $row_2->product_code;
                $productData['product_price'] = $row_2->product_price;
                $productData['product_thumb'] = $row_2->product_thumb;
                $productData['cat_id']        = $row_2->cat_id;
                $productData['sub_cat_id']    = $row_2->sub_cat_id;
                $products_of_cat[]            = $productData;
            }
            $product_list_by_category[] = $products_of_cat;
        }
        $data['product_list_by_category'] = $product_list_by_category;
        $data['sub_category']             = $this->pos_model->get_sub_category_by_cat_id(1);
        $data['get_customer']             = $this->pos_model->get_customer();
        $data['get_warehouse']            = $this->pos_model->get_warehouse();
        $data['product_list']             = $this->loadProductArray();
        $data['main_category']            = $this->category_models->getCategory();
        $data['order_place']              = 'bar';
        $this->load->view('pos/pos', $data);
    }
    public function vk()
    {
        $this->load->view("pos/vk");
    }
    public function ajaxcategorydata($category_id = '')
    {
        $category_id = $this->input->get('category_id');
        $out_cat     = '';
        $out_sub     = '';
        $d           = $this->pos_model->get_product_by_cat_id($category_id);
        $s           = $this->pos_model->get_sub_category_by_cat_id($category_id);
        if (!empty($d)) {
            $c    = count($d);
            $top  = 0;
            $left = 0;
            $i    = 0;
            foreach ($d as $key => $prod) {
                if ($i < $c) {
                    $out_cat .= "<button data-container='body' class='btn-prni btn-default product pos-tip' title='" . $prod->product_name . "'  value='" . $prod->product_code . "' type='button' id='product-" . $prod->product_id . "' product_id='" . $prod->product_id . "' product_price='" . $prod->product_price . "'  style='font-weight:bold; font-size:14px; height:120px; min-width:160px;max-width:180px;position:absolute; top:" . $top . "px; left:" . $left . "px;'> 
                
                
                        <img class='img-rounded col-xs-6' style='max-height:113px;padding:0px' alt='" . $prod->product_name . "' src='" . asset_url() . "uploads/thumbs/" . $prod->product_thumb . "'>
                

                        " . substr($prod->product_name, 0, 25) . "<br>" . $prod->product_price . "
                
                
                </button>";
                    if ($left <= 550) {
                        $left += 170;
                    } else {
                        $top += 130;
                        $left = 0;
                    }
                    $i++;
                } else {
                    $i++;
                }
            }
            if (!empty($s)) {
                foreach ($s as $key => $sub_cat) {
                    $out_sub .= "<button id='subcategory-" . $sub_cat->sub_cat_id . "' type='button' value='" . $sub_cat->sub_cat_id . "' class='btn-prni subcategory' ><img src='" . asset_url() . "uploads/no-image.jpg' style='width:60px;height:60px;' class='img-rounded img-thumbnail'/><span>" . $sub_cat->sub_cat_name . "</span></button>";
                }
                $jproduct = array(
                    "products" => $out_cat,
                    "subcategories" => $out_sub,
                    "tcp" => 0
                );
                $ret      = json_encode($jproduct);
                echo $ret;
            } else {
                $jproduct = array(
                    "products" => $out_cat,
                    "subcategories" => "",
                    "tcp" => 0
                );
                $ret      = json_encode($jproduct);
                echo $ret;
            }
        } else {
            $jproduct = array(
                "products" => "<div></div>",
                "subcategories" => "",
                "tcp" => 0
            );
            $ret      = json_encode($jproduct);
            echo $ret;
        }
    }
    public function ajaxproducts($category_id = '', $subcategory_id = '', $per_page = '')
    {
        $nm             = '';
        $category_id    = $this->input->get('category_id');
        $subcategory_id = $this->input->get('subcategory_id');
        $n              = $this->pos_model->get_product_by_cat_sub_id($category_id, $subcategory_id);
        if (!empty($n)) {
            $c    = count($n);
            $top  = 0;
            $left = 0;
            $i    = 0;
            foreach ($n as $key => $pro) {
                if ($i < $c) {
                    $nm .= "<button data-container='body' class='btn-prni btn-default product pos-tip' title='" . $pro->product_name . "'  value='" . $pro->product_code . "' type='button' id='product-" . $pro->product_id . "' product_id='" . $pro->product_id . "' product_price='" . $pro->product_price . "'  style='font-weight:bold; font-size:14px; height:120px; min-width:160px;max-width:180px;position:absolute; top:" . $top . "px; left:" . $left . "px;'> 
                
<img class='img-rounded col-xs-7' style='max-height:113px; padding:0px;' alt='" . $pro->product_name . "' src='" . asset_url() . "uploads/thumbs/" . $pro->product_thumb . "'>

" . $pro->product_name . "<br>" . $pro->product_price . "
                
                </button>";
                    if ($left <= 550) {
                        $left += 170;
                    } else {
                        $top += 130;
                        $left = 0;
                    }
                    $i++;
                } else {
                    $i++;
                }
            }
            echo $nm;
        } else {
            echo "<div></div>";
        }
    }
    public function getProductDataByCode()
    {
        $emp_array             = array();
        $product_code          = $this->input->get('code');
        $customer_id           = $this->input->get('customer_id');
        $warehouse_id          = $this->input->get('warehouse_id');
        $get_product_all_by_id = $this->pos_model->get_product_by_code($product_code, $customer_id, $warehouse_id);
        if (!empty($get_product_all_by_id)) {
            $empar = array();
            foreach ($get_product_all_by_id as $key => $value) {
                $r     = $get_product_all_by_id[$key];
                $lb    = $get_product_all_by_id[$key]->product_name;
                $label = array(
                    "id" => mt_rand(10, 10000),
                    "product_id" => $get_product_all_by_id[$key]->product_id,
                    "product_code" => $get_product_all_by_id[$key]->product_code,
                    "product_price" => $get_product_all_by_id[$key]->product_price,
                    "label" => $get_product_all_by_id[$key]->product_code . ' | ' . $get_product_all_by_id[$key]->product_name,
                    "product_name" => $get_product_all_by_id[$key]->product_name,
                    "value" => $get_product_all_by_id[$key]->product_name
                );
                array_push($empar, $label);
            }
            echo json_encode($empar);
        } else {
            echo '[{"id":0,"label":"No matching result found! Product might be out of stock in the selected warehouse.","value":"hg"}]';
        }
    }
    public function loadProductArray()
    {
        $emp_array             = array();
        $returnstr             = array();
        $product_code          = null;
        $customer_id           = $this->input->get('customer_id');
        $warehouse_id          = $this->input->get('warehouse_id');
        $get_product_all_by_id = $this->pos_model->get_product_by_code($product_code, $customer_id, $warehouse_id);
        if (!empty($get_product_all_by_id)) {
            $empar = array();
            foreach ($get_product_all_by_id as $key => $value) {
                $label = array(
                    "id" => mt_rand(10, 10000),
                    "product_id" => $get_product_all_by_id[$key]->product_id,
                    "product_code" => $get_product_all_by_id[$key]->product_code,
                    "product_price" => $get_product_all_by_id[$key]->product_price,
                    "label" => $get_product_all_by_id[$key]->product_code . ' | ' . $get_product_all_by_id[$key]->product_name,
                    "product_name" => $get_product_all_by_id[$key]->product_name,
                    "value" => $get_product_all_by_id[$key]->product_name
                );
                array_push($empar, $label);
            }
            $returnstr = json_encode($empar);
            return $returnstr;
        } else {
            echo '[{"id":0,"label":"No matching result found! Product might be out of stock in the selected warehouse.","value":"hg"}]';
        }
    }
    private function validate_customer_by_phone($phone, $name)
    {
        if ($phone == "" || $name = "") {
            return 1;
        }
        $query = $this->db->get_where('customer', array(
            'cus_phone    ' => $phone
        ));
        if ($query->num_rows() > 0) {
            $row = $query->row();
            return $row->cus_id;
        } else {
            // If category not found, insert into database and return new cat_id
            $this->db->insert('customer', array(
                'cus_phone' => $phone,
                'cus_code' => $phone,
                'cus_name' => $name,
                'cus_type_id' => 1
            ));
            return $this->db->insert_id();
        }
    }
    function getNumericValue($input_string)
    {
        // Remove leading and trailing whitespaces
        $input_string = trim($input_string);
        // Check if the string is empty
        if ($input_string === '') {
            return 0; // Return 0 for an empty string
        }
        // Check if the string is numeric
        if (is_numeric($input_string)) {
            // Convert the string to a numeric value
            $numeric_value = floatval($input_string);
            return $numeric_value;
        } else {
            // Return 0 if the string is not numeric
            return 0;
        }
    }
    
    public function pos_submit()
    {
        $this->db->insert('post_log', array(
            'url' => $this->input->server('REQUEST_URI'),
            'post_data' => json_encode($this->input->post()),
            'user_id'   => $this->session->userdata('ss_user_id'),
            'location_id'   => $this->session->userdata('ss_warehouse_id'),
        ));
        
        $this->load->model('stock_model');
        $this->load->model('Product_Models');
        $this->load->model('sales_model');
        $cashierFloatId = $this->session->userdata('ss_cashier_float_id');
        if ($cashierFloatId <= 0) {
            echo json_encode(array(
                'success' => false,
                'sale_id' => 0,
                'sale_ref' => 0,
                'error' => '1',
                'disMsg' => 'PLEASE START NEW CASHIER FLOAT',
                'duplicate' => 0
            ));
            return;
        }
        $this->load->library('form_validation');
        $this->form_validation->set_rules('uniq_id', 'Bill is unique', 'is_unique[sales.uniq_id]');
        if (!$this->form_validation->run()) {
            echo json_encode(array(
                'success' => true,
                'sale_id' => 0,
                'sale_ref' => $this->input->post('uniq_id'),
                'error' => '1',
                'disMsg' => 'this bill already added. please use reprint if you haven\'t received bill print',
                'duplicate' => 1
            ));
            return;
        }
        $this->load->model('customer_model');
        $sale_id   = $this->input->post('sale_id');
        $cus_phone = ($this->input->post('cus_phone') != "") ? $this->format_phone($this->input->post('cus_phone')) : "";
        //$cus_name  = ($this->input->post('cus_name') != "") ? ($this->input->post('cus_name')) : "";
        /*if ($cus_phone == "error") {
            echo json_encode(array(
                'success' => false,
                'sale_id' => '',
                'sale_ref' => '',
                'error' => '1',
                'duplicate' => '0',
                'disMsg' => 'Invalid phone!'
            ));
            exit;
        }*/
        $cus_name             = $this->input->post('cus_name');
        //$customer_id          = $this->customer_model->validate_customer_by_phone($cus_phone, $cus_name);
        $customer_id          = $this->validate_customer_by_phone($cus_phone, $cus_name);
        /*print_r($customer_id);
        exit;*/
        //$customer_id              = $this->input->post('poscustomer');
        $location_id          = $this->input->post('poswarehouse');
        $inv_discount         = $this->input->post('discount');
        $pos_discount_input   = $this->input->post('pos_discount_input');
        $extra_charges        = $this->input->post('extra_charges');
        $extra_charges_amount = $this->input->post('extra_charges_amount');
        $pay_amount           = $this->input->post('pay_amount'); // total given amount
        $pay_cash             = $this->input->post('pay_cash');
        $pay_cc               = $this->input->post('pay_cc');
        $grand_total          = $this->input->post('grand_total');
        $paid_by              = $this->input->post('paid_by');
        $cc_name              = $this->input->post('cc_name');
        $cc_no                = $this->input->post('cc_no');
        $pcc_holder           = $this->input->post('pcc_holder');
        $pcc_type             = $this->input->post('pcc_type');
        $payment_note         = $this->input->post('payment_note');
        $shipping             = $this->input->post('posshipping');
        $uniq_id              = $this->input->post('uniq_id');
        $sale_date            = date('Y-m-d H:i:s', strtotime($this->input->post('sale_datetime')));
        $salei_date           = date('Y-m-d', strtotime($this->input->post('sale_datetime')));
        //$sale_ref             = $this->input->post('sale_reference_no');
        //if (!$sale_ref) {
        //$sale_ref = $this->common_model->gen_ref_number("sale_id", "sales", "S");
        //}
        $cus_type             = $this->input->post('cus_type');
        if ($extra_charges_amount > 0) {
        } else {
            $extra_charges_amount = 0;
        }
        $table_id                 = $this->input->post('table_id');
        /*$floor_id                 = $this->input->post('floor_id');*/
        /*$division_id              = $this->input->post('division_id');*/
        $pr_id                    = $this->input->post('product_id');
        $product_code             = $this->input->post('product_code');
        $product_name             = $this->input->post('product_name');
        $net_price                = $this->input->post('net_price');
        $ssubtotal                = $this->input->post('ssubtotal');
        $quantity                 = $this->input->post('quantity');
        $print_status             = $this->input->post('print_status');
        $item_print_status        = 0;
        $sale_pymnt_balane_amount = $this->input->post('balance_amount');
        $shipping_address         = $this->input->post('shipping_address');
        $dine_type                = $this->input->post('delivery_status');
        $sale_status              = 0; // $this->input->post('sale_status');
        $kot_id                   = $this->input->post('kot_id');
        $kitchen_note             = $this->input->post('kitchen_note');
        $uniq_id                  = $this->input->post('uniq_id');
        $waiter_id                = $this->input->post('waiter_id');
        $odr_type                 = $this->input->post('odr_type');
        $separate_status          = $this->input->post('separate_status');
        $is_seperate              = $this->input->post('is_seperate');
        $call_order               = $this->input->post('call_order');
        $discount                 = $this->input->post('product_discount');
        $discount_val             = $this->input->post('product_discount_amount');
        $product_ott              = $this->input->post('product_ott');
        $kot_ref_no               = $this->input->post('kot_ref_no');
        if ($grand_total > 0) {
            //go as normal
        } else {
            $this->db->insert('error_log', array(
                'url' => $this->input->server('REQUEST_URI'),
                'post_data' => json_encode($this->input->post()),
                'user_id'   => $this->session->userdata('ss_user_id'),
                'location_id'   => $this->session->userdata('ss_warehouse_id'),
                'error_from' => 'A01'
            ));
            echo json_encode(array(
                'success' => true,
                'sale_id' => 0,
                'sale_ref' => $this->input->post('uniq_id'),
                'error' => '1',
                'disMsg' => 'INVALID INVOICE DATA. PLEASE ADD AGAIN!',
                'duplicate' => 1
            ));
            return false;
        }
        $odr_type = 1;
        if (isset($call_order)) {
            if ($call_order == 1) {
                $odr_type = 2;
            }
        }
        if ($waiter_id == '') {
            $waiter_id = null;
        }
        if ($dine_type == 3) {
            if ($cus_phone == "") {
                echo json_encode(array(
                    'success' => false,
                    'sale_id' => '',
                    'sale_ref' => '',
                    'error' => '1',
                    'disMsg' => 'Customer phone number is required!'
                ));
                exit;
            }
        }
        if ($table_id > 0) {
        } else {
            $table_id = 0;
        }
        //echo $pay_amount;
        if ($pay_amount == 0) {
            $sale_status = 1;
        } else if ($pay_amount >= $grand_total) {
            //$sale_status = 3;
        } else if ($pay_amount == $grand_total) {
            //$sale_status = 2;
        }
        $queries         = array();
        $continued       = $this->input->post('continued');
        if(!$continued){
            $this->form_validation->set_rules('sale_id', 'Sale id unique', 'is_unique[sales.sale_id]');
            if (!$this->form_validation->run()) {
                echo json_encode(array(
                    'success' => true,
                    'sale_id' => 0,
                    'sale_ref' => $this->input->post('uniq_id'),
                    'error' => '1',
                    'disMsg' => 'this bill already added. please use reprint if you haven\'t received bill print',
                    'duplicate' => 1
                ));
                $this->db->insert('error_log', array(
                    'url' => $this->input->server('REQUEST_URI'),
                    'post_data' => json_encode($this->input->post()),
                    'user_id'   => $this->session->userdata('ss_user_id'),
                    'location_id'   => $this->session->userdata('ss_warehouse_id'),
                    'error_from' => 'A02'
                ));
                return;
            }
        }
        $sales_data      = array(
            'sale_id' => $sale_id,
            'warehouse_id' => $location_id,
            'sale_reference_no' => $sale_id,
            'customer_id' => $customer_id,
            'sale_datetime' => $sale_date,
            /*'sale_note' => $payment_note,*/
            'sale_total' => $grand_total,
            'sale_inv_discount' => $pos_discount_input,
            'sale_inv_discount_amount' => $inv_discount,
            'paid_by' => $paid_by,
            'sale_shipping' => $shipping,
            //'invoice_type' => 1,
            'shipping_address' => $shipping_address,
            'dine_type' => $dine_type,
            //'sale_extra_charges' => $extra_charges,
            //'sale_extra_charges_amount' => $extra_charges_amount,
            'user' => $this->session->userdata('ss_user_id'),
            //'division_id' => $division_id,
            'table_id' => $table_id,
            //'floor_id' => $floor_id,
            'sale_status' => $cus_type == 2 ? 3 : $sale_status,
            'sale_cook_status' => 'pending',
            'kitchen_note' => $kitchen_note,
            'continued' => $continued,
            'uniq_id' => $uniq_id,
            'waiter_id' => $waiter_id,
            'odr_type' => $odr_type,
            'float_id' => $this->session->userdata('ss_cashier_float_id'),
            'pay_visa' => floatval($pay_cc),
            'pay_cash' => floatval($pay_cash),
        );
        $header_response = null;
        //$this->db->insert('sales_log', $sales_data);
        $this->db->trans_start();
        $queries[] = $this->db->last_query();
        if ($continued) {
            $header_response = $this->pos_model->save_sale_header($sales_data, $sale_id);
        } else {
            $header_response = $this->pos_model->save_sale_header($sales_data);
        }
        $queries[] = $this->db->last_query();
        if ($header_response) {
            $kot_item_count = $this->input->post('kot_item_count') ? $this->input->post('kot_item_count') : 0;
            $kot_id         = $this->input->post('kot_id') ? $this->input->post('kot_id') : null;
            if($kot_id > 0){
                $kot_data = array('is_auto_printed' => 0);
                $this->db->where('kot_id', $kot_id);
                $this->db->update('kot_master',$kot_data);
            }
            
            if($this->input->post("ns") === "off" && $kot_item_count > 0){
                $get_alrady_no_of_kot = $this->pos_model->check_no_of_kot_in_date(date("Y-m-d"));
                $get_alrady_no_of_kot += 1;
                $kot_data = array(
                    'sale_id' => $sale_id,
                    'system_date_time' => date("Y-m-d H:i:s"),
                    'location_id' => $this->session->userdata('ss_warehouse_id'),
                    'user_id' => $this->session->userdata('ss_user_id'),
                    'kot_ref_no' => substr($sale_id, -4)
                );
                $kot_id   = $this->pos_model->save_kot_master($kot_data);
            }
            
            $recipe_having_items = array();
            $item_list           = array();
            $movements_list      = array();
            $tot_cost            = 0;
            if (!empty($pr_id)) {
                for ($i = 0; $i < count($pr_id); $i++) {
                    $product_id   = $pr_id[$i];
                    $product_des  = $this->Product_Models->get_product_cost_by_id($product_id);
                    $product_cost = $product_des->product_cost;
                    $qty          = $quantity[$i];
                    $tot_cost_itm = $product_cost * $qty;
                    $tot_cost     = $tot_cost + $tot_cost_itm;
                    $np           = $net_price[$i];
                    $ssb          = $qty * $np;
                    $sepr_status  = 0;
                    if (isset($is_seperate)) {
                        if ($is_seperate == 1) {
                            $sepr_status = 1;
                        }
                    }
                    $item_data             = array(
                        'sale_id' => $sale_id,
                        'product_id' => $pr_id[$i],
                        'product_code' => $product_code[$i],
                        'product_name' => $product_name[$i],
                        'quantity' => $quantity[$i],
                        'unit_price' => $net_price[$i],
                        'gross_total' => $ssubtotal[$i],
                        'print_status' => $print_status[$i],
                        'discount' => $discount[$i],
                        'discount_val' => $this->getNumericValue($discount_val[$i]),
                        'item_cost' => $product_cost,
                        'sale_datetime' => $salei_date,
                        'user' => $this->session->userdata('ss_user_id'),
                        'kot_id' => $product_ott[$i] > 0 ? $kot_id : 0, //$this->check_is_product_kot_enable($pr_id[$i]) ? $kot_id : 0,
                        'cost_total' => $quantity[$i] * $product_cost,
                        'separate_status' => $sepr_status,
                        'float_id' => $this->session->userdata('ss_cashier_float_id')
                    );
                    $item_list[]           = $item_data;
                    $data                  = array(
                        'location_id' => $location_id,
                        'transaction_id' => $uniq_id,
                        'product_id' => $pr_id[$i],
                        'quantity' => floatval($quantity[$i]),
                        'unit_value' => floatval($net_price[$i]),
                        'movement_type' => 'out',
                        'movement_date' => $sale_date,
                        'origin' => 'sale',
                        'origin_id' => $sale_id
                    );
                    $movements_list[]      = $data;
                    $recipe_having_items[] = array(
                        'product_id' => $pr_id[$i],
                        'quantity' => $quantity[$i]
                    );
                }
                // save sale items
                $this->pos_model->sale_items_in_all($item_list);
                $this->db->insert_batch('sale_items_log', $item_list);
            }
            /*clearing Bullshit towards this point*/
            $total_given_amount = $pay_amount;
            // save payments
            if ($total_given_amount <= $grand_total) {
                $pay_amount = $total_given_amount;
            } else {
                $pay_amount = $grand_total;
            }
            $payments = $this->input->post('payment');
            //print_r($payments);
            
            if ($pay_amount > 0) {
                if(!empty($payments)){
                    foreach($payments as $key=>$row){
                        $pmData = array(
                            'sale_id' => $sale_id,
                            'sale_pymnt_paying_by' => $row['type'],
                            'sale_pymnt_amount' => $row['amount'],
                            'sale_pymnt_date_time' => $sale_date,
                            'sale_pymnt_added_date_time' => date("Y-m-d H:i:s"),
                            'sale_pymnt_crdt_card_no' => '',
                            'sale_pymnt_crdt_card_holder_name' => '',
                            'sale_pymnt_crdt_card_type' => '',
                            'sale_payment_type' => 'sale',
                            'sale_pymnt_given_amount' => $row['amount'],
                            'sale_pymnt_balance_amount' => 0,
                            'user_id' => $this->session->userdata('ss_user_id'),
                            'float_id' => $this->session->userdata('ss_cashier_float_id')
                            );
                        $this->db->insert('sale_payments', $pmData);
                        $queries[] = $this->db->last_query();
                    }
                }
                /*exit;*/
                /*if ($pay_cc) {
                    if ($pay_cc <= $grand_total) {
                        $pmData = array(
                            'sale_id' => $sale_id,
                            'sale_pymnt_paying_by' => "visa",
                            'sale_pymnt_amount' => $pay_cc,
                            'sale_pymnt_date_time' => $sale_date,
                            'sale_pymnt_added_date_time' => date("Y-m-d H:i:s"),
                            'sale_pymnt_crdt_card_no' => '',
                            'sale_pymnt_crdt_card_holder_name' => '',
                            'sale_pymnt_crdt_card_type' => '',
                            'sale_payment_type' => 'sale',
                            'sale_pymnt_given_amount' => $pay_cc,
                            'sale_pymnt_balance_amount' => 0,
                            'user_id' => $this->session->userdata('ss_user_id'),
                            'float_id' => $this->session->userdata('ss_cashier_float_id')
                        );
                        $this->db->insert('sale_payments', $pmData);
                        $queries[] = $this->db->last_query();
                        
                        if ($pay_cash) {
                            $rem_pymnt = $grand_total - $pay_cc;
                            if($rem_pymnt <= $pay_cash){
                                $pmData = array(
                                    'sale_id' => $sale_id,
                                    'sale_pymnt_paying_by' => "cash",
                                    'sale_pymnt_amount' => $rem_pymnt,
                                    'sale_pymnt_date_time' => $sale_date,
                                    'sale_pymnt_added_date_time' => date("Y-m-d H:i:s"),
                                    'sale_pymnt_crdt_card_no' => '',
                                    'sale_pymnt_crdt_card_holder_name' => '',
                                    'sale_pymnt_crdt_card_type' => '',
                                    'sale_payment_type' => 'sale',
                                    'sale_pymnt_given_amount' => $pay_cash,
                                    'sale_pymnt_balance_amount' => 0,
                                    'user_id' => $this->session->userdata('ss_user_id'),
                                    'float_id' => $this->session->userdata('ss_cashier_float_id')
                                );
                                $this->db->insert('sale_payments', $pmData);
                                $queries[] = $this->db->last_query();
                            }
                        }
                    } else {
                        // error
                    }
                } else {
                    if ($pay_cash) {
                        if($grand_total >= $pay_cash ){
                            $pmData = array(
                                'sale_id' => $sale_id,
                                'sale_pymnt_paying_by' => "cash",
                                'sale_pymnt_amount' => $pay_cash,
                                'sale_pymnt_date_time' => $sale_date,
                                'sale_pymnt_added_date_time' => date("Y-m-d H:i:s"),
                                'sale_pymnt_crdt_card_no' => '',
                                'sale_pymnt_crdt_card_holder_name' => '',
                                'sale_pymnt_crdt_card_type' => '',
                                'sale_payment_type' => 'sale',
                                'sale_pymnt_given_amount' => $pay_cash,
                                'sale_pymnt_balance_amount' => 0,
                                'user_id' => $this->session->userdata('ss_user_id'),
                                'float_id' => $this->session->userdata('ss_cashier_float_id')
                            );
                            $this->db->insert('sale_payments', $pmData);
                            $queries[] = $this->db->last_query();
                        }else if($grand_total < $pay_cash ){
                            $pmData = array(
                                'sale_id' => $sale_id,
                                'sale_pymnt_paying_by' => "cash",
                                'sale_pymnt_amount' => $grand_total,
                                'sale_pymnt_date_time' => $sale_date,
                                'sale_pymnt_added_date_time' => date("Y-m-d H:i:s"),
                                'sale_pymnt_crdt_card_no' => '',
                                'sale_pymnt_crdt_card_holder_name' => '',
                                'sale_pymnt_crdt_card_type' => '',
                                'sale_payment_type' => 'sale',
                                'sale_pymnt_given_amount' => $pay_cash,
                                'sale_pymnt_balance_amount' => 0,
                                'user_id' => $this->session->userdata('ss_user_id'),
                                'float_id' => $this->session->userdata('ss_cashier_float_id')
                            );
                            $this->db->insert('sale_payments', $pmData);
                            $queries[] = $this->db->last_query();
                        }
                    }
                }*/
                // update finance movement
                
                // $data = array(
                //     'transaction_date' => date('Y-m-d H:i:s'), // You can use any date format here
                //     'transaction_type' => 'income', // Or 'expense' or 'transfer'
                //     'transaction_method' => $sale_pymnt_paying_by, // cash / visa
                //     'amount' => $sale_pymnt_amount,
                //     'currency' => 'LKR',
                //     'description' => 'Income from sales',
                //     'reference_id' => $reference_id, // If there's no related transaction, set it to null
                //     'created_by_user_id' => $user_id // Provide the user ID who initiated the transaction
                // );
                // $this->Common_Model->insert_transaction($data);
                
                if($grand_total > 0){
                    $total_paid_amount = $this->sales_model->get_total_paid_by_sale_id($sale_id);
                    $total_advance_paid_amount = 0;
                    
                    $return_tot_amt    = 0;
                    $to_be_paid        = $grand_total - $return_tot_amt;
                    $balance = $to_be_paid - $total_paid_amount;
                    $pay_st = 'pending';
                    if($balance == 0){
                        $pay_st = 'paid';
                    }else if($balance < $to_be_paid){
                        $pay_st = 'partial';
                    }
                    $update = array(
                        'total_paid' => $total_paid_amount,
                        'total_balance' => $balance,
                        'payment_status' => $pay_st,
                        'sale_status' => 3
                    );
                    $this->db->where('sale_id',$sale_id);
                    $this->db->update('sales', $update);
                    //echo $this->db->last_query();
                }
            
                
            }
            $sales_data = array();
            if ($continued == 1) {
                $item_total               = $this->pos_model->get_sale_item_totals($sale_id);
                $sales_data['sale_total'] = $item_total['gross_total'];
                $sales_data['cost_total'] = $item_total['cost_total'];
                $this->pos_model->update_sale_header($sales_data, $sale_id);
                $queries[] = $this->db->last_query();
            }
            /*if ($dine_type == 1) {
            //$this->pos_model->complete_sale($sale_id);
            } else if ($dine_type == 2) {
            $msg = "Thank you for Choosing Indian Hut Restaurant. Your order #" . $sale_id . " will be ready soon.\nOrder Amount: " . $grand_total;
            if ($cus_phone){
            //$this->sms_model->send_sms($cus_phone, $msg);
            }
            } else if ($dine_type == 3) {
            $msg = "Thank you for Choosing Indian Hut Restaurant. Your order #" . $sale_id . " will be ready.\nOrder Amount: " . $grand_total;
            if ($cus_phone){
            //$this->sms_model->send_sms($cus_phone, $msg);
            }
            }*/
            $track_data = array(
                'trans_id' => $uniq_id,
                'location_id' => $location_id,
                'date_time' => $sale_date,
                'added_by' => $this->session->userdata('ss_user_id')
            );
            $this->stock_model->stock_m_tracker($track_data);
            //$is_sc = true;
            if (!empty($recipe_having_items)) {
                foreach ($recipe_having_items as $itm) {
                    $recipe = $this->get_recipe($location_id, $itm['product_id']);
                    //print_r($recipe);
                    foreach ($recipe as $rcp_itm) {
                        $data             = array(
                            'location_id' => $location_id,
                            'transaction_id' => $uniq_id,
                            'product_id' => $rcp_itm->ingredient_id,
                            'quantity' => $rcp_itm->quantity * $itm['quantity'],
                            'unit_value' => floatval($rcp_itm->cost_per_item),
                            'movement_type' => 'out',
                            'movement_date' => $sale_date,
                            'origin' => 'consume',
                            'origin_id' => $sale_id
                        );
                        $movements_list[] = $data;
                    }
                }
            }
            if (!empty($movements_list)){
                $this->stock_model->bulkInsertMovements_($movements_list);
                $queries[] = $this->db->last_query();
                //print_r($queries);
            }
            $this->db->trans_complete();
            if ($this->db->trans_status() === FALSE) {
                echo json_encode(array(
                    'success' => false,
                    'sale_id' => $sale_id,
                    'error' => '0',
                    'disMsg' => '101',
                    'alter' => $queries
                ));
                exit;
            } else {
                echo json_encode(array(
                    'success' => true,
                    'sale_id' => $sale_id,
                    'error' => '0',
                    'disMsg' => '100',
                    'alter' => $queries
                ));
                exit;
            }
        } else {
            echo json_encode(array(
                'success' => false,
                'sale_id' => $sale_id,
                'error' => '1',
                'disMsg' => 'Sales record has not saved'
            ));
            return false;
        }
        exit;
    }
    function save_sp($data)
    {
    }
    function check_is_product_kot_enable($product_id)
    {
        $this->db->from('product');
        $this->db->where("ott !=", 0);
        $this->db->where("product_id", $product_id);
        $query = $this->db->get();
        return $query->num_rows();
    }
    function get_recipe($location_id, $product_id)
    {
        $this->db->select('product_id,ingredient_id,quantity,cost_per_item');
        $this->db->from('recipe_items');
        $this->db->where('product_id', $product_id);
        $this->db->where('location_id', $location_id);
        $this->db->where('is_active', 1);
        $query = $this->db->get();
        return $query->result();
    }
    public function view_bill()
    {
        $data['category_by_id_1'] = $this->pos_model->get_product_by_cat_id(1);
        $data['category']         = $this->pos_model->get_all_category();
        $data['sub_category']     = $this->pos_model->get_sub_category_by_cat_id(1);
        $data['get_customer']     = $this->pos_model->get_customer();
        $data['get_warehouse']    = $this->pos_model->get_warehouse();
        $this->load->view('pos/pos-bill', $data);
    }
    public function sale_print()
    {
        $data['sale_id']        = $this->input->get('sale_id');
        $data['pay_amount']     = $this->input->get('pay_amount');
        $data['paid_by']        = $this->input->get('paid_by');
        $data['balance_amount'] = $this->input->get('balance_amount');
        $this->load->view('pos_print_nav', $data);
    }
    public function list_pos_sales()
    {
        $search_key     = $this->input->get('search');
        $search_key_val = $search_key['value'];
        $start          = $this->input->get('start');
        $length         = $this->input->get('length');
        $dine_type      = $this->input->get('dine_type');
        $cus_id         = $this->input->get('cus_id');
        $sales          = '';
        $totalData      = 0;
        if ($search_key_val) {
            $sales     = $this->pos_model->get_all_sales($start, $length, $search_key_val, $dine_type, '1', '', $cus_id);
            $sales_c   = $this->pos_model->get_all_sales_c('', '', $search_key_val, $dine_type, '1', $cus_id);
            $sales_c   = $sales_c[0]['count_s'];
            $totalData = $sales_c;
        } else {
            $sales     = $this->pos_model->get_all_sales($start, $length, '', $dine_type, '1', '', $cus_id);
            $sales_c   = $this->pos_model->get_all_sales_c('', '', '', $dine_type, '1', '', $cus_id);
            $sales_c   = $sales_c[0]['count_s'];
            $totalData = $sales_c;
        }
        $totalFiltered = $totalData;
        $style         = '';
        $data          = array();
        if ($this->session->userdata('ss_group_id') == 3) {
            $style = 'display:none';
        }
        if (!empty($sales)) {
            foreach ($sales as $row) {
                $nestedData        = array();
                $sale_id           = $row['sale_id'];
                $total_paid_amount = 0;
                $total_paid_amount = $this->pos_model->get_total_paid_by_sale_id($sale_id);
                $return_tot_amt    = 0;
                $sale_items        = $this->pos_model->get_sale_items_by_sale_id($sale_id);
                $si                = '<table class="table table-condensed dataTable">';
                for ($i = 0; $i < count($sale_items); $i++) {
                    $si = $si . '<tr><td class="col-xs-11">' . $sale_items[$i]['product_name'] . '</td><td class="col-xs-1"> ' . intval($sale_items[$i]['quantity']) . '' . '</td></tr>';
                }
                $si            = $si . '</table>';
                $to_be_paid    = $row['sale_total'] - $return_tot_amt;
                $nestedData[]  = $row['sale_reference_no'];
                $nestedData[]  = date('Y/m/d - g:i A', strtotime($row['sale_datetime']));
                $nestedData[]  = $row['cus_name'] . ' | TABLE NO :' . $row['table_id'];
                $nestedData[]  = $si;
                $nestedData[]  = '<p style="text-align:right">' . $row['sale_total'] . '</p>';
                $btn           = '';
                $cash_input    = '';
                $add_pymnt_div = '';
                $payment_grid  = '<p style="white-space:nowrap">- payment completed -</p>';
                if ($dine_type != 3) {
                    if (empty($total_paid_amount)) {
                        $pay_st        = '<span class="label label-warning" style="font-size:14px">Pending</span>';
                        $cash_input    = '<input style="width:100%;" class="form-control input-md py_amt" sale-id="' . $sale_id . '" id="c_pay_amount_' . $sale_id . '" onclick="this.select()" value="' . $to_be_paid . '"/>';
                        $payment_grid  = '
                                <select class="form-control paid_by select2-nosearch" id="paying_by_' . $sale_id . '" name="paying_by' . $sale_id . '" >
                                    <option value="Cash" selected="selected">Cash &nbsp;&nbsp;</option>
                                    <option value="CC">Credit Card &nbsp;&nbsp;</option>
                                </select>';
                        $add_pymnt_div = '<div class="label label-success col-xs-12" style="cursor:pointer;font-size: 14px; margin:1px; padding:20px;" onClick ="set_as_paid(' . $sale_id . ') ">Add Payment </div>';
                        $btn           = '<div align="center" class"col-xs-12">
                                            <div class="label label-info    col-xs-12" style="cursor:pointer;font-size: 14px; margin:1px; padding:20px;" onClick ="fbs_click_pos_no_c(' . $sale_id . ') ">Print Bill</div>
                                            <div class="label label-warning col-xs-12 " style="cursor:pointer;font-size: 14px; margin:5px 0px 1px 0px; padding:20px;" onClick ="edit_sale(' . $sale_id . ') ">CONTINUE ></div>
                                        </div>';
                    } else {
                        if ($total_paid_amount >= $to_be_paid) {
                            $btn    = '    <div align="center" class"col-xs-12">
                                        <span class="label label-warning col-xs-12" style="cursor:pointer;font-size: 14px; margin:1px; padding:20px;" onClick ="complete_sale(' . $sale_id . ') ">Complete Sale</span>
                                        <span class="label label-info col-xs-12" style="cursor:pointer;font-size: 14px; margin:1px; padding:20px;" onClick ="complete_and_print(' . $sale_id . ') ">Complete and Print Sale</span>
                                    </div>';
                            $pay_st = '<span class="label label-success" style="font-size:14px">Paid</span>';
                        } else {
                            $pay_st       = '<span class="label label-info" style="font-size:14px">Partial</span>';
                            $cash_input   = '<input style="width:100%;" class="form-control input-md py_amt" sale-id="' . $sale_id . '" id="c_pay_amount_' . $sale_id . '" onclick="this.select()" value="' . $to_be_paid . ' />';
                            $payment_grid = '<select class="form-control paid_by select2-nosearch" id="paying_by_' . $sale_id . '" name="paying_by' . $sale_id . '" >
                                             <option value="Cash" selected="selected">Cash &nbsp;&nbsp;</option>
                                             <option value="CC">Credit Card &nbsp;&nbsp;</option>
                                         </select>';
                            $btn          = '<center><span class="label label-warning" style="cursor:pointer;font-size: 15px" onClick ="complete_and_print(' . $sale_id . ') "><i class="fa fa-print"></i></span></center>';
                        }
                    }
                } else {
                    $btn          = '    <div align="center" class"col-xs-12">
                                        <span class="label label-warning col-xs-12" style="cursor:pointer;font-size: 14px; margin:1px; padding:20px;" onClick ="complete_sale(' . $sale_id . ') ">Deliver without reciept</span>
                                        <span class="label label-info col-xs-12" style="cursor:pointer;font-size: 14px; margin:1px; padding:20px;" onClick ="complete_and_print(' . $sale_id . ') ">Deliver</span>
                                    </div>';
                    $pay_st       = '<span class="label label-warning" style="font-size:14px">Pending</span>';
                    $cash_input   = '';
                    $payment_grid = $row['shipping_address'];
                }
                $nestedData[] = '<center>' . $pay_st . '</center>';
                $nestedData[] = '<div class="col-xs-12" style="padding:0px">
                                            <div class="col-xs-6">' . $payment_grid . '</div>
                                            <div class="col-xs-6">' . $cash_input . '</div>
                                             <div class="col-xs-12">' . $add_pymnt_div . '</div>
                                            
                                        </div>';
                '<div class="btn-group text-left">
                <button data-toggle="dropdown" class="btn btn-default btn-xs btn-primary dropdown-toggle" type="button">Actions <span class="caret"></span></button>
                <ul role="menu" class="dropdown-menu pull-right">
                <li><a href="' . base_url() . 'sales/view/' . $sale_id . '"><i class="fa fa-file-text-o"></i> Sale Details</a></li>
                <li><a onClick="complete_and_print(' . $row['sale_id'] . ')" data-toggle="modal" href="#" data-placement="top" data-original-title="Edit suppliers"><i class="fa fa-print"></i> Print Sale</a></li>
                
                 <!--<li><a href="' . base_url() . 'sales_return/sales_return_add/' . $sale_id . '"><i class="fa fa-angle-double-left"></i></i> Return Sale</a></li>-->
                 <li style="' . $style . '"><a href="#" onClick ="delete_invoice(' . $sale_id . ')"><i class="fa fa-trash-o"></i></i> Delete Invoice</a></li>                    
                 <li style="' . $style . '"><a href="#" onClick ="delete_payments(' . $sale_id . ')"><i class="fa fa-trash-o"></i>    Delete Payments</a></li>
                </ul></div>';
                $nestedData[] = $btn;
                $data[]       = $nestedData;
            }
            $json_data = array(
                "recordsTotal" => intval($totalData),
                "recordsFiltered" => intval($totalFiltered),
                "data" => $data
            );
            echo json_encode($json_data);
        } else {
            $json_data = array(
                "recordsTotal" => '0',
                "recordsFiltered" => '0',
                "data" => ''
            );
            echo json_encode($json_data);
        }
    }
    public function get_customers()
    {
        $srh_customer_id = $this->input->get('srh_customer_id');
        $customers       = $this->pos_model->get_customers($srh_customer_id);
        echo json_encode($customers);
    }
    public function set_as_paid()
    {
        $sale_id              = $this->input->post('sale_id');
        $paid_by              = $this->input->post('paid_by');
        $sale_pymnt_date_time = $this->input->post('sale_pymnt_date_time');
        $given_amount         = $this->input->post('given_amount');
        $sale_details         = $this->pos_model->get_sale_info($sale_id);
        $t                    = $this->pos_model->sales_payment($sale_details[0]['sale_id'], $paid_by, $sale_details[0]['sale_total'], $sale_pymnt_date_time, '', '', '', '', "sale", $given_amount, '0');
        if ($t == true) {
            echo json_encode(array(
                'sale_id' => $sale_id,
                'error' => '0',
                'disMsg' => 'Paid !'
            ));
        } else {
            echo json_encode(array(
                'sale_id' => '',
                'error' => '0',
                'disMsg' => 'Something went wrong !'
            ));
        }
    }
    public function complete_sale_()
    {
        $sale_id = $this->input->post('sale_id');
        $t       = $this->pos_model->complete_sale($sale_id);
        if ($t == true) {
            echo json_encode(array(
                'sale_id' => $sale_id,
                'error' => '0',
                'disMsg' => 'Completed!'
            ));
        } else {
            echo json_encode(array(
                'sale_id' => '',
                'error' => '0',
                'disMsg' => 'Something went wrong !'
            ));
        }
    }
    function create_customers()
    {
        $data['nc']             = $this->input->get('nc');
        $data['id']             = 1;
        $data['main_menu_name'] = $this->main_menu_name;
        $data['sub_menu_name']  = 'create_customer';
        if (isset($_GET['cus_id'])) {
            $cus_id = $_GET['cus_id'];
        } else {
            $cus_id = '';
        }
        if ($cus_id) {
            $data['cus_id']   = $cus_id;
            $data['type']     = 'E';
            $data['pageName'] = 'UPDATE CUSTOMER';
            $data['btnText']  = 'Update Customer';
            $data['customer'] = $this->common_model->get_customer_info($cus_id);
        } else {
            $data['cus_id']   = '';
            $data['type']     = 'A';
            $data['pageName'] = 'ADD CUSTOMER';
            $data['btnText']  = 'Add Customer';
            $data['customer'] = array();
        }
        $data['country_list'] = $this->common_model->get_all_country();
        $this->load->view('models/create_customer', $data);
    }
    function save_pos_product()
    {
        if ($this->input->post('product_name') == '') {
            $st = array(
                'status' => 0,
                'validation' => 'ERROR'
            );
            echo json_encode($st);
        } else {
            $product_name = $this->input->post('product_name');
            $product_code = $this->input->post('product_code');
            $category     = $this->input->post('category');
            $subcategory  = $this->input->post('subcategory');
            if (!$subcategory)
                $subcategory = 0;
            $unit                    = $this->input->post('unit');
            $product_cost            = $this->price_filter($this->input->post('product_cost'));
            $product_price           = $this->price_filter($this->input->post('product_price'));
            $wholesale_price         = $this->price_filter($this->input->post('wholesale_price'));
            $credit_salling_price    = $this->price_filter($this->input->post('credit_salling_price'));
            $tax                     = $this->input->post('tax');
            $alert_quty              = $this->input->post('alert_quty');
            $product_details         = $this->input->post('product_details');
            $product_part_no         = $this->input->post('product_part_no');
            $product_oem_part_number = $this->input->post('product_oem_part_number');
            $product_id              = $this->input->post('product_id');
            $store_position          = $this->input->post('store_position');
            $product_max_qty         = floatval($this->input->post('product_max_qty'));
            $product_data            = array(
                'cat_id' => $category,
                'sub_cat_id' => $subcategory,
                'product_name' => $product_name,
                'product_alert_qty' => $alert_quty,
                'product_unit' => $unit,
                'product_cost' => $product_cost,
                'product_price' => $product_price,
                'wholesale_price' => $wholesale_price,
                'credit_salling_price' => $credit_salling_price,
                'tax' => $tax,
                'product_details' => $product_details,
                'product_part_no' => $product_part_no,
                'product_oem_part_number' => $product_oem_part_number,
                'store_position' => $store_position,
                'product_max_qty' => $product_max_qty
            );
            $last_id                 = $this->pos_model->save_product($product_data);
            if ($last_id) {
                $st = array(
                    'status' => 1,
                    'validation' => 'Done!',
                    'last_id' => "PD" . sprintf("%04d", $last_id + 1)
                );
                echo json_encode($st);
            } else {
                $st = array(
                    'status' => 0,
                    'validation' => 'error occurred please contact your system administrator'
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
    public function check()
    {
        $sale_items    = $this->pos_model->check1();
        $recorded_lost = 0;
        echo '<table style="border:solid 1px"><tr style="border:solid 1px"><th style="border:solid 1px">sale id</th><th style="border:solid 1px">qty</th><th style="border:solid 1px">price</th><th style="border:solid 1px">gross total</th><th style="border:solid 1px">calculated total</th><th style="border:solid 1px">loss</th></tr>';
        foreach ($sale_items as $row) {
            $this_lost = (($row['quantity'] * $row['unit_price']) - $row['gross_total']);
            $recorded_lost += $this_lost;
            echo '<tr>';
            echo '<td style="border:solid 1px;">' . $row['sale_id'] . '</td><td style="border:solid 1px">' . $row['quantity'] . '</td>' . '<td style="border:solid 1px">' . $row['unit_price'] . '</td><td style="border:solid 1px">' . $row['gross_total'] . '</td>' . '<td style="border:solid 1px">' . ($row['quantity'] * $row['unit_price']) . '</td>' . '<td style="border:solid 1px">' . (($row['quantity'] * $row['unit_price']) - $row['gross_total']) . '</td>';
            echo '</tr>';
        }
        echo '<th>qty</th><th>price</th><th>gross total</th><th>calculated total</th><th>' . $recorded_lost . '</th></table>';
    }
    function format_phone($phone)
    {
        $rv                    = "";
        $filtered_phone_number = filter_var($phone, FILTER_SANITIZE_NUMBER_INT);
        $phone_to_check        = str_replace("-", "", $filtered_phone_number);
        $phone_to_check        = intval($phone_to_check);
        if (strlen($phone_to_check) < 9 || strlen($phone_to_check) > 12) {
            $rv = "error";
        } else {
            $rv = substr($phone_to_check, -9);
            $rv = "0" . $rv;
        }
        return $rv;
    }
    // AUTO PRINT START
    //**************************************************************************
    //init page
    function ap_juice()
    {
        $data['cat_id']     = 1; //$this->input->get('cat_id');
        $data['auto_print'] = '';
        $data['auto_close'] = '';
        $ap                 = $this->input->get('ap');
        if ($ap == 1)
            $data['auto_print'] = 'myWindow.print();';
        $ap = $this->input->get('ac');
        if ($ap == 1)
            $data['auto_close'] = 'myWindow.close();';
        $this->load->view('pos/ap_page', $data);
    }
    function check_juice_printables()
    {
        $this->load->model("auto_print_model");
        $success   = false;
        $sale_id   = 0;
        $sale_id   = $this->input->post('sale_id');
        $cat_id    = $this->input->post('cat_id');
        $sale_data = $this->auto_print_model->check_juice_printables($cat_id, $sale_id);
        if (isset($sale_data->sale_id)) {
            if ($sale_data->sale_id > 0) {
                $sale_id = $sale_data->sale_id;
                $success = true;
            }
        }
        echo json_encode(array(
            "success" => $success,
            "sale_id" => $sale_id
        ));
    }
    //call print kot juice
    function ap_kot()
    {
        $this->load->model("auto_print_model");
        $sale_id            = $this->input->get('sale_id');
        $cat_id             = 999; //$this->input->get('cat_id');
        $data['sale_info']  = $this->auto_print_model->get_sale_info($sale_id);
        $data['sale_items'] = $this->auto_print_model->get_pending_sale_item_list_by_sale_id($sale_id, $cat_id);
        $this->load->view('pos/print_kot_silent', $data);
        $this->auto_print_model->set_printed($sale_id, $cat_id);
    }
    function ap_kot_json()
    {
        $success = false;
        $this->load->model("auto_print_model");
        $sale_id    = $this->input->get('sale_id');
        $cat_id     = 999; //$this->input->get('cat_id');
        $sale_info  = $this->auto_print_model->get_sale_info($sale_id);
        $sale_items = $this->auto_print_model->get_pending_sale_item_list_by_sale_id($sale_id, $cat_id);
        $data       = array();
        if (!empty($sale_items)) {
            $default_size      = "10";
            //bill_no
            $columns           = array();
            $columns[]         = "\t  B.O.T";
            $row['columns']    = $columns;
            $row['offset']     = 20;
            $row['font']       = "Courier New";
            $row['font_size']  = 12;
            $row['font_style'] = "bold";
            array_push($data, $row);
            //bill_no
            $columns           = array();
            $columns[]         = "BILL NO:" . $sale_info->sale_id;
            $row['columns']    = $columns;
            $row['offset']     = 22;
            $row['font']       = "Courier New";
            $row['font_size']  = $default_size;
            $row['font_style'] = "bold";
            array_push($data, $row);
            //dine type
            $columns = array();
            if ($sale_info->dine_type == 1) {
                $columns[] = "DINE IN";
            } else if ($sale_info->dine_type == 2) {
                $columns[] = "TAKE AWAY";
            } else if ($sale_info->dine_type == 3) {
                $columns[] = "DELIVERY";
            }
            $row['columns']    = $columns;
            $row['offset']     = 20;
            $row['font']       = "Courier New";
            $row['font_size']  = $default_size;
            $row['font_style'] = "bold";
            array_push($data, $row);
            //table
            $columns = array();
            if ($sale_info->dine_type == 1) {
                if ($sale_info->continued > 0) {
                    $columns[] = "CONTINUE TO TABLE " . $sale_info->table_id;
                } else
                    $columns[] = "TABLE " . $sale_info->table_id;
                $row['columns']    = $columns;
                $row['offset']     = 20;
                $row['font']       = "Courier New";
                $row['font_size']  = $default_size;
                $row['font_style'] = "bold";
                array_push($data, $row);
            }
            //blank line
            $row['columns'] = array();
            $row['offset']  = 10;
            array_push($data, $row);
            //sale items
            foreach ($sale_items as $item) {
                $columns           = array();
                $columns[]         = $item->product_name;
                $columns[]         = "-" . intval($item->quantity);
                $row['columns']    = $columns;
                $row['offset']     = 20;
                $row['font']       = "Courier New";
                $row['font_size']  = 13;
                $row['font_style'] = "bold";
                array_push($data, $row);
            }
            $success = true;
        }
        header("Content-type: application/json");
        echo json_encode(array(
            'success' => $success,
            'data' => $data
        ));
        $this->auto_print_model->set_printed($sale_id, $cat_id);
    }
    //END JUICE;
    //**************************************************************************
    function ap_kitchen()
    {
        $data['cat_id']     = 1; //$this->input->get('cat_id');
        $data['auto_print'] = '';
        $data['auto_close'] = '';
        $ap                 = $this->input->get('ap');
        if ($ap == 1)
            $data['auto_print'] = 'myWindow.print();';
        $ap = $this->input->get('ac');
        if ($ap == 1)
            $data['auto_close'] = 'myWindow.close();';
        $this->load->view('pos/ap_kitchen', $data);
    }
    function check_kitchen_printables()
    {
        $this->load->model("auto_print_model");
        $success   = false;
        $sale_id   = 0;
        $sale_id   = $this->input->post('sale_id');
        $cat_id    = 999; //$this->input->post('cat_id');
        $sale_data = $this->auto_print_model->check_kitchen_printables($cat_id, $sale_id);
        if (isset($sale_data->sale_id)) {
            if ($sale_data->sale_id > 0) {
                $sale_id = $sale_data->sale_id;
                $success = true;
            }
        }
        echo json_encode(array(
            "success" => $success,
            "sale_id" => $sale_id
        ));
    }
    function check_kitchen_orders()
    {
        $this->load->model("auto_print_model");
        $success   = false;
        $sale_id   = 0;
        $sale_id   = $this->input->post('sale_id');
        $cat_id    = 999; //$this->input->post('cat_id');
        $sale_data = $this->auto_print_model->check_kitchen_printables_by_is_ko($sale_id);
        if (isset($sale_data->sale_id)) {
            if ($sale_data->sale_id > 0) {
                $sale_id = $sale_data->sale_id;
                $success = true;
            }
        }
        echo json_encode(array(
            "success" => $success,
            "sale_id" => $sale_id
        ));
    }
    //call print kot kitchen
    function ap_kot_kitchen()
    {
        $this->load->model("auto_print_model");
        $sale_id            = $this->input->get('sale_id');
        $cat_id             = 999; //$this->input->get('cat_id');
        $data['sale_info']  = $this->auto_print_model->get_sale_info($sale_id);
        $data['sale_items'] = $this->auto_print_model->get_pending_kitchen_sale_item_list_by_sale_id($sale_id, $cat_id);
        $this->load->view('pos/print_kot_silent', $data);
        $this->auto_print_model->set_printed_kitchen($sale_id, $cat_id);
    }
    function ap_kot_kitchen_json()
    {
        $success = false;
        $this->load->model("auto_print_model");
        $sale_id    = $this->input->get('sale_id');
        $cat_id     = 999; //$this->input->get('cat_id');
        $sale_info  = $this->auto_print_model->get_sale_info($sale_id);
        $sale_items = $this->auto_print_model->get_pending_sale_item_list_for_direct_kitchen($sale_id);
        $data       = array();
        if (!empty($sale_items)) {
            $default_size      = "12";
            //bill_no
            $columns           = array();
            $columns[]         = "          K.O.T";
            $row['columns']    = $columns;
            $row['offset']     = 20;
            $row['font']       = "Consolas";
            $row['font_size']  = 13;
            $row['font_style'] = "bold";
            array_push($data, $row);
            //bill_no
            $columns           = array();
            $columns[]         = "BILL NO:" . $sale_info->sale_id;
            $row['columns']    = $columns;
            $row['offset']     = 20;
            $row['font']       = "Courier New";
            $row['font_size']  = $default_size;
            $row['font_style'] = "bold";
            array_push($data, $row);
            //Date Time - added
            $columns           = array();
            $columns[]         = "Added:" . $sale_info->sale_datetime;
            $row['columns']    = $columns;
            $row['offset']     = 20;
            $row['font']       = "Courier New";
            $row['font_size']  = $default_size;
            $row['font_style'] = "bold";
            array_push($data, $row);
            //Date Time
            $columns           = array();
            $columns[]         = "Printed:" . date("Y-m-d H:i a");
            $row['columns']    = $columns;
            $row['offset']     = 20;
            $row['font']       = "Courier New";
            $row['font_size']  = $default_size;
            $row['font_style'] = "bold";
            array_push($data, $row);
            //dine type
            $columns = array();
            if ($sale_info->dine_type == 1) {
                $columns[] = "DINE IN";
            } else if ($sale_info->dine_type == 2) {
                $columns[] = "TAKE AWAY";
            } else if ($sale_info->dine_type == 3) {
                $columns[] = "DELIVERY";
            }
            $row['columns']    = $columns;
            $row['offset']     = 20;
            $row['font']       = "Courier New";
            $row['font_size']  = $default_size;
            $row['font_style'] = "bold";
            array_push($data, $row);
            //NOTE
            $columns           = array();
            $columns[]         = "NOTE:" . $sale_info->kitchen_note;
            $row['columns']    = $columns;
            $row['offset']     = 20;
            $row['font']       = "Courier New";
            $row['font_size']  = $default_size;
            $row['font_style'] = "bold";
            array_push($data, $row);
            //table
            $columns = array();
            if ($sale_info->dine_type == 1) {
                if ($sale_info->continued > 0) {
                    $columns[] = "CONTINUE TO TABLE " . $sale_info->table_id;
                } else
                    $columns[] = "TABLE " . $sale_info->table_id;
                $row['columns']    = $columns;
                $row['offset']     = 20;
                $row['font']       = "Courier New";
                $row['font_size']  = $default_size;
                $row['font_style'] = "bold";
                array_push($data, $row);
            }
            //blank line
            $row['columns'] = array();
            $row['offset']  = 10;
            array_push($data, $row);
            //header
            $columns           = array();
            $columns[]         = "       ITEM          QTY";
            $row['columns']    = $columns;
            $row['offset']     = 20;
            $row['font']       = "Courier New";
            $row['font_size']  = $default_size;
            $row['font_style'] = "bold";
            array_push($data, $row);
            //sale items
            foreach ($sale_items as $item) {
                $columns           = array();
                $columns[]         = $item->product_name;
                $columns[]         = "-" . intval($item->quantity);
                $row['columns']    = $columns;
                $row['offset']     = 20;
                $row['font']       = "Courier New";
                $row['font_size']  = 12;
                $row['font_style'] = "bold";
                array_push($data, $row);
            }
            $success = true;
        }
        header("Content-type: application/json");
        echo json_encode(array(
            'success' => $success,
            'data' => $data
        ));
        $this->auto_print_model->set_printed_kitchen_order($sale_id, $cat_id);
    }
    function printed_successfully_kot()
    {
        $this->load->model("auto_print_model");
        $sale_id = $this->input->get('sale_id');
        $cat_id  = 999; //$this->input->get('cat_id');
        $result  = $this->auto_print_model->set_printed_kitchen_order($sale_id, $cat_id);
        echo json_encode(array(
            "result" => $result
        ));
    }
    //not using
    function set_printed()
    {
        $this->load->model("auto_print_model");
        $sale_id = $this->input->get('sale_id');
        $cat_id  = $this->input->get('cat_id');
        $result  = $this->auto_print_model->set_printed($sale_id, $cat_id);
        echo json_encode(array(
            "result" => $result
        ));
    }
    function check_user()
    {
        $this->load->model("User_Model");
        $this->load->library('form_validation'); //form validation lib
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        if ($this->form_validation->run() == FALSE) {
            $st = array(
                'success' => false,
                'validation' => validation_errors()
            );
            echo json_encode($st);
        } else {
            $user_username = $this->input->post('username');
            $password      = $this->input->post('password');
            $sale_id       = $this->input->post('sale_id');
            //get user details by id
            $user_id       = $this->User_Model->pos_login($user_username, $password);
            //echo "<br/>test:$user_id";
            if ($user_id) {
                $st = array(
                    'success' => true,
                    'user_id' => $user_id
                );
                $this->common_model->add_user_activitie("Checked User: $sale_id");
                echo json_encode($st);
            } else {
                $st = array(
                    'success' => false,
                    'validation' => "Invalid user!"
                );
                $this->common_model->add_user_activitie("Checked User failed: $sale_id");
                echo json_encode($st);
            }
        }
    }
    function authorize()
    {
        $this->load->model("User_Model");
        $this->load->library('form_validation'); //form validation lib
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        if ($this->form_validation->run() == FALSE) {
            $st = array(
                'success' => false,
                'validation' => validation_errors()
            );
            echo json_encode($st);
        } else {
            $user_username   = $this->input->post('username');
            $password        = $this->input->post('password');
            $auth_for        = $this->input->post('auth_for');
            //get user details by id
            $user_info       = $this->pos_login($user_username, $password);
            $user_id         = $user_info['user_id'];
            $group_id        = $user_info['group_id'];
            $user_first_name = $user_info['user_first_name'];
            //echo "<br/>test:$user_id";
            if ($user_id) {
                if ($auth_for == 'item_discount') {
                    if ($group_id <= 2) {
                        $st = array(
                            'success' => true,
                            'user_id' => $user_id
                        );
                        $this->common_model->add_user_activitie("User $user_first_name ($user_id) authorized for discount");
                        echo json_encode($st);
                        exit;
                    } else {
                        $st = array(
                            'success' => false,
                            'validation' => "Authorization failed ($user_id) for discount",
                            'user_id' => $user_id
                        );
                        $this->common_model->add_user_activitie("Authorization failed $user_first_name($group_id) for discount");
                        echo json_encode($st);
                        exit;
                    }
                } else {
                    $st = array(
                        'success' => false,
                        'validation' => "Authentication failed due to unrecognized request",
                        'user_id' => $user_id
                    );
                    $this->common_model->add_user_activitie("Auth failed due to unrecognized request");
                    echo json_encode($st);
                }
            } else {
                $success = false;
            }
            $st = array(
                'success' => false,
                'validation' => "Invalid user!"
            );
            $this->common_model->add_user_activitie("attempt failed");
            echo json_encode($st);
        }
    }
    function pos_login($user_username, $user_password)
    {
        $paa = hash('sha512', $user_password);
        $this->db->select('user.*');
        $this->db->from('user');
        $this->db->where("user_username", $user_username);
        $this->db->where("user_password", $paa);
        $this->db->where('user_status', 1);
        //$this->db->where('group_id != 3');
        //$this->db->or_where('group_id', 1);
        $query = $this->db->get();
        //echo $this->db->last_query();
        if ($query->num_rows() == 1) {
            $row     = $query->row();
            $newdata = array(
                'user_id' => $row->user_id,
                'group_id' => $row->group_id,
                'user_first_name' => $row->user_first_name,
                'user_last_name' => $row->user_last_name
            );
            return $newdata;
        }
        return array(
            'user_id' => '',
            'user_group' => ''
        );
        ;
    }
    function cus_orders()
    {
        $data['main_menu_name'] = 'cus_orders';
        $data['sub_menu_name']  = 'cus_orders';
        $this->load->view('cus_orders/cus_orders', $data);
    }
    function list_co()
    {
        $this->db->select('*');
        $this->db->from('custom_orders');
        $query         = $this->db->get();
        $result        = $query->result_array();
        $totalData     = count($result);
        $totalFiltered = $totalData;
        foreach ($result as $row) {
            $nestedData           = array();
            $sr_id                = $row['order_id'];
            $total_paid_amount    = '';
            $nestedData[]         = display_date_time_format($row['added_on']);
            $nestedData[]         = $row['order_id'];
            $nestedData[]         = $row['cust_name'];
            $nestedData[]         = $row['cust_phone'];
            $nestedData[]         = $row['delivery_date'];
            //$nestedData[] = $row['sr_id'];
            $actionTxtDisble      = '';
            $actionTxtEnable      = '';
            $actionTxtUpdate      = '';
            $actionTxtDelete      = '';
            $url                  = base_url("stock_req/sr_details?sr_id=$sr_id");
            $actionTxtUpdate      = '<a onClick="fbs_click(' . $row['order_id'] . ')" data-toggle="modal" href="#" class="btn btn-xs btn-blue tooltips" data-placement="top" data-original-title="Edit suppliers"><i class="clip-zoom-in-2"></i></a> &nbsp;';
            $actionTxtViewDetails = '<a href="' . base_url() . 'stock_req/view/' . $sr_id . '" class="btn btn-xs btn-blue tooltips" data-placement="top" data-original-title="Edit suppliers"><i class="fa fa-file-text-o"></i></a> &nbsp;';
            $nv_qty               = '';
            $can_qtt              = '';
            if ($this->session->userdata('ss_group_id') < 4) {
                //$nv_qty = '<li><a href="' . base_url() . 'stock_req/invoice_qutation?id=' . $sr_id . '"><i class="fa fa-shopping-cart"></i>Invoice Quotation</a></li>';
                //$nv_qty .= '<li><a href="#" onclick="finish_qutation(' . $sr_id . ')"><i class="fa fa-check"></i>Finish Quotation</a></li>';
            }
            if ($this->session->userdata('ss_group_id') == 1) {
                //$can_qtt = '<li><a href="#" onclick="cancel_qutation(' . $sr_id . ')"><i class="fa fa-ban"></i>Cancel Quotation</a></li>';
            }
            $nestedData[] = '<div class="btn-group text-left">
                                <button data-toggle="dropdown" class="btn btn-default btn-xs btn-primary dropdown-toggle" type="button">Actions <span class="caret"></span></button>
                                <ul role="menu" class="dropdown-menu pull-right">
                                <li><a href="' . base_url() . 'pos/view_cus/' . $sr_id . '"><i class="fa fa-file-text-o"></i> Details</a></li>
                                <li><a onClick="fbs_click(' . $row['order_id'] . ')" data-toggle="modal" href="#" data-placement="top" data-original-title="Edit suppliers"><i class="fa fa-print"></i> Print</a></li>
                                ' . $nv_qty . $can_qtt . '
                                </ul>
                            </div>';
            $data[]       = $nestedData;
        }
        $json_data = array(
            //"draw"            => intval( $requestData['draw'] ),  
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );
        echo json_encode($json_data);
    }
    function get_cus_order($id)
    {
        $this->db->select('*');
        $this->db->from('custom_orders');
        $this->db->where('order_id', $id);
        $query = $this->db->get();
        return $query->row();
    }
    function get_cus_items($id)
    {
        $this->db->select('custom_order_items.*,product.product_name');
        $this->db->from('custom_order_items');
        $this->db->join('product', 'custom_order_items.product_id = product.product_id', 'left');
        $this->db->where('order_id', $id);
        $query = $this->db->get();
        return $query->result_array();
    }
    function view_cus($id)
    {
        $this->load->model('Warehouse_Model');
        $data['main_menu_name']    = 'cus_orders';
        $data['sub_menu_name']     = 'cus_orders';
        $data['qts_id']            = $id;
        $data['qts_details']       = $this->get_cus_order($id);
        $data['qts_item_list']     = $this->get_cus_items($id);
        $data['warehouse_details'] = $this->Warehouse_Model->get_warehouse_info($data['qts_details']->location_id);
        $this->load->view('cus_orders/cus_order_view', $data);
    }
    
    function split_bill(){
        $this->load->model('auto_print_model');
        $split_id = $this->input->post('split_bill_id');
        $new_id = $this->input->post('new_bill_id');
        $unique_id = $this->input->post('unique_id');
        $item_updates = $this->input->post('updates');
        
        $split_sale_details = $this->pos_model->get_sale_info_row($split_id);
        $split_sale_items = $this->pos_model->get_sale_item_list_by_sale_id($split_id);
        
        $new_sale_details = $split_sale_details;
        $new_sale_details->uniq_id = $unique_id;
        $new_sale_details->sale_datetime = date("Y-m-d");
        $new_sale_details->sale_datetime_created = date("Y-m-d");
        $new_sale_details->spl_id = $split_id;
        $new_sale_details->sale_id = $new_id;
        
        
        $this->load->library('form_validation');
        $this->form_validation->set_rules('new_bill_id', 'Duplicate entry', 'is_unique[sales.sale_id]');
        if (!$this->form_validation->run()) {
            echo json_encode(array(
                'success' => true,
                'new_sale_id' => $new_id,
                'error' => '1',
                'disMsg' => 'this bill already added. please use reprint if you haven\'t received bill print',
                'duplicate' => 1
            ));
            return;
        }
        
        
        $post = $this->input->post();
        /*echo json_encode(array(
            'data' => $post,
            'split_sale_details' => $split_sale_details,
            'new_sale_details' => $new_sale_details,
            'item_updates' => $item_updates,
            'split_sale_items' =>$split_sale_items
        ));*/
        $queries = array();
        $this->db->trans_start();
        
        /*insert new sale record*/
        $this->db->insert('sales',$new_sale_details);
        
        foreach($item_updates as $item){
            /*calculations*/
            $id = $item['siid'];
            //$price = $item['product_price'];
            $original_qtty = $item['product_qty'];
            $moving_qtty = $item['si_qty'];
            $balance_qty = $original_qtty - $moving_qtty;

            /*Update existing sale items*/
            $this->db->where(array('id' => $id));
            $this->db->update('sale_items',array(
                'quantity' => $balance_qty
                //'gross_total' => $balance_qty * $price,
            ));
            $queries[] = $this->db->last_query();

            /*inserting new sale items*/
            // GET ITEM
            $this->db->select('*');
            $this->db->from('sale_items');
            $this->db->where('id', $id);
            $query = $this->db->get();
            $result = $query->row_array();
            $queries[] = $this->db->last_query();
            // SET ITEM
            $result['sale_id'] = $new_id;
            $result['quantity'] = $moving_qtty;
            unset($result['id']);
            $this->db->insert('sale_items',$result);
            $queries[] = $this->db->last_query();
        }
        /*update sale*/
        $item_total               = $this->pos_model->get_sale_item_totals($split_id);
        $sales_data['sale_total'] = $item_total['gross_total'];
        $sales_data['cost_total'] = $item_total['cost_total'];
        $this->pos_model->update_sale_header($sales_data, $split_id);
        $queries[] = $this->db->last_query();
        
        $item_total               = $this->pos_model->get_sale_item_totals($new_id);
        $sales_data['sale_total'] = $item_total['gross_total'];
        $sales_data['cost_total'] = $item_total['cost_total'];
        $this->pos_model->update_sale_header($sales_data, $new_id);
        $queries[] = $this->db->last_query();
        
        $this->db->trans_complete();
        echo json_encode(
            array(
                'success' => true,
                'queries' => $queries
                )
        );
    }
}