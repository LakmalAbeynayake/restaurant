<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Transfer extends CI_Controller
{
    var $main_menu_name = "transfer";
    var $sub_menu_name = "transfer";
    public function __construct()
    {
        parent::__construct();
        $this->load->model('transfer_model');
        $this->load->model('Warehouse_Model');
        $this->load->model('Common_Model');
    }
    //Transfers list page load
    public function index()
    {
        $data['main_menu_name'] = $this->main_menu_name;
        $data['sub_menu_name']  = 'list_transfer';
        $data['warehouse_list'] = $this->Warehouse_Model->get_all_warehouse();
        $this->load->view('transfer/transfer_list', $data);
    }
    
    function get_stock_balance(){
        $this->load->model('stock_model');
        $product_id = $this->input->post('product_id');
        $location_id = $this->input->post('location_id');
        $where = array(
            'location_id' => $location_id,
            'product_id' => $product_id
        );
        $result = $this->stock_model->get_stock($where);
        echo json_encode(array(
            'b' => $result[$product_id]['closing_balance']
        ));
    }
    function check_stock($items,$location_id){
        $error_list = array();
        if(!empty($items)){
            foreach ($items as $row) {
                $bal = $this->stock_balance($row->product_id,$location_id);
                if($row->trnsfr_itm_quantity > $bal){
                    $error_list[] = $row->product_id;
                }
            }
        }else{
            return array(
                'error' => true,
                'msg'   => 'No items',
                'plist' => ''
            );
        }
        return array(
            'error' => count($error_list) > 0 ? true : false,
            'msg'   => count($error_list) > 0 ? "Insufficient stock" : "",
            'plist' => $error_list
        );
    }
    function stock_balance($product_id,$location_id){
        $this->load->model('stock_model');
        
        $where = array(
            'location_id' => $location_id,
            'product_id' => $product_id
        );
        $result = $this->stock_model->get_stock($where);
        return $result[$product_id]['closing_balance'];
    }
    //Transfers list
    public function list_transfer()
    {
        $columns       = array(
            0 => 'trnsfr_id',
            1 => 'trnsfr_id',
            2 => 'trnsfr_id',
            3 => 'trnsfr_id',
            4 => 'trnsfr_id',
            5 => 'trnsfr_id'
        );
        $location_id = $this->input->get('location_id');
        $data          = array();
        $transfer      = $this->transfer_model->get_all_transfer($location_id);
        $totalData     = count($transfer);
        $totalFiltered = $totalData;
        foreach ($transfer as $row) {
            $pay_st = '';
            if (!$row->approval_status) {
                $pay_st = '<span class="label label-warning">Pending</span>';
            } else {
                $pay_st = '<span class="label label-info">Approved</span>';
            }
            $nestedData           = array();
            $trnsfr_id            = $row->trnsfr_id;
            $total_paid_amount    = '';
            $nestedData[]         = $row->trnsfr_id;
            $nestedData[]         = $row->trnsfr_datetime." (Added on: ".$row->added_on.")";
            $nestedData[]         = $row->trnsfr_reference_no;
            $nestedData[]         = $row->name;
            $nestedData[]         = number_format($row->trnsfr_total, 2, '.', ',');
            $nestedData[]         = $pay_st;
            $url                  = base_url("transfer/trnsfr_details?trnsfr_id=$trnsfr_id");
            $actionTxtUpdate      = '<a onClick="fbs_click(' . $row->trnsfr_id . ')" data-toggle="modal" href="#" class="btn btn-xs btn-blue tooltips" data-placement="top" data-original-title="Edit suppliers"><i class="clip-zoom-in-2"></i></a> &nbsp;';
            $actionTxtViewDetails = '<a href="' . base_url() . 'transfer/view/' . $trnsfr_id . '" class="btn btn-xs btn-blue tooltips" data-placement="top" data-original-title="Edit suppliers"><i class="fa fa-file-text-o"></i></a> &nbsp;';
            $nestedData[]         = '<div class="btn-group text-left">

                            <button data-toggle="dropdown" class="btn btn-default btn-xs btn-primary dropdown-toggle" type="button">Actions <span class="caret"></span></button>

                            <ul role="menu" class="dropdown-menu pull-right">

                            

                            <li><a target="_new" href="' . base_url('transfer/view/' . $trnsfr_id) . '" ><i class="fa fa-file"></i> View Transfer Details</a></li>
                            <li><a onClick="fbs_click(' . $row->trnsfr_id . ')" data-toggle="modal" href="#" data-placement="top" data-original-title="Edit suppliers"><i class="fa fa-print"></i> Print Transfer</a></li>

                            

                            </ul></div>';
            /*<li><a href="'.base_url().'transfer/view/'.$trnsfr_id.'"><i class="fa fa-file-text-o"></i> Transfer Details</a></li>*/
            $data[]               = $nestedData;
        }
        $json_data = array(
            //"draw"            => intval( $requestData['draw'] ),  
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data,
            'location_id' => $location_id
        );
        echo json_encode($json_data);
    }
    
    
    //Transfers details view
    public function view()
    {
        $data['main_menu_name']   = $this->main_menu_name;
        $data['sub_menu_name']    = '';
        //get sale id
        $trnsfr_id                = $this->uri->segment('3');
        $data['trnsfr_item_list'] = $this->transfer_model->get_trnsfr_item_list_by_trnsfr_id($trnsfr_id);
        $data['trnsfr_details']   = $this->transfer_model->get_trnsfr_info($trnsfr_id);
        $data['location_details'] = $this->Warehouse_Model->get_warehouse_info($data['trnsfr_details']['location_id']);
        $data['receiver_details'] = $this->Warehouse_Model->get_warehouse_info($data['trnsfr_details']['trnsfr_to_location_id']);
        $data['trnsfr_id']        = $trnsfr_id;
        $this->load->view('transfer/transfer_view', $data);
    }
    
    //Transfers ger avalable product qty
    public function get_avalable_product_qty()
    {
        $product_id    = $this->input->get('product_id');
        $warehouse_id  = $this->input->get('warehouse_id');
        $data['total'] = $this->transfer_model->get_avalable_product_qty($product_id, $warehouse_id);
        echo json_encode(array(
            'remmnaingQty' => 0 //$data['total']
        ));
    }
    
    function del_items(){
        $trnsfr_itm_id             = $this->input->post('db_id');
        if($trnsfr_itm_id > 0){
            $this->db->delete('transfer_item',array('trnsfr_itm_id' => $trnsfr_itm_id));
        }
        echo json_encode(
            array(
                'success' => $this->db->affected_rows() > 0 ? true : false
            )
        );
    }
    /*function add_item(){
        $trnsfr_itm_id             = $this->input->post('db_id');
        if($trnsfr_itm_id > 0){
            $this->db->delete('transfer_item',array('trnsfr_itm_id' => $trnsfr_itm_id));
        }
        echo json_encode(
            array(
                'success' => $this->db->affected_rows() > 0 ? true : false
            )
        );
    }*/
    
    public function save_transfer()
    {
        $trns_id                 = $this->input->post('trnsfr_id');
        
        if($trns_id){
            $this->db->select('*');
            $this->db->where('trnsfr_id', $trns_id);
            $query = $this->db->get('transfer');
            $result = $query->row();
            $approval_status = $result->approval_status;
            if($approval_status == 1){
                echo json_encode(array(
                    'trnsfr_id' => $trns_id,
                    'error' => 1,
                    'disMsg' => "Request forbidden"
                ));
                exit;
            }
        }
        
        $location_id             = $this->input->post('location_id');
        $trnsfr_to_location_id   = $this->input->post('trnsfr_to_location_id');
        $rowCount                = $this->input->post('rowCount');
        $trnsfr_datetime         = date('Y-m-d H:i:s', strtotime($this->input->post('trnsfr_datetime')));
        $trnsfr_total            = $this->input->post('trnsfr_total');
        $trnsfr_datetime_created = date('Y-m-d H:i:s');
        $error                   = '';
        $disMsg                  = '';
        $lastid                  = '';
        $trnsfr_id               = '';
        if($trns_id){
            $trnsfr_id = $trns_id;
            $this->db->delete('transfer_item',array('trnsfr_id' => $trns_id));
        }
        /*check stock*/
        /*$cresult = $this->check_stock($this->input->post('row'),$location_id);
        $error = $cresult['error'];*/
        if (!$error) {
        
            $trnsfr_reference_no    = '';
            $this->db->select('count(trnsfr_id) as count');
            $this->db->from('transfer');
            $this->db->where('location_id', $location_id);
            $query        = $this->db->get();
            $count_result = $query->num_rows();
            if ($count_result > 0) {
                // If there are rows returned
                $r          = $query->row()->count;
                // Adding padding with 5 zeros
                $trnsfr_reference_no = 'TRS'.$location_id.'-' . $trnsfr_to_location_id . '-' . str_pad(($r + 1), 5, '0', STR_PAD_LEFT);
            } else {
                // If no rows are returned, set the count to 0
                $trnsfr_reference_no = 'TRS'.$location_id.'-' . $trnsfr_to_location_id . '-' . str_pad(1, 5, '0', STR_PAD_LEFT);
            }

            $data = array(
                'trnsfr_reference_no' => $trnsfr_reference_no,
                'location_id' => $location_id,
                'trnsfr_to_location_id' => $trnsfr_to_location_id,
                'trnsfr_datetime' => $trnsfr_datetime,
                'trnsfr_total' => $trnsfr_total,
                'user_id' => $this->session->userdata('ss_user_id'),
                'added_on' => $trnsfr_datetime_created
            );
            
            $this->db->trans_start();
            $_insert   = $this->transfer_model->save_transfer($data, $trnsfr_id);
            $lastid    = $this->db->insert_id() ? $this->db->insert_id() : $trns_id;
            $trnsfr_id = $lastid;
            $disMsg    = 'Successfully added';
            //insert sale item data
            $raw       = $this->input->post('row');

            $data_item = array();
            if(!empty($raw)){
                foreach ($raw as $row) {
                    $data_item = array(
                        'trnsfr_id' => $trnsfr_id,
                        'product_id' => $row['product_id'],
                        'trnsfr_itm_quantity' => $row['qty'],
                        'trnsfr_itm_unit_value' => $row['unit_value']
                    );
                    $this->transfer_model->save_transfer_item($data_item);
                }
                $this->db->trans_complete();
                $this->Common_Model->add_user_activitie("Transfer add - id#$trnsfr_id");
                $error = 0;
            }else{
                $error = 1;
                $disMsg = 'No valid Items!';
                $this->Common_Model->add_user_activitie("Transfer add - attempt failed- Empty/Invalid Items");
            }
        } else {
            $error = 1;
            $disMsg = 'Stock error!';
            $this->Common_Model->add_user_activitie("Transfer add - attempt failed");
        }
        
        if ($this->db->trans_status() === FALSE)
        {
                $this->session->set_flashdata('message', 'Transfer failed!');
                echo json_encode(array(
                    'trnsfr_id' => 0,
                    'error' => $error,
                    'disMsg' => $disMsg
                ));
                exit;
        }
        else
        {
                $this->session->set_flashdata('message', 'Transfer successfully added!');
                echo json_encode(array(
                    'trnsfr_id' => $lastid,
                    'error' => $error,
                    'disMsg' => $disMsg
                ));
                //http_response_code(200);
                exit;
        }
    }
    //Transfers reference no jenarate    
    public function get_next_ref_no()
    {
        $query               = $this->transfer_model->get_next_ref_no();
        $result              = $query->row();
        //print_r($result);
        $trnsfr_reference_no = sprintf("%05d", $result->trnsfr_id + 1);
        $trnsfr_reference_no = $trnsfr_reference_no;
        echo json_encode(array(
            'trnsfr_reference_no' => $trnsfr_reference_no
        ));
    }
    public function get_next_ref_no_()
    {
        $query               = $this->transfer_model->get_next_ref_no();
        $result              = $query->row();
        //print_r($result);
        return sprintf("%05d", $result->trnsfr_id + 1);
    }
    //Transfers add form
    public function transfer_add($transfer_id = 0)
    {
        $data['main_menu_name'] = $this->main_menu_name;
        $data['sub_menu_name']  = 'transfer_add';
        if($transfer_id){
            $this->db->select('*');
            $this->db->where('trnsfr_id', $transfer_id);
            $query = $this->db->get('transfer');
            $result = $query->row();
            $approval_status = $result->approval_status;
            if($approval_status == 1){
                header("Location: ". base_url('transfer/add'));
            }else{
                $data['td'] = $result;
                
                $this->db->select('transfer_item.*, product.product_name, product.product_code');
                $this->db->from('transfer_item');
                $this->db->join('product','product.product_id = transfer_item.product_id','left');
                $this->db->where('trnsfr_id', $transfer_id);
                $query = $this->db->get();
                $result = $query->result_array();
                
                $data['tdi'] = $result;
            }
        }
        //get suppliers list
        //$data['suppliers']      = $this->Supplier_Model->get_all_supplier();
        $data['warehouse_list'] = $this->Warehouse_Model->get_all_warehouse();
        //$data['tax_rates_list'] = $this->Tax_Rates_Model->get_all_tax_rates();
        //$data['customer_list']  = $this->Customer_Model->get_all_customers();
        //$data['status_list']    = $this->Common_Model->get_all_status();
        $this->load->view('transfer/transfer_add', $data);
    }
    //Sale details page
    public function trnsfr_details()
    {
        $trnsfr_id                    = $this->input->get('trnsfr_id');
        $data['trnsfr_details']       = $this->transfer_model->get_trnsfr_info($trnsfr_id);
        //get sale item list
        $data['trnsfr_item_list']     = $this->transfer_model->get_trnsfr_item_list_by_trnsfr_id($trnsfr_id);
        $data['warehouse_details']    = $this->Warehouse_Model->get_warehouse_info($data['trnsfr_details']['location_id']);
        $data['to_warehouse_details'] = $this->Warehouse_Model->get_warehouse_info($data['trnsfr_details']['trnsfr_to_location_id']);
        $data['cr_limit_list']        = $this->Common_Model->get_all_cr_limit();
        $this->load->view('transfer/transfer_print', $data);
    }
    
    /*Approve and generate GTN*/
    function approve()
    {
        $this->load->model('gtn_model');
        $this->load->model('grn_model');
        $this->load->model('stock_model');
        /*Check permission*/
        
        /*End Check permission*/
        $date        = date('Y-m-d H:i:s');
        $transfer_id = $this->input->post('transfer_id');
        $uuid        = $this->input->post('uuid');
        if (!$transfer_id > 0 || !$this->session->userdata('ss_user_id') || !$uuid) {
            $this->Common_Model->add_user_activitie("Transfer approval - Bad request");
            http_response_code(400);
            return;
        }
        /*mapping pro*/
        $products = array();
        
        $this->db->select('product_id,product_code,product_name');
        $this->db->from('product');
        $query = $this->db->get();
        $products_raw = $query->result();
        
        foreach($products_raw as $itm){
            $products[$itm->product_id] = $itm;
        }
        //print_r($this->transfer_model->is_approved($transfer_id));
        // if not approved yet. ( >> go to the model function to get a better idea about the return value)
        if ($this->transfer_model->is_approved($transfer_id) === FALSE) {
            $transfer_details = $this->transfer_model->get_trnsfr_info($transfer_id);
            $this->db->trans_start();
            
            /*create origin entry - for gtn*/
            $ori_data = array(
                'sender_location_id' => $transfer_details['location_id'],
                'receiver_location_id' => $transfer_details['trnsfr_to_location_id'],
                'gtn_ref_no' => '',
                'origin_id' => $transfer_id,
                'origin_type' => 'transfer',
                'date_time' => $date,
                'uuid' => $uuid,
                'approval_status' => 1,
                'approved_by' => $this->session->userdata('ss_user_id'),
                'approved_on' => $date
            );
            
            $gtn_id        = $this->gtn_model->save_gtn($ori_data);
            $gtn_item_data = array();
            
            if (!$gtn_id) {
                http_response_code(500);
                return;
            }
            
            /* create origin entry - for grn*/
            $ori_data = array(
                'sender_location_id' => $transfer_details['location_id'],
                'receiver_location_id' => $transfer_details['trnsfr_to_location_id'],
                'grn_ref_no' => '',
                'origin_id' => $transfer_id,
                'origin_type' => 'transfer',
                'date_time' => $date,
                'uuid' => $uuid
            );
            $grn_id   = $this->grn_model->save_grn($ori_data);
            if (!$grn_id) {
                http_response_code(500);
                return;
            }
            $grn_item_data = array();
            $post_items  = array();
            /**/
            
            /*end create origin entry*/
            $transfer_items = $this->transfer_model->get_transfer_items($transfer_id);
            
            /*check stock*/
            $cresult = $this->check_stock($transfer_items,$transfer_details['location_id']);
            $error = $cresult['error'];
            if($error){
                echo json_encode(array(
                    'success' => false,
                    'list' => $cresult['plist']
                ));
                exit;
            }
            
            // Stock Movement Records
            // arry for
            $movements_list = array();
            foreach ($transfer_items as $item) {
                $data             = array(
                    'location_id' => $transfer_details['location_id'],
                    'transaction_id' => $uuid,
                    'product_id' => $item->product_id,
                    'quantity' => $item->trnsfr_itm_quantity,
                    'unit_value' => $item->trnsfr_itm_unit_value,
                    'movement_type' => 'out',
                    'movement_date' => $date,
                    'origin' => 'gtn',
                    'origin_id' => $gtn_id
                );
                $movements_list[] = $data;
                
                $itm_data        = array(
                    'gtn_id' => $gtn_id,
                    'transaction_id' => $uuid,
                    'product_id' => $item->product_id,
                    'quantity' => $item->trnsfr_itm_quantity,
                    'unit_value' => $item->trnsfr_itm_unit_value
                );
                $gtn_item_data[] = $itm_data;
                
                $itm_data        = array(
                    'grn_id' => $grn_id,
                    'transaction_id' => $uuid,
                    'product_id' => $item->product_id,
                    'quantity' => $item->trnsfr_itm_quantity,
                    'unit_value' => $item->trnsfr_itm_unit_value
                );
                $grn_item_data[] = $itm_data;
                
                $itm_data    = array(
                    'product_code_ref' => $products[$item->product_id]->product_code,
                    'product_code' => $products[$item->product_id]->product_code,
                    'product_name' => $products[$item->product_id]->product_name,
                    'batch_no'  => '',
                    'quantity' => $item->trnsfr_itm_quantity,
                    'unit_value' => $item->trnsfr_itm_unit_value
                );
                $post_items[] = $itm_data;
            }
            
            $this->gtn_model->save_gtn_items($gtn_item_data);
            $this->grn_model->save_grn_items($grn_item_data);
            
            $track_data = array(
                'trans_id' => $uuid,
                'location_id' => $transfer_details['location_id'],
                'date_time' => $date,
                'added_by' => $this->session->userdata('ss_user_id')
            );
            $this->stock_model->stock_m_tracker($track_data);
            //print_r($movements_list);
            $this->stock_model->bulkInsertMovements($movements_list);
            $this->transfer_model->approve($transfer_id);
            $this->Common_Model->add_user_activitie("Transfer approved - id#$transfer_id");
            http_response_code(200);
            
            /*methanin thamai production ekata yawanne*/
            $post_data      = array(
                'sender_id' => $transfer_details['location_id'],
                'authKey' => '123456789',
                'uuid' => $uuid,
                'receiver_id' => $transfer_details['trnsfr_to_location_id'],
                'ref_no' => $transfer_details['trnsfr_reference_no'],
                'date_time' => $date,
                'total_vale' => $transfer_details['trnsfr_total'],
                'date' => date("Y-m-d", strtotime($date)),
                'origin_type' => 'gtn',
                'origin_id' => $gtn_id,
                'items' => $post_items
            );
            $pst = $this->post_transfer($post_data);
            
            $pst = json_decode($pst);
            
            if(isset($pst->error)){
                echo json_encode(array(
                    'error' => $pst->error,
                    'data' => $pst->data
                ));
                return;
            }
            
            $this->db->trans_complete();
            if ($this->db->trans_status() === FALSE)
            {
                    echo json_encode(array(
                        'error' => 'something internal wrong'
                    ));
                    //http_response_code(403);
                    exit;
            }
            else
            {
                    echo json_encode(array(
                        'success' => 'success'
                    ));
                    //http_response_code(200);
                    exit;
            }
        }
        http_response_code(403);
        // Call the addMovement method from the model
        // $log_id = $this->Stock_model->addMovement($data);
    }
    public function post_transfer($data)
    {
        
        /*
        https://singhe-production1v1.vpos.verp.sites.lk
        https://singhe-production2v1.vpos.verp.sites.lk
        https://singhe-distribution.vpos.verp.sites.lk
        */
        
        $url = '';
        //---------------------------------------------------------------
        $urls = array();
        $urls[5] = "https://singhe-production1v1.vpos.verp.sites.lk/outlet_api/create_grn";
        $urls[6] = "https://singhe-production2v1.vpos.verp.sites.lk/outlet_api/create_grn";
        
        if($data['receiver_id'] != $data['sender_id']){
            if(isset($urls[$data['receiver_id']]))
                $url = $urls[$data['receiver_id']];
            else{
                return json_encode(array(
                    'success' => 'internal transfer successful'
                ));
            }
        }else {
            return json_encode(array(
                'success' => 'internal transfer successful'
            ));
        }
        // Data to be sent in JSON format
        
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
    /*transfer report*/
    function report(){
        $data['main_menu_name'] = 'reports';
        $data['sub_menu_name']  = 'ts_report_daily';
        $data['warehouse_list'] = $this->Warehouse_Model->get_all_warehouse();
        $this->load->view('transfer/report', $data);
    }
    function get_report_data(){
        /*  -method: post
            -filters:
                -from_date
                -to_date
                -location
        */
        $from_date = $this->input->post('date');
        $to_date = $this->input->post('to_date');
        $location = $this->input->post('location_id');
        //transfer_model
        if($from_date){
            $from_date=date('Y-m-d', strtotime($from_date));
        }
        if($to_date){
            $to_date=date('Y-m-d', strtotime($to_date));
        }
        $products   =   $this->transfer_model->get_product_list();
        $transfer_items =   $this->transfer_model->get_transfer_details_list($from_date,$to_date,$location);
        $DB_DATA = array();
        foreach($transfer_items as $row)
            $DB_DATA[]  = $row;
       
        /*Insert data*/
        //$this->db->insert_batch('rep_daily_stock_summary',$DB_DATA);

        header('content-type:application/json');
        echo json_encode($DB_DATA);
    }
}