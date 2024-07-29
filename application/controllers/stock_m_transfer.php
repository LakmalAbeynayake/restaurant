<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
 header('Access-Control-Allow-Origin: *');   
class Stock_M_Transfer extends CI_Controller
{
    var $main_menu_name = "stock_transfer";
    var $sub_menu_name = "stock_transfer";
    private $main_model;
   
    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set("Asia/Colombo");
        $this->load->model('Common_Model');
        $this->load->model('Stock_M_Transfer_Model');
        $this->load->model('User_Model');
        $this->load->model('Customer_Model');
        $this->load->model('Warehouse_Model');
        $this->load->model('Product_Models');
        $this->load->model('Stock_Counter_Model');
        ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
    }
    public function index()
    {
       show_404();
    }
       
    function new_transfer(){
        
	    $data['main_menu_name'] = 'transfer';
		$data['sub_menu_name'] = 'new_transfer';
		$data['warehouse_list'] = $this->Warehouse_Model->get_all_warehouse();
		$data['outlet_list']=$this->Stock_M_Transfer_Model->get_outlet_list();
		$this->load->view('transfer_m/add_transfer_master',$data); 
	}

    public function save_trasfer_master()
    {
		$this->load->library('form_validation');	
		$this->form_validation->set_rules('warehouse_id', 'WAREHOUSE', 'required|xss_clean');
	    //$this->form_validation->set_rules('sale_rep_id', 'SALES REPRESENTATIVE', 'required|xss_clean');
	    //$this->form_validation->set_rules('customer_id', 'CUSTOMER', 'required|xss_clean');
		$this->form_validation->set_rules('ref_no', 'Ref No', 'xss_clean');
		$this->form_validation->set_rules('odr_type', 'TRANSFER TO', 'required|xss_clean');
		$this->form_validation->set_rules('note', 'Quntity', 'max_length[500]|xss_clean');
	    //$this->form_validation->set_rules('odr_price_type_id', 'PRICE TYPE', 'required|xss_clean');
		 if ($this->form_validation->run() == FALSE)
        {
           $st = array('status' =>0,'validation' => validation_errors());
           echo json_encode($st);
        }
        else
        {
        $warehouse_id=$this->input->post('warehouse_id');
		$sale_rep_id=$this->input->post('sale_rep_id');
		$customer_id=$this->input->post('customer_id');
		$odr_price_type_id=$this->input->post('odr_price_type_id');
		$ref_no=$this->input->post('ref_no');
		$note=$this->input->post('note');
		$odr_type=$this->input->post('odr_type');
        $data=array(
			'stm_warehouse_id'=>$warehouse_id,
			'stm_ref_no'=>$ref_no,
			'stm_note'=>$note,	
			'stm_to_id'=>$odr_type,
			'stm_no'=>$this->Common_Model->gen_ref_number('stm_id','stock_m_transfer_master','TMO'),
			'stm_by'=>$this->session->userdata('ss_user_id'),
			'stm_date_time'=>date("Y-m-d H:i:s"),
			
		);	
          $result = $this->Stock_M_Transfer_Model->save_trasfer_master($data);
        $status=0;
        if($result>0){
           $status=1; 
        }
        $retun_data=array(
            'result'=>$result,
            'status'=>$status,
            );
        echo json_encode($retun_data);
		}
	}
	function add_transfer_items(){
	    $data['main_menu_name'] = $this->main_menu_name;
		$data['sub_menu_name'] = $this->sub_menu_name;
		$data['stm_id'] =$this->input->get('id');
		$data['details']=$this->Stock_M_Transfer_Model->get_transfer_info($data['stm_id']);
	    $this->load->view('transfer_m/add_transfer_items',$data);
	}
	
	public function get_product_dynamic(){
        $str = $this->input->post('search_string');
		$result=$this->Stock_M_Transfer_Model->get_product_dynamic($str);
		$data=array();
		foreach($result as $r){
		    $stock=1000;//$this->Stock_Counter_Model->get_stock_balance_batch('',$r['product_id'],$r['batch_id']);
		    if($stock==0){
		        continue;
		    }
		    $nested_data=array(
		        'batch_id'=>$r['item_id'],
		        'product_id'=>$r['item_id'],
		        'product_name'=>$r['item_name'],
		        'product_code'=>$r['item_code'],
		        'batch'=>", BATCH  ".$r['item_code'].", COST RS.".$r['item_cost'].", STOCK ".$stock,
		        );
		        $data[]=$nested_data;
		}
        echo json_encode($data);
    }
    public function get_product_value_added_dynamic(){
        $str = $this->input->post('search_string');
		$result=$this->Stock_M_Transfer_Model->get_product_value_added_dynamic($str);
		$data=array();
		foreach($result as $r){
		    $stock=$this->Stock_Counter_Model->getFinalProductStockBalance('',$r['pbi_product_id'],$r['pbi_id']);
		    if($stock==0){
		        continue;
		    }
		    $nested_data=array(
		        'batch_id'=>$r['pbi_id'],
		        'product_id'=>$r['pbi_product_id'],
		        'product_name'=>$r['product_name'],
		        'product_code'=>$r['product_code'],
		        'batch'=>", BATCH  ".$r['pbi_ref_no'].", COST RS.".$r['pbi_unit_cost'].", STOCK ".$stock,
		        );
		        $data[]=$nested_data;
		}
        echo json_encode($data);
    }
    public function get_product_dynamic_admin(){
        $str = $this->input->get('search_string');
		$result=$this->Stock_M_Transfer_Model->get_product_dynamic($str);
		$data=array();
		foreach($result as $r){
		    $stock=$this->Stock_Counter_Model->getFinalProductStockBalance('',$r['pbi_product_id'],$r['pbi_id']);
		    $nested_data=array(
		        'batch_id'=>$r['pbi_id'],
		        'product_id'=>$r['pbi_product_id'],
		        'product_name'=>$r['product_name'],
		        'product_code'=>$r['product_code'],
		        'batch'=>", BATCH  ".$r['pbi_ref_no'].", COST RS.".$r['pbi_unit_cost'].", STOCK ".$stock,
		        );
		        $data[]=$nested_data;
		}
        echo json_encode($data);
    }
	public function save_transfer_item(){
		$this->load->library('form_validation');
		$this->form_validation->set_rules('product_id', 'Product', 'trim|required|xss_clean');
		$this->form_validation->set_rules('odr_id', 'Main ', 'trim|required|xss_clean');
		$this->form_validation->set_rules('req_qty', 'Quntity', 'trim|required|greater_than[0]|xss_clean');
		//$this->form_validation->set_rules('price_type', 'Price type', 'trim|required|greater_than[0]|xss_clean');
		 if ($this->form_validation->run() == FALSE)
        {
           $st = array('status' =>0,'validation' => validation_errors());
           echo json_encode($st);
        }
        else
        {
            $batch_id=$this->input->post('product_id');
	    	$odr_id=$this->input->post('odr_id');
	    	$req_qty=$this->input->post('req_qty');
	    	$price_cost=$this->Stock_M_Transfer_Model->get_product_price_cost($batch_id);
	    	$stock=1000;//$this->Stock_Counter_Model->get_stock_balance_batch('',$price_cost['product_mat_id'],$batch_id);
	    	if($stock < $req_qty){
	    	    $st = array('status' =>0,'validation' =>'OUT OF STOCK');
                echo json_encode($st); 
	    	    return false;
	    	}
            $data=array(
			'stm_id'=>$odr_id,
			'product_id'=>$price_cost['item_id'],
			'quantity'=>$req_qty,
			'product_cost'=>$price_cost['item_cost'],
			'product_retail_pirce'=> 0,
			'product_wholsale_pirce'=>0,
			'product_credit_pirce'=>0,	
			'product_code'=>$price_cost['item_code'],
			'batch_id'=>$batch_id,
		);	
         $result=$this->Stock_M_Transfer_Model->save_trasfer_item($data);	   
          $st = array('status' =>1,'validation' =>'Added');
          echo json_encode($st);
		}
	}
	public function get_trasferr_item_list() {
        $id=$this->input->get('id');
        $values = $this->Stock_M_Transfer_Model->get_trasfer_product_list($id);
        $totalData=count($values);
        $totalFiltered=$totalData;
         $data          = array();
	    foreach ($values as $row) {
	        $nestad_data=array();
	        $nestad_data[]  = $row['item_code'];
	        $nestad_data[]  = $row['item_name'];
	        $nestad_data[]  = $row['unit_code'];
	        //$nestad_data[]  = $row['uom_cost'];
	        $nestad_data[]  = $row['product_retail_pirce'];
	        $nestad_data[]  = $row['quantity'];
	        $nestad_data[]  = $row['product_cost'];
	        $remove_button=' <button type="button" class="btn btn-danger btn-xs" data-toggle="tooltip" data-placement="bottom" title="Remove This Item"  onClick="delete_item_block('.$row['sti_id'].')"><i class="fa fa-trash-o" aria-hidden="true"> Remove</i></button> ';
	        //$edit_qty_button=' <button type="button" class="btn btn-primary btn-xs" data-toggle="tooltip" data-placement="bottom" title="Edit Quantity" onClick="update_aloacted_qty('.$row['sti_id'].')" ><i class="fa fa-pencil-square-o" aria-hidden="true"> Qty</i></button> ';
	        $action='';
	        $action.=$remove_button;
	        $nestad_data[]  =$action;
	        $data[]=$nestad_data;
	    }
	     $output = array(
                'data' => $data,
                "recordsTotal" => intval($totalData),
                "recordsFiltered" => intval($totalFiltered)
            );
            echo json_encode($output);
    }
    function delete_tranfer_item(){
       	$this->load->library('form_validation');
		$this->form_validation->set_rules('id', 'ID', 'trim|required|xss_clean');
		 if ($this->form_validation->run() == FALSE)
        {
           $st = array('status' =>0,'validation' => validation_errors());
           echo json_encode($st);
        }
        else
        {
            $id=$this->input->post('id');
            $result=$this->Stock_M_Transfer_Model->delete_trasfer_item($id);	   
            $st = array('status' =>1,'validation' =>'Added');
          echo json_encode($st);
		}
    }
    
    function final_transfer(){
       	$this->load->library('form_validation');
		$this->form_validation->set_rules('id', 'ID', 'trim|required|xss_clean');
		 if ($this->form_validation->run() == FALSE)
        {
           $st = array('status' =>0,'validation' => validation_errors());
           echo json_encode($st);
        }
        else
        {
            $id=$this->input->post('id');
             $data=array(
	        'stm_status'=>1,
			'stm_final_by'=>$this->session->userdata('ss_user_id'),
			'stm_on'=>date("Y-m-d H:i:s"),
		);
		$result=$this->Stock_M_Transfer_Model->update_transfer_master($id,$data);
		$list=$this->Stock_M_Transfer_Model->get_transfer_list_items($id);
		foreach($list as $row){
		     $data=array(
              'product_id'=>$row['product_id'],
              'batch_id'=>$row['batch_id'],
              'quantity'=>($row['quantity']*(-1)),
              'warehouse_id'=>$row['stm_warehouse_id'],
              'transaction_type'=>"TRANSFER",
              'transaction_id'=>$id,
              'user_id'=>$this->session->userdata('ss_user_id')
              );
		    //$this->Stock_M_Transfer_Model->save_stock_lodge($data);
		    
		}
          $st = array('status' =>1,'validation' =>'TRANSFER COMPLETED');
          echo json_encode($st);
		}
    }
    
    function list_transfers(){
        
	    $data['main_menu_name'] = 'stock_transfer';
		$data['sub_menu_name'] = 'list_m_transfers';
	    $this->load->view('transfer_m/list_transfer',$data);
	}
	
	public function get_transfer_list($value = ''){
        $search_key     = $this->input->get('search');
        $search_key_val = $search_key['value'];
        $start          = $this->input->get('start');
        $length         = $this->input->get('length');
        $totalData      = 0;
        $values         = $this->Stock_M_Transfer_Model->get_transfer_list($start, $length, $search_key_val);
        $value_count    = $this->Stock_M_Transfer_Model->get_transfer_list('', '', '');
        if ($search_key_val) {
            $values_c  = $this->Stock_M_Transfer_Model->get_transfer_list('', '', $search_key_val);
            $totalData = 100;  
        }
        $totalData     = $value_count;
        $totalFiltered = $totalData;
     
        $data          = array();
        if (!empty($values)) {
            foreach ($values as $products) {
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
                 $row[]               = $products->stm_ref_no;
                $row[]               = $products->user_first_name." ".$products->user_last_name;
                 $row[]               = $products->stm_to_id;
                $row[]               = $status;
                $row[]               = $grnstatus;

                $actdes = '';
                
                
                $option_order_details='<li><a href="' . base_url('stock_m_transfer/transfer_details') . '?id=' . $products->stm_id . '"><i class="fa fa-file-o"></i> DETAILS</a></li>';
                $update_action='<li><a href="' . base_url('stock_m_transfer/add_transfer_items') . '?id=' . $products->stm_id . '"><i class="fa fa-pencil-square-o"></i> UPDATE</a></li>';
                
                
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
    
    function transfer_details(){
	    $data['main_menu_name'] = '';
		$data['sub_menu_name'] = '';
		$data['stm_id'] =$this->input->get('id');
		$data['details']=$this->Stock_M_Transfer_Model->get_transfer_info($data['stm_id']);
	    $this->load->view('transfer_m/transfer_details',$data);
	}
    
    	public function get_details_transfer_item_list() {
        $id=$this->input->get('id');
        $values = $this->Stock_M_Transfer_Model->get_trasfer_product_list($id);
        $totalData=count($values);
        $totalFiltered=$totalData;
         $data          = array();
	    foreach ($values as $row) {
	       
	        $nestad_data=array();
	        $nestad_data[]  = $row['item_code'];
	        $nestad_data[]  = $row['item_name'];
	        $nestad_data[]  = $row['unit_code'];
	        //$nestad_data[]  = $row['uom_cost'];
	        $nestad_data[]  = $row['product_retail_pirce'];
	        $nestad_data[]  = $row['quantity'];
	     $nestad_data[]  = $row['product_cost'];
	     
	        $nestad_data[]  ='';
	       // $remove_button=' <button type="button" class="btn btn-danger btn-xs" data-toggle="tooltip" data-placement="bottom" title="Remove This Item"  onClick="delete_item_block('.$row['sti_id'].')"><i class="fa fa-trash-o" aria-hidden="true"> Remove</i></button> ';
	        //$edit_qty_button=' <button type="button" class="btn btn-primary btn-xs" data-toggle="tooltip" data-placement="bottom" title="Edit Quantity" onClick="update_aloacted_qty('.$row['sti_id'].')" ><i class="fa fa-pencil-square-o" aria-hidden="true"> Qty</i></button> ';
	      //''  $action='';
	       //$action.=$remove_button;
	        
	      // $nestad_data[]  =$action;
	         $data[]=$nestad_data;
	    }
	     $output = array(
                'data' => $data,
                "recordsTotal" => intval($totalData),
                "recordsFiltered" => intval($totalFiltered)
            );
            echo json_encode($output);
    }
    public function get_transfer_list_with_code($value = ''){
        $code     = $this->input->get('code');
        $search_key     = $this->input->get('search');
        $search_key_val = $search_key['value'];
        $start          = $this->input->get('start');
        $length         = $this->input->get('length');
        $totalData      = 0;
        $values         = $this->Stock_M_Transfer_Model->get_transfer_list_with_code($code,$start, $length, $search_key_val);
        $value_count    = $this->Stock_M_Transfer_Model->get_transfer_list_with_code($code,'', '', '');
        if ($search_key_val) {
            $values_c  = $this->Stock_M_Transfer_Model->get_transfer_list_with_code($code,'', '', $search_key_val);
            $totalData = 100;  
        }
        $totalData     = $value_count;
        $totalFiltered = $totalData;
     
        $data          = array();
        if (!empty($values)) {
            foreach ($values as $products) {
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
                 $row[]               = $products->stm_ref_no;
                $row[]               = $products->user_first_name." ".$products->user_last_name;
                 $row[]               = $products->stm_to_id;
                $row[]               = $status;
                $row[]               = $grnstatus;

                $actdes = '';
                
                $option_order_details='<li><a  class="btn btn-default " data-toggle="tooltip" data-placement="bottom" title="GRN This Transfer"  onClick="view_transfer('.$products->stm_id.')"><i class="fa fa-check" aria-hidden="true"> GRN Details</i></a></li>';
                $option_order_details.='<li><a  class="btn btn-default " data-toggle="tooltip" data-placement="bottom" title="GRN This Transfer"  onClick="grn_this_transfer('.$products->stm_id.')"><i class="fa fa-check" aria-hidden="true"> GRN</i></a></li>';
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
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    public function update_order_product_price(){
		$this->load->library('form_validation');
		$this->form_validation->set_rules('id', 'ID', 'trim|required|xss_clean');
		$this->form_validation->set_rules('result', 'PRICE ', 'trim|required|greater_than[0]|xss_clean');
		$this->form_validation->set_rules('qty', 'QTY ', 'trim|required|greater_than[0]|xss_clean');
		 if ($this->form_validation->run() == FALSE)
        {
           $st = array('status' =>0,'validation' => validation_errors());
           echo json_encode($st);
        }
        else
        {
            $id=$this->input->post('id');
	    	$result=$this->input->post('result');
            $qty=$this->input->post('qty');
            
            $data=array(
			'uom_price'=>$result,
			'total_price'=>$result*$qty,
			'price_edit_status'=>1,
			'price_edit_by'=>$this->session->userdata('ss_user_id'),
			'price_edit_on'=>date("Y-m-d H:i:s")
		);	
         $result=$this->Order_Model->update_order_item($id,$data);	   
          $st = array('status' =>1,'validation' =>'Added');
          echo json_encode($st);
		}
	}
	
	public function update_order_product_qty(){
		$this->load->library('form_validation');
		$this->form_validation->set_rules('id', 'ID', 'trim|required|xss_clean');
		$this->form_validation->set_rules('result', 'PRICE ', 'trim|required|greater_than[0]|xss_clean');
		 if ($this->form_validation->run() == FALSE)
        {
           $st = array('status' =>0,'validation' => validation_errors());
           echo json_encode($st);
        }
        else
        {
            $id=$this->input->post('id');
	    	$result=$this->input->post('result');
	    	$price_cost=$this->Order_Model->get_order_item_price_cost($id);
            $data=array(
			'request_qty'=>$result,
			'approved_qty'=>$result,
			'total_price'=>$price_cost['uom_price']*$result,
			'total_cost'=>$price_cost['uom_cost']*$result,
		);	
         $result=$this->Order_Model->update_order_item($id,$data);	   
          $st = array('status' =>1,'validation' =>'Added');
          echo json_encode($st);
		}
	}
    
    
    
     function final_order(){
       	$this->load->library('form_validation');
		$this->form_validation->set_rules('id', 'ID', 'trim|required|xss_clean');
		 if ($this->form_validation->run() == FALSE)
        {
           $st = array('status' =>0,'validation' => validation_errors());
           echo json_encode($st);
        }
        else
        {
            $id=$this->input->post('id');
             $result=$this->Order_Model->get_order_total_values($id);
             
             if($result['total_cost']==0){
                  $st = array('status' =>0,'validation' => 'ORDER IS INVALID');
                  echo json_encode($st);
                  return false;
             }
             
             $data=array(
			'total_odr_cost'=>$result['total_cost'],
			'total_odr_price'=>$result['total_price'],
	        'odr_status'=>1,
			'added_user_id'=>$this->session->userdata('ss_user_id'),
			'added_date_time'=>date("Y-m-d H:i:s"),
		);
		
		$result=$this->Order_Model->update_order_master($id,$data);
             
          $st = array('status' =>1,'validation' =>'ORDER COMPLETED');
          echo json_encode($st);
		}
        
    }
    
     
    
     function approval_orders(){
        
	    $data['main_menu_name'] = 'management';
		$data['sub_menu_name'] = 'approval_orders';
	    $this->load->view('order/approval_list_order',$data);
	}
	
		public function get_order_approval_pending_list($value = ''){
        $search_key     = $this->input->get('search');
        $search_key_val = $search_key['value'];
        $start          = $this->input->get('start');
        $length         = $this->input->get('length');
        $totalData      = 0;
        $values         = $this->Order_Model->get_order_approval_pending_list($start, $length, $search_key_val);
        $value_count    = $this->Order_Model->get_order_approval_pending_list('', '', '');
        if ($search_key_val) {
            $values_c  = $this->Order_Model->get_order_approval_pending_list('', '', $search_key_val);
            $totalData = 100;  
        }
        $totalData     = $value_count;
        $totalFiltered = $totalData;
     
        $data          = array();
        if (!empty($values)) {
            foreach ($values as $products) {
                $row=array();
                $status='<span class=" btn btn-xs btn-primary"> DRAFT</sapn>';
                if($products->odr_status==1){
                   $status='<span class=" btn btn-xs btn-success"> COMPLETED</sapn>'; 
                }
                
                $row[]               = $products->added_date_time;
                $row[]               = $products->odr_ref_no;
                 $row[]               = $products->odr_manual_ref_no;
                $row[]               = $products->cus_code;
                $row[]               = $products->cus_name;
                $row[]               = $products->user_first_name." ".$products->user_last_name;
                $row[]               = $status;
                $row[]               = $products->mas_name;
                
                $row[]               = $products->approval_user_first_name." ".$products->approval_user_last_name;
                $row[]               = $products->approval_date_time;//$products->brm_note;
                $actdes = '';
                
                
                $option_order_details='<li><a href="' . base_url('order/management_order_details') . '?id=' . $products->odr_id . '"><i class="fa fa-file-o"></i> VIEW & APPROVAL</a></li>';
                $update_action='<li><a href="' . base_url('order/add_order_items') . '?id=' . $products->odr_id . '"><i class="fa fa-pencil-square-o"></i> UPDATE</a></li>';
                $option_order_approval='<li><a style="cursor: pointer;" onclick="approval_requste('. $products->odr_id .')"><i class="glyphicon fa fa-check"></i> APPROVAL</a></li>';
                $option_reject=' <li><a style="cursor: pointer;" onclick="reject_request('. $products->odr_id .')"><i class="glyphicon fa fa-ban"></i> REJECT</a></li>';
               $action_option=''; 
              if($products->odr_approval_status==1){
                  $action_option=$option_order_details;
                }else{
                    $action_option=$option_order_details.$update_action.$option_order_approval.$option_reject;
                }
                $actdes = $actdes . '<div class="btn-group text-left">
                            <button data-toggle="dropdown" class="btn btn-default btn-xs  dropdown-toggle" type="button">Actions <span class="caret"></span></button>
                            <ul role="menu" class="dropdown-menu pull-right">
                            '.$action_option.'</ul></div>                      ';
                
                
              
                $row[]               = $actdes;
                $data[] = $row;
            }
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
    
     function  grant_approval(){
       
        $this->load->library('form_validation');
		$this->form_validation->set_rules('id', 'ID', 'required|xss_clean');
		if ($this->form_validation->run() == FALSE)
        {
           $st = array('status' =>0,'validation' => validation_errors());
           echo json_encode($st);
        }
        else{
            $id= $this->input->post('id');
              $data=array(
                    'odr_approval_status'=>1,
                    'approval_by'=>$this->session->userdata('ss_user_id'),
                    'approval_date_time'=>date("Y-m-d H:i:s"),
                    );
                   $this->Order_Model->update_order_master($id,$data); 
                     $st = array('status' =>1,'validation' => 'Saved');
                echo json_encode($st);
        }
   }
   
   function  reject_approval(){
       
        $this->load->library('form_validation');
		$this->form_validation->set_rules('id', 'ID', 'required|xss_clean');
		if ($this->form_validation->run() == FALSE)
        {
           $st = array('status' =>0,'validation' => validation_errors());
           echo json_encode($st);
        }
        else{
            $id= $this->input->post('id');
              $data=array(
                    'odr_approval_status'=>2,
                    'approval_by'=>$this->session->userdata('ss_user_id'),
                    'approval_date_time'=>date("Y-m-d H:i:s"),
                    );
                   $this->Order_Model->update_order_master($id,$data); 
                     $st = array('status' =>1,'validation' => 'Saved');
                echo json_encode($st);
        }
   }
   
   	public function save_order_item_with_batch(){
		$this->load->library('form_validation');
		$this->form_validation->set_rules('product_id', 'Product', 'trim|required|xss_clean');
		$this->form_validation->set_rules('odr_id', 'Main ', 'trim|required|xss_clean');
		$this->form_validation->set_rules('req_qty', 'Quntity', 'trim|required|greater_than[0]|xss_clean');
		$this->form_validation->set_rules('price_type', 'Price type', 'trim|required|greater_than[0]|xss_clean');
		 if ($this->form_validation->run() == FALSE)
        {
           $st = array('status' =>0,'validation' => validation_errors());
           echo json_encode($st);
        }
        else
        {
            $batch_id=$this->input->get('id');
            $product_id=$this->input->post('product_id');
	    	$odr_id=$this->input->post('odr_id');
	    	$req_qty=$this->input->post('req_qty');
	    	$price_type=$this->input->post('price_type');
	    	$price_important=$this->input->post('price_important');
	    	$count=$this->Order_Model->check_already_added($product_id,$odr_id);
	    	if($count>0){
	    	  $st = array('status' =>0,'validation' =>'Item Already Added !');
                echo json_encode($st);
                return false;
	    	}
	    	$price_cost=$this->Order_Model->get_batch_details($batch_id);
	    	$price=0;
	    	if($price_type==1){
	    	   $price= $price_cost['product_price'];
	    	}
	    	if($price_type==2){
	    	   $price= $price_cost['credit_salling_price'];
	    	}
	    	if($price_type==3){
	    	   $price= $price_cost['wholesale_price'];
	    	}
	    	$cost= $price_cost['product_cost'];
	    	
            $data=array(
			'odr_id'=>$odr_id,
			'product_id'=>$product_id,
			'request_qty'=>$req_qty,	
			'approved_qty'=>$req_qty,
			'uom_price'=>$price,
			'uom_cost'=>$cost,
			'total_price'=>$price*$req_qty,
			'total_cost'=>$cost*$req_qty,
			'price_important'=>1,
			'batch_id'=>$batch_id,
			'is_batch_validate'=>1,
			 'original_uom_price'=>$price
		);	
         $result=$this->Order_Model->save_order_item($data);	   
          $st = array('status' =>1,'validation' =>'Added');
          echo json_encode($st);
		}
	}
	
	
	
		public function get_order_item_details_list() {
        $id=$this->input->get('id');
        $values = $this->Order_Model->get_order_product_list($id);
        $totalData=count($values);
        $totalFiltered=$totalData;
         $data          = array();
	    foreach ($values as $row) {
	        if($row['price_important']==1){
	         $update_price='<button type="button" class="btn btn-warning btn-xs" data-toggle="tooltip" data-placement="bottom" title="Edit UOM Price" onClick="update_product_price('.$row['odri_id'].','.$row['request_qty'].')" ><i class="fa fa-pencil-square-o" aria-hidden="true"> Price</i></button>';
	       }else{
	           $update_price='';
	       }
	        $nestad_data=array();
	        $nestad_data[]  = $row['product_code'];
	        $nestad_data[]  = $row['product_name'];
	        $nestad_data[]  = $row['unit_code'];
	        //$nestad_data[]  = $row['uom_cost'];
	        $nestad_data[]  = $row['uom_price'];
	        $nestad_data[]  = $row['request_qty'];
	        $nestad_data[]  =$row['total_price'];
	        
	        $action='';
	        if($row['price_edit_status']==1 ){
	            $action='<span class="btn btn-xs btn-warning">Item Price Override by user! </span><br>Original UOM Price RS.'.$row['original_uom_price'];
	        }
	      
	       $nestad_data[]  =$action;
	         $data[]=$nestad_data;
	    }
	     $output = array(
                'data' => $data,
                "recordsTotal" => intval($totalData),
                "recordsFiltered" => intval($totalFiltered)
            );
            echo json_encode($output);
    }
    
    
    	function management_order_details(){
	    $data['main_menu_name'] = '';
		$data['sub_menu_name'] = '';
		$data['odr_id'] =$this->input->get('id');
		$data['details']=$this->Order_Model->get_order_info($data['odr_id']);
	    $this->load->view('order/management_order_details',$data);
	}
	
		public function get_customer_dynamic(){
        $str = $this->input->post('search_string');
		$result=$this->Customer_Model->get_customer_for_ajex($str);
        echo json_encode($result);
    }
    public function get_user_dynamic(){
        $str = $this->input->post('search_string');
		$result=$this->User_Model->get_user_for_ajex($str,4);
        echo json_encode($result);
    }
    
    function update_grn_recode()
    {
        $id = $this->input->get('id');
        $data = array('stm_receved_status' => "1");
        $result = $this->Stock_M_Transfer_Model->update_transfer_master($id, $data);
        if ($result == 1) {

            echo json_encode(
                array(
                    "status" => 1,
                    "msg" => "SUCCSESS.",

                )
            );

        } else {

            echo json_encode(
                array(
                    "status" => 0,
                    "msg" => "Failed. (Error code: error-403-i)",

                )
            );
        }
    }

   
  
}