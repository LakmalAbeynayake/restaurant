<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Gtn extends CI_Controller
{
    var $main_menu_name = "gtn";
    var $sub_menu_name = "";
    function __construct()
    {
        parent::__construct();
        $this->load->model('common_model');
        $this->load->model('gtn_model');
        $this->load->model('Warehouse_Model');
        /*$this->load->model('Sequerty_Model');*/
        /*$this->load->library('form_validation');*/
    }

    public function index($e = 0)
    {
        $data['error']          = $e;
        $data['main_menu_name'] = 'grn';
        $data['location_list'] = $this->Warehouse_Model->get_all_warehouse();
        $data['sub_menu_name']  = "list_gtn";
        $this->load->view('gtn/gtn_list', $data);
    }

    public function get_list_gtn($value = '')
    {
        $i      = 0;
        $grns = $this->gtn_model->get_gtns();
        $data   = array();
        $pay_st;
        if (!empty($grns)) {
            foreach ($grns as $grn) {
                $row    = array();
                if (!$grn->approval_status) {
                    $pay_st = '<span class="label label-warning">Pending</span>';
                } else {
                    $pay_st = '<span class="label label-info">Approved</span>';
                }
                $row[]  = $grn->date_time;
                $row[]  = $grn->gtn_ref_no;
                $row[]  = $grn->name."(".$grn->sender_location_id.")";
                //$row[]  = number_format($grn->grn_total_paid, 2, '.', '');
                $row[]  = $pay_st;
                $row[]  =  '<div class="text-center">
                                <div class="btn-group text-left">
                                    <button data-toggle="dropdown" class="btn btn-default btn-xs btn-primary dropdown-toggle" type="button">Actions <span class="caret"></span></button>
                                    <ul role="menu" class="dropdown-menu pull-right">
                                        <li><a href="' . base_url('gtn/view/' . $grn->gtn_id) . '"><i class="fa fa-file-text-o"></i> GRN Details</a></li>            
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

    public function purchases_details($purchas_id = '')
    {
        $data['main_menu_name'] = $this->main_menu_name;
        $data['sub_menu_name']  = "view_purchases";
        $data['po_header']      = $this->purchases_model->getpurchases_by_id($purchas_id);
        if ($data['po_header']) {
            $data['po_middle']     = $this->purchases_model->get_purchese_data_by_id($purchas_id);
            //print_r($data['po_middle']);
            //$data['po_header_r'] = $this->purchases_model->getpurchases_return_by_id_sum($purchas_id);
            //  print_r($data['po_header_r']);
            //$po_header = $this->purchases_model->getpurchases_return_by_id($purchas_id);
            //$data['po_header']['0']['purchase_id']; 
            // $data['po_middle_r'] = $this->purchases_model->get_purchese_return_data_by_id($data['po_header_r'][0]->pr_id);
            $data['po_payment']    = $this->purchases_model->get_payment_by_id($purchas_id);
            $data['po_paid_total'] = $this->purchases_model->grn_pay_total($purchas_id);
            $data['purchas_id']    = $purchas_id;
            $this->load->view('purchases_details', $data);
        } else
            show_404();
    }
}