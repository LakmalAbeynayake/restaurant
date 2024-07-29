<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Grn extends CI_Controller
{
    var $main_menu_name = "grn";
    var $sub_menu_name = "";
    function __construct()
    {
        parent::__construct();
        $this->load->model('common_model');
        $this->load->model('grn_model');
        $this->load->model('Warehouse_Model');
        /*$this->load->model('Sequerty_Model');*/
        /*$this->load->library('form_validation');*/
    }

    public function index($e = 0)
    {
        $data['error']          = $e;
        $data['main_menu_name'] = $this->main_menu_name;
        $data['warehouse_list'] = $this->Warehouse_Model->get_all_warehouse();
        $data['sub_menu_name']  = "list_grn";
        $this->load->view('grn/grn_list', $data);
    }

    public function add_grn()
    {
        $data['suppliers']      = $this->Supplier_Model->get_all_supplier();
        $data['warehouse_list'] = $this->Warehouse_Model->get_all_warehouse();
        $data['warehouse']      = $this->purchases_model->get_warehouse();
        $data['supplier']       = $this->purchases_model->get_supplier();
        $data['purchased_id']   = $purchased_id;
        $data['tax_rates_list'] = $this->Tax_Rates_Model->get_all_tax_rates();
        $data['customer_list']  = $this->Customer_Model->get_all_customers();
        $data['status_list']    = $this->Common_Model->get_all_status();
        
        $data['main_menu_name'] = $this->main_menu_name;
        $data['sub_menu_name']  = 'add_grn';
        $this->load->view('grn/add_grn', $data);
    }
    
    public function get_list_grn($value = '')
    {
        
        $location_id = $this->input->get('location_id');
        $i      = 0;
        $grns = $this->grn_model->get_grns($location_id);
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
                $row[]  = $grn->grn_ref_no;
                $row[]  = $grn->name."(".$grn->sender_location_id.")";
                $row[]  = $grn->sender_ref_no;
                //$row[]  = number_format($grn->grn_total_paid, 2, '.', '');
                $row[]  = $pay_st;
                $row[]  =  '<div class="text-center">
                                <div class="btn-group text-left">
                                    <button data-toggle="dropdown" class="btn btn-default btn-xs btn-primary dropdown-toggle" type="button">Actions <span class="caret"></span></button>
                                    <ul role="menu" class="dropdown-menu pull-right">
                                        <li><a href="' . base_url('grn/view/' . $grn->grn_id) . '"><i class="fa fa-file-text-o"></i> GRN Details</a></li>            
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

    public function suggestions($value = '')
    {
        $this->load->model('products_model');
        
        $term           = $this->input->get('term');
        $in_type        = $this->input->get('t');
        $result         = $this->products_model->search($term);
        $json           = array();
        
        foreach ($result as $row) {
            
            $product_name            = $row['product_name'];
            $product_code            = $row['product_code'];
            $product_id              = $row['product_id'];
            $json_itm = array(
                'id' => $row['product_id'],
                'product_id' => $row['product_id'],
                'product_code' => $row['product_code'],
                'product_name' => $row['product_name'],
                'item_cost' => $row['product_cost'],
                'value' => $row['product_name'] . " (" . $row['product_code'] . ")",
                'label' => $row['product_name'] . " (" . $row['product_code'] . ")"
            );
            array_push($json, $json_itm);
        }
        echo json_encode($json);
    }

    public function view($grn_id)
    {
        $data['main_menu_name'] = $this->main_menu_name;
        $data['sub_menu_name']  = "view_grn";
        $data['po_header']      = $this->grn_model->get_grn_info($grn_id);
        //print_r($data['po_header']);
        //exit;
        if ($data['po_header']) {
            $data['grn_id']     = $grn_id;
            $data['sender_location']     =$this->Warehouse_Model->get_warehouse_info($data['po_header']->sender_location_id);
            $data['receiver_location']   =$this->Warehouse_Model->get_warehouse_info($data['po_header']->receiver_location_id);
            $data['po_middle']  = $this->grn_model->get_grn_items($grn_id);
            $this->load->view('grn/grn_details', $data);
        } else
            show_404();
    }
    /*approve and add stock movements*/
    function approve(){
        $this->load->model('common_model');
        $this->load->model('grn_model');
        $this->load->model('stock_model');
        $this->load->model('products_model');
        /*Check permission*/
        
        /*End Check permission*/
        $grn_id = $this->input->post('grn_id');
        $uuid = $this->input->post('uuid');
        if(!$grn_id > 0 || !$this->session->userdata('ss_user_id') || !$uuid){
            $this->common_model->add_user_activitie("GRN approval - 400");
            http_response_code(400);
            return;
        }
        
        $grn_info = $this->grn_model->get_grn_info($grn_id);
        
        // if not approved yet (go to model function to get a better idea for the return value)
        if($this->grn_model->is_approved($grn_id)){
            $this->db->trans_start();

            /*end create origin entry*/
            $grn_items = $this->grn_model->get_grn_items($grn_id);
            // Stock Movement Records

            $movements_list = array();
            foreach($grn_items as $item){
                $data = array(
                    'location_id' => $grn_info->receiver_location_id,
                    'transaction_id' => $uuid,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'movement_type' => 'in',
                    'movement_date' => $grn_info->date_time,
                    'origin' => 'grn',
                    'origin_id' => $grn_id
                );
                $movements_list[] = $data;
                $this->products_model->update_to_latest_grn_value($item->product_id);
            }

            $track_data = array( 'trans_id' => $uuid,'location_id' => $grn_info->receiver_location_id,'date_time' => $grn_info->date_time,'added_by' => $this->session->userdata('ss_user_id'));
            $this->stock_model->stock_m_tracker($track_data);
            $this->stock_model->bulkInsertMovements($movements_list);
            $this->grn_model->approve($grn_id);
            $this->db->trans_complete();
            $this->common_model->add_user_activitie("GRN approved - id#$grn_id");
            http_response_code(200);
            exit;
        }
        $this->common_model->add_user_activitie("GRN approval - 403#$grn_id");
        http_response_code(403);
    }
    function report(){
        $this->load->model('products_model');
        $data['main_menu_name'] = 'reports';
        $data['sub_menu_name']  = "rep_grn";
        $data['warehouse_list']    = $this->Warehouse_Model->get_all_warehouse();
        $data['types']          = $this->products_model->get_types();
        $this->load->view('grn/report', $data);
    }
    function get_daily_grn(){
        $this->load->model('stock_model');
        
        $date = $this->input->post('date');
        $location_id = $this->input->post('location_id');
        //$location_id = $this->session->userdata('ss_warehouse_id');
        /*$update = $this->input->post('update') == 'true' ? true : false;
        if(!$date){
            http_response_code(400);
        }*/
        
        /*Check if data is available*/
        /*$this->db->select('COUNT(id) as count');
        $this->db->from('rep_daily_stock_summary');
        $this->db->where('date(date)', $date);
        $this->db->where('location_id', $location_id);
        $query = $this->db->get();
        $rep_data_count = $query->row()->count;
        
        // if data is there and not requesting for an update
        if($rep_data_count && !$update){
            $this->db->select('*');
            $this->db->from('rep_daily_stock_summary');
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
            $this->db->delete('rep_daily_stock_summary');
        }*/

        /*products_model.php*/
        $this->db->select('product_id,product_name,product_code,product_cost,product_type_id');
        $query = $this->db->get('product');
        $products_raw = $query->result();
        $products = array();
        foreach($products_raw as $row){
            $products[$row->product_id] = $row;
        }

        /*get grn for the date*/
        $stock_balance = array();
        $where = array(
            'date(date_time)' => $date,
            'receiver_location_id' => $location_id
        );
        $this->db->select('*');
        $this->db->from('grn');
        $this->db->where($where);
        $query = $this->db->get();
        $grns = $query->result();
        
        $id_list = array();
        $mapped_grn_by_id = array();
        foreach($grns as $row){
            $mapped_grn_by_id[$row->grn_id] = $row;
            $id_list[] = $row->grn_id;
        }
        
        /*get grn items for the date*/
        $stock_balance = array();
        $where = array(
            'date(date_time)' => $date,
            'receiver_location_id' => $location_id
        );
        $this->db->select('*');
        $this->db->from('grn_items');
        $this->db->where_in('grn_id',$id_list);
        $query = $this->db->get();
        $grn_items = $query->result();
        
        /*print_r($grn_items);*/
        
        $item_data = array();
        
        foreach($grn_items as $row){
            //print_r($mapped_grn_by_id[$row->grn_id]->grn_ref_no);
            //print_r($mapped_grn_by_id[$row->grn_id]->grn_ref_no);
            
            $itm = array(
                'date' => $mapped_grn_by_id[$row->grn_id]->date_time,
                'grn_ref_no' => $mapped_grn_by_id[$row->grn_id]->grn_ref_no,
                'sender_ref_no' => $mapped_grn_by_id[$row->grn_id]->sender_ref_no,
                'code' => $products[$row->product_id]->product_code,
                'name' => $products[$row->product_id]->product_name,
                'type' => $products[$row->product_id]->product_type_id,
                'quantity' => $row->quantity,
                'rate' => $row->unit_value,
                'amount' => floatval($row->unit_value) * floatval($row->quantity)
            );
            $item_data[] = $itm;
        }
        
        $DB_DATA = array();
        foreach($item_data as $row)
            $DB_DATA[]  = $row;
        
        /*Insert data*/
        header('content-type:application/json');
        echo json_encode($DB_DATA);
    }
}