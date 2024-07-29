<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Transactions extends CI_Controller
{
    var $main_menu_name = "transactions";
    var $sub_menu_name = "transactions_list";
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Transactions_Model');
        $this->load->model('Fixed_Assets_Model');
        $this->load->model('Common_Model');
        $this->load->model('finance_model');
        date_default_timezone_set("Asia/Colombo");
    }
    public function index()
    {
        $data['main_menu_name']    = $this->main_menu_name;
        $data['sub_menu_name']     = 'transactions_list';
        $data['transactions_type'] = $this->Fixed_Assets_Model->get_fixed_asset_list();
        $this->load->view('transaction/transactions_list', $data);
    }
    public function create_transactions()
    {
        $data['main_menu_name']          = $this->main_menu_name;
        $data['sub_menu_name']           = 'transactions_list';
        $data['mstr_expences_type_list'] = $this->finance_model->get_mstr_expences_type_list();
        $acctrnss_id                     = '';
        //print_r($this->input->get());
        //echo "test:".$this->input->get('acctrnss_id');
        if ($this->input->get('acctrnss_id')) {
            $acctrnss_id = $this->input->get('acctrnss_id');
        } else {
            $acctrnss_id = '';
        }
        //echo "t:$acctrnss_id";
        if ($acctrnss_id) {
            $data['acctrnss_id']          = $acctrnss_id;
            $data['type']                 = 'E';
            $data['pageName']             = 'UPDATE Transactions';
            $data['btnText']              = 'Update';
            $data['transactions_details'] = $this->Transactions_Model->get_transactions_details($acctrnss_id);
        } else {
            $data['acctrnss_id']  = '';
            $data['type']         = 'A';
            $data['pageName']     = 'ADD Transactions';
            $data['btnText']      = 'Add';
            $data['transactions'] = array();
        }
        $data['transactions_type'] = $this->Fixed_Assets_Model->get_fixed_asset_list();
        $this->load->view('transaction/create_transactions', $data);
    }
    public function save_transactions()
    {
        $uuid      = $this->input->post('uuid');
        $acctrnss_id      = $this->input->post('acctrnss_id');
        $type             = $this->input->post('type');
        $fxd_ass_id       = $this->input->post('fxd_ass_id');
        $acctrnss_amount  = $this->input->post('acctrnss_amount');
        $etp_id           = $this->input->post('etp_id');
        $business         = $this->input->post('business');
        $acctrnss_date    = date('Y-m-d H:i:s', strtotime($this->input->post('acctrnss_date')));
        $user_id          = $this->session->userdata('ss_user_id');
        $acctrnss_details = $this->input->post('acctrnss_details');
        $this->load->library('form_validation'); //form validation lib
        
        
        if ($this->session->userdata('ss_cashier_float_id') > 0) {

        } else {
            echo json_encode(array(
                'status' => 0,
                'validation' => 'Please start new float'
            ));
            return false;
        }
        
        $this->form_validation->set_rules('uuid', 'required|is_unique[acc_transactions.uuid]');
        
        if ($type == 'A') {
            $this->form_validation->set_rules('fxd_ass_id', 'required');
        } else if ($type == 'E') {
            $this->form_validation->set_rules('fxd_ass_id', 'required');
        }
        if ($this->form_validation->run() == FALSE) {
            $st = array(
                'status' => 0,
                'validation' => validation_errors()
            );
            echo json_encode($st);
        } else {
            if (!$etp_id) {
                $etp_id = 0;
            }
            $data    = array(
                'fxd_ass_id' => $fxd_ass_id,
                'acctrnss_amount' => $acctrnss_amount,
                'acctrnss_date' => $acctrnss_date,
                'acctrnss_details' => $acctrnss_details,
                'user_id' => $user_id,
                'etp_id' => $etp_id,
                //'business'=>$business,
                'float_id' => $this->session->userdata('ss_cashier_float_id'),
                'uuid' => $uuid
            );
            $_insert = $this->Transactions_Model->save_transactions($data, $acctrnss_id);
            //echo $this->db->last_query();
            $lastid  = $this->db->insert_id();
            if ($type == 'A') {
                if ($lastid) {
                    echo json_encode(array(
                        'id' => $lastid,
                        'type' => $type,
                        'status' => 1
                    ));
                } else {
                    echo json_encode(array(
                        'status' => '0'
                    ));
                }
            }
            if ($type == 'E') {
                echo json_encode(array(
                    'type' => $type,
                    'status' => 1
                ));
            }
        }
    }
    public function transactions_load()
    {
        $transactions_type = $this->Fixed_Assets_Model->get_fixed_asset_list();
        $tsm = array();
        foreach($transactions_type as $row){
            $tsm[$row['fxd_ass_id']] = $row;
        }
        
        
        $search_key        = $this->input->post('search');
        $search_key_val    = $search_key['value'];
        $start             = $this->input->post('start');
        $length            = $this->input->post('length');
        $warehouse_id      = $this->input->post('warehouse_id');
        $fxd_ass_id        = $this->input->post('fxd_ass_id');
        $srh_from_date     = $this->input->post('srh_from_date');
        $srh_to_date       = $this->input->post('srh_to_date');
        //$transactions_list=$this->Transactions_Model->get_transactions_list();
        $transactions_list = $this->Transactions_Model->get_transactions_list($start, $length, $search_key_val, $fxd_ass_id, $warehouse_id, $srh_from_date, $srh_to_date);
        $totalData         = 1000; // count($transactions_list);
        $totalFiltered     = $totalData;
        $data              = array();
        $x                 = 0;
        
        
        
        foreach ($transactions_list as $row) {
            $x++;
            $nestedData   = array();
            $nestedData[] = $row['acctrnss_id'];
            $nestedData[] = $row['fxd_ass_name'] . ' / ' . $row['etp_name'];
            ;
            $nestedData[] = '';
            $nestedData[] = '';
            $nestedData[] = site_date_time($row['acctrnss_date']);
            $nestedData[] = $row['acctrnss_amount'];
            $status       = '';
            if ($row['fxd_ass_status'] == 1) {
                $status = '<center><span class="label label-success">Enable</span></center>';
            } else if ($row['fxd_ass_status'] == 0) {
                $status = '<center><span class="label label-warning">Disable</span></center>';
            }
            $action       = '<center><div class="btn-group text-left">
                            <button data-toggle="dropdown" class="btn btn-default btn-xs btn-primary dropdown-toggle" type="button">Actions <span class="caret"></span></button>
                            <ul role="menu" class="dropdown-menu pull-right">
                            <li><a href="#" onclick="update_transactions(' . $row['acctrnss_id'] . '); return false;"><i class="fa fa-file-text-o"></i>Update Transactions</a></li>
                            <li><a href="#" onclick="print_transaction(' . $row['acctrnss_id'] . '); "> <i class="fa fa-print"></i> Print Transactions</a></li>
                            </ul></div></center>';
            $nestedData[] = $action;
            $data[]       = $nestedData;
        }
        $json_data = array(
            "data" => $data,
            "transactions_type" => $transactions_type
        );
        $json_data = array(
            //"draw"            => intval( $requestData['draw'] ),  
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data,
            "transactions_type" => $tsm
        );
        echo json_encode($json_data);
    }
    public function print_transaction()
    {
        $id                           = $this->input->get('id');
        $data['transactions_details'] = $this->Transactions_Model->transaction_details_print($id);
        $this->load->view('models/transaction_print', $data);
    }
}