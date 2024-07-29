<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Posplus extends CI_Controller
{
    private $ism_din = true;
    private $ism_ubr = true;
    private $ism_pkm = true;
    private $pmt_csh = true;
    private $pmt_vsa = true;
    private $pmt_mst = true;
    private $pmt_amx = true;
    private $ftr;
    
    private $settings = array(
        'def_cat' => 5,         /* 1 or 2(recommended) */
        'key_brd' => true,
        'key_brd_lyt' => 1,     /* 1 or 2(recommended) */
        'mlt_pmt' => false,     /* add multiple payments   */
        'num_col' => 4,         /* number of columns should have in product list */
        'wide_left' => true,    /* more wide left panel (min width 520px) */
    );
    
    public function __construct()
    {
        parent::__construct();
        
        $this->ftr = array(
            'add_prd' => false,     /* add products             */
            'edt_sle' => true,      /* edit sale / continue     */
            'cus_reg' => true,      /* customer registration    */
            'cus_pnt' => false,     /* customer points          */
            'str_pnt' => false,     /* store points             */
            'dsc_bll' => true,      /* bill discount            */
            'dsc_itm' => false,     /* discount item wise       */
            'bll_nte' => true,      /* kitchen note             */
            'ism'     => array(
                'din' => array(
                    'on' => true,
                    'def' => false
                ),  /* issue method: dine in    */
                'tkw' => array(
                    'on' => true,
                    'def' => true
                ),  /* issue method: take away  */
                'dlv' => array(
                    'on' => false,
                    'def' => false
                ),  /* issue method: delivery   */
                'ubr' => array(
                    'on' => $this->ism_ubr,
                    'def' => false
                ),  /* issue method: uber       */
                'pkm' => array(
                    'on' => $this->ism_pkm,
                    'def' => false
                ),  /* issue method: pickme     */
            ),
            'slt_tbl' => function(){ return $this->ism_din ? true : false; },  /* select tables for dine in     */
            'slt_wtr' => function(){ return $this->ism_din ? true : false; },  /* select waiter for dine in     */
            'pmt_csh' => $this->pmt_csh,  /* payment method: cash     */
            'pmt_vsa' => $this->pmt_vsa,  /* payment method: visa     */
            'pmt_mst' => $this->pmt_mst,  /* payment method: master   */
            'pmt_amx' => $this->pmt_amx,  /* payment method: amex     */
        );
        
        /*ini_set('max_execution_time', 3);*/
        $this->load->model('bar_model');
        $this->load->model('posplus_model');
        $this->load->model('common_model');
        $this->load->model('customer_model');
        $this->load->model('category_models');
        $this->load->model('Sales_Model');
        $this->load->model('Warehouse_Model');
        date_default_timezone_set("Asia/Colombo");
    }
    
    public function get_ot($type = "") {
        // Get current date
        $otr = array();
        $date = date("Y-m-d");
        
        $ott = $this->input->post('ott');
        
        foreach($ott as $ot){
            // Select count of records for the current date
            $this->db->select('count(*) as count');
            $this->db->from('kot_master');
            $this->db->where("DATE(system_date_time)", $date);
            $this->db->where("ott", $ot);
            $query = $this->db->get();
            $result = $query->row();
            
            if ($result) {
                $count = $result->count + 1;
        
                // Insert new record
                $kot_data = array(
                    'user_id' => $this->session->userdata('ss_user_id'),
                    'is_auto_printed' => 0,
                    'location_id' => $this->session->userdata('ss_warehouse_id'),
                    'sale_id' => $this->input->post('sale_id'),
                    'ott' => $ot,
                    'system_date_time' => date("Y-m-d H:i:s"),
                    'kot_ref_no' => $count
                );
        
                if ($this->db->insert('kot_master', $kot_data)) {
                    $kot_id = $this->db->insert_id();
                    
                    // Return JSON response
                    $otr[$ot] = array(
                        'r' => $count,
                        'i' => $kot_id,
                        't' => $ot
                    );
                } else {
                    // Handle database insert failure
                    $otr[$ot] = array(
                        'error' => 'Failed to insert data'
                    );
                }
            } else {
                // Handle database query failure
                $otr[$ot] = array(
                    'error' => 'Failed to fetch data from the database'
                );
            }
        }
        
        echo json_encode($otr);
    
    }

    function terminal($terminal_id = ''){
        if($terminal_id){
            $this->db->where('user_id', $this->session->userdata('ss_user_id'));
            $udata = array('terminal_id',$terminal_id);
            if($this->db->update('user',$udata)){
                return $terminal_id;
            }
        }

        $this->db->select('terminal_id,user_id');
        $this->db->from('user');
        $this->db->where('user_id',$this->session->userdata('ss_user_id'));
        $query = $this->db->get();
        $terminal_id = isset($query->row()->terminal_id) ? $query->row()->terminal_id : 0;
        return $terminal_id;
    }
    function set_terminal(){
        $terminal_id = $this->input->post('terminal_id');
        if($terminal_id)
            $terminal_id = $this->terminal($terminal_id);
        echo json_encode(array('status' => $terminal_id ? true : false));
    }
    public function app_login(){
        $terminal_id = $this->terminal();
        $wh = $this->Warehouse_Model->get_warehouse_info($this->session->userdata('ss_warehouse_id'));
        header('Content-type:application/json');
        
        if(!empty($wh)){
            echo json_encode(array(
                'status' => $this->session->userdata('ss_cashier_float_id') ? true : false,
                'terminal_id' => $terminal_id,
                'cashier' => array(
                    'float_id' => $this->session->userdata('ss_cashier_float_id'),
                    'user_id' => $this->session->userdata('ss_user_id'),
                    'name' => $this->session->userdata('ss_user_first_name')
                ),
                'wh' => array(
                    'id' => $wh['id'],
                    'code' => $wh['code'],
                    'name' => $wh['name'],
                    'address' => $wh['address'],
                    'phone' => $wh['phone'],
                    'email' => $wh['email']
                ),
                'base_url' => base_url()
            ));
        }else{
            echo json_encode(array(
                'status' => false,
                'cashier' => array(
                    'float_id' => '',
                    'user_id' => '',
                    'name' => ''
                ),
                'wh' => array(
                    'id' => '',
                    'code' => '',
                    'name' => '',
                    'address' => '',
                    'phone' => '',
                    'email' => ''
                ),
                'base_url' => base_url()
            ));
        }
        
        
    }
    public function index()
    {
        echo "server online";
    }
    public function app()
    {
        $data['ftr'] = $this->ftr;
        
        $data['settings'] = $this->settings;

        $this->load->model('products_model');
        if ($this->session->userdata('ss_cashier_float_status') == 0) {
            header("Location:" . base_url("dashboard"));
            die();
        }

        $data['customer_id'] = 0;
        $data['sale_id']     = $this->uri->segment(3);
        $data['printer_key'] = "";
        $wh = $this->Warehouse_Model->get_warehouse_info($this->session->userdata('ss_warehouse_id'));
        $data['printer_key'] = $wh['printer_key'];
        if ($this->session->userdata('ss_user_id') == 9) {
            //echo $this->session->userdata('ss_user_id');
        }
        $data['is_editable']  = '1';
        $data['price_types']    = $this->products_model->get_price_types();
        $data['category_by_id_1'] = array();//$this->bar_model->get_product_by_cat_id(17, 1);
        $data['category']         = $this->bar_model->get_all_category();
        $product_list_by_category = array();
        if(!empty($data['category'])){
            foreach ($data['category'] as $row) {
                $get_products_cat_by_cat = $this->bar_model->get_product_by_cat_id($row->cat_id);
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
                        $products_of_cat[] = $productData;
                    }
                $product_list_by_category[] = $products_of_cat;
            }
        }
        $data['product_list_by_category'] = array();//$product_list_by_category;
        $data['sub_category']  = $this->posplus_model->get_sub_category_by_cat_id(1);
        $data['get_customer']  = $this->posplus_model->get_customer();
        $data['get_warehouse'] = $this->posplus_model->get_warehouse();
        $data['get_waiter'] =  $this->bar_model->get_waiter();
        $data['product_list']  = $this->loadProductArray($this->session->userdata('ss_warehouse_id'));

        /*
            header('Content-type:application/json');
            echo json_encode(json_decode($data['product_list']), JSON_PRETTY_PRINT);
            exit;
        */

        //$data['main_category'] = $this->category_models->getCategory();
        //$data['customers']     = $this->customer_model->get_cus_phone();
        //$data['order_place'] = 'bar';
        $this->load->view('posplus/_pos', $data);
    }
    function get_products(){
        $product_list  = $this->loadProductArray($this->session->userdata('ss_warehouse_id'));
        echo $product_list;
    }
    function get_phone(){
        $customers = $this->customer_model->get_cus_phone();
        $result = array();
        foreach ($customers as $cus) {
            if ($cus['cus_phone'] != 0 && $cus['cus_phone'] != "") {
                $result[] = $cus['cus_phone'];
            }
        }
        echo json_encode($result);
    }
    function service_worker()
    {
        header("Content-type: application/javascript");
        $this->load->view('posplus/service_worker');
    }
    public function loadProductArray($location_id)
    {
        $emp_array             = array();
        $returnstr             = array();
        $product_code          = null;
        $get_product_all_by_id = $this->posplus_model->get_products();

        if (!empty($get_product_all_by_id)) {
            $empar = array();
            foreach ($get_product_all_by_id as $key => $value) {
                
                $p = json_decode($get_product_all_by_id[$key]->product_prices);
                $location_name = 'lo'.$location_id;
                //echo $location_name;
                //print_r($p);
                if(isset($p->$location_name)){
                    $prices = $p->$location_name;
                    
                    $label = array(
                        "id" => mt_rand(10, 10000),
                        "product_id" => $get_product_all_by_id[$key]->product_id,
                        "product_cat_id" => $get_product_all_by_id[$key]->cat_id,
                        "product_code" => $get_product_all_by_id[$key]->product_code,
                        "product_price" => $get_product_all_by_id[$key]->product_price,
                        "product_prices" => $prices,
                        "product_ott" => $get_product_all_by_id[$key]->ott,
                        "label" => $get_product_all_by_id[$key]->product_code . ' | ' . $get_product_all_by_id[$key]->product_name,
                        "product_name" => $get_product_all_by_id[$key]->product_name,
                        "is_rti" => $get_product_all_by_id[$key]->is_rti,
                        "value" => $get_product_all_by_id[$key]->product_name
                    );
                    array_push($empar, $label);
                }
                //continue;
            }
            $returnstr = json_encode($empar);
            return $returnstr;
        } else {
            echo '[{"id":0,"label":"No matching result found! Product might be out of stock in the selected warehouse.","value":"hg"}]';
        }
    }
    function get_sale_info(){
        $this->load->model('pos_model');
        $sale_id = $this->input->post('sale_id');
        $sale_details = $this->pos_model->get_sale_info_row($sale_id);
        $sale_details->items = $this->get_sale_items_by_sale_id($sale_id);
        $sale_details->customer = $this->get_cus_info($sale_details->customer_id);
        
        //$data['sale_item_list'] = array();//$this->bar_model->get_sale_item_list_by_sale_id($data['sale_id']);
        header('Content-type:application/json');
        echo json_encode($sale_details);
    }
    function get_cus_info($cus_id) {
		$this->db->select('cus_phone,cus_name');
		$this->db->where("cus_id",$cus_id);
		$query = $this->db->get('customer');
		return $query->row();
	}
	
    function get_sale_items_by_sale_id($sale_id)
    {
        $this->db->select('id,product_id,product_code,product_name,quantity,unit_price,discount,discount_val');
        $this->db->from('sale_items');
        $this->db->where("sale_items.sale_id", $sale_id);
        $this->db->where("valid_status", 1);
        $query = $this->db->get();
        return $query->result();
    }
    /*function validate($post){
        if(isset($post['sale_id'])){
            
        }
    }*/
    
    public function validate($post) {
        // Check if the required fields are present and not empty
        $requiredFields = array(
            'sale_id',
            'uuid',
            'location_id',
            'customer_id',
            'order_datetime',
            'price_type',
            'invoice_type',
            'waiter_id',
            'user_id'
        );
        
        $missing_fields = array();
    
        foreach ($requiredFields as $field) {
            if (empty($post[$field])) {
                    $missing_fields[] = $field;
            }
        }
        
        
        if(!empty($missing_fields)){
            echo json_encode(array(
                'error' => 'Missing required fields',
                'message' => 'Check "data" for more details',
                'data'    => $missing_fields
            ));
            exit;
        }
        
        return true; // Validation passed
    }
    
    public function order()
    {
        $post_data = $this->input->post();
        //print_r($post_data);
        
        // Validate the incoming data
        if ($this->validate($post_data)) {

            $query = $this->db->select('sale_id,uuid')
                  ->from('orders')
                  ->where('uuid', $post['uuid'])
                  ->where('sale_id', $post['sale_id'])
                  ->get();
            
            $count = $query->row()->count;
            
            if($count > 0){
                echo json_encode(array(
                    'error' => 'Duplicate entry',
                    'message' => 'the resource you are trying to create is already exist',
                    'data'    => array(
                        'sale_id' => $post['sale_id'],
                        'uuid' => $post['uuid']
                    )
                ));
                exit;
            }
            /*$query = $this->db->select('COUNT(*) as count')
                  ->from('orders')
                  ->where('uuid', $post['uuid'])
                  ->where('sale_id', $post['sale_id'])
                  ->get();
    
            $count = $query->row()->count;
    
            if($count > 0){
                echo json_encode(array(
                    'error' => 'Duplicate entry',
                    'message' => 'the resource you are trying to create is already exist',
                    'data'    => array(
                        'sale_id' => $post['sale_id'],
                        'uuid' => $post['uuid']
                    )
                ));
                exit;
            }*/
            
            // End check duplicates
            
            
            // If validation passes, proceed with creating the order data
            $order_data = array(
                'order_id' => $post_data['sale_id'],
                'uuid' => $post_data['uuid'],
                'location_id' => $post_data['location_id'],
                'customer_id' => $post_data['customer_id'],
                'order_datetime' => $post_data['order_datetime'],
                'invoice_type' => $post_data['invoice_type'],
                'table_id' => isset($post_data['table_id']) ? $post_data['table_id'] : null,
                'price_type' => $post_data['price_type'],
                'user_id' => isset($post_data['user_id']) ? $post_data['user_id'] : null,
                'waiter_id' => isset($post_data['waiter_id']) ? $post_data['waiter_id'] : null,
                'order_status' => isset($post_data['order_status']) ? $post_data['order_status'] : null,
            );
            
            if($post_data['continued'])
            
            $this->db->insert('orders',$order_data);
            
            $num_rows = $this->db->affected_rows();
            
            if(!isset($post_data['items'])){
                $post_data['items'] = array();
            }
    
            /*$item_data = $post_data['items'];
            header('Content-type: application/json');
            echo json_encode($item_data);*/
            
            $order_items = array();
            
            foreach($item_data as $item){
                $order_item = array(
                    'order_id' => $item[''],
                    'location_id' => $item['location_id'], // You can set other fields to specific values or null
                    'product_id' => $item['product_id'],
                    'product_name' => $item['product_name'],
                    'item_cost' => $item['item_cost'],
                    'unit_price' => $item['unit_price'],
                    'unit_discount' => $item['unit_discount'],
                    'unit_discount_amount' => $item['unit_discount_amount'],
                    'quantity' => $item['quantity'],
                    'sub_total' => $item['sub_total'],
                    'item_status' => 'waiting',
                    'item_note' => $item['item_note'],
                    'item_datetime' => $date("Y-m-d H:i:s"),
                    'item_ott' => $item['item_ott'],
                    //'ot_issued' => $item['ot_issued']
                );
                $order_items[] = $order_item;
            }
            
            if (!empty($order_items)) {
                $this->db->insert_batch('order_items', $order_items);
            }
            
            $num_rows = $this->db->affected_rows();
            
            //if($num_rows) >
            
            
        } else {
            // Handle validation failure, perhaps return an error response or redirect back to the form
        }
        
        exit;
        $this->validate($this->input->post());
        
        $order_data = array(
            'order_id' => $this->input->post('sale_id'),
            'uuid' => $this->input->post('uuid'),
            'location_id' => $this->input->post('location_id'),
            'customer_id' => $this->input->post('customer_id'),
            'order_datetime' => $this->input->post('order_datetime'),
            'invoice_type' => $this->input->post('invoice_type'),
            'table_id' => $this->input->post('table_id'),
            'price_type' => $this->input->post('price_type'),
            'user_id' => $this->input->post('user_id'),
            'waiter_id' => $this->input->post('waiter_id'),
            'order_status' => $this->input->post('order_status'),
            'status' => 0
        );

        if($this->session->userdata('ss_cashier_float_id')>0){}else{
        echo json_encode(array(
               'sale_id' => 0,
				'sale_ref' => 0,
				'error' => '1',
				'disMsg' => 'PLEASE START NEW CASHIER FLOAT',
				'duplicate' => 0
               ));
               return false;
        }
        $this->load->library('form_validation');
		$this->form_validation->set_rules('uniq_id', 'Bill is unique', 'is_unique[sales.uniq_id]');
		 if ($this->form_validation->run() == FALSE)
        {
           echo json_encode(array(
               'sale_id' => 0,
				'sale_ref' => $this->input->post('uniq_id'),
				'error' => '1',
				'disMsg' => 'this bill already added. please use reprint if you havent received bill print',
				'duplicate' => 1
               ));
        }
        else
        {
        $this->load->model('customer_model');
        $sale_id   = $this->input->post('sale_id');
        $cus_phone = ($this->input->post('cus_phone') != "") ? $this->format_phone($this->input->post('cus_phone')) : "";
        $cus_name  = ($this->input->post('cus_name') != "") ? ($this->input->post('cus_name')) : "";
        if ($cus_phone == "error") {
            echo json_encode(array(
                'sale_id' => '',
                'sale_ref' => '',
                'error' => '1',
                'duplicate' => '0',
                'disMsg' => 'Invalid phone!'
            ));
            exit;
        }
        $cus_name             = $this->input->post('cus_name');
        $customer_id          = $this->customer_model->validate_customer_by_phone($cus_phone, $cus_name);
        //$customer_id              = $this->input->post('poscustomer');
        $poswarehouse         = $this->input->post('poswarehouse');
        $discount             = $this->input->post('discount');
        $pos_discount_input   = $this->input->post('pos_discount_input1');
        $extra_charges        = $this->input->post('extra_charges');
        $extra_charges_amount = $this->input->post('extra_charges_amount');
        $pay_amount           = $this->input->post('pay_amount');
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
        $uniq_id             = $this->input->post('uniq_id');
        $sale_date            = date('Y-m-d H:i:s', strtotime($this->input->post('sale_datetime')));
        $salei_date           = date('Y-m-d', strtotime($this->input->post('sale_datetime')));
        $sale_ref             = $this->input->post('sale_reference_no');
        if (!$sale_ref) {
            $sale_ref = $this->common_model->gen_ref_number("sale_id", "sales", "S");
        }
        if($extra_charges_amount>0){}else{$extra_charges_amount=0;}
        $table_id                 = $this->input->post('table_id');
        $floor_id                 = $this->input->post('floor_id');
        $division_id              = $this->input->post('division_id');
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
        $uniq_id             = $this->input->post('uniq_id');
        $waiter_id             = $this->input->post('waiter_id');
        $odr_type             = $this->input->post('odr_type');
        $separate_status=$this->input->post('separate_status');
        $is_seperate=$this->input->post('is_seperate');
        $call_order             = $this->input->post('call_order');
        if($grand_total>0){
            //go as normal
        }else{
             echo json_encode(array(
               'sale_id' => 0,
				'sale_ref' => 0,
				'error' => '1',
				'disMsg' => 'INVALID INVOICE DATA. PLEASE ADD AGAIN!',
				'duplicate' => 0
               ));
               return false;
        }
        $odr_type=1;
        if(isset($call_order)){
                    if($call_order==1){
                    $odr_type=2;}
                }
        if($waiter_id==''){
            $waiter_id=null;
        }
        if ($dine_type == 3) {
            if ($cus_phone == "") {
                echo json_encode(array(
                    'sale_id' => '',
                    'sale_ref' => '',
                    'error' => '1',
                    'disMsg' => 'Customer phone number is required!'
                ));
                exit;
            }
        }
        if($table_id>0){}else{$table_id=0;}
        //echo $pay_amount;
        if ($pay_amount == 0) {
            $sale_status = 1;
        } else if ($pay_amount >= $grand_total) {
            //$sale_status = 3;
        } else if ($pay_amount == $grand_total) {
            //$sale_status = 2;
        }
        $update    = false;
        $continued = 0;
        if ($sale_id) {
            $update            = true;
            $continued         = 1;
            $item_print_status = $this->input->post('item_print_status');
        }
        $sales_data = array(
            'sale_id' => $sale_id,
            'warehouse_id' => $poswarehouse,
            'sale_reference_no' => $sale_ref,
            'customer_id' => $customer_id,
            'sale_datetime' => $sale_date,
            'sale_note' => $payment_note,
            'sale_total' => $grand_total,
            'sale_inv_discount' => $pos_discount_input,
            'sale_inv_discount_amount' => $discount,
            'paid_by' => $paid_by,
            'sale_datetime_created' => $sale_date,
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
            'sale_status' => $sale_status,
            'sale_cook_status' => 'pending',
            'kitchen_note' => $kitchen_note,
            'continued' => $continued,
            'uniq_id'=>$uniq_id,
            'waiter_id'=>$waiter_id,
            'odr_type'=>$odr_type,
            'float_id'	=> $this->session->userdata('ss_cashier_float_id'),
        );
        if ($sale_id) {
            $this->pos_model->save_sale_header($sales_data, $sale_id);
        } else {
            $sale_id = $this->pos_model->save_sale_header($sales_data);
        }
        if ($sale_id) {
            $kot_item_count=$this->pos_model->check_is_product_array_kot_enable($pr_id);
            $kot_id=null;
            if($kot_item_count>0){
                $get_alrady_no_of_kot=$this->pos_model->check_no_of_kot_in_date(date("Y-m-d"));
                $get_alrady_no_of_kot+=1;
                $kot_data=array(
                    'sale_id'=>$sale_id,
                    'system_date_time'=>date("Y-m-d H:i:s"),
                    'user_id'=>$this->session->userdata('ss_user_id'),
                    'kot_ref_no'=>$get_alrady_no_of_kot
                    );
                   $kot_id= $this->pos_model->save_kot_master($kot_data);
            }
            $tot_cost = 0;
            for ($i = 0; $i < count($pr_id); $i++) {
                $product_id   = $pr_id[$i];
                $product_des  = $this->Product_Models->get_product_cost_by_id($product_id);
                $product_cost = $product_des->product_cost;
                $qty          = $quantity[$i];
                $tot_cost_itm = $product_cost * $qty;
                $tot_cost     = $tot_cost + $tot_cost_itm;
                $np           = $net_price[$i];
                $ssb          = $qty * $np;
                $sepr_status=0;
                if(isset($is_seperate)){
                    if($is_seperate==1){
                    $sepr_status=1;}
                }
                if ($update) {
                    $this->pos_model->sale_items_in($sale_id, $pr_id[$i], $product_code[$i], $product_name[$i], $quantity[$i], $net_price[$i], $ssb, $print_status[$i], $product_cost,$salei_date,$kot_id,$sepr_status);
                } else
                    $this->pos_model->sale_items_in($sale_id, $pr_id[$i], $product_code[$i], $product_name[$i], $quantity[$i], $net_price[$i], $ssb, $print_status[$i], $product_cost,$salei_date,$kot_id,$sepr_status);
            }
            $item_total=$this->pos_model->get_sale_item_totals($sale_id);
            $sales_data               = array();
            if($continued==1){
                $sales_data['sale_total'] = $item_total['gross_total'];
            }
            //$sales_data['cost_total'] = $item_total['cost_total'];
            //$this->pos_model->update_sale_header($sales_data, $sale_id);
           
            if ($dine_type == 1) {
                $this->pos_model->complete_sale($sale_id);
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
            }
            if ($pay_amount > 0) {
                if ($payments[1]['amount']) {
                    $t = $this->pos_model->sales_payment($sale_id, "visa", $payments[1]['amount'], $sale_date, $payment_note, $cc_no, $pcc_holder, $pcc_type, "sale", $payments[1]['amount'], 0);
                    if ($payments[0]['amount'])
                        $t = $this->pos_model->sales_payment($sale_id, "Cash", $payments[0]['amount'], $sale_date, $payment_note, $cc_no, $pcc_holder, $pcc_type, "sale", $pay_amount, $sale_pymnt_balane_amount);
                } else {
                    $t = $this->pos_model->sales_payment($sale_id, "Cash", $grand_total, $sale_date, $payment_note, $cc_no, $pcc_holder, $pcc_type, "sale", $pay_amount, $sale_pymnt_balane_amount);
                }
                if ($t == 1) {
                    echo json_encode(array(
                        'sale_id' => $sale_id,
                        'error' => '0',
                        'disMsg' => ''
                    ));
                } else {
                    echo json_encode(array(
                        'sale_id' => '',
                        'sale_ref' => '',
                        'error' => '0',
                        'disMsg' => '',
                        'duplicate' => '0',
                    ));
                }
            } else {
                echo json_encode(array(
                    'sale_id' => $sale_id,
                    'sale_ref' => $sale_ref,
                    'error' => '0',
                    'disMsg' => '',
                    'duplicate' => '0',
                ));
            }
        }
     }
    }
    public function view_bill()
    {
        $data['category_by_id_1'] = $this->bar_model->get_product_by_cat_id(1);
        $data['category']         = $this->bar_model->get_all_category();
        $data['sub_category']     = $this->bar_model->get_sub_category_by_cat_id(1);
        $data['get_customer']     = $this->bar_model->get_customer();
        $data['get_warehouse']    = $this->bar_model->get_warehouse();
        $this->load->view('bar/pos-bill', $data);
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
        $this->load->model('pos_plus_model');
        $search_key     = $this->input->get('search');
        $search_key_val = $search_key ? $search_key['value'] : '';
        $start          = $this->input->get('start');
        $length         = $this->input->get('length');
        $dine_type      = $this->input->get('dine_type');
        $cus_id         = $this->input->get('cus_id');
        $sales          = '';
        //$totalData      = 0;
        $length = 40;
            if($dine_type  == 2){
                $length = 1000;
            }
        $sale_id = '';
        $sale_status = 1;
        $sales     = $this->pos_plus_model->get_sales_data($start, $length, $search_key_val, $dine_type, $sale_status, $sale_id, $get_count = false);
        /*$totalData = $this->pos_plus_model->get_sales_data(    '',      '', $search_key_val, $dine_type, $sale_status, $sale_id, $get_count = false);*/
        /*$totalFiltered = $totalData;*/
        $style         = '';
        $data          = array();
        if ($this->session->userdata('ss_group_id') == 3) {
            $style = 'display:none';
        }
        
        //print_r($sales);
        if (!empty($sales)) {
            foreach ($sales as $row) {
                //print_r($row['sale_id']);
                $nestedData = array();
                
                $sale_id           = $row['sale_id'];
                $total_paid_amount = $this->Sales_Model->get_total_paid_by_sale_id($sale_id);
                $return_tot_amt    = 0;

                $to_be_paid        = $row['sale_total'] - $return_tot_amt - $total_paid_amount;

                $sale_items        = $this->bar_model->get_sale_items_by_sale_id($sale_id);
                $si                = '<table class="table table-condensed dataTable" id="items_'.$sale_id.'">';
                for ($i = 0; $i < count($sale_items); $i++) {
                    //print_r($sale_items[$i]);
                    // $item_delete='<td><button onclick="remove_saved_sale_item_by_login('.$sale_items[$i]['id'].');" class="btn btn-xs btn-danger" data-toggle="tooltip" title="REMOVE THIS ITEM">X</button>' . '</td>';
                    $item_delete=''; 
                    // if($to_be_paid<=$total_paid_amount){
                    // }
                    $si = $si . '<tr data-product_id="'.$sale_items[$i]['product_id'].'" data-sale_item_id="'.$sale_items[$i]['product_id'].'" data-sale_item_price="'.$sale_items[$i]['unit_price'].'" ><td class="col-xs-11">' . $sale_items[$i]['product_name'] .' <span class="" style="width: 50%;text-align:center;display: inline-block;float: right;"> '.$sale_items[$i]['unit_price']. '</span></td><td class="col-xs-1"> ' . intval($sale_items[$i]['quantity']) . '</td>'.$item_delete.'</tr>';
                }
                $si = $si . '</table>';
                
				$table_id = "SALE ID : <strong>".$row['sale_id']."</strong><br>";

				if($row['dine_type'] == 1)$table_id .= "Table no :  <strong>".$row['table_id']."</strong><br> Waiter :  <strong>".$row['waitername']."</strong><br>Cashier : <strong> ".$row['cashier']."</strong>";

                $nestedData[] = $table_id;
                $nestedData[] = /*display_time_format(*/ $row['sale_datetime'] /*)*/ ; //print_r($nestedData);
                $nestedData[] = $row['cus_phone'].$total_paid_amount;
                $nestedData[] = $si;
                $nestedData[] = '<p style="text-align:right">' . $row['sale_total']. '</p>';
                $btn          = '';
                
                $split = '';
                if(count($sale_items) > 1)
                    $split = '<div class="btn btn-default col-xs-12 splitbtn" onClick ="split_sale(`' . $sale_id . '`)" style="cursor:pointer;font-size: 14px; margin:5px 0px 1px 0px;"> Split Bill </div>';
                
                $btn_continue = $this->ftr['edt_sle'] ? '<div class="btn btn-warning col-xs-12 contbtn" style="cursor:pointer;font-size: 14px; margin:5px 0px 1px 0px;" onClick ="edit_sale(`' . $sale_id . '`) ">CONTINUE ></div>' : '';
                //$btn_cancel = '<div class="btn btn-warning col-xs-12 " style="cursor:pointer;font-size: 14px; margin:5px 0px 1px 0px;" onClick ="cancel_sale(`' . $sale_id . '`) ">Cancel</div>';
                if($this->session->userdata('ss_group_id')==1 ||$this->session->userdata('ss_group_id')==2||$this->session->userdata('ss_group_id')==4 ){
                $btn_cancel = '<div class="btn btn-danger col-xs-12 " style="cursor:pointer;font-size: 14px; margin:5px 0px 1px 0px;" onClick ="cancel_sale_by_login(`' . $sale_id . '`) ">Remove</div>';
                }else{
                    $btn_cancel='';
                }
                $btn_complete    = '<div align="center" class"col-xs-12">
                                        <span class="btn btn-warning col-xs-12" style="cursor:pointer;font-size: 14px; margin:1px" onClick ="complete_sale(`' . $sale_id . '`) ">Complete Sale</span>
                                        <span class="btn btn-info col-xs-12" style="cursor:pointer;font-size: 14px; margin:1px" onClick ="complete_and_print(`' . $sale_id . '`) ">Complete and Print Sale</span>
                                    </div>';
                                    
                                $kotbtn = '<div class="btn btn-warning col-xs-12" style="cursor:pointer;font-size: 14px; margin:1px" onClick ="print_on_kot(`' . $sale_id . '`) ">Print ON KOT</div>
                                        <div class="btn btn-warning col-xs-12" style="cursor:pointer;font-size: 14px; margin:1px" onClick ="print_on_bot(`' . $sale_id . '`) ">Print ON BOT</div>';
                $btn_print_bill  = '<div align="center" class"col-xs-12">
                                        <div class="btn btn-info    col-xs-12" style="cursor:pointer;font-size: 14px; margin:1px" onClick ="print_bill(`' . $sale_id . '`) ">Print Bill</div>
                                    </div>';
                
                $btn_ready_takeaway = ($row['ready_sale'] == 1)?'':'<div align="center" class"col-xs-12">
                                                                        <div class="btn btn-info col-xs-12" style="cursor:pointer;font-size: 14px; margin:1px" onClick ="ready_takeaway(`' . $sale_id . '`,'.(($row['cus_phone'] != "")?$row['cus_phone']:'0').',' . $row['sale_total'] . ') ">Order ready</div>
                                                                    </div>';
                //echo "$btn_ready_takeaway";
                $btn_ready_delivery = (($row['ready_sale'])?"":'<span class="label label-info col-xs-12" style="cursor:pointer;font-size: 14px; margin:1px; padding:20px;" onClick ="ready_sale(`' . $sale_id . '`,'.$row['cus_phone'].',' . $row['sale_total'] . ')">Order ready</span>').'';
                
                if ($dine_type == 1){
                    if ($row['payment_status'] == 'paid') {
                            $pay_st = '<span class="btn btn-success" style="font-size:14px">Paid </span>';
                            $btn= $btn_complete;
                    } else {
                        $pay_st     = ($row['payment_status'] == 'partial') ? '<span class="label label-info" style="font-size:14px">Partial</span>' : '<span class="label label-warning" style="font-size:14px">Pending</span>';
                        $btn = $split.$btn_print_bill.$btn_cancel.$btn_continue;
                    }
                }else if($dine_type == 2){
                    if ($row['payment_status'] == 'paid') {
                            $pay_st = '<span class="btn btn-success" style="font-size:14px">Paid</span>';
                            $btn= $btn_complete;
                    } else {
                        if($row['payment_status'] == 'partial'){
                            $pay_st     = '<span class="label label-info" style="font-size:14px">Partial</span>';
                            $btn = ($row['ready_sale'])? $btn_print_bill: $btn_cancel.$btn_ready_takeaway.$btn_print_bill.$btn_continue;
                        }else{
                            $pay_st     = '<span class="label label-warning" style="font-size:14px">Pending</span>';
                            $btn = ($row['ready_sale'])? $btn_print_bill.$btn_continue : $btn_cancel.'<div style="display: flex;justify-content: space-between;width: 100%;">'.$btn_ready_takeaway.$btn_print_bill.'</div>'.$btn_continue;
                        }
                    }
                }if($dine_type == 3){
                    if ($row['payment_status'] == 'paid') {
                            $pay_st = '<span class="btn btn-success" style="font-size:14px">Paid</span>';
                            $btn= $btn_complete;
                    } else {
                        $pay_st     = '<span class="label label-warning" style="font-size:14px">Pending</span>';
                        $btn = ($row['ready_sale'])?$btn_print_bill:$btn_ready_delivery.$btn_print_bill.$btn_continue.$btn_cancel;
                    }
                }
                
                $nestedData[] = '<center>' . $pay_st . '</center>';
                
                /*$nestedData[] = '<div class="col-xs-12" style="padding:0px"></div><div class="col-xs-12" style="padding:0px"></div>';*/
                $nestedData[] = $btn;
                $data[] = $nestedData;
            }
            
            $json_data = array(
                /*"recordsTotal" => intval($totalData),
                "recordsFiltered" => intval($totalFiltered),*/
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
        $customers       = $this->bar_model->get_customers($srh_customer_id);
        echo json_encode($customers);
    }
    public function set_as_paid()
    {
        $sale_id              = $this->input->post('sale_id');
        $sale_pymnt_date_time = $this->input->post('sale_pymnt_date_time');

        $paid_by              = $this->input->post('paid_by');
        $given_amount         = $this->input->post('given_amount');

        $paid_by_2              = $this->input->post('paid_by_2');
        $given_amount_2         = $this->input->post('given_amount_2');

        $sale_details         = $this->bar_model->get_sale_info($sale_id);
        $t = false;
        if ($given_amount > 0) {
            $t                    = $this->bar_model->sales_payment($sale_details[0]['sale_id'], $paid_by, $given_amount, $sale_pymnt_date_time, '', '', '', '', "sale", $given_amount, '0');
        }

        if ($given_amount_2 > 0) {
            $t                      = $this->bar_model->sales_payment($sale_details[0]['sale_id'], $paid_by_2, $given_amount_2, $sale_pymnt_date_time, '', '', '', '', "sale", $given_amount_2, '0');
        }
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
    public function complete_sale()
    {
        $this->load->model("sms_model");
        $sale_id = $this->input->post('sale_id');
        /*$sale_info = $this->bar_model->get_sale_info($sale_id);
        if($sale_info[0]['dine_type'] == 2){
            if($cus_phone != "error"){
                $cus_phone = $this->format_phone($sale_info[0]['cus_phone']);
                $msg = "Your order #".$sale_id." is ready. Order Amount:".$sale_info[0]['sale_total']."\nPlease come and collect it. Thank You";
                if($cus_phone)$this->sms_model->send_sms($cus_phone,$msg);
            }
        }
        */
        $t       = $this->bar_model->complete_sale($sale_id);
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
    function get_sale_info_($sale_id)
    {
        $this->db->select('sales.sale_id,sales.warehouse_id,sales.sale_datetime,qts_id');
        $this->db->from('sales');
        $this->db->where("sales.sale_id", $sale_id);
        $query = $this->db->get();
        return $query->row();
    }
    function get_sale_id_by_sale_item_id($id)
    {
        $this->db->select('sales.sale_id,sales.warehouse_id,sales.sale_datetime');
        $this->db->from('sales');
        $this->db->join('sale_items', 'sales.sale_id = sale_items.sale_id', 'left');
        $this->db->where("sale_items.id", $id);
        $query = $this->db->get();
        return $query->row();
    }
    function get_sale_item_info($id)
    {
        $this->db->select('product_id,quantity,unit_price');
        $this->db->from('sale_items');
        $this->db->where("id", $id);
        $query = $this->db->get();
        return $query->row();
    }
    public function sales_item_delete_($sale_item_id="")
    {
        $this->load->model('stock_model');
        $sale_item_id    = $this->input->get('sale_id') ? $this->input->get('sale_id') : $sale_item_id;
        $uniq_id    = $this->input->get('uuid');
        $sale_info = $this->get_sale_id_by_sale_item_id($sale_item_id);
        
        $sale_item_info = $this->get_sale_item_info($sale_item_id);
        
        $date = date("Y-m-d H:i:s");
        
        $movements_list = array();
            $data = array(
                'location_id' => $sale_info->warehouse_id,
                'transaction_id' => $uniq_id,
                'product_id' => $sale_item_info->product_id,
                'quantity' => $sale_item_info->quantity,
                'unit_value' => $sale_item_info->unit_price,
                'movement_type' => 'in',
                'movement_date' => $sale_info->sale_datetime,
                'origin' => 'sale_cancel',
                'origin_id' => $sale_info->sale_id
            );
        $movements_list[] = $data;
        $this->db->trans_start();

        $result     = $this->delete_sale_item($sale_item_id);
        
        /*add recipe items to the movements list*/
        
        $recipe = $this->get_recipe($sale_info->warehouse_id, $sale_item_info->product_id);
        //print_r($recipe);
        foreach($recipe as $rcp_itm){
            $data = array(
                'location_id' => $sale_info->warehouse_id,
                'transaction_id' => $uniq_id,
                'product_id' => $rcp_itm->ingredient_id,
                'quantity' => $rcp_itm->quantity * $sale_item_info->quantity,
                'unit_value' => $rcp_itm->cost_per_item,
                'movement_type' => 'in',
                'movement_date' => $date,
                'origin' => 'unconsume',
                'origin_id' => $sale_info->sale_id
            );
            $movements_list[] = $data;
        }
        
        
        /*end add*/
        //print_r($result);
        //sleep(1);
        
        $invoice_data = $this->Sales_Model->get_sale_item_total($sale_info->sale_id);
        $newdata         = array(
            'sale_total' => $invoice_data['gross_total'],
            'cost_total' => $invoice_data['cost_total'],
            'updated_by' => $this->session->userdata('ss_user_id'),
            'update_on' => $date
        );

        
        $resp = $this->update_sale_master($sale_info->sale_id, $newdata);
        
        $this->stock_model->bulkInsertMovements_($movements_list);
        $this->common_model->add_user_activitie("Sale Item Delete");
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE)
        {
            echo json_encode(array(
                'success' => $result ? true : false
            ));
        }
        else{
            echo json_encode(array(
                'success' => $result ? true : false
            ));
        }
    }
    function delete_sale_item($id)
    {
        if ($id > 0) {
            $this->db->where('id', $id);
            $this->db->delete('sale_items');
            return $this->db->affected_rows();
        } else {
            return 0;
        }
    }
    public function cancel_sale()
    {
        $sale_id = $this->input->post('sale_id');
        $uniq_id    = $this->input->post('uuid');
        $cancellation_reasons = $this->input->post('cancellation_reasons');
        
        $this->db->trans_start();
        $t       = $this->cancel_sale_($sale_id,$cancellation_reasons);
        if ($t){
            $this->db->select('id');
            $this->db->from('sale_items');
            $this->db->where('sale_id',$sale_id);
            $qry = $this->db->get();
            $rslt = $qry->result();
            
            foreach($rslt as $r){
                $this->cancel_items($r->id,$uniq_id);
            }
        }
        
        $t       = $this->cancel_payments($sale_id);

        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE)
        {
            $this->common_model->add_user_activitie("Invoice cancellation failed, (Invoice No:$sale_id)");
            echo json_encode(array(
                'sale_id' => '',
                'error' => '0',
                'disMsg' => 'Something went wrong !'
            ));
            
        }else{
            $this->common_model->add_user_activitie("Invoice cancelled, (Invoice No:$sale_id)");
            echo json_encode(array(
                'sale_id' => $sale_id,
                'error' => '0',
                'disMsg' => 'Completed!'
            ));
        }
    }
    function cancel_payments($sale_id){
        $sp = array(
            'sale_id' => $sale_id,
            'sale_payment_type' => 'sale',
        );
        $this->db->where($sp);
        $this->db->update('sale_payments',array(
            'valid_status' => 0
        ));
    }
    function cancel_items($sale_item_id,$uniq_id){
        $this->load->model('stock_model');
        
        $sale_info = $this->get_sale_id_by_sale_item_id($sale_item_id);
        $sale_item_info = $this->get_sale_item_info($sale_item_id);
        $date = date("Y-m-d H:i:s");

        $movements_list = array();
        $data = array(
            'location_id' => $sale_info->warehouse_id,
            'transaction_id' => $uniq_id,
            'product_id' => $sale_item_info->product_id,
            'quantity' => $sale_item_info->quantity,
            'unit_value' => $sale_item_info->unit_price,
            'movement_type' => 'in',
            'movement_date' => $sale_info->sale_datetime,
            'origin' => 'sale_cancel',
            'origin_id' => $sale_info->sale_id
        );
        $movements_list[] = $data;

        /*add recipe items to the movements list*/
        
        $recipe = $this->get_recipe($sale_info->warehouse_id, $sale_item_info->product_id);
        //print_r($recipe);
        foreach($recipe as $rcp_itm){
            $data = array(
                'location_id' => $sale_info->warehouse_id,
                'transaction_id' => $uniq_id,
                'product_id' => $rcp_itm->ingredient_id,
                'quantity' => $rcp_itm->quantity * $sale_item_info->quantity,
                'unit_value' => $rcp_itm->cost_per_item,
                'movement_type' => 'in',
                'movement_date' => $date,
                'origin' => 'unconsume',
                'origin_id' => $sale_info->sale_id
            );
            $movements_list[] = $data;
        }
        
        $invoice_data = $this->Sales_Model->get_sale_item_total($sale_info->sale_id);
        $newdata         = array(
            'sale_total' => $invoice_data['gross_total'],
            'cost_total' => $invoice_data['cost_total'],
            'updated_by' => $this->session->userdata('ss_user_id'),
            'update_on' => $date
        );
        $this->update_sale_master($sale_info->sale_id, $newdata);
        $this->stock_model->bulkInsertMovements_($movements_list);
        
    }
    function delete_items($sale_item_id,$uniq_id){
        $this->load->model('stock_model');
        
        $sale_info = $this->get_sale_id_by_sale_item_id($sale_item_id);
        
        $sale_item_info = $this->get_sale_item_info($sale_item_id);
        
        $date = date("Y-m-d H:i:s");
        
        $movements_list = array();
            $data = array(
                'location_id' => $sale_info->warehouse_id,
                'transaction_id' => $uniq_id,
                'product_id' => $sale_item_info->product_id,
                'quantity' => $sale_item_info->quantity,
                'unit_value' => $sale_item_info->unit_price,
                'movement_type' => 'in',
                'movement_date' => $sale_info->sale_datetime,
                'origin' => 'sale_cancel',
                'origin_id' => $sale_info->sale_id
            );
        $movements_list[] = $data;

        $result     = $this->delete_sale_item($sale_item_id);
        
        /*add recipe items to the movements list*/
        
        $recipe = $this->get_recipe($sale_info->warehouse_id, $sale_item_info->product_id);
        //print_r($recipe);
        foreach($recipe as $rcp_itm){
            $data = array(
                'location_id' => $sale_info->warehouse_id,
                'transaction_id' => $uniq_id,
                'product_id' => $rcp_itm->ingredient_id,
                'quantity' => $rcp_itm->quantity * $sale_item_info->quantity,
                'unit_value' => $rcp_itm->cost_per_item,
                'movement_type' => 'in',
                'movement_date' => $date,
                'origin' => 'unconsume',
                'origin_id' => $sale_info->sale_id
            );
            $movements_list[] = $data;
        }
        
        $invoice_data = $this->Sales_Model->get_sale_item_total($sale_info->sale_id);
        $newdata         = array(
            'sale_total' => $invoice_data['gross_total'],
            'cost_total' => $invoice_data['cost_total'],
            'updated_by' => $this->session->userdata('ss_user_id'),
            'update_on' => $date
        );
        $this->update_sale_master($sale_info->sale_id, $newdata);
        $this->stock_model->bulkInsertMovements_($movements_list);
        
    }
    function update_sale_master($sale_id, $data)
    {
        if (!$sale_id)
            return 0;
        $this->db->where('sale_id', $sale_id);
        $this->db->update('sales', $data);
        //echo $this->db->last_query();
        return $this->db->affected_rows();
    }
    function get_recipe($location_id,$product_id){
        $this->db->select('product_id,ingredient_id,quantity,cost_per_item');
        $this->db->from('recipe_items');
        $this->db->where('product_id',$product_id);
        $this->db->where('location_id',$location_id);
        $this->db->where('is_active',1);
        $query = $this->db->get();
        return $query -> result();
    }
    function cancel_sale_($sale_id , $cancellation_reasons="")
    {
        if($sale_id > 0)
        return $this->db->query('UPDATE `sales` SET `sale_status`= 99, `cancellation_reasons` = "'.$cancellation_reasons.'" WHERE `sale_id` = ' . $sale_id);
        else return false;
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

            $product_data = array(
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


            $last_id = $this->bar_model->save_product($product_data); //, $product_code, $category, $subcategory, $unit, $product_cost, $product_price, $wholesale_price, $credit_salling_price, $tax, $alert_quty, NULL, NULL, $product_details, $product_part_no, $product_oem_part_number, $product_id, $store_position, $product_max_qty);
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
        $sale_items    = $this->bar_model->check1();
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
    function get_otp()
    {
        $sale_id = $this->input->post('sale_id');
        $wh = $this->Warehouse_Model->get_warehouse_info($this->session->userdata['ss_warehouse_id']);
        $sms_no = $wh['sms_no'];
        //print_r($sms_no);
        $this->load->model("sms_model");
        $otp         = (rand(1000, 9999));
        $error = 0;
        $response = $this->sms_model->send_sms($sms_no, "Your OTP for sale no " . $sale_id . " is " . $otp);
        $obj = json_decode($response);
        if ($obj->error) {
            $error = $obj->error;
        }
        $return_data = array(
            "otp" => $otp,
            "error" => $error,
            "msg" => 'Your passcode is ' . $otp,
            "response" => $response
        );
        echo json_encode($return_data);
    }
    public function ready_sale()
    {
        $this->load->model("sms_model");
        $sale_id = $this->input->post('sale_id');
        $cus_phone = $this->format_phone($this->input->post('cus_phone'));
        $sale_total = $this->input->post('amount');
        $rider_name = $this->input->post('rider_name');
        $rider_phone = $this->format_phone($this->input->post('rider_phone'));
        if ($cus_phone == "error") {
            echo json_encode(array(
                'sale_id' => $sale_id,
                'error' => '1',
                'disMsg' => 'Invalid phone number for customer!'
            ));
            exit;
        }
        if ($rider_phone == "error") {
            echo json_encode(array(
                'sale_id' => $sale_id,
                'error' => '1',
                'disMsg' => 'Invalid phone number for rider!'
            ));
            exit;
        }
        $msg = "Your order #" . $sale_id . " is dispatched by " . (($rider_name != "") ? $rider_name : "...") . ". " . (($rider_name != "") ? "Contact No. " . $rider_phone : "") . "\nOrder Amount:" . $sale_total . " \nThank You. ";
        //$msg = "Your order no ".$sale_id." will be delivered by \n".(($rider_name!= "")?"Rider:".$rider_name:"")."\n".(($rider_name!= "")?"Phone:".$rider_phone:"");
        if ($cus_phone) $this->sms_model->send_sms($cus_phone, $msg);

        $t       = $this->bar_model->ready_sale($sale_id);
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
    public function ready_takeaway()
    {
        $error = "";
        $disMsg = "";
        $this->load->model("sms_model");
        $sale_id = $this->input->post('sale_id');
        $cus_phone = $this->format_phone($this->input->post('cus_phone'));
        $sale_total = $this->input->post('amount');
        if ($cus_phone == "error") {
            $error = 1;
            $disMsg .= '<p>Invalid phone number for customer!</p>';
        }
        $msg = "Your order #" . $sale_id . " is ready. \nOrder Amount:" . $sale_total . " \nPlease come and collect it. Thank You. ";
        //$msg = "Your order no ".$sale_id." will be delivered by \n".(($rider_name!= "")?"Rider:".$rider_name:"")."\n".(($rider_name!= "")?"Phone:".$rider_phone:"");
        if ($cus_phone) $this->sms_model->send_sms($cus_phone, $msg);

        $t       = $this->bar_model->ready_sale($sale_id);
        if ($t == true) {
            $error = 0;
            $disMsg .= '<p>Sale is ready!</p>';
        } else {
            $error = 1;
            $disMsg .= '<p>Error!</p>';
        }
        echo json_encode(array(
            'sale_id' => $sale_id,
            'error' => $error,
            'disMsg' => $disMsg
        ));
    }
    function format_phone($phone)
    {
        $rv = "";
        $filtered_phone_number = filter_var($phone, FILTER_SANITIZE_NUMBER_INT);
        $phone_to_check = str_replace("-", "", $filtered_phone_number);
        $phone_to_check = intval($phone_to_check);
        if (strlen($phone_to_check) < 9 || strlen($phone_to_check) > 12) {
            $rv = "error";
        } else {
            $rv = substr($phone_to_check, -9);
        }
        return $rv;
    }
    private function validate_customer_by_phone($phone,$name)
      {
        if($phone == "" || $name = ""){
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
    function save_custom_orders(){
        /*echo json_encode(
            array(
                'post' => $this->input->post()
                )
            );
            
        exit; */
        
        $post_data = $this->input->post();
        
        $cust_name = $post_data['cust_name'];
        $cust_phone = $post_data['cust_phone'];
        $delivery_date = $post_data['delivery_date'];
        $delivery_type = $post_data['delivery_type'];
        $store_id = $post_data['store_id'];
        $delivery_address = $post_data['delivery_address'];
        $order_products = $post_data['cust'];
        $custom_order_total = $post_data['custom_order_total'];
        $uuid = $post_data['uuid'];
        
        $this->db->trans_start();
        
        $cus_id = $this->validate_customer_by_phone($cust_phone, $cust_name);

        // Insert data into the header table ("custom_orders")
        $header_data = array(
            'cust_name' => $cust_name,
            'cust_phone' => $cust_phone,
            'customer_id' => $cus_id,
            'uuid'      => $uuid,
            'delivery_date' => $delivery_date,
            'delivery_type' => $delivery_type,
            'store_id' => $store_id,
            'delivery_address' => $delivery_address,
            'custom_order_total' => $custom_order_total[0] // Assuming there's only one total
        );

        
        $this->db->insert('custom_orders', $header_data);
        $order_id = $this->db->insert_id();

        // Insert data into the item table ("custom_order_items")
        $product_ids = $order_products['product_id'];
        $product_names = $order_products['product_name'];
        $product_codes = $order_products['product_code'];
        $product_notes = $order_products['product_note'];
        $prices = $order_products['price'];
        $discounts = $order_products['discount'];
        $quantities = $order_products['quantity'];
        $subtotals = $order_products['subtotal'];

        $post_items = array();
        // Loop through products and insert each one
        for ($i = 0; $i < count($product_ids); $i++) {
            $item_data = array(
                'order_id' => $order_id,
                'product_id' => $product_ids[$i],
                'product_code' => $product_codes[$i],
                'product_note' => $product_notes[$i],
                'price' => $prices[$i],
                'discount' => $discounts[$i],
                'quantity' => $quantities[$i],
                'subtotal' => $subtotals[$i]
            );

            $post_items[] = array(
                'product_id' => $product_ids[$i],
                'product_code' => $product_codes[$i],
                'product_name' => $product_names[$i],
                'product_note' => $product_notes[$i],
                'qty' => $quantities[$i]
            );
            
            $this->db->insert('custom_order_items', $item_data);
        }
        $this->db->trans_complete();
        // Send a response
        
        if ($this->db->trans_status() === FALSE)
        {
            echo json_encode(array('status' => 'false', 'message' => 'Order not saved successfully'));
            return;
        }
        
        $this->db->select('*');
        $this->db->get_where('warehouse_id');
        $query = $this->db->get_where('locations', array('id' => $this->session->userdata('ss_warehouse_id')));
        $result = $query->row();
        
        $url       = "https://admin.fab.test.newviableerp.com/api/bulk_orders";
        $post_data      = array(
            'outlet_code' => $result->code,
            'uuid' => '',
            'outlet_name' => $result->name,
            'order_date' => $delivery_date,
            'type'  => "Customer",
            'origin_type' => 'co',
            'origin_id' => $order_id,
            'ref_no' => 'OD'.$order_id,
            'items' => $post_items
        );
        
        $resp = $this->post_transfer($url,$post_data);
        $resp = json_decode($resp);
        
        if(isset($resp->error)){
            echo json_encode(array('status' => 'false', 'message' => 'Order save failed', 'resp' => $resp));
        }else
            echo json_encode(array('status' => 'success', 'message' => 'Order saved successfully', 'resp' => $resp));
        
    }
    
     public function post_transfer($url,$data)
    {
        // Convert the data array to JSON format
        $json_data = json_encode($data);
        // Initialize cURL session
        $ch        = curl_init($url);
        // Set the cURL options for the POST request
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($json_data)
        ));
        // Execute the cURL request
        $response = curl_exec($ch);
        // Check for errors
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        // Close cURL session
        curl_close($ch);
        // Output the response
        return $response;
    }
    function get_inv_count(){
        $this->db->select('count(sale_id) as count');
        $this->db->from('sales');
        $this->db->where('float_id', $this->session->userdata('ss_cashier_float_id'));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            echo json_encode(array(
                'count' => $query->row()->count
            ));
        } else {
            echo json_encode(array(
                'count' => 0
            ));
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
        $this->load->model('pos_model');
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
        $continued       = $this->input->post('continued');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('uniq_id', 'Bill is unique', 'is_unique[sales.uniq_id]');
        if(!$continued){
            $this->form_validation->set_rules('sale_id', 'Bill is already added', 'is_unique[sales.sale_id]');
        }
        if (!$this->form_validation->run()) {
            echo json_encode(array(
                'success' => true,
                'sale_id' => 0,
                'sale_ref' => $this->input->post('uniq_id'),
                'error' => '1',
                'disMsg' => 'this bill already added. please use reprint if you haven\'t received bill print',
                'duplicate' => 1
            ));
            return false;
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
        $payments                 = $this->input->post('payment');
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
            //print_r($payments);
            
            if ($pay_amount > 0) {
                if($this->settings['mlt_pmt']){
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
                }else{
                    /* $payments[1]['type'] = visa */
                    if ($payments[1]['amount'] > 0) {
                        if ($payments[1]['amount'] <= $grand_total) {
                            $pmData = array(
                                'sale_id' => $sale_id,
                                'sale_pymnt_paying_by' => "visa",
                                'sale_pymnt_amount' => $payments[1]['amount'],
                                'sale_pymnt_date_time' => $sale_date,
                                'sale_pymnt_added_date_time' => date("Y-m-d H:i:s"),
                                'sale_pymnt_crdt_card_no' => '',
                                'sale_pymnt_crdt_card_holder_name' => '',
                                'sale_pymnt_crdt_card_type' => '',
                                'sale_payment_type' => 'sale',
                                'sale_pymnt_given_amount' => $payments[1]['amount'],
                                'sale_pymnt_balance_amount' => 0,
                                'user_id' => $this->session->userdata('ss_user_id'),
                                'float_id' => $this->session->userdata('ss_cashier_float_id')
                            );
                            $this->db->insert('sale_payments', $pmData);
                            $queries[] = $this->db->last_query();
                            
                            if ($payments[0]['amount'] > 0) {
                                $rem_pymnt = $grand_total - $payments[1]['amount'];
                                if($rem_pymnt <= $payments[0]['amount']){
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
                                        'sale_pymnt_given_amount' => $payments[0]['amount'],
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
                        if ($payments[0]['amount'] > 0) {
                            if($grand_total >= $payments[0]['amount'] ){
                                $pmData = array(
                                    'sale_id' => $sale_id,
                                    'sale_pymnt_paying_by' => "cash",
                                    'sale_pymnt_amount' => $payments[0]['amount'],
                                    'sale_pymnt_date_time' => $sale_date,
                                    'sale_pymnt_added_date_time' => date("Y-m-d H:i:s"),
                                    'sale_pymnt_crdt_card_no' => '',
                                    'sale_pymnt_crdt_card_holder_name' => '',
                                    'sale_pymnt_crdt_card_type' => '',
                                    'sale_payment_type' => 'sale',
                                    'sale_pymnt_given_amount' => $payments[0]['amount'],
                                    'sale_pymnt_balance_amount' => 0,
                                    'user_id' => $this->session->userdata('ss_user_id'),
                                    'float_id' => $this->session->userdata('ss_cashier_float_id')
                                );
                                $this->db->insert('sale_payments', $pmData);
                                $queries[] = $this->db->last_query();
                            }else if($grand_total < $payments[0]['amount'] ){
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
                                    'sale_pymnt_given_amount' => $payments[0]['amount'],
                                    'sale_pymnt_balance_amount' => 0,
                                    'user_id' => $this->session->userdata('ss_user_id'),
                                    'float_id' => $this->session->userdata('ss_cashier_float_id')
                                );
                                $this->db->insert('sale_payments', $pmData);
                                $queries[] = $this->db->last_query();
                            }
                        }
                    }
                }
                /*exit;*/
                /**/
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
                    'success' => true,
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
                'success' => true,
                'sale_id' => $sale_id,
                'error' => '0',
                'disMsg' => 'Sales record has not saved'
            ));
            return false;
        }
        exit;
    }
}
