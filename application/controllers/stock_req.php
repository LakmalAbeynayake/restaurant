<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Stock_req extends CI_Controller
{
    var $main_menu_name = "stock_req";
    var $sub_menu_name = "stock_req";
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Common_Model');
        $this->load->model('Sr_Model');
        $this->load->model('Supplier_Model');
        $this->load->model('Warehouse_Model');
        $this->load->model('Common_Model');
        $this->load->model('Tax_Rates_Model');
        $this->load->model('Customer_Model');
    }
    //Stock_req list page load
    public function index()
    {
        /*$data['stock_req'] = $this->Sr_Model->get_all_sr();*/
        $data['main_menu_name'] = $this->main_menu_name;
        $data['sub_menu_name']  = $this->sub_menu_name;
        $this->load->view('stock_req/stock_req', $data);
    }
    //Stock_req details view
    public function view()
    {
        $this->load->model('Sales_Model');
        $data['main_menu_name']     = $this->main_menu_name;
        $data['sub_menu_name']      = '';
        //get sale id
        $sr_id                      = $this->uri->segment('3');
        $data['qts_item_list']       = $this->Sr_Model->get_sr_item_list_by_sr_id($sr_id);
        $data['qts_details']         = $this->Sr_Model->get_sr_info($sr_id);
        $data['customer_details']   = array();//$this->Customer_Model->get_customer_info($data['sr_details']['customer_id']);
        $data['warehouse_details']  = $this->Warehouse_Model->get_warehouse_info($data['qts_details']['warehouse_id']);
        $data['sale_payments_list'] = $this->Sales_Model->get_advance_qty_sale_payments_by_sale_id($sr_id);
        $data['sr_id']              = $sr_id;
        $this->load->view('stock_req/stock_req_view', $data);
    }
    //Stock_req add page
    public function add_sr_payments()
    {
        $sr_pymnt_amount                = $this->input->post('sr_pymnt_amount');
        $sr_id                          = $this->input->post('sr_id');
        $sr_pymnt_ref_no                = $this->input->post('sr_pymnt_ref_no');
        $sr_pymnt_paying_by             = $this->input->post('sr_pymnt_paying_by');
        $sr_pymnt_date_time             = $this->input->post('sr_pymnt_date_time');
        $sr_pymnt_date_time_send        = date('Y-m-d H:i:s', strtotime($sr_pymnt_date_time));
        $sr_pymnt_cheque_no             = $this->input->post('sr_pymnt_cheque_no');
        $sr_pymnt_crdt_card_no          = $this->input->post('sr_pymnt_crdt_card_no');
        $sr_pymnt_crdt_card_holder_name = $this->input->post('sr_pymnt_crdt_card_holder_name');
        $sr_pymnt_crdt_card_month       = $this->input->post('sr_pymnt_crdt_card_month');
        $sr_pymnt_crdt_card_year        = $this->input->post('sr_pymnt_crdt_card_year');
        $sr_pymnt_crdt_card_type        = $this->input->post('sr_pymnt_crdt_card_type');
        $sr_type                        = $this->input->post('sr_type');
        $sr_pymnt_note                  = $this->input->post('sr_pymnt_note');
        $user_id                        = $this->session->userdata('ss_user_id');
        $sr_pymnt_added_date_time       = date("Y-m-d H:i:s");
        $sr_pymnt_id                    = '';
        $this->load->library('form_validation'); //form validation lib
        $this->form_validation->set_rules('sr_pymnt_amount', 'Amount', 'required');
        if ($sr_pymnt_paying_by == 'Credit Card') {
            $this->form_validation->set_rules('sr_pymnt_crdt_card_type', 'Card Type', 'required');
            $this->form_validation->set_rules('sr_pymnt_crdt_card_no', 'Credit Card No', 'required');
            $this->form_validation->set_rules('sr_pymnt_crdt_card_holder_name', 'Holder Name', 'required');
            $this->form_validation->set_rules('sr_pymnt_crdt_card_month', 'Month', 'required');
            $this->form_validation->set_rules('sr_pymnt_crdt_card_year', 'Year', 'required');
        }
        if ($sr_pymnt_paying_by == 'Cheque') {
            $this->form_validation->set_rules('sr_pymnt_cheque_no', 'Cheque No', 'required');
        }
        $this->form_validation->set_rules('sr_id', 'System Error', 'required');
        if ($this->form_validation->run() == FALSE) {
            $st = array(
                'status' => 0,
                'validation' => validation_errors()
            );
            echo json_encode($st);
        } else {
            $data = array(
                'sr_pymnt_amount' => $sr_pymnt_amount,
                'sr_pymnt_ref_no' => $sr_pymnt_ref_no,
                'sr_pymnt_paying_by' => $sr_pymnt_paying_by,
                'sr_pymnt_date_time' => $sr_pymnt_date_time_send,
                'sr_pymnt_note' => $sr_pymnt_note,
                'user_id' => $user_id,
                'sr_id' => $sr_id,
                'sr_pymnt_added_date_time' => $sr_pymnt_added_date_time,
                'sr_pymnt_cheque_no' => $sr_pymnt_cheque_no,
                'sr_pymnt_crdt_card_no' => $sr_pymnt_crdt_card_no,
                'sr_pymnt_crdt_card_holder_name' => $sr_pymnt_crdt_card_holder_name,
                'sr_pymnt_crdt_card_type' => $sr_pymnt_crdt_card_type,
                'sr_pymnt_crdt_card_month' => $sr_pymnt_crdt_card_month,
                'sr_pymnt_crdt_card_year' => $sr_pymnt_crdt_card_year,
                'sr_payment_type' => $sr_type
            );
            if ($this->Sr_Model->save_sr_payments($data, $sr_pymnt_id)) {
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
    //Stock_req payment page 
    public function payments()
    {
        $data['sr_id']   = $this->input->get('id');
        $data['sr_type'] = $this->input->get('sr_type');
        $this->load->view('models/sr_payment', $data);
    }
    //Stock_req save 
    //Stock_req item save
    //Add stock_req items to 54 table
    
    function save_quotations(&$supplier_data, $qts_id = false)
    {
        if (!$qts_id) {
            
        } else {
            $this->db->where("qts_id", $qts_id);
            return $this->db->update($this->tableName, $supplier_data);
        }
    }
    //Sales item save
    function save_quotations_item(&$data_item)
    {
        $this->db->insert("quotations_items", $data_item);
    }
    
    //Stock_req reference no jenarate    
    public function get_next_ref_no()
    {
        $query           = $this->get_next_ref_no_();
        $result          = $query->row();
        //print_r($result);
        $sr_reference_no = sprintf("%05d", $result->req_id + 1);
        $sr_reference_no = $sr_reference_no;
        echo json_encode(array(
            'req_reference_no' => $sr_reference_no
        ));
    }
    //Stock_req ger avalable product qty
    public function get_avalable_product_qty()
    {
        $product_id    = $this->input->get('product_id');
        $warehouse_id  = $this->input->get('warehouse_id');
        $data['total'] = $this->Sr_Model->get_avalable_product_qty($product_id, $warehouse_id);
        echo json_encode(array(
            'remmnaingQty' => $data['total']
        ));
    }
    //Stock_req add form
    public function add()
    {
        $data['main_menu_name'] = $this->main_menu_name;
        $data['sub_menu_name']  = 'sr_add';
        //get suppliers list
        $data['suppliers']      = $this->Supplier_Model->get_all_supplier();
        $data['warehouse_list'] = $this->Warehouse_Model->get_all_warehouse();
        $data['tax_rates_list'] = $this->Tax_Rates_Model->get_all_tax_rates();
        $data['customer_list']  = $this->Customer_Model->get_all_customers();
        $data['status_list']    = $this->Common_Model->get_all_status();
        $this->load->view('stock_req/stock_req_add', $data);
    }
    function get_next_ref_no_()
    {
        $this->db->select_max("req_id");
        return $this->db->get("stock_requisitions");
    }
    //Stock_req product items get
    public function suggestions($value = '')
    {
        $term              = $this->input->get('term');
        $data['stock_req'] = $this->Sr_Model->get_products_suggestions($term);
        $json              = array();
        foreach ($data['stock_req'] as $row) {
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
    public function sr_details()
    {
        $this->load->model('Sales_Model');
        $sr_id                      = $this->input->get('sr_id');
        $data['sr_details']         = $this->Sr_Model->get_sr_info($sr_id);
        //get sale item list
        $data['sr_item_list']       = $this->Sr_Model->get_sr_item_list_by_sr_id($sr_id);
        $data['customer_details']   = $this->Customer_Model->get_customer_info($data['sr_details']['customer_id']);
        $data['warehouse_details']  = $this->Warehouse_Model->get_warehouse_info($data['sr_details']['warehouse_id']);
        $data['sale_payments_list'] = $this->Sales_Model->get_advance_qty_sale_payments_by_sale_id($sr_id);
        $data['cr_limit_list']      = $this->Common_Model->get_all_cr_limit();
        $this->load->view('models/sr_print', $data);
    }
    //Stock_req list
    public function list_sr()
    {
        $requestData   = $_REQUEST;
        $columns       = array(
            0 => 'sr_id',
            1 => 'sr_id',
            2 => 'sr_id',
            3 => 'sr_id',
            4 => 'sr_id',
            5 => 'sr_id'
        );
        $data          = array();
        $stock_req     = $this->Sr_Model->get_all_stock_requisitions();
        $totalData     = count($stock_req);
        $totalFiltered = $totalData;
        foreach ($stock_req as $row) {
            $nestedData           = array();
            $sr_id                = $row['req_id'];
            $total_paid_amount    = '';
            $nestedData[]         = display_date_time_format($row['req_datetime']);
            $nestedData[]         = $row['req_reference_no'];
            $nestedData[]         = $row['reqesting_for_date'];
            $nestedData[]         = $row['req_note'];
            //$nestedData[] = $row['sr_id'];
            $actionTxtDisble      = '';
            $actionTxtEnable      = '';
            $actionTxtUpdate      = '';
            $actionTxtDelete      = '';
            $url                  = base_url("stock_req/sr_details?sr_id=$sr_id");
            $actionTxtUpdate      = '<a onClick="fbs_click(' . $row['req_id'] . ')" data-toggle="modal" href="#" class="btn btn-xs btn-blue tooltips" data-placement="top" data-original-title="Edit suppliers"><i class="clip-zoom-in-2"></i></a> &nbsp;';
            $actionTxtViewDetails = '<a href="' . base_url() . 'stock_req/view/' . $sr_id . '" class="btn btn-xs btn-blue tooltips" data-placement="top" data-original-title="Edit suppliers"><i class="fa fa-file-text-o"></i></a> &nbsp;';
            $nv_qty               = '';
            if ($this->session->userdata('ss_group_id') < 4) {
                $nv_qty = '<li><a href="' . base_url() . 'stock_req/invoice_qutation?id=' . $sr_id . '"><i class="fa fa-shopping-cart"></i>Invoice Quotation</a></li>';
                $nv_qty .= '<li><a href="#" onclick="finish_qutation(' . $sr_id . ')"><i class="fa fa-check"></i>Finish Quotation</a></li>';
            }
            if ($this->session->userdata('ss_group_id') == 1) {
                $can_qtt = '<li><a href="#" onclick="cancel_qutation(' . $sr_id . ')"><i class="fa fa-ban"></i>Cancel Quotation</a></li>';
            }
            $nestedData[] = '<div class="btn-group text-left">
                                <button data-toggle="dropdown" class="btn btn-default btn-xs btn-primary dropdown-toggle" type="button">Actions <span class="caret"></span></button>
                                <ul role="menu" class="dropdown-menu pull-right">
                                <li><a href="' . base_url() . 'stock_req/view/' . $sr_id . '"><i class="fa fa-file-text-o"></i> Quotation Details</a></li>
                                <li><a onClick="fbs_click(' . $row['req_id'] . ')" data-toggle="modal" href="#" data-placement="top" data-original-title="Edit suppliers"><i class="fa fa-print"></i> Print Quotation</a></li>
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
    public function invoice_qutation()
    {
        $data['main_menu_name'] = $this->main_menu_name;
        $data['sub_menu_name']  = 'add_sales';
        //get suppliers list
        $id                     = $this->input->get('id');
        $data['sr_item_list']   = $this->Sr_Model->get_sr_item_list_by_sr_id($id);
        $data['sr_details']     = $this->Sr_Model->get_sr_info($id);
        $data['suppliers']      = $this->Supplier_Model->get_all_supplier();
        $data['warehouse_list'] = $this->Warehouse_Model->get_all_warehouse();
        $data['tax_rates_list'] = $this->Tax_Rates_Model->get_all_tax_rates();
        $data['customer_list']  = $this->Customer_Model->get_all_customers();
        $data['status_list']    = $this->Common_Model->get_all_status();
        $this->load->view('add_sales_qtation', $data);
    }
    public function finish_qutation()
    {
        $id   = $this->input->get('id');
        $data = array(
            'qutation_status' => 2,
            'updated_on' => date('Y-m-d H:i:s'),
            'updated_by' => $this->session->userdata('ss_user_id')
        );
        $this->Sr_Model->update_sr($id, $data);
        echo json_encode(array(
            'status' => 1
        ));
    }
    public function cancel_qutation()
    {
        $id   = $this->input->get('id');
        $data = array(
            'qutation_status' => 3,
            'updated_on' => date('Y-m-d H:i:s'),
            'updated_by' => $this->session->userdata('ss_user_id')
        );
        $this->Sr_Model->update_sr($id, $data);
        echo json_encode(array(
            'status' => 1
        ));
    }
    
    public function save_sr()
    {
        $sr_reference_no     = $this->input->post('req_reference_no');
        $warehouse_id        = $this->input->post('warehouse_id');
        $customer_id         = $this->input->post('customer_id');
        $rowCount            = $this->input->post('rowCount');
        $reqesting_for_date  = $this->input->post('reqesting_for_date');
        $sr_datetime         = $this->input->post('sr_datetime');
        $sr_total            = $this->input->post('sr_total');
        $sr_datetime_created = date('Y-m-d H:i:s');
        $error               = '';
        $disMsg              = '';
        $lastid              = '';
        $sr_id               = '';
        if (!$error) {
            $data      = array(
                'req_reference_no' => $sr_reference_no,
                'reqesting_for_date' => $reqesting_for_date,
                'warehouse_id' => $warehouse_id,
                'req_datetime' => date("Y-m-d H:i:s A"),
                'req_note' => '',
                'user_id' => '',
                
            );
            $this->db->trans_begin();
            $this->db->insert('stock_requisitions', $data);
            $lastid    = $this->db->insert_id();
            $sr_id     = $lastid;
            $disMsg    = 'Stock requisition successfully added';
            // Insert stock requisition item data
            $row       = $this->input->post('row');
            $rowCount  = $this->input->post('rowCount');
            $data_item = array();
            $post_items = array();
            for ($i = 1; $i <= $rowCount; $i++) {
                if (isset($row[$i]['product_id'][0])) {
                    $data_item = array(
                        'req_id' => $sr_id,
                        'product_id' => $row[$i]['product_id'][0],
                        'quantity' => $row[$i]['qty'][0]
                    );
                    
                    $post_items[] = array(
                        'product_id' => $row[$i]['product_id'][0],
                        'product_code' => $row[$i]['product_id'][0],
                        'product_name' => $row[$i]['product_id'][0],
                        'product_note' => $row[$i]['product_id'][0],
                        'qty' => $row[$i]['qty'][0]
                    );
                    
                    $this->db->insert('stock_requisition_items',$data_item);
                }
            }
            if ($this->db->trans_status() === FALSE)
            {
                     $this->session->set_flashdata('message', 'Stock requisition failed!');
                    echo json_encode(array(
                        'sr_id' => 0,
                        'error' => 'error',
                        'disMsg' => 'error'
                    ));
                    
                    return;
            }else{
                $url       = "https://admin.fab.test.newviableerp.com/api/bulk_orders";
                
                $this->db->select('*');
                $this->db->get_where('warehouse_id');
                $query = $this->db->get_where('locations', array('id' => $warehouse_id));
                $result = $query->row();
                //print_r($result);
                $post_data      = array(
                    'outlet_code' => $warehouse_id,
                    'uuid' => '',
                    'outlet_name' => $result->name,
                    'order_date' => $reqesting_for_date,
                    'type'  => "Normal",
                    'origin_type' => 'sr',
                    'origin_id' => $sr_id,
                    'ref_no' => $sr_reference_no,
                    'reqesting_for_date' => $reqesting_for_date,
                    'items' => $post_items
                );
                
                $resp = $this->post_transfer($url,$post_data);
                $resp = json_decode($resp);
                //print_r($resp);
                
                if(!isset($resp->error)){
                    $this->db->trans_commit();
                    $this->session->set_flashdata('message', 'Stock requisition successfully added!');
                    echo json_encode(array(
                        'sr_id' => $sr_id,
                        'error' => 0,
                        'disMsg' => 'Stock requisition successfully added!',
                        'resp' => $resp
                    ));
                }else{
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message', 'Stock requisition failed! '.$resp->message);
                    echo json_encode(array(
                        'sr_id' => 0,
                        'error' => 1,
                        'disMsg' => 'Stock requisition failed! '.$resp->message,
                        'resp' => $resp,
                        'result' => $result
                    ));
                }
            }
            
        } else {
            $disMsg = 'Please select these before adding any product: ' . $disMsg;
        }
        
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
}