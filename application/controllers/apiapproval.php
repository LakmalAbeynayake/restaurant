<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *'); 
class Apiapproval extends CI_Controller
{
    var $main_menu_name = "";
    var $sub_menu_name = "";
    public function __construct()
    {
        parent::__construct();
        $this->load->model('common_model');
        $this->load->model('Stock_Transfer_Model');
        $this->load->model('Stock_M_Transfer_Model');
        /*
           header('Content-Type: application/json');
            if (!isset($_SERVER['CONTENT_TYPE'])) {
                $data = array(
                    "status" => 0,
                    "msg" => "Content Type undefined.",
                    "err_code" => "error-400-i"
                );
                echo json_encode($data);
                exit();
            }
            if ($_SERVER['CONTENT_TYPE'] !== "application/json" && $_SERVER['CONTENT_TYPE'] !== "application/json; charset=utf-8") {
                $data = array(
                    "status" => 0,
                    "msg" => "Invalid content type! JSON required. Received:" . $_SERVER['CONTENT_TYPE'],
                    "err_code" => "error-401-i"
                );
                echo json_encode($data);
                exit();
            }
            $_POST = json_decode(file_get_contents("php://input"), true);
            */
       
      
    }
    
    //this function added by namal for get all transfers list include finish goods, Metirial
    public function get_transfer_all_list($value = ''){
        
        $code     = $this->input->get('code');
        $search_key     = $this->input->get('search');
        $search_key_val = isset($search_key['value'])?$search_key['value']:'';
        $start          = $this->input->get('start');
        $length         = $this->input->get('length');
        $totalData      = 0;
        $values         = $this->Stock_Transfer_Model->get_transfer_all_list_finish_goods($code,$start, $length);
        //$value_count    = $this->Stock_Transfer_Model->get_transfer_all_list_finish_goods($code,'', '', '');
        
        
        $values_row_meterials         = $this->Stock_Transfer_Model->get_transfer_all_list_row_meterial($code,$start, $length);
        //$values = array_merge($values, $values_row_meterials);
        //echo '<pre>',print_r($values_row_meterials); die();
        $new_rows = array();
        if($values){
            foreach($values as $vrow){
                $vrow->type = 'Finish Goods';
                $new_rows[] = $vrow;
            }
        }
        if($values_row_meterials){
            foreach($values_row_meterials as $mrow){
                $mrow->type = 'Meterial';
                $new_rows[] = $mrow;
            }
        }
        //rsort($new_rows);
        usort($new_rows, function($a, $b) {
          $ad = new DateTime($a->stm_date_time);
          $bd = new DateTime($b->stm_date_time);
          if ($ad == $bd) {
            return 0;
          }
          return $ad < $bd ? 1 : -1;
        });
        //echo '<pre>',print_r($new_rows); die();
        

        $totalData     = count($new_rows);
        $totalFiltered = $totalData;
        
    // echo '<pre>',print_r($values); die();
        $data          = array();
        if (!empty($new_rows)) {
            
            foreach ($new_rows as $products) {
                $row=array();
                $status='<span class=" btn btn-xs btn-primary"> DRAFT</sapn>';
                if($products->stm_status==1){
                   $status='<span class=" btn btn-xs btn-success"> COMPLETED</sapn>'; 
                }
                
                $grnstatus='<span class=" btn btn-xs btn-warning"> PENDING</sapn>';
                if($products->stm_receved_status==1){
                   $grnstatus='<span class=" btn btn-xs btn-success"> COMPLETED</sapn>'; 
                }
                
                $row[]               = $products->stm_date_time;
                $row[]               = $products->stm_no;
                $row[]               = $products->type;
                $row[]               = $products->user_first_name." ".$products->user_last_name;
                $row[]               = $products->stm_to_id;
                $row[]               = $status;
                $row[]               = $grnstatus;
                $actdes = '';
                
                if($products->type=='Meterial'){
                    $option_order_details='<li><a  class="btn btn-default " data-toggle="tooltip" data-placement="bottom" title="GRN This Transfer"  onClick="view_m_transfer('.$products->stm_id.')"><i class="fa fa-check" aria-hidden="true"> GRN Details</i></a></li>';
                    $option_order_details.='<li><a  class="btn btn-default " data-toggle="tooltip" data-placement="bottom" title="GRN This Transfer"  onClick="grn_m_this_transfer('.$products->stm_id.')"><i class="fa fa-check" aria-hidden="true"> GRN</i></a></li>';
                }else{
                    $option_order_details='<li><a  class="btn btn-default " data-toggle="tooltip" data-placement="bottom" title="GRN This Transfer"  onClick="view_transfer('.$products->stm_id.')"><i class="fa fa-check" aria-hidden="true"> GRN Details</i></a></li>';
                    $option_order_details.='<li><a  class="btn btn-default " data-toggle="tooltip" data-placement="bottom" title="GRN This Transfer"  onClick="grn_this_transfer('.$products->stm_id.')"><i class="fa fa-check" aria-hidden="true"> GRN</i></a></li>';
                }
                
               
                $update_action='';
                
                
               $action_option=''; 
              if($products->stm_status==1 || $products->stm_status==1 ){
                  $action_option=$option_order_details;
                }else{
                    $action_option=$option_order_details.$update_action;
                }
                $actdes = $actdes . '<div class="btn-group text-left">
                            <button data-toggle="dropdown" class="btn btn-default btn-xs  dropdown-toggle" type="button">Actions <span class="caret"></span></button>
                            <ul role="menu" class="dropdown-menu pull-right">
                            '.$action_option.'</ul></div>                      ';
                $row[]               = $actdes;
                $data[] = $row;
            }
            
            //echo '<pre>',print_r($data); die();
            
            $output = array(
                'data' => $data,
                "recordsTotal" => intval($totalData),
                "recordsFiltered" => intval($totalFiltered)
            );
            echo json_encode($output);
            
        } else {
            $output = array(
                'data' => ''
            );
            echo json_encode($output);
        }
    }
    
    
    
    
    public function index()
    {
        $data = array(
            "status" => 0,
            "msg" => "Error",
            "err_code" => "error-200-a"
        );
        echo json_encode($data);
    }
    
    public function approvel_transfer(){
        $id = $this->input->get('id');
        $data=array('stm_receved_status'=>"1");
        $this->Stock_Transfer_Model->update_transfer_master($id,$data);
        echo json_encode(array(
                "status" => 1,
                "msg" => "Success",
            ));
    }
    
    public function approvel_m_transfer(){
        $id = $this->input->get('id');
        $data=array('stm_receved_status'=>"1");
        $this->Stock_M_Transfer_Model->update_transfer_master($id,$data);
        echo json_encode(array(
                "status" => 1,
                "msg" => "Success",
            ));
    }
    
    
    
    //Added by namal to view only transfer items
    
    function transfer_items_view()
    {
       if (isset($_SERVER['HTTP_ORIGIN'])) {
      // Decide if the origin in $_SERVER['HTTP_ORIGIN'] is one
      // you want to allow, and if so:
      header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
      header('Access-Control-Allow-Credentials: true');
      header('Access-Control-Max-Age: 86400');    // cache for 1 day
    }
    // Access-Control headers are received during OPTIONS requests
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

      if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
        // may also be using PUT, PATCH, HEAD etc
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

      if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
        header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

      exit(0);
    } 
        $id = $this->input->get('id');
        $d           = $this->Stock_Transfer_Model->get_trasfer_product_list_api($id);
   
        if (!empty($d)) {
            foreach ($d as $key => $row) {
                $d[$key]->product_id    = $d[$key]->product_id + 0;
                $d[$key]->product_retail_pirce = $d[$key]->product_retail_pirce + 0;
                $d[$key]->product_cost  = $d[$key]->product_cost + 0;
                $d[$key]->product_code  = $d[$key]->product_code;
                $d[$key]->stm_no  = $d[$key]->stm_no;
                $d[$key]->product_name  = $d[$key]->product_name;
                $d[$key]->quantity    = $d[$key]->quantity + 0;
                
            }
            echo json_encode(array(
                "status" => 1,
                "msg" => "Success",
                "products" => $d,
                'stm_no'=>$d[$key]->stm_no,
                'stm_receved_status'=>$d[$key]->stm_receved_status
            ));
            $data=array('stm_receved_status'=>"1");
            //$this->Stock_Transfer_Model->update_transfer_master($id,$data);
        } else {
            $jproduct = array();
            echo json_encode(array(
                "status" => 0,
                "msg" => "Failed. (Error code: error-403-i)",
                "products" => $jproduct
            ));
        }
    }
    
    function transfer_items_view_m()
    {
        $this->load->model('Stock_M_Transfer_Model');
       if (isset($_SERVER['HTTP_ORIGIN'])) {
      // Decide if the origin in $_SERVER['HTTP_ORIGIN'] is one
      // you want to allow, and if so:
      header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
      header('Access-Control-Allow-Credentials: true');
      header('Access-Control-Max-Age: 86400');    // cache for 1 day
    }
    // Access-Control headers are received during OPTIONS requests
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

      if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
        // may also be using PUT, PATCH, HEAD etc
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

      if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
        header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

      exit(0);
    } 
        $id = $this->input->get('id');
        $d           = $this->Stock_M_Transfer_Model->get_trasfer_product_list_api_new($id);
        //echo '<pre>',print_r($d); die();
   
        if (!empty($d)) {
            foreach ($d as $key => $row) {
                $d[$key]->product_id    = $d[$key]->product_id + 0;
                $d[$key]->product_retail_pirce = $d[$key]->product_retail_pirce + 0;
                $d[$key]->product_cost  = $d[$key]->product_cost + 0;
                $d[$key]->product_code  = $d[$key]->item_code;
                $d[$key]->stm_no  = $d[$key]->stm_no;
                $d[$key]->product_name  = $d[$key]->item_name;
                $d[$key]->quantity    = $d[$key]->quantity + 0;
                
            }
            echo json_encode(array(
                "status" => 1,
                "msg" => "Success",
                "products" => $d,
                'stm_no'=>$d[$key]->stm_no,
                'stm_receved_status'=>$d[$key]->stm_receved_status
            ));
            $data=array('stm_receved_status'=>"1");
            //$this->Stock_M_Transfer_Model->update_transfer_master($id,$data);
        } else {
            $jproduct = array();
            echo json_encode(array(
                "status" => 0,
                "msg" => "Failed. (Error code: error-403-i)",
                "products" => $jproduct
            ));
        }
    }
    
    
    //Closed "Added by namal"
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
   
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
                $d[$key]->cat_name        = $d[$key]->cat_name;
                $d[$key]->sub_cat_id    = $d[$key]->sub_cat_id + 0;
                $d[$key]->min_order_qty = $d[$key]->min_order_qty + 0;
            }
            echo json_encode(array(
                "status" => 1,
                "msg" => "Success",
                "products" => $d
            ));
        } else {
            $jproduct = array();
            echo json_encode(array(
                "status" => 0,
                "msg" => "Failed. (Error code: error-403-i)",
                "products" => $jproduct
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
                "msg" => "Failed. (Error code: error-404-i)",
                "product_info" => json_decode("{}")
            ));
            echo $ret;
        }
    }
    /*add grn*/
    public function add_fg()
    {
        $this->load->library('form_validation');
        $num_products_inserted = 0;
        //print_r($_SUBMIT);
        $status = 0;
        $msg = '';
        $return_data  = '';
        
        $lastid = '';
        
        $this->form_validation->set_rules('supplier_name', 'supplier_name', 'required');
        $this->form_validation->set_rules('warehouse_id', 'Warehouse_id', 'required');
        if ($this->form_validation->run() == FALSE) {
            $msg .= "Failed. (Error code: error-406-i)".validation_errors()."\n";
        } else {
            $warehouse_id        = $this->input->post('warehouse_id');
            $warehouse_info      = $this->warehouse_model->get_warehouse_info($warehouse_id);
            if(empty($warehouse_info)){
                $msg .= "Failed. Invalid warehouse_id (Error code: error-408-i). \n";
            }else{
                $perfix_for_contract = 'GRN-EXT-' . $warehouse_info['code'] . "/";
                $reference_no        = $this->common_model->gen_ref_number('id', 'purchases', $perfix_for_contract);
                $supplier_name       = $this->input->post('supplier_name');
                $this->db->trans_start();
                $supplier_id         = $this->check_supplier($supplier_name);
                $podate              = date("Y-m-d H:i:s");
                $supp_invocie_no = $this->input->post('supp_invocie_no');
                $discount            = $this->input->post('discount');
                $order_cal_des       = $this->input->post('discount_amount');
                $total               = $this->input->post('sub_total');
                $grand_total         = $this->input->post('grand_total');
                $note                = $this->input->post('note');
                $uuid                = $this->input->post('uuid');
                $products            = $this->input->post('products');
                
                $header_data = array(
                    'uuid' => $uuid,
                    'reference_no' => $reference_no,
                    'warehouse_id' => $warehouse_id,
                    'supplier_id' => $supplier_id,
                    'date' => $podate,
                    'note' => $note,
                    'total' => $total,
                    'grand_total' => $grand_total,
                    'discount' => $discount,
                    'discount_cal' => $order_cal_des,
                    'supp_invocie_no' => $supp_invocie_no
                );
                $grn_header_id       = $this->purchases_model->add_grn_header_api($header_data);
//                $lastid              = $this->db->insert_id();
                if ($grn_header_id) {
                    //insert sale item data
                    $data_item = array();
                    for ($i = 0; $i < count($products); $i++) {
                        if (!isset($products[$i]['product_code']) || !isset($products[$i]['product_name']) || !isset($products[$i]['qty']) || !isset($products[$i]['unit_price']) || !isset($products[$i]['selling_price'])){
                            $msg .= "Error! undefined fields in products!\n";
                            break;
                        }
                        if (!($products[$i]['product_code']) || !($products[$i]['product_name']) || !($products[$i]['qty']) || !($products[$i]['unit_price']) || !($products[$i]['selling_price'])){
                            $msg .= "Error! empty fields in products!\n";
                            break;
                        }
                        $product_id = 0;
                        $product_info = $this->product_models->get_product_by_code($products[$i]['product_code']);
                        if(empty($product_info)){
                            $new_product_data = array(
                                'cat_id' => 1,
                                'sub_cat_id' => 1,
                                'product_name' => $products[$i]['product_name'],
                                'product_code' => $products[$i]['product_code'],
                                'product_cost' => $products[$i]['unit_price'],
                                'product_price' => $products[$i]['selling_price'],
                                /*'wholesale_price' => $wholesale_price,
                                'credit_salling_price' => $credit_salling_price,
                                'tax' => $tax,
                                'product_details' => $product_details,*/
                            );
                            $product_id = $this->product_models->save_product_api($new_product_data);
                        }else
                        $product_id = $product_info->product_id;
                        
                        $data_item = array(
                            'purchase_id' => $grn_header_id,
                            'product_id' => $product_id,
                            'product_code' => $products[$i]['product_code'],
                            'product_name' => $products[$i]['product_name'],
                            'quantity' => $products[$i]['qty'],
                            'unit_price' => $products[$i]['unit_price'],
                            'product_price' => $products[$i]['selling_price'],
                            'sub_total' => floatval($products[$i]['qty'])* floatval($products[$i]['unit_price']),
                            /*'discount' => $products[$i]['discount'],
                            'discount_cal' => $row[$i]['discount_val']*/
                        );
                        if(!$this->purchases_model->add_grn_list_item($data_item)){
                            $this->db->trans_rollback();
                            break;
                        }
                        if($product_id)
                            $num_products_inserted++;
                    }
                    /*
                    for ($i = 0; $i < count($products); $i++) {
                    if (!isset($products[$i]['product_id']))
                        continue;
                    */
                    if($num_products_inserted != count($products)){
                        $this->db->trans_rollback();
                        $msg .= "Failed. Product list error (Error code: error-409-i)\n";   
                    }else{
                        $this->db->trans_complete();
                        $status = 1;
                        $msg .= "successfully added.";   
                    }
                }else{
                    $msg .= "Failed. (Error code: error-407-i). \n";
                }
            }
        }
        echo json_encode(array(
                    "status" => $status,
                    "msg" => $msg,
                    'data' => array()
        ));
    }
    function check_supplier($supplier_name){
        $supp_id = 0;
        $supplier_data       = $this->supplier_model->get_supplier_info_by_name($supplier_name);
        if(!empty($supplier_data)){
            $supp_id = $supplier_data->supp_id;
        }else{
            $data    = array(
                'supp_company_name' => $supplier_name,
                'supp_code' => $this->common_model->gen_ref_number('supp_id', 'supplier', 'SUPP-EXT-')
            );
            $this->supplier_model->save_supplier($data, $supp_id);
            $supp_id  = $this->db->insert_id();
        }
        return $supp_id;
    }
}