<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Stock_Adjesment extends CI_Controller
{
    var $main_menu_name = "adjustments";
    var $sub_menu_name = "stock_adjesment";
    function __construct()
    {
        parent::__construct();
        //error_reporting(E_ALL);
        //ini_set('display_errors', 1);
        $this->load->model('summary_model');
        $this->load->model('purchases_model');
        $this->load->model('Common_Model');
        /*$this->load->model('Sequerty_Model');*/
        $this->load->library('form_validation');
        $this->load->model('User_Model');
        $this->load->model('Ingredient_Stock_Adj_Model');
    }
    public function index($e = 0)
    {
        $data['error']          = $e;
        $data['main_menu_name'] = $this->main_menu_name;
        $data['sub_menu_name']  = "list";
        $data['warehouse']      = $this->purchases_model->get_warehouse();
        $this->load->view('adjustments/list', $data);
    } 
    
    public function add()
    {
        $this->load->model('products_model');
        $data['main_menu_name'] = $this->main_menu_name;
        $data['sub_menu_name']  = 'add';
        $data['types']          = $this->products_model->get_types();
        $data['warehouse']      = $this->purchases_model->get_warehouse();
        $this->load->view('adjustments/add', $data);
    }

    function save_adjustment(){

        $location_id = $this->input->post('location_id');
        $uuid = $this->input->post('uuid');
        $data = $this->input->post('data');
        $adj_date = $this->input->post('adj_date');
        
        if(!$location_id){
            echo "Location ID required";
            exit;
        }
        
        if(!$uuid){
            echo "UUID ID required";
            exit;
        }
        if(!$adj_date){
            echo "Date is required";
            exit;
        }
        
        $adj_date = date("Y-m-d H:i:s", strtotime($adj_date));
        $user = $this->session->userdata('ss_user_id');
        
        if(!empty($data)){
            $this->db->trans_start();
            
            $adj_ref_no = '';
            
            $this->db->select('count(adj_id) as count');
            $this->db->from('stock_adjustments');
            $this->db->where('location_id', $location_id);
            $query = $this->db->get();
            $count_result = $query->num_rows();
            
            if ($count_result > 0) {
                // If there are rows returned
                $r = $query->row()->count;
                // Adding padding with 5 zeros
                $adj_ref_no = "ADJ$location_id" . str_pad(($r + 1), 5, '0', STR_PAD_LEFT);
            } else {
                // If no rows are returned, set the count to 0
                $adj_ref_no = "ADJ$location_id" . str_pad(1, 5, '0', STR_PAD_LEFT);
            }

            $adj = array(
                'transaction_id' => $uuid,
                'adj_ref_no'    => $adj_ref_no,
                'date_time' => $adj_date,
                'location_id'   => $location_id,
                'user_id'   => $user,
            );

            $this->db->insert('stock_adjustments',$adj);
            $adj_id = $this->db->insert_id();
            $adj_items = array();
            
            $acc = 0;

            foreach($data as $row){
                $r = array(
                    'adj_id' => $adj_id,
                    'product_id' => $row['pid'],
                    'physical_count' => $row['phy'],
                    'system_count' => $row['qty'],
                    'adjustment' => $row['adj'],
                    'user_id' => $user,
                    'transaction_id' => $uuid
                );
                $adj_items[] = $r;
                
                /*if($row['adj'] != 0)
                    $acc ++;*/
                
                $this->db->insert('stock_adjustments_items',$r);
            }
            
            // $this->db->insert_batch('stock_adjustments_items',$adj_items);
            // $lq = $this->db->last_query();
            // $af = $affected_rows = $this->db->affected_rows();
            $af = 1;
            if($af != 1){
                echo json_encode(array(
                    'success' => false,
                    'af' => 1,
                    'dc' => 1,
                    // 'ai' => $adj_items,
                    // 'ajc' => $acc,
                    // 'lq' => $lq
                ));
                exit;
            }
            
            $this->db->trans_complete();
            if ($this->db->trans_status() === FALSE)
            {
                $this->Common_Model->add_user_activitie("Stock adjustment - attempt failed");
                echo json_encode(array(
                    'success' => false,
                    'af' => 1,
                    'dc' => 1
                ));
            }else{
                $this->Common_Model->add_user_activitie("Stock adjustment - added");
                echo json_encode(array(
                    'success' => true,
                    'last_id' => $adj_id,
                    'af' => 1,
                    'dc' => 1
                ));
            }
        }
    }
    
    function get_daily_stock(){
        $this->load->model('stock_model');
        $date = $this->input->post('date');
        $location_id = $this->input->post('location_id') ? $this->input->post('location_id') : $this->session->userdata('ss_warehouse_id');
        
        if(!$location_id){
            echo "Location ID is Required!";
            return false;
        }
        
        if(!$date){
            echo "Date is Required!";
            return false;
        }else
            $date = date("Y-m-d", strtotime($date));

        /*
        $rep_data_count = $this->check_data_availability($date);
        
        if($rep_data_count && !$update){
            $rep_data = $this->get_existing_data($date);
            $this->output_json_response($rep_data);
        }
        
        if($rep_data_count){
            $this->delete_existing_data($date);
        }
        */

        $products = $this->get_products();
        $closing_Balances = $this->get_closing_balances($date,$location_id);
        $stock_balance = $this->calculate_stock_balance($products, $closing_Balances, $date,$location_id);
        $this->output_json_response($stock_balance);
    }
    
    function check_data_availability($date) {
        $this->db->select('COUNT(id) as count');
        $this->db->from('rep_daily_stock_summary');
        $this->db->where('date(date)', $date);
        $query = $this->db->get();
        return $query->row()->count;
    }
    
    function get_existing_data($date) {
        $this->db->select('*');
        $this->db->from('rep_daily_stock_summary');
        $this->db->where('date(date)', $date);
        $query = $this->db->get();
        return $query->result();
    }
    
    function delete_existing_data($date) {
        $this->db->where('date(date)', $date);
        $this->db->delete('rep_daily_stock_summary');
    }
    
    function get_products() {
        $this->db->select('product_id,product_name,product_code,product_cost,product_type_id');
        $query = $this->db->get('product');
        $products_raw = $query->result();
        $products = array();
        foreach($products_raw as $row){
            $products[$row->product_id] = $row;
        }
        return $products;
    }
    
    function get_closing_balances($date,$location_id) {
        $lastRecordedDate = $this->stock_model->getLastRecordedDate("", $date,$location_id);
        $this->db->select('product_id,closing_balance');
        $this->db->where('date', $lastRecordedDate);
        $this->db->where('location_id', $location_id);
        $query_raw = $this->db->get('rep_daily_stock_summary');
        $closing_Balances_raw = $query_raw->result();
        $closing_Balances = array();
        foreach($closing_Balances_raw as $raw)
            $closing_Balances[$raw->product_id] = $raw;
        return $closing_Balances;
    }
    
    function calculate_stock_balance($products, $closing_Balances, $date, $location_id) {
        $stock_balance = array();
        $stock_movements = $this->summary_model->get_stock_movements(array(
            'date(movement_date)' => $date,
            'location_id' => $location_id,
        ));
    
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
                    'product_name'  => "[".$prd->product_code."] ".$prd->product_name,
                    'opening_balance'   => floatVal($closing_Balance),
                    'grn_quantity'      => 0,
                    'gtn_quantity'      => 0,
                    'sale_quantity'     => 0,
                    'return_quantity'   => 0,
                    'damadge_quantity'  => 0,
                    'adjusted_quantity' => 0,
                    'consumption_quantity' => 0,
                    'closing_balance'   => floatVal($closing_Balance)
                );
            }
    
            $movements = array();
            if(isset($mapped_movements_by_product_id[$prd->product_id]))
                $movements = $mapped_movements_by_product_id[$prd->product_id];
    
            if(!empty($movements))
                foreach ($movements as $movement) {
                    // Update quantities based on movement type and origin
                    if ($movement->movement_type == 'in'){
                        $stock_balance[$product_id]['closing_balance'] += $movement->quantity;
                    }else{
                        $stock_balance[$product_id]['closing_balance'] -= $movement->quantity;
                    }
                    /*if ($movement->origin == 'grn') {
                        $stock_balance[$product_id]['grn_quantity']     += $movement->quantity;
                    } elseif ($movement->origin == 'gtn') {
                        $stock_balance[$product_id]['gtn_quantity']     += $movement->quantity;
                    } elseif ($movement->origin == 'sale') {
                        $stock_balance[$product_id]['sale_quantity']    += $movement->quantity;
                    } elseif ($movement->origin == 'return') {
                        $stock_balance[$product_id]['return_quantity']  += $movement->quantity;
                    } elseif ($movement->origin == 'damadge') {
                        $stock_balance[$product_id]['damadge_quantity'] += $movement->quantity;
                    } elseif ($movement->origin == 'adjusted') {
                        $stock_balance[$product_id]['adjusted_quantity']+= $movement->quantity;
                    } elseif ($movement->origin == 'consume') {
                        $stock_balance[$product_id]['consumption_quantity']+= $movement->quantity;
                    }*/
                }
        }
        return $stock_balance;
    }
    
    function insert_data($DB_DATA) {
        $this->db->insert_batch('rep_daily_stock_summary', $DB_DATA);
    }
    
    function output_json_response($data) {
        header('content-type:application/json');
        echo json_encode($data);
    }
    
    public function get_list($value = '')
    {
        $location_id = $this->input->post('location_id');
        
        $this->db->select('stock_adjustments.*,user.user_first_name');
        $this->db->from('stock_adjustments');
        $this->db->join('user','user.user_id = stock_adjustments.user_id','left');
        $this->db->where('location_id',$location_id);
        $query = $this->db->get();
        
        $result = $query->result();
        
        $data   = array();
        if (!empty($result)) {
            foreach ($result as $raw) {
                $pay_st;
                if ($raw->approval_status == 0) {
                    $pay_st = '<span class="label label-warning">Pending</span>';
                } else {
                    $pay_st = '<span class="label label-success">Approved</span>';
                }
                
                $row    = array();
                $row[]  = $raw->created_on;
                $row[]  = $raw->date_time;
                $row[]  = $raw->adj_ref_no;
                $row[]  = $raw->user_first_name;
                $row[]  = $pay_st;
                $row[]  =   '<div class="text-center">
                                <div class="btn-group text-left">
                                    <button data-toggle="dropdown" class="btn btn-default btn-xs btn-primary dropdown-toggle" type="button">Actions <span class="caret"></span></button>
                                    <ul role="menu" class="dropdown-menu pull-right">
                                        <li><a href="' . base_url('adjustments/view/' . $raw->adj_id) . '"><i class="fa fa-file-text-o"></i> Details </a></li>
                                    </ul>
                                </div>
                            </div>';
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
    
   
     public function view($adj_id)
    {
        $data['main_menu_name'] = $this->main_menu_name;
        $data['sub_menu_name']  = "view_ingredient";
        $data['po_header']      = $this->get_stock_adjustment_info($adj_id);
        $data['po_middle']      = $this->get_stock_adjustment_items($adj_id);
        $data['adj_id']     = $adj_id;
        $this->load->view('adjustments/details', $data);
    }
    
    function get_stock_adjustment_info($adj_id){
        $this->db->select('*');
        $this->db->from('stock_adjustments');
        $this->db->where('adj_id',$adj_id);
        $this->db->join('locations','locations.id = stock_adjustments.location_id','left');
        $query = $this->db->get();
        return $query->row();
    }

    function get_stock_adjustment_items($adj_id){
        $this->db->select('stock_adjustments_items.*,product_name,product_code');
        $this->db->from('stock_adjustments_items');
        $this->db->join('product','product.product_id = stock_adjustments_items.product_id','left');
        $this->db->where('adj_id',$adj_id);
        $query = $this->db->get();
        return $query->result();
    }
    function get_product_list(){
        $this->db->select('product_id,product_code,product_cost');
        $this->db->from('product');
        $query = $this->db->get();
        return $query->result();
    }
    /*Approve and generate SAN*/
    function approve_adjustment(){
        //$this->load->model('san_model');
        $this->load->model('stock_model');
        /*Check permission*/
        
        /*End Check permission*/
        
        
        $adj_id = $this->input->post('adj_id');
        
        $product_list       = $this->get_product_list();
        $pl_mapped = array();
        foreach($product_list as $pd){
            $pl_mapped[$pd->product_id] = $pd;
        }
        
        
        $uuid = $this->input->post('uuid');
        if(!$adj_id > 0 || !$this->session->userdata('ss_user_id') || !$uuid){
            http_response_code(400);
            return;
        }

        // if not approved yet (go to model function to get a better idea for the return value)
        if($this->is_approved($adj_id)){
            $this->db->trans_start();

            $adjustment_info = $this->get_stock_adjustment_info($adj_id);

            /*create origin entry - san*/
            $ori_data = array(
                'location_id'    => $adjustment_info->location_id, 
                'san_ref_no'     => $adj_id,
                'adj_id'     => $adj_id,
                'date_time'     => $adjustment_info->date_time,
                'uuid'          => $uuid,
                'added_by'   => $this->session->userdata('ss_user_id')
            );
            
            $this->db->insert('san',$ori_data);
            $san_id = $this->db->insert_id();
            $san_item_data = array();
            
            if(!$san_id){
                http_response_code(403);
                return;
            }
            

            /*end create origin entry*/
            $adjustment_items = $this->get_adjustment_items($adj_id);
            
            // Stock Movement Records
            // arry for
            $movements_list = array();
            foreach($adjustment_items as $item){
                $data = array(
                    'location_id' => $adjustment_info->location_id,
                    'transaction_id' => $uuid,
                    'product_id' => $item->product_id,
                    'quantity' => $item->adjustment,
                    'unit_value' => $pl_mapped[$item->product_id]->product_cost,
                    'movement_type' => 'in',
                    'movement_date' => $adjustment_info->date_time,
                    'origin' => 'san',
                    'origin_id' => $san_id
                );
                $movements_list[] = $data;
                
                $itm_data = array(
                    'san_id'    => $san_id,
                    'transaction_id' => $uuid,
                    'product_id' => $item->product_id,
                    'physical_count' => $item->physical_count,
                    'system_count' => $item->system_count,
                    'adjustment' => $item->adjustment,
                );
                $san_item_data[] = $itm_data;
            }
            
            $rec = $this->save_san_items($san_item_data);
            if(!$rec){
                http_response_code(500);
                return;
            }

            $track_data = array( 'trans_id' => $uuid,'location_id' => $adjustment_info->location_id,'date_time' => $adjustment_info->date_time,'added_by' => $this->session->userdata('ss_user_id'));
            $this->stock_model->stock_m_tracker($track_data);
            $this->stock_model->bulkInsertMovements($movements_list);
            $this->approve($adj_id);
            $this->db->trans_complete();
            if ($this->db->trans_status() === FALSE){
                $this->Common_Model->add_user_activitie("Adjustment Approval - attempt failed");
                http_response_code(500);
                exit;
            }
            $this->Common_Model->add_user_activitie("Adjustment Approval - #$adj_id");
            http_response_code(200);
            exit;
        }
        http_response_code(403);
        // Call the addMovement method from the model 
        // $log_id = $this->Stock_model->addMovement($data);
    }
    function get_adjustment_items($adj_id){
        $this->db->select('*');
        $this->db->from('stock_adjustments_items');
        $this->db->where('adj_id', $adj_id);
        $query = $this->db->get();
        return $query->result();
    }
    
    function save_san_items($items){
        $this->db->insert_batch('san_items',$items);
        return $this->db->affected_rows();
    }
    function approve($adj_id){
        $data = array(
            'approved_by' => $this->session->userdata('ss_user_id'),
            'approved_on' => date('Y-m-d H:i:s'),
            'approval_status' => 1
        );
        $this->db->where('adj_id', $adj_id);
        $this->db->update('stock_adjustments', $data);
        return $this->db->affected_rows();
    }
    function is_approved($adj_id){
        $this->db->select('approval_status');
        $this->db->from('stock_adjustments');
        $this->db->where('adj_id', $adj_id);
        $query = $this->db->get();
        return $query->row()->approval_status ? false: true;
        //approval_status == 0 == false; return true; true means "not approved yet. so good to continue the approval process"
    }
    
    /*
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    */
    public function print_grn_details()
    {
        $adj_id             = $this->input->get('adjustment_id');
        $data['ingredient_item'] = $this->Ingredient_Stock_Adj_Model->get_ingredient_item_list($adj_id);
        $data['reference_no']    = $this->Ingredient_Stock_Adj_Model->get_ingredient_ref($adj_id);
        $this->load->view('models/view_ingridient_grn', $data);
    }
}


