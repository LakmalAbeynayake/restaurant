<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Quotations extends CI_Controller
{
    var $main_menu_name = "quotations";
    var $sub_menu_name = "quotations";
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Quotations_Model');
        $this->load->model('Supplier_Model');
        $this->load->model('Warehouse_Model');
        $this->load->model('Common_Model');
        $this->load->model('Tax_Rates_Model');
        $this->load->model('Customer_Model');
    }
    //Quotations list page load
    public function index()
    {
        /*$data['quotations']     = $this->Quotations_Model->get_all_quotations();*/
        $data['main_menu_name'] = $this->main_menu_name;
        $data['sub_menu_name']  = $this->sub_menu_name;
        $data['warehouse_list'] = $this->Warehouse_Model->get_all_warehouse();
        $this->load->view('quotations/quotations', $data);
    }
    //Quotations details view
    public function view()
    {
        $this->load->model('Sales_Model');
        $data['main_menu_name']     = $this->main_menu_name;
        $data['sub_menu_name']      = '';
        //get sale id
        $qts_id                     = $this->uri->segment('3');
        $data['qts_item_list']      = $this->Quotations_Model->get_qts_item_list_by_qts_id($qts_id);
        $data['qts_details']        = $this->Quotations_Model->get_qts_info($qts_id);
        $data['customer_details']   = $this->Customer_Model->get_customer_info($data['qts_details']['customer_id']);
        $data['warehouse_details']  = $this->Warehouse_Model->get_warehouse_info($data['qts_details']['warehouse_id']);
        $data['sale_payments_list'] = $this->Sales_Model->get_advance_qty_sale_payments_by_sale_id($qts_id);
        $data['qts_id']             = $qts_id;
        $this->load->view('quotations/quotations_view', $data);
    }
    //Quotations add page
    public function add_qts_payments()
    {
        $qts_pymnt_amount                = $this->input->post('qts_pymnt_amount');
        $qts_id                          = $this->input->post('qts_id');
        $qts_pymnt_ref_no                = $this->input->post('qts_pymnt_ref_no');
        $qts_pymnt_paying_by             = $this->input->post('qts_pymnt_paying_by');
        $qts_pymnt_date_time             = $this->input->post('qts_pymnt_date_time');
        $qts_pymnt_date_time_send        = date('Y-m-d H:i:s', strtotime($qts_pymnt_date_time));
        $qts_pymnt_cheque_no             = $this->input->post('qts_pymnt_cheque_no');
        $qts_pymnt_crdt_card_no          = $this->input->post('qts_pymnt_crdt_card_no');
        $qts_pymnt_crdt_card_holder_name = $this->input->post('qts_pymnt_crdt_card_holder_name');
        $qts_pymnt_crdt_card_month       = $this->input->post('qts_pymnt_crdt_card_month');
        $qts_pymnt_crdt_card_year        = $this->input->post('qts_pymnt_crdt_card_year');
        $qts_pymnt_crdt_card_type        = $this->input->post('qts_pymnt_crdt_card_type');
        $qts_type                        = $this->input->post('qts_type');
        $qts_pymnt_note                  = $this->input->post('qts_pymnt_note');
        $user_id                         = $this->session->userdata('ss_user_id');
        $qts_pymnt_added_date_time       = date("Y-m-d H:i:s");
        $qts_pymnt_id                    = '';
        $this->load->library('form_validation'); //form validation lib
        $this->form_validation->set_rules('qts_pymnt_amount', 'Amount', 'required');
        if ($qts_pymnt_paying_by == 'Credit Card') {
            $this->form_validation->set_rules('qts_pymnt_crdt_card_type', 'Card Type', 'required');
            $this->form_validation->set_rules('qts_pymnt_crdt_card_no', 'Credit Card No', 'required');
            $this->form_validation->set_rules('qts_pymnt_crdt_card_holder_name', 'Holder Name', 'required');
            $this->form_validation->set_rules('qts_pymnt_crdt_card_month', 'Month', 'required');
            $this->form_validation->set_rules('qts_pymnt_crdt_card_year', 'Year', 'required');
        }
        if ($qts_pymnt_paying_by == 'Cheque') {
            $this->form_validation->set_rules('qts_pymnt_cheque_no', 'Cheque No', 'required');
        }
        $this->form_validation->set_rules('qts_id', 'System Error', 'required');
        if ($this->form_validation->run() == FALSE) {
            $st = array(
                'status' => 0,
                'validation' => validation_errors()
            );
            echo json_encode($st);
        } else {
            $data = array(
                'qts_pymnt_amount' => $qts_pymnt_amount,
                'qts_pymnt_ref_no' => $qts_pymnt_ref_no,
                'qts_pymnt_paying_by' => $qts_pymnt_paying_by,
                'qts_pymnt_date_time' => $qts_pymnt_date_time_send,
                'qts_pymnt_note' => $qts_pymnt_note,
                'user_id' => $user_id,
                'qts_id' => $qts_id,
                'qts_pymnt_added_date_time' => $qts_pymnt_added_date_time,
                'qts_pymnt_cheque_no' => $qts_pymnt_cheque_no,
                'qts_pymnt_crdt_card_no' => $qts_pymnt_crdt_card_no,
                'qts_pymnt_crdt_card_holder_name' => $qts_pymnt_crdt_card_holder_name,
                'qts_pymnt_crdt_card_type' => $qts_pymnt_crdt_card_type,
                'qts_pymnt_crdt_card_month' => $qts_pymnt_crdt_card_month,
                'qts_pymnt_crdt_card_year' => $qts_pymnt_crdt_card_year,
                'qts_payment_type' => $qts_type
            );
            if ($this->Quotations_Model->save_qts_payments($data, $qts_pymnt_id)) {
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
    //Quotations payment page 
    public function payments()
    {
        $data['qts_id']   = $this->input->get('id');
        $data['qts_type'] = $this->input->get('qts_type');
        $this->load->view('models/quotations_payment', $data);
    }
    //Quotations save 
    //Quotations item save
    //Add quotations items to 54 table
    public function save_quotations()
    {
        $qts_id        = $this->input->post('qts_id');
        $qts_reference_no        = $this->input->post('qts_reference_no') ? $this->input->post('qts_reference_no') : $this->get_next_ref_no_();
        $warehouse_id            = $this->input->post('warehouse_id');
        $customer_id             = $this->input->post('customer_id');
        $rowCount                = $this->input->post('rowCount');
        $qts_datetime_1          = $this->input->post('qts_datetime');
        $qts_datetime            = date('Y-m-d H:i:s', strtotime($qts_datetime_1));
        $qts_inv_discount        = $this->input->post('qts_inv_discount');
        $qts_total               = $this->input->post('qts_total');
        $qts_inv_discount_amount = $this->input->post('qts_inv_discount_amount');
        $qts_datetime_created    = date('Y-m-d H:i:s');
        $error                   = '';
        $disMsg                  = '';
        $lastid                  = '';
        if (!$error) {
            $data      = array(
                'qts_reference_no' => $qts_reference_no,
                'warehouse_id' => $warehouse_id,
                'customer_id' => $customer_id,
                'warehouse_id' => $warehouse_id,
                'qts_datetime' => $qts_datetime,
                'qts_inv_discount' => $qts_inv_discount,
                'qts_total' => $qts_total,
                'qts_datetime_created' => $qts_datetime_created,
                'qts_inv_discount_amount' => $qts_inv_discount_amount,
                'user_id' => $this->session->userdata('ss_user_id')
            );
            $qqts_id = $qts_id ? $qts_id : '';
            $this->db->trans_start();
            $_insert   = $this->Quotations_Model->save_quotations($data, $qts_id);
            /*echo $this->db->last_query();*/
            $lastid    = $this->db->insert_id() ? $this->db->insert_id() : $qqts_id;
            $qts_id    = $lastid ? $lastid : $qqts_id;
            $data['qts_id'] = $qts_id;
            $this->db->insert('quotations_log',$data);
            $disMsg    = 'Successfully added';
            //insert sale item data
            $row       = $this->input->post('row');
            
            if($qts_id > 0){
                $this->db->where("qts_id",$qts_id);
                $this->db->delete("quotations_items");
            }
            foreach($row as $i=>$r){
                
                if (isset($r['product_id'])) {
                    $data_item = array(
                        'qts_id' => $qts_id,
                        'product_id' => $r['product_id'],
                        'quantity' => $r['qty'],
                        'discount' => $r['discount'],
                        'unit_price' => $r['unit_price'] + $r['item_price_p'],
                        'discount_val' => $r['discount_val'],
                        'gross_total' => $r['gross_total']
                    );
                    $this->Quotations_Model->save_quotations_item($data_item,$qts_id);
                    //add reford for f4 table
                    $type      = 'sale';
                    $ref_id    = $qts_id;
                    $product   = $r['product_id'];
                    $quantity  = $r['qty'];
                    $unit_cost = $r['unit_price'];
                    $this->Common_Model->add_fi_table($type, $ref_id, $product, $quantity, $unit_cost);
                }
            }
            $this->db->trans_complete();
            
            if ($this->db->trans_status() === FALSE){
                $error = 1;
            }else{
                $error = 0;
            }

        } else {
            $disMsg = 'Please select these before adding any product:' . $disMsg;
        }
        $this->session->set_flashdata('message', 'Quotation successfully added!');
        echo json_encode(array(
            'qts_id' => $lastid,
            'error' => $error,
            'disMsg' => $disMsg
        ));
    }
    //Quotations reference no jenarate    
    public function get_next_ref_no()
    {
        $query            = $this->Quotations_Model->get_next_ref_no();
        $result           = $query->row();
        //print_r($result);
        $qts_reference_no = sprintf("%05d", $result->qts_id + 1);
        $qts_reference_no = $qts_reference_no;
        echo json_encode(array(
            'qts_reference_no' => $qts_reference_no
        ));
    }
    function get_next_ref_no_()
    {
        $query            = $this->Quotations_Model->get_next_ref_no();
        $result           = $query->row();
        //print_r($result);
        $qts_reference_no = sprintf("%05d", $result->qts_id + 1);
        return $qts_reference_no;
    }
    //Quotations ger avalable product qty
    public function get_avalable_product_qty()
    {
        $product_id    = $this->input->get('product_id');
        $warehouse_id  = $this->input->get('warehouse_id');
        $data['total'] = $this->Quotations_Model->get_avalable_product_qty($product_id, $warehouse_id);
        echo json_encode(array(
            'remmnaingQty' => $data['total']
        ));
    }
    //Quotations add form
    public function quotations_add($qts_id="")
    {
        $data['main_menu_name'] = $this->main_menu_name;
        $data['sub_menu_name']  = 'quotations_add';
        //get suppliers list
        $data['suppliers']      = $this->Supplier_Model->get_all_supplier();
        $data['warehouse_list'] = $this->Warehouse_Model->get_all_warehouse();
        $data['tax_rates_list'] = $this->Tax_Rates_Model->get_all_tax_rates();
        $data['customer_list']  = $this->Customer_Model->get_all_customers();
        $data['status_list']    = $this->Common_Model->get_all_status();
        $data['qts_item_list']  = array();
        //$data['qts_details']    = array();
        $data['customer_details']   = array();
        if($qts_id){
            $data['qts_item_list']      = $this->Quotations_Model->get_qts_item_list_by_qts_id($qts_id);
            $data['qts_details']        = $this->Quotations_Model->get_qts_info($qts_id);
            $data['customer_details']   = $this->Customer_Model->get_customer_info($data['qts_details']['customer_id']);
            /*echo "<pre>";
                print_r($data['qts_item_list']);
                print_r($data['qts_details']);
            echo "</pre>";*/
        }
        $this->load->view('quotations/quotations_add', $data);
    }
    //Quotations product items get
    public function suggestions($value = '')
    {
        $term               = $this->input->get('term');
        $data['quotations'] = $this->Quotations_Model->get_products_suggestions($term);
        $json               = array();
        foreach ($data['quotations'] as $row) {
            $product_name            = $row['product_name'];
            $product_code            = $row['product_code'];
            $product_part_no         = $row['product_part_no'];
            $product_oem_part_number = $row['product_oem_part_number'];
            $product_id              = $row['product_id'];
            $product_price           = $row['product_price'];
            $sendParameters          = "'$product_id','$product_name','$product_code','$product_price'";
            $sendParameters          = "$product_id,$product_name,$product_code,$product_price";
            $extraName               = '';
            $extraName .= ", Selling Price: " . number_format($product_price, 2, '.', ',');
            if ($product_part_no)
                $extraName .= ", Part No: $product_part_no";
            if ($product_oem_part_number)
                $extraName .= ", OEM Part No: $product_oem_part_number";
            $json_itm = array(
                'id' => $row['product_id'],
                'product_id' => $row['product_id'],
                'product_code' => $row['product_code'],
                'product_name' => $row['product_name'],
                'product_price' => $row['product_price'],
                'product_part_no' => $row['product_part_no'],
                'product_oem_part_number' => $row['product_oem_part_number'],
                'value' => $row['product_name'] . " (" . $row['product_code'] . ")",
                'label' => $row['product_name'] . " (" . $row['product_code'] . ")$extraName"
            );
            array_push($json, $json_itm);
        }
        echo json_encode($json);
    }
    //Sale details page
    public function qts_details()
    {
        $this->load->model('Sales_Model');
        $qts_id                     = $this->input->get('qts_id');
        $data['qts_details']        = $this->Quotations_Model->get_qts_info($qts_id);
        //get sale item list
        $data['qts_item_list']      = $this->Quotations_Model->get_qts_item_list_by_qts_id($qts_id);
        $data['customer_details']   = $this->Customer_Model->get_customer_info($data['qts_details']['customer_id']);
        $data['warehouse_details']  = $this->Warehouse_Model->get_warehouse_info($data['qts_details']['warehouse_id']);
        $data['sale_payments_list'] = $this->Sales_Model->get_advance_qty_sale_payments_by_sale_id($qts_id);
        $data['cr_limit_list']      = $this->Common_Model->get_all_cr_limit();
        $this->load->view('models/quotations_print', $data);
    }
    //Quotations list
    public function list_quotations()
    {
        
        $location_id = $this->input->post('location_id');
        $sf          = $this->input->post('sf');
        
        $requestData   = $_REQUEST;
        $columns       = array(
            0 => 'qts_id',
            1 => 'qts_id',
            2 => 'qts_id',
            3 => 'qts_id',
            4 => 'qts_id',
            5 => 'qts_id'
        );
        $data          = array();
        
        $quotations    = $this->Quotations_Model->get_all_quotations($location_id,$sf);
        $totalData     = count($quotations);
        $totalFiltered = $totalData;
        foreach ($quotations as $row) {
            $nestedData           = array();
            $qts_id               = $row['qts_id'];
            $total_paid_amount    = '';
            $nestedData[]         = display_date_time_format($row['qts_datetime']);
            $nestedData[]         = $row['qts_reference_no'];
            $nestedData[]         = $row['cus_name'];
            $nestedData[]         = number_format($row['qts_total'], 2, '.', ',');
            //$nestedData[] = $row['qts_id'];
            $actionTxtDisble      = '';
            $actionTxtEnable      = '';
            $actionTxtUpdate      = '';
            $actionTxtDelete      = '';
            $url                  = base_url("quotations/qts_details?qts_id=$qts_id");
            $actionTxtUpdate      = '<a onClick="fbs_click(' . $row['qts_id'] . ')" data-toggle="modal" href="#" class="btn btn-xs btn-blue tooltips" data-placement="top" data-original-title="Edit suppliers"><i class="clip-zoom-in-2"></i></a> &nbsp;';
            $actionTxtViewDetails = '<a href="' . base_url() . 'quotations/view/' . $qts_id . '" class="btn btn-xs btn-blue tooltips" data-placement="top" data-original-title="Edit suppliers"><i class="fa fa-file-text-o"></i></a> &nbsp;';
            $nv_qty               = '';
            $can_qtt                = '';
            if ($this->session->userdata('ss_group_id') < 4) {
                $nv_qty = '<li><a href="' . base_url() . 'quotations/invoice_qutation?id=' . $qts_id . '"><i class="fa fa-shopping-cart"></i>Invoice Quotation</a></li>';
                $nv_qty .= '<li><a href="#" onclick="finish_qutation(' . $qts_id . ')"><i class="fa fa-check"></i>Finish Quotation</a></li>';
            }
            if ($this->session->userdata('ss_group_id') == 1) {
                $can_qtt = '<li><a href="#" onclick="cancel_qutation(' . $qts_id . ')"><i class="fa fa-ban"></i>Cancel Quotation</a></li>';
            }
            $nestedData[] = '<div class="btn-group text-left">
                            <button data-toggle="dropdown" class="btn btn-default btn-xs btn-primary dropdown-toggle" type="button">Actions <span class="caret"></span></button>
                            <ul role="menu" class="dropdown-menu pull-right">
                            <li><a href="' . base_url() . 'quotations/view/' . $qts_id . '"><i class="fa fa-file-text-o"></i> Quotation Details</a></li>
                            <li><a onClick="fbs_click(' . $row['qts_id'] . ')" data-toggle="modal" href="#" data-placement="top" data-original-title="Edit suppliers"><i class="fa fa-print"></i> Print Quotation</a></li>
                            ' . $nv_qty . $can_qtt . '
                            </ul></div>';
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
    public function invoice_qutation()
    {
        $data['main_menu_name'] = $this->main_menu_name;
        $data['sub_menu_name']  = 'add_sales';
        //get suppliers list
        $id                     = $this->input->get('id');
        $data['qts_item_list']  = $this->Quotations_Model->get_qts_item_list_by_qts_id($id);
        $data['qts_details']    = $this->Quotations_Model->get_qts_info($id);
        $data['suppliers']      = $this->Supplier_Model->get_all_supplier();
        $data['warehouse_list'] = $this->Warehouse_Model->get_all_warehouse();
        $data['tax_rates_list'] = $this->Tax_Rates_Model->get_all_tax_rates();
        $data['customer_list']  = $this->Customer_Model->get_all_customers();
        $data['status_list']    = $this->Common_Model->get_all_status();
        $this->load->view('quotations/add_sales_quotation', $data);
    }
    public function finish_qutation()
    {
        $id   = $this->input->get('id');
        $data = array(
            'qutation_status' => 2,
            'updated_on' => date('Y-m-d H:i:s'),
            'updated_by' => $this->session->userdata('ss_user_id')
        );
        $this->Quotations_Model->update_quotations($id, $data);
        echo json_encode(array(
            'status' => 1
        ));
    }
    public function cancel_qutation()
    {
        $this->load->model('Sales_Model');
        $id   = $this->input->get('id');
        
        /*check payments*/
        /*if($id){
            $pymnts = $this->Sales_Model->get_advance_qty_sale_payments_by_sale_id($id);
            $tot_adv = 0;
            if(!empty($pymnts))
                foreach($pymnts as $pymnt){
                    $tot_adv += $pymnt->sale_pymnt_amount;
                }
            if($tot_adv > 0){
                $pmData = array(
                    'sale_id' => $sale_id,
                    'sale_pymnt_paying_by' => "cash",
                    'sale_pymnt_amount' => $tot_adv,
                    'sale_pymnt_date_time' => date("Y-m-d H:i:s A"),
                    'sale_pymnt_added_date_time' => date("Y-m-d H:i:s A"),
                    'sale_pymnt_crdt_card_no' => '',
                    'sale_pymnt_crdt_card_holder_name' => '',
                    'sale_pymnt_crdt_card_type' => '',
                    'sale_payment_type' => 'quotation_refund',
                    'sale_pymnt_given_amount' => $tot_adv,
                    'sale_pymnt_balance_amount' => 0,
                    'user_id' => $this->session->userdata('ss_user_id'),
                    'float_id' => $this->session->userdata('ss_cashier_float_id')
                );
                $this->db->insert('sale_payments', $pmData);
            }
        }*/
        $data = array(
            'qutation_status' => 3,
            'updated_on' => date('Y-m-d H:i:s'),
            'updated_by' => $this->session->userdata('ss_user_id')
        );
        $this->Quotations_Model->update_quotations($id, $data);
        echo json_encode(array(
            'status' => 1
        ));
    }
}