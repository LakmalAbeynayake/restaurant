<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class pos_api extends CI_Controller
{
    var $main_menu_name = "";
    var $sub_menu_name = "";
    public function __construct()
    {
        parent::__construct();
        $this->load->model('common_model');
        $this->load->model('api_model');
        $this->load->model('customer_model');
        
        if ($this->router->method != "paycorp_view") {
            header('Content-Type: application/json');
            if (!isset($_SERVER['CONTENT_TYPE'])) {
                $data = array(
                    "status" => 0,
                    "msg" => "Content Type undefined.",
                    "err_code" => "ipasop400-i"
                );
                echo json_encode($data);
                exit();
            }
            if ($_SERVER['CONTENT_TYPE'] !== "application/json" && $_SERVER['CONTENT_TYPE'] !== "application/json; charset=utf-8") {
                $data = array(
                    "status" => 0,
                    "msg" => "Invalid content type! JSON required. Received:" . $_SERVER['CONTENT_TYPE'],
                    "err_code" => "ipasop401-i"
                );
                echo json_encode($data);
                exit();
            }
            $_POST = json_decode(file_get_contents("php://input"), true);
        }
        if ($this->router->method != "login" && $this->router->method != "get_categories" && $this->router->method != "paycorp_view") {
            /**/
            if ($this->router->method == "test_session"){
                if(!is_logged_in()){
                    $st = array(
                        "status" => 0,
                        "msg" => "session expired!",
                        "err_code" => "ipasop201-a"
                    );
                    echo json_encode($st);
                    exit;
                }
            }else
            
            /**/
            if (!$this->input->post('session_id')) {
                $data = array(
                    "status" => 0,
                    "msg" => "session_id is required.",
                    "err_code" => "ipasop405-i"
                );
                echo json_encode($data);
                exit();
            } else if (!$this->is_api_logged_in($this->input->post('session_id'))) {
                $st = array(
                    "status" => 0,
                    "msg" => "session expired!",
                    "err_code" => "ipasop201-a"
                );
                echo json_encode($st);
                exit;
            }
            
        }
    }
    function test_session(){
        echo json_encode(array(
            "status"=>1,
            "msg"   => "YEAAAAAAH BROOO!!!"
        ));
    }
    public function index()
    {
        $data = array(
            "status" => 0,
            "msg" => "Error",
            "err_code" => "ipasop200-a"
        );
        echo json_encode($data);
    }
    function login()
    {
        $this->load->model('User_Model');
        $incomingContentType = $_SERVER['CONTENT_TYPE'];
        if ($_SERVER['CONTENT_TYPE'] !== "application/json" && $_SERVER['CONTENT_TYPE'] !== "application/json; charset=utf-8") {
            header($_SERVER['SERVER_PROTOCOL'] . '500 Internal Server Error');
            exit();
        }
        $_POST = json_decode(file_get_contents("php://input"), true);
        $this->load->library('form_validation');
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        if ($this->form_validation->run() == FALSE) {
            $st = array(
                "status" => 0,
                "msg" => validation_errors()
            );
            echo json_encode($st);
        } else {
            $user_username = $this->input->post('username');
            $password      = $this->input->post('password');
            $user_id       = $this->User_Model->login($user_username, $password);
            if ($user_id) {
                $data['user_details'] = $this->User_Model->get_user_info($user_id);
                $ss_user_username     = $data['user_details']['user_username'];
                $ss_user_id           = $data['user_details']['user_id'];
                $ss_group_id          = $data['user_details']['group_id'];
                $ss_warehouse_id      = $data['user_details']['warehouse_id'];
                $ss_user_first_name   = $data['user_details']['user_first_name'];
                $ss_user_last_name    = $data['user_details']['user_last_name'];
                $ss_user_group_name   = $data['user_details']['user_group_name'];
                $sesdata              = array(
                    'ss_user_username' => $ss_user_username,
                    'ss_user_id' => $ss_user_id,
                    'ss_group_id' => $ss_group_id,
                    'ss_warehouse_id' => $ss_warehouse_id,
                    'ss_user_first_name' => $ss_user_first_name,
                    'ss_user_last_name' => $ss_user_last_name,
                    'ss_user_group_name' => $ss_user_group_name
                );
                $this->User_Model->create_user_sessions($sesdata);
                $st = array(
                    "status" => 1,
                    "msg" => "Done!",
                    "session" => $this->session->userdata
                );
                $this->api_model->add_session("");
                echo json_encode($st);
            } else {
                $st = array(
                    "status" => 0,
                    "msg" => "Invalid username or password!",
                    "err_code" => "ipasop202-a"
                );
                echo json_encode($st);
            }
        }
    }
    function logout()
    {
        $sesdata = array(
            'ss_user_username' => '',
            'ss_user_id' => '',
            'ss_group_id' => '',
            'ss_warehouse_id' => '',
            'ss_user_first_name' => '',
            'ss_user_last_name' => '',
            'ss_user_group_name' => ''
        );
        $this->common_model->add_user_activitie("Logout User");
        $this->session->unset_userdata($sesdata);
        $st = array(
            'status' => 1,
            'msg' => "Logged out successfully!"
        );
        echo json_encode($st);
    }
    function get_cus_like()
    {
        $srh_term = $this->input->post('suggestion');
        $result   = $this->customer_model->get_search_customer($srh_term);
        echo json_encode(array(
            "status" => 1,
            "msg" => "Success",
            "suggetions" => $result
        ));
    }
    function get_categories()
    {
        $this->load->model('category_models');
        $cats = $this->category_models->getCategory();
        $data = array();
        foreach ($cats as $key => $row) {
            $nestedData                   = array();
            $nestedData['app_cat_id']     = $row->cat_id + 0;
            $nestedData['app_cat_name']   = $row->cat_name;
            $nestedData['app_cat_image']  = $row->cat_image;
            $nestedData['app_cat_status'] = $row->cat_status + 0;
            $data[]                       = $nestedData;
        }
        echo json_encode(array(
            "status" => 1,
            "msg" => "Success",
            "categories" => $data
        ));
    }
    function get_products($category_id = "")
    {
        $category_id = $this->input->post('category_id');
        $out_cat     = '';
        $out_sub     = '';
        $d           = $this->api_model->get_product_by_cat_id($category_id);
        if (!empty($d)) {
            foreach ($d as $key => $row) {
                $d[$key]->product_thumb = asset_url() . 'uploads/thumbs/' . $d[$key]->product_thumb;
                $d[$key]->product_image = asset_url() . 'uploads/' . $d[$key]->product_image;
                $d[$key]->product_id    = $d[$key]->product_id + 0;
                $d[$key]->product_price = $d[$key]->product_price + 0;
                $d[$key]->cat_id        = $d[$key]->cat_id + 0;
                $d[$key]->sub_cat_id    = $d[$key]->sub_cat_id + 0;
                $d[$key]->min_order_qty = $d[$key]->min_order_qty + 0;
            }
            echo json_encode(array(
                "status" => 1,
                "msg" => "Success",
                "products_of_cat" => $d
            ));
        } else {
            $jproduct = array();
            echo json_encode(array(
                "status" => 0,
                "msg" => "Failed. (Error code: ipasop403-i)",
                "products_of_cat" => $jproduct
            ));
        }
    }
    function get_product_info()
    {
        $product_id = $this->input->post('product_id');
        $out_cat    = '';
        $out_sub    = '';
        $d          = $this->api_model->get_product_by_product_id($product_id);
        if (!empty($d)) {
            $d['product_thumb'] = asset_url() . 'uploads/thumbs/' . $d['product_thumb'];
            $d['product_image'] = asset_url() . 'uploads/' . $d['product_image'];
            $d['product_id']    = $d['product_id'] + 0;
            $d['product_price'] = $d['product_price'] + 0;
            $d['cat_id']        = $d['cat_id'] + 0;
            $d['sub_cat_id']    = $d['sub_cat_id'] + 0;
            $d['min_order_qty'] = $d['min_order_qty'] + 0;
            $d['sizes']         = json_decode("{}");
            $sizes              = $this->api_model->get_product_sizes_by_product_id($product_id);
            if (!empty($sizes)) {
                $d['sizes'] = $sizes;
            }
            echo json_encode(array(
                "status" => 1,
                "msg" => "Success",
                "product_info" => $d
            ));
        } else {
            $jproduct = array();
            $ret      = json_encode(array(
                "status" => 0,
                "msg" => "Failed. (Error code: ipasop404-i)",
                "product_info" => json_decode("{}")
            ));
            echo $ret;
        }
    }
    function get_area_like()
    {
        $cname      = $this->input->post('suggestion');
        $country_id = 251;
        $result     = $this->common_model->search_city_by_name_and_country_id($cname, $country_id);
        echo json_encode(array(
            "status" => 1,
            "msg" => "Success",
            "areas" => $result
        ));
    }
    function save_customer()
    {
        $msg          = "";
        $status       = 0;
        $returndata   = "";
        $cus_name     = $this->input->post('cus_name');
        $cus_phone    = $this->input->post('cus_phone');
        $cus_email    = $this->input->post('cus_email');
        $home_address = $this->input->post('home_address');
        $type         = $this->input->post('type');
        $cus_id       = intval($this->input->post('cus_id'));
        $this->load->library('form_validation');
        if ($type == 'A') {
            $_POST['cus_phone'] = $this->format_phone($this->input->post('cus_phone'));
            $this->form_validation->set_rules('cus_name', 'Name', 'required');
            $this->form_validation->set_rules('cus_phone', 'Phone', 'required|is_unique[customer.cus_phone]');
            $this->form_validation->set_rules('cus_email', 'Email', 'required');
            $this->form_validation->set_rules('home_address', 'Home Address', 'required');
        } else if ($type == 'E') {
            $this->form_validation->set_rules('cus_name', 'Name', 'required');
            $this->form_validation->set_rules('cus_email', 'Email', 'required');
            $this->form_validation->set_rules('home_address', 'Home Address', 'required');
        }
        if (!filter_var($cus_email, FILTER_VALIDATE_EMAIL)) {
            $status = 0;
            $msg    = "Invalid email format. (Error code: ipasop300-v)";
        } else if ($this->form_validation->run() == FALSE) {
            $status = 0;
            $msg    = validation_errors();
        } else {
            $cusdata = "";
            if ($type == 'A') {
                $cus_code = $this->Common_Model->gen_ref_number('cus_id', 'customer', 'CUS/');
                $cusdata  = array(
                    'cus_name' => $cus_name,
                    'cus_code' => $cus_code,
                    'cus_email' => $cus_email,
                    'cus_address' => $home_address,
                    'cus_phone' => $cus_phone,
                    'country_id' => "251"
                );
            }
            if ($type == 'E') {
                $cusdata = array(
                    'cus_name' => $cus_name,
                    'cus_email' => $cus_email,
                    'cus_address' => $home_address
                );
            }
            $result = $this->Customer_Model->save_customer($cusdata, $cus_id);
            if ($type == 'A') {
                $lastid = $this->db->insert_id();
                if ($lastid) {
                    $returndata = array(
                        'cus_id' => $lastid,
                        'type' => $type,
                        'cus_email' => $cus_email,
                        'cus_status' => 1,
                        'cus_name' => $cus_name,
                        'cus_address' => $home_address,
                        'cus_phone' => $cus_phone
                    );
                } else {
                    $returndata = array();
                    $status     = 0;
                    $msg        = "Failed! (Error code: ipasop402-i)";
                }
            } else if ($type == 'E') {
                $returndata = array(
                    'cus_id' => $cus_id,
                    'type' => $type,
                    'cus_email' => $cus_email,
                    'cus_status' => 1,
                    'cus_name' => $cus_name,
                    'cus_address' => $home_address,
                    'cus_phone' => $cus_phone
                );
                $status     = 1;
                $msg        = "Updated successfully!";
            }
        }
        echo json_encode(array(
            "status" => $status,
            "msg" => $msg,
            "cus_data" => $returndata
        ));
    }
    function save_sale()
    {
        $this->load->model('app_model');
        $txt_msg                  = "";
        $status                   = 0;
        $msg                      = "Failed";
        $warn                     = "";
        $return_data              = array();
        $sale_id                  = $this->input->post('sale_id');
        $customer_id              = $this->input->post('cus_id');
        $warehouse_id             = $this->input->post('warehouse_id');
        $sale_date                = date('Y-m-d H:i:s', strtotime($this->input->post('sale_datetime')));
        $dine_type                = $this->input->post('dine_type');
        $discount                 = $this->input->post('discount');
        $discount_amount          = $this->input->post('discount_amount');
        $extra_charges            = $this->input->post('extra_charges');// more_cheese, more_sugar, service_charges
        $extra_charges_amount     = $this->input->post('extra_charges_amount');
        $grand_total              = $this->input->post('grand_total');
        $pay_amount               = $this->input->post('pay_amount');
        $paid_by                  = $this->input->post('paid_by');
        $sale_pymnt_balane_amount = $this->input->post('change');
        $sale_note                = $this->input->post('sale_note');
        $shipping_address         = $this->input->post('delivery_address');
        $shipping_date_time       = $this->input->post('delivery_date_time');
        $delivery_charges         = $this->input->post('delivery_charges');
        $sale_ref                 = $this->input->post('sale_reference_no');
        $table_id                 = $this->input->post('table_id');
        if (!$sale_ref) {
            $query    = $this->api_model->get_next_ref_no();
            $result   = $query->row();
            $sale_ref = sprintf("%05d", $result->sale_id + 1);
            //$sale_ref = '(' . date('d') . ')-' . $sale_ref;
        }
        if($dine_type == 1){
            $extra_charges = "10%";
            $extra_charges_amount = $grand_total/100*10;
            $grand_total = $grand_total*1.1;
        }else{
            $extra_charges = "";
            $extra_charges_amount = 0;
        }
        $products   = $this->input->post('products');
        $sales_data = array(
            'sale_id' => $sale_id,
            'sale_reference_no' => $sale_ref,
            'warehouse_id' => $warehouse_id,
            'customer_id' => $customer_id,
            'sale_datetime' => $sale_date,
            'invoice_type' => 5,
            'sale_type' => "android_pos_sale",
            'sale_note' => $sale_note,
            'sale_total' => $grand_total,
            'sale_status'=> 0,
            'sale_inv_discount' => $discount,
            'sale_inv_discount_amount' => $discount_amount,
            'sale_datetime_created' => $sale_date,
            'sale_shipping' => $delivery_charges,
            'shipping_address' => $shipping_address,
            'dine_type' => $dine_type,
            'sale_extra_charges' => $extra_charges,
            'sale_extra_charges_amount' => $extra_charges_amount,
            'user' => 1,
            'table_id' => $table_id
        );
        $sale_id    = $this->api_model->save_sale_header($sales_data, $sale_id);
        if ($sale_id) {
            for ($i = 0; $i < count($products); $i++) {
                if (!isset($products[$i]['product_id']))
                    continue;
                $item_details  = $this->app_model->get_product_details_by_id($products[$i]['product_id']);
                $selling_price = $item_details['product_price'];
                $size_id       = 0;
                if (isset($products[$i]['size_id'])) {
                    if ($products[$i]['size_id']) {
                        $size_price = $this->app_model->get_price_by_size_id($products[$i]['size_id']);
                        if ($size_price->size_price) {
                            $size_id       = $products[$i]['size_id'];
                            $selling_price = $size_price->size_price;
                            $product_name .= "-" . $size_price->size_name;
                        }
                    }
                }
                $error     = 0;
                $tmpDisVal = 0;
                $discount  = "";
                if (isset($products[$i]['discount']))
                    $discount = $products[$i]['discount'];
                $discount_value = 0;
                if ($discount) {
                    if (strpos($discount, "%") !== false) {
                        $pds = explode("%", $discount);
                        if (!is_nan($pds[0])) {
                            $selling_price  = $selling_price - ($selling_price * $pds[0] / 100);
                            $discount_value = $selling_price * $pds[0] / 100;
                        } else {
                            $error = 1;
                        }
                    } else {
                        if (!is_nan($discount)) {
                            $selling_price  = $selling_price - $discount;
                            $discount_value = $discount;
                        } else {
                            $error = 1;
                        }
                    }
                }
                $print_status = 0;
                if(isset($products[$i]['print_status']))
                    $print_status = $products[$i]['print_status'];
                
                $data_item = array(
                    'sale_id' => $sale_id,
                    'product_id' => $products[$i]['product_id'],
                    'size_id' => $size_id,
                    'product_name' => $item_details['product_name'],
                    'product_code' => $item_details['product_code'],
                    'quantity' => $products[$i]['qty'],
                    'print_status' => $print_status,
                    'unit_price' => $selling_price,
                    'item_cost' => $item_details['product_cost'],
                    'gross_total' => $selling_price * $products[$i]['qty'],
                    'discount' => $discount,
                    'discount_val' => $discount_value
                );
                
                $txt_msg .= "  *" . $item_details['product_name'] . "-" . $products[$i]['qty'] . "\n";
                $result = $this->api_model->sale_items_in($data_item);
            }
            $total_paid = 0;
            $payments = array();
                if($this->input->post('payments'))
                    $payments = $this->input->post('payments');
            for ($i = 0; $i < count($payments); $i++) {
                if (!isset($payments[$i]['type']))
                    continue;
                if (!isset($payments[$i]['pay_amount']))
                    continue;
                $paid_by                   = $payments[$i]['type'];
                $pay_amount                = $payments[$i]['pay_amount'];
                $sale_pymnt_given_amount   = ($payments[$i]['given_amount']) ? $payments[$i]['given_amount'] : 0;
                $sale_pymnt_balance_amount = ($payments[$i]['change']) ? $payments[$i]['change'] : 0;
                $pymnt_data                = array(
                    'sale_id' => $sale_id,
                    'sale_pymnt_paying_by' => $paid_by,
                    'sale_pymnt_amount' => $pay_amount,
                    'sale_pymnt_date_time' => $sale_date,
                    'sale_pymnt_added_date_time' => $sale_date,
                    'sale_payment_type' => "sale",
                    'sale_pymnt_given_amount' => $sale_pymnt_given_amount,
                    'sale_pymnt_balance_amount' => $sale_pymnt_balance_amount,
                    'user_id' => $this->session->userdata('ss_user_id')
                );
                $t                         = $this->api_model->sales_payment($pymnt_data);
                if($t)$total_paid += $pay_amount;
            }
            if($total_paid >= $grand_total){
                $this->api_model->complete_sale($sale_id);
            }
            $status = 1;
            $msg = "Success";
            $return_data['sale_id'] = $sale_id;
            $return_data['sale_ref_no'] = $sale_ref;
            // $return_data['sale_status'] = $sale_ref;
        }
        echo json_encode(array(
            "status" => $status,
            "msg" => $msg,
            "sale_data" => $return_data
        ));
    }
    function is_api_logged_in($session_id)
    {
        $logged_in = false;
        $ss_data   = $this->api_model->get_session($session_id);
        if ($ss_data) {
            $logged_in = true;
        }
        return $logged_in;
    }
    /*PAYCORP*/
    function paycorp_view(){
        $data = array();
        //$_POST = json_decode(file_get_contents("php://input"), true);
        
        $amount = $this->input->get('amount');
        $sale_ref = $this->input->get('sale_reference_no');
        
        $amount = base64_decode($amount);
        $sale_ref = base64_decode($sale_ref);
        
        
        
        //$amount = $this->input->get('amount');
        //$sale_ref = $this->input->get('sale_reference_no');
        
        if($amount == "" && $sale_ref == "")
        {
            echo json_encode(array(
                "status" => 0,
                "msg" => "Missing Required data!"
            ));
            exit;
        }else if(!$amount > 0){
            echo json_encode(array(
                "status" => 0,
                "msg" => "Invalid amount!"
            ));
            exit;
        }
        // MTAwMA==
        $data['paymentAmount'] = $amount;
        $data['clientRef'] = $sale_ref;
        $data['comment'] = "";
        $data['returnUrl'] = base_url();
        
        $this->load->view("paycorp/view",$data);
    }
    function table_list(){
        $data = array();
        for($table_id = 1; $table_id <= 50; $table_id++ ){
            $nestedData                   = array();
            $nestedData['table_id']       = $table_id;
            $nestedData['table_name']     = "Table ".$table_id;
            $data[]                       = $nestedData;
        }
        echo json_encode(array(
            "status" => 1,
            "msg" => "Success",
            "valies" => $data
        ));
    }
    function list_sales()
    {
        $dine_type      = $this->input->post('dine_type');
        $d              = $this->api_model->get_all_sales($dine_type);
        if (!empty($d)) {
            foreach ($d as $key => $row) {
                /*$d[$key]->product_thumb = asset_url() . 'uploads/thumbs/' . $d[$key]->product_thumb;
                $d[$key]->product_image = asset_url() . 'uploads/' . $d[$key]->product_image;
                $d[$key]->product_id    = $d[$key]->product_id + 0;
                $d[$key]->product_price = $d[$key]->product_price + 0;
                $d[$key]->cat_id        = $d[$key]->cat_id + 0;
                $d[$key]->sub_cat_id    = $d[$key]->sub_cat_id + 0;
                */
                
                $d[$key]->table_name = "Table ".$d[$key]->table_id;
                $d[$key]->sale_items = $this->api_model->get_sale_items_by_sale_id($row->sale_id);
            }
            echo json_encode(array(
                "status" => 1,
                "msg" => "Success",
                "sales" => $d
            ));
        } else {
            $jproduct = array();
            echo json_encode(array(
                "status" => 0,
                "msg" => "Failed. (Error code: ipasop403-i)",
                "sales" => $jproduct
            ));
        }
    }
    function check_juice(){
        $success = 0;
        $sale_id = 0;
        $cat_id             = $this->input->post('cat_id');
        $sale_data = $this->api_model->check_juices($cat_id);
        if(!empty($sale_data)){
            foreach ($sale_data as $key => $row) {
                $sale_data[$key]->sale_items = $this->api_model->get_sale_items_by_sale_id_n_cat($row->sale_id,$cat_id);
            }
            $success = 1;
        }
        echo json_encode(array(
            "status"=> $success,
            "sale_ids"=> $sale_data
        ));
    }
}