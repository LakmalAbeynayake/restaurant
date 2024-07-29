<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Sales extends CI_Controller
{
    var $main_menu_name = "sales";
    var $sub_menu_name = "sales";
    public function __construct()
    {
        parent::__construct();
        //ini_set('max_execution_time', 10);
        $this->load->model('Sales_Model');
        $this->load->model('Supplier_Model');
        $this->load->model('Warehouse_Model');
        $this->load->model('Common_Model');
        $this->load->model('Tax_Rates_Model');
        $this->load->model('Customer_Model');
        $this->load->model('Sales_Return_Model');
        $this->load->model('Restaurant_Model');
        error_reporting(E_ALL);
        //ini_set('display_errors', 1);
    }
    //Sales list page load
    public function index()
    {
        $this->load->model('User_Model');
        $data['sales']          = array(); //$this->Sales_Model->get_all_sales();
        $data['main_menu_name'] = $this->main_menu_name;
        $data['sub_menu_name']  = $this->sub_menu_name;
        $data['user_list']      = $this->User_Model->getUsers();
        $data['warehouse_list'] = $this->Warehouse_Model->get_all_warehouse();
        $data['customer_list']  = $this->Customer_Model->get_all_customers();
        $this->load->view('sales/sales_list', $data);
    }
    //Sales details view
    public function view()
    {
        $data['main_menu_name'] = $this->main_menu_name;
        $data['sub_menu_name']  = '';
        //get sale id
        $sale_id                = $this->uri->segment('3');
        $data['sale_details']   = $this->Sales_Model->get_sale_info($sale_id);
        if ($data['sale_details']) {
            $data['sale_item_list']     = $this->Sales_Model->get_sale_item_list_by_sale_id($sale_id);
            $data['total_paid_amount']  = $this->Sales_Model->get_total_paid_by_sale_id($sale_id);
            //echo $sale_id;
            $data['sale_payments_list'] = $this->Sales_Model->get_sale_payments_by_sale_id($sale_id);
            $old_payment_tot            = 0;
            $retured_payment_tot        = 0;
            $retured_payment_msg_this   = '';
            $old_payments_dis_msg_this  = '';
            //check return payments
            $return_sales_details       = $this->Sales_Return_Model->get_return_sale_info_sale_id($sale_id);
            foreach ($return_sales_details as $row) {
                $this_balance_pament      = 0;
                $this_trn_amt             = $row->sl_rtn_total;
                $retured_payment_tot      = $retured_payment_tot + $this_trn_amt;
                $retured_payment_msg_this = $retured_payment_msg_this . ' -' . $this_trn_amt . ' ,';
            }
            $old_payment_tot              = $old_payment_tot - $retured_payment_tot;
            $data['old_payments']         = $old_payment_tot;
            $data['old_payments_dis_msg'] = "Return Total Amount ($old_payments_dis_msg_this $retured_payment_msg_this)";
            $data['sale_id']              = $sale_id;
            $data['customer_details']     = $this->Customer_Model->get_customer_info($data['sale_details']['customer_id']);
            $data['warehouse_details']    = $this->Warehouse_Model->get_warehouse_info($data['sale_details']['warehouse_id']);
            $this->load->view('sales/sale_details', $data);
        } else
            show_404();
    }
    //Sales add page
    public function add_sale_payments()
    {
        if ($this->session->userdata('ss_cashier_float_id') > 0) {
        } else {
            echo json_encode(array(
                'status' => 0,
                'validation' => 'Please start new float'
            ));
            return false;
        }
        $sale_total                       = $this->input->post('sale_total');
        $uuid                             = $this->input->post('uuid');
        $sale_pymnt_amount                = $this->input->post('sale_pymnt_amount');
        $sale_id                          = $this->input->post('sale_id');
        $sale_pymnt_ref_no                = $this->input->post('sale_pymnt_ref_no');
        $sale_pymnt_paying_by             = $this->input->post('sale_pymnt_paying_by');
        $sale_pymnt_date_time             = $this->input->post('sale_pymnt_date_time');
        $sale_pymnt_date_time_send        = date('Y-m-d H:i:s', strtotime($sale_pymnt_date_time));
        $sale_pymnt_cheque_no             = $this->input->post('sale_pymnt_cheque_no');
        $sale_pymnt_crdt_card_no          = $this->input->post('sale_pymnt_crdt_card_no');
        $sale_pymnt_crdt_card_holder_name = $this->input->post('sale_pymnt_crdt_card_holder_name');
        $sale_pymnt_crdt_card_month       = $this->input->post('sale_pymnt_crdt_card_month');
        $sale_pymnt_crdt_card_year        = $this->input->post('sale_pymnt_crdt_card_year');
        $sale_pymnt_crdt_card_type        = $this->input->post('sale_pymnt_crdt_card_type');
        $sale_type                        = $this->input->post('sale_type');
        $sale_pymnt_note                  = $this->input->post('sale_pymnt_note');
        $user_id                          = $this->session->userdata('ss_user_id');
        $sale_pymnt_added_date_time       = date("Y-m-d H:i:s");
        $sale_pymnt_id                    = '';
        $this->load->library('form_validation'); //form validation lib
        $this->form_validation->set_rules('sale_pymnt_amount', 'Amount', 'required');
        $this->form_validation->set_rules('uuid', 'UUID', 'required|is_unique[sale_payments.uuid]');
        if ($sale_pymnt_paying_by == 'CC') {
            $this->form_validation->set_rules('sale_pymnt_crdt_card_type', 'Card Type', 'required');
            $this->form_validation->set_rules('sale_pymnt_crdt_card_no', 'Credit Card No', 'required');
            $this->form_validation->set_rules('sale_pymnt_crdt_card_holder_name', 'Holder Name', 'required');
            $this->form_validation->set_rules('sale_pymnt_crdt_card_month', 'Month', 'required');
            $this->form_validation->set_rules('sale_pymnt_crdt_card_year', 'Year', 'required');
        }
        if ($sale_pymnt_paying_by == 'Cheque') {
            $this->form_validation->set_rules('sale_pymnt_cheque_no', 'Cheque No', 'required');
        }
        $this->form_validation->set_rules('sale_id', 'System Error', 'required');
        if ($this->form_validation->run() == FALSE) {
            $st = array(
                'status' => 0,
                'validation' => validation_errors()
            );
            echo json_encode($st);
        } else {
            /*
                get total paid
            */
            $total_paid_amount = $this->Sales_Model->get_total_paid_by_sale_id($sale_id);
            $total_advance_paid_amount = 0;
            
            $this->db->select('qts_id');
            $this->db->from('sales');
            $this->db->where('sale_id',$sale_id);
            $query = $this->db->get();
            
            $qts_id = $query->row()->qts_id;
            if($qts_id)
                $total_advance_paid_amount = $this->Sales_Model->get_total_advance_by_qts_id($qts_id);
            
            $total_paid_amount += $total_advance_paid_amount;
            
            if(($total_paid_amount + $sale_pymnt_amount) > $sale_total){
                $st = array(
                    'status' => 0,
                    'validation' => "Invalid Paying amount!"
                );
                echo json_encode($st);
                exit;
            }
            $data = array(
                'sale_pymnt_amount' => $sale_pymnt_amount,
                'sale_pymnt_ref_no' => $sale_pymnt_ref_no,
                'sale_pymnt_paying_by' => $sale_pymnt_paying_by,
                'sale_pymnt_date_time' => $sale_pymnt_date_time_send,
                'sale_pymnt_note' => $sale_pymnt_note,
                'user_id' => $user_id,
                'sale_id' => $sale_id,
                'sale_pymnt_added_date_time' => $sale_pymnt_added_date_time,
                'sale_pymnt_cheque_no' => $sale_pymnt_cheque_no,
                'sale_pymnt_crdt_card_no' => $sale_pymnt_crdt_card_no,
                'sale_pymnt_crdt_card_holder_name' => $sale_pymnt_crdt_card_holder_name,
                'sale_pymnt_crdt_card_type' => $sale_pymnt_crdt_card_type,
                'sale_pymnt_crdt_card_month' => $sale_pymnt_crdt_card_month,
                'sale_pymnt_crdt_card_year' => $sale_pymnt_crdt_card_year,
                'sale_payment_type' => $sale_type,
                'float_id' => $this->session->userdata('ss_cashier_float_id'),
                'uuid' => $uuid
            );
            if ($this->Sales_Model->save_sale_payments($data, $sale_pymnt_id)) {
                $this->Common_Model->add_user_activitie("Sale payment added $sale_pymnt_amount by $sale_pymnt_paying_by for sale $sale_id");
                $reference_id = $this->db->insert_id();
                /* update sale record*/
                if($sale_total > 0){
                    $this->update_paid_status($sale_id,$sale_total);
                    //echo $this->db->last_query();
                    
                    /*update finance movement*/
                    $data = array(
                        'transaction_date' => date('Y-m-d H:i:s'), // You can use any date format here
                        'transaction_type' => 'income', // Or 'expense' or 'transfer'
                        'transaction_method' => $sale_pymnt_paying_by, // cash / visa
                        'amount' => $sale_pymnt_amount,
                        'currency' => 'LKR',
                        'description' => 'Income from sales',
                        'reference_id' => $reference_id, // If there's no related transaction, set it to null
                        'created_by_user_id' => $user_id // Provide the user ID who initiated the transaction
                    );
                    $this->Common_Model->insert_transaction($data);
                }
                $st = array(
                    'status' => 1,
                    'validation' => 'Done!'
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
    function update_paid_status($sale_id,$sale_total){
        $total_paid_amount = $this->Sales_Model->get_total_paid_by_sale_id($sale_id);
        $total_advance_paid_amount = 0;
        
        $this->db->select('qts_id');
        $this->db->from('sales');
        $this->db->where('sale_id',$sale_id);
        $query = $this->db->get();
        
        $qts_id = $query->row()->qts_id;
        if($qts_id)
            $total_advance_paid_amount = $this->Sales_Model->get_total_advance_by_qts_id($qts_id);
        
        $total_paid_amount += $total_advance_paid_amount;
        
        $return_tot_amt    = $this->Sales_Return_Model->get_total_return_by_sale_id($sale_id);
        $to_be_paid        = $sale_total - $return_tot_amt;
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
        );
        $this->db->where('sale_id',$sale_id);
        $this->db->update('sales', $update);
    }
    //Sales payment page 
    public function payments()
    {
        $data['sale_id']   = $this->input->get('id');
        $data['sale_type'] = $this->input->get('sale_type');
        $this->load->view('models/sales_payment', $data);
    }
    public function advance_payments()
    {
        $data['sale_id']   = $this->input->get('id');
        $data['sale_type'] = $this->input->get('sale_type');
        $this->load->view('models/sales_payment_advance', $data);
    }
    //Sales save 
    //Sales item save
    //Add sales items to 54 table
    public function save_sales()
    {
        //$sale_reference_no=$this->input->post('sale_reference_no');
        $query             = $this->Sales_Model->get_next_ref_no();
        $result            = $query->row();
        $sale_reference_no = sprintf("%05d", $result->sale_id + 1);
        $warehouse_id      = $this->input->post('warehouse_id');
        $customer_id       = $this->input->post('customer_id');
        $rowCount          = $this->input->post('rowCount');
        $sale_datetime_1   = $this->input->post('sale_datetime');
        $sale_datetime     = date('Y-m-d H:i:s', strtotime($sale_datetime_1));
        $tax_rate_id       = $this->input->post('tax_rate_id');
        $sale_inv_discount = $this->input->post('sale_inv_discount');
        $sale_status       = $this->input->post('sale_status');
        $payment_status    = $this->input->post('payment_status');
        $sale_shipping     = $this->input->post('sale_shipping');
        $sale_payment_term = $this->input->post('sale_payment_term');
        $sale_total        = $this->input->post('sale_total');
        $sale_paid         = $this->input->post('sale_paid');
        if ($sale_paid == "NaN")
            $sale_paid = 0;
        $sale_balance             = $this->input->post('sale_balance');
        $cost_total               = $this->input->post('cost_total');
        $in_type                  = $this->input->post('in_type');
        $sale_inv_discount_amount = $this->input->post('sale_inv_discount_amount');
        $sale_datetime_created    = date('Y-m-d H:i:s');
        $error                    = '';
        $disMsg                   = '';
        $lastid                   = '';
        $sale_id                  = '';
        if (!$error) {
            $data    = array(
                'sale_reference_no' => $sale_reference_no,
                'warehouse_id' => $warehouse_id,
                'customer_id' => $customer_id,
                'warehouse_id' => $warehouse_id,
                'sale_datetime' => $sale_datetime,
                //'tax_rate_id' => $tax_rate_id,
                'sale_inv_discount' => $sale_inv_discount,
                'sale_status' => $sale_status,
                'payment_status' => $payment_status,
                'sale_shipping' => $sale_shipping,
                'sale_payment_term' => $sale_payment_term,
                'sale_total' => $sale_total,
                'sale_paid' => $sale_paid,
                'cost_total' => $cost_total,
                'sale_balance' => $sale_balance,
                'in_type' => $in_type,
                'sale_datetime_created' => $sale_datetime_created,
                'sale_inv_discount_amount' => $sale_inv_discount_amount
            );
            $_insert = $this->Sales_Model->save_sales($data, $sale_id);
            $lastid  = $this->db->insert_id();
            $sale_id = $lastid;
            //insert user activity
            $this->Common_Model->add_user_activitie("Added Sale, (Invoice No:$sale_reference_no)");
            $disMsg    = 'Sale successfully added';
            //insert sale item data
            $row       = $this->input->post('row');
            $rowCount  = $this->input->post('rowCount');
            $data_item = array();
            for ($i = 1; $i <= $rowCount; $i++) {
                //echo "/ $rowCount , Test:".$row[$i]['product_id'][0];
                if (isset($row[$i]['product_id'][0])) {
                    $data_item = array(
                        'sale_id' => $sale_id,
                        'product_id' => $row[$i]['product_id'][0],
                        'quantity' => $row[$i]['qty'][0],
                        'discount' => $row[$i]['discount'][0],
                        'unit_price' => $row[$i]['unit_price'][0],
                        'item_cost' => $row[$i]['item_cost'][0],
                        'unit_price' => $row[$i]['unit_price'][0] + $row[$i]['item_price_p'][0],
                        'discount_val' => $row[$i]['discount_val'][0],
                        'gross_total' => $row[$i]['gross_total'][0]
                    );
                    $this->Sales_Model->save_sales_item($data_item);
                    $itemid = $this->db->insert_id();
                    //insert user activity
                    $this->Common_Model->add_user_activitie("Added Sale Item, (Id:$itemid)");
                    //add reford for f4 table
                    $type      = 'sale';
                    $ref_id    = $sale_id;
                    $product   = $row[$i]['product_id'][0];
                    $quantity  = $row[$i]['qty'][0];
                    $unit_cost = $row[$i]['unit_price'][0];
                    $this->Common_Model->add_fi_table($type, $ref_id, $product, $quantity, $unit_cost);
                }
            }
        } else {
            $disMsg = 'Please select these before adding any product:' . $disMsg;
        }
        $this->session->set_flashdata('message', 'Sale successfully added!');
        echo json_encode(array(
            'sale_id' => $lastid,
            'error' => $error,
            'disMsg' => $disMsg
        ));
    }
    //Sales reference no jenarate    
    public function get_next_ref_no()
    {
        $query             = $this->Sales_Model->get_next_ref_no();
        $result            = $query->row();
        //print_r($result);
        $sale_reference_no = sprintf("%05d", $result->sale_id + 1);
        $sale_reference_no = $sale_reference_no;
        echo json_encode(array(
            'sale_reference_no' => $sale_reference_no
        ));
    }
    //Sales ger avalable product qty
    public function get_avalable_product_qty()
    {
        $product_id    = $this->input->get('product_id');
        $warehouse_id  = $this->input->get('warehouse_id');
        $data['total'] = $this->Sales_Model->get_avalable_product_qty($product_id, $warehouse_id);
        echo json_encode(array(
            'remmnaingQty' => $data['total']
        ));
    }
    //Sales add form
    public function add_sales()
    {
        $data['main_menu_name'] = $this->main_menu_name;
        $data['sub_menu_name']  = 'add_sales';
        //get suppliers list
        $data['suppliers']      = $this->Supplier_Model->get_all_supplier();
        $data['warehouse_list'] = $this->Warehouse_Model->get_all_warehouse();
        $data['tax_rates_list'] = $this->Tax_Rates_Model->get_all_tax_rates();
        $data['customer_list']  = $this->Customer_Model->get_all_customers();
        $data['status_list']    = $this->Common_Model->get_all_status();
        $this->load->view('add_sales', $data);
    }
    //Sales product items get
    public function suggestions($value = '')
    {
        //print_r($_GET);
        $term          = $this->input->get('term');
        $in_type       = $this->input->get('t');
        $data['sales'] = $this->Sales_Model->get_products_suggestions($term);
        $json          = array();
        //echo "Count:".count($data['sales']);
        //print_r($data['sales']);
        foreach ($data['sales'] as $row) {
            //set price
            $price_tmp = 0;
            if ($in_type == 'Cash') {
                $price_tmp = $row['product_price'];
            }
            if ($in_type == 'Credit') {
                $price_tmp = $row['product_price']; //$price_tmp=$row['credit_salling_price'];
            }
            if ($in_type == 'Wholesale') {
                $price_tmp = $row['wholesale_price'];
            }
            $product_name   = $row['product_name'];
            $product_code   = $row['product_code'];
            $product_id     = $row['product_id'];
            $product_price  = $price_tmp;
            $sendParameters = "'$product_id','$product_name','$product_code','$product_price'";
            $sendParameters = "$product_id,$product_name,$product_code,$product_price";
            $json_itm       = array(
                'id' => $row['product_id'],
                'product_id' => $row['product_id'],
                'product_code' => $row['product_code'],
                'product_name' => $row['product_name'],
                'product_price' => $price_tmp,
                'item_cost' => $row['product_cost'],
                'product_oem_part_number' => '',
                'value' => $row['product_name'] . " (" . $row['product_code'] . ")",
                'label' => $row['product_name'] . " (" . $row['product_code'] . ")"
            );
            array_push($json, $json_itm);
        }
        echo json_encode($json);
    }
    //Sale details page
    public function sale_details()
    {
        $sale_type                  = 0;
        $sale_id                    = $this->input->get('sale_id');
        $sale_type                  = $this->input->get('type');
        $data['sale_details']       = $this->Sales_Model->get_sale_info($sale_id);
        $data['sale_type']          = $sale_type;
        //get sale item list
        $data['sale_item_list']     = $this->Sales_Model->get_sale_item_list_by_sale_id($sale_id);
        $data['customer_details']   = $this->Customer_Model->get_customer_info($data['sale_details']['customer_id']);
        $data['warehouse_details']  = $this->Warehouse_Model->get_warehouse_info($data['sale_details']['warehouse_id']);
        $data['sale_payments_list'] = $this->Sales_Model->get_sale_payments_by_sale_id($sale_id);
        //get old payments amounts
        $cus_sales_details          = $this->Sales_Model->get_sale_info_by_customer_id($data['sale_details']['customer_id']);
        $this->load->view('sales/sale_print', $data);
    }
    function print_kot()
    {
        $sale_type            = 0;
        $kot_id               = $this->input->get('sale_id');
        $kot_details          = $this->Sales_Model->get_kot_info($kot_id);
        $data['kot_details']  = $kot_details;
        $sale_id              = $kot_details['sale_id'];
        $sale_type            = $this->input->get('type');
        $data['sale_details'] = $this->Sales_Model->get_sale_info($sale_id);
        $floor_name           = '';
        $area_name            = '';
        $floor_id             = '';// $data['sale_details']['floor_id'];
        $division_id          = '';// $data['sale_details']['division_id'];
        if ($floor_id == 1) {
            $floor_name = 'BAR';
            if ($division_id == 1) {
                $area_name = 'AREA 1';
            } else if ($division_id == 2) {
                $area_name = 'AREA 2';
            }
        }
        if ($floor_id == 2) {
            //$floor_name    = '<div class=\"label col-xs-12\"  style="text-align:center; padding:15px; border-radius:5px; color:black; font-weight:bold; font-size:25px; background-color:#FCF49C;"> RESTAURANT </div>';
            $floor_name = 'RESTAURANT';
            $area_name  = 'RESTAURANT';
        }
        $data['area_name']        = $area_name;
        $data['floor_name']       = $floor_name;
        $data['table_id']         = $data['sale_details']['table_id'];
        $data['sale_type']        = $sale_type;
        //get sale item list
        $data['sale_item_list']   = $this->get_pending_sale_item_list_by_kot_id($kot_id);
        $data['customer_details'] = $this->Customer_Model->get_customer_info($data['sale_details']['customer_id']);
        // $data['warehouse_details']  = $this->Warehouse_Model->get_warehouse_info($data['sale_details']['warehouse_id']);
        //  $data['sale_payments_list'] = $this->Sales_Model->get_sale_payments_by_sale_id($sale_id);
        //get old payments amounts
        //$cus_sales_details          = $this->Sales_Model->get_sale_info_by_customer_id($data['sale_details']['customer_id']);
        if ($data['sale_item_list']) {
            $this->load->view('models/print_kot', $data);
            $data = array(
                'duplicate_print_by' => $this->session->userdata('ss_user_id'),
                'duplicate_print_on' => date("Y-m-d h:i:s")
            );
            $t    = $this->Restaurant_Model->update_kot_master($kot_id, $data);
        } else {
            $this->set_printed_($sale_id);
            echo '<script>window.close()</script>';
        }
    }
    function set_printed_($sale_id)
    {
        $this->db->where('sale_id', $sale_id);
        if ($this->db->update('sale_items', array('print_status' => 1))) {
            $this->db->where('sale_id', $sale_id);
            $this->db->update('sales', array('print_status' => 1));
            return 1;
        }
        //echo $this->db->last_query();
    }
    public function sale_details_pos()
    {
        $sale_type            = 0;
        $sale_id              = $this->input->get('sale_id');
        $dd                   = $this->input->get('dd');
        $sale_type            = $this->input->get('type');
        $data['sale_details'] = $this->Sales_Model->get_sale_info($sale_id);
        $data['sale_type']    = $sale_type;
        if ($dd == 1) {
            $data['reprinted'] = "DUPLICATE";
        }
        //get sale item list
        $data['sale_item_list']     = $this->Sales_Model->get_sale_item_list_by_sale_id($sale_id,1);
        $data['customer_details']   = $this->Customer_Model->get_customer_info($data['sale_details']['customer_id']);
        $data['warehouse_details']  = $this->Warehouse_Model->get_warehouse_info($data['sale_details']['warehouse_id']);
        $data['sale_payments_list'] = $this->Sales_Model->get_sale_payments_by_sale_id($sale_id);
        //get old payments amounts
        //$cus_sales_details=$this->Sales_Model->get_sale_info_by_customer_id($data['sale_details']['customer_id']);
        $this->load->view('models/view_sales_pos', $data);
    }
    public function sale_details_quot()
    {
        $sale_type            = 0;
        $sale_id              = $this->input->get('sale_id');
        $dd                   = $this->input->get('dd');
        $sale_type            = $this->input->get('type');
        $data['sale_details'] = $this->Sales_Model->get_sale_info($sale_id);
        $data['sale_type']    = $sale_type;
        if ($dd == 1) {
            $data['reprinted'] = "DUPLICATE";
        }
        //get sale item list
        $data['sale_item_list']     = $this->Sales_Model->get_sale_item_list_by_sale_id($sale_id);
        $data['customer_details']   = $this->Customer_Model->get_customer_info($data['sale_details']['customer_id']);
        $data['warehouse_details']  = $this->Warehouse_Model->get_warehouse_info($data['sale_details']['warehouse_id']);
        $data['sale_payments_list'] = $this->Sales_Model->get_sale_payments_by_sale_id($sale_id,true);
        //get old payments amounts
        //$cus_sales_details=$this->Sales_Model->get_sale_info_by_customer_id($data['sale_details']['customer_id']);
        $this->load->view('models/view_sales_pos_quot', $data);
    }
    public function sale_details_kot()
    {
        $sale_type                  = 0;
        $sale_id                    = $this->input->get('sale_id');
        $sale_type                  = $this->input->get('type');
        $data['sale_details']       = $this->Sales_Model->get_sale_info($sale_id);
        $data['sale_type']          = $sale_type;
        //get sale item list
        $data['sale_item_list']     = $this->Sales_Model->get_sale_item_list_by_sale_id($sale_id);
        $data['customer_details']   = $this->Customer_Model->get_customer_info($data['sale_details']['customer_id']);
        $data['warehouse_details']  = $this->Warehouse_Model->get_warehouse_info($data['sale_details']['warehouse_id']);
        $data['sale_payments_list'] = $this->Sales_Model->get_sale_payments_by_sale_id($sale_id);
        //get old payments amounts
        //$cus_sales_details=$this->Sales_Model->get_sale_info_by_customer_id($data['sale_details']['customer_id']);
        $this->load->view('models/view_sales_kot', $data);
    }
    public function pos_sale_details()
    {
        $sale_type                  = 0;
        $sale_id                    = $this->input->get('sale_id');
        $sale_type                  = $this->input->get('type');
        $data['sale_details']       = $this->Sales_Model->get_sale_info($sale_id);
        $data['sale_type']          = $sale_type;
        //get sale item list
        $data['sale_item_list']     = $this->Sales_Model->get_sale_item_list_by_sale_id($sale_id);
        $data['customer_details']   = $this->Customer_Model->get_customer_info($data['sale_details']['customer_id']);
        $data['warehouse_details']  = $this->Warehouse_Model->get_warehouse_info($data['sale_details']['warehouse_id']);
        $data['sale_payments_list'] = $this->Sales_Model->get_sale_payments_by_sale_id($sale_id);
        //get old payments amounts
        //$cus_sales_details=$this->Sales_Model->get_sale_info_by_customer_id($data['sale_details']['customer_id']);
        //print_r($cus_sales_details);
        //$old_payment_tot=0;
        //$retured_payment_tot=0;
        //$retured_payment_msg_this='';
        //$old_payments_dis_msg_this='';
        /*foreach ($cus_sales_details as $row)
        {
        //echo "sale id:$row->sale_id";
        //echo "sale_total:$row->sale_total";
        if($row->sale_id!=$sale_id){
        //get paid amount
        $paid_amount=$this->Sales_Model->get_total_paid_by_sale_id($row->sale_id);
        if($row->sale_total!=$paid_amount){
        //$this_balance_pament=$row->sale_total-$paid_amount;
        //$old_payment_tot=$old_payment_tot+$this_balance_pament;
        //echo "sale_total:$row->sale_total , ";
        //$old_payments_dis_msg_this=$old_payments_dis_msg_this.''.$this_balance_pament.' ,';
        }
        }
        }
        */
        //check return payments
        //$return_sales_details = $this->Sales_Return_Model->get_return_sale_info_sale_id($sale_id);
        /*
        foreach ($return_sales_details as $row)
        {
        //echo "sale id:$row->sale_id";
        //echo "sale_total:$row->sale_total";
        
        $this_balance_pament=0;
        $this_trn_amt=$row->sl_rtn_total;
        $retured_payment_tot=$retured_payment_tot+$this_trn_amt;
        
        $retured_payment_msg_this=$retured_payment_msg_this.' -'.$this_trn_amt.' ,';
        
        
        }*/
        //$old_payment_tot=$old_payment_tot-$retured_payment_tot;
        //$data['old_payments']=$old_payment_tot;
        //$data['old_payments_dis_msg']="Return Total Amount ($old_payments_dis_msg_this $retured_payment_msg_this)";
        //$data['cr_limit_list'] = $this->Common_Model->get_all_cr_limit();
        $this->load->view('models/pos_view_sales', $data);
    }
    //Sales list
    public function list_sales()
    {
        $requestData    = $this->input->get();
        $search_key     = $this->input->get('search');
        $ss     = $this->input->get('ss');
        $ps     = $this->input->get('ps');
        $search_key_val = $search_key['value'];
        $start          = $this->input->get('start');
        $length         = $this->input->get('length');
        $order          = $this->input->get('order');
        $columns        = $this->input->get('columns');
        $srh_location_id  = $this->input->get('srh_location_id') !== '' ? $this->input->get('srh_location_id') : $this->session->userdata('ss_warehouse_id');
        $srh_from_date  = $this->input->get('srh_from_date');
        $srh_to_date    = $this->input->get('srh_to_date');
        $srh_user_id    = $this->input->get('srh_user_id');
        $customer_id    = $this->input->get('customer_id');
        if ($srh_from_date) {
            $srh_from_date = date('Y-m-d H:i:s', strtotime($srh_from_date));
        }
        if ($srh_to_date) {
            $srh_to_date = date('Y-m-d H:i:s', strtotime($srh_to_date));
        }
        $columns       = array(
            0 => 'sale_id',
            1 => 'sale_reference_no',
            2 => 'sale_id',
            3 => 'sale_id',
            4 => 'sale_id',
            5 => 'sale_id'
        );
        $data          = array();
        //$sales_tot     = $this->Sales_Model->get_all_sales_count($customer_id,$ss,$ps,$srh_location_id,$search_key_val, $srh_from_date, $srh_to_date, $srh_user_id);
        $sales         = $this->Sales_Model->get_all_sales($customer_id,$ss,$ps,$srh_location_id,$start, $length, $search_key_val, '', $order[0], $srh_from_date, $srh_to_date, $srh_user_id);
        $totalData     = $this->Sales_Model->get_all_sales($customer_id,$ss,$ps,$srh_location_id,'', '', $search_key_val, 1, $order[0], $srh_from_date, $srh_to_date, $srh_user_id);
        //$totalD-ata     = $sales_tot;
        $totalFiltered = $totalData;
        foreach ($sales as $row) {
            /*if($ss != '')
                if($row['sale_status'] != $ss)
                    continue;
            
            if($ps != '')
                if($row['payment_status'] != $ps)
                    continue;*/
            
            $nestedData      = array();
            $sale_id         = $row['sale_id'];
            $order_yype_name = "";
            if ($row['dine_type'] == 1) {
                $order_yype_name = "DINE-IN";
            }
            if ($row['dine_type'] == 2) {
                $order_yype_name = "TAKE-AWAY";
            }
            $total_paid_amount = 0;
            //$total_paid_amount = $this->Sales_Model->get_total_paid_by_sale_id($sale_id);
            
            $total_advance_paid_amount = 0;
            //if($row['qts_id'])
                //$total_advance_paid_amount = $this->Sales_Model->get_total_advance_by_qts_id($row['qts_id']);
                
            $total_paid_amount += floatval($total_advance_paid_amount);
            
            $return_tot_amt    = 0;
            $return_tot_amt    = $this->Sales_Return_Model->get_total_return_by_sale_id($sale_id);
            $to_be_paid        = $row['sale_total'] - $return_tot_amt;
            $nestedData[]      = display_date_time_format($row['sale_datetime']);
            $nestedData[]      = $row['sale_id'];//sale_reference_no
            $nestedData[]      = $row['cus_name'] . " | " . $order_yype_name;
            $nestedData[]      = $row['cashier'];
            $nestedData[]      = $row['waiter'];
            /*
            $nestedData[] = number_format($row['sale_total'], 2, '.', ',');
            $nestedData[] = number_format($total_paid_amount, 2, '.', ',');
            $nestedData[] = number_format($row['sale_total']-$total_paid_amount, 2, '.', ',');
            */
            $nestedData[]      = $row['sale_total'];
            $nestedData[]      = $return_tot_amt;
            $nestedData[]      = $to_be_paid;
            $nestedData[]      = $row['total_paid'];
            $nestedData[]      = $row['total_balance'];
            /*
            if($row['payment_status']=='Paid') {
                $nestedData[]='<span class="label label-sm label-success">'.$row['payment_status'].'</span>'; 
            }else {
                $nestedData[]=$row['payment_status'];
            }
            */
            
            /*if (empty($total_paid_amount)) {
                $pay_st = '<span class="label label-warning">Pending</span>';
            } else {
                if ($total_paid_amount >= $to_be_paid) {
                    $pay_st = '<span class="label label-success">Paid</span>';
                } else {
                    $pay_st = '<span class="label label-info">Partial</span>';
                }
            }
            if ($row['sale_status'] == 99) {
                $pay_st = '<span class="label label-danger">Canceled</span>';
            }*/

            if ($row['payment_status'] == 'pending') {
                $pay_st = '<span class="label label-warning">Pending</span>';
            }else if ($row['payment_status'] == 'partial'){
                $pay_st = '<span class="label label-info">Partial</span>';
            } else {
                $pay_st = '<span class="label label-success">Paid</span>';
            }
            
            if( $row['sale_status'] == 99 ) $pay_st = '--/--';

            $nestedData[]    = $row['sale_status'] == 1 ? "Live" : ( $row['sale_status'] == 99 ? '<span class="label label-danger">Canceled</span>': "Finished");
            $nestedData[]    = $pay_st;
            $style           = '';
            //$nestedData[] = $row['sale_id'];
            $actionTxtDisble = '';
            $actionTxtEnable = '';
            $actionTxtUpdate = '';
            $actionTxtDelete = '';
            if ($this->session->userdata('ss_group_id') == 1 || $this->session->userdata('ss_user_group_id') == 2) {
                $actionTxtDelete = '<li style="' . $style . '"><a href="#" data-sale_id="'.$sale_id.'" onClick ="delete_invoice(this)"><i class="fa fa-trash-o"></i></i> Delete Invoice</a></li>
                                    <li style="' . $style . '"><a href="#" data-sale_id="'.$sale_id.'" onClick ="delete_payments(this)"><i class="fa fa-trash-o"></i> Delete Payments</a></li>';
                if ($row['sale_status'] == 99) $actionTxtDelete = '';
            }
            $url                  = base_url("sales/sale_details?sale_id=$sale_id");
            $actionTxtUpdate      = '<a data-sale_id="' . $row['sale_id'] . '" onClick="print_bill(this)" data-toggle="modal" href="#" class="btn btn-xs btn-blue tooltips" data-placement="top" data-original-title="Edit suppliers"><i class="clip-zoom-in-2"></i></a> &nbsp;';
            $actionTxtViewDetails = '<a href="' . base_url() . 'sales/view/' . $sale_id . '" class="btn btn-xs btn-blue tooltips" data-placement="top" data-original-title="Edit suppliers"><i class="fa fa-file-text-o"></i></a> &nbsp;';
            $nestedData[]         = '<div class="btn-group text-left">
                            <button data-toggle="dropdown" class="btn btn-default btn-xs btn-primary dropdown-toggle" type="button">Actions <span class="caret"></span></button>
                            <ul role="menu" class="dropdown-menu pull-right">
                            <li><a href="' . base_url() . 'sales/view/' . $sale_id . '"><i class="fa fa-file-text-o"></i> Sale Details</a></li>
                            <li><a data-sale_id="' . $row['sale_id'] . '" onClick="print_bill(this)" data-toggle="modal" href="#" data-placement="top" data-original-title="Edit suppliers"><i class="fa fa-print"></i> Print Sale</a></li>
                            <!-- <li><a href="' . base_url() . 'sales_return/sales_return_add/' . $sale_id . '"><i class="fa fa-angle-double-left"></i></i> Return Sale</a></li>-->
                           
                            </ul></div>';
            $data[]               = $nestedData;
        }
        $json_data = array(
            "draw" => intval($requestData['draw']),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );
        echo json_encode($json_data);
    }
    public function add_order()
    {
        $data['main_menu_name'] = 'order';
        $data['sub_menu_name']  = 'add_order';
        //get suppliers list
        $data['suppliers']      = $this->Supplier_Model->get_all_supplier();
        $data['warehouse_list'] = $this->Warehouse_Model->get_all_warehouse();
        $data['tax_rates_list'] = $this->Tax_Rates_Model->get_all_tax_rates();
        $data['customer_list']  = $this->Customer_Model->get_all_customers();
        $data['status_list']    = $this->Common_Model->get_all_status();
        $this->load->view('add_order', $data);
    }
    public function order_list()
    {
        $data['sales']          = $this->Sales_Model->get_all_sales();
        $data['main_menu_name'] = 'order';
        $data['sub_menu_name']  = 'order';
        $this->load->view('order', $data);
    }
    public function sales_delete()
    {
        $sale_id = $this->input->get('sale_id');
        $result  = $this->Sales_Model->sales_delete($sale_id);
        $this->Common_Model->add_user_activitie("sale delete - id#$sale_id - $result");
        //$result  = $this->Sales_Model->delete_sale_payments($sale_id);
        echo json_encode(array(
            'success' => $result
        ));
    }
    public function sale_pymnts_delete()
    {
        $sale_id = $this->input->get('sale_id');
        $in_type = $this->input->get('in_type');
        $result  = $this->Sales_Model->delete_sale_payments($sale_id);
        $this->Common_Model->add_user_activitie("Sale payment delete - id#$sale_id - $result");
        return $result;
    }
    public function sale_pymnts_delete_by_sp_id()
    {
        $sp_id  = $this->input->get('sp_id');
        if($sp_id){
            /**/
            $this->db->select('sale_id');
            $this->db->from('sale_payments');
            $this->db->where('sale_pymnt_id', $sp_id);
            $this->db->where('sale_payment_type', 'sale');
            $query = $this->db->get();
            $sale_id = $query->row()->sale_id;
            //echo $this->db->last_query();
            $result = $this->Sales_Model->sale_pymnts_delete_by_sp_id($sp_id);
            if($sale_id){
                $this->db->select('sale_id,sale_total,qts_id');
                $this->db->from('sales');
                $this->db->where('sale_id', $sale_id);
                $query = $this->db->get();
                //echo $this->db->last_query();
                $row = $query->row_array();
                $this->Sales_Model->update_sale_record($row);
            }
            /**/
            echo json_encode(array(
                'success' => $result
            ));
            $this->Common_Model->add_user_activitie("Sale payment deleted - sp_id#$sp_id - $result");
            return;
        }
        echo json_encode(array(
            'success' => false
        ));
    }
    public function qts_pymnts_delete_by_sp_id()
    {
        $sp_id  = $this->input->get('sp_id');
        if($sp_id){
            $result = $this->Sales_Model->sale_pymnts_delete_by_sp_id($sp_id);
            echo json_encode(array(
                'success' => $result
            ));
            $this->Common_Model->add_user_activitie("Advance payment deleted - sp_id#$sp_id - $result");
            return;
        }
        echo json_encode(array(
            'success' => false
        ));
    }
    public function cheque_return_by_sp_id()
    {
        $sp_id  = $this->input->get('sp_id');
        $result = $this->Sales_Model->cheque_return_by_sp_id($sp_id);
        return $result;
    }
    public function sale_details_pos_duplicate()
    {
        $sale_type                  = 0;
        $sale_ref                   = $this->input->get('sale_ref');
        $sale_id                    = $this->Sales_Model->get_sale_id($sale_ref);
        $data['reprinted']          = "RE-PRINTED";
        $sale_type                  = $this->input->get('type');
        $data['sale_details']       = $this->Sales_Model->get_sale_info($sale_id);
        $data['sale_type']          = $sale_type;
        //get sale item list
        $data['sale_item_list']     = $this->Sales_Model->get_sale_item_list_by_sale_id($sale_id);
        $data['customer_details']   = $this->Customer_Model->get_customer_info($data['sale_details']['customer_id']);
        $data['warehouse_details']  = $this->Warehouse_Model->get_warehouse_info($data['sale_details']['warehouse_id']);
        $data['sale_payments_list'] = $this->Sales_Model->get_advance_qty_sale_payments_by_sale_id($sale_id);
        //get old payments amounts
        //$cus_sales_details=$this->Sales_Model->get_sale_info_by_customer_id($data['sale_details']['customer_id']);
        $this->load->view('models/view_sales_pos', $data);
    }
    function check_kot(){
        $location_id = $this->input->get('location_id');
        $kot_details         = $this->get_pending_kot_info($location_id);

        $data['kot_details'] = $kot_details;
        if (isset($kot_details['sale_id'])) {
            echo json_encode(array(
                'status' => true
            ));
        } else {
            echo json_encode(array(
                'status' => false
            ));
        }
    }
    function get_pending_kot_info($location_id)
    {
        $this->db->select('*');
        $this->db->from('kot_master');
        $this->db->where("is_auto_printed", 0);
        $this->db->where("location_id", $location_id);
        $this->db->order_by("kot_id", "asc");
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->row_array();
    }
    function get_sale_info($id)
    {
        $this->db->select('s.*,');
        $this->db->select('u.user_first_name as waitername');
        $this->db->select('ca.user_first_name as cashier');
        $this->db->from('sales s');
        $this->db->join('user u', 'u.user_id = s.waiter_id', 'left');
        $this->db->join('user ca', 'ca.user_id = s.user', 'left');
        $this->db->where("s.sale_id", $id);
        $query = $this->db->get();
        return $query->row_array();
    }
    function get_pending_sale_item_list_by_kot_id($kot_id)
    {
        $this->db->select('sale_items.separate_status,sale_items.product_id, product.product_name, product.product_code, sale_items.quantity, sale_items.discount, sale_items.discount_val, sale_items.unit_price, sale_items.gross_total');
        $this->db->from('sale_items');
        $this->db->join('product', 'sale_items.product_id = product.product_id', 'inner');
        $this->db->where("sale_items.kot_id", $kot_id);
        $this->db->where("sale_items.valid_status", 1);
        $this->db->order_by("sale_items.id", "asc");
	///	$this->db->where('print_status ','0');
        $query = $this->db->get();
        return $query->result_array();
    }
    function print_kot_auto()
    {
        $sale_type           = 0;
        $kot_id              = 0; //$this->input->get('sale_id');
        $location_id = $this->input->get('location_id');
        $kot_details         = $this->get_pending_kot_info($location_id);
        
       /* 
        print_r($kot_details);
        
        exit;
        */

        $data['kot_details'] = $kot_details;
        if (isset($kot_details['sale_id'])) {
            
        } else {
            echo '<script>window.close()</script>';
            return false;
        }
        
        
        $sale_id              = $kot_details['sale_id'];
        $kot_id              = $kot_details['kot_id'];
        $data['sale_details'] = $this->Sales_Model->get_sale_info($sale_id);

        if(empty($data['sale_details'])){
            $this->set_printed($sale_id, $kot_id);
            echo '<script>window.close()</script>';
            return;
        }
        
        
        $data['table_id']         = $data['sale_details']['table_id'];
        $data['sale_type']        = '';
        //get sale item list
        $data['sale_item_list']   = $this->get_pending_sale_item_list_by_kot_id($kot_details['kot_id']);
        $data['customer_details'] = $this->Customer_Model->get_customer_info($data['sale_details']['customer_id']);
        // $data['warehouse_details']  = $this->Warehouse_Model->get_warehouse_info($data['sale_details']['warehouse_id']);
        //  $data['sale_payments_list'] = $this->Sales_Model->get_sale_payments_by_sale_id($sale_id);
        //get old payments amounts
        //$cus_sales_details          = $this->Sales_Model->get_sale_info_by_customer_id($data['sale_details']['customer_id']);
  
        /*
            echo '<pre>';
            print_r($data['sale_item_list']);
            echo '</pre>';
            exit;
        */

        if (!empty($data['sale_item_list'])) {
            $this->load->view('models/print_kot', $data);
            $data = array(
                'is_auto_printed' => 1,
                'kot_status' => 2,
                'auto_printing_on' => date("Y-m-d H:i:s")
            );
            $t    = $this->update_kot_master($kot_details['kot_id'], $data);
        } else {
            $this->set_printed($sale_id,$kot_id);
            //$this->Sales_Model->set_printed($sale_id);
            echo '<script>window.close()</script>';
        }
    }
    function set_printed($sale_id,$kot_id)
    {
        $items = array(
            'print_status' => 1
        );
        $this->db->where('sale_id', $sale_id);
        if ($this->db->update('sale_items', $items)) {
            $data = array(
                'print_status' => 1
            );
            $this->db->where('sale_id', $sale_id);
            $this->db->update('sales', $data);
        }
        
        $data = array(
            'is_auto_printed' => 1
        );
        $this->db->where('sale_id', $sale_id);
        $this->db->where('kot_id', $kot_id);
        $this->db->update('kot_master', $data);
        
        //echo $this->db->last_query();
    }
    function update_kot_master($kot_id,$data){
        if($kot_id){
            $this->db->where('kot_id', $kot_id);
            return   $this->db->update('kot_master', $data);
        }else{
            return false;
        }
    }
     function delete_sale_item($id)
    {
        if ($id > 0) {
            $this->db->where('id', $id);
            $this->db->update('sale_items',array('valid_status'=>0));
            return $this->db->affected_rows();
            /*$this->db->where('id', $id);
            $this->db->delete('sale_items');
            return $this->db->affected_rows();*/
        } else {
            return 0;
        }
    }
    public function sales_item_delete()
    {
        $this->load->model('stock_model');
        
        $sale_item_id    = $this->input->get('sale_id');
        $uniq_id    = $this->input->get('uuid');
        $sale_info = $this->Sales_Model->get_sale_id_by_sale_item_id($sale_item_id);
        
        $sale_item_info = $this->Sales_Model->get_sale_item_info($sale_item_id);
        
        $date = date("Y-m-d H:i:s");
        
        $movements_list = array();
            $data = array(
                'location_id' => $sale_info->warehouse_id,
                'transaction_id' => $uniq_id,
                'product_id' => $sale_item_info->product_id,
                'quantity' => $sale_item_info->quantity * -1,
                'unit_value' => $sale_item_info->unit_price * -1,
                'movement_type' => 'out',
                'movement_date' => $sale_info->sale_datetime,
                'origin' => 'sale',
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
        $this->Common_Model->add_user_activitie("Sale Item Delete");
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
    public function sale_details_pos_without_balance()
    {
        $sale_type                  = 0;
        $sale_id                    = $this->input->get('sale_id');
        $sale_type                  = $this->input->get('type');
        $data['sale_details']       = $this->Sales_Model->get_sale_info($sale_id);
        $data['sale_type']          = $sale_type;
        //get sale item list
        $data['sale_item_list']     = $this->Sales_Model->get_sale_item_list_by_sale_id($sale_id,1);
        $data['customer_details']   = $this->Customer_Model->get_customer_info($data['sale_details']['customer_id']);
        $data['warehouse_details']  = $this->Warehouse_Model->get_warehouse_info($data['sale_details']['warehouse_id']);
        $data['sale_payments_list'] = array(); //$this->Sales_Model->get_sale_payments_by_sale_id($sale_id);
        //get old payments amounts
        //$cus_sales_details=$this->Sales_Model->get_sale_info_by_customer_id($data['sale_details']['customer_id']);
        $this->db->query('UPDATE `sales` SET `ready_sale`= 1 WHERE `sale_id` = ' . $sale_id);
        $this->load->view('models/view_sales_pos_without_balance', $data);
    }
    public function cash_drawer_open()
    {
        $data = array();
        $this->load->view('models/cash_drawer_open', $data);
    }
    //Sales add page
    public function add_sale_payments_advance()
    {
        if ($this->session->userdata('ss_cashier_float_id') > 0) {
        } else {
            echo json_encode(array(
                'status' => 0,
                'validation' => 'Please start new float'
            ));
            return false;
        }
        $sale_pymnt_amount                = $this->input->post('sale_pymnt_amount');
        $sale_id                          = $this->input->post('sale_id');
        $sale_pymnt_ref_no                = $this->input->post('sale_pymnt_ref_no');
        $sale_pymnt_paying_by             = $this->input->post('sale_pymnt_paying_by');
        $sale_pymnt_date_time             = $this->input->post('sale_pymnt_date_time');
        $sale_pymnt_date_time_send        = date('Y-m-d H:i:s', strtotime($sale_pymnt_date_time));
        $sale_pymnt_cheque_no             = $this->input->post('sale_pymnt_cheque_no');
        $sale_pymnt_crdt_card_no          = $this->input->post('sale_pymnt_crdt_card_no');
        $sale_pymnt_crdt_card_holder_name = $this->input->post('sale_pymnt_crdt_card_holder_name');
        $sale_pymnt_crdt_card_month       = $this->input->post('sale_pymnt_crdt_card_month');
        $sale_pymnt_crdt_card_year        = $this->input->post('sale_pymnt_crdt_card_year');
        $sale_pymnt_crdt_card_type        = $this->input->post('sale_pymnt_crdt_card_type');
        $sale_type                        = $this->input->post('sale_type');
        $sale_pymnt_note                  = $this->input->post('sale_pymnt_note');
        $user_id                          = $this->session->userdata('ss_user_id');
        $sale_pymnt_added_date_time       = date("Y-m-d H:i:s");
        $sale_pymnt_id                    = '';
        $this->load->library('form_validation'); //form validation lib
        $this->form_validation->set_rules('sale_pymnt_amount', 'Amount', 'required');
        if ($sale_pymnt_paying_by == 'CC') {
            $this->form_validation->set_rules('sale_pymnt_crdt_card_type', 'Card Type', 'required');
            $this->form_validation->set_rules('sale_pymnt_crdt_card_no', 'Credit Card No', 'required');
            $this->form_validation->set_rules('sale_pymnt_crdt_card_holder_name', 'Holder Name', 'required');
            $this->form_validation->set_rules('sale_pymnt_crdt_card_month', 'Month', 'required');
            $this->form_validation->set_rules('sale_pymnt_crdt_card_year', 'Year', 'required');
        }
        if ($sale_pymnt_paying_by == 'Cheque') {
            $this->form_validation->set_rules('sale_pymnt_cheque_no', 'Cheque No', 'required');
        }
        $this->form_validation->set_rules('sale_id', 'System Error', 'required');
        if ($this->form_validation->run() == FALSE) {
            $st = array(
                'status' => 0,
                'validation' => validation_errors()
            );
            echo json_encode($st);
        } else {
            $data = array(
                'sale_pymnt_amount' => $sale_pymnt_amount,
                'sale_pymnt_ref_no' => $sale_pymnt_ref_no,
                'sale_pymnt_paying_by' => $sale_pymnt_paying_by,
                'sale_pymnt_date_time' => $sale_pymnt_date_time_send,
                'sale_pymnt_note' => $sale_pymnt_note,
                'user_id' => $user_id,
                'sale_id' => $sale_id,
                'sale_pymnt_added_date_time' => $sale_pymnt_added_date_time,
                'sale_pymnt_cheque_no' => $sale_pymnt_cheque_no,
                'sale_pymnt_crdt_card_no' => $sale_pymnt_crdt_card_no,
                'sale_pymnt_crdt_card_holder_name' => $sale_pymnt_crdt_card_holder_name,
                'sale_pymnt_crdt_card_type' => $sale_pymnt_crdt_card_type,
                'sale_pymnt_crdt_card_month' => $sale_pymnt_crdt_card_month,
                'sale_pymnt_crdt_card_year' => $sale_pymnt_crdt_card_year,
                'sale_payment_type' => "custom",
                'float_id' => $this->session->userdata('ss_cashier_float_id'),
                'qutation_id' => $sale_id
            );
            if ($this->Sales_Model->save_sale_payments($data, $sale_pymnt_id)) {
                $st = array(
                    'status' => 1,
                    'validation' => 'Done!'
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
    public function save_sales_advance()
    {
        $this->load->model('stock_model');
        
        $sale_id           = $this->input->post('sale_id');
        //$sale_reference_no=$this->input->post('sale_reference_no');
        $query             = $this->Sales_Model->get_next_ref_no();
        $result            = $query->row();
        $sale_reference_no = sprintf("%05d", $result->sale_id + 1);
        $warehouse_id      = $this->input->post('warehouse_id');
        $uuidv4            = $this->input->post('uuidv4');
        $customer_id       = $this->input->post('customer_id');
        $rowCount          = $this->input->post('rowCount');
        $sale_datetime_1   = $this->input->post('sale_datetime');
        $sale_datetime     = date('Y-m-d H:i:s', strtotime($sale_datetime_1));
        $tax_rate_id       = $this->input->post('tax_rate_id');
        $sale_inv_discount = $this->input->post('sale_inv_discount');
        $sale_status       = $this->input->post('sale_status');
        $payment_status    = $this->input->post('payment_status');
        $sale_shipping     = $this->input->post('sale_shipping');
        $sale_payment_term = $this->input->post('sale_payment_term');
        $sale_total        = $this->input->post('sale_total');
        $sale_paid         = $this->input->post('sale_paid');
        $qts_id            = $this->input->post('qts_id');
        if ($sale_paid == "NaN")
            $sale_paid = 0;
        $sale_balance             = $this->input->post('sale_balance');
        $cost_total               = $this->input->post('cost_total');
        $in_type                  = $this->input->post('in_type');
        $sale_inv_discount_amount = $this->input->post('sale_inv_discount_amount');
        $sale_datetime_created    = date('Y-m-d H:i:s');
        $error                    = '';
        $disMsg                   = '';
        $lastid                   = '';
        $this->db->trans_start();
        if (!$error) {
            $data = array(
                'sale_id' => $sale_id,
                'sale_reference_no' => $sale_reference_no,
                'warehouse_id' => $warehouse_id,
                'customer_id' => $customer_id,
                'warehouse_id' => $warehouse_id,
                'sale_datetime' => $sale_datetime,
                //'tax_rate_id' => $tax_rate_id,
                'sale_inv_discount' => $sale_inv_discount,
                'sale_status' => $sale_status,
                //'payment_status' => $payment_status,
                'sale_shipping' => $sale_shipping,
                //'sale_payment_term' => $sale_payment_term,
                'sale_total' => $sale_total,
                //'sale_paid' => $sale_paid,
                'cost_total' => $cost_total,
                //'sale_balance' => $sale_balance,
                //'in_type' => $in_type,
                'sale_datetime_created' => $sale_datetime_created,
                'sale_inv_discount_amount' => $sale_inv_discount_amount,
                'qts_id' => $qts_id,
                'float_id' => $this->session->userdata('ss_cashier_float_id'),
                'dine_type' => 2,
                //'invoice_type'=>1,
                'user' => $this->session->userdata('ss_user_id')
            );
            $this->Sales_Model->save_sales($data);
            $lastid        = $sale_id; //$this->db->insert_id();
            /*$data_qutation = array(
                'sale_id' => $sale_id
            );
            $this->Sales_Model->update_advance_sale_payment($data_qutation, $qts_id);*/
            //insert user activity
            $this->Common_Model->add_user_activitie("Added Sale, (Invoice No:$sale_reference_no)");
            $disMsg    = 'Sale successfully added';
            //insert sale item data
            $row       = $this->input->post('row');
            $rowCount  = $this->input->post('rowCount');
            
            $movements_list = array();
            $recipe_having_items = array();
            
            $data_item = array();
            for ($i = 1; $i <= $rowCount; $i++) {
                //echo "/ $rowCount , Test:".$row[$i]['product_id'][0];
                if (isset($row[$i]['product_id'][0])) {
                    $data_item = array(
                        'sale_id' => $sale_id,
                        'product_id' => $row[$i]['product_id'][0],
                        'quantity' => $row[$i]['qty'][0],
                        'discount' => $row[$i]['discount'][0],
                        'unit_price' => $row[$i]['unit_price'][0],
                        'item_cost' => $row[$i]['item_cost'][0],
                        'unit_price' => $row[$i]['unit_price'][0] + $row[$i]['item_price_p'][0],
                        'discount_val' => $row[$i]['discount_val'][0],
                        'gross_total' => $row[$i]['gross_total'][0],
                        'float_id' => $this->session->userdata('ss_cashier_float_id')
                    );
                    $this->Sales_Model->save_sales_item($data_item);
                    $itemid = $this->db->insert_id();
                    
                    $data                  = array(
                        'location_id' => $warehouse_id,
                        'transaction_id' => $uuidv4,
                        'product_id' => $row[$i]['product_id'][0],
                        'quantity' => floatval($row[$i]['qty'][0]),
                        'unit_value' => floatval($row[$i]['unit_price'][0]),
                        'movement_type' => 'out',
                        'movement_date' => $sale_datetime,
                        'origin' => 'sale',
                        'origin_id' => $sale_id
                    );
                    $movements_list[]      = $data;
                    $recipe_having_items[] = array(
                        'product_id' => $row[$i]['product_id'][0],
                        'quantity' => floatval($row[$i]['qty'][0])
                    );
                    //insert user activity
                    $this->Common_Model->add_user_activitie("Added Sale Item, (Id:$itemid)");
                    //add reford for f4 table
                    $type      = 'sale';
                    $ref_id    = $sale_id;
                    $product   = $row[$i]['product_id'][0];
                    $quantity  = $row[$i]['qty'][0];
                    $unit_cost = $row[$i]['unit_price'][0];
                    // $this->Common_Model->add_fi_table($type, $ref_id, $product, $quantity, $unit_cost);
                }
            }
            if (!empty($recipe_having_items)) {
                foreach ($recipe_having_items as $itm) {
                    $recipe = $this->get_recipe($warehouse_id, $itm['product_id']);
                    if(!empty($recipe)){
                        foreach ($recipe as $rcp_itm) {
                            $data             = array(
                                'location_id' => $warehouse_id,
                                'transaction_id' => $uuidv4,
                                'product_id' => $rcp_itm->ingredient_id,
                                'quantity' => $rcp_itm->quantity * $itm['quantity'],
                                'unit_value' => floatval($rcp_itm->cost_per_item),
                                'movement_type' => 'out',
                                'movement_date' => $sale_datetime,
                                'origin' => 'consume',
                                'origin_id' => $sale_id
                            ); 
                            $movements_list[] = $data;
                        }
                    }
                }
            }
            if (!empty($movements_list)){
                $this->stock_model->bulkInsertMovements_($movements_list);
                //$queries[] = $this->db->last_query();
                //print_r($queries);
            }
            /*last update*/
            if($sale_total > 0){
                $total_paid_amount = $this->Sales_Model->get_total_paid_by_sale_id($sale_id);
                $total_advance_paid_amount = 0;
                
                $this->db->select('qts_id');
                $this->db->from('sales');
                $this->db->where('sale_id',$sale_id);
                $query = $this->db->get();
                
                $qts_id = $query->row()->qts_id;
                if($qts_id)
                    $total_advance_paid_amount = $this->Sales_Model->get_total_advance_by_qts_id($qts_id);
                
                $total_paid_amount += $total_advance_paid_amount;
                
                $return_tot_amt    = $this->Sales_Return_Model->get_total_return_by_sale_id($sale_id);
                $to_be_paid        = $sale_total - $return_tot_amt;
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
                );
                $this->db->where('sale_id',$sale_id);
                $this->db->update('sales', $update);
                //echo $this->db->last_query();
                
                /*update finance movement*/
                /*$data = array(
                    'transaction_date' => date('Y-m-d H:i:s'), // You can use any date format here
                    'transaction_type' => 'income', // Or 'expense' or 'transfer'
                    'transaction_method' => $sale_pymnt_paying_by, // cash / visa
                    'amount' => $sale_pymnt_amount,
                    'currency' => 'LKR',
                    'description' => 'Income from sales',
                    'reference_id' => $reference_id, // If there's no related transaction, set it to null
                    'created_by_user_id' => $user_id // Provide the user ID who initiated the transaction
                );
                $this->Common_Model->insert_transaction($data);*/
            }
            
            $this->db->trans_complete();
        } else {
            $disMsg = 'Please select these before adding any product:' . $disMsg;
        }
        
        if ($this->db->trans_status() === FALSE)
        {
            $this->session->set_flashdata('err_message', 'Error!');
            echo json_encode(array(
                'success' => false,
                'sale_id' => $lastid,
                'error' => $error,
                'disMsg' => $disMsg
            ));
        }
        else{ 
            $this->session->set_flashdata('message', 'Sale successfully added!');
            echo json_encode(array(
                'success' => true,
                'sale_id' => $lastid,
                'error' => $error,
                'disMsg' => $disMsg
            ));
        }
    }
    function duplicate_sale_check()
    {
        $this->load->model('Manual_Query_With_Grn_Model');
        $list = $this->Manual_Query_With_Grn_Model->duplicate_sale_list();
        foreach ($list as $row) {
            print_r($row);
            $updated_uniq_id = $row->uniq_id . "D" . rand(10, 100);
            $data            = array(
                'uniq_id' => $updated_uniq_id
            );
            $list            = $this->Manual_Query_With_Grn_Model->update_sale_master($row->sale_id, $data);
            echo "<br>";
        }
    }
    /**/
    
    public function credit_sales($customer_id="")
    {
        $data['main_menu_name'] = $this->main_menu_name;
        $data['sub_menu_name']  = 'credit_sales';
        $data['customer_type']  = $this->input->get('ct') ? $this->input->get('ct') : 2; 
        $data['customers_except']  = $this->input->get('ce') ? explode(',', $this->input->get('ce')) : array();
        $data['customer_list']  = $this->get_customers($data['customer_type']);
        $data['location_id']  = $this->input->get('li') ? $this->input->get('li') : $this->session->userdata('ss_warehouse_id');
        
        $data['month']  = $this->input->get('mo') ? $this->input->get('mo') : date("m"); 
        $this->load->model('User_Model');
        $data['sales']          = array(); //$this->Sales_Model->get_all_sales();
        $data['user_list']      = $this->User_Model->getUsers();
        $data['warehouse_list'] = $this->Warehouse_Model->get_all_warehouse();
        $data['sales_list']     = $this->get_credit_sale_by_cus_id($customer_id,$data['location_id'], $data['month'],$data['customer_type'],$data['customers_except']);
        $data['customer_id']    = $customer_id;
        $this->load->view('sales/credit_sales', $data);
    }
    public function list_credit_sales()
    {
        $requestData    = $this->input->post();
        $search_key     = $this->input->post('search');
        $search_key_val = $search_key['value'];
        $start          = $this->input->post('start');
        $length         = $this->input->post('length');
        $order          = $this->input->post('order');
        $columns        = $this->input->post('columns');
        $srh_from_date  = $this->input->post('srh_from_date');
        $srh_to_date    = $this->input->post('srh_to_date');
        $srh_user_id    = $this->input->post('srh_user_id');
        if ($srh_from_date) {
            $srh_from_date = date('Y-m-d H:i:s', strtotime($srh_from_date));
        }
        if ($srh_to_date) {
            $srh_to_date = date('Y-m-d H:i:s', strtotime($srh_to_date));
        }
        $columns       = array(
            0 => 'sale_id',
            1 => 'sale_reference_no',
            2 => 'sale_id',
            3 => 'sale_id',
            4 => 'sale_id',
            5 => 'sale_id'
        );
        $data          = array();
        $sales_tot     = $this->Sales_Model->get_all_sales_count($search_key_val, $srh_from_date, $srh_to_date, $srh_user_id);
        $sales         = $this->Sales_Model->get_all_sales($start, $length, $search_key_val, '', $order[0], $srh_from_date, $srh_to_date, $srh_user_id);
        $totalData     = $sales_tot;
        $totalFiltered = $totalData;
        foreach ($sales as $row) {
            $nestedData      = array();
            $sale_id         = $row['sale_id'];
            $order_yype_name = "";
            if ($row['dine_type'] == 1) {
                $order_yype_name = "DINE-IN";
            }
            if ($row['dine_type'] == 2) {
                $order_yype_name = "TAKE-AWAY";
            }
            $total_paid_amount = 0;
            $total_paid_amount = $this->Sales_Model->get_total_paid_by_sale_id($sale_id);
            $return_tot_amt    = 0;
            $return_tot_amt    = $this->Sales_Return_Model->get_total_return_by_sale_id($sale_id);
            $to_be_paid        = $row['sale_total'] - $return_tot_amt;
            $nestedData[]      = display_date_time_format($row['sale_datetime']);
            $nestedData[]      = $row['sale_reference_no'];
            $nestedData[]      = $row['cus_name'] . " | " . $order_yype_name;
            $nestedData[]      = $row['cashier'];
            $nestedData[]      = $row['waiter'];
            /*
            $nestedData[] = number_format($row['sale_total'], 2, '.', ',');
            $nestedData[] = number_format($total_paid_amount, 2, '.', ',');
            $nestedData[] = number_format($row['sale_total']-$total_paid_amount, 2, '.', ',');
            */
            $nestedData[]      = $row['sale_total'];
            $nestedData[]      = $return_tot_amt;
            $nestedData[]      = $to_be_paid;
            $nestedData[]      = $total_paid_amount;
            $nestedData[]      = $to_be_paid - $total_paid_amount;
            /*
            if($row['payment_status']=='Paid') {
                $nestedData[]='<span class="label label-sm label-success">'.$row['payment_status'].'</span>'; 
            }else {
                $nestedData[]=$row['payment_status'];
            }
            */
            if (empty($total_paid_amount)) {
                $pay_st = '<span class="label label-warning">Pending</span>';
            } else {
                if ($total_paid_amount >= $to_be_paid) {
                    $pay_st = '<span class="label label-success">Paid</span>';
                } else {
                    $pay_st = '<span class="label label-info">Partial</span>';
                }
            }
            if ($row['sale_status'] == 99) {
                $pay_st = '<span class="label label-danger">Canceled</span>';
            }
            $nestedData[]    = $pay_st;
            $style           = '';
            //$nestedData[] = $row['sale_id'];
            $actionTxtDisble = '';
            $actionTxtEnable = '';
            $actionTxtUpdate = '';
            $actionTxtDelete = '';
            if ($this->session->userdata('ss_group_id') == 1 | $this->session->userdata('ss_user_group_id') == 2) {
                $actionTxtDelete = ' <li style="' . $style . '"><a href="#" data-sale_id="'.$sale_id.'" onClick ="delete_invoice(this)"><i class="fa fa-trash-o"></i></i> Delete Invoice</a></li>                    
            <li style="' . $style . '"><a href="#" data-sale_id="'.$sale_id.'" onClick ="delete_payments(this)"><i class="fa fa-trash-o"></i>    Delete Payments</a></li>';
            }
            $url                  = base_url("sales/sale_details?sale_id=$sale_id");
            $actionTxtUpdate      = '<a data-sale_id="' . $row['sale_id'] . '" onClick="print_bill(this)" data-toggle="modal" href="#" class="btn btn-xs btn-blue tooltips" data-placement="top" data-original-title="Edit suppliers"><i class="clip-zoom-in-2"></i></a> &nbsp;';
            $actionTxtViewDetails = '<a href="' . base_url() . 'sales/view/' . $sale_id . '" class="btn btn-xs btn-blue tooltips" data-placement="top" data-original-title="Edit suppliers"><i class="fa fa-file-text-o"></i></a> &nbsp;';
            $nestedData[]         = '<div class="btn-group text-left">
                            <button data-toggle="dropdown" class="btn btn-default btn-xs btn-primary dropdown-toggle" type="button">Actions <span class="caret"></span></button>
                            <ul role="menu" class="dropdown-menu pull-right">
                            <li><a href="' . base_url() . 'sales/view/' . $sale_id . '"><i class="fa fa-file-text-o"></i> Sale Details</a></li>
                            <li><a data-sale_id="' . $row['sale_id'] . '" onClick="print_bill(this)" data-toggle="modal" href="#" data-placement="top" data-original-title="Edit suppliers"><i class="fa fa-print"></i> Print Sale</a></li>
                            <!-- <li><a href="' . base_url() . 'sales_return/sales_return_add/' . $sale_id . '"><i class="fa fa-angle-double-left"></i></i> Return Sale</a></li>-->
                           ' . $actionTxtDelete . '
                            </ul></div>';
            $data[]               = $nestedData;
        }
        $json_data = array(
            "draw" => intval($requestData['draw']),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );
        echo json_encode($json_data);
    }
    public function get_credit_sale_by_cus_id($customer_id, $warehouse_id, $month,$ct,$cus_except)
    {
        // Extracting the current year
        $currentYear = date('Y');
    
        // Adjusting the month value if it's less than 10 to have leading zero
        $month = str_pad($month, 2, '0', STR_PAD_LEFT);
    
        // Constructing the start and end date for the given month
        $startDate = "$currentYear-$month-01 00:00:00";
        $endDate = date('Y-m-t', strtotime($startDate)) . " 23:59:59";
    
        $this->db->select('s.*,c.cus_name');
        $this->db->from('sales s');
        //$this->db->join('sale_payments sp', 's.sale_id=sp.sale_id', 'left');
        $this->db->join('customer c', 'c.cus_id=s.customer_id', 'left');
        if($customer_id)
            $this->db->where("s.customer_id", $customer_id);
        
        if (!empty($cus_except)) {
            $this->db->where_not_in("s.customer_id", $cus_except);
        }
        
        if($ct)
            $this->db->where("c.cus_type_id", $ct);
            
        $this->db->where("s.warehouse_id", $warehouse_id);
        $this->db->where("s.payment_status != ", "paid");
        $this->db->where("s.sale_status != ", 99);
    
        // Adding the condition to filter by the given month
        $this->db->where("date(s.sale_datetime) >= ", $startDate);
        $this->db->where("date(s.sale_datetime) <= ", $endDate);
    
        $this->db->order_by("s.sale_datetime", "desc");
        /*$this->db->group_by("s.sale_id");*/
        $query = $this->db->get();
        /*echo $this->db->last_query();*/
        return $query->result();
    }

    function get_customers($cus_type_id) {
		$this->db->select('customer.*');
		$this->db->order_by("cus_name", "asc");
		$this->db->where("cus_status",1);//("id !=",$id);
		$this->db->where("cus_type_id",$cus_type_id);//("id !=",$id);
		//$this->db->where("cus_id", $id);
		$query = $this->db->get('customer');
		return $query->result_array();
	}
	public function save_batch_payments()
    {	
		$total_val					= $this->input->post('sale_pymnt_amount');
        $warehouse_id               = $this->input->post('warehouse_id');
        $sale_pymnt_paying_by       = $this->input->post('sale_pymnt_paying_by');
        $customer_id                = intval($this->input->post('customer_id'));
        $sale_pymnt_date_time       = date('Y-m-d H:i:s', strtotime($this->input->post('sale_pymnt_date_time')));
        $row                        = $this->input->post('row_c');
        $sale_note                = $this->input->post('sale_note');
		$user_id                    = $this->session->userdata('ss_user_id');
        $sale_pymnt_added_date_time = date("Y-m-d H:i:s");
        
        $data_item                  = array();
        
        $updates = array();
        $payments = array();
        if(!empty($row)){
            foreach($row as $r){
                if($r['amount'] > 0)
                    $payments[] = array(
                        'sale_id' => $r['sale_id'],
                        'sale_pymnt_amount' => floatval($r['amount']),
                        'sale_pymnt_paying_by' => $sale_pymnt_paying_by,
                        'user_id' => $user_id,
                        'sale_pymnt_added_date_time' => $sale_pymnt_added_date_time,
                        'sale_payment_type' => 'sale',
                        'sale_pymnt_date_time' => $sale_pymnt_date_time,
                        'sale_pymnt_note' => $sale_note,
                        'sale_pymnt_cheque_no' => '',
                        'sale_pymnt_crdt_card_no' => '',
                        'sale_pymnt_crdt_card_holder_name' => '',
                        'sale_pymnt_crdt_card_type' => '',
                        'sale_pymnt_crdt_card_month' => '',
                        'sale_pymnt_crdt_card_year' => ''
                    );
                    $updates[] = $r['sale_id'];
            }
        }
        $this->db->trans_start();
        
        if(!empty($payments)){
            $this->db->insert_batch('sale_payments',$payments);
        }
        
        if(!empty($updates)){
            foreach($updates as $sale_id){
                $this->db->select('sales.sale_total');
                $this->db->from('sales');
                $this->db->where("sales.sale_id", $sale_id);  
                $query = $this->db->get();
                $sale_total = $query->row()->sale_total;
                
                $this->update_paid_status($sale_id,$sale_total);
            }
        }
        
        $this->db->trans_complete();
        //$this->Common_Model->update_list();
        $disMsg = '';
        $trans_status = $this->db->trans_status();
        
        if ($trans_status == FALSE) {
            echo json_encode(array(
                'error' => 1,
                'disMsg' => $this->db->last_query()
            ));
        } else {
            echo json_encode(array(
                'error' => 0,
                'disMsg' => $disMsg
            ));
        }
        exit;
    }
    
    public function update_list()
    {
        $sales         = $this->get_credit_sales();
        foreach ($sales as $row) {
            $nestedData      = array();
            $sale_id         = $row['sale_id'];
            $order_yype_name = "";
            if ($row['dine_type'] == 1) {
                $order_yype_name = "DINE-IN";
            }
            if ($row['dine_type'] == 2) {
                $order_yype_name = "TAKE-AWAY";
            }

            $total_paid_amount = $this->Sales_Model->get_total_paid_by_sale_id($sale_id);
            $total_advance_paid_amount = 0;
            
            if($row['qts_id'])
                $total_advance_paid_amount = $this->Sales_Model->get_total_advance_by_qts_id($row['qts_id']);
                
            $total_paid_amount += $total_advance_paid_amount;
            
            $return_tot_amt    = $this->Sales_Return_Model->get_total_return_by_sale_id($sale_id);
            $to_be_paid        = $row['sale_total'] - $return_tot_amt;
            $balance = $to_be_paid - $total_paid_amount;
            
            $nestedData[]      = display_date_time_format($row['sale_datetime']);
            $nestedData[]      = $row['sale_reference_no'];
            $nestedData[]      = $row['cus_name'] . " | " . $order_yype_name;
            $nestedData[]      = $row['sale_total'];
            $nestedData[]      = $return_tot_amt;
            $nestedData[]      = $to_be_paid;
            $nestedData[]      = $total_paid_amount;
            $nestedData[]      = $balance;
            
            
            
            //print_r($nestedData);
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
            );
            $this->db->where('sale_id',$sale_id);
            if($this->db->update('sales',$update)){
                echo "<pre> Updated!: $sale_id"; echo "</pre>";
            }else{
                echo "<pre> Error!";
                print_r($nestedData);
                echo "</pre>";
            }
        }
    }
    function get_credit_sales()
    {
        $this->db->select('sales.*, customer.cus_name');
        $this->db->select('u.user_first_name as cashier');
        $this->db->select('w.user_first_name as waiter');
        $this->db->from('sales');
        $this->db->join('user u', 'sales.user = u.user_id', 'left');
        $this->db->join('user w', 'sales.waiter_id = w.user_id', 'left');
        $this->db->join('customer', 'sales.customer_id = customer.cus_id', 'left');
        $this->db->where("sales.payment_status != ", "paid"); 
        $this->db->order_by("sales.sale_datetime", "desc"); 
        $query = $this->db->get();
        return $query->result_array();
    }
}