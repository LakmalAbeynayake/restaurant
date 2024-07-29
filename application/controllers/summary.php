<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
    //header('Access-Control-Allow-Origin: *');   
class Summary extends CI_Controller
{
    var $main_menu_name = "reports";
    var $sub_menu_name = "";
    private $main_model;
   
    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set("Asia/Colombo");
        $this->load->model('Common_Model');
        $this->load->model('summary_model');
        $this->load->model('warehouse_model');
    }
    
    /*View Methods*/
    public function daily_summary()
    {
        $data['main_menu_name']    = $this->main_menu_name;
        $data['sub_menu_name']     = 'rep_daily_summary';
        $data['warehouse_list']    = $this->warehouse_model->get_all_warehouse();
        $this->load->view('rep_daily_summary', $data);
    }
    /*Calculation Methods*/
    function getNextDate($inputDate) {
        // Create a DateTime object from the input date
        $currentDate = new DateTime($inputDate);

        // Add one day to the current date
        $nextDate = $currentDate->modify('+1 day');

        // Format the next date
        $formattedNextDate = $nextDate->format('Y-m-d');

        return $formattedNextDate;
    }
    function gen_summary(){
        if(!$this->session->userdata('ss_user_id')){
            echo json_encode(array(
                'status' => false,
                'msg' => 'Please login'
            ));
            return;
        }
        $date = $this->input->post('date');
        if(!$date){
            echo json_encode(array(
                'status' => false,
                'msg' => 'Date is required'
            ));
            return;
        }
        /* Loop through number of days*/
        $num_days = 1;
        for($i = 0; $i < $num_days; $i++ ){
            $ttl_value_of_return_to_suppliers = 0;
            $ttl_value_of_paybacks_from_suppliers = 0;
            
            $a = $this->summary_model->check_report_availability($date);
            if($a){
                $date = $this->getNextDate($date);
                continue;
            }
            
            $ttl_purchases_value = $this->summary_model->get_sum_of_purchases($date);
            $ttl_pymnts_for_purchases = $this->summary_model->get_sum_of_grn_payments($date);
            
            $ttl_cost_of_sales = 0;//$this->summary_model->get_sum_of_sales_cost($date);
            $ttl_sales  = 0;//$this->summary_model->get_sum_of_sales($date);
            
            /*MAP SALES TABLE*/
            $get_count = false;
            $sales_data_for_day = $this->summary_model->get_sales_data_for_summary_report($date, $this->session->userdata('ss_warehouse_id'), $get_count);
            
            // DT summary means, dine type summary
            $dt_summary = array(
                'di' => array(
                    'count' => 0,
                    'amount' => 0
                    ),
                'ta' => array(
                    'count' => 0,
                    'amount' => 0
                    ),
                'dl' => array(
                    'count' => 0,
                    'amount' => 0
                    )
            );
            // Loop through each sale record for a day and extract meaningful data
            foreach($sales_data_for_day as $row){
                // Calculating total cost of sale by collecting cost of each sale
                $ttl_cost_of_sales += $row->cost_total;

                // Calculating total amount of sale by collecting sale amount of each sale
                $ttl_sales += $row->sale_total;

                // Switching the dine type / order type and collect figures
                switch($row->dine_type){
                    case 1 : 
                        $dt_summary['di']['count'] += 1;
                        $dt_summary['di']['amount'] += $row->sale_total;
                        break;
                    case 2 : 
                        $dt_summary['ta']['count'] += 1;
                        $dt_summary['ta']['amount'] += $row->sale_total;
                        break;
                    case 3 : 
                        $dt_summary['dl']['count'] += 1;
                        $dt_summary['dl']['amount'] += $row->sale_total;
                        break;
                }
            }
            
            $ttl_payments_for_sales = $this->summary_model->get_sum_of_sale_payments($date);
            
            $ttl_value_of_customer_returns = $this->summary_model->get_sum_of_customer_returns($date);
            $ttl_value_of_pay_back_to_cus = 0;
            
            // In below array, we save extra sales figures which helps for other reports
            // You can put your own data structure below
            $extra_figures = array();
            
            // Collect Extra Sales related figures
            //  ++Payments
            $sale_cash = $this->summary_model->get_pymnt_summary($date,'sale','cash');
            $sale_credit_card = $this->summary_model->get_pymnt_summary($date,'sale','cc');
            $sale_cheque = $this->summary_model->get_pymnt_summary($date,'sale','cheque');
            
            // Map of sales data figure
            $sales_extra = array();
                // Methods of payments summary
                $mop = array(
                    "cash" => $sale_cash,
                    "cc" => $sale_credit_card,
                    "cheque" => $sale_cheque,
                );
                // Put MOP summary into the sales extra array
                $sales_extra['mop'] = $mop;
            
            // Order type summary / DT summary
                $sales_extra['dt'] = $dt_summary;
            
            /*At the end, push all the extra figures in to $extra_figures*/
            // --Loading $sales_extra into $extra_figures
            $extra_figures['sales_extra'] = $sales_extra;
            /*
                {
                    "sales" : {
                        "ot":{
                            "dine_in"   : "400",
                            "take_away" : "350",
                            "delivery"  : "600"
                        },
                        "mop":{
                            "cash"      : "400",
                            "cc"        : "350",
                            "cheque"    : "600"
                        }
                    }
                }
            */
            
            $data = array(
                'rep_for_date' => $date,
                'created_by' => $this->session->userdata('ss_user_id'),
                'ttl_purchases_value' => $ttl_purchases_value,
                'ttl_pymnts_for_purchases' => $ttl_pymnts_for_purchases,
                'ttl_value_of_return_to_suppliers' => $ttl_value_of_return_to_suppliers,
                'ttl_value_of_paybacks_from_suppliers' => $ttl_value_of_paybacks_from_suppliers,
                'ttl_cost_of_sales' => $ttl_cost_of_sales,
                'ttl_sales' => $ttl_sales,
                'ttl_payments_for_sales' => $ttl_payments_for_sales,
                'ttl_value_of_customer_returns' => $ttl_value_of_customer_returns,
                'ttl_value_of_pay_back_to_cus' => $ttl_value_of_pay_back_to_cus,
                'extra_figures' => json_encode($extra_figures)
            );
            // Call the model to save data
            $this->summary_model->saveData($data);
            
            $date = $this->getNextDate($date);
        }
        echo json_encode(array(
            'status' => true
        ));
        return;
        
    }

    /*MOP*/
    function gen_in_mop_summary(){
        if(!$this->session->userdata('ss_user_id')){
            echo json_encode(array(
                'status' => false,
                'msg' => 'Please login'
            ));
            return;
        }
        $date = $this->input->post('date');
        if(!$date){
            echo json_encode(array(
                'status' => false,
                'msg' => 'Date is required'
            ));
            return;
        }
        for($i = 0; $i < 60; $i++ ){
            $a = $this->summary_model->check_in_mop_report_availability($date);
            if($a){
                $date = $this->getNextDate($date);
                continue;
            }
            /*sale*/
            $sale_cash = $this->summary_model->get_pymnt_summary($date,'sale','cash');
            $sale_credit_card = $this->summary_model->get_pymnt_summary($date,'sale','cc');
            $sale_cheque = $this->summary_model->get_pymnt_summary($date,'sale','cheque');
            
            $data = array(
                'rep_for_date' => $date,
                'created_by' => $this->session->userdata('ss_user_id'),
                'paid_for' => 'sale',
                'cash' => $sale_cash,
                'credit_card' => $sale_credit_card,
                'cheque' => $sale_cheque
            );
            if($sale_cash || $sale_credit_card || $sale_cheque)
                $this->summary_model->saveMopSummaryData($data);
            
            $date = $this->getNextDate($date);
            
            /*Add more `paid_for` here...*/
        }
        
        echo json_encode(array(
            'status' => true
        ));
        return;
    }
    /*function get_daily_report(){
        $date = $this->input->post('date');
        if(!$date){
            echo json_encode(array(
                'status' => false,
                'msg' => 'Date is required'
            ));
            return;
        }
        $rep = $this->summary_model->get_report($date);
        header("Content-type:application/json");
        echo json_encode($rep);
    }*/
    function get_daily_report(){
        $date = $this->input->post('date');
        $date_to = $this->input->post('date_to');
        
        if(!$date){
            echo json_encode(array(
                'status' => false,
                'msg' => 'Date is required'
            ));
            return;
        }
        if(!$date_to){
            $rep = $this->summary_model->get_report($date);
            header("Content-type:application/json");
            echo json_encode($rep);
        }else{
            $data_list = $this->summary_model->get_report($date,$date_to);
            
            $sum_of_data = array(
                'rep_for_date' => $date,
                'rep_for_date_to' => $date_to,
                'created_on' => date("Y-m-d H:i A"),
                'created_by' => $this->session->userdata('ss_user_id'),
                'last_modified_on' => date("Y-m-d H:i A"),
                'ttl_purchases_value' => 0.00,
                'ttl_pymnts_for_purchases' => 0.00,
                'ttl_value_of_return_to_suppliers' => 0.00,
                'ttl_value_of_paybacks_from_suppliers' => 0.00,
                'ttl_sales' => 0.00,
                'ttl_sales_cancelled' => 0.00,
                'ttl_cost_of_sales' => 0.00,
                'ttl_payments_for_sales' => 0.00,
                'ttl_value_of_customer_returns' => 0.00,
                'ttl_value_of_pay_back_to_cus' => 0.00,
                'extra_figures' => array(
                    'sales_extra' => array(
                        'mop' => array(
                            'cash' => '0.00',
                            'cc' => '0.00',
                            'cheque' => 0
                        ),
                        'dt' => array(
                            'di' => array(
                                'count' => 0,
                                'amount' => 0
                            ),
                            'ta' => array(
                                'count' => 0,
                                'amount' => 0
                            ),
                            'dl' => array(
                                'count' => 0,
                                'amount' => 0
                            )
                        )
                    )
                )
            );
            foreach ($data_list as $row) {
                $sum_of_data['ttl_purchases_value'] += $row->ttl_purchases_value;
                $sum_of_data['ttl_pymnts_for_purchases'] += $row->ttl_pymnts_for_purchases;
                $sum_of_data['ttl_value_of_return_to_suppliers'] += $row->ttl_value_of_return_to_suppliers;
                $sum_of_data['ttl_value_of_paybacks_from_suppliers'] += $row->ttl_value_of_paybacks_from_suppliers;
                $sum_of_data['ttl_sales'] += $row->ttl_sales;
                $sum_of_data['ttl_sales_cancelled'] += $row->ttl_sales_cancelled;
                $sum_of_data['ttl_cost_of_sales'] += $row->ttl_cost_of_sales;
                $sum_of_data['ttl_payments_for_sales'] += $row->ttl_payments_for_sales;
                $sum_of_data['ttl_value_of_customer_returns'] += $row->ttl_value_of_customer_returns;
                $sum_of_data['ttl_value_of_pay_back_to_cus'] += $row->ttl_value_of_pay_back_to_cus;
            
                // Decode the JSON string and sum up the values
                $extra_figures = json_decode($row->extra_figures, true);
            
                $sum_of_data['extra_figures']['sales_extra']['mop']['cash'] += $extra_figures['sales_extra']['mop']['cash'];
                $sum_of_data['extra_figures']['sales_extra']['mop']['cc'] += $extra_figures['sales_extra']['mop']['cc'];
                $sum_of_data['extra_figures']['sales_extra']['mop']['cheque'] += $extra_figures['sales_extra']['mop']['cheque'];
                $sum_of_data['extra_figures']['sales_extra']['dt']['di']['count'] += $extra_figures['sales_extra']['dt']['di']['count'];
                $sum_of_data['extra_figures']['sales_extra']['dt']['di']['amount'] += $extra_figures['sales_extra']['dt']['di']['amount'];
                $sum_of_data['extra_figures']['sales_extra']['dt']['ta']['count'] += $extra_figures['sales_extra']['dt']['ta']['count'];
                $sum_of_data['extra_figures']['sales_extra']['dt']['ta']['amount'] += $extra_figures['sales_extra']['dt']['ta']['amount'];
                $sum_of_data['extra_figures']['sales_extra']['dt']['dl']['count'] += $extra_figures['sales_extra']['dt']['dl']['count'];
                $sum_of_data['extra_figures']['sales_extra']['dt']['dl']['amount'] += $extra_figures['sales_extra']['dt']['dl']['amount'];
            }

            // Format numbers to have 2 decimal places
            foreach ($sum_of_data as $key => $value) {
                if (is_numeric($value)) {
                    $sum_of_data[$key] = number_format($value, 2);
                }
            }

            // Encode 'extra_figures' as a JSON string
            $sum_of_data['extra_figures'] = json_encode($sum_of_data['extra_figures']);

            header("Content-type:application/json");
            echo json_encode($sum_of_data);
        }
    }
    /*Generate Daily Summary Report - simplified code*/
    function gen_daily_sales_gon_report(){
        //ini_set('memory_limit', '50M');

        if(!$this->session->userdata('ss_user_id')){
            echo json_encode(array(
                'status' => false,
                'msg' => 'Please login'
            ));
            return;
        }
        $date = date('Y-m-d', strtotime($this->input->post('date')));
        $update = $this->input->post('update');
        $location_id = $this->input->post('location_id') ? $this->input->post('location_id') : $this->session->userdata('ss_warehouse_id');
        $sc = $this->input->post('sc');

        if(!$date){
            echo json_encode(array(
                'status' => false,
                'msg' => 'Date is required'
            ));
            return;
        }
        if($update != 'true'){
            $rep_data = $this->summary_model->get_gon_data($date,false,$sc,$location_id);
            if(!empty($rep_data)){
                echo json_encode(array(
                    'status' => empty($rep_data) ? false : true,
                    'msg' => '',
                    'date' => $date,
                    'data' => $rep_data
                ));
                return;
            }
        }
        
        /*Mapping Products*/
        $products = $this->summary_model->get_all_products();
        $productsMapped = array();
        foreach($products as $itm){
            $productsMapped[$itm->product_id] = $itm;
        }
        
        /*Mapping Users*/
        $users = $this->summary_model->get_users();
        $usersMapped = array();
        foreach($users as $usr){
            $usersMapped[$usr->user_id] = $usr;
        }

        $rep = array();
        /* Loop through number of days*/
        $num_days = 1;
        for($i = 0; $i < $num_days; $i++ ){
            /*delete existing data*/
            $this->db->where('DATE(date)', $date);
            $this->db->delete('rep_daily_sales_list');
            /**/
            /*  
                --Get the list of sales for the day
                    --Loop through each sale record
                    --Get the sale items list for the record
                    
            */
            /*MAP SALES TABLE*/
            $get_count = false;
            $sales_data_for_day = $this->summary_model->get_sales_data_for_summary_report($date, $location_id, $get_count);
            
            
            /*Mapping Items*/
            $sale_items_for_day = $this->summary_model->get_sale_items_for_gon_report($date,$location_id);
            $mappedItems = array();
            foreach($sale_items_for_day as $itm){
                if(!isset($mappedItems[$itm->sale_id]))
                    $mappedItems[$itm->sale_id] = array();
                
                $mappedItems[$itm->sale_id][] = $itm;
            }
            
            $err = "";
            // Loop through each sale record for a day and extract meaningful data 
            if(!empty($sales_data_for_day))
            foreach($sales_data_for_day as $row){
                $item = array(
                    'code' => 0,
                    'name' => 0,
                    'qty' => 0,
                    'rate' => 0,
                    'amount' => 0
                );
                if(isset($mappedItems[$row->sale_id])){
                    foreach($mappedItems[$row->sale_id] as $key=>$rw){
                        if(isset($mappedItems[$row->sale_id][$key]) && isset($productsMapped[$rw->product_id])){
                            $mappedItems[$row->sale_id][$key]->code = $productsMapped[$rw->product_id]->product_code;
                            $mappedItems[$row->sale_id][$key]->name = $productsMapped[$rw->product_id]->product_name;
                        }
                    }
                    //sample
                    $sale_summary = array(
                        'date' => $date,
                        'invoice_no' => $row->sale_id,
                        'location_id' => $row->warehouse_id,
                        'order_type' => $row->dine_type,
                        'cashier_id' => $row->user,
                        'cashier_name' => $usersMapped[$row->user]->user_first_name,
                        'items' => json_encode($mappedItems[$row->sale_id]),
                        'amount' => $row->sale_total,
                        'sale_status' => $row->sale_status
                    );
                    $rep[] = $sale_summary;
                }else{
                    $err .= "$row->sale_id ,";
                    $sale_summary = array(
                        'date' => $date,
                        'invoice_no' => $row->sale_id,
                        'location_id' => $row->warehouse_id,
                        'order_type' => $row->dine_type,
                        'cashier_id' => $row->user,
                        'cashier_name' => $usersMapped[$row->user]->user_first_name,
                        'items' => json_encode(array()),
                        'amount' => $row->sale_total,
                        'sale_status' => $row->sale_status
                    );
                    $rep[] = $sale_summary;
                }
                
            }
            //echo $err;
            $date = $this->getNextDate($date);
        }
        
        // Perform bulk insertion
        if(!empty($rep))
        $this->db->insert_batch('rep_daily_sales_list', $rep);
        
        $tr = array();
        
        foreach($rep as $key=>$r){
            if($sc === 'true')
            {
                if($r['sale_status'] == 99){
                    $tr[] = $r;
                }
            }else{
                if($r['sale_status'] != 99)
                    $tr[] = $r;
            }
        }

        // Optionally, check if the insertion was successful
        if ($this->db->affected_rows() > 0) {
            echo json_encode(array(
                'status' => true,
                'msg' => 'Successful',
                'data' => $tr
            ));
        } else {
            echo json_encode(array(
                'status' => false,
                'msg' => 'No data',
                'data' => array()
            ));
        }
    }
    function daily_stock(){
        $this->load->model('products_model');
        $data['main_menu_name']    = $this->main_menu_name;
        $data['sub_menu_name']     = 'rep_daily_stock';
        $data['warehouse_list']    = $this->warehouse_model->get_all_warehouse();
        $data['types']          = $this->products_model->get_types();
        $this->load->view('rep_daily_stock', $data);
    }
    function get_daily_stock(){
        $this->load->model('stock_model');
        $date = $this->input->post('date');
        $location_id = $this->input->post('location_id');
        /*echo $location_id;exit;*/
        //$location_id = $this->session->userdata('ss_warehouse_id');
        $update = $this->input->post('update') == 'true' ? true : false;
        if(!$date){
            http_response_code(400);
        }
        
        /*Check if data is available*/
        $this->db->select('COUNT(id) as count');
        $this->db->from('rep_daily_stock_summary');
        $this->db->where('date(date)', $date);
        $this->db->where('location_id', $location_id);
        $query = $this->db->get();
        $rep_data_count = $query->row()->count;
        
        // if data is there and not requesting for an update
        if($rep_data_count && !$update){
            $this->db->select('*');
            $this->db->from('rep_daily_stock_summary');
            $this->db->where('location_id', $location_id);
            $this->db->where('date(date)', $date);
            $query = $this->db->get();
            $rep_data = $query->result();
            
            header('content-type:application/json');
            echo json_encode($rep_data);
            exit;
        }
        
        if($rep_data_count){
            // delete existing data for the date - not recommended. Implement a proper 'updating algorithm'
            $this->db->where('date(date)', $date);
            $this->db->where('location_id', $location_id);
            $this->db->delete('rep_daily_stock_summary');
        }

        /*products_model.php*/
        $this->db->select('product_id,product_name,product_code,product_cost,product_type_id');
        $this->db->order_by("product_code", "asc");
        $query = $this->db->get('product');
        $products_raw = $query->result();
        $products = array();
        foreach($products_raw as $row){
            $products[$row->product_id] = $row;
        }

        /*get closing balances*/
        $lastRecordedDate = $this->stock_model->getLastRecordedDate("",$date,$location_id);
        $this->db->select('product_id,closing_balance');
        $this->db->where('date', $lastRecordedDate);
        $this->db->where('location_id', $location_id);
        $query_raw = $this->db->get('rep_daily_stock_summary');
        $closing_Balances_raw = $query_raw->result();
        $closing_Balances = array();
        foreach($closing_Balances_raw as $raw)
            $closing_Balances[$raw->product_id] = $raw;
        
        /*get stock movements for the date*/
        $stock_balance = array();
        $where = array(
            'date(movement_date)' => $date,
            'location_id' => $location_id
        );
        $stock_movements = $this->summary_model->get_stock_movements($where);
        /*echo $this->db->last_query();
        exit;*/
        /*echo json_encode($stock_movements);
        exit;*/
        $mapped_movements_by_product_id = array();
        foreach ($stock_movements as $movement){
            if(!isset($mapped_movements_by_product_id[$movement->product_id])){
                $mapped_movements_by_product_id[$movement->product_id] = array();
            }
            $mapped_movements_by_product_id[$movement->product_id][] = $movement;
        }

        foreach($products as $prd){
            $product_id = $prd->product_id;
            if (!isset($stock_balance[$product_id])) {
                $closing_Balance = isset($closing_Balances[$product_id]) ? $closing_Balances[$product_id]->closing_balance : 0;
                $stock_balance[$product_id] = array(
                    'date'          => $date,
                    'product_id'    => $product_id,
                    'product_type'    => $prd->product_type_id,
                    'location_id'    => $location_id,
                    'product_name'  =>  "[".$prd->product_code."] ".$prd->product_name,
                    'opening_balance'   => floatVal($closing_Balance),
                    'opening_balance_amount' => floatVal($closing_Balance) * floatVal($prd->product_cost),
                    'grn_quantity'      => 0,
                    'gtn_quantity'      => 0,
                    'sale_quantity'     => 0,
                    'consume_quantity'  => 0,
                    'return_quantity'   => 0,
                    'damadge_quantity'  => 0,
                    'adjusted_quantity' => 0,
                    'staff_meal' => 0,
                    'closing_balance'   => floatVal($closing_Balance),
                    'grn_amount' => 0,
                    'gtn_amount' => 0,
                    'sale_amount' => 0,
                    'consume_amount' => 0,
                    'return_amount' => 0,
                    'damadge_amount' => 0,
                    'adjusted_amount' => 0,
                    'staff_meal_amount' => 0,
                    'closing_balance_amount' => floatVal($closing_Balance) * floatVal($prd->product_cost),
                );
            }
            $movements = array();
            if(isset($mapped_movements_by_product_id[$prd->product_id]))
                $movements = $mapped_movements_by_product_id[$prd->product_id];

            if(!empty($movements))
                foreach ($movements as $movement) {
                    // Calculate amount for each movement
                    $amount = $movement->unit_value * $movement->quantity;
                    // Update quantities and amounts based on movement type and origin
                    if ($movement->movement_type == 'in') {
                        $stock_balance[$product_id]['closing_balance'] += $movement->quantity;
                        $stock_balance[$product_id]['closing_balance_amount'] += $amount;
                    } else {
                        $stock_balance[$product_id]['closing_balance'] -= $movement->quantity;
                        $stock_balance[$product_id]['closing_balance_amount'] -= $amount;
                    }
                    if ($movement->origin == 'grn') {
                        $stock_balance[$product_id]['grn_quantity'] += $movement->quantity;
                        $stock_balance[$product_id]['grn_amount'] += $amount;
                    } elseif ($movement->origin == 'gtn') {
                        $stock_balance[$product_id]['gtn_quantity'] += $movement->quantity;
                        $stock_balance[$product_id]['gtn_amount'] += $amount;
                    } elseif ($movement->origin == 'sale') {
                        $stock_balance[$product_id]['sale_quantity'] += $movement->quantity;
                        $stock_balance[$product_id]['sale_amount'] += $amount;
                    } elseif ($movement->origin == 'sale_cancel') {
                        $stock_balance[$product_id]['return_quantity'] += $movement->quantity;
                        $stock_balance[$product_id]['return_amount'] += $amount;
                    } elseif ($movement->origin == 'damage') {
                        $stock_balance[$product_id]['damadge_quantity'] += $movement->quantity;
                        $stock_balance[$product_id]['damadge_amount'] += $amount;
                    } elseif ($movement->origin == 'staff_meal') {
                        $stock_balance[$product_id]['staff_meal'] += $movement->quantity;
                        $stock_balance[$product_id]['staff_meal_amount'] += $amount;
                    } elseif ($movement->origin == 'san') {
                        $stock_balance[$product_id]['adjusted_quantity'] += $movement->quantity;
                        $stock_balance[$product_id]['adjusted_amount'] += $amount;
                    } elseif ($movement->origin == 'consume') {
                        $stock_balance[$product_id]['consume_quantity'] += $movement->quantity;
                        $stock_balance[$product_id]['consume_amount'] += $amount;
                    } elseif ($movement->origin == 'unconsume') {
                        $stock_balance[$product_id]['consume_quantity'] -= $movement->quantity;
                        $stock_balance[$product_id]['consume_amount'] -= $amount;
                    }
                }

                /*foreach ($movements as $movement) {
                    // Update quantities based on movement type and origin
                    if ($movement->movement_type == 'in'){
                        $stock_balance[$product_id]['closing_balance'] += $movement->quantity;
                    }else{
                        $stock_balance[$product_id]['closing_balance'] -= $movement->quantity;
                    }
                    if ($movement->origin == 'grn') {
                        $stock_balance[$product_id]['grn_quantity']     += $movement->quantity;
                    } elseif ($movement->origin == 'gtn') {
                        $stock_balance[$product_id]['gtn_quantity']     += $movement->quantity;
                    } elseif ($movement->origin == 'sale') {
                        $stock_balance[$product_id]['sale_quantity']    += $movement->quantity;
                    } elseif ($movement->origin == 'sale_cancel') {
                        $stock_balance[$product_id]['return_quantity']  += $movement->quantity;
                    } elseif ($movement->origin == 'damage') {
                        $stock_balance[$product_id]['damadge_quantity'] += $movement->quantity;
                    } elseif ($movement->origin == 'san') {
                        $stock_balance[$product_id]['adjusted_quantity']+= $movement->quantity;
                    } elseif ($movement->origin == 'consume') {
                        $stock_balance[$product_id]['consume_quantity'] += $movement->quantity;
                    } elseif ($movement->origin == 'unconsume') {
                        $stock_balance[$product_id]['consume_quantity'] -= $movement->quantity; 
                    }
                }*/
        }
        $DB_DATA = array();
        foreach($stock_balance as $row)
            $DB_DATA[]  = $row;
        
        /*Insert data*/
        $this->db->insert_batch('rep_daily_stock_summary',$DB_DATA);

        header('content-type:application/json');
        echo json_encode($DB_DATA);
        
    }
    function generate_closing_stock(){
        $date = $this->inpit->post('date');
        if(!$date){
            http_response_code(400);
        }
        $this->summary_model->get_moved_products_by_date($date);
        
    }
    /*public function fillDailyStockSummaries($date) {
        $this->load->model('stock_model');
        // Retrieve data from stock_movements
        $stockMovements = $this->stock_model->calculateDailyStockSummaries($date);

        // Insert data into rep_daily_stock_summary table
        foreach ($stockMovements as $movement) {
            // Calculate opening balance
            $openingBalance = $this->calculateOpeningBalance($movement['product_id'], $date);

            // Calculate closing balance
            $closingBalance = $openingBalance + $movement['grn_quantity'] - $movement['sale_quantity'];

            // Prepare data for insertion
            $data = array(
                'date' => $date,
                'product_id' => $movement['product_id'],
                'opening_balance' => $openingBalance,
                'grn_quantity' => $movement['grn_quantity'],
                'sale_quantity' => $movement['sale_quantity'],
                'closing_balance' => $closingBalance
            );

            // Insert into rep_daily_stock_summary table
            $this->db->insert('rep_daily_stock_summary', $data);
        }

        echo "Daily stock summaries filled for date: $date";
    }*/
    /*private function calculateOpeningBalance($product_id, $date) {
        // Convert the date to MySQL date format (YYYY-MM-DD)
        $dateFormatted = date('Y-m-d', strtotime($date));
        $lastRecordedDate = $this->stock_model->getLastRecordedDate($product_id);

        // Query to calculate opening balance
        $this->db->select('SUM(IF(movement_type = "in", quantity, 0)) AS total_in, SUM(IF(movement_type = "out", quantity, 0)) AS total_out');
        $this->db->from('stock_movements');
        $this->db->where('product_id', $product_id);
        if($lastRecordedDate){
            $this->db->where('DATE(movement_date) >= '.$lastRecordedDate);
            $this->db->where('DATE(movement_date) < '.$dateFormatted);
        }
        else
            $this->db->where('DATE(movement_date) <', $dateFormatted);
        $query = $this->db->get();
        $result = $query->row_array();
    
        // Calculate opening balance
        $openingBalance = $result['total_in'] - $result['total_out'];
    
        return $openingBalance;
    }*/
    /*depricated*/
    /*function get_daily_stock_d(){
        $date = $this->input->post('date');
        $where = array(
            'date(movement_date)' => $date
        );
        $stockMovements = $this->summary_model->get_stock_movements($where);
        
        // calculation
        $stockBalance = array();
        // Group movements by product ID
        foreach ($stockMovements as $movement) {
            $productId = $movement->product_id;
            if (!isset($stockBalance[$productId])) {
                $stockBalance[$productId] = array(
                    'product_id' => $productId,
                    'product_name' => '', // Leave blank for now
                    'opening_balance' => 0, // To be calculated
                    'grn' => 0,
                    'sale' => 0,
                    'stock_balance' => 0 // To be calculated
                );
            }
            
            // Update quantities based on movement type and origin
            if ($movement->movement_type == 'in' && $movement->origin == 'grn') {
                $stockBalance[$productId]['grn'] += $movement->quantity;
            } elseif ($movement->movement_type == 'out' && $movement->origin == 'sale') {
                $stockBalance[$productId]['sale'] += $movement->quantity;
            }
        }

        // Calculate opening balance and stock balance
        foreach ($stockBalance as &$product) {
            $product['opening_balance'] = $product['grn'] - $product['sale'];
            $product['stock_balance'] = $product['opening_balance'];
        }
        
        // end calculation
        header('content-type:application/json');
        echo json_encode($stockBalance);
    }*/
    
    /*View Methods*/
    public function daily_item_sale()
    {
        $this->load->model('products_model');
        $data['main_menu_name']    = $this->main_menu_name;
        $data['sub_menu_name']     = 'daily_item_sale';
        $data['warehouse_list']    = $this->warehouse_model->get_all_warehouse();
        $data['types']          = $this->products_model->get_types();
        $this->load->view('rep_daily_item_sale', $data);
    }
    
    function get_daily_item_sale(){
        /*$this->load->model('stock_model');*/
        $date = $this->input->post('date');
        $location_id = $this->input->post('location_id');
        
        //$location_id = $this->session->userdata('ss_warehouse_id');
        $update = $this->input->post('update') == 'true' ? true : false;
        if(!$date){
            http_response_code(400);
        }
        
        /*Check if data is available*/
        $this->db->select('COUNT(id) as count');
        $this->db->from('rep_daily_item_sale_summary');
        $this->db->where('date(date)', $date);
        $this->db->where('location_id', $location_id);
        $query = $this->db->get();
        $rep_data_count = $query->row()->count;
        
        // if data is there and not requesting for an update
        if($rep_data_count && !$update){
            $this->db->select('*');
            $this->db->from('rep_daily_item_sale_summary');
            $this->db->where('date(date)', $date);
            $query = $this->db->get();
            $rep_data = $query->result();
            
            header('content-type:application/json');
            echo json_encode($rep_data);
            exit;
        }
        
        if($rep_data_count){
            // delete existing data for the date - not recommended. Implement a proper 'updating algorithm'
            $this->db->where('date(date)', $date);
            $this->db->delete('rep_daily_item_sale_summary');
        }

        /*products_model.php*/
        $this->db->select('product_id,product_cost,product_price,product_type_id');
        $query = $this->db->get('product');
        $products_raw = $query->result();
        $products = array();
        foreach($products_raw as $row){
            $products[$row->product_id] = $row;
        }
        
        /*sold items*/
        $this->db->select('product_id,product_name,unit_price,quantity');
        $query = $this->db->get('sale_items');
        $sale_items_raw = $query->result();
        $sale_items = array();
        foreach($sale_items_raw as $row){
            if(!isset($sale_items[$row->product_id])){
                $sale_items[$row->product_id] = array();
                $sale_items[$row->product_id] = array(
                    'date'          => $date,
                    'product_id'    => $row->product_id,
                    'product_type'    => $products[$row->product_id]->product_type_id,
                    'location_id'    => $location_id,
                    'product_name'  => $row->product_name,
                    'sale_quantity'     => 0,
                    'return_quantity'   => 0,
                    'unit_price'  => 0,
                    'balance_quantity' => 0,
                    'sub_total'   => 0
                );
            }
            $sale_items[$row->product_id]['sale_quantity']      += $row->quantity;
            $sale_items[$row->product_id]['unit_price']         += $row->unit_price;
            $sale_items[$row->product_id]['balance_quantity']   += $row->quantity;
            $sale_items[$row->product_id]['sub_total']          += ($row->unit_price * $row->quantity);
        }
        
        
        $DB_DATA = array();
        foreach($sale_items as $row)
            $DB_DATA[]  = $row;
        
        /*Insert data*/
        $this->db->insert_batch('rep_daily_item_sale_summary',$DB_DATA);

        header('content-type:application/json');
        echo json_encode($DB_DATA);
    }
    
    function fix(){
        
        $date = '2024-03-21 16:41:06';
        echo $date;
        $this->load->model('stock_model');
        
        $uuid = 'e8be124d-9928-4bc8-8d2b-236d64c78d51';
        
        $this->db->select('sales.sale_id,sales.warehouse_id,sale_items.product_id,sale_items.quantity,sale_items.unit_price,sales.sale_datetime');
        $this->db->from('sale_items');
        $this->db->join('sales','sales.sale_id = sale_items.sale_id','left');
        $this->db->where('sales.sale_datetime > ','2024-03-21 00:01:00');
        $this->db->where('sales.sale_datetime < ',$date);
        //$this->db->where('sales.sale_status !=','99');
        $query = $this->db->get();
        
        echo $this->db->last_query();
        
        $sale_items = $query->result();
        $movements_list = array();
        foreach($sale_items as $item){
            $data = array(
                'location_id' => $item->warehouse_id,
                'transaction_id' => $uuid,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'unit_value' => $item->unit_price,
                'movement_type' => 'out',
                'movement_date' => $item->sale_datetime,
                'origin' => 'sale',
                'origin_id' => $item->sale_id
            );
            $movements_list[] = $data;
        }
        echo "<pre>";
        print_r($movements_list);
        $this->stock_model->bulkInsertMovements($movements_list);
    }
    
    function get_rti_stock($product_id = 0, $location_id = 1){
        $this->load->model('stock_model');
        
        $product_id = $product_id ? $product_id : $this->input->post('product_id');
        $location_id = $location_id ? $location_id : $this->session->userdata('ss_warehouse_id');
        
        /*get closing balances*/
        $lastRecordedDate = $this->stock_model->getLastRecordedDate("",date("Y-m-d"),$location_id);
        $this->db->select('product_id,opening_balance');
        $this->db->where('date', $lastRecordedDate);
        $this->db->where('product_id', $product_id);
        $this->db->where('location_id', $location_id);
        $query_raw = $this->db->get('rep_daily_stock_summary');
        $opening_balance = $query_raw->row()->opening_balance;
        
        /*today calculation*/
        /*$this->db->select('SUM(IF(movement_type = "in", quantity, 0)) AS total_in, SUM(IF(movement_type = "out", quantity, 0)) AS total_out');
        $this->db->from('stock_movements');
        $this->db->where('product_id', $product_id);
        $this->db->where('DATE(movement_date)',date("Y-m-d"));*/
        
        $query = $this->db->query('SELECT SUM(IF(movement_type = "in", quantity, 0)) AS total_in, SUM(IF(movement_type = "out", `quantity`, 0)) AS total_out FROM (`stock_movements`) WHERE 
                                    `product_id` = "'.$product_id.'" AND DATE(movement_date) = "'.date("Y-m-d").'"');
        //$query = $this->db->get();
        $result = $query->row();
        
        //echo $this->db->last_query();
        
        $total_in = $result->total_in;
        $total_out = $result->total_out;
        $balance = $total_in + $opening_balance - $total_out;
        
        echo json_encode(array('balance' => $balance));
    }
}