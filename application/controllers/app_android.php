<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class App_Android extends CI_Controller
{
    var $main_menu_name = "";
    var $sub_menu_name = "";
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Sales_Model');
        $this->load->model('Supplier_Model');
        $this->load->model('Warehouse_Model');
        $this->load->model('Common_Model');
        $this->load->model('Tax_Rates_Model');
        $this->load->model('Customer_Model');
        $this->load->model('Sales_Return_Model');
        $this->load->model('Android_Model');
        $this->load->model('app_model');
        $this->load->model('category_models');
		$this->load->model('product_models');
		
    }
    //Sales list page load
    public function index()
    {
        /*
        
        $data['sales'] = $this->Sales_Model->get_all_sales();
        
        $data['main_menu_name'] = $this->main_menu_name;
        
        $data['sub_menu_name'] = $this->sub_menu_name;
        
        $this->load->view('sales',$data);*/
    }
    //cus login
    function login()
    {
        $this->load->library('form_validation'); //form validation lib
        $this->form_validation->set_rules('cus_username', 'Username', 'required');
        if ($this->form_validation->run() == FALSE) {
            $st = array(
                'status' => false,
                'validation' => 'Error!'
            );
            echo json_encode($st);
        } else {
            //echo $this->input->post('cus_username');
            //echo $this->input->post('cus_password');
            $user_username = $this->input->post('cus_username');
            $password      = $this->input->post('cus_password');
            //get user details by id
            //            echo $user_username.'/n';
            //            echo $password;
            $cus_id        = $this->Customer_Model->login($user_username, $password);
            //echo "<br/>test:$cus_id";
            if ($cus_id) {
                $data['cus_details'] = $this->Customer_Model->get_customer_info($cus_id);
                //create sessions
                //print_r($data['cus_details']);
                $ss_cus_username     = $data['cus_details']['cus_email'];
                $ss_cus_id           = $data['cus_details']['cus_id'];
                $ss_group_id         = '5';
                $ss_warehouse_id     = $data['cus_details']['cus_warehouse_id'];
                $ss_cus_group_name   = 'customer';
                $sesdata             = array(
                    'ss_user_username' => $ss_cus_username,
                    'ss_user_id' => $ss_cus_id,
                    'ss_group_id' => $ss_group_id,
                    'ss_warehouse_id' => $ss_warehouse_id,
                    'ss_user_first_name' => $data['cus_details']['cus_name'],
                    'ss_user_last_name' => '',
                    'ss_user_group_name' => $ss_cus_group_name,
                    'ss_user_address' => $data['cus_details']['cus_address']
                );
                $st                  = array(
                    'status' => true,
                    'validation' => 'Done!',
                    'cus_username' => $ss_cus_username,
                    'cus_id' => $ss_cus_id,
                    'warehouse_id' => $ss_warehouse_id,
                    'cus_name' => $data['cus_details']['cus_name'],
                    'cus_group_name' => $ss_cus_group_name,
                    'cus_address' => $data['cus_details']['cus_address']
                );
                //insert user activity
                //$this->Common_Model->add_user_activitie("Log Csutomer");
                echo json_encode($st);
            } else {
                $st = array(
                    'status' => false,
                    'validation' => 'Error!'
                );
                echo json_encode($st);
            }
        }
    }
    function get_vehicles_nearby()
    {
        $location = $this->input->get('location');
        $cus_id   = $this->input->get('cus_id');
        $vehicles = $this->Android_Model->get_all_vehicles();
        //return as requested
    }
    function product_suggestions_by_vh_id($value = '')
    {
        //print_r($_GET);
        $vh_id            = $this->input->get('vh_id');
        $term             = $this->input->get('term');
        $in_type          = $this->input->get('t');
        $data['pro_data'] = $this->Android_Model->get_products_suggestions($term, $vh_id);
        $json             = array();
        //echo "Count:".count($data['sales']);
        //print_r($data['sales']);
        foreach ($data['pro_data'] as $row) {
            //set price
            $price_tmp = 0;
            if ($in_type == 'mobile') {
                $price_tmp = $row['product_price'];
            }
            $product_name   = $row['product_name'];
            $product_code   = $row['product_code'];
            $product_id     = $row['product_id'];
            $product_price  = $price_tmp;
            $sendParameters = "'$product_id','$product_name','$product_code','$product_price'";
            $sendParameters = "$product_id,$product_name,$product_code,$product_price";
            $extraName      = '';
            $extraName .= ", Selling Price: " . number_format($product_price, 2, '.', ',');
            $json_itm = array(
                'id' => $row['product_id'],
                'product_id' => $row['product_id'],
                'product_code' => $row['product_code'],
                'product_name' => $row['product_name'],
                'product_price' => $price_tmp,
                'value' => $row['product_name'] . " (" . $row['product_code'] . ")",
                'label' => $row['product_name'] . " (" . $row['product_code'] . ")"
            );
            array_push($json, $json_itm);
        }
        echo json_encode($json);
    }
    function get_categories()
    {
        echo json_encode($this->category_models->getCategory());
    }
    function get_items_by_category_id()
    {
        $category_id = $this->input->post('category_id');
        //echo $category_id;
        $out_cat     = '';
        $out_sub     = '';
        $d           = $this->app_model->get_product_by_cat_id($category_id);
        $s           = $this->app_model->get_sub_category_by_cat_id($category_id);
        if (!empty($d)) {
            $jproduct = array(
                "products" => $d,
                "subcategories" => "",
                "tcp" => 0
            );
            foreach ($d as $key => $row) {
                //print_r( $d[$key]->product_name );
                //$d[$key]->product_thumb = 'http://sampathtest.salleepos.com.lk/bakerschoice/thems/uploads/thumbs/'.$d[$key]->product_thumb ;
                $d[$key]->product_thumb = asset_url() . 'uploads/thumbs/' . $d[$key]->product_thumb;
                //print_r( $d[$key]->product_thumb );
            }
            echo json_encode($d);
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
    public function save_sale()
    {
        //print_r( $this->input->post() );
        //echo '---------';
        //echo json_encode($this->input->post());exit();
        $customer_id       = $this->input->post('cus_id');
        $delivery_address  = $this->input->post('delivery_address');
        $delivery_charges  = $this->input->post('delivery_charges');
        $discount_code     = $this->input->post('discount_code');
        $lorry_id          = $this->input->post('lorry_id');
        $paid_by           = $this->input->post('paid_by');
        $products          = $this->input->post('products');
        $sale_note         = $this->input->post('sale_note');
        $warehouse_id      = $this->input->post('warehouse_id');
        //payments
        //$extra_charges        = $this->input->post('extra_charges');
        //$extra_charges_amount = $this->input->post('extra_charges_amount');
        //$pay_amount           = $this->input->post('pay_amount');
        //$cc_name              = $this->input->post('cc_name');
        //$cc_no                = $this->input->post('cc_no');
        //$cc_holder               = $this->input->post('cc_holder');
        //$cc_type                 = $this->input->post('cc_type');
        //$payment_note           = $this->input->post('payment_note');
        $sale_datetime     = date('Y-m-d H:i:s');
        $sale_reference_no = $this->app_model->get_next_ref_no_by_customer_id($customer_id);
        //product details
        //$dine_type                = $this->input->post('delivery_status');
        $sale_status       = $this->input->post('sale_status');
        $sales_data        = array(
            'customer_id' => $customer_id,
            'paid_by' => $paid_by,
            'sale_datetime' => $sale_datetime,
            'sale_note' => $sale_note,
            'sale_reference_no' => $sale_reference_no,
            'sale_shipping' => $delivery_charges,
            'shipping_address' => $delivery_address,
            'warehouse_id' => $warehouse_id,
            'invoice_type' => 2
            /*'sale_id' => $sale_id,
            'sale_total'     => $grand_total,
            'sale_inv_discount'            => $pos_discount_input,
            'sale_inv_discount_amount'    => $discount,
            
            'sale_datetime_created'        => $sale_date,
            
            'invoice_type' => 4,
            'shipping_address' => $delivery_address,
            'dine_type' => $dine_type,
            'sale_extra_charges' => $extra_charges,
            'sale_extra_charges_amount' => $extra_charges_amount,
            'user' => $this->session->userdata('ss_user_id')*/
        );
		$sale_id = $this->app_model->save_sale_header($sales_data);
		$sale_total	=	0;
		$cost_total	=	0;
        if ($sale_id) {
            for ($i = 0; $i < count($products); $i++) {
                $item_details = $this->app_model->get_product_details_by_id($products[$i]['product_id']);
                $selling_price  = $item_details['product_price'];
                $error          = false;
                $tmpDisVal      = 0;
                $discount       = $products[$i]['discount'];
                $discount_value = 0;
                if ($discount) {
                    //echo 'disconut found \n \n /n /n';
                    if (strpos($discount, "%") !== false) {
                        $pds = explode("%", $discount);
                        //alert(1);
                        if (!is_nan($pds[0])) {
                            $selling_price  = $selling_price - ($selling_price * $pds[0] / 100);
                            $discount_value = $selling_price * $pds[0] / 100;
                        } else {
                            $error = true;
                        }
                    } else {
                        if (!is_nan($discount)) {
                            $selling_price  = $selling_price - $discount;
                            $discount_value = $discount;
                            //alert('discount:'+discount);
                        } else {
                            $error = true;
                        }
                    }
                }
                //print_r($item_details);
                $data = array(
                    'sale_id' => $sale_id,
                    'product_id' => $products[$i]['product_id'],
                    'product_code' => $item_details['product_code'],
                    'product_name' => $item_details['product_name'],
                    'quantity' => $products[$i]['qty'],
                    'unit_price' => $item_details['product_price'],
                    'gross_total' => $selling_price
                );
				$sale_total += $selling_price;
				$cost_total	+= $item_details['product_cost'];
                $this->app_model->sale_items_in($data);
                //$this->common_model->add_fi_table('sale', $sale_id, $products[$i], $quantity[$i], $net_price[$i]);
            }
			//$update_date = array('sale_total'=>$sale_total,'cost_total'=>$cost_total);
			//$this->app_model->update_sale($update_data);
            $pay_amount = 0;
            if ($pay_amount > 0) {
                $t = $this->app_model->sales_payment($sale_id, $paid_by, $grand_total, $sale_date, $payment_note, $cc_no, $pcc_holder, $pcc_type, "sale", $pay_amount, $sale_pymnt_balane_amount);
                $this->app_model->complete_sale($sale_id);
                if ($t == true) {
                    $data['sale_id']        = $sale_id;
                    $data['pay_amount']     = $pay_amount;
                    $data['paid_by']        = $paid_by;
                    $data['balance_amount'] = $sale_pymnt_balane_amount;
                    echo json_encode(array(
                        'sale_id' => $sale_id,
                        'sale_ref' => $sale_ref,
                        'error' => '0',
                        'disMsg' => ''
                    ));
                } else {
                    echo json_encode(array(
                        'sale_id' => '',
                        'sale_ref' => '',
                        'error' => '0',
                        'disMsg' => ''
                    ));
                }
            } else {
                echo json_encode(array(
                    'sale_id' => $sale_id,
                    'sale_ref' => $sale_reference_no,
                    'error' => '0',
                    'disMsg' => 'Order added'
                ));
            }
        }
    }
	
	 public function sales_print() {
        $this->load->view('self_print');
    }

    public function get_print_details() {
        $sale_id = $this->input->post('sale_id');
        $print['sale_details'] = $this->Sales_Model->get_sale_print();
		if(isset($print['sale_details']['sale_id']))
        echo json_encode($print['sale_details']['sale_id']);
		else echo json_encode('');
    }

    public function set_printed() {
//        echo 'lllllljj';
        $sale_id = $this->input->post('sale_id');
        //echo $sale_id;
        $print['sale_details'] = $this->Sales_Model->set_printed($sale_id);
        echo json_encode($sale_id);
    }
	
	public function get_all_products(){
        $search_key     = $this->input->get('search');
        $search_key_val = $search_key['value'];
        $start          = $this->input->get('start');
        $length         = $this->input->get('length');
        $category       = $this->input->get('category');
        $totalData      = 0;
        $values         = $this->product_models->getProducts($start, $length, $search_key_val, $category);
        echo json_encode($values);
    }
}