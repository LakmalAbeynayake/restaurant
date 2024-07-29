<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Apitransfer extends CI_Controller
{
    var $main_menu_name = "synchronization";
    var $sub_menu_name = "production_product_synchroniza";
    public function __construct()
    {
        parent::__construct();
        $this->load->model('API_Model');
        $this->load->model('Product_Models');
        $this->load->model('common_model');
        $this->load->model('Purchases_Model');
        $this->load->model('Warehouse_Model');
        $this->load->model('Stock_Counter_Model');
        $this->load->model('Common_Model');
         ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
        
    }
    public function index()
    {
        $data['main_menu_name'] = $this->main_menu_name;
        $data['sub_menu_name']  = $this->sub_menu_name;
        $this->load->view('apitransfer/list_transfer_grn', $data);
    }
    
    public function material()
    {
        $data['main_menu_name'] = $this->main_menu_name;
        $data['sub_menu_name']  = $this->sub_menu_name;
        $this->load->view('apitransfer/material', $data);
    }
    
    
    public function grn_transfer()
    {
        $id=$this->input->get('id');
        //---------------------------------------------------------------
        //$url ="http://isurufc.newviableerp.com/api/transfer_grn?id=".$id;
        $url ="http://singhe-admin.vpos.verp.sites.lk/api/transfer_grn/".$id;//change by namal
        $ch = curl_init($url);
        $headers = array(
            "Content-Type: application/json"
            );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($ch);
        curl_close($ch);
        //header("Content-type: application/json");
        $object = json_decode($response);
        //---------------------------------------------------------------
        $product_list=$object->products;
        $stm_no=$object->ref_no;
        $total_grn_value=0;
        $operation=1;
        $err_product_code='';
        foreach($product_list as $pd){
        $product_id=$this->Product_Models->get_product_id($pd->product_code);
       if($product_id==0){$operation=0; $err_product_code.=$pd->product_code." , "; }
       $total_grn_value+=($pd->product_cost*$pd->quantity);
               
        }
        if($operation==0){
            $data_return = array(
                    "status" => 0,
                    "message" => "PRODUCT CODE NOT FOUND : ".$err_product_code,
                    "err_code" => "error-400-i"
                );
                echo json_encode($data_return); 
                return false;
        }
         $data = array(
           'reference_no' => $this->Common_Model->gen_ref_number('id','purchases','GRN') ,
           'warehouse_id' => 1,
           'supplier_id'  => 2,
           'date'         => date("Y-m-d H:i:s"),
           'note'         => '',
           'total'        => $total_grn_value,
           'grand_total'  => $total_grn_value,
           'discount'     => 0,
           'discount_cal' => 0,
    	   'supp_invocie_no'=>$stm_no
        );
      $last_id=$this->API_Model->save_grn_master($data);  
        foreach($product_list as $pd){
            $product_id=$this->Product_Models->get_product_id($pd->product_code);
            //$product_price=$this->Product_Models->get_product_price_latest($product_id);
              $data_array = array(
                'purchase_id' => $last_id,
                'product_name' => $pd->product_name,
                'product_code' => $pd->product_code,
                'product_id' => $product_id,
                'quantity' => $pd->quantity,
                'unit_price' => $pd->product_cost,
                //'retail_price' => $pd->product_retail_pirce,//($product_price)?$product_price:
                'sub_total' => $pd->product_cost*$pd->quantity,
                'batch_code' => $pd->batch_code,
            );
            $this->API_Model->save_grn_items($data_array);
        }
        

        $url ="http://singhe-admin.vpos.verp.sites.lk/api/transfer_grn_update/".$id;
        $ch = curl_init($url);
        $headers = array(
            "Content-Type: application/json"
            );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($ch);
        curl_close($ch);
        //header("Content-type: application/json");
        $response_object = json_decode($response);
        if($response_object->status==1){
           $row_id = $response_object->row_id;
            $data = array('stm_receved_status' => "1");
            //$result = $this->API_Model->update_transfer_master($row_id, $data);
            $result = 1;
            if ($result == 1) {
    
                $data_return = array(
                    "status" => 1,
                    "msg" => "SUCCSESS.",
    
                );
            } else {
    
                $data_return = array(
                    "status" => 0,
                    "msg" => "Failed. (Error code: error-403-i)",
    
                );
            }
        
        }else{
            $data_return =array(
                    "status" => 0,
                    "msg" => "Failed. (Error code: error-403-i)",
    
                );
        }
        
                echo json_encode($data_return);
    }
    
    public function m_grn_transfer()
    {
        $id=$this->input->get('id');
        //---------------------------------------------------------------
        //$url ="http://isurufc.newviableerp.com/api/transfer_grn?id=".$id;
        $url ="http://singhe-admin.vpos.verp.sites.lk/api/transfer_grn/".$id;//change by namal
        $ch = curl_init($url);
        $headers = array(
            "Content-Type: application/json"
            );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($ch);
        curl_close($ch);
        //header("Content-type: application/json");
        $object = json_decode($response);
        //---------------------------------------------------------------
        $product_list=$object->products;
        $stm_no=$object->ref_no;
        $total_grn_value=0;
        $operation=1;
        $err_product_code='';
        foreach($product_list as $pd){
        $product_id=$this->Product_Models->get_men_item_id($pd->product_code);
       if($product_id==0){$operation=0; $err_product_code.=$pd->product_code." , "; }
       $total_grn_value+=($pd->product_cost*$pd->quantity);
               
        }
        if($operation==0){
            $data_return = array(
                    "status" => 0,
                    "message" => "PRODUCT CODE NOT FOUND : ".$err_product_code,
                    "err_code" => "error-400-i"
                );
                echo json_encode($data_return); 
                return false;
        }
         $data = array(
           'reference_no' => $this->Common_Model->gen_ref_number('id','ingredian_grn','IGRN') ,
           'warehouse_id' => 1,
           'supplier_id'  => 2,
           'date'         => date("Y-m-d H:i:s"),
           'note'         => '',
           'total'        => $total_grn_value,
           'grand_total'  => $total_grn_value,
           'discount'     => 0,
           'discount_cal' => 0,
    	   'supp_invocie_no'=>$stm_no
        );
      $last_id=$this->API_Model->save_m_grn_master($data);
      
        foreach($product_list as $pd){
            $product_id=$this->Product_Models->get_men_item_id($pd->product_code);
            //$product_price=$this->Product_Models->get_product_price_latest($product_id);
              $data_array = array(
                'purchase_id' => $last_id,
                'product_name' => $pd->product_name,
                'product_code' => $pd->product_code,
                'product_id' => $product_id,
                'quantity' => $pd->quantity,
                'unit_price' => $pd->product_cost,
                //'retail_price' => $pd->product_retail_pirce,//($product_price)?$product_price:
                'sub_total' => $pd->product_cost*$pd->quantity,
                'batch_code' => $pd->batch_code,
            );
            $this->API_Model->save_m_grn_items($data_array);
        }
        

        $url ="http://singhe-admin.vpos.verp.sites.lk/api/transfer_grn_update/".$id;
        $ch = curl_init($url);
        $headers = array(
            "Content-Type: application/json"
            );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($ch);
        curl_close($ch);
        //header("Content-type: application/json");
        $response_object = json_decode($response);
        if($response_object->status==1){
           $row_id = $response_object->row_id;
            $data = array('stm_receved_status' => "1");
            //$result = $this->API_Model->update_transfer_master($row_id, $data);
            $result = 1;
            if ($result == 1) {
    
                $data_return = array(
                    "status" => 1,
                    "msg" => "SUCCSESS.",
    
                );
            } else {
    
                $data_return = array(
                    "status" => 0,
                    "msg" => "Failed. (Error code: error-403-i)",
    
                );
            }
        
        }else{
            $data_return =array(
                    "status" => 0,
                    "msg" => "Failed. (Error code: error-403-i)",
    
                );
        }
        
                echo json_encode($data_return);
    }
    
   
    
    
    public function view($id)
    {
        //$id=$this->input->get('id');
        //echo $id; die();
        $data['main_menu_name'] = $this->main_menu_name;
        $data['sub_menu_name']  = $this->sub_menu_name;
        
        $url ="http://singhe-admin.vpos.verp.sites.lk/api/transfer_grn/".$id;//change by namal
        $ch = curl_init($url);
        $headers = array(
            "Content-Type: application/json"
            );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($ch);
        curl_close($ch);
        //header("Content-type: application/json");
        $object = json_decode($response);
        //---------------------------------------------------------------
        $product_list=$object->products;
        $data['product_list'] = $product_list;
         
        //echo '<pre>',print_r($product_list); die();
        
        $this->load->view('apitransfer/transfer_details', $data);
    }
    
    
    public function m_view($id)
    {
        //$id=$this->input->get('id');
        //echo $id; die();
        $data['main_menu_name'] = $this->main_menu_name;
        $data['sub_menu_name']  = $this->sub_menu_name;
        
        $url ="http://singhe-admin.vpos.verp.sites.lk/api/transfer_grn/".$id;//change by namal
        $ch = curl_init($url);
        $headers = array(
            "Content-Type: application/json"
            );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($ch);
        curl_close($ch);
        //header("Content-type: application/json");
        $object = json_decode($response);
        //---------------------------------------------------------------
        $product_list=$object->products;
        $data['product_list'] = $product_list;
         
        //echo '<pre>',print_r($product_list); die();
        
        $this->load->view('apitransfer/metirial_transfer_details', $data);
    }
    
    

    
}